<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Analytics</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<!-- ✅ Mobile Top Bar -->
<div class="md:hidden bg-[#1e3a8a] text-white p-4 flex justify-between items-center">
  <h1 class="text-lg font-bold">Admin Panel</h1>
  <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')" class="text-2xl">
    <i class="bi bi-list"></i>
  </button>
</div>

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
<!-- ✅ Sidebar (Mobile Toggle) -->
<aside id="mobileSidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] 
  text-white p-6 flex flex-col shadow-xl z-50 hidden md:hidden">
  <h1 class="text-2xl font-bold mb-8">Admin Panel</h1>
  
  <!-- Reuse same nav -->
  <nav class="flex flex-col gap-4">
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
      <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.analytics') ? 'bg-white/20 font-semibold' : '' }}">
        <i class="bi bi-graph-up-arrow"></i> Analytics
      </a>
    </div>
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people"></i> Users
      </a>
      <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-person-badge"></i> Municipal Admins
      </a>
    </div>
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Content</p>
      <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-megaphone"></i> Announce
      </a>
      <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-file-text"></i> Reports
      </a>
      <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-plus-square"></i> Updates
      </a>
      <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-calendar-event"></i> Events
      </a>
      <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people-fill"></i> Engagement
      </a>
    </div>
  </nav>
</aside>

<!-- ✅ Main Content -->
<div class="md:ml-64 p-4 md:p-8">

  <!-- ✅ Header -->
  <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg p-6 mb-8 border border-gray-200">
    <div class="flex justify-between items-center flex-wrap gap-3">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
          <i class="bi bi-bar-chart-line text-red-600"></i> System Analytics
        </h2>
        <p class="text-gray-500">📈 Real-time insights of reports, users & feedback</p>
      </div>
      <div class="flex gap-2">
        <button class="px-4 py-2 rounded-xl bg-red-600 text-white font-medium shadow">Overview</button>
      </div>
    </div>
  </div>

  <!-- ✅ KPI Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white/70 backdrop-blur-xl p-5 rounded-2xl shadow-lg border border-gray-200 flex items-center gap-4">
      <div class="bg-red-100 text-red-600 p-3 rounded-xl"><i class="bi bi-file-earmark-bar-graph text-xl"></i></div>
      <div>
        <h6 class="text-sm text-gray-500">Total Reports</h6>
        <h3 class="text-2xl font-bold">{{ $totalReports ?? 0 }}</h3>
      </div>
    </div>
    <div class="bg-white/70 backdrop-blur-xl p-5 rounded-2xl shadow-lg border border-gray-200 flex items-center gap-4">
      <div class="bg-green-100 text-green-600 p-3 rounded-xl"><i class="bi bi-check2-circle text-xl"></i></div>
      <div>
        <h6 class="text-sm text-gray-500">Resolved</h6>
        <h3 class="text-2xl font-bold">{{ $resolvedReports ?? 0 }}</h3>
      </div>
    </div>
    <div class="bg-white/70 backdrop-blur-xl p-5 rounded-2xl shadow-lg border border-gray-200 flex items-center gap-4">
      <div class="bg-yellow-100 text-yellow-600 p-3 rounded-xl"><i class="bi bi-hourglass-split text-xl"></i></div>
      <div>
        <h6 class="text-sm text-gray-500">Pending</h6>
        <h3 class="text-2xl font-bold">{{ $pendingReports ?? 0 }}</h3>
      </div>
    </div>
    <div class="bg-white/70 backdrop-blur-xl p-5 rounded-2xl shadow-lg border border-gray-200 flex items-center gap-4">
      <div class="bg-indigo-100 text-indigo-600 p-3 rounded-xl"><i class="bi bi-people text-xl"></i></div>
      <div>
        <h6 class="text-sm text-gray-500">Total Users</h6>
        <h3 class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</h3>
      </div>
    </div>
  </div>

 <!-- ✅ Charts - Compact Style -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
  <div class="bg-white/70 backdrop-blur-xl p-4 rounded-2xl shadow-md border border-gray-200">
    <h5 class="font-semibold mb-2 flex items-center gap-2 text-sm">
      <i class="bi bi-activity text-red-600"></i> Reports Status Overview
    </h5>
    <canvas id="statusChart" class="w-full h-40"></canvas>
  </div>
  <div class="bg-white/70 backdrop-blur-xl p-4 rounded-2xl shadow-md border border-gray-200">
    <h5 class="font-semibold mb-2 flex items-center gap-2 text-sm">
      <i class="bi bi-geo-alt text-green-600"></i> Reports by Municipality
    </h5>
    <canvas id="municipalityChart" class="w-full h-40"></canvas>
  </div>
  <div class="bg-white/70 backdrop-blur-xl p-4 rounded-2xl shadow-md border border-gray-200">
    <h5 class="font-semibold mb-2 flex items-center gap-2 text-sm">
      <i class="bi bi-calendar-event text-yellow-600"></i> Daily Reports Trend
    </h5>
    <canvas id="dailyChart" class="w-full h-40"></canvas>
  </div>
  <div class="bg-white/70 backdrop-blur-xl p-4 rounded-2xl shadow-md border border-gray-200">
    <h5 class="font-semibold mb-2 flex items-center gap-2 text-sm">
      <i class="bi bi-people text-indigo-600"></i> User Growth Over Time
    </h5>
    <canvas id="userChart" class="w-full h-40"></canvas>
  </div>
</div>


  <!-- ✅ Feedback Section -->
  <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl shadow-lg border border-gray-200">
    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-2"><i class="bi bi-chat-left-text text-red-600"></i> All Users Feedback</h4>
    <p class="text-sm text-gray-500 mb-3">Live feedback from users</p>
    <div id="feedback-container" class="space-y-3 max-h-80 overflow-y-auto">
      <!-- AJAX feedback will load here -->
    </div>
  </div>

</div>

<!-- ✅ Chart.js + AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const pending = {{ $pendingReports ?? 0 }};
  const resolved = {{ $resolvedReports ?? 0 }};
  const ongoing = {{ $ongoingReports ?? 0 }};
  const rejected = {{ $rejectedReports ?? 0 }};
  const total = {{ $totalReports ?? 0 }};
  const feedbacks = {{ $totalFeedbacks ?? 0 }};
  const municipalities = {!! json_encode($municipalities ?? ['Santa Fe', 'Bantayan', 'Madridejos']) !!};
  const reportsByMunicipality = {!! json_encode($reportsByMunicipality ?? [50, 40, 30]) !!};
  const dailyReports = {!! json_encode($dailyReports ?? [12, 18, 25, 15, 30, 22, 28]) !!};
  const userGrowth = {!! json_encode($userGrowth ?? [100, 120, 150, 200, 250, 300, 350]) !!};

  new Chart(document.getElementById('statusChart'), {
    type: 'radar',
    data: {
      labels: ['Pending', 'Resolved', 'Ongoing', 'Rejected', 'Total', 'Feedbacks'],
      datasets: [{
        data: [pending, resolved, ongoing, rejected, total, feedbacks],
        backgroundColor: 'rgba(239,68,68,0.2)',
        borderColor: '#ef4444',
        pointBackgroundColor: '#dc2626'
      }]
    },
    options: { responsive: true, scales: { r: { beginAtZero: true } } }
  });

  new Chart(document.getElementById('municipalityChart'), {
    type: 'polarArea',
    data: {
      labels: municipalities,
      datasets: [{
        data: reportsByMunicipality,
        backgroundColor: ['#ef4444','#f59e0b','#10b981']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });

  const ctx = document.getElementById('dailyChart').getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, 'rgba(239,68,68,0.4)');
  gradient.addColorStop(1, 'rgba(239,68,68,0)');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
      datasets: [{
        label: 'Reports',
        data: dailyReports,
        borderColor: '#ef4444',
        backgroundColor: gradient,
        fill: true,
        tension: 0.4
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });

  new Chart(document.getElementById('userChart'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
      datasets: [{
        label: 'Users',
        data: userGrowth,
        backgroundColor: '#10b981',
        borderRadius: 8
      }]
    },
    options: { responsive: true, indexAxis: 'y', plugins: { legend: { display: false } } }
  });

  function loadFeedbacks() {
    fetch('{{ route("admin.feedbacks.latest") }}')
      .then(res => res.json())
      .then(data => {
        let container = document.getElementById('feedback-container');
        container.innerHTML = '';
        data.forEach(fb => {
          let stars = '';
          for (let i = 1; i <= 5; i++) {
            stars += `<i class="bi bi-star${i <= fb.rating ? '-fill text-yellow-400' : ''}"></i>`;
          }
          container.innerHTML += `
            <div class="p-3 bg-white/50 backdrop-blur-lg rounded-xl shadow border border-gray-100">
              <div class="flex items-center gap-2 mb-1">
                <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center">${fb.user_id}</div>
                <div>
                  <p class="text-xs text-gray-500">Feedback ID: #${fb.id}</p>
                  <p class="text-xs text-gray-400">${new Date(fb.created_at).toLocaleString()}</p>
                </div>
              </div>
              <p class="text-sm text-gray-700"><strong>Location:</strong> ${fb.location}</p>
              <p class="text-sm text-gray-600 mb-1">${fb.feedback}</p>
              <div class="flex gap-1
              <div class="flex gap-1 text-yellow-400">${stars}</div>
            </div>
          `;
        });
      });
  }
  loadFeedbacks();
  setInterval(loadFeedbacks, 5000);
});
document.addEventListener('click', function(event) {
  const sidebar = document.getElementById('mobileSidebar');
  const toggleBtn = document.querySelector('.md\\:hidden button'); // Mobile menu button

  // If sidebar is visible and click is outside sidebar & not the toggle button
  if (!sidebar.classList.contains('hidden') && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
    sidebar.classList.add('hidden');
  }
});

</script>

</body>
</html>
