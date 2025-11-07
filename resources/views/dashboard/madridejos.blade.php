<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Madridejos Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  

</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<!-- 🌐 Navbar -->
<nav class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-50">
  <!-- Left: Logo + Title -->
  <a href="#" class="flex items-center gap-3">
    <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-200 shadow-sm">
    <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">Madrdejos Dashboard</span>
  </a>

  <!-- 📱 Mobile Menu Toggle -->
  <button 
    id="mobileMenuBtn"
    type="button"
    class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
    aria-controls="navbarLinks"
    aria-expanded="false"
  >
    <i data-lucide="menu" class="w-6 h-6"></i>
  </button>

  <!-- 🌐 Navbar Links -->
 <div 
  id="navbarLinks"
  class="hidden flex-col md:flex md:flex-row items-start md:items-center gap-3 md:gap-5 text-sm 
         absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent 
         shadow-lg md:shadow-none rounded-b-2xl md:rounded-none p-4 md:p-0 z-50 transition-all duration-300"
>

    <!-- 🔔 Alerts Dropdown -->
 
<div class="relative w-full md:w-auto">
<button onclick="toggleDropdown('alertsDropdown'); clearBadge();" 
        class="flex items-center justify-center md:justify-start w-15 h-10 md:w-auto md:px-4 rounded-full hover:bg-gray-100 transition relative text-gray-700">
  <i data-lucide="bell" class="w-5 h-5"></i>
  <span class="ml-2 hidden md:inline">Notifications</span>

  {{-- 🔴 Notification Badge --}}
  @if($mddrmoAcceptedReports->isNotEmpty() || $mddrmoOngoingReports->isNotEmpty() || $mddrmoResolvedReports->isNotEmpty())
    <span id="alertsBadge" 
          class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full shadow inline-flex items-center justify-center">
      {{ $mddrmoAcceptedReports->count() + $mddrmoOngoingReports->count() + $mddrmoResolvedReports->count() }}
    </span>
  @endif
</button>



      <!-- Dropdown -->
      <div id="alertsDropdown" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
        <div class="flex justify-between items-center px-4 py-2 border-b border-gray-200">
          <h6 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Notifications</h6>
          <button onclick="hideNotifications()" class="text-gray-400 hover:text-gray-600 text-sm">Clear All</button>
        </div>

        <div class="max-h-96 overflow-y-auto">
          {{-- System Alerts --}}
          @forelse ($alerts as $alert)
            <div onclick="showAlertModal({{ $alert->id }}, '{{ $alert->title }}', '{{ $alert->message }}')" 
                 class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition">
              <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-blue-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-gray-800 text-sm font-medium">{{ $alert->title }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ $alert->message }}</p>
              </div>
            </div>
          @empty
            <p class="text-gray-400 text-sm text-center py-4">No alerts available.</p>
          @endforelse

          {{-- Reports Notifications --}}
          @foreach(['Resolved Reports' => ['color'=>'purple','data'=>[$mddrmoResolvedReports,$wasteResolvedReports]],
                    'Ongoing Reports' => ['color'=>'blue','data'=>[$mddrmoOngoingReports,$wasteOngoingReports]],
                    'Accepted Reports' => ['color'=>'green','data'=>[$mddrmoAcceptedReports,$wasteAcceptedReports]]] as $group => $groupData)
            @foreach($groupData['data'] as $reports)
              @foreach($reports as $report)
                <div onclick="openReportModal({{ $report->id }}, '{{ $report->title }}', '{{ $report->status }}', '{{ $report->forwarded_to }}')" 
                     class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition bg-{{ $groupData['color'] }}-50 rounded-md m-2">
                  <div class="flex-shrink-0 w-8 h-8 bg-{{ $groupData['color'] }}-400 text-white rounded-full flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-{{ $groupData['color'] }}-700 text-sm font-medium">{{ $report->status }}</p>
                    <p class="text-gray-600 text-xs mt-1">
                      Your report "<span class="font-medium">{{ $report->title }}</span>" 
                      {{ $group == 'Resolved Reports' ? 'was resolved by' : ($group == 'Ongoing Reports' ? 'is being handled by' : 'was forwarded to') }}
                      <span class="font-semibold">{{ $report->forwarded_to }}</span>.
                    </p>
                  </div>
                </div>
              @endforeach
            @endforeach
          @endforeach
        </div>
      </div>
    </div>

    <!-- 📩 Feedback -->
    <a href="{{ route('feedback.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="message-square" class="w-4 h-4"></i>
    <span class="ml-2 block md:inline">Feedback</span>
     
    </a>
<a href="{{ route('eventsandannouncements.madridejos') }}" 
   id="eventsBadgeLink"
   class="relative flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
    <i data-lucide="bell" class="w-4 h-4"></i>
    <span class="ml-2 block md:inline">Events & Announcements</span>

    @if($totalForwardedCount > 0)
        <span id="eventsBadge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-3 -translate-y-1">
            {{ $totalForwardedCount }}
        </span>
    @endif
</a>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const link = document.getElementById('eventsBadgeLink');
    const badge = document.getElementById('eventsBadge');
    const storageKey = 'eventsBadgeLastClicked';
    const now = new Date().getTime();

    // Check if badge was clicked within last 24 hours
    const lastClicked = localStorage.getItem(storageKey);
    if (lastClicked && now - parseInt(lastClicked) < 24 * 60 * 60 * 1000) {
        if(badge) badge.style.display = 'none';
    }

    // Hide badge on click and store timestamp
    link.addEventListener('click', () => {
        if(badge) badge.style.display = 'none';
        localStorage.setItem(storageKey, now);
    });
});
</script>

    <!-- 💬 Support -->
    <a href="{{ route('contact.support.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="life-buoy" class="w-4 h-4"></i>
      <span class="ml-2 block md:inline">Support</span>
    </a>
<button 
  onclick="openModal('reportModal')" 
  class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition font-medium"
>
  <i data-lucide="plus-circle" class="w-4 h-4"></i>
  <span class="ml-2 block">Concern</span>
</button>
<!-- 👤 User Dropdown -->
<div class="relative">
  <button 
    onclick="toggleDropdown('userDropdown')" 
    class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition font-medium"
  >
    <!-- Profile Icon -->
    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
      <i data-lucide="user" class="w-4 h-4 text-gray-700"></i>
    </div>

    <!-- Username -->
    <span class="ml-2 block text-sm sm:text-base">
      {{ Auth::user()->name ?? 'Guest' }}
    </span>

    <!-- Dropdown Arrow -->
    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-600 ml-1"></i>
  </button>

  <!-- Dropdown Menu -->
  <div 
    id="userDropdown" 
    class="hidden absolute left-1/2 -translate-x-1/2 top-full mt-3 
           bg-white shadow-xl rounded-xl w-[90vw] sm:w-64 max-w-sm 
           overflow-hidden border border-gray-100 z-50 transform transition-all duration-200"
  >

    <!-- ✅ Desktop Info Section -->
    <div class="hidden sm:block px-3 py-2 bg-gray-50 text-xs sm:text-sm text-center leading-tight">
      <p class="font-semibold truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
      <p class="text-gray-500 truncate">{{ Auth::user()->email ?? 'No Email' }}</p>
      <p class="text-gray-400 truncate">{{ Auth::user()->location ?? 'No Location' }}</p>
    </div>

    <!-- 🚀 Logout (Visible on All Devices, but main item on Mobile) -->
    <button 
      onclick="confirmLogout(event)" 
      class="flex items-center justify-center gap-2 px-4 py-2 text-sm 
             text-red-600 hover:bg-red-50 w-full text-center transition"
    >
      <i data-lucide="log-out" class="w-4 h-4"></i> Logout
    </button>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
  </div>
</div>
</div>   
</nav>         
<!-- 🌟 Hero Section -->
<section class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-r from-green-50 to-lime-50">
  <!-- Background blobs -->
  <div class="absolute top-0 left-0 w-40 md:w-56 h-40 md:h-56 bg-green-200 rounded-full opacity-30 blur-2xl -z-10"></div>
  <div class="absolute top-0 right-0 w-60 md:w-80 h-60 md:h-80 bg-lime-200 rounded-full opacity-30 blur-2xl -z-10"></div>

  <div class="px-6 md:px-8 flex flex-col lg:flex-row gap-10 items-start">
    <!-- Left Column: Hero Text -->
    <div class="lg:w-1/2 max-w-xl flex flex-col justify-center">
      <h1 class="text-3xl md:text-5xl font-extrabold mb-3 md:mb-4 leading-tight text-gray-900">
        Welcome, <span class="text-green-700">{{ Auth::user()->name ?? 'Guest' }}</span>
      </h1>
      <h2 class="text-xl md:text-2xl font-semibold mb-4 text-gray-700">Madridejos 911</h2>
      <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
        Empowering citizen participation through transparent and accessible platforms,  
        fostering evidence-based decision-making for the community.
      </p>
      
    </div>
<!-- Right Column: Resolved MDRRMO Reports Grid -->
<section class="grid lg:grid-cols-2 gap-6 lg:w-1/2">
@forelse ($mddrmoResolvedReports as $report)
  @php $isNew = \Carbon\Carbon::parse($report->updated_at)->gt(now()->subDay()); @endphp
  <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-2xl p-5 shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate-fadeIn">
    <div class="absolute inset-0 bg-green-200/10 rounded-2xl -z-10"></div>

    @if($isNew)
      <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full animate-pulse">NEW</span>
    @endif

    <div class="flex justify-between items-start gap-3">
      <div class="flex flex-col gap-2">
        <strong class="text-gray-800 text-md animate-pulse">
          Hello {{ $report->user ? $report->user->name : 'Citizen' }} (ID: {{ $report->user_id }})
        </strong>

        <p class="text-gray-700 text-sm">
          Your report titled <em>"{{ $report->title }}"</em> in the category 
          <span class="font-semibold text-green-600">{{ $report->category }}</span> 
          has been successfully resolved.
        </p>

        <div class="text-xs text-gray-500 mt-2 space-y-1 flex flex-col">
          <div class="flex items-center gap-1">
            <i data-lucide="calendar" class="w-4 h-4 text-green-600"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}
          </div>
          <div class="flex items-center gap-1">
            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}
          </div>
          <div class="flex items-center gap-1">
            <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i> Report ID: <span class="font-mono">{{ $report->id }}</span>
            <button onclick="navigator.clipboard.writeText('{{ $report->id }}')" class="ml-2 text-xs text-green-600 hover:text-green-700" title="Copy ID">
              <i data-lucide="clipboard" class="w-4 h-4"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="flex flex-col items-end gap-2">
        <i data-lucide="check-circle" class="text-green-600 w-8 h-8 animate-ping"></i>
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600 flex items-center gap-1">
          <i data-lucide="tag" class="w-3 h-3"></i> {{ $report->category }}
        </span>
      </div>
    </div>

    <div class="mt-4 flex gap-2 justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-500">
      <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700 flex items-center gap-1 animate-bounce">
        <i data-lucide="eye" class="w-4 h-4"></i> View Details
      </button>
<button onclick="window.location='{{ route('feedback.page', ['report' => $report->id]) }}'" 
        class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs hover:bg-green-200 flex items-center gap-1 animate-pulse">
    <i data-lucide="message-circle" class="w-4 h-4"></i> Send Feedback
</button>

    </div>
  </div>
@empty
  <p class="text-gray-500 text-sm text-center py-10">No resolved reports available.</p>
@endforelse


<!-- Waste Management Resolved Reports -->
<div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
  <h5 class="text-yellow-600 font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
    <i data-lucide="refresh-cw" class="w-5 h-5 text-yellow-600"></i> Waste Management Resolved Reports
  </h5>

  <div class="overflow-auto space-y-5 flex-1" style="max-height: 480px;">

    @forelse ($wasteResolvedReports as $report)
      @php $isNew = \Carbon\Carbon::parse($report->updated_at)->gt(now()->subDay()); @endphp
      <div class="relative group bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 rounded-2xl p-5 shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate-fadeIn">
        <div class="absolute inset-0 bg-yellow-200/10 rounded-2xl -z-10"></div>

        @if($isNew)
          <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">NEW</span>
        @endif

        <div class="flex justify-between items-start gap-3">
          <div class="flex flex-col gap-2">
            <strong class="text-gray-800 text-md animate-pulse">
              Hello {{ $report->user ? $report->user->name : 'Citizen' }},
            </strong>
            <p class="text-gray-700 text-sm">
              Your report titled <em>"{{ $report->title }}"</em> in the category 
              <span class="font-semibold text-yellow-600">{{ $report->category }}</span> 
              has been successfully resolved by <strong>Waste Management</strong>.
            </p>
            <div class="text-xs text-gray-500 mt-2 space-y-1 flex flex-col">
              <div class="flex items-center gap-1">
                <i data-lucide="calendar" class="w-4 h-4 text-yellow-600"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}
              </div>
              <div class="flex items-center gap-1">
                <i data-lucide="check-circle" class="w-4 h-4 text-yellow-500"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}
              </div>
              <div class="flex items-center gap-1">
                <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i> Report ID: <span class="font-mono">{{ $report->id }}</span>
                <button onclick="navigator.clipboard.writeText('{{ $report->id }}')" class="ml-2 text-xs text-yellow-500 hover:text-yellow-700" title="Copy ID">
                  <i data-lucide="clipboard" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="flex flex-col items-end gap-2">
            <i data-lucide="check-circle" class="text-yellow-500 w-8 h-8 animate-ping"></i>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600 flex items-center gap-1">
              <i data-lucide="tag" class="w-3 h-3"></i> {{ $report->category }}
            </span>
          </div>
        </div>

        <div class="mt-4 flex gap-2 justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-500">
          <button class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-yellow-600 flex items-center gap-1 animate-bounce">
            <i data-lucide="eye" class="w-4 h-4"></i> View Details
          </button>
          <button class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs hover:bg-yellow-200 flex items-center gap-1 animate-pulse">
            <i data-lucide="message-circle" class="w-4 h-4"></i> Send Feedback
          </button>
        </div>
      </div>
    @empty
      <p class="text-gray-500 text-sm text-center py-10">No resolved waste reports available.</p>
    @endforelse

  </div>
</div>
  </div>  
 
  <!-- Background blobs -->
  <div class="absolute top-0 left-0 w-40 h-40 bg-green-200 rounded-full opacity-30 blur-3xl -z-10 animate-pulse"></div>
  <div class="absolute bottom-0 right-0 w-60 h-60 bg-lime-200 rounded-full opacity-20 blur-3xl -z-10 animate-pulse"></div>

  <div class="container mx-auto px-6 lg:px-20">
    <!-- Section Header -->
    <div class="text-center mb-12">
     
      <p class="text-gray-600 text-lg md:text-xl animate-fadeInUp delay-200">Empowering our community through information and services.</p>
    </div>

    <!-- Citizen Symbols Grid -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
  <!-- Citizen Icon 1 -->
  <div class="flex flex-col items-center text-center animate-fadeInUp delay-300">
    <img src="{{ asset('images/commu.png') }}" alt="Community" class="w-32 h-32 mb-4 rounded-full border-4 border-green-200 p-2">
    <h3 class="text-xl font-semibold text-green-700">Community</h3>
    <p class="text-gray-500 text-sm">Collaborative citizen engagement.</p>
  </div>

  <!-- Citizen Icon 2 -->
  <div class="flex flex-col items-center text-center animate-fadeInUp delay-400">
    <img src="{{ asset('images/indi.png') }}" alt="Individual" class="w-32 h-32 mb-4 rounded-full border-4 border-green-200 p-2">
    <h3 class="text-xl font-semibold text-green-700">Individual</h3>
    <p class="text-gray-500 text-sm">Empowering each citizen’s voice.</p>
  </div>

  <!-- Citizen Icon 3 -->
  <div class="flex flex-col items-center text-center animate-fadeInUp delay-500">
    <img src="{{ asset('images/govern.png') }}" alt="Governance" class="w-32 h-32 mb-4 rounded-full border-4 border-green-200 p-2">
    <h3 class="text-xl font-semibold text-green-700">Governance</h3>
    <p class="text-gray-500 text-sm">Transparent, accessible government services.</p>
  </div>

  <!-- Citizen Icon 4 -->
  <div class="flex flex-col items-center text-center animate-fadeInUp delay-600">
    <img src="{{ asset('images/sip.png') }}" alt="Support" class="w-32 h-32 mb-4 rounded-full border-4 border-green-200 p-2">
    <h3 class="text-xl font-semibold text-green-700">Support</h3>
    <p class="text-gray-500 text-sm">Assistance and resources for all citizens.</p>
  </div>
</div>


  <style>
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
      animation: fadeInUp 0.8s forwards;
    }
    /* Stagger delay using Tailwind-style classes */
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-600 { animation-delay: 0.6s; }
  </style>
</section>

      
    </div>
<!-- 📌 Submit Concern Modal -->
<div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 animate-fadeIn">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Submit Concern</h3>
      <button onclick="closeModal('reportModal')" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
    </div>

    <form id="submitConcernForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
          <option value="" disabled selected>Select category</option>
          <option>Road Issue</option>
          <option>Water Management</option>
          <option>Waste Management</option>
          <option>Fire Management</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="E.g. Broken streetlight" required>
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="Describe your concern..." required></textarea>
      </div>

    
      <div class="mb-3">
  <label class="block text-sm font-medium text-gray-700">Upload Photo (Optional)</label>
  <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/jpg, image/gif" 
         class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
  <p class="text-xs text-gray-500 mt-1">Max size: 2MB. Allowed types: png, jpg, jpeg, gif.</p>
</div>

      <div class="flex justify-end gap-3 pt-4 border-t">
        <button type="button" onclick="closeModal('reportModal')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const form = document.getElementById('submitConcernForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Stop default submission first

    Swal.fire({
      title: 'Submit Concern?',
      text: "Are you sure all details are correct?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#16a34a',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Submit'
    }).then((result) => {
      if (result.isConfirmed) {
        // Submit the form to backend
        form.submit();

        // Optional: show success message
        Swal.fire({
          title: 'Submitted!',
          text: 'Your concern has been sent successfully.',
          icon: 'success',
          confirmButtonColor: '#16a34a'
        });
      }
    });
  });
const photoInput = document.getElementById('photo');
  photoInput.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(file.type)) {
      alert('Invalid file type. Only PNG, JPG, JPEG, GIF allowed.');
      this.value = '';
    } else if (file.size > maxSize) {
      alert('File is too large. Maximum 2MB allowed.');
      this.value = '';
    }
  });
  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
  }
</script>
<!-- 📱 Mobile-Optimized Report Progress Modal -->
<div id="reportProgressModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-2 sm:p-4">
  <div class="bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg sm:max-w-xl p-4 sm:p-6 relative text-gray-100 overflow-y-auto max-h-[90vh] sm:max-h-[85vh]">

    <!-- Close button -->
    <button onclick="closeReportModal()" 
      class="absolute top-3 right-3 text-gray-400 hover:text-white transition text-lg sm:text-xl">✖</button>

    <!-- Header -->
    <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white mb-2 text-center sm:text-left">
      Report Progress
    </h2>
    <p class="text-xs sm:text-sm text-gray-400 mb-4 sm:mb-6 text-center sm:text-left">
      Track your report in real-time with animated progress updates
    </p>

    <!-- Report Info -->
    <div class="bg-gray-800 rounded-lg p-3 sm:p-4 mb-5 border border-gray-700 text-sm sm:text-base">
      <p class="text-gray-400 text-xs sm:text-sm">Report Title:</p>
      <h3 id="modalReportTitle" class="text-sm sm:text-base font-semibold text-white break-words"></h3>
      <p class="text-gray-400 text-xs sm:text-sm mt-2">Forwarded to: 
        <span id="modalDepartment" class="font-medium text-white"></span>
      </p>
    </div>

    <!-- Timeline Container -->
    <div class="relative pl-10 sm:pl-12">
      <!-- Timeline line -->
      <div id="timelineLine" class="absolute left-4 sm:left-6 top-3 w-1 bg-gray-700 h-full rounded"></div>
      <div id="timelineFill" class="absolute left-4 sm:left-6 top-3 w-1 bg-gradient-to-b from-green-400 via-blue-400 via-yellow-400 to-purple-400 h-0 rounded transition-all duration-1000"></div>

      <!-- Timeline Steps -->
      <div class="timeline-step-block relative flex items-start mb-8 sm:mb-10" data-step="Forwarded">
        <div class="absolute -left-6 sm:-left-6 flex flex-col items-center">
          <div id="stepForwarded" class="timeline-step w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-[10px] sm:text-xs">→</i>
          </div>
        </div>
        <div class="ml-4 sm:ml-6">
          <p class="font-semibold text-green-400 text-base sm:text-lg">Report Forwarded</p>
          <p class="text-gray-400 text-xs sm:text-sm mt-1">Your report has been forwarded to the responsible department for review.</p>
          <p id="forwardedTime" class="text-[10px] sm:text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start mb-8 sm:mb-10" data-step="Accepted">
        <div class="absolute -left-6 sm:-left-6 flex flex-col items-center">
          <div id="stepAccepted" class="timeline-step w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-[10px] sm:text-xs">✓</i>
          </div>
        </div>
        <div class="ml-4 sm:ml-6">
          <p class="font-semibold text-blue-400 text-base sm:text-lg">Report Accepted</p>
          <p class="text-gray-400 text-xs sm:text-sm mt-1">The department has reviewed and accepted your report for action.</p>
          <p id="acceptedTime" class="text-[10px] sm:text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start mb-8 sm:mb-10" data-step="Ongoing">
        <div class="absolute -left-6 sm:-left-6 flex flex-col items-center">
          <div id="stepOngoing" class="timeline-step w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-[10px] sm:text-xs">⏳</i>
          </div>
        </div>
        <div class="ml-4 sm:ml-6">
          <p class="font-semibold text-yellow-400 text-base sm:text-lg">Action Ongoing</p>
          <p class="text-gray-400 text-xs sm:text-sm mt-1">The department is actively working on resolving your reported issue.</p>
          <p id="ongoingTime" class="text-[10px] sm:text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start" data-step="Resolved">
        <div class="absolute -left-6 sm:-left-6 flex flex-col items-center">
          <div id="stepResolved" class="timeline-step w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-[10px] sm:text-xs">✔</i>
          </div>
        </div>
        <div class="ml-4 sm:ml-6">
          <p class="font-semibold text-purple-400 text-base sm:text-lg">Report Resolved</p>
          <p class="text-gray-400 text-xs sm:text-sm mt-1">The issue has been successfully resolved and verified by the department.</p>
          <p id="resolvedTime" class="text-[10px] sm:text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <!-- Particle Container -->
      <div id="particlesContainer" class="absolute left-0 top-0 w-full h-full pointer-events-none"></div>
    </div>
  </div>
</div>

<script>
function openReportModal(id, title, status, department, timestamps = {}) {
  const modal = document.getElementById("reportProgressModal");
  modal.classList.remove("hidden");
  modal.classList.add("flex");

  document.getElementById("modalReportTitle").innerText = title;
  document.getElementById("modalDepartment").innerText = department;

  document.getElementById("forwardedTime").innerText = timestamps.forwarded || '--';
  document.getElementById("acceptedTime").innerText = timestamps.accepted || '--';
  document.getElementById("ongoingTime").innerText = timestamps.ongoing || '--';
  document.getElementById("resolvedTime").innerText = timestamps.resolved || '--';

  const stepsOrder = ["Forwarded","Accepted","Ongoing","Resolved"];
  const colors = {"Forwarded":"bg-green-400","Accepted":"bg-blue-400","Ongoing":"bg-yellow-400","Resolved":"bg-purple-400"};
  const timelineFill = document.getElementById("timelineFill");
  const stepBlocks = document.querySelectorAll(".timeline-step-block");
  const particleContainer = document.getElementById("particlesContainer");
  particleContainer.innerHTML = '';

  stepsOrder.forEach((s, i) => {
    const stepEl = document.getElementById("step"+s);
    const block = stepEl.closest(".timeline-step-block");
    const top = block.offsetTop + stepEl.offsetHeight/2;

    if(stepsOrder.indexOf(s) <= stepsOrder.indexOf(status)){
      setTimeout(() => {
        stepEl.classList.add(colors[s]);
        stepEl.classList.add("border-transparent");
        stepEl.querySelector("i").classList.add("text-white");
        stepEl.classList.add("scale-110");
        setTimeout(()=> stepEl.classList.remove("scale-110"), 300);

        timelineFill.style.height = (top) + "px";

        for(let j=0;j<5;j++){
          const p = document.createElement("div");
          p.className = "w-1 h-1 rounded-full absolute animate-bounce";
          p.style.left = (stepEl.offsetLeft + 6 + Math.random()*10) + "px";
          p.style.top = (top - 6 + Math.random()*10) + "px";
          p.style.backgroundColor = window.getComputedStyle(stepEl).backgroundColor;
          particleContainer.appendChild(p);
        }
      }, i*400);
    }
  });
}

function closeReportModal() {
  const modal = document.getElementById("reportProgressModal");
  modal.classList.add("hidden");
  modal.classList.remove("flex");
}
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  if (window.lucide) lucide.createIcons();

  const mobileMenuBtn = document.getElementById("mobileMenuBtn");
  const navbarLinks = document.getElementById("navbarLinks");
  const alertsBadge = document.getElementById("alertsBadge");

  // ✅ Toggle mobile menu
  mobileMenuBtn.addEventListener("click", (event) => {
    event.stopPropagation(); // Prevent document click
    navbarLinks.classList.toggle("hidden");
    navbarLinks.classList.toggle("flex");
  });

  // ✅ Close mobile menu when clicking outside
  document.addEventListener("click", (event) => {
    const isClickInsideMenu = navbarLinks.contains(event.target);
    const isClickOnButton = mobileMenuBtn.contains(event.target);
    if (!isClickInsideMenu && !isClickOnButton) {
      navbarLinks.classList.add("hidden");
      navbarLinks.classList.remove("flex");
    }
  });
// Show badge if alerts not cleared
if (alertsBadge) {
  if (localStorage.getItem("alertsCleared") === "true") {
    alertsBadge.style.display = "none";
  } else {
    alertsBadge.style.display = "inline-flex"; // ensures badge is visible
  }
}

  // ✅ Close dropdowns when clicking outside
  document.addEventListener("click", (e) => {
    document.querySelectorAll("[id$='Dropdown']").forEach((dropdown) => {
      const trigger = dropdown.previousElementSibling;
      if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
        dropdown.classList.add("hidden");
      }
    });
  });
});

// ✅ Toggle dropdown function
function toggleDropdown(id) {
  const dropdown = document.getElementById(id);
  if (!dropdown) return;
  const isOpen = !dropdown.classList.contains("hidden");
  document.querySelectorAll("[id$='Dropdown']").forEach(el => el.classList.add("hidden"));
  if (!isOpen) dropdown.classList.remove("hidden");
}

// ✅ Open / Close modal
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    lucide.createIcons();
  }
}
function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }
}

// ✅ Clear notification badge
function clearBadge() {
  const badge = document.getElementById("alertsBadge");
  if (badge) {
    badge.style.display = "none";
    localStorage.setItem("alertsCleared", "true");
  }
}

// ✅ Logout confirmation
function confirmLogout(event) {
  event.preventDefault();
  Swal.fire({
    title: "Logout Confirmation",
    text: "Do you really want to logout?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#16a34a",
    cancelButtonColor: "#9ca3af",
    confirmButtonText: "Logout",
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById("logout-form")?.submit();
    }
  });
}
</script>

</body>
</html>
