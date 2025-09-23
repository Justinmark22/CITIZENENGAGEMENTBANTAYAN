<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sta.Fe Dashboard</title>
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
    <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">Santa.Fe Dashboard</span>
  </a>

  <!-- Mobile menu toggle -->
  <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
    <i data-lucide="menu" class="w-6 h-6"></i>
  </button>

  <!-- Right side items -->
  <div id="navbarLinks" class="hidden md:flex items-center gap-4 md:gap-5 flex-wrap text-sm absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-md md:shadow-none rounded-b-2xl md:rounded-none p-4 md:p-0">
    
<!-- 🔔 Alerts Dropdown -->
<div class="relative w-full md:w-auto">
  <button onclick="toggleDropdown('alertsDropdown'); clearBadge();" 
          class="flex items-center justify-center md:justify-start w-10 h-10 md:w-auto md:px-4 rounded-full hover:bg-gray-100 transition relative text-gray-700">
    <i data-lucide="bell" class="w-5 h-5"></i>Notifications
    @php 
      $totalAlerts = $alerts->count() 
                    + $mddrmoAcceptedReports->count() + $wasteAcceptedReports->count()
                    + $mddrmoOngoingReports->count() + $wasteOngoingReports->count()
                    + $mddrmoResolvedReports->count() + $wasteResolvedReports->count(); 
    @endphp
    @if($totalAlerts > 0)
      <span id="alertsBadge" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full shadow">{{ $totalAlerts }}</span>
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
                <p class="text-{{ $groupData['color'] }}-700 text-sm font-medium">
                  {{ $report->status }} {{ strpos($group,'Waste') !== false ? '♻' : '' }}
                </p>
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



 <a href="{{ route('certificate.request') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="file-text" class="w-4 h-4"></i> Certificate
    </a>
    <a href="{{ route('feedback.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
    </a>

    <a href="{{ route('contact.support.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
      <i data-lucide="life-buoy" class="w-4 h-4"></i> Support
    </a>

    <button onclick="openModal('reportModal')" 
            class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full font-semibold text-gray-800 shadow-sm transition">
      + Concern
    </button>

    <!-- User Dropdown -->
    <div class="relative w-full md:w-auto">
      <button onclick="toggleDropdown('userDropdown')" class="flex items-center justify-between md:justify-start w-full md:w-auto gap-2 text-gray-700 hover:text-green-700 transition">
        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
          <i data-lucide="user" class="w-4 h-4"></i>
        </div>
        <span class="md:inline hidden font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
        <i data-lucide="chevron-down" class="w-4 h-4"></i>
      </button>

      <!-- Dropdown -->
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
      <h2 class="text-xl md:text-2xl font-semibold mb-4 text-gray-700">Citizen Engagement Platform</h2>
      <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
        Empowering citizen participation through transparent and accessible platforms,  
        fostering evidence-based decision-making for the community.
      </p>
      <button class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold shadow-md hover:bg-green-700 transition transform hover:scale-105">
        Learn More
      </button>
    </div>

    <!-- Right Column: Reports Grid -->
    <section class="grid lg:grid-cols-2 gap-6 lg:w-1/2">

      <!-- MDRRMO Resolved Reports -->
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
                        ->get(['id', 'title', 'description', 'category', 'user_id', 'created_at', 'updated_at']);
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
                    Your report titled <em>"{{ $report->title }}"</em> in the category 
                    <span class="font-semibold text-success">{{ $report->category }}</span> 
                    has been successfully resolved by <strong>MDRRMO</strong>.
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
                  <i class="bi bi-eye-fill"></i> View Details
                </button>
                <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs hover:bg-green-200 flex items-center gap-1 animate-pulse">
                  <i class="bi bi-chat-left-text-fill"></i> Send Feedback
                </button>
              </div>
            </div>
          @empty
            <p class="text-gray-500 text-sm text-center py-10">No resolved reports available.</p>
          @endforelse
        </div>
      </div>

      <!-- Waste Management Resolved Reports -->
      <div class="bg-white rounded-3xl shadow-xl p-6 h-full flex flex-col">
        <h5 class="text-yellow-600 font-bold mb-6 flex items-center gap-3 text-xl animate-pulse">
          <i class="bi bi-recycle text-yellow-600"></i> Waste Management Resolved Reports
        </h5>

        <div class="overflow-auto space-y-5 flex-1" style="max-height: 480px;">
          @php
            $Reports = \App\Models\ForwardedReport::with('user')
                              ->where('location', 'Santa.Fe')
                              ->where('status', 'Resolved')
                              ->where('category', 'Waste Management') // fetch only waste reports
                              ->latest()
                              ->get(['id', 'title', 'description', 'category', 'user_id', 'created_at', 'updated_at']);
          @endphp

          @forelse ($Reports as $report)
            @php $isNew = Carbon::parse($report->updated_at)->gt(now()->subDay()); @endphp
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
                    <div class="flex items-center gap-1"><i class="bi bi-calendar-event-fill text-yellow-600"></i> Submitted: {{ $report->created_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1"><i class="bi bi-check2-circle text-yellow-500"></i> Resolved: {{ $report->updated_at->format('M d, Y h:i A') }}</div>
                    <div class="flex items-center gap-1">
                      <i class="bi bi-hash text-gray-400"></i> Report ID: <span class="font-mono">{{ $report->id }}</span>
                      <button onclick="navigator.clipboard.writeText('{{ $report->id }}')" class="ml-2 text-xs text-yellow-500 hover:text-yellow-700" title="Copy ID">
                        <i class="bi bi-clipboard-fill"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <i class="bi bi-check-circle-fill text-yellow-500 text-3xl animate-ping"></i>
                  <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600 flex items-center gap-1">
                    <i class="bi bi-tag-fill"></i> {{ $report->category }}
                  </span>
                </div>
              </div>

              <div class="mt-4 flex gap-2 justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <button class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-yellow-600 flex items-center gap-1 animate-bounce">
                  <i class="bi bi-eye-fill"></i> View Details
                </button>
                <button class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs hover:bg-yellow-200 flex items-center gap-1 animate-pulse">
                  <i class="bi bi-chat-left-text-fill"></i> Send Feedback
                </button>
              </div>
            </div>
          @empty
            <p class="text-gray-500 text-sm text-center py-10">No resolved waste reports available.</p>
          @endforelse
        </div>
      </div>

    </section>
  </div>
</section>

<!-- Tailwind animation -->
<style>
@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(10px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.5s ease-in-out; }
</style>


<!-- 📌 Submit Concern Modal -->
<div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 animate-fadeIn">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Submit Concern</h3>
      <button onclick="closeModal('reportModal')" class="text-gray-400 hover:text-gray-700">&times;</button>
    </div>

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
          <option value="" disabled selected>Select category</option>
          <option>Road Issue</option>
          <option>Water Management</option>
          <option>Waste Management</option>
          <option>Noise Complaint</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="E.g. Broken streetlight" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="Describe your concern..." required></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Upload Photo (optional)</label>
        <input type="file" name="photo" accept="image/*" class="w-full border rounded-lg px-3 py-2">
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t">
        <button type="button" onclick="closeModal('reportModal')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Submit</button>
      </div>
    </form>
  </div>
</div>
<!-- TikTok-Style Dark Report Progress Modal (Tailwind) -->
<div id="reportProgressModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
  <div class="bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-6 relative text-gray-100 overflow-hidden">

    <!-- Close button -->
    <button onclick="closeReportModal()" 
      class="absolute top-4 right-4 text-gray-400 hover:text-white transition">✖</button>

    <!-- Header -->
    <h2 id="modalTitle" class="text-xl font-bold text-white mb-2">Report Progress</h2>
    <p class="text-sm text-gray-400 mb-6">
      Track your report in real-time with animated progress updates
    </p>

    <!-- Report Info -->
    <div class="bg-gray-800 rounded-lg p-4 mb-6 border border-gray-700">
      <p class="text-sm text-gray-400">Report Title:</p>
      <h3 id="modalReportTitle" class="text-base font-semibold text-white"></h3>
      <p class="text-sm text-gray-400 mt-2">Forwarded to: 
        <span id="modalDepartment" class="font-medium text-white"></span>
      </p>
    </div>

    <!-- Timeline Container -->
    <div class="relative pl-12">
      <!-- Timeline line -->
      <div id="timelineLine" class="absolute left-6 top-3 w-1 bg-gray-700 h-full rounded"></div>
      <div id="timelineFill" class="absolute left-6 top-3 w-1 bg-gradient-to-b from-green-400 via-blue-400 via-yellow-400 to-purple-400 h-0 rounded transition-all duration-1000"></div>

      <!-- Timeline Steps -->
      <div class="timeline-step-block relative flex items-start mb-10" data-step="Forwarded">
        <div class="absolute -left-6 flex flex-col items-center">
          <div id="stepForwarded" class="timeline-step w-6 h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-xs">→</i>
          </div>
        </div>
        <div>
          <p class="font-semibold text-green-400 text-lg">Report Forwarded</p>
          <p class="text-gray-400 text-sm mt-1">Your report has been forwarded to the responsible department for review.</p>
          <p id="forwardedTime" class="text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start mb-10" data-step="Accepted">
        <div class="absolute -left-6 flex flex-col items-center">
          <div id="stepAccepted" class="timeline-step w-6 h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-xs">✓</i>
          </div>
        </div>
        <div>
          <p class="font-semibold text-blue-400 text-lg">Report Accepted</p>
          <p class="text-gray-400 text-sm mt-1">The department has reviewed and accepted your report for action.</p>
          <p id="acceptedTime" class="text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start mb-10" data-step="Ongoing">
        <div class="absolute -left-6 flex flex-col items-center">
          <div id="stepOngoing" class="timeline-step w-6 h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-xs">⏳</i>
          </div>
        </div>
        <div>
          <p class="font-semibold text-yellow-400 text-lg">Action Ongoing</p>
          <p class="text-gray-400 text-sm mt-1">The department is actively working on resolving your reported issue.</p>
          <p id="ongoingTime" class="text-xs text-gray-500 mt-1">--</p>
        </div>
      </div>

      <div class="timeline-step-block relative flex items-start" data-step="Resolved">
        <div class="absolute -left-6 flex flex-col items-center">
          <div id="stepResolved" class="timeline-step w-6 h-6 rounded-full border-2 border-gray-500 bg-gray-900 flex items-center justify-center shadow-md transition-all duration-500">
            <i class="text-gray-500 text-xs">✔</i>
          </div>
        </div>
        <div>
          <p class="font-semibold text-purple-400 text-lg">Report Resolved</p>
          <p class="text-gray-400 text-sm mt-1">The issue has been successfully resolved and verified by the department.</p>
          <p id="resolvedTime" class="text-xs text-gray-500 mt-1">--</p>
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
  

  // Mobile menu toggle
  const mobileMenuBtn = document.getElementById("mobileMenuBtn");
  const navbarLinks = document.getElementById("navbarLinks");
  mobileMenuBtn.addEventListener("click", () => {
    navbarLinks.classList.toggle("hidden");
    navbarLinks.classList.toggle("flex");
    navbarLinks.classList.toggle("flex-col");
  });

  // Dropdown toggle
  function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const isOpen = !dropdown.classList.contains("hidden");
    document.querySelectorAll("[id$='Dropdown']").forEach(el => el.classList.add("hidden"));
    if (!isOpen) dropdown.classList.remove("hidden");
  }

  // Close dropdowns when clicking outside
  document.addEventListener("click", (event) => {
    document.querySelectorAll("[id$='Dropdown']").forEach(drop => {
      if (!drop.contains(event.target) && !drop.previousElementSibling.contains(event.target)) {
        drop.classList.add("hidden");
      }
    });
  });

  // Modals
  function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    lucide.createIcons();
  }

  function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }

  // Clear alerts badge & remember state
  function clearBadge() {
    let badge = document.getElementById('alertsBadge');
    if (badge) {
      badge.style.display = 'none';
      localStorage.setItem('alertsCleared', 'true');
    }
  }

  window.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('alertsCleared') === 'true') {
      let badge = document.getElementById('alertsBadge');
      if (badge) badge.style.display = 'none';
    }
    lucide.createIcons();
  });

  // Logout confirmation
  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Logout Confirmation',
      text: "Do you really want to logout?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#16a34a',
      cancelButtonColor: '#9ca3af',
      confirmButtonText: 'Logout'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }
</script>

</body>
</html>
