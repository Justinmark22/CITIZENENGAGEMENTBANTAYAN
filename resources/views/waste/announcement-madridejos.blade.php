<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waste Madridejos – Resolved Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 font-sans flex min-h-screen" x-data="reportApp()" x-init="fetchReports()">

  <!-- Sidebar -->
  <aside class="fixed md:static inset-y-0 left-0 z-40 w-64 
         bg-gradient-to-b from-blue-200 to-blue-100 
         text-gray-800 p-6 transform transition-transform duration-300 
         ease-in-out shadow-lg"
         :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="flex items-center justify-between mb-10">
      <img src="{{ asset('/images/SAN.PNG') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
      <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">Waste madridejos</span>
      <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
    </div>

    <nav class="flex flex-col gap-4">
      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
        <a href="{{ route('dashboard.waste-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
          <i data-lucide="home" class="w-5 h-5"></i>
          <span class="font-medium">Overview</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
        <a href="{{ route('waste.reports-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          <span>All Reports</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
        <a href="{{ route('waste.announcement-madridejos') }}" 
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

  <!-- Main -->
  <main class="flex-1 flex flex-col">
    <header class="bg-white border-b px-6 py-4 flex justify-between items-center">
      <h2 class="text-xl font-semibold text-gray-800">Resolved Reports</h2>
      <div class="flex items-center gap-6">
        <input type="text" placeholder="Search reports..." 
               class="border rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-300"
               x-model="filters.search" @input="applyFilters()">
        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-600">Admin</span>
          <img src="/images/SAN.PNG" class="h-8 w-8 rounded-full border" alt="User">
        </div>
      </div>
    </header>

    <!-- Filters -->
    <div class="bg-gray-50 border-b px-6 py-3 flex gap-4 items-center text-sm">
      <select x-model="filters.category" @change="applyFilters()" class="border rounded px-2 py-1">
        <option value="">All Categories</option>
        <option value="Health">Health</option>
        <option value="Disaster">Disaster</option>
        <option value="Infrastructure">Infrastructure</option>
      </select>
      <input type="date" x-model="filters.date" @change="applyFilters()" class="border rounded px-2 py-1">
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6">
      <div class="bg-white p-5 rounded-lg shadow border">
        <h3 class="text-sm text-gray-500">Total Resolved</h3>
        <p class="text-2xl font-bold text-blue-700" x-text="reports.length"></p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border">
        <h3 class="text-sm text-gray-500">Announcements Posted</h3>
        <p class="text-2xl font-bold text-green-600" x-text="stats.announcements"></p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border">
        <h3 class="text-sm text-gray-500">Pending Reviews</h3>
        <p class="text-2xl font-bold text-yellow-600" x-text="stats.pending"></p>
      </div>
    </div>

    <!-- Reports Grid -->
    <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-6">
      <template x-for="(report, index) in filteredReports" :key="index">
        <div class="relative bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col transform hover:-translate-y-1">
          
          <div class="relative h-52 overflow-hidden rounded-t-2xl">
            <img 
              :src="report.photo ? report.photo : 'https://via.placeholder.com/600x400?text=No+Image'" 
              alt="Report Photo" 
              class="w-full h-full object-cover transition-transform duration-500 hover:scale-110 hover:rotate-1">
            <span class="absolute top-4 left-4 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-md tracking-wide uppercase" 
                  x-text="report.category || 'General'"></span>
          </div>

          <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 hover:text-indigo-600 transition-colors duration-300 cursor-pointer" 
                x-text="report.title"></h3>
            <p class="text-sm text-gray-700 mb-4 line-clamp-3 flex-1 leading-relaxed" x-text="report.description"></p>

            <div class="flex justify-between items-center text-xs text-gray-500 mt-auto pt-3 border-t border-gray-200">
              <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h8m-7 4h6" />
                </svg>
                <span x-text="new Date(report.updated_at).toLocaleDateString()"></span>
              </span>
              <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zM12 12v7" />
                </svg>
                <span x-text="report.location || 'Madridejos'"></span>
              </span>
            </div>
          </div>

          <div class="bg-white/90 p-4 border-t border-gray-200">
            <button x-show="!report.announced" @click="postAnnouncement(report, index)"
              class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-sm py-2.5 rounded-xl shadow-md hover:from-indigo-600 hover:to-blue-600 focus:ring-2 focus:ring-indigo-300 focus:outline-none transition-all duration-300 font-semibold">
              📢 <span>Post to Announcements</span>
            </button>
          </div>
        </div>
      </template>
    </div>
  </main>

  <script>
    function reportApp() {
      return {
        reports: [],
        filteredReports: [],
        stats: { announcements: 0, pending: 0 },
        filters: { search: '', category: '', date: '' },

        async fetchReports() {
          try {
            const response = await fetch('/resolved-reports-madridejos');
            if (!response.ok) throw new Error('Failed to fetch resolved madridejos reports');
            this.reports = await response.json();
            this.filteredReports = this.reports;
            console.log(this.reports); // ✅ Debug check
          } catch (error) {
            Swal.fire({
              title: 'Error!',
              text: 'Failed to fetch resolved madridejos reports.',
              icon: 'error',
              confirmButtonColor: '#d33'
            });
          }
        },

        applyFilters() {
          this.filteredReports = this.reports.filter(r => {
            let match = true;
            if (this.filters.search && !r.title.toLowerCase().includes(this.filters.search.toLowerCase())) match = false;
            if (this.filters.category && r.category !== this.filters.category) match = false;
            if (this.filters.date && new Date(r.updated_at).toLocaleDateString() !== new Date(this.filters.date).toLocaleDateString()) match = false;
            return match;
          });
        },

        async postAnnouncement(report, index) {
          try {
            const { value: formValues } = await Swal.fire({
              title: 'Post Announcement',
              html: `
                <p class="text-sm text-gray-600 mb-2">Please add details for this announcement:</p>
                <input id="swal-extra-title" class="swal2-input" placeholder="Additional Title/Info">
                <textarea id="swal-extra-desc" class="swal2-textarea" placeholder="Additional Description"></textarea>
                <input id="swal-extra-photo" type="file" accept="image/*" class="swal2-file">
              `,
              focusConfirm: false,
              showCancelButton: true,
              confirmButtonText: 'Post Announcement',
              cancelButtonText: 'Cancel',
              preConfirm: () => ({
                extraTitle: document.getElementById('swal-extra-title').value,
                extraDesc: document.getElementById('swal-extra-desc').value,
                extraPhoto: document.getElementById('swal-extra-photo').files[0] || null
              })
            });

            if (!formValues) return;

            const formData = new FormData();
            formData.append('title', report.title + (formValues.extraTitle ? ` - ${formValues.extraTitle}` : ''));
            formData.append('description', report.description + (formValues.extraDesc ? `\n\nUpdate: ${formValues.extraDesc}` : ''));
            formData.append('category', report.category);
            formData.append('location', 'Madridejos'); // ✅ Fixed
            formData.append('report_id', report.id);
            if (formValues.extraPhoto) formData.append('photo', formValues.extraPhoto);

            const response = await fetch('/post-announcement', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
              },
              body: formData
            });

            const result = await response.json();
            if (!response.ok || !result.success) throw new Error(result.message || 'Failed to post announcement');

            Swal.fire({
              title: 'Success!',
              text: 'Announcement posted successfully 🎉',
              icon: 'success',
              confirmButtonColor: '#2563eb'
            });

            this.reports[index].announced = true;
            this.stats.announcements++;
            this.applyFilters();

          } catch (error) {
            console.error('postAnnouncement error:', error);
            Swal.fire({
              title: 'Error!',
              text: error.message || 'Something went wrong while posting the announcement.',
              icon: 'error',
              confirmButtonColor: '#d33'
            });
          }
        }
      };
    }
  </script>
</body>
</html>
