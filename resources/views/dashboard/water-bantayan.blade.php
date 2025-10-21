<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantayan Water Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-50 font-sans antialiased">

<div class="flex min-h-screen">

<aside class="w-64 bg-gradient-to-b from-sky-500/70 to-sky-700/70 text-white flex flex-col shadow-lg backdrop-blur-md border-r border-white/10">
    <!-- Logo -->
    <div class="flex items-center space-x-3 px-6 py-5 border-b border-white/20">
        <img src="{{ asset('images/water-logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full shadow-md">
        <div>
            <h2 class="text-xl font-bold text-white">WaterMgmt</h2>
            <p class="text-blue-100 text-sm">Bantayan</p>
        </div>
    </div>

    <!-- Navigation Sections -->
    <nav class="mt-6 flex-1 px-3 space-y-6">
        <!-- Section 1: Overview -->
        <div>
            <h3 class="text-xs uppercase tracking-wider text-white/70 font-semibold px-3 mb-2">Overview</h3>
            <a href="#" class="flex items-center px-4 py-3 text-sky-50 hover:bg-sky-400/30 hover:text-white rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
                Dashboard
            </a>
        </div>

        <!-- Section 2: Reports -->
        <div>
            <h3 class="text-xs uppercase tracking-wider text-white/70 font-semibold px-3 mb-2">Reports</h3>
            <a href="{{ route('water.reports-bantayan') }}" class="flex items-center px-4 py-3 text-sky-50 hover:bg-sky-400/30 hover:text-white rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                </svg>
                Reports
            </a>
        </div>

        <!-- Section 3: Analytics -->
        <div>
            <h3 class="text-xs uppercase tracking-wider text-white/70 font-semibold px-3 mb-2">Analytics</h3>
            <a href="#" class="flex items-center px-4 py-3 text-sky-50 hover:bg-sky-400/30 hover:text-white rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                Analytics
            </a>
        </div>

        <!-- Section 4: Settings -->
        <div>
            <h3 class="text-xs uppercase tracking-wider text-white/70 font-semibold px-3 mb-2">Settings</h3>
            <a href="#" class="flex items-center px-4 py-3 text-sky-50 hover:bg-sky-400/30 hover:text-white rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                </svg>
                Configuration
            </a>
        </div>
    </nav>

    <!-- Logout Button -->
    <div class="px-6 py-4 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-sky-600/60 hover:bg-sky-500/80 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

   
</aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-8">
        <div class="flex justify-between items-center mb-10 border-b pb-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Bantayan Water Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome, Water Administrator</p>
            </div>
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin" class="w-10 h-10 rounded-full border border-gray-300">
                <span class="text-gray-700 font-medium">Admin</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-xl transition">
                <h2 class="text-gray-400 text-sm font-semibold">Total Reports</h2>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-3xl font-bold text-gray-900">{{ $totalReports }}</p>
                    <div class="text-blue-600 bg-blue-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-xl transition">
                <h2 class="text-gray-400 text-sm font-semibold">Pending Reports</h2>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingReportsCount }}</p>
                    <div class="text-yellow-600 bg-yellow-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-xl transition">
                <h2 class="text-gray-400 text-sm font-semibold">Resolved Reports</h2>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-3xl font-bold text-gray-900">{{ $resolvedReportsCount }}</p>
                    <div class="text-green-600 bg-green-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Recent Water Reports</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Report ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-700 font-medium">#{{ $report->id }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $report->category }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $report->description }}</td>
                                <td class="px-6 py-4">
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
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $color }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $report->created_at->format('M d, Y') }}</td>
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
