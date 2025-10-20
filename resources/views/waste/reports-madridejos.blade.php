<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waste - Bantayan</title>
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
          <h1 class="text-xl font-bold tracking-wide">WASTE Bantayan</h1>
        </div>
        <button class="md:hidden" @click="mobileMenu=false">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>

      <nav class="flex-1 space-y-2">
        <a href="{{ route('dashboard.waste-madridejos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="home" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('mdrrmo.reports-santafe') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="file-warning" class="w-5 h-5 text-amber-400"></i> Reports
        </a>
        <a href="#announcements" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="megaphone" class="w-5 h-5 text-blue-400"></i> Announcements
        </a>
        <a href="#alerts" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="bell" class="w-5 h-5 text-rose-400"></i> Emergency Alerts
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
      <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Forwarded Reports (Waste Management)</h1>
          <p class="text-sm text-gray-500">Dashboard / Forwarded Reports</p>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
          <span class="text-sm text-gray-500">Pending</span>
          <span id="count-pending" class="text-xl font-bold text-yellow-600">{{ $reports->where('status','Pending')->count() }}</span>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
          <span class="text-sm text-gray-500">Accepted</span>
          <span id="count-accepted" class="text-xl font-bold text-blue-600">{{ $reports->where('status','Accepted')->count() }}</span>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
          <span class="text-sm text-gray-500">Ongoing</span>
          <span id="count-ongoing" class="text-xl font-bold text-orange-600">{{ $reports->where('status','Ongoing')->count() }}</span>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
          <span class="text-sm text-gray-500">Resolved</span>
          <span id="count-resolved" class="text-xl font-bold text-green-600">{{ $reports->where('status','Resolved')->count() }}</span>
        </div>
      </div>

      <!-- Reports -->
      <div class="space-y-4" id="reports-container">
        @forelse($reports->where('forwarded_to', 'Waste Management')->whereNotIn('status', ['Resolved','Rejected']) as $report)
        <div 
          x-data="{ open: false }" 
          id="report-{{ $report->id }}"
          class="report-item bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all"
        >
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
              <span class="status-badge px-2.5 py-1 text-xs font-medium rounded-full text-white 
                {{ strtolower($report->status) == 'pending' ? 'bg-yellow-500' : 'bg-blue-600' }}">
                {{ ucfirst($report->status) }}
              </span>
              <i x-show="!open" data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
              <i x-show="open" data-lucide="chevron-up" class="h-4 w-4 text-gray-400"></i>
            </div>
          </div>

          <div x-show="open" x-transition class="px-5 py-4 border-t border-gray-100 text-gray-700 space-y-4 bg-gray-50/50">
            <p class="text-sm leading-relaxed">{{ $report->description }}</p>
            <div class="text-xs text-gray-500 flex flex-col sm:flex-row sm:justify-between gap-2">
              <span><strong>Location:</strong> {{ $report->location }}</span>
              <span><strong>Created:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</span>
            </div>
            @if($report->photo)
            <img src="{{ asset('storage/'.$report->photo) }}" class="rounded-md w-full md:w-2/3 lg:w-1/2 h-48 object-cover border border-gray-200">
            @endif
<!-- Buttons -->
<div class="flex justify-end space-x-2 mt-4">
  <button onclick="updateStatus('{{ $report->id }}','Accepted',{}, this)" 
    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Accept</button>
  <button onclick="updateStatus('{{ $report->id }}','Ongoing',{}, this)" 
    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Ongoing</button>
  <button onclick="updateStatus('{{ $report->id }}','Resolved',{}, this)" 
    class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Resolved</button>
  <div class="relative inline-block text-left">
    <button type="button" onclick="toggleDropdown('{{ $report->id }}')" 
      class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600">Reroute</button>
    <div id="dropdown-{{ $report->id }}" 
      class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-md z-10">
      <button onclick="rerouteReport('{{ $report->id }}','Water Management', this)" 
        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Water Management</button>
      <button onclick="rerouteReport('{{ $report->id }}','Mayor\'s Office', this)" 
        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Mayor's Office</button>
      <button onclick="rerouteReport('{{ $report->id }}','MDRRMO', this)" 
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

      <div class="mt-8 flex justify-center">
        {{ $reports->links('pagination::tailwind') }}
      </div>
    </main>
  </div>

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
