@php
    use Illuminate\Support\Facades\Storage;
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDRRMO - BANTAYAN</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    tailwind.config = {
  theme: {
    extend: {
      fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
      colors: {
        mdrrmo: {
          blue: '#1e3a8a',
          red: '#dc2626',
          green: '#16a34a',
          amber: '#f59e0b',
          gray: '#4b5563',
          light: '#f3f4f6'
        }
      },
      backgroundImage: {
        'page-gradient': 'linear-gradient(to right, #e0e7ff, #f3f4f6)',
        'card-texture': 'repeating-linear-gradient(45deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 8px)'
      }
    }
  }
}
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 9999px; }
    html { scroll-behavior: smooth; }
  </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex flex-col" x-data="{ mobileMenu: false }">
  <div class="flex flex-1 min-h-screen overflow-hidden">
    
<!-- Sidebar -->
<aside 
  class="fixed md:static inset-y-0 left-0 z-40 w-64 
         bg-gradient-to-b from-blue-200 to-blue-100 
         text-gray-800 p-6 transform transition-transform duration-300 
         ease-in-out shadow-lg"
  :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

  
  <div class="flex items-center justify-between mb-10">
  <div class="flex items-center justify-between mb-10">
  <!-- Larger Circular Logo -->
<img src="{{ asset('images/bantayanlogo.png') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
    <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">MDRRMO BANTAYAN</span>
  
  <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
</div>
  <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
</div>

  <nav class="flex flex-col gap-4">
    <!-- Dashboard -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
       <a href="{{ route('dashboard.mdrrmo-bantayan') }}"class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span class="font-medium">Overview</span>
      </a>
    </div>

    <!-- Reports -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
      <a href="{{ route('mdrrmo.reports-bantayan') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="file-text" class="w-5 h-5"></i>
        <span>All Reports</span>
      </a>
    </div>

    <!-- Communications -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
      <a href="{{ route('mdrrmo.mdrrmo_bantayan-announcements') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="megaphone" class="w-5 h-5"></i>
        <span>Announcements</span>
      </a>
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
      @csrf
      <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-400 hover:bg-red-500 font-semibold shadow transition-all">
        Logout
      </button>
    </form>
  </nav>
</aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto bg-gray-50 min-h-screen">
      <!-- Header -->
      <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Forwarded Reports</h1>
          <p class="text-sm text-gray-500">Dashboard / Forwarded Reports</p>
        </div>
      </div>
<!-- Reports Container -->
<div class="space-y-4" id="reports-container">
    {{-- Show Forwarded or Rerouted reports excluding Resolved/Rejected --}}
    @forelse($reports->whereNotIn('status', ['Resolved','Rejected']) as $report)
    <div 
        x-data="{ open: false }" 
        id="report-{{ $report->id }}"
        class="report-item bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all"
    >
        <!-- Header -->
        <div 
            @click="open = !open" 
            class="cursor-pointer px-5 py-4 flex justify-between items-center hover:bg-gray-50 transition"
        >
            <div>
                <h2 class="text-base font-semibold text-gray-800">{{ $report->title }}</h2>
                <p class="text-sm text-gray-500">
                    {{ $report->category }} • ID: {{ $report->id }}  
                    <span class="ml-2">
                        By: {{ $report->user?->name ?? 'N/A' }} ({{ $report->user?->email ?? 'N/A' }})
                        @if($report instanceof \App\Models\ReroutedReport)
                            <span class="ml-1 text-xs font-medium text-purple-600">(Rerouted)</span>
                        @else
                            <span class="ml-1 text-xs font-medium text-blue-600">(Forwarded)</span>
                        @endif
                    </span>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span 
                    class="status-badge px-2.5 py-1 text-xs font-medium rounded-full text-white
                        @if(str_contains(strtolower($report->status), 'rerouted')) bg-purple-500 
                        @elseif(strtolower($report->status) == 'pending') bg-yellow-500 
                        @else bg-blue-600 @endif"
                >
                    {{ ucfirst($report->status) }}
                </span>
                <svg x-show="!open" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                <svg x-show="open" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div 
            x-show="open" 
            x-transition 
            class="px-5 py-4 border-t border-gray-100 text-gray-700 space-y-4 bg-gray-50/50"
        >
            <!-- Description -->
            <p class="text-sm leading-relaxed">{{ $report->description }}</p>

            <!-- Metadata -->
            <div class="text-xs text-gray-500 flex flex-col sm:flex-row sm:justify-between gap-2">
                <span><strong>Location:</strong> {{ $report->location }}</span>
              <span><strong>Created:</strong> 
    {{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y h:i A') }}
</span>

            </div>

            <!-- Photo -->
            @if($report->photo)
            <img 
                src="{{ asset('storage/'.$report->photo) }}" 
                alt="Report Photo" 
                class="rounded-md w-full md:w-2/3 lg:w-1/2 h-48 object-cover border border-gray-200"
            >
            @endif

<!-- Buttons -->
<div class="flex justify-end space-x-2 mt-4">
    @php
        $statusLower = strtolower($report->status);
        $isRerouted = str_contains($statusLower, 'rerouted');
    @endphp

    <!-- Accept -->
    <button data-action="accept"
        onclick="updateStatus('{{ $report->id }}', 'Accepted', this)"
        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition
            {{ in_array($report->status, ['Forwarded','Pending']) || $isRerouted ? '' : 'hidden' }}">
        Accept
    </button>

    <!-- Ongoing -->
    <button data-action="ongoing"
        onclick="updateStatus('{{ $report->id }}', 'Ongoing', this)"
        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition
            {{ $report->status === 'Accepted' ? '' : 'hidden' }}">
        Ongoing
    </button>

    <!-- Resolved -->
    <button data-action="resolved"
        onclick="updateStatus('{{ $report->id }}', 'Resolved', this)"
        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition
            {{ $report->status === 'Ongoing' ? '' : 'hidden' }}">
        Resolved
    </button>

    <!-- Reroute (always visible) -->
    <div class="relative inline-block text-left" data-action="reroute">
        <button onclick="toggleDropdown('{{ $report->id }}')" class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600 transition">
            Reroute
        </button>
        <div id="dropdown-{{ $report->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-md z-10">
            <button onclick="rerouteReport('{{ $report->id }}','Water Management')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Water Management</button>
            <button onclick="rerouteReport('{{ $report->id }}','Waste Management')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Waste Management</button>
            <button onclick="rerouteReport('{{ $report->id }}','MDRRMO')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">MDRRMO</button>
            <button onclick="rerouteReport('{{ $report->id }}','Fire Management')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Fire Department</button>
        </div>
    </div>
</div>



        </div>
    </div>
    @empty
        <p id="no-reports" class="text-gray-500 text-center mt-10">No forwarded or rerouted reports found.</p>
    @endforelse
</div>


<!-- Pagination -->
<div class="mt-8 flex justify-center">
  {{ $reports->links('pagination::tailwind') }}
</div>
</main>
</div>

<script>
function updateStatus(reportId, status, btn) {
    Swal.fire({
        title: `Mark report as ${status}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if(!result.isConfirmed) return;

        fetch(`/forwarded-reports/${reportId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: `Report status changed to ${data.status}`,
                    timer: 1200,
                    showConfirmButton: false
                });

                const reportEl = document.getElementById(`report-${reportId}`);
                const badge = reportEl.querySelector('.status-badge');

                // ✅ Update badge color
                if(badge){
                    badge.textContent = data.status;
                    let colorClass = "bg-gray-500 text-white";
                    if(data.status === 'Accepted') colorClass = "bg-blue-500 text-white";
                    if(data.status === 'Ongoing') colorClass = "bg-yellow-500 text-white";
                    if(data.status === 'Resolved') colorClass = "bg-green-500 text-white";
                    if(data.status.includes('Rerouted')) colorClass = "bg-purple-500 text-white";
                    badge.className = `status-badge px-2.5 py-1 text-xs font-medium rounded-full ${colorClass}`;
                }

                // ✅ Toggle button visibility
                const acceptBtn   = reportEl.querySelector('[data-action="accept"]');
                const ongoingBtn  = reportEl.querySelector('[data-action="ongoing"]');
                const resolvedBtn = reportEl.querySelector('[data-action="resolved"]');

                if(data.status === 'Accepted'){
                    if(acceptBtn) acceptBtn.classList.add('hidden');
                    if(ongoingBtn) ongoingBtn.classList.remove('hidden');
                }
                if(data.status === 'Ongoing'){
                    if(ongoingBtn) ongoingBtn.classList.add('hidden');
                    if(resolvedBtn) resolvedBtn.classList.remove('hidden');
                }
                if(data.status === 'Resolved'){
                    reportEl.remove(); // ✅ Only remove row when resolved
                }
            } else {
                Swal.fire('Error','Failed to update status','error');
            }
        })
        .catch(err => Swal.fire('Error','Request failed','error'));
    });
}


function toggleDropdown(reportId) {
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
    document.getElementById(`dropdown-${reportId}`).classList.toggle('hidden');
}
function rerouteReport(reportId, destination) {
    Swal.fire({
        title: 'Reroute Report',
        text: `Are you sure you want to reroute this report to ${destination}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reroute',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/forwarded-reports/${reportId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                status: `Rerouted to ${destination}`,
                rerouted_to: destination // ✅ backend must store this
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Rerouted!',
                    text: `Report successfully rerouted to ${data.rerouted_to}`,
                    timer: 1500,
                    showConfirmButton: false
                });

                // ✅ Hide the report immediately
                const reportEl = document.getElementById(`report-${reportId}`);
                if (reportEl) {
                    reportEl.style.display = 'none';
                }
            } else {
                Swal.fire('Error', 'Failed to reroute report', 'error');
            }
        })
        .catch(err => Swal.fire('Error', 'Request failed', 'error'));
    });
}

</script>




</body>
</html>
