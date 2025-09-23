<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Santa Fe Resolved Reports</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans antialiased flex min-h-screen" x-data="reportApp()" x-init="fetchReports()">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0 p-6 flex flex-col">
        <h1 class="text-2xl font-bold mb-8">MDRRMO Santa Fe</h1>
        <nav class="flex flex-col gap-3">
            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-800 transition">Dashboard</a>
            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-800 transition">Reports</a>
            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-800 transition">Announcements</a>
            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-800 transition">Events</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Santa Fe Resolved Reports</h1>

        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <template x-for="(report, index) in reports" :key="index">
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-3" x-text="report.title"></h2>
                        <p class="text-gray-700 mb-4" x-text="report.description"></p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span x-text="'📅 Resolved: ' + new Date(report.updated_at).toLocaleDateString()"></span>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs" x-text="report.category || 'General'"></span>
                        </div>
                    </div>
                    <!-- Post to Announce Button -->
                    <button 
                        x-show="(report.location || 'Santa.Fe') === 'Santa.Fe'" 
                        @click="postAnnouncement(report, index)" 
                        class="mt-4 bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition w-full font-semibold">
                        Post to Announce
                    </button>
                </div>
            </template>

            <template x-if="reports.length === 0">
                <p class="col-span-full text-gray-500 text-center text-lg mt-8">No resolved reports yet.</p>
            </template>
        </div>
    </main>

<script>
function reportApp() {
    return {
        reports: [],
        async fetchReports() {
            try {
                const response = await fetch('/resolved-reports');
                if (!response.ok) throw new Error('Failed to fetch reports');
                this.reports = await response.json();
            } catch (error) {
                console.error(error);
                alert('Error fetching resolved reports.');
            }
        },
        async postAnnouncement(report, index) {
            try {
                const payload = {
                    title: report.title,
                    description: report.description,
                    category: report.category,
                    location: 'Santa.Fe' // enforce Santa Fe location
                };

                const response = await fetch('/post-announcement', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                // Check for non-JSON response
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error('Server error: ' + text);
                }

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.message || 'Failed to post announcement');
                }

                alert('Announcement posted successfully!');
                this.reports.splice(index, 1);

            } catch (error) {
                console.error(error);
                alert('Error posting announcement: ' + error.message);
            }
        }
    }
}
</script>

</body>
</html>
