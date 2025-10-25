<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bantayan - Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #e8f3f0; }
    .glass {
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.3);
    }
  </style>
</head>
<body class="flex min-h-screen">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-gradient-to-b from-emerald-400 to-blue-600 text-white p-6 flex flex-col fixed inset-y-0">
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/santafe.png') }}" alt="Santa Fe Logo" class="w-20 h-20 rounded-full mb-2">
      <h2 class="text-lg font-semibold">Bantayan Admin</h2>
    </div>

    <nav class="flex flex-col gap-3 text-sm font-medium">
      <a href="{{ route('dashboard.bantayanadmin') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="home"></i> Dashboard</a>
      <a href="{{ route('bantayan.users.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="users"></i> Users</a>
      <a href="{{ route('bantayan.reports') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/20"><i data-lucide="file-text"></i> Reports</a>
      <a href="{{ route('bantayan.feedback') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="message-square"></i> Feedback</a>
      <a href="{{ route('bantayan.announcements') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="megaphone"></i> Announcements</a>
      <a href="{{ route('bantayan.events') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="calendar-days"></i> Events</a>
      <a href="{{ route('bantayan.updates') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10"><i data-lucide="message-square"></i> Updates</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-64 flex-1 p-8">
    <!-- NAVBAR -->
    <header class="glass rounded-xl shadow-sm p-4 mb-6 flex justify-between items-center">
      <h1 class="text-xl font-semibold text-gray-800 flex items-center gap-2"><i data-lucide="layout-dashboard"></i> Bantayan Reports</h1>
      <div class="relative">
        <button class="flex items-center gap-2 bg-white rounded-full shadow px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
          <i data-lucide="user-cog" class="text-blue-600"></i>
          {{ Auth::user()->email ?? 'admin@santafe.gov' }}
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
      </div>
    </header>

    <!-- FILTERS -->
    <form method="GET" action="{{ route('bantayan.reports') }}" class="flex flex-wrap gap-3 mb-6">
      <select name="status" class="w-48 rounded-lg border border-gray-300 bg-white p-2 text-sm focus:ring-2 focus:ring-blue-500">
        <option value="">All Status</option>
        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
        <option value="Ongoing" {{ request('status')=='Ongoing'?'selected':'' }}>Ongoing</option>
        <option value="Resolved" {{ request('status')=='Resolved'?'selected':'' }}>Resolved</option>
        <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
      </select>
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 flex items-center gap-1">
        <i data-lucide="filter"></i> Filter
      </button>
    </form>

    <!-- REPORTS LIST -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      @forelse ($reports as $report)
      <div class="glass rounded-2xl p-5 shadow-md hover:shadow-lg transition cursor-pointer" 
           data-modal-target="#reportModal"
           data-title="{{ $report->title }}" 
           data-description="{{ $report->description }}"
           data-location="{{ $report->location }}" 
           data-status="{{ $report->status }}"
           data-date="{{ $report->created_at->format('M d, Y H:i') }}"
           data-photo="{{ $report->photo ? asset('storage/'.$report->photo) : '' }}"
           onclick="openModal(this)">
        <h2 class="font-semibold text-gray-800 mb-1">{{ $report->title }}</h2>
        <p class="text-gray-500 text-sm mb-2">{{ Str::limit($report->description,100) }}</p>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-600 flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $report->location }}</span>
          <span class="px-3 py-1 rounded-full text-xs font-semibold text-white 
            @if($report->status=='Resolved') bg-green-500 
            @elseif($report->status=='Rejected') bg-red-500 
            @elseif($report->status=='Ongoing') bg-blue-500 
            @else bg-yellow-500 text-black @endif">
            {{ $report->status }}
          </span>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center text-gray-600 py-8">No reports found.</div>
      @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
      {{ $reports->withQueryString()->links() }}
    </div>
  </main>

  <!-- MODAL -->
  <div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-3xl p-6 relative">
      <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeModal()">
        <i data-lucide="x"></i>
      </button>
      <h2 id="modalTitle" class="text-xl font-semibold text-gray-800 mb-3"></h2>
      <p id="modalDesc" class="text-gray-600 mb-4"></p>
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <p><span class="font-semibold">Location:</span> <span id="modalLoc"></span></p>
          <p><span class="font-semibold">Status:</span> <span id="modalStatus"></span></p>
          <p><span class="font-semibold">Date:</span> <span id="modalDate"></span></p>
        </div>
        <div class="flex-1 flex justify-center items-center">
          <img id="modalPhoto" src="" alt="Report Photo" class="max-h-64 rounded-lg shadow hidden">
          <p id="noPhoto" class="text-gray-500 italic">No photo available</p>
        </div>
      </div>
      <div class="mt-6 flex justify-end">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Close</button>
      </div>
    </div>
  </div>

  <!-- SCRIPT -->
  <script>
    function openModal(card){
      document.getElementById('reportModal').classList.remove('hidden');
      document.getElementById('modalTitle').innerText = card.dataset.title;
      document.getElementById('modalDesc').innerText = card.dataset.description;
      document.getElementById('modalLoc').innerText = card.dataset.location;
      document.getElementById('modalStatus').innerText = card.dataset.status;
      document.getElementById('modalDate').innerText = card.dataset.date;

      const img = document.getElementById('modalPhoto');
      const noPhoto = document.getElementById('noPhoto');
      if(card.dataset.photo){
        img.src = card.dataset.photo;
        img.classList.remove('hidden');
        noPhoto.classList.add('hidden');
      } else {
        img.classList.add('hidden');
        noPhoto.classList.remove('hidden');
      }
      lucide.createIcons();
    }
    function closeModal(){
      document.getElementById('reportModal').classList.add('hidden');
    }
    document.addEventListener("DOMContentLoaded",()=>lucide.createIcons());
  </script>

</body>
</html>
