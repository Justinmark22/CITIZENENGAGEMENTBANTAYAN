<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDRRMO Bantayan – Resolved Reports</title>

  <!-- Tailwind, Alpine, SweetAlert -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 font-sans min-h-screen flex flex-col md:flex-row" x-data="reportApp()" x-init="fetchReports('Bantayan')">

  <!-- ======================= SIDEBAR ======================= -->
  <aside 
    class="fixed md:static inset-y-0 left-0 z-50 w-64 md:w-64 bg-gradient-to-b from-blue-200 to-blue-100 text-gray-800 p-6 shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0"
    :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="flex items-center justify-between mb-10">
      <div class="flex items-center gap-3">
        <img src="{{ asset('/images/mad.png') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
        <span class="text-lg md:text-2xl font-extrabold tracking-wide">MDRRMO BANTAYAN</span>
      </div>
      <button class="md:hidden text-2xl font-bold text-gray-600 hover:text-red-600" @click="mobileMenu=false">✕</button>
    </div>

    <nav class="flex flex-col gap-4 text-sm md:text-base">
      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
        <a href="{{ route('dashboard.mdrrmo-bantayan') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all font-medium">
          <i data-lucide="home" class="w-5 h-5"></i>
          Overview
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
        <a href="{{ route('mdrrmo.reports-bantayan') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          All Reports
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
        <a href="{{ route('mdrrmo.mdrrmo_bantayan-announcements') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="megaphone" class="w-5 h-5"></i>
          Announcements
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

  <!-- ======================= MAIN CONTENT ======================= -->
  <main class="flex-1 flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b px-4 sm:px-6 py-3 sm:py-4 flex flex-wrap justify-between items-center gap-4">
      <div class="flex items-center gap-2">
        <button class="md:hidden text-gray-700 hover:text-blue-600" @click="mobileMenu=true">☰</button>
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Resolved Reports – Bantayan</h2>
      </div>

      <div class="flex items-center gap-3 sm:gap-6 w-full sm:w-auto">
        <input type="text" placeholder="Search..." 
               class="w-full sm:w-52 border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:ring-blue-300"
               x-model="filters.search" @input="applyFilters()">

        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-600">Admin</span>
          <img src="/images/banmdrrmo.png" class="h-8 w-8 rounded-full border" alt="User Avatar">
        </div>
      </div>
    </header>

    <!-- Filters -->
    <div class="bg-gray-50 border-b px-4 sm:px-6 py-3 flex flex-wrap gap-3 items-center text-sm">
      <select x-model="filters.category" @change="applyFilters()" class="border rounded px-2 py-1 w-full sm:w-auto">
        <option value="">All Categories</option>
        <option value="Health">Health</option>
        <option value="Disaster">Disaster</option>
        <option value="Infrastructure">Infrastructure</option>
      </select>
      <input type="date" x-model="filters.date" @change="applyFilters()" class="border rounded px-2 py-1 w-full sm:w-auto">
    </div>

    <!-- Stats Overview -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-8">
      <div class="bg-white p-5 rounded-lg shadow border text-center">
        <h3 class="text-sm text-gray-500">Total Resolved</h3>
        <p class="text-2xl font-bold text-blue-700 mt-1" x-text="reports.length"></p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border text-center">
        <h3 class="text-sm text-gray-500">Announcements Posted</h3>
        <p class="text-2xl font-bold text-green-600 mt-1" x-text="stats.announcements"></p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border text-center">
        <h3 class="text-sm text-gray-500">Pending Reviews</h3>
        <p class="text-2xl font-bold text-yellow-600 mt-1" x-text="stats.pending"></p>
      </div>
    </section>

    <!-- ======================= REPORTS GRID ======================= -->
    <section class="p-4 sm:p-8">
      <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        <template x-for="(report, index) in filteredReports" :key="index">
          <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 flex flex-col hover:-translate-y-1">

            <!-- Image -->
            <div class="relative h-48 sm:h-56 overflow-hidden rounded-t-2xl">
              <img 
                :src="report.photo ? report.photo : 'https://via.placeholder.com/600x400?text=No+Image'" 
                alt="Report Photo"
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
              <span class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-md uppercase">
                <span x-text="report.category || 'General'"></span>
              </span>
            </div>

            <!-- Content -->
            <div class="p-5 flex flex-col flex-1">
              <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-1 hover:text-indigo-600 cursor-pointer" x-text="report.title"></h3>
              <p class="text-sm text-gray-700 mb-4 line-clamp-3 flex-1" x-text="report.description"></p>

              <div class="flex justify-between text-xs text-gray-500 border-t pt-3 mt-auto">
                <span><i class="mr-1" data-lucide="clock"></i> <span x-text="new Date(report.updated_at).toLocaleDateString()"></span></span>
                <span><i class="mr-1" data-lucide="map-pin"></i> <span x-text="report.location || 'Bantayan'"></span></span>
              </div>
            </div>

            <!-- Button -->
            <div class="bg-white/90 p-4 border-t">
              <button 
                x-show="!report.announced"
                @click="postAnnouncement(report, index)"
                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-sm py-2.5 rounded-xl shadow-md hover:from-indigo-600 hover:to-blue-600 focus:ring-2 focus:ring-indigo-300 focus:outline-none transition-all font-semibold">
                📢 <span>Post to Announcements</span>
              </button>
            </div>
          </div>
        </template>
      </div>
    </section>
  </main>

  <script>
  function reportApp() {
    return {
      mobileMenu: false,
      reports: [],
      filteredReports: [],
      stats: { announcements: 0, pending: 0 },
      filters: { search: '', category: '', date: '' },

      async fetchReports() {
        try {
          const response = await fetch('/api/resolved-reports/bantayan');
          if (!response.ok) throw new Error('Failed to fetch reports');
          const data = await response.json();
          this.reports = data.map(r => ({ ...r, announced: r.announced ?? false }));
          this.filteredReports = this.reports;
          this.stats.pending = this.reports.filter(r => r.status === 'pending').length;
        } catch {
          Swal.fire('Error!', 'Failed to fetch resolved reports for Bantayan.', 'error');
        }
      },

      applyFilters() {
        this.filteredReports = this.reports.filter(r => {
          const matchSearch = !this.filters.search || r.title.toLowerCase().includes(this.filters.search.toLowerCase());
          const matchCategory = !this.filters.category || r.category === this.filters.category;
          const matchDate = !this.filters.date || new Date(r.updated_at).toLocaleDateString() === new Date(this.filters.date).toLocaleDateString();
          return matchSearch && matchCategory && matchDate;
        });
      },

      async postAnnouncement(report, index) {
        try {
          const { value: formValues } = await Swal.fire({
            title: 'Post Announcement',
            html: `
              <input id="swal-extra-title" class="swal2-input" placeholder="Additional Title/Info">
              <textarea id="swal-extra-desc" class="swal2-textarea" placeholder="Additional Description"></textarea>
              <input id="swal-extra-photo" type="file" accept="image/*" class="swal2-file">
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Post',
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
          formData.append('location', 'Bantayan');
          formData.append('report_id', report.id);
          if (formValues.extraPhoto) formData.append('photo', formValues.extraPhoto);

          const res = await fetch('/post-announcement/bantayan', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
            body: formData
          });

          const result = await res.json();
          if (!res.ok || !result.success) throw new Error(result.message || 'Failed to post announcement');
          Swal.fire('Success!', 'Announcement posted successfully 🎉', 'success');
          this.reports[index].announced = true;
          this.stats.announcements++;
          this.applyFilters();
        } catch (error) {
          Swal.fire('Error!', error.message || 'Something went wrong while posting.', 'error');
        }
      }
    };
  }
  </script>

</body>
</html>
