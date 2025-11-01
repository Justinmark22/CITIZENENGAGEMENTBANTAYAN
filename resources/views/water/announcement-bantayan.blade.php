<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Water Bantayan – Resolved Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans flex min-h-screen" x-data="reportApp()" x-init="fetchReports()">

<!-- Sidebar -->
<aside class="fixed md:static inset-y-0 left-0 z-40 w-64 
  bg-gradient-to-b from-blue-200 to-blue-100 text-gray-800 p-6 
  transform transition-transform duration-300 ease-in-out shadow-lg"
  :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

  <div class="flex items-center justify-between mb-10">
    <img src="{{ asset('/images/SAN.PNG') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
    <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">Water Bantayan</span>
    <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
  </div>

  <nav class="flex flex-col gap-4">
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
      <a href="{{ route('dashboard.water-bantayan') }}" 
         class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
        <i data-lucide="home" class="w-5 h-5"></i> Overview
      </a>
    </div>

    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
      <a href="{{ route('water.reports-bantayan') }}" 
         class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="file-text" class="w-5 h-5"></i> All Reports
      </a>
    </div>

    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
      <a href="{{ route('water.announcement-bantayan') }}" 
         class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="megaphone" class="w-5 h-5"></i> Announcements
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

  <!-- Stats Overview -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 border-b bg-gray-50">
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

  <!-- Resolved Reports List -->
  <section class="grid lg:grid-cols-2 gap-6 p-8">
    <template x-for="(report, index) in filteredReports" :key="index">
      <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-2xl p-5 shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate-fadeIn">
        <div class="absolute inset-0 bg-green-200/10 rounded-2xl -z-10"></div>

        <strong class="text-gray-800 text-md">
          Citizen Report (ID: <span x-text="report.id"></span>)
        </strong>

        <p class="text-gray-700 text-sm mt-2">
          Your report titled <em>"<span x-text="report.title"></span>"</em> 
          in the category <span class="font-semibold text-green-600" x-text="report.category"></span> 
          has been successfully resolved.
        </p>

        <div class="text-xs text-gray-500 mt-3 space-y-1 flex flex-col">
          <div class="flex items-center gap-1">
            <i data-lucide="calendar" class="w-4 h-4 text-green-600"></i> 
            <span>Resolved: </span> 
            <span x-text="new Date(report.updated_at).toLocaleString()"></span>
          </div>
          <div class="flex items-center gap-1">
            <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i> 
            Report ID: <span class="font-mono" x-text="report.id"></span>
          </div>
        </div>

        <div class="mt-4 flex gap-2 justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-500">
          <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700 flex items-center gap-1">
            <i data-lucide="eye" class="w-4 h-4"></i> View Details
          </button>
          <button @click="postAnnouncement(report, index)" 
            class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs hover:bg-green-200 flex items-center gap-1">
            <i data-lucide="message-circle" class="w-4 h-4"></i> Send Feedback
          </button>
        </div>
      </div>
    </template>

    <p x-show="filteredReports.length === 0" class="text-gray-500 text-sm text-center py-10 col-span-2">
      No resolved reports available.
    </p>
  </section>
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
        const response = await fetch('/resolved-reports/Bantayan');
        if (!response.ok) throw new Error('Failed to fetch Bantayan resolved reports');
        this.reports = await response.json();
        this.filteredReports = this.reports;
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Failed to Load Reports',
          text: 'Unable to fetch resolved reports for Bantayan.',
          confirmButtonColor: '#e3342f'
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
            <p class="text-sm text-gray-600 mb-2">Add details for this announcement:</p>
            <input id="swal-extra-title" class="swal2-input" placeholder="Extra Title">
            <textarea id="swal-extra-desc" class="swal2-textarea" placeholder="Extra Description"></textarea>
            <input id="swal-extra-photo" type="file" accept="image/*" class="swal2-file">
          `,
          showCancelButton: true,
          confirmButtonText: 'Post Announcement',
          preConfirm: () => ({
            extraTitle: document.getElementById('swal-extra-title').value,
            extraDesc: document.getElementById('swal-extra-desc').value,
            extraPhoto: document.getElementById('swal-extra-photo').files[0] || null
          })
        });

        if (!formValues) return;

        const formData = new FormData();
        formData.append('title', report.title + (formValues.extraTitle ? ` - ${formValues.extraTitle}` : ''));
        formData.append('description', report.description + (formValues.extraDesc ? `\n\n${formValues.extraDesc}` : ''));
        formData.append('category', report.category);
        formData.append('location', 'Bantayan');
        formData.append('report_id', report.id);
        if (formValues.extraPhoto) formData.append('photo', formValues.extraPhoto);

        const response = await fetch('/post-announcement', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: error.message,
          confirmButtonColor: '#d33'
        });
      }
    }
  }
}
</script>

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</body>
</html>
