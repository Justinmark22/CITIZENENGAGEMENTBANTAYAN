<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bantayan Water Management Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg flex flex-col">
      <div class="p-6 border-b border-gray-200">
          <h2 class="text-2xl font-bold text-gray-900">WaterMgmt</h2>
          <p class="text-gray-400 text-sm mt-1">Bantayan</p>
      </div>
      <nav class="mt-6 flex-1 space-y-2">
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
              </svg>
              Dashboard
          </a>
          <a href="{{ route('water.reports-bantayan') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
              </svg>
              Reports
          </a>
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a4 4 0 100-8 4 4 0 000 8z"/>
              </svg>
              Analytics
          </a>
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
              </svg>
              Settings
          </a>
      </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8">
      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
          <div>
              <h1 class="text-4xl font-extrabold text-gray-900">Bantayan Water Dashboard</h1>
              <p class="text-gray-500 mt-1">Welcome, Water Admin</p>
          </div>
          <div class="flex space-x-3">
              <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Add Report</button>
              <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition">Settings</button>
          </div>
      </div>

      <!-- Dashboard Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white shadow-xl rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
              <h2 class="text-gray-400 text-sm font-semibold">Total Reports</h2>
              <div class="flex justify-between items-center mt-4">
                  <p class="text-3xl font-bold text-gray-900">{{ $totalReports }}</p>
                  <div class="text-blue-500 opacity-70">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
                      </svg>
                  </div>
              </div>
          </div>

          <div class="bg-white shadow-xl rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
              <h2 class="text-gray-400 text-sm font-semibold">Pending Reports</h2>
              <div class="flex justify-between items-center mt-4">
                  <p class="text-3xl font-bold text-gray-900">{{ $pendingReportsCount }}</p>
                  <div class="text-yellow-500 opacity-70">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                      </svg>
                  </div>
              </div>
          </div>

          <div class="bg-white shadow-xl rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
              <h2 class="text-gray-400 text-sm font-semibold">Resolved Reports</h2>
              <div class="flex justify-between items-center mt-4">
                  <p class="text-3xl font-bold text-gray-900">{{ $resolvedReportsCount }}</p>
                  <div class="text-green-500 opacity-70">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                  </div>
              </div>
          </div>
      </div>

      <!-- Recent Reports Table -->
      <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6">
          <h2 class="text-2xl font-semibold text-gray-900 mb-6">Recent Water Reports</h2>
          <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 table-auto">
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
                      <tr class="hover:bg-gray-50 transition cursor-pointer">
                          <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">#{{ $report->id }}</td>
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
                              <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full shadow-sm {{ $color }}">
                                  {{ $report->status }}
                              </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $report->created_at->format('M d, Y') }}</td>
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
