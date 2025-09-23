<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa Fe Waste Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar + Header -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">Waste Management</h2>
                <p class="text-gray-500 mt-1">Santa Fe</p>
            </div>
            <nav class="mt-6">
                <a href="#" class="block px-6 py-2 text-gray-700 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="#" class="block px-6 py-2 text-gray-700 hover:bg-gray-200 rounded">Reports</a>
                <a href="#" class="block px-6 py-2 text-gray-700 hover:bg-gray-200 rounded">Analytics</a>
                <a href="#" class="block px-6 py-2 text-gray-700 hover:bg-gray-200 rounded">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Santa Fe Waste Management Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome, Waste Admin</p>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow rounded-lg p-5">
                    <h2 class="text-gray-500 text-sm font-medium">Total Reports</h2>
                    <p class="text-2xl font-bold mt-2">128</p>
                </div>
                <div class="bg-white shadow rounded-lg p-5">
                    <h2 class="text-gray-500 text-sm font-medium">Pending Actions</h2>
                    <p class="text-2xl font-bold mt-2">32</p>
                </div>
                <div class="bg-white shadow rounded-lg p-5">
                    <h2 class="text-gray-500 text-sm font-medium">Resolved Reports</h2>
                    <p class="text-2xl font-bold mt-2">96</p>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="bg-white shadow rounded-lg p-5">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Waste Reports</h2>
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
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#001</td>
                                <td class="px-6 py-4 whitespace-nowrap">Garbage Collection</td>
                                <td class="px-6 py-4 whitespace-nowrap">Overflowing trash bins at Market Street</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">2025-09-12</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#002</td>
                                <td class="px-6 py-4 whitespace-nowrap">Recycling</td>
                                <td class="px-6 py-4 whitespace-nowrap">Plastic waste not collected</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">2025-09-11</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#003</td>
                                <td class="px-6 py-4 whitespace-nowrap">Hazardous Waste</td>
                                <td class="px-6 py-4 whitespace-nowrap">Chemical spill near factory</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Action Required</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">2025-09-10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
