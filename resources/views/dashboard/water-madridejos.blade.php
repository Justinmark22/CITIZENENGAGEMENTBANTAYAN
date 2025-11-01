<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madridejos Water Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

<body class="bg-gray-100 font-sans flex min-h-screen" x-data="reportApp()" x-init="fetchReports()">

  <!-- Sidebar -->
  <aside class="fixed md:static inset-y-0 left-0 z-40 w-64 
         bg-gradient-to-b from-blue-200 to-blue-100 
         text-gray-800 p-6 transform transition-transform duration-300 
         ease-in-out shadow-lg"
         :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="flex items-center justify-between mb-10">
      <img src="{{ asset('/images/SAN.PNG') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
      <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">Water Madridejos</span>
      <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
    </div>

    <nav class="flex flex-col gap-4">
      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
        <a href="{{ route('dashboard.water-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
          <i data-lucide="home" class="w-5 h-5"></i>
          <span class="font-medium">Overview</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
        <a href="{{ route('water.reports-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          <span>All Reports</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
        <a href="{{ route('water.announcement-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="megaphone" class="w-5 h-5"></i>
          <span>Announcements</span>
        </a>
      </div>

      <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
        @csrf
        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-400 hover:bg-red-500 font-semibold shadow transition-all">
          Logout
        </button>
      </form>
    </nav>
  </aside>


    <!-- Main Content -->
    <main class="flex-1 bg-gradient-to-br from-gray-50 to-gray-100 p-10 overflow-y-auto">
        <!-- Header -->
        <header class="sticky top-0 z-10 mb-8 backdrop-blur-lg bg-white/80 border border-gray-200 shadow-md rounded-2xl px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Madridejos Water Dashboard</h1>
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
