<!DOCTYPE html>
<html lang="en" x-data="{ mobileMenu: false }">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waste - Madridejos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 9999px; }
    html { scroll-behavior: smooth; }
  </style>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex">

<body class="bg-gray-100 font-sans flex min-h-screen" x-data="reportApp()" x-init="fetchReports()">

  <!-- Sidebar -->
  <aside class="fixed md:static inset-y-0 left-0 z-40 w-64 
         bg-gradient-to-b from-blue-200 to-blue-100 
         text-gray-800 p-6 transform transition-transform duration-300 
         ease-in-out shadow-lg"
         :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="flex items-center justify-between mb-10">
      <img src="{{ asset('/images/SAN.PNG') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
      <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">Waste madridejos</span>
      <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
    </div>

    <nav class="flex flex-col gap-4">
      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
        <a href="{{ route('dashboard.waste-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
          <i data-lucide="home" class="w-5 h-5"></i>
          <span class="font-medium">Overview</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
        <a href="{{ route('waste.reports-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          <span>All Reports</span>
        </a>
      </div>

      <div>
        <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
        <a href="{{ route('waste.announcement-madridejos') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
          <i data-lucide="megaphone" class="w-5 h-5"></i>
          <span>Announcements</span>
        </a>
      </div>

      <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
        @csrf
        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-400 hover:bg-red-500 font-semibold shadow transition-all">
          Logout
        </button>
      </form>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Forwarded & Rerouted Reports (Waste Management)</h1>
        <p class="text-sm text-gray-500">Dashboard / Forwarded Reports</p>
      </div>
    </div>

    <!-- Stats -->
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

    <!-- Forwarded & Rerouted Reports -->
    <div class="space-y-6" id="reports-container">
      @forelse($reports as $report)
      <div x-data="{ open: false }" id="report-{{ $report->id }}"
           class="bg-white/60 backdrop-blur-md border border-gray-200 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">

        <!-- Header -->
        <div @click="open = !open" class="cursor-pointer px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
          <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ $report->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">
              {{ $report->category }} • ID: {{ $report->id }}
              <span class="ml-2">By: {{ $report->user?->name ?? 'N/A' }}</span>
            </p>
          </div>
          <div class="flex items-center gap-3">
            <!-- Status Badge -->
            <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full 
              {{ strtolower($report->status)=='pending'?'bg-yellow-400 text-yellow-900':(strtolower($report->status)=='ongoing'?'bg-orange-400 text-orange-900':'bg-blue-500 text-white') }}">
              {{ ucfirst($report->status) }}
            </span>

            <!-- Type Badge -->
            <span class="px-2 py-0.5 text-xs font-semibold rounded-full
              {{ $report->type=='rerouted'?'bg-purple-500 text-white':'bg-green-500 text-white' }}">
              {{ ucfirst($report->type ?? 'Forwarded') }}
            </span>

            <i x-show="!open" data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
            <i x-show="open" data-lucide="chevron-up" class="h-4 w-4 text-gray-400"></i>
          </div>
        </div>

        <!-- Content -->
        <div x-show="open" x-transition class="px-6 py-4 border-t border-gray-100 space-y-4 text-gray-700 bg-gray-50/50 rounded-b-xl">
          <p class="text-sm leading-relaxed">{{ $report->description }}</p>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-2 text-xs text-gray-500">
            <span><strong>Location:</strong> {{ $report->location }}</span>
          <span><strong>Created:</strong> {{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('M d, Y h:i A') : 'N/A' }}</span>

          </div>

          @if($report->photo)
          <img src="{{ asset('storage/'.$report->photo) }}" class="rounded-lg w-full md:w-2/3 lg:w-1/2 h-48 object-cover border border-gray-200 shadow-sm">
          @endif

          <div class="flex flex-wrap justify-end gap-2 mt-4">
            <button onclick="updateStatus('{{ $report->id }}','Accepted',{},this)" class="flex items-center gap-1 px-4 py-1 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
              <i data-lucide="check-circle" class="w-4 h-4"></i> Accept
            </button>
            <button onclick="updateStatus('{{ $report->id }}','Ongoing',{},this)" class="flex items-center gap-1 px-4 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
              <i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Ongoing
            </button>
            <button onclick="updateStatus('{{ $report->id }}','Resolved',{},this)" class="flex items-center gap-1 px-4 py-1 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">
              <i data-lucide="check" class="w-4 h-4"></i> Resolved
            </button>

            <button onclick="rerouteReport('{{ $report->id }}')" 
              class="flex items-center gap-1 px-4 py-1 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition">
              <i data-lucide="share-2" class="w-4 h-4"></i> Reroute
            </button>
          </div>
        </div>
      </div>
      @empty
      <p class="text-gray-500 text-center mt-10">No reports found for Water Management.</p>
      @endforelse
    </div>

    <div class="mt-8 flex justify-center">
      {{ $reports->links('pagination::tailwind') }}
    </div>
  </main>

  <!-- JavaScript Section -->
  <script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content || '';

    function mapCountId(status) {
      if (!status) return null;
      const s = status.toLowerCase();
      if (s.includes('pending')) return 'count-pending';
      if (s.includes('accepted')) return 'count-accepted';
      if (s.includes('ongoing')) return 'count-ongoing';
      if (s.includes('resolved')) return 'count-resolved';
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

        const data = await res.json();
        if (!data.success) {
          Swal.fire('Error', data.message || 'Failed to update status', 'error');
          return;
        }

        Swal.fire({
          icon: 'success',
          title: data.message || `Marked as ${data.status || status}`,
          timer: 1200,
          showConfirmButton: false
        });

        if (btn) btn.style.display = "none";
        const card = document.getElementById(`report-${id}`);
        if (card) {
          const badge = card.querySelector('.status-badge');
          if (badge && data.status) badge.textContent = data.status;

          if (data.status && data.status.toLowerCase().includes('resolved')) {
            card.style.transition = "opacity .3s ease";
            card.style.opacity = "0";
            setTimeout(() => card.remove(), 350);
          }
        }
        adjustCounters(data.old_status || null, data.status || payload.status || null);
      } catch (err) {
        console.error('updateStatus exception', err);
        Swal.fire('Error', 'Network error.', 'error');
      }
    }

    async function rerouteReport(id) {
      const { value: department } = await Swal.fire({
        title: "Reroute Report",
        input: "select",
        inputOptions: {
          "Water Management": "Water Management",
          "Waste Management": "Waste Management",
          "MDRRMO": "MDRRMO",
          "Fire Management": "Fire Department",
        },
        inputPlaceholder: "Select department to reroute to",
        showCancelButton: true,
        confirmButtonText: "Reroute",
        cancelButtonText: "Cancel",
        inputValidator: (value) => {
          if (!value) return "Please select a department";
        },
      });

      if (department) {
        try {
          const res = await fetch(`/reports/${id}/reroute`, {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": CSRF,
              "Content-Type": "application/json",
              "Accept": "application/json",
            },
            body: JSON.stringify({ rerouted_to: department }),
          });

          const data = await res.json();

          if (!data.success) {
            Swal.fire("Error", data.message || "Failed to reroute report", "error");
            return;
          }

          Swal.fire({
            icon: "success",
            title: `Report rerouted to ${department}`,
            timer: 1300,
            showConfirmButton: false,
          });

          const card = document.getElementById(`report-${id}`);
          if (card) {
            card.style.transition = "opacity .3s ease";
            card.style.opacity = "0";
            setTimeout(() => card.remove(), 350);
          }
        } catch (err) {
          console.error(err);
          Swal.fire("Error", "Network error while rerouting.", "error");
        }
      }
    }
  </script>

</body>
</html>
