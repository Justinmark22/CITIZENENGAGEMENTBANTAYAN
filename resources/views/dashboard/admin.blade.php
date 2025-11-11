<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    #sidebar { transition: transform 0.3s ease-in-out; }
    @media (max-width: 640px) {
      .stats-card p:first-child { font-size: 0.7rem; }
      .stats-card p:last-child { font-size: 1.2rem; }
      .quick-actions a, .quick-actions button { padding: 0.5rem; font-size: 0.85rem; }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<!-- ✅ Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-blue-900 to-blue-800 text-white p-6 transform -translate-x-full lg:translate-x-0 z-50">
  <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>
  <nav class="flex flex-col gap-2 text-sm">
    <p class="uppercase text-xs opacity-70">Main</p>
    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-graph-up-arrow"></i> Analytics</a>

    <p class="uppercase text-xs opacity-70 mt-3">User Management</p>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-people"></i> Users</a>
    <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-person-badge"></i> Municipal Admins</a>

    <p class="uppercase text-xs opacity-70 mt-3">Content</p>
    <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-megaphone"></i> Announce</a>
    

    <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-calendar-event"></i> Events</a>
   
  </nav>
</aside>

<!-- ✅ Main Content -->
<div class="lg:ml-64 p-3 sm:p-4 lg:p-8">
  <button id="sidebarToggle" class="lg:hidden bg-blue-600 text-white px-3 py-2 rounded mb-4 shadow">☰ Menu</button>

  <!-- ✅ Navbar -->
  <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-3 sm:p-4 rounded-xl shadow mb-4 sm:mb-6">
    <button class="bg-red-500 text-white px-3 py-2 text-sm rounded shadow mb-2 sm:mb-0" onclick="openModal('alertModal')">➕ Add Emergency</button>

    <div class="flex gap-3 text-sm mb-2 sm:mb-0">
      <a href="{{ route('admin.download.database') }}" class="btn btn-primary">
    Download Database
</a>

  <a href="{{ route('view.bantayan') }}" class="relative font-semibold">
    Bantayan 
    <span id="badge-bantayan" class="hidden absolute -top-2 -right-3 bg-red-500 text-white font-bold rounded-full px-2 text-xs"></span>
  </a>

  <a href="{{ route('view.madridejos') }}" class="relative font-semibold">
    Madridejos 
    <span id="badge-madridejos" class="hidden absolute -top-2 -right-3 bg-red-500 text-white font-bold rounded-full px-2 text-xs"></span>
  </a>

  <a href="{{ route('view.santafe') }}" class="relative font-semibold">
    Sta. Fe 
    <span id="badge-santafe" class="hidden absolute -top-2 -right-3 bg-red-500 text-white font-bold rounded-full px-2 text-xs"></span>
  </a>
</div>


    <!-- Profile -->
    <div class="relative">
      <div onclick="toggleDropdown()" class="flex items-center gap-2 cursor-pointer">
        <img src="{{ asset('images/citizen.png') }}" class="w-9 h-9 rounded-full border">
        <div class="hidden sm:block">
          <p class="font-semibold text-sm">Welcome, Admin</p>
          <p class="text-xs text-gray-500">System Administrator</p>
        </div>
      </div>
      <div id="dropdownMenu" class="hidden absolute right-0 bg-white shadow rounded mt-2 w-32">
        <form method="POST" action="{{ route('logout') }}" id="logoutForm">@csrf
          <button type="button" onclick="confirmLogout()" class="block px-4 py-2 hover:bg-gray-100 w-full text-left text-sm">Logout</button>
        </form>
      </div>
    </div>
  </div>

 <!-- ✅ Stats Cards - Labels Bold, Smaller Numbers -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
  @php
    $stats = [
      ['label' => 'Total Users', 'value' => $totalUsers, 'color' => 'blue'],
      ['label' => 'Pending Reports', 'value' => $pendingReportsCount, 'color' => 'yellow'],
      ['label' => 'Resolved Reports', 'value' => $resolvedReports, 'color' => 'green'],
      ['label' => 'Total Reports', 'value' => $totalReports, 'color' => 'red'],
    ];
  @endphp
  @foreach ($stats as $stat)
    <div class="stats-card bg-white rounded-2xl p-5 shadow-lg text-center hover:shadow-xl transition">
      <p class="text-sm text-gray-800 font-bold">{{ $stat['label'] }}</p>
      <p class="text-xl sm:text-2xl font-normal text-{{ $stat['color'] }}-600">{{ $stat['value'] }}</p>
    </div>
  @endforeach
</div>



  <!-- ✅ Charts + Quick Actions -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
    <!-- 📈 Reports Overview -->
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition">
       <h2 class="text-lg font-semibold text-gray-900">Reports Overview</h2>
      <canvas id="reportChart" class="w-full h-64 sm:h-80"></canvas>
    </div>

    <!-- 📊 Reports by Day -->
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition">
       <h2 class="text-lg font-semibold text-gray-900">Reports by Day</h2>
      <canvas id="totalreportchart" class="w-full h-64 sm:h-80"></canvas>
    </div>

    <!-- 👥 Users Chart -->
    <div class="bg-white rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold text-gray-900"> Users by Municipality</h2>
      <canvas id="userChart" class="mx-auto h-56 sm:h-72"></canvas>
    </div>

    <!-- 🌐 Ultra-Premium Quick Actions -->
<section class="max-w-2xl mx-auto">
  <div class="backdrop-blur-lg bg-white/70 border border-gray-200 rounded-2xl shadow-xl p-6">
    
    <!-- Header -->
    <header class="mb-6">
     <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>

      <p class="text-sm text-gray-500 mt-1">Access key sections instantly</p>
    </header>

    <!-- Action Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <!-- Reports -->
      <a href="{{ route('admin.reports.index') }}" 
         class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-400 text-white flex items-center justify-center group-hover:scale-105 transition">
          <i class="bi bi-file-text text-xl"></i>
        </div>
        <div>
          <p class="font-semibold text-gray-900">Manage Reports</p>
          <span class="text-sm text-gray-500">Handle user reports efficiently</span>
        </div>
      </a>

      <!-- Users -->
      <a href="{{ route('admin.users.index') }}" 
         class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-400 text-white flex items-center justify-center group-hover:scale-105 transition">
          <i class="bi bi-people text-xl"></i>
        </div>
        <div>
          <p class="font-semibold text-gray-900">Manage Users</p>
          <span class="text-sm text-gray-500">Control accounts & roles</span>
        </div>
      </a>

      <!-- Announcements -->
      <a href="{{ route('admin.announcements.index') }}" 
         class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-400 text-white flex items-center justify-center group-hover:scale-105 transition">
          <i class="bi bi-megaphone text-xl"></i>
        </div>
        <div>
          <p class="font-semibold text-gray-900">Announcements</p>
          <span class="text-sm text-gray-500">Post updates to community</span>
        </div>
      </a>

      <!-- Events -->
      <a href="{{ route('admin.events.create') }}" 
         class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-400 text-white flex items-center justify-center group-hover:scale-105 transition">
          <i class="bi bi-calendar-event text-xl"></i>
        </div>
        <div>
          <p class="font-semibold text-gray-900">Manage Events</p>
          <span class="text-sm text-gray-500">Plan and edit events</span>
        </div>
      </a>

      <!-- Add Admin -->
      <button onclick="openModal('adminModal')" 
              class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-pink-400 text-white flex items-center justify-center group-hover:scale-105 transition">
          <i class="bi bi-shield-lock text-xl"></i>
        </div>
        <div>
          <p class="font-semibold text-gray-900">Add Admin</p>
          <span class="text-sm text-gray-500">Create new admin account</span>
        </div>
      </button>
    </div>
  </div>
</section>
<!-- ✅ Premium Add Admin Modal -->
<div id="adminModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200">
    
    <!-- Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
      <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add New Admin
      </h3>
      <button onclick="closeModal('adminModal')" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
    </div>

    <!-- Body -->
    <div class="p-6">
      <form method="POST" action="{{ route('admins.store') }}" class="space-y-5">
        @csrf
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input type="text" name="name" placeholder="Enter admin's name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
          <input type="email" name="email" placeholder="admin@email.com" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" name="password" placeholder="••••••••" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
          <select name="location" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
            <option value="">Select Location</option>
            <option value="Santa.Fe">Santa.Fe</option>
            <option value="Bantayan">Bantayan</option>
            <option value="Madridejos">Madridejos</option>
          </select>
        </div>

        <!-- ✅ New Role Dropdown -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
          <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="fire">Fire</option>
            <option value="waste">Waste</option>
            <option value="water">Water</option>
            <option value="mdrrmo">MDRRMO</option>
          </select>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t mt-6">
          <button type="button" onclick="closeModal('adminModal')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-medium">Cancel</button>
          <button type="submit" class="px-5 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition font-semibold shadow-md">Save Admin</button>
        </div>
      </form>
    </div>
  </div>
</div>


@if(session('success'))
<div 
    id="success-toast" 
    class="fixed top-4 right-4 flex items-center gap-3 bg-green-600 text-white px-4 py-3 rounded-lg shadow-xl z-50 animate-slide-in"
    role="alert"
>
    <!-- Success Icon -->
    <svg class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>

    <!-- Message -->
    <span class="font-medium">{{ session('success') }}</span>

    <!-- Close Button -->
    <button onclick="closeToast()" class="ml-2 text-white hover:text-gray-200">
        ✕
    </button>
</div>

<style>
    /* Slide-in animation */
    @keyframes slide-in {
        0% { opacity: 0; transform: translateX(100%); }
        100% { opacity: 1; transform: translateX(0); }
    }
    .animate-slide-in {
        animation: slide-in 0.5s ease-out;
    }

    /* Fade-out animation */
    @keyframes fade-out {
        0% { opacity: 1; }
        100% { opacity: 0; transform: translateX(100%); }
    }
    .animate-fade-out {
        animation: fade-out 0.5s ease-in forwards;
    }
</style>

<script>
    // Auto-close after 4 seconds
    setTimeout(() => {
        closeToast();
    }, 4000);

    function closeToast() {
        const toast = document.getElementById('success-toast');
        if (toast) {
            toast.classList.add('animate-fade-out');
            setTimeout(() => toast.remove(), 500);
        }
    }
</script>
@endif



<!-- ✅ Add Emergency Alert Modal -->
<div id="alertModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl w-full max-w-lg p-6">
    <h3 class="text-lg font-bold mb-4 text-red-600">🚨 Add Emergency Alert</h3>
    <form id="alertForm" method="POST" action="{{ route('admin.alerts.store') }}">
      @csrf
      <div class="mb-3">
        <label class="block text-sm font-medium">Alert Title</label>
        <input type="text" name="title" class="w-full border rounded px-3 py-2" placeholder="e.g. Fire in Zone 3" required>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Alert Message</label>
        <textarea name="message" class="w-full border rounded px-3 py-2" rows="3" placeholder="Provide a brief description..." required></textarea>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Select Municipality</label>
        <select name="location" class="w-full border rounded px-3 py-2" required>
          <option value="">-- Select Location --</option>
          <option value="Bantayan">Bantayan</option>
          <option value="Madridejos">Madridejos</option>
          <option value="Santa.Fe">Santa Fe</option>
          <option value="All">All Municipalities</option>
        </select>
      </div>
      <div class="flex justify-end gap-2 mt-4">
        <button type="button" onclick="closeModal('alertModal')" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Submit Alert</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Combined Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ✅ Emergency Alert Confirmation
  const alertForm = document.getElementById('alertForm');
  if (alertForm) {
    alertForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      Swal.fire({
        title: 'Confirm Alert',
        text: 'Are you sure you want to send this emergency alert?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, send it!'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit(); // ✅ triggers Laravel redirect and session message
        }
      });
    });
  }

  // ✅ Sidebar Toggle
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  sidebarToggle?.addEventListener('click', (e) => {
    e.stopPropagation(); 
    sidebar.classList.toggle('-translate-x-full');
  });

  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && 
        !sidebarToggle.contains(e.target) && 
        !sidebar.classList.contains('-translate-x-full') && 
        window.innerWidth < 1024) {
      sidebar.classList.add('-translate-x-full');
    }
  });

  // ✅ Dropdown Toggle
  window.toggleDropdown = function() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
  }

  // ✅ Logout Confirmation
  window.confirmLogout = function() {
    Swal.fire({
      title: 'Confirm Logout',
      text: 'Are you sure you want to log out?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Logout',
      cancelButtonText: 'Cancel'
    }).then(result => { if (result.isConfirmed) document.getElementById('logoutForm').submit(); });
  }

  // ✅ Modal Open/Close
  window.openModal = function(id) { document.getElementById(id).classList.remove('hidden'); }
  window.closeModal = function(id) { document.getElementById(id).classList.add('hidden'); }

  // ✅ Charts
  const reportDays = {!! json_encode($reportDays) !!};
  const reportCounts = {!! json_encode($reportCounts) !!};
  const pendingReports = {{ $pendingReportsCount }};
  const resolvedReports = {{ $resolvedReports }};
  const usersSantaFe = {{ $santaFeUsers ?? 0 }};
  const usersBantayan = {{ $bantayanUsers ?? 0 }};
  const usersMadridejos = {{ $madridejosUsers ?? 0 }};

  new Chart(document.getElementById('reportChart'), {
    type: 'line',
    data: {
      labels: ['Start', 'Now'],
      datasets: [
        { label: 'Pending', data: [0, pendingReports], borderColor: '#facc15', fill: true },
        { label: 'Resolved', data: [0, resolvedReports], borderColor: '#10b981', fill: true }
      ]
    }
  });

  new Chart(document.getElementById('totalreportchart'), {
    type: 'bar',
    data: { labels: reportDays, datasets: [{ label: 'Total Reports', data: reportCounts, backgroundColor: '#f97316' }] }
  });

 


  const ctx = document.getElementById('userChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Santa Fe', 'Bantayan', 'Madridejos'],
      datasets: [{
        data: [usersSantaFe, usersBantayan, usersMadridejos],
        backgroundColor: ['#6366f1','#34d399','#fbbf24'],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      cutout: '55%', // smaller cutout = bigger chart area
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            font: { size: 14 }
          }
        }
      }
    }
  });



});
</script>

</body>
</html>
