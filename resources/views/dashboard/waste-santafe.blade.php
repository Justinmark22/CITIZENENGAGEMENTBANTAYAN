<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Santa Fe Waste Management Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-semibold text-gray-800">Waste Management</h2>
            <p class="text-gray-500 mt-1">Santa Fe</p>
        </div>
        <nav class="mt-6 flex-1">
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded transition">Dashboard</a>
            <a href="{{ route('waste.reports-santafe') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded transition">Reports</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded transition">Analytics</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded transition">Settings</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Santa Fe Waste Management Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome, Waste Admin</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border-l-4 border-blue-400 shadow-sm rounded-lg p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-gray-500 text-sm font-medium">Total Reports</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalReports }}</p>
                    </div>
                    <div class="text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-yellow-400 shadow-sm rounded-lg p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-gray-500 text-sm font-medium">Pending Reports</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $pendingReportsCount }}</p>
                    </div>
                    <div class="text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-green-400 shadow-sm rounded-lg p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-gray-500 text-sm font-medium">Resolved Reports</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $resolvedReportsCount }}</p>
                    </div>
                    <div class="text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Waste Reports Table -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Waste Reports</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">#{{ $report->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $report->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $report->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Accepted' => 'bg-blue-100 text-blue-800',
                                        'Ongoing' => 'bg-orange-100 text-orange-800',
                                        'Resolved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $report->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

</body>
</html>
