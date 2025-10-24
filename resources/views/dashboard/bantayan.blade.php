<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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

  <!-- Mobile menu toggle -->
  <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
    <i data-lucide="menu" class="w-6 h-6"></i>
  </button>

  <div id="navbarLinks" class="hidden md:flex md:flex-row items-center gap-4 md:gap-5 w-full md:w-auto absolute md:static top-full left-0 bg-white md:bg-transparent shadow-lg md:shadow-none rounded-xl md:rounded-none p-4 md:p-0 border md:border-0 transition-all duration-300">
    
    <!-- Alerts -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('alertsDropdown'); clearBadge();" 
              class="flex items-center justify-start md:justify-center gap-2 w-full md:w-auto rounded-lg px-3 py-2 hover:bg-gray-100 transition text-gray-700 font-medium relative">
        <i data-lucide="bell" class="w-5 h-5"></i>
        <span>Notifications</span>
        @php 
          $totalAlerts = $alerts->count() 
                        + $mddrmoAcceptedReports->count() + $wasteAcceptedReports->count()
                        + $mddrmoOngoingReports->count() + $wasteOngoingReports->count()
                        + $mddrmoResolvedReports->count() + $wasteResolvedReports->count(); 
        @endphp
        @if($totalAlerts > 0)
          <span id="alertsBadge" class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full shadow">{{ $totalAlerts }}</span>
        @endif
      </button>

      <div id="alertsDropdown" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
        <div class="flex justify-between items-center px-4 py-2 border-b border-gray-200">
          <h6 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Notifications</h6>
          <button onclick="hideNotifications()" class="text-gray-400 hover:text-gray-600 text-sm">Clear All</button>
        </div>
        <div class="max-h-96 overflow-y-auto">
          @forelse ($alerts as $alert)
            <div onclick="showAlertModal({{ $alert->id }}, '{{ $alert->title }}', '{{ $alert->message }}')" 
                 class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition">
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

    <!-- Menu Links -->
    <a href="{{ route('feedback.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition w-full md:w-auto px-3 py-2 rounded-lg hover:bg-gray-100">
      <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
    </a>
    <a href="{{ route('contact.support.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition w-full md:w-auto px-3 py-2 rounded-lg hover:bg-gray-100">
      <i data-lucide="life-buoy" class="w-4 h-4"></i> Support
    </a>
    <button onclick="openModal('reportModal')" 
            class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full font-semibold text-gray-800 shadow-sm transition">
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
        Empowering citizen participation through transparent and accessible platforms,  
        fostering evidence-based decision-making for the community.
      </p>
      <button class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold shadow-md hover:bg-green-700 transition transform hover:scale-105">
        Learn More
      </button>
    </div>

    <!-- Reports Grid -->
    <div class="grid lg:grid-cols-2 gap-6 lg:w-1/2">

      <!-- MDRRMO Resolved Reports -->
      <div class="bg-white shadow-md rounded-xl p-4 flex flex-col gap-3 hover:shadow-xl transition">
        <div class="flex items-center gap-2">
          <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
          <h3 class="font-semibold text-gray-800">Resolved Reports</h3>
        </div>
        <p class="text-gray-500 text-sm">Total: {{ $mddrmoResolvedReports->count() }}</p>
        <button onclick="openReportModal('resolvedReports', 'Resolved Reports', 'Resolved', 'MDRRMO')" 
                class="mt-auto self-start px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">
          View
        </button>
      </div>

      <!-- Forwarded Reports -->
      <div class="bg-white shadow-md rounded-xl p-4 flex flex-col gap-3 hover:shadow-xl transition">
        <div class="flex items-center gap-2">
          <i data-lucide="arrow-right-circle" class="w-5 h-5 text-blue-600"></i>
          <h3 class="font-semibold text-gray-800">Forwarded Reports</h3>
        </div>
        <p class="text-gray-500 text-sm">Total: {{ $forwardedReports->count() }}</p>
        <button onclick="openReportModal('forwardedReports', 'Forwarded Reports', 'Forwarded', 'MDRRMO')" 
                class="mt-auto self-start px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition">
          View
        </button>
      </div>

    </div>
  </div>
</section>

<!-- Modals -->
@include('partials.report-modal') <!-- Load your report modal Blade partial -->

<!-- Scripts -->
<script>
  // Lucide Icons
  document.addEventListener("DOMContentLoaded", () => lucide.createIcons());

  // Mobile Navbar Toggle
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navbarLinks = document.getElementById('navbarLinks');

  mobileMenuBtn?.addEventListener('click', () => {
    navbarLinks.classList.toggle('hidden');
  });

  // Dropdown Toggle
  function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.classList.toggle('hidden');
  }

  // Logout
  function confirmLogout(event){
    event.preventDefault();
    if(confirm("Are you sure you want to logout?")){
      document.getElementById('logout-form').submit();
    }
  }

  // Alerts
  function clearBadge(){
    const badge = document.getElementById('alertsBadge');
    if(badge) badge.style.display = 'none';
  }

  function hideNotifications(){
    const dropdown = document.getElementById('alertsDropdown');
    if(dropdown) dropdown.classList.add('hidden');
    clearBadge();
  }

  // Report Modal
  function openReportModal(id, title, status, department){
    const modal = document.getElementById('reportProgressModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('modalReportTitle').innerText = title;
    document.getElementById('modalDepartment').innerText = department;

    // Timeline animation logic
    const timelineContainer = document.getElementById('modalTimeline');
    timelineContainer.innerHTML = ''; // Clear previous particles
    const steps = timelineContainer.querySelectorAll('.step');
    steps.forEach(step => {
      for(let i=0; i<3; i++){
        const p = document.createElement('div');
        p.className = 'w-2 h-2 bg-green-600 rounded-full absolute animate-pulse';
        const rect = step.getBoundingClientRect();
        const containerRect = timelineContainer.getBoundingClientRect();
        p.style.left = (rect.left - containerRect.left + rect.width/2 + Math.random()*6 - 3) + 'px';
        p.style.top = (rect.top - containerRect.top + rect.height/2 + Math.random()*6 - 3) + 'px';
        timelineContainer.appendChild(p);
      }
    });
  }

  function closeReportModal(){
    const modal = document.getElementById('reportProgressModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
</body>
</html>
