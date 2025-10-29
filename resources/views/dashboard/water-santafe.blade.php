<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santafe Water Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-sky-600/90 to-sky-800/90 text-white flex flex-col shadow-xl backdrop-blur-md border-r border-white/10">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3 px-6 py-5 border-b border-white/20">
            <img src="{{ asset('images/water-logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full shadow-md ring-2 ring-white/20">
            <div>
                <h2 class="text-xl font-bold">WaterMgmt</h2>
                <p class="text-blue-100 text-sm tracking-wide">Santafe</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 flex-1 px-3 space-y-8">
            <div>
                <h3 class="text-xs uppercase tracking-widest text-white/60 font-semibold px-3 mb-3">Overview</h3>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-sky-50 hover:bg-white/10 hover:shadow-sm transition">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <div>
                <h3 class="text-xs uppercase tracking-widest text-white/60 font-semibold px-3 mb-3">Reports</h3>
                <a href="{{ route('water.reports-santafe') }}" class="flex items-center px-4 py-3 rounded-lg text-sky-50 hover:bg-white/10 hover:shadow-sm transition">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                    </svg>
                    Reports
                </a>
            </div>

            <div>
                <h3 class="text-xs uppercase tracking-widest text-white/60 font-semibold px-3 mb-3">Settings</h3>
                <a href="{{ route('water.announcement-santafe') }}" class="flex items-center px-4 py-3 rounded-lg text-sky-50 hover:bg-white/10 hover:shadow-sm transition">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                    </svg>
                    Configuration
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div class="px-6 py-5 border-t border-white/20 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-white/15 hover:bg-white/25 text-white font-semibold rounded-lg shadow-inner transition">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gradient-to-br from-gray-50 to-gray-100 p-10 overflow-y-auto">
        <!-- Header -->
        <header class="sticky top-0 z-10 mb-8 backdrop-blur-lg bg-white/80 border border-gray-200 shadow-md rounded-2xl px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Santafe Water Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome, Water Administrator</p>
            </div>
        </header>

        <!-- Stats Section -->
        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
            @php
                $cards = [
                    ['title' => 'Total Reports', 'count' => $totalReports, 'color' => 'blue'],
                    ['title' => 'Pending Reports', 'count' => $pendingReportsCount, 'color' => 'yellow'],
                    ['title' => 'Resolved Reports', 'count' => $resolvedReportsCount, 'color' => 'green']
                ];
            @endphp

            @foreach ($cards as $card)
            <div class="bg-white shadow-lg rounded-2xl p-6 border-t-4 border-{{ $card['color'] }}-500 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
                <h2 class="text-gray-500 text-sm font-semibold">{{ $card['title'] }}</h2>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-4xl font-extrabold text-gray-900">{{ $card['count'] }}</p>
                    <div class="bg-{{ $card['color'] }}-100 text-{{ $card['color'] }}-600 p-3 rounded-lg shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </section>

        <!-- Reports Table -->
        <section class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="h-6 w-6 mr-2 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                </svg>
                Recent Water Reports
            </h2>

            <div class="overflow-x-auto rounded-lg border border-gray-100 shadow-inner">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-sky-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-sky-700 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left font-semibold text-sky-700 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left font-semibold text-sky-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left font-semibold text-sky-700 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-sky-50 transition">
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
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $color }}">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $report->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

</body>
</html>
