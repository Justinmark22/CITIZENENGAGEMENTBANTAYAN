<?php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LocationReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminEngagementController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\Admin\SantaFeUserController;
use App\Models\User;
use App\Models\Report;
use App\Models\Feedback;
use App\Http\Controllers\SantaFeController;
use App\Http\Controllers\SantaFeAnnouncementController;
use App\Http\Controllers\SantaFeEventController;
use App\Http\Controllers\SantaFeUpdateController;
use App\Http\Controllers\Admin\BantayanUserController;
use App\Http\Controllers\BantayanController;
use App\Http\Controllers\BantayanEventController;
use App\Http\Controllers\BantayanUpdateController;
use App\Http\Controllers\BantayanAnnouncementController;
use App\Http\Controllers\Admin\MadridejosUserController;
use App\Http\Controllers\MadridejosController;
use App\Http\Controllers\MadridejosAnnouncementController;
use App\Http\Controllers\MadridejosEventController;
use App\Http\Controllers\MadridejosUpdateController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\MunicipalAdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MDRRMOController;
use App\Http\Controllers\WasteDashboardController;
use App\Http\Controllers\WaterDashboardController;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewUserEmail;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// ✅ Secure dashboard route (requires user login + OTP verification)
Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// ✅ Registration Page
Route::get('/register', fn() => view('register'))->name('register');

// ✅ Registration Logic
Route::post('/register', function (Request $request) {
    // 🔒 Strict Validation
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'location' => ['required', 'in:Bantayan,Santa.Fe,Madridejos,Admin'],
        'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
    ]);

    // 👤 Create User Securely
    $user = User::create([
        'name' => e($validated['name']),
        'email' => strtolower($validated['email']),
        'location' => $validated['location'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
        'status' => 'active',
        'remember_token' => Str::random(60),
    ]);

    // 📩 Send the Bantayan 911 Welcome Email
    Mail::to($user->email)->send(new WelcomeNewUserEmail($user));

    // 🔐 Auto-login the User
    Auth::login($user);
    $request->session()->regenerate();

    // ✅ Redirect to Login Page with Success Message
    return redirect()->route('login')->with('success', 'Registration successful! Please check your email for a welcome message from Bantayan 911.');
})->name('register.submit');

// ✅ HOME ROUTE (Welcome Page with Defacement Protection)
Route::get('/', function () {
    $welcomePath = resource_path('views/welcome.blade.php');
    $hashFile = storage_path('app/security_hash.txt');

    // Create a reference hash if it doesn’t exist
    if (!File::exists($hashFile)) {
        File::put($hashFile, hash_file('sha256', $welcomePath));
    }

    $currentHash = hash_file('sha256', $welcomePath);
    $originalHash = trim(File::get($hashFile));

    // ✅ Detect tampering or defacement
    if ($currentHash !== $originalHash) {
        Log::warning('⚠️ Defacement detected on welcome.blade.php');
        abort(403, 'System integrity check failed — unauthorized modification detected.');
    }

    // ✅ Add HTTP security headers
    $response = response()->view('welcome');
    $response->headers->set('X-Frame-Options', 'DENY');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('Referrer-Policy', 'no-referrer');

    return $response;
});

// ✅ LOGIN ROUTES
Route::get('/login', fn() => view('login'))->name('login');

Route::post('/login', function (Request $request) {
    // ✅ Throttling (limit 3 attempts per IP+email)
    $key = Str::lower($request->input('email')).'|'.$request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return back()->withErrors([
            'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
        ])->onlyInput('email');
    }

    // ✅ reCAPTCHA v3 verification
    $recaptchaResponse = $request->input('g-recaptcha-response');
    $secretKey = '6LfBN94rAAAAAAo8EQqJV6hayWp52XZLGJb8vDcd'; // your secret key

    if (!$recaptchaResponse) {
        return back()->withErrors(['captcha' => 'Please complete the reCAPTCHA verification.'])
            ->onlyInput('email');
    }

    $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $request->ip(),
    ]);

    $recaptchaData = $verifyResponse->json();

    if (empty($recaptchaData['success']) || $recaptchaData['success'] !== true || $recaptchaData['score'] < 0.5) {
        return back()->withErrors(['captcha' => 'Suspicious activity detected. Please try again.'])
            ->onlyInput('email');
    }

    // ✅ Validate credentials
    $credentials = $request->validate([
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'max:255'],
    ]);

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    // ✅ Disabled user check
    if ($user && $user->status === 'disabled') {
        RateLimiter::hit($key, 60);
        return back()->withErrors([
            'email' => 'Your account has been disabled. Contact the super admin.',
        ])->onlyInput('email');
    }

    // ✅ Attempt login
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();

        // ✅ Update user status
        $user->status = 'active';
        $user->save();

        RateLimiter::clear($key); // Reset attempts on success

        // ✅ Generate OTP for extra verification
        $otp = rand(100000, 999999);
        session([
            'otp' => $otp,
            'otp_expires' => now()->addMinutes(3),
            'otp_user_id' => $user->id,
        ]);

        // TODO: You can send this OTP via email or SMS here.
        // Mail::to($user->email)->send(new SendOtpMail($otp));

        return redirect()->route('otp.verify.page')->with('status', 'OTP sent to your email.');
    }

    // ❌ Failed login
    RateLimiter::hit($key, 60);

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ])->onlyInput('email');
})->name('login.submit');

// ✅ OTP VERIFICATION ROUTES
Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('otp.verify.page');

Route::post('/verify-otp', function (Request $request) {
    $request->validate(['otp' => 'required|numeric']);

    $sessionOtp = session('otp');
    $expires = session('otp_expires');
    $userId = session('otp_user_id');

    if (!$sessionOtp || now()->greaterThan($expires)) {
        Auth::logout();
        session()->forget(['otp', 'otp_expires', 'otp_user_id']);
        return redirect()->route('login')->withErrors(['otp' => 'OTP expired. Please login again.']);
    }

    if ($request->otp != $sessionOtp) {
        return back()->withErrors(['otp' => 'Invalid OTP code.']);
    }

    // ✅ OTP verified successfully
    session(['otp_verified' => true]);
    $user = \App\Models\User::find($userId);

    if (!$user) {
        return redirect()->route('login')->withErrors(['email' => 'User not found.']);
    }

    Auth::login($user);
    session()->forget(['otp', 'otp_expires', 'otp_user_id']);

    // ✅ Redirect based on role & location
    return match (strtolower($user->role)) {
        'admin' => match ($user->location) {
            'Santa.Fe'   => redirect()->route('dashboard.santafeadmin'),
            'Bantayan'   => redirect()->route('dashboard.bantayanadmin'),
            'Madridejos' => redirect()->route('dashboard.madridejosadmin'),
            'Admin'      => redirect()->route('dashboard.admin'),
            default      => redirect('/dashboard'),
        },
        'mdrrmo' => match ($user->location) {
            'Santa.Fe'   => redirect()->route('dashboard.mdrrmo-santafe'),
            'Bantayan'   => redirect()->route('dashboard.mdrrmo-bantayan'),
            'Madridejos' => redirect()->route('dashboard.mdrrmo-madridejos'),
            default      => redirect('/dashboard'),
        },
        'waste' => match ($user->location) {
            'Santa.Fe'   => redirect()->route('dashboard.waste-santafe'),
            'Bantayan'   => redirect()->route('dashboard.waste-bantayan'),
            'Madridejos' => redirect()->route('dashboard.waste-madridejos'),
            default      => redirect('/dashboard'),
        },
        'water' => match ($user->location) {
            'Santa.Fe'   => redirect()->route('dashboard.water-santafe'),
            'Bantayan'   => redirect()->route('dashboard.water-bantayan'),
            'Madridejos' => redirect()->route('dashboard.water-madridejos'),
            default      => redirect('/dashboard'),
        },
        default => match ($user->location) {
            'Santa.Fe'   => redirect()->route('dashboard.santafe'),
            'Bantayan'   => redirect()->route('dashboard.bantayan'),
            'Madridejos' => redirect()->route('dashboard.madridejos'),
            default      => redirect('/dashboard'),
        },
    };
})->name('otp.verify.submit');
Route::post('/logout', function (Request $request) {
    $user = Auth::user();
    if ($user) {
        $user->status = 'offline';   // ✅ Mark user offline on logout
        $user->save();
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');


// Dashboard redirection logic
Route::get('/dashboard', [DashboardController::class, 'redirectBasedOnRole'])->middleware('auth')->name('dashboard');

// Individual dashboards
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth')->name('dashboard.admin');
Route::get('/dashboard/santafe', [DashboardController::class, 'dashboardSantaFe'])->middleware('auth')->name('dashboard.santafe');
// ✅ Regular user dashboard for Bantayan
Route::get('/dashboard/bantayan/user', [DashboardController::class, 'dashboardBantayan'])
    ->middleware('auth')
    ->name('dashboard.bantayan');

Route::get('/dashboard/madridejos', [DashboardController::class, 'dashboardMadridejos'])->middleware('auth')->name('dashboard.madridejos');

// Reports
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/bantayan', [LocationReportController::class, 'viewBantayan'])->name('reports.bantayan');
Route::get('/reports/santafe', [LocationReportController::class, 'viewSantaFe'])->name('reports.santafe');
Route::get('/reports/madridejos', [LocationReportController::class, 'viewMadridejos'])->name('reports.madridejos');

// Feedback
Route::get('/feedback', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.page');
Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/rate-service', [FeedbackController::class, 'showRateServiceForm'])->name('rate.service');
Route::post('/rate-service', [FeedbackController::class, 'submitRating'])->name('service.rate.submit');

// Support
Route::get('/contact-support', [SupportController::class, 'showSupportPage'])->name('contact.support.page');
Route::post('/contact-support', [SupportController::class, 'submitSupportRequest'])->name('contact.support.submit');

// Contact
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Alert
Route::post('alerts', [AlertController::class, 'store'])->name('admin.alerts.store');
Route::post('/alerts/mark-as-read', [AlertController::class, 'markAsRead'])->name('alerts.markAsRead');

// Admin Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('reports', AdminReportController::class);
    Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.updateStatus');
    Route::resource('users', UserController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::resource('engagements', AdminEngagementController::class);
    Route::get('/engagements/create', [AdminEngagementController::class, 'create'])->name('engagements.create');
    Route::post('/engagements', [AdminEngagementController::class, 'store'])->name('engagements.store');
    Route::delete('/engagements/{id}', [EngagementController::class, 'destroy'])->name('engagements.destroy');
    Route::get('/updates/create', [UpdateController::class, 'create'])->name('updates.create');
    Route::post('/updates', [UpdateController::class, 'store'])->name('updates.store');
    Route::get('/updates/all', [UpdateController::class, 'getAll'])->name('updates.all');
    Route::put('/updates/{id}', [UpdateController::class, 'update'])->name('updates.update');
    Route::delete('/updates/{id}', [UpdateController::class, 'destroy'])->name('updates.destroy');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/all', [EventController::class, 'getAll'])->name('events.all');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Location views
Route::get('/bantayan', [LocationController::class, 'viewBantayan'])->name('view.bantayan');
Route::get('/madridejos', [LocationController::class, 'viewMadridejos'])->middleware('auth')->name('view.madridejos');
Route::get('/santafe', [LocationController::class, 'viewSantafe'])->middleware('auth')->name('view.santafe');

// Engagements (public)
Route::get('/engagements', [EngagementController::class, 'index'])->name('engagements.index');
Route::get('/engagements/{id}', [EngagementController::class, 'show'])->name('engagements.show');
Route::post('/engagements/{id}/comment', [EngagementController::class, 'postComment'])->name('engagements.comment');
Route::get('/engagements/{id}/chart-data', [EngagementController::class, 'chartData']);

// Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
//
Route::put('/user/settings', [App\Http\Controllers\UserSettingsController::class, 'update'])->name('user.update.settings');
//
// routes/web.php
Route::get('/engagements', [EngagementController::class, 'index'])->name('engagements');
Route::get('/engagements', [EngagementController::class, 'index'])->name('engagements.index');
//
Route::get('/reports/chart-data', [ReportController::class, 'getChartData']);
//
Route::view('/privacy-policy', 'legal.privacy')->name('privacy.policy');
Route::view('/terms-of-service', 'legal.terms')->name('terms.service');
Route::view('/data-protection', 'legal.data')->name('data.protection');
//
Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
//
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
});Route::post('/admin/events/store', [EventController::class, 'store'])->name('admin.events.store');





use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Route::get('/dashboard/santafeadmin', function () {
    

    $totalUsers = User::where('location', 'Santa.Fe')->count();
    $totalReports = Report::where('location', 'Santa.Fe')->count();
    $pendingReports = Report::where('location', 'Santa.Fe')->where('status', 'pending')->count();
    $resolvedReports = Report::where('location', 'Santa.Fe')->where('status', 'resolved')->count();

    // ✅ Latest Feedbacks
    $feedbacks = Feedback::where('location', 'SantaFe')->latest()->take(5)->get();

    // ✅ Daily User Registrations (last 30 days)
    $dailyUserData = User::selectRaw("DATE(created_at) as date, COUNT(*) as count")
        ->where('location', 'Santa.Fe')
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    $dailyLabels = $dailyUserData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
    $dailyCounts = $dailyUserData->pluck('count')->toArray();

    // ✅ Monthly User Registrations (all time)
    $monthlyUserData = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
        ->where('location', 'Santa.Fe')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyLabels = $monthlyUserData->pluck('month')->map(fn($m) => Carbon::parse($m)->format('M Y'))->toArray();
    $monthlyCounts = $monthlyUserData->pluck('count')->toArray();

    return view('dashboard.santafeadmin', compact(
        'totalUsers',
        'totalReports',
        'pendingReports',
        'resolvedReports',
        'feedbacks',
        'dailyLabels',
        'dailyCounts',
        'monthlyLabels',
        'monthlyCounts'
    ));
})->name('dashboard.santafeadmin');
// Bantayan Admin Dashboard
Route::get('/dashboard/bantayanadmin', function () {
   
    $totalUsers = User::where('location', 'Bantayan')->count();
    $totalReports = Report::where('location', 'Bantayan')->count();
    $pendingReports = Report::where('location', 'Bantayan')->where('status', 'pending')->count();
    $resolvedReports = Report::where('location', 'Bantayan')->where('status', 'resolved')->count();

    // ✅ Latest Feedbacks
    $feedbacks = Feedback::where('location', 'Bantayan')->latest()->take(5)->get();

    // ✅ Daily User Registrations (last 30 days)
    $dailyUserData = User::selectRaw("DATE(created_at) as date, COUNT(*) as count")
        ->where('location', 'Bantayan')
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    $dailyLabels = $dailyUserData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
    $dailyCounts = $dailyUserData->pluck('count')->toArray();

    // ✅ Monthly User Registrations (all time)
    $monthlyUserData = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
        ->where('location', 'Bantayan')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyLabels = $monthlyUserData->pluck('month')->map(fn($m) => Carbon::parse($m)->format('M Y'))->toArray();
    $monthlyCounts = $monthlyUserData->pluck('count')->toArray();

    return view('dashboard.bantayanadmin', compact(
        'totalUsers',
        'totalReports',
        'pendingReports',
        'resolvedReports',
        'feedbacks',
        'dailyLabels',
        'dailyCounts',
        'monthlyLabels',
        'monthlyCounts'
    ));
})->name('dashboard.bantayanadmin');
// Madridejos Admin Dashboard
Route::get('/dashboard/madridejosadmin', function () {

    $totalUsers = User::where('location', 'Madridejos')->count();
    $totalReports = Report::where('location', 'Madridejos')->count();
    $pendingReports = Report::where('location', 'Madridejos')->where('status', 'pending')->count();
    $resolvedReports = Report::where('location', 'Madridejos')->where('status', 'resolved')->count();

    // ✅ Latest Feedbacks
    $feedbacks = Feedback::where('location', 'Madridejos')->latest()->take(5)->get();

    // ✅ Daily User Registrations (last 30 days)
    $dailyUserData = User::selectRaw("DATE(created_at) as date, COUNT(*) as count")
        ->where('location', 'Madridejos')
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    $dailyLabels = $dailyUserData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
    $dailyCounts = $dailyUserData->pluck('count')->toArray();

    // ✅ Monthly User Registrations (all time)
    $monthlyUserData = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
        ->where('location', 'Madridejos')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyLabels = $monthlyUserData->pluck('month')->map(fn($m) => Carbon::parse($m)->format('M Y'))->toArray();
    $monthlyCounts = $monthlyUserData->pluck('count')->toArray();

    return view('dashboard.madridejosadmin', compact(
        'totalUsers',
        'totalReports',
        'pendingReports',
        'resolvedReports',
        'feedbacks',
        'dailyLabels',
        'dailyCounts',
        'monthlyLabels',
        'monthlyCounts'
    ));
})->name('dashboard.madridejosadmin');
// Santa Fe User Management Routes
Route::prefix('admin/santafe')->name('santafe.')->group(function () {
    Route::get('/users', [SantaFeUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [SantaFeUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [SantaFeUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [SantaFeUserController::class, 'destroy'])->name('users.destroy');
});

// Reports Chart API
Route::get('/reports/chart-data', [ReportController::class, 'chartData']);
Route::get('/reports/chart-data', function () {
    $statuses = ['Pending', 'Delayed', 'Resolved'];

    $reportData = DB::table('reports')
        ->select('status', DB::raw('count(*) as total'))
        ->whereIn('status', $statuses)
        ->groupBy('status')
        ->get();

    // Ensure all statuses are present even if count = 0
    $counts = [];
    foreach ($statuses as $status) {
        $match = $reportData->firstWhere('status', $status);
        $counts[] = $match ? $match->total : 0;
    }

    return response()->json([
        'labels' => $statuses,
        'counts' => $counts
    ]);
});
Route::get('/admin/santafe/reports', function () {
    $reports = Report::where('location', 'Santa.Fe')
                     ->where('status', 'Pending')
                     ->latest()
                     ->get();

    return view('santa_fe.reports', compact('reports'));
})->name('santafe.reports');
//
Route::put('/admin/santafe/reports/{id}', function (Request $request, $id) {
    $report = Report::findOrFail($id);
    $report->status = $request->status;
    $report->save();

    return redirect()->route('santafe.reports')->with('success', 'Report status updated.');
})->name('santafe.reports.update');
//
Route::get('/santafe/feedback', [SantaFeController::class, 'feedback'])->name('santafe.feedback');
Route::get('/santafe/announcements', [SantaFeController::class, 'announcements'])->name('santafe.announcements');
Route::get('/santafe/announcements/create', [SantaFeController::class, 'createAnnouncement'])->name('santafe.announcements.create');
Route::post('/santafe/announcements', [SantaFeController::class, 'storeAnnouncement'])->name('santafe.announcements.store');
Route::post('/santafe/announcements/{id}/forward', [SantaFeController::class, 'forwardAnnouncement'])->name('santafe.announcements.forward');
Route::post('/santafe/announcements/{id}/forward', [SantaFeAnnouncementController::class, 'forward'])->name('santafe.announcements.forward');
//
Route::get('/santafe/events', [SantaFeEventController::class, 'index'])->name('santafe.events');
//
Route::prefix('santafe')->middleware(['auth'])->group(function () {
    Route::get('/events', [SantaFeEventController::class, 'index'])->name('santa_fe.events');

    // Move these inside the group:
    Route::get('/events/{id}/edit', [SantaFeEventController::class, 'edit'])->name('santafe.events_edit');
    Route::put('/events/{id}', [SantaFeEventController::class, 'update'])->name('santafe.events_update');
    Route::delete('/events/{id}', [SantaFeEventController::class, 'destroy'])->name('santafe.events.destroy');

    Route::post('/events/forward/{id}', [SantaFeEventController::class, 'forward'])->name('santafe.events.forward');
});

//
$usersSantaFe = User::where('location', 'Santa Fe')->count();
//
Route::prefix('santa_fe')->name('santafe.')->middleware('auth')->group(function () {
    Route::get('/updates', [SantaFeUpdateController::class, 'index'])->name('updates');
    Route::get('/updates/create', [SantaFeUpdateController::class, 'create'])->name('updates.create');
    Route::post('/updates', [SantaFeUpdateController::class, 'store'])->name('updates.store');
    Route::get('/updates/{id}', [SantaFeUpdateController::class, 'show'])->name('updates.show');
});
Route::get('/santafe/reports', [SantaFeController::class, 'reports'])->name('santafe.reports');
// web.php
Route::get('/santafe/reports/{report}/export', [SantaFeController::class, 'export'])->name('santafe.export');

// routes/web.php

Route::get('/santafe/announcements/{id}/edit', [SantaFeAnnouncementController::class, 'edit'])->name('santafe.announcements.edit');
Route::delete('/santafe/announcements/{id}', [SantaFeAnnouncementController::class, 'destroy'])
    ->name('santafe.announcements.destroy');
    Route::put('/santafe/announcements/{id}', [SantaFeAnnouncementController::class, 'update'])
    ->name('santafe.announcements.update');
//
Route::prefix('santafe/updates')->name('santafe.updates.')->group(function () {
    Route::get('/', [SantaFeUpdateController::class, 'index'])->name('index');
    Route::get('/create', [SantaFeUpdateController::class, 'create'])->name('create');
    Route::post('/', [SantaFeUpdateController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SantaFeUpdateController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SantaFeUpdateController::class, 'update'])->name('update');
    Route::delete('/{id}', [SantaFeUpdateController::class, 'destroy'])->name('destroy');
});
// Bantayan User Management Routes
Route::prefix('admin/bantayan')->name('bantayan.')->group(function () {
    Route::get('/users', [BantayanUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [BantayanUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [BantayanUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [BantayanUserController::class, 'destroy'])->name('users.destroy');
});

// Reports Chart API
Route::get('/reports/chart-data', [ReportController::class, 'chartData']);
Route::get('/reports/chart-data', function () {
    $statuses = ['Pending', 'Delayed', 'Resolved'];

    $reportData = DB::table('reports')
        ->select('status', DB::raw('count(*) as total'))
        ->whereIn('status', $statuses)
        ->groupBy('status')
        ->get();

    $counts = [];
    foreach ($statuses as $status) {
        $match = $reportData->firstWhere('status', $status);
        $counts[] = $match ? $match->total : 0;
    }

    return response()->json([
        'labels' => $statuses,
        'counts' => $counts
    ]);
});

Route::get('/admin/bantayan/reports', function () {
    $reports = Report::where('location', 'Bantayan')
                     ->where('status', 'Pending')
                     ->latest()
                     ->get();

    return view('bantayan.reports', compact('reports'));
})->name('bantayan.reports');

Route::put('/admin/bantayan/reports/{id}', function (Request $request, $id) {
    $report = Report::findOrFail($id);
    $report->status = $request->status;
    $report->save();

    return redirect()->route('bantayan.reports')->with('success', 'Report status updated.');
})->name('bantayan.reports.update');

Route::get('/bantayan/feedback', [BantayanController::class, 'feedback'])->name('bantayan.feedback');
Route::get('/bantayan/announcements', [BantayanController::class, 'announcements'])->name('bantayan.announcements');
Route::get('/bantayan/announcements/create', [BantayanController::class, 'createAnnouncement'])->name('bantayan.announcements.create');
Route::post('/bantayan/announcements', [BantayanController::class, 'storeAnnouncement'])->name('bantayan.announcements.store');
Route::post('/bantayan/announcements/{id}/forward', [BantayanAnnouncementController::class, 'forward'])->name('bantayan.announcements.forward');

Route::get('/bantayan/events', [BantayanEventController::class, 'index'])->name('bantayan.events');

Route::prefix('bantayan')->middleware(['auth'])->group(function () {
    Route::get('/events', [BantayanEventController::class, 'index'])->name('bantayan.events');
    Route::post('/events/forward/{id}', [BantayanEventController::class, 'forward'])->name('bantayan.events.forward');
});
Route::post('/bantayan/events/forward/{id}', [BantayanEventController::class, 'forward'])->name('bantayan.events.forward');
Route::get('/events/{id}/edit', [BantayanEventController::class, 'edit'])->name('bantayan.events_edit');
Route::put('/events/{id}', [BantayanEventController::class, 'update'])->name('bantayan.events_update');
Route::delete('/events/{id}', [BantayanEventController::class, 'destroy'])->name('bantayan.events.destroy');

// Bantayan Updates
Route::prefix('bantayan/updates')->name('bantayan.updates.')->group(function () {
    Route::get('/', [BantayanUpdateController::class, 'index'])->name('index');
    Route::get('/create', [BantayanUpdateController::class, 'create'])->name('create');
    Route::post('/', [BantayanUpdateController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BantayanUpdateController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BantayanUpdateController::class, 'update'])->name('update');
    Route::delete('/{id}', [BantayanUpdateController::class, 'destroy'])->name('destroy');
});

Route::get('/bantayan/reports', [BantayanController::class, 'reports'])->name('bantayan.reports');
Route::get('/bantayan/reports/{report}/export', [BantayanController::class, 'export'])->name('bantayan.export');

Route::get('/bantayan/announcements/{id}/edit', [BantayanAnnouncementController::class, 'edit'])->name('bantayan.announcements.edit');
Route::delete('/bantayan/announcements/{id}', [BantayanAnnouncementController::class, 'destroy'])->name('bantayan.announcements.destroy');
Route::put('/bantayan/announcements/{id}', [BantayanAnnouncementController::class, 'update'])->name('bantayan.announcements.update');
//madridejos

Route::prefix('admin/madridejos')->name('madridejos.')->group(function () {
    Route::get('/users', [MadridejosUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [MadridejosUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [MadridejosUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [MadridejosUserController::class, 'destroy'])->name('users.destroy');
});

// Reports Chart API
Route::get('/reports/chart-data', [ReportController::class, 'chartData']);
Route::get('/reports/chart-data', function () {
    $statuses = ['Pending', 'Delayed', 'Resolved'];

    $reportData = DB::table('reports')
        ->select('status', DB::raw('count(*) as total'))
        ->whereIn('status', $statuses)
        ->groupBy('status')
        ->get();

    $counts = [];
    foreach ($statuses as $status) {
        $match = $reportData->firstWhere('status', $status);
        $counts[] = $match ? $match->total : 0;
    }

    return response()->json([
        'labels' => $statuses,
        'counts' => $counts
    ]);
});

Route::get('/admin/madridejos/reports', function () {
    $reports = Report::where('location', 'Madridejos')
                     ->where('status', 'Pending')
                     ->latest()
                     ->get();

    return view('madridejos.reports', compact('reports'));
})->name('madridejos.reports');

Route::put('/admin/madridejos/reports/{id}', function (Request $request, $id) {
    $report = Report::findOrFail($id);
    $report->status = $request->status;
    $report->save();

    return redirect()->route('madridejos.reports')->with('success', 'Report status updated.');
})->name('madridejos.reports.update');

Route::get('/madridejos/feedback', [MadridejosController::class, 'feedback'])->name('madridejos.feedback');
Route::get('/madridejos/announcements', [MadridejosController::class, 'announcements'])->name('madridejos.announcements');
Route::get('/madridejos/announcements/create', [MadridejosController::class, 'createAnnouncement'])->name('madridejos.announcements.create');
Route::post('/madridejos/announcements', [MadridejosController::class, 'storeAnnouncement'])->name('madridejos.announcements.store');
Route::post('/madridejos/announcements/{id}/forward', [MadridejosAnnouncementController::class, 'forward'])->name('madridejos.announcements.forward');

Route::get('/madridejos/events', [MadridejosEventController::class, 'index'])->name('madridejos.events');

Route::prefix('madridejos')->middleware(['auth'])->group(function () {
    Route::get('/events', [MadridejosEventController::class, 'index'])->name('madridejos.events');
    Route::post('/events/forward/{id}', [MadridejosEventController::class, 'forward'])->name('madridejos.events.forward');
});
Route::post('/madridejos/events/forward/{id}', [MadridejosEventController::class, 'forward'])->name('madridejos.events.forward');
Route::get('/madridejos/events/{id}/edit', [MadridejosEventController::class, 'edit'])->name('madridejos.events_edit');
Route::put('/madridejos/events/{id}', [MadridejosEventController::class, 'update'])->name('madridejos.events_update');
Route::delete('/madridejos/events/{id}', [MadridejosEventController::class, 'destroy'])->name('madridejos.events.destroy');

// madridejos Updates
Route::prefix('madridejos/updates')->name('madridejos.updates.')->group(function () {
    Route::get('/', [MadridejosUpdateController::class, 'index'])->name('index');
    Route::get('/create', [MadridejosUpdateController::class, 'create'])->name('create');
    Route::post('/', [MadridejosUpdateController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MadridejosUpdateController::class, 'edit'])->name('edit');
    Route::put('/{id}', [MadridejosUpdateController::class, 'update'])->name('update');
    Route::delete('/{id}', [MadridejosUpdateController::class, 'destroy'])->name('destroy');
});

Route::get('/madridejos/reports', [MadridejosController::class, 'reports'])->name('madridejos.reports');
Route::get('/madridejos/reports/{report}/export', [MadridejosController::class, 'export'])->name('madridejos.export');

Route::get('/madridejos/announcements/{id}/edit', [MadridejosAnnouncementController::class, 'edit'])->name('madridejos.announcements.edit');
Route::delete('/madridejos/announcements/{id}', [MadridejosAnnouncementController::class, 'destroy'])->name('madridejos.announcements.destroy');
Route::put('/madridejos/announcements/{id}', [MadridejosAnnouncementController::class, 'update'])->name('madridejos.announcements.update');
// admin analytics
Route::get('/admin/analytics', [AnalyticsController::class, 'index'])
    ->name('admin.analytics');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');

    
    // routes/web.php or routes/api.php
Route::get('/admin/feedbacks/latest', [AnalyticsController::class, 'getFeedbacks'])->name('admin.feedbacks.latest');
//municipal admins
Route::prefix('admin/municipal-admins')->group(function () {
    Route::get('/', [MunicipalAdminController::class, 'index'])->name('admin.municipal.index');
    Route::get('/disable/{id}', [MunicipalAdminController::class, 'disable'])->name('admin.municipal.disable');
    Route::get('/enable/{id}', [MunicipalAdminController::class, 'enable'])->name('admin.municipal.enable');
});Route::post('/admin/municipal-admins/update/{id}', [MunicipalAdminController::class, 'update'])->name('municipal-admins.update');
//certificates
Route::get('/certificate/request', [CertificateController::class, 'showRequestForm'])->name('certificate.request');
Route::post('/certificate/request', [CertificateController::class, 'store'])->name('certificate.submit');
//
Route::post('/reports/forward', [SantaFeController::class, 'forward'])->name('reports.forward');
//
Route::get('/mdrrmo/santafe', [MDRRMOController::class, 'santafe'])->name('dashboard.mdrrmo-santafe');
Route::get('/mdrrmo/bantayan', [MDRRMOController::class, 'bantayan'])->name('dashboard.mdrrmo-bantayan');
Route::get('/mdrrmo/madridejos', [MDRRMOController::class, 'madridejos'])->name('dashboard.mdrrmo-madridejos');
Route::get('/mdrrmo/reports/santafe', [MDRRMOController::class, 'reportsSantaFe'])->name('mdrrmo.reports-santafe');
Route::get('/mdrrmo/reports/bantayan', [MDRRMOController::class, 'reportsBantayan'])->name('mdrrmo.reports-bantayan');
Route::get('/mdrrmo/reports/madridejos', [MDRRMOController::class, 'reportsMadridejos'])->name('mdrrmo.reports-madridejos');
Route::post('/rerouted-reports/{report}/update-status', [MDRRMOController::class, 'updateStatus']);
Route::post('/forwarded-reports/{report}/update-status', [MDRRMOController::class, 'updateStatus']);

Route::get('/dashboard/mdrrmo-santafe', [MDRRMOController::class, 'santafe'])->name('mdrrmo.santafe');
Route::get('/mdrrmo/stats', [MDRRMOController::class, 'stats'])->name('mdrrmo.stats');
//
Route::get('/mdrrmo/santafe-announcements', [MDRRMOController::class, 'santafeAnnouncements'])
    ->name('mdrrmo.mdrrmo_santafe-announcements');
    Route::get('/resolved-reports', [MDRRMOController::class, 'getResolvedReports']);
  Route::post('/post-announcement', [MDRRMOController::class, 'postAnnouncement']);
//
// ---------------- MADRIDEJOS ----------------
Route::get('/mdrrmo/madridejos-announcements', [MDRRMOController::class, 'madridejosAnnouncements'])
    ->name('mdrrmo.mdrrmo_madridejos-announcements');

Route::get('/resolved-reports/madridejos', function () {
    return app(\App\Http\Controllers\MDRRMOController::class)->getResolvedReports('Madridejos');
})->name('mdrrmo.madridejos-resolved');

Route::post('/post-announcement/madridejos', [MDRRMOController::class, 'postAnnouncement'])
    ->name('mdrrmo.madridejos-post-announcement');
    // ---------------- MADRIDEJOS REPORTS / UPDATES ----------------
Route::get('/mdrrmo/madridejos-updates', [MDRRMOController::class, 'reportsMadridejos'])
    ->name('madridejos.updates');
    //
    Route::get('/api/resolved-reports/madridejos', [MDRRMOController::class, 'getResolvedReportsMadridejos']);
//// ---------------- BANTAYAN ----------------

// Announcements page
Route::get('/mdrrmo/bantayan-announcements', [MDRRMOController::class, 'bantayanAnnouncements'])
    ->name('mdrrmo.mdrrmo_bantayan-announcements');

Route::get('/api/resolved-reports/bantayan', [MDRRMOController::class, 'getResolvedReportsBantayan'])
    ->name('mdrrmo.bantayan-resolved');


// Post announcement
Route::post('/post-announcement/bantayan', [MDRRMOController::class, 'postAnnouncement'])
    ->name('mdrrmo.bantayan-post-announcement');

// Bantayan updates page
Route::get('/mdrrmo/bantayan-updates', [MDRRMOController::class, 'reportsBantayan'])
    ->name('bantayan.updates');


Route::middleware(['auth'])->group(function () {
    // 🔹 Waste Dashboards
    Route::get('/dashboard/waste-santafe', [WasteDashboardController::class, 'santafe'])
        ->name('dashboard.waste-santafe');
    Route::get('/dashboard/waste-bantayan', [WasteDashboardController::class, 'bantayan'])
        ->name('dashboard.waste-bantayan');
    Route::get('/dashboard/waste-madridejos', [WasteDashboardController::class, 'madridejos'])
        ->name('dashboard.waste-madridejos');

    // 🔹 Waste Reports
    Route::get('/reports/waste/santafe', [WasteDashboardController::class, 'reportsSantafe'])
        ->name('waste.reports-santafe');
    Route::get('/reports/waste/bantayan', [WasteDashboardController::class, 'reportsBantayan'])
        ->name('waste.reports-bantayan');
    Route::get('/reports/waste/madridejos', [WasteDashboardController::class, 'reportsMadridejos'])
        ->name('waste.reports-madridejos');

    // 🔹 Update Report Status (Accept, Ongoing, Resolved, Reroute)
    // ✅ For your JS (short URL)
    Route::post('/reports/{id}/update-status', [WasteDashboardController::class, 'updateStatus'])
        ->name('reports.update-status');

    // ✅ Alternative Laravel-style path
    Route::post('/waste/reports/{id}/update-status', [WasteDashboardController::class, 'updateStatus'])
        ->name('waste.reports.update-status');
});


// water manangement

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/water-santafe', [WaterDashboardController::class, 'santafe'])->name('dashboard.water-santafe');
    Route::get('/dashboard/water-bantayan', [WaterDashboardController::class, 'bantayan'])->name('dashboard.water-bantayan');
    Route::get('/dashboard/water-madridejos', [WaterDashboardController::class, 'madridejos'])->name('dashboard.water-madridejos');
});
