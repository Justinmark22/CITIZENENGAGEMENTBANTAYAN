<!DOCTYPE html>
<html lang="en" x-data="{ mobileMenu: false }">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waste - Bantayan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 9999px; }
    html { scroll-behavior: smooth; }
  </style>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex">

  
  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg flex flex-col">
      <div class="p-6 border-b border-gray-200">
          <h2 class="text-2xl font-bold text-gray-900">WasteMgmt</h2>
          <p class="text-gray-400 text-sm mt-1">Santa Fe</p>
      </div>
      <nav class="mt-6 flex-1 space-y-2">
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
              </svg>
              Dashboard
          </a>
          <a href="{{ route('waste.reports-bantayan') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6H9zM5 9V5h14v4H5z"/>
              </svg>
              Reports
          </a>
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a4 4 0 100-8 4 4 0 000 8z"/>
              </svg>
              Analytics
          </a>
          <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 rounded-lg transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
              </svg>
              Settings
          </a>
      </nav>
  </aside>


  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Forwarded Reports (Waste Management)</h1>
        <p class="text-sm text-gray-500">Dashboard / Forwarded Reports</p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center hover:shadow-lg transition">
        <span class="text-sm text-gray-500">Pending</span>
        <span id="count-pending" class="text-xl font-bold text-yellow-600">{{ $reports->where('status','Pending')->count() }}</span>
      </div>
      <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center hover:shadow-lg transition">
        <span class="text-sm text-gray-500">Accepted</span>
        <span id="count-accepted" class="text-xl font-bold text-blue-600">{{ $reports->where('status','Accepted')->count() }}</span>
      </div>
      <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center hover:shadow-lg transition">
        <span class="text-sm text-gray-500">Ongoing</span>
        <span id="count-ongoing" class="text-xl font-bold text-orange-600">{{ $reports->where('status','Ongoing')->count() }}</span>
      </div>
      <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center hover:shadow-lg transition">
        <span class="text-sm text-gray-500">Resolved</span>
        <span id="count-resolved" class="text-xl font-bold text-green-600">{{ $reports->where('status','Resolved')->count() }}</span>
      </div>
    </div>

    <!-- Reports List -->
    <div class="space-y-6" id="reports-container">
      @forelse($reports->where('forwarded_to','Waste Management')->whereNotIn('status',['Resolved','Rejected']) as $report)
      <div x-data="{ open: false }" id="report-{{ $report->id }}"
           class="bg-white/60 backdrop-blur-md border border-gray-200 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        
        <!-- Header -->
        <div @click="open = !open" class="cursor-pointer px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
          <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ $report->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $report->category }} • ID: {{ $report->id }}
              <span class="ml-2">By: {{ $report->user?->name ?? 'N/A' }}</span>
            </p>
          </div>
          <div class="flex items-center gap-3">
            <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full 
              {{ strtolower($report->status)=='pending'?'bg-yellow-400 text-yellow-900':'bg-blue-500 text-white' }}">
              {{ ucfirst($report->status) }}
            </span>
            <i x-show="!open" data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
            <i x-show="open" data-lucide="chevron-up" class="h-4 w-4 text-gray-400"></i>
          </div>
        </div>

        <!-- Body -->
        <div x-show="open" x-transition class="px-6 py-4 border-t border-gray-100 space-y-4 text-gray-700 bg-gray-50/50 rounded-b-xl">
          <p class="text-sm leading-relaxed">{{ $report->description }}</p>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-2 text-xs text-gray-500">
            <span><strong>Location:</strong> {{ $report->location }}</span>
            <span><strong>Created:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</span>
          </div>
          @if($report->photo)
          <img src="{{ asset('storage/'.$report->photo) }}" class="rounded-lg w-full md:w-2/3 lg:w-1/2 h-48 object-cover border border-gray-200 shadow-sm">
          @endif

          <!-- Actions -->
          <div class="flex flex-wrap justify-end gap-2 mt-4">
            <button onclick="updateStatus('{{ $report->id }}','Accepted',{},this)"
              class="flex items-center gap-1 px-4 py-1 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
              <i data-lucide="check-circle" class="w-4 h-4"></i> Accept
            </button>
            <button onclick="updateStatus('{{ $report->id }}','Ongoing',{},this)"
              class="flex items-center gap-1 px-4 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
              <i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Ongoing
            </button>
            <button onclick="updateStatus('{{ $report->id }}','Resolved',{},this)"
              class="flex items-center gap-1 px-4 py-1 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">
              <i data-lucide="check" class="w-4 h-4"></i> Resolved
            </button>
            <div class="relative inline-block text-left">
              <button type="button" onclick="toggleDropdown('{{ $report->id }}')"
                class="px-4 py-1 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition">Reroute</button>
              <div id="dropdown-{{ $report->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                <button onclick="rerouteReport('{{ $report->id }}','Water Management',this)"
                  class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Water Management</button>
                <button onclick="rerouteReport('{{ $report->id }}','Mayor\'s Office',this)"
                  class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Mayor's Office</button>
                <button onclick="rerouteReport('{{ $report->id }}','MDRRMO',this)"
                  class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">MDRRMO</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <p class="text-gray-500 text-center mt-10">No Waste Management reports found.</p>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
      {{ $reports->links('pagination::tailwind') }}
    </div>
  </main>


<script>
/* ---------- CONFIG ---------- */
const CSRF = document.querySelector('meta[name="csrf-token"]').content || '';

/* ---------- helpers ---------- */
function mapCountId(status) {
  if (!status) return null;
  const s = status.toLowerCase();
  if (s.includes('pending')) return 'count-pending';
  if (s.includes('accepted')) return 'count-accepted';
  if (s.includes('ongoing')) return 'count-ongoing';
  if (s.includes('resolved')) return 'count-resolved';
  if (s.includes('rejected')) return 'count-rejected';
  return null;
}

function adjustCounters(oldStatus, newStatus) {
  const decId = mapCountId(oldStatus);
  const incId = mapCountId(newStatus);

  if (decId) {
    const el = document.getElementById(decId);
    if (el) el.innerText = Math.max(0, (parseInt(el.innerText || '0') - 1));
  }
  if (incId) {
    const el = document.getElementById(incId);
    if (el) el.innerText = (parseInt(el.innerText || '0') + 1);
  }
}

/* ---------- main update ---------- */
async function updateStatus(id, status, opts = {}, btn = null) {
  try {
    const payload = Object.assign({ status }, opts);

    const res = await fetch(`/reports/${id}/update-status`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    });

    if (!res.ok) {
      const text = await res.text().catch(() => '');
      Swal.fire('Error', text || `Status ${res.status}`, 'error');
      return;
    }

    const data = await res.json();
    if (!data.success) {
      Swal.fire('Error', data.message || 'Failed to update status', 'error');
      return;
    }

    Swal.fire({
      icon: 'success',
      title: data.message || `Marked as ${data.status || status}`,
      timer: 1300,
      showConfirmButton: false
    });

    // Hide clicked button only
    if (btn) btn.style.display = "none";

    // Update badge
    const card = document.getElementById(`report-${id}`);
    if (card) {
      const badge = card.querySelector('.status-badge');
      if (badge && data.status) badge.textContent = data.status;

      // If Resolved → remove card from list
      if (data.status && data.status.toLowerCase().includes('resolved')) {
        card.style.transition = "opacity .3s ease";
        card.style.opacity = "0";
        setTimeout(() => card.remove(), 350);
      }
    }

    adjustCounters(data.old_status || null, data.status || payload.status || null);

  } catch (err) {
    console.error('updateStatus exception', err);
    Swal.fire('Error', 'Network or server error. See console for details.', 'error');
  }
}

/* ---------- reroute wrapper ---------- */
function rerouteReport(id, dept, btn = null) {
  const status = `Rerouted to ${dept}`;
  updateStatus(id, status, { rerouted_to: dept }, btn);
}

/* ---------- dropdown helper ---------- */
function toggleDropdown(id) {
  document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
    if (el.id !== `dropdown-${id}`) el.classList.add('hidden');
  });
  const d = document.getElementById(`dropdown-${id}`);
  if (d) d.classList.toggle('hidden');
}
</script>
</body>
</html>
