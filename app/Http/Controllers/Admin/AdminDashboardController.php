<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{public function index()
{
    $totalUsers = User::count();
    $totalReports = Report::count();
    $totalFeedbacks = Feedback::count();
    $resolvedReports = Report::where('status', 'Resolved')->count();
    $pendingReportsCount = Report::where('status', 'Pending')->count();
    

    // Group users by location
    $santaFeUsers = User::where('location', 'Santa.Fe')->count();
    $bantayanUsers = User::where('location', 'Bantayan')->count();
    $madridejosUsers = User::where('location', 'Madridejos')->count();

    // ✅ Group reports by day
    $reportsByDay = Report::select(
        DB::raw('DATE(created_at) as day'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('day')
    ->orderBy('day', 'desc')
    ->limit(7) // Last 7 days
    ->get();

    $reportDays = $reportsByDay->pluck('day')->toArray();
    $reportCounts = $reportsByDay->pluck('total')->toArray();

    return view('dashboard.admin', compact(
        'totalUsers',
        'totalReports',
        'totalFeedbacks',
        'resolvedReports',
        'pendingReportsCount',
        'santaFeUsers',
        'bantayanUsers',
        'madridejosUsers',
        'reportDays',
        'reportCounts'
    ));
}public function downloadDatabase()
{
    $database = env('DB_DATABASE');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $host = env('DB_HOST', '127.0.0.1');

    try {
        $pdo = new \PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

        return response()->streamDownload(function() use ($pdo, $tables) {
            foreach ($tables as $table) {
                // Drop table
                echo "DROP TABLE IF EXISTS `$table`;\n";

                // Create table
                $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(\PDO::FETCH_ASSOC);
                echo $create['Create Table'] . ";\n\n";

                // Insert data in chunks to avoid memory issues
                $stmt = $pdo->query("SELECT * FROM `$table`");
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $columns = implode('`,`', array_keys($row));
                    $values = implode(',', array_map([$pdo, 'quote'], array_values($row)));
                    echo "INSERT INTO `$table` (`$columns`) VALUES ($values);\n";
                }
                echo "\n\n";
            }
        }, 'system.sql', [
            'Content-Type' => 'application/sql',
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Database export failed: ' . $e->getMessage());
    }
}


}
