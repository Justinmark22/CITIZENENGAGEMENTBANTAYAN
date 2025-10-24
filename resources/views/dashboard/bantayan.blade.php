<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bantayan Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<!-- Navbar -->
<nav class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-50">
  <a href="#" class="flex items-center gap-3">
    <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-200 shadow-sm">
    <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">Bantayan Dashboard</span>
  </a>

  <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
    <i data-lucide="menu" class="w-6 h-6"></i>
  </button>

  <div id="navbarLinks" class="hidden md:flex md:flex-row items-center gap-4 md:gap-5 w-full md:w-auto absolute md:static top-full left-0 bg-white md:bg-transparent shadow-lg md:shadow-none rounded-xl md:rounded-none p-4 md:p-0 border md:border-0 animate-fadeIn">

    <!-- Alerts Dropdown -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('alertsDropdown'); clearBadge();" class="flex items-center justify-start md:justify-center gap-2 w-full md:w-auto rounded-lg px-3 py-2 hover:bg-gray-100 transition text-gray-700 font-medium relative">
        <i data-lucide="bell" class="w-5 h-5"></i>
        <span>Notifications</span>
        @php 
          $totalAlerts = $alerts->count() + $mddrmoAcceptedReports->count() + $wasteAcceptedReports->count()
                        + $mddrmoOngoingReports->count() + $wasteOngoingReports->count()
                        + $mddrmoResolvedReports->count() + $wasteResolvedReports->count(); 
        @endphp
        @if($totalAlerts > 0)
          <span id="alertsBadge" class="absolute top-0 right-0 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full shadow">{{ $totalAlerts }}</span>
        @endif
      </button>

      <div id="alertsDropdown" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
        <div class="flex justify-between items-center px-4 py-2 border-b border-gray-200">
          <h6 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Notifications</h6>
          <button onclick="hideNotifications()" class="text-gray-400 hover:text-gray-600 text-sm">Clear All</button>
        </div>
        <div class="max-h-96 overflow-y-auto">
          @forelse ($alerts as $alert)
            <div onclick="showAlertModal({{ $alert->id }}, '{{ $alert->title }}', '{{ $alert->message }}')" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition">
              <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="text-blue-600" data-lucide="alert-triangle"></i>
              </div>
              <div class="flex-1">
                <p class="text-gray-800 text-sm font-medium">{{ $alert->title }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ $alert->message }}</p>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-sm text-center py-4">No alerts available.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Menu links -->
    <a href="{{ route('feedback.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition w-full md:w-auto px-3 py-2 rounded-lg hover:bg-gray-100">
      <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
    </a>

    <a href="{{ route('contact.support.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition w-full md:w-auto px-3 py-2 rounded-lg hover:bg-gray-100">
      <i data-lucide="life-buoy" class="w-4 h-4"></i> Support
    </a>

    <button onclick="openModal('reportModal')" class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full font-semibold text-gray-800 shadow-sm transition">
      + Concern
    </button>

    <!-- User Dropdown -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('userDropdown')" class="flex items-center justify-between md:justify-start w-full md:w-auto gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium">
        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
          <i data-lucide="user" class="w-4 h-4"></i>
        </div>
        <span class="md:inline hidden font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
        <i data-lucide="chevron-down" class="w-4 h-4"></i>
      </button>

      <div id="userDropdown" class="hidden absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-64 overflow-hidden border border-gray-100 z-50">
        <div class="px-5 py-4 bg-gray-50">
          <p class="font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
          <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? 'No Email' }}</p>
          <p class="text-gray-400 text-sm">{{ Auth::user()->location ?? 'No Location' }}</p>
        </div>
        <div class="border-t">
          <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
            <i data-lucide="settings" class="w-4 h-4"></i> Settings
          </a>
          <button onclick="confirmLogout(event)" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition">
            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
          </button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-r from-green-50 to-lime-50">
  <div class="absolute top-0 left-0 w-40 md:w-56 h-40 md:h-56 bg-green-200 rounded-full opacity-30 blur-2xl -z-10"></div>
  <div class="absolute top-0 right-0 w-60 md:w-80 h-60 md:h-80 bg-lime-200 rounded-full opacity-30 blur-2xl -z-10"></div>

  <div class="px-6 md:px-8 flex flex-col lg:flex-row gap-10 items-start">
    <!-- Hero Text -->
    <div class="lg:w-1/2 max-w-xl flex flex-col justify-center">
      <h1 class="text-3xl md:text-5xl font-extrabold mb-3 md:mb-4 leading-tight text-gray-900">
        Welcome, <span class="text-green-700">{{ Auth::user()->name ?? 'Guest' }}</span>
      </h1>
      <h2 class="text-xl md:text-2xl font-semibold mb-4 text-gray-700">Citizen Engagement Platform</h2>
      <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
        Empowering citizen participation through transparent and accessible platforms, fostering evidence-based decision-making for the community.
      </p>
      <button class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold shadow-md hover:bg-green-700 transition transform hover:scale-105">
        Learn More
      </button>
    </div>

    <!-- Reports Grid -->
    <section class="grid lg:grid-cols-2 gap-6 lg:w-1/2">

      <!-- MDRRMO Resolved Reports -->
      <div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
        <h5 class="text-green-600 font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
          <i class="bi bi-megaphone-fill text-green-600"></i> MDRRMO Resolved Reports
        </h5>
        <div class="overflow-auto space-y-5 flex-1 max-h-[480px]">
          @php
            use Carbon\Carbon;
            $reports = \App\Models\ForwardedReport::with('user')->where('location','Bantayan')->where('status','Resolved')->latest()->get(['id','title','description','category','user_id','created_at','updated_at']);
          @endphp
          @forelse ($reports as $report)
            @php $isNew = Carbon::parse($report->updated_at)->gt(now()->subDay()); @endphp
            <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-2xl p-5 shadow-md hover:shadow-2xl transition transform hover:-translate-y-1 animate-fadeIn overflow-hidden">
              <div class="absolute inset-0 bg-green-200/10 rounded-2xl -z-10"></div>
              @if($isNew)
                <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full animate-pulse">NEW</span>
              @endif
              <div class="flex justify-between items-start gap-3">
                <div class="flex flex-col gap-2">
                  <strong class="text-gray-800 text-md animate-pulse">
                    Hello {{ $report->user ? $report->user->name : 'Citizen' }},
                  </strong>
                  <p class="text-gray-700 text-sm">
                    Your report titled <em>"{{ $report->title }}"</em> in the category 
                    <span class="font-semibold text-green-600">{{ $report->category }}</span> 
                    has been successfully resolved by <strong>MDRRMO</strong>.
                  </p>
                  <div class="text-xs text-gray-500 mt-2 space-y-1 flex flex-col">
                    <div class="flex items-center gap-1"><i class="bi bi-calendar-event-fill text-green-600"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1"><i class="bi bi-check2-circle text-green-600"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1">
                      <i class="bi bi-hash text-gray-400"></i> Report ID: <span class="font-mono">{{ $report->id }}</span>
                      <button onclick="navigator.clipboard.writeText('{{ $report->id }}')" class="ml-2 text-xs text-green-600 hover:text-green-700" title="Copy ID"><i class="bi bi-clipboard-fill"></i></button>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <i class="bi bi-check-circle-fill text-green-600 text-3xl animate-ping"></i>
                  <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600 flex items-center gap-1">
                    <i class="bi bi-check-lg"></i> Resolved
                  </span>
                </div>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-sm text-center py-10">No resolved reports available.</p>
          @endforelse
        </div>
      </div>

      <!-- Waste Management Reports -->
      <div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
        <h5 class="text-yellow-600 font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
          <i class="bi bi-trash-fill text-yellow-600"></i> Waste Management Reports
        </h5>
        <div class="overflow-auto space-y-5 flex-1 max-h-[480px]">
          @php
            $wasteReports = \App\Models\ForwardedReport::with('user')->where('category','Waste')->where('status','Resolved')->latest()->get();
          @endphp
          @forelse ($wasteReports as $report)
            <div class="relative group bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 rounded-2xl p-5 shadow-md hover:shadow-2xl transition transform hover:-translate-y-1 animate-fadeIn overflow-hidden">
              <div class="absolute inset-0 bg-yellow-200/10 rounded-2xl -z-10"></div>
              <div class="flex justify-between items-start gap-3">
                <div class="flex flex-col gap-2">
                  <strong class="text-gray-800 text-md animate-pulse">
                    Hello {{ $report->user ? $report->user->name : 'Citizen' }},
                  </strong>
                  <p class="text-gray-700 text-sm">
                    Your waste management report <em>"{{ $report->title }}"</em> has been resolved.
                  </p>
                  <div class="text-xs text-gray-500 mt-2 space-y-1 flex flex-col">
                    <div class="flex items-center gap-1"><i class="bi bi-calendar-event-fill text-yellow-500"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1"><i class="bi bi-check2-circle text-yellow-500"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}</div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <i class="bi bi-check-circle-fill text-yellow-500 text-3xl animate-ping"></i>
                  <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600 flex items-center gap-1">
                    <i class="bi bi-check-lg"></i> Resolved
                  </span>
                </div>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-sm text-center py-10">No waste reports available.</p>
          @endforelse
        </div>
      </div>

    </section>
  </div>
</section>

<!-- Scripts -->
<script>
  // Navbar Mobile Toggle
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navbarLinks = document.getElementById('navbarLinks');
  mobileMenuBtn.addEventListener('click', () => {
    navbarLinks.classList.toggle('hidden');
  });

  // Dropdown toggle
  function toggleDropdown(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
  }

  // Alerts
  function clearBadge() {
    const badge = document.getElementById('alertsBadge');
    if(badge) badge.remove();
  }

  function hideNotifications() {
    const dropdown = document.getElementById('alertsDropdown');
    if(dropdown) dropdown.classList.add('hidden');
    clearBadge();
  }

  // User Logout
  function confirmLogout(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Logout?',
      text: "Are you sure you want to logout?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#16a34a',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Yes, logout'
    }).then((result) => {
      if(result.isConfirmed) document.getElementById('logout-form').submit();
    });
  }

  // Report Modal
  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
  }

  // Alert modal (custom)
  function showAlertModal(id, title, message) {
    Swal.fire({
      title: title,
      text: message,
      icon: 'info',
      confirmButtonColor: '#16a34a',
    });
  }
</script>

</body>
</html>
