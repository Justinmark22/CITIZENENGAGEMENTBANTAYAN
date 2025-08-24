<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDRRMO  - Santa.Fe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ["Inter", "ui-sans-serif"] },
          colors: {
            brand: {
              50: "#eef2ff", 100: "#e0e7ff", 200: "#c7d2fe", 300: "#a5b4fc",
              400: "#818cf8", 500: "#6366f1", 600: "#4f46e5",
              700: "#4338ca", 800: "#3730a3", 900: "#312e81",
            }
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
      class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white p-6 transform transition-transform duration-300 ease-in-out"
      :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
      
      <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2">
          <i data-lucide="shield" class="w-7 h-7 text-brand-400"></i>
          <h1 class="text-xl font-bold tracking-wide">MDRRMO Santa Fe</h1>
        </div>
        <button class="md:hidden" @click="mobileMenu=false">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>

      <nav class="flex-1 space-y-2">
        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="home" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('mdrrmo.reports-santafe') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="file-warning" class="w-5 h-5 text-amber-400"></i> Reports
        </a>
        <a href="#announcements" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="megaphone" class="w-5 h-5 text-blue-400"></i> Announcements
        </a>
        <a href="#events" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="calendar" class="w-5 h-5 text-green-400"></i> Events
        </a>
        <a href="#alerts" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="bell" class="w-5 h-5 text-rose-400"></i> Emergency Alerts
        </a>
        <a href="#feedback" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="message-square" class="w-5 h-5 text-cyan-400"></i> Feedback
        </a>
      </nav>

      <form method="POST" action="{{ route('logout') }}" class="mt-6">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 transition font-medium">
          <i data-lucide="log-out" class="w-5 h-5"></i> Logout
        </button>
      </form>
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
        {{-- Only show Pending or Ongoing reports --}}
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
                <span class="ml-2">By: {{ $report->user?->name ?? 'N/A' }} ({{ $report->user?->email ?? 'N/A' }})</span>
              </p>
            </div>

            <div class="flex items-center gap-3">
              <span 
                class="status-badge px-2.5 py-1 text-xs font-medium rounded-full text-white 
                  {{ strtolower($report->status) == 'pending' ? 'bg-yellow-500' : 'bg-blue-600' }}"
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
              <span><strong>Created:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</span>
            </div>

            <!-- Photo (always at bottom of content) -->
            @if($report->photo)
            <img 
              src="{{ asset('storage/'.$report->photo) }}" 
              alt="Report Photo" 
              class="rounded-md w-full md:w-2/3 lg:w-1/2 h-48 object-cover border border-gray-200"
            >
            @endif

            <div class="flex justify-end space-x-2 mt-4">
    {{-- Show Ongoing button if status is Forwarded --}}
    @if($report->status === 'Forwarded')
        <button onclick="updateStatus('{{ $report->id }}', 'Ongoing', this)"
            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            Ongoing
        </button>

        {{-- Show Rejected button if status is Forwarded --}}
        <button onclick="updateStatus('{{ $report->id }}', 'Rejected', this)"
            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
            Rejected
        </button>
              @endif

              {{-- Show Resolved button only if status is Ongoing --}}
              @if($report->status === 'Ongoing')
                  <button onclick="updateStatus('{{ $report->id }}', 'Resolved', this)"
                      class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">
                      Resolved
                  </button>
              @endif

              {{-- Rejected is always allowed if still Pending --}}
              @if($report->status === 'Pending')
                  <button onclick="updateStatus('{{ $report->id }}', 'Rejected', this)"
                      class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                      Rejected
                  </button>
              @endif
            </div>
          </div>
        </div>
        @empty
          <p id="no-reports" class="text-gray-500 text-center mt-10">No forwarded reports found.</p>
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
            body: JSON.stringify({status: status})
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

                if(status === 'Resolved' || status === 'Rejected'){
                    // Remove entire card
                    reportEl.remove();

                    // Show "No reports" message if container is empty
                    if(document.querySelectorAll('.report-item').length === 0){
                        const container = document.getElementById('reports-container');
                        if(!document.getElementById('no-reports')){
                            const noReports = document.createElement('p');
                            noReports.id = 'no-reports';
                            noReports.className = 'text-gray-500 text-center mt-10';
                            noReports.textContent = 'No forwarded reports found.';
                            container.appendChild(noReports);
                        }
                    }
                } else if(status === 'Ongoing'){
                    // Hide only the Ongoing button
                    btn.style.display = 'none';

                    // Update badge
                    if(badge){
                        badge.textContent = 'Ongoing';
                        badge.className = 'status-badge px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-800';
                    }
                }
            } else {
                Swal.fire('Error','Failed to update status','error');
            }
        })
        .catch(err => Swal.fire('Error','Request failed','error'));
    });
}

// Initialize Lucide icons
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
</script>

</body>
</html>
