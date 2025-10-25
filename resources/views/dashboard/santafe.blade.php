<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Santa.Fe Full Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<!-- Navbar -->
<nav class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-50">
  <a href="#" class="flex items-center gap-3">
    <img src="{{ asset('images/citizen.png') }}" alt="Logo"
         class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-200 shadow-sm">
    <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">Santa.Fe Dashboard</span>
  </a>

  <button id="mobileMenuBtn" type="button" aria-label="Toggle menu"
          class="md:hidden p-2 rounded-xl text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
    <i data-lucide="menu" class="w-6 h-6"></i>
  </button>

  <div id="navbarLinks"
       class="hidden md:flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-5 flex-wrap text-sm absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-md md:shadow-none rounded-b-2xl md:rounded-none p-5 md:p-0 transition-all duration-300 ease-in-out origin-top">

    <!-- Notifications -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('alertsDropdown'); clearBadge();"
              class="flex items-center gap-2 w-full md:w-auto text-gray-700 hover:text-green-700 transition font-medium">
        <i data-lucide="bell" class="w-5 h-5"></i> Notifications
        @php 
          $totalAlerts = $alerts->count() 
                        + $mddrmoAcceptedReports->count() + $wasteAcceptedReports->count()
                        + $mddrmoOngoingReports->count() + $wasteOngoingReports->count()
                        + $mddrmoResolvedReports->count() + $wasteResolvedReports->count(); 
        @endphp
        @if($totalAlerts > 0)
          <span id="alertsBadge"
                class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full shadow">
            {{ $totalAlerts }}
          </span>
        @endif
      </button>

      <div id="alertsDropdown"
           class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
        <div class="flex justify-between items-center px-4 py-2 border-b border-gray-200">
          <h6 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Notifications</h6>
          <button onclick="hideNotifications()" class="text-gray-400 hover:text-gray-600 text-sm">Clear All</button>
        </div>
        <div class="max-h-96 overflow-y-auto">
          @forelse ($alerts as $alert)
            <div onclick="showAlertModal({{ $alert->id }}, '{{ $alert->title }}', '{{ $alert->message }}')" 
                 class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="text-blue-600" data-lucide="alert-triangle"></i>
              </div>
              <div>
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

    <a href="{{ route('feedback.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
    </a>

    <a href="{{ route('contact.support.page') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="life-buoy" class="w-4 h-4"></i> Support
    </a>

    <button onclick="openModal('reportModal')" 
            class="w-full md:w-auto bg-green-100 hover:bg-green-200 px-4 py-2 rounded-full font-semibold text-green-700 shadow-sm transition">
      + Concern
    </button>

    <!-- User Dropdown -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('userDropdown')"
              class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition w-full md:w-auto font-medium">
        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
          <i data-lucide="user" class="w-4 h-4"></i>
        </div>
        <span class="hidden md:inline">{{ Auth::user()->name ?? 'Guest' }}</span>
        <i data-lucide="chevron-down" class="w-4 h-4"></i>
      </button>

      <div id="userDropdown"
           class="hidden absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-64 overflow-hidden border border-gray-100 z-50">
        <div class="px-5 py-4 bg-gray-50">
          <p class="font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
          <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? 'No Email' }}</p>
          <p class="text-gray-400 text-sm">{{ Auth::user()->location ?? 'No Location' }}</p>
        </div>
        <div class="border-t">
          <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
            <i data-lucide="settings" class="w-4 h-4"></i> Settings
          </a>
          <button onclick="confirmLogout(event)"
                  class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition">
            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
          </button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-r from-green-50 to-lime-50">
  <div class="absolute top-0 left-0 w-40 md:w-56 h-40 md:h-56 bg-green-200 rounded-full opacity-30 blur-2xl -z-10"></div>
  <div class="absolute top-0 right-0 w-60 md:w-80 h-60 md:h-80 bg-lime-200 rounded-full opacity-30 blur-2xl -z-10"></div>

  <div class="px-6 md:px-8 flex flex-col lg:flex-row gap-10 items-start">
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

    <section class="grid lg:grid-cols-2 gap-6 lg:w-1/2">

      <!-- MDRRMO Reports -->
      <div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
        <h5 class="text-success font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
          <i class="bi bi-megaphone-fill text-success"></i> MDRRMO Resolved Reports
        </h5>
        <div class="overflow-auto space-y-5 flex-1" style="max-height: 480px;">
          @php
            use Carbon\Carbon;
            $reports = \App\Models\ForwardedReport::with('user')
                        ->where('location', 'Santa.Fe')
                        ->where('status', 'Resolved')
                        ->latest()
                        ->get();
          @endphp

          @forelse ($reports as $report)
            @php $isNew = Carbon::parse($report->updated_at)->gt(now()->subDay()); @endphp
            <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-success rounded-2xl p-5 shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate-fadeIn">
              <div class="absolute inset-0 bg-green-200/10 rounded-2xl -z-10"></div>
              @if($isNew)
                <span class="absolute top-3 right-3 bg-success text-white text-xs px-2 py-1 rounded-full animate-pulse">NEW</span>
              @endif
              <div class="flex justify-between items-start gap-3">
                <div class="flex flex-col gap-2">
                  <strong class="text-gray-800 text-md animate-pulse">
                    Hello {{ $report->user ? $report->user->name : 'Citizen' }},
                  </strong>
                  <p class="text-gray-700 text-sm">
                    Your report titled <em>"{{ $report->title }}"</em> in <span class="font-semibold text-success">{{ $report->category }}</span> has been resolved.
                  </p>
                  <div class="text-xs text-gray-500 mt-2 space-y-1 flex flex-col">
                    <div class="flex items-center gap-1"><i class="bi bi-calendar-event-fill text-green-600"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1"><i class="bi bi-check2-circle text-success"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1">
                      <i class="bi bi-hash text-gray-400"></i> Report ID: <span class="font-mono">{{ $report->id }}</span>
                      <button onclick="navigator.clipboard.writeText('{{ $report->id }}')" class="ml-2 text-xs text-success hover:text-success/70" title="Copy ID">
                        <i class="bi bi-clipboard-fill"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <i class="bi bi-check-circle-fill text-success text-3xl animate-ping"></i>
                  <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/30 text-success flex items-center gap-1">
                    <i class="bi bi-tag-fill"></i> {{ $report->category }}
                  </span>
                </div>
              </div>
              <div class="mt-4 flex gap-2 justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <button class="bg-success text-white px-3 py-1 rounded-lg text-xs hover:bg-success/80 flex items-center gap-1 animate-bounce">
                  <i class="bi bi-eye-fill"></i> View
                </button>
                <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs hover:bg-green-200 flex items-center gap-1 animate-pulse">
                  <i class="bi bi-chat-left-text-fill"></i> Comment
                </button>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-center py-6">No resolved reports yet.</p>
          @endforelse
        </div>
      </div>

      <!-- Waste Reports Column -->
      <div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
        <h5 class="text-warning font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
          <i class="bi bi-trash-fill text-warning"></i> Waste Ongoing Reports
        </h5>
        <div class="overflow-auto space-y-5 flex-1" style="max-height: 480px;">
          @php
            $wasteReports = \App\Models\WasteReport::with('user')
                                ->where('location', 'Santa.Fe')
                                ->where('status', 'Ongoing')
                                ->latest()
                                ->get();
          @endphp
          @forelse ($wasteReports as $report)
            <div class="relative group bg-yellow-50 border-l-4 border-warning rounded-2xl p-5 shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate-fadeIn">
              <div class="absolute inset-0 bg-yellow-100/10 rounded-2xl -z-10"></div>
              <div class="flex justify-between items-start gap-3">
                <div class="flex flex-col gap-2">
                  <strong class="text-gray-800 text-md">{{ $report->user ? $report->user->name : 'Citizen' }}</strong>
                  <p class="text-gray-700 text-sm">Report: <em>{{ $report->title }}</em> - {{ $report->category }}</p>
                  <div class="text-xs text-gray-500 mt-2">
                    <div>Submitted: {{ $report->created_at->format('M d, Y h:i A') }}</div>
                    <div>Status: {{ $report->status }}</div>
                    <div>ID: {{ $report->id }}</div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/30 text-warning">{{ $report->category }}</span>
                </div>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-center py-6">No ongoing waste reports.</p>
          @endforelse
        </div>
      </div>

    </section>
  </div>
</section>
<!-- Report Modal -->
<div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 animate-fadeIn">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Submit Concern</h3>
      <button onclick="closeModal('reportModal')" class="text-gray-500 hover:text-gray-800">
        <i data-lucide="x"></i>
      </button>
    </div>
    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Title</label>
        <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
      </div>
      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Category</label>
        <select name="category" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
          <option value="">Select Category</option>
          <option value="Health">Health</option>
          <option value="Environment">Environment</option>
          <option value="Safety">Safety</option>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
      </div>
      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Photo (Optional)</label>
        <input type="file" name="photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-green-100 file:text-green-700 hover:file:bg-green-200 transition">
      </div>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeModal('reportModal')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script>
  function toggleDropdown(id) {
    document.getElementById(id).classList.toggle('hidden');
  }

  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
  }

  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
  }

  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Logout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'Cancel',
      iconColor: '#16a34a',
      confirmButtonColor: '#16a34a',
    }).then((result) => {
      if(result.isConfirmed) document.getElementById('logout-form').submit();
    });
  }

  function clearBadge() {
    const badge = document.getElementById('alertsBadge');
    if(badge) badge.classList.add('hidden');
  }

  function hideNotifications() {
    const dropdown = document.getElementById('alertsDropdown');
    if(dropdown) dropdown.classList.add('hidden');
  }

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
