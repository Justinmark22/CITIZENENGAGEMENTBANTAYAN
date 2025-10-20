<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa Fe Water Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-gray-50 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white flex flex-col">
        <div class="px-6 py-4 text-2xl font-bold border-b border-blue-500">
            💧 Water Management
        </div>
        <nav class="flex-1 px-4 py-6 space-y-4">
            <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-700">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-700">
                <i class="bi bi-droplet-half"></i> Supply Status
            </a>
            <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-700">
                <i class="bi bi-exclamation-triangle"></i> Leak Reports
            </a>
            <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-700">
                <i class="bi bi-megaphone"></i> Announcements
            </a>
        </nav>
        <div class="p-4 border-t border-blue-500">
            <a href="/logout" class="text-sm text-blue-200 hover:text-white">Logout</a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8 space-y-8">
        <!-- Header -->
        <header class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Santa Fe Water Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">👤 Water Admin</span>
            </div>
        </header>

        <!-- Stats -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h3 class="text-gray-500 text-sm">Total Reports</h3>
                <p class="text-2xl font-bold text-blue-600">128</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h3 class="text-gray-500 text-sm">Active Leaks</h3>
                <p class="text-2xl font-bold text-red-600">12</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h3 class="text-gray-500 text-sm">Water Quality Index</h3>
                <p class="text-2xl font-bold text-green-600">92%</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h3 class="text-gray-500 text-sm">Supply Level</h3>
                <p class="text-2xl font-bold text-indigo-600">Stable</p>
            </div>
        </section>

        <!-- Charts & Reports -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Chart -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Water Consumption Trend</h3>
                <canvas id="waterTrendChart"></canvas>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pending Water Issues</h3>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="py-2">Report ID</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td>#W-1021</td>
                            <td>Leak</td>
                            <td><span class="text-red-500">Pending</span></td>
                            <td>Sept 15, 2025</td>
                        </tr>
                        <tr class="border-b">
                            <td>#W-1018</td>
                            <td>Low Supply</td>
                            <td><span class="text-yellow-500">In Progress</span></td>
                            <td>Sept 14, 2025</td>
                        </tr>
                        <tr>
                            <td>#W-1012</td>
                            <td>Quality Check</td>
                            <td><span class="text-green-500">Resolved</span></td>
                            <td>Sept 13, 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('waterTrendChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Consumption (m³)',
                    data: [120, 150, 130, 170, 180, 140, 160],
                    borderColor: 'rgba(37, 99, 235, 1)',
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            }
        });
    </script>
</body>
</html>
