<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Reports</title>

  <!-- ✅ Tailwind & Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body class="bg-gray-50 text-gray-800 font-inter">

<!-- ✅ Mobile Top Bar with Hamburger -->
<header class="md:hidden bg-blue-900 text-white flex justify-between items-center px-4 py-3 shadow">
  <h1 class="font-bold text-lg">Admin Panel</h1>
  <button id="menuBtn" class="text-2xl focus:outline-none">
    <i class="bi bi-list"></i>
  </button>
</header>

<!-- ✅ Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white p-6 flex flex-col shadow-xl z-50 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
  <div class="flex justify-between items-center mb-6 md:mb-8">
    <h1 class="text-2xl font-bold">Admin Panel</h1>
    <button id="closeBtn" class="md:hidden text-2xl"><i class="bi bi-x"></i></button>
  </div>
  
  <nav class="flex flex-col gap-4">
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
      <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-graph-up-arrow"></i> Analytics
      </a>
    </div>

    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people"></i> Users
      </a>
      <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-person-badge"></i> Municipal Admins
      </a>
    </div>

    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Content</p>
      <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-megaphone"></i> Announce
      </a>
      <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-file-text"></i> Reports
      </a>
      <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-plus-square"></i> Updates
      </a>
      <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-calendar-event"></i> Events
      </a>
      <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people-fill"></i> Engagement
      </a>
    </div>
  </nav>
</aside>

<!-- ✅ Overlay for mobile -->
<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40 md:hidden"></div>

<!-- ✅ Main Content -->
<main class="md:pl-64 transition-all duration-300 ease-in-out">

  <!-- ✅ Intro Section -->
  <div class="text-center py-16 px-4 bg-gradient-to-b from-white to-gray-100 mb-8">
    <h1 class="text-3xl font-bold text-blue-900 animate__animated animate__fadeInDown">Manage All Reports</h1>
    <p class="text-gray-500 mt-2">Select a municipality to view and manage their submitted reports.</p>

    <div class="flex justify-center mt-4">
      <video autoplay muted loop class="w-28 sm:w-36 rounded-xl rotate-90 animate__animated animate__fadeInDown">
        <source src="{{ asset('videos/hand.mp4') }}" type="video/mp4">
      </video>
    </div>

    <div class="flex flex-wrap justify-center gap-3 mt-6">
      @foreach(['Santa Fe' => $stafeReports, 'Madridejos' => $madridejosReports, 'Bantayan' => $bantayanReports] as $name => $collection)
        <button class="relative bg-white border border-blue-500 text-blue-600 font-semibold px-5 py-2 rounded-full hover:bg-blue-50 transition"
                onclick="showReports('{{ $name }}')">
          {{ $name === 'Santa Fe' ? 'Sta.Fe' : $name }}
          @if($collection->where('status', 'Pending')->count())
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
              {{ $collection->where('status', 'Pending')->count() }}
            </span>
          @endif
        </button>
      @endforeach
    </div>
  </div>

  <!-- ✅ Report Section -->
  <div id="reportSection" class="hidden px-4 sm:px-6 max-w-6xl mx-auto">
    <h4 id="reportTitle" class="text-center font-bold text-lg sm:text-xl mb-6"></h4>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
      @foreach (['Santa Fe' => $stafeReports, 'Bantayan' => $bantayanReports, 'Madridejos' => $madridejosReports] as $location => $reports)
        @foreach ($reports->where('status', 'Pending') as $report)
          <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 border-l-4 border-blue-500 cursor-pointer report-card"
               data-location="{{ $location }}"
               data-title="{{ $report->title }}"
               data-description="{{ Str::limit($report->description, 120) }}"
               data-name="{{ $report->user->name ?? 'N/A' }}"
               data-email="{{ $report->user->email ?? 'N/A' }}"
               data-status="{{ $report->status }}">
            <div class="flex justify-between">
              <span class="font-semibold text-blue-700">{{ $location }}</span>
              <small class="text-gray-500">Status: Pending</small>
            </div>
            <h5 class="mt-2 font-bold text-gray-800">{{ $report->title }}</h5>
            <p class="text-gray-500 mt-1">{{ Str::limit($report->description, 120) }}</p>
            <div class="flex gap-2 mt-3">
              @foreach(['Resolved' => 'green', 'Delayed' => 'yellow'] as $status => $color)
                <form class="status-form" action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                  @csrf @method('PATCH')
                  <input type="hidden" name="status" value="{{ $status }}">
                  <button type="submit" class="px-3 py-1 text-sm rounded bg-{{ $color }}-500 text-white hover:bg-{{ $color }}-600 transition">{{ $status }}</button>
                </form>
              @endforeach
            </div>
          </div>
        @endforeach
      @endforeach
    </div>
    <div id="noReportsMsg" class="text-center text-gray-500 mt-6 hidden">No reports to show.</div>
  </div>

</main>

<!-- ✅ Modal -->
<div id="reportModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl overflow-hidden animate__animated animate__fadeInDown" id="printContent">
    <div class="p-6">
      <div class="text-center mb-4">
        <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="h-20 mx-auto">
        <h4 class="mt-3 font-bold text-blue-700">Citizen Engagement System</h4>
      </div>
      <hr class="my-4">
      <div class="mb-4">
        <h6 class="font-semibold text-gray-600 border-b pb-1 mb-2">Reporter Information</h6>
        <p><strong>Name:</strong> <span id="modalUserName"></span></p>
        <p><strong>Email:</strong> <span id="modalUserEmail"></span></p>
      </div>
      <div class="mb-4">
        <h6 class="font-semibold text-gray-600 border-b pb-1 mb-2">Report Details</h6>
        <p><strong>Location:</strong> <span id="modalLocation"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus" class="inline-block px-2 py-0.5 bg-yellow-300 text-yellow-900 rounded text-sm">Pending</span></p>
        <p class="mt-2"><strong>Title:</strong></p>
        <h5 id="modalTitle" class="font-bold text-gray-800"></h5>
        <p class="mt-3"><strong>Description:</strong></p>
        <p id="modalDescription" class="text-gray-600"></p>
      </div>
      <div class="border-t pt-3">
        @php $auth = Auth::user(); @endphp
        <p><strong>Reviewed By:</strong> {{ $auth->name ?? 'Unknown User' }}</p>
        <small class="text-gray-500">{{ $auth->email ?? 'No Email' }}</small>
      </div>
    </div>
    <div class="flex justify-between bg-gray-50 px-6 py-3">
      <button onclick="printReport()" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        <i class="bi bi-printer"></i> Print
      </button>
      <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Close</button>
    </div>
  </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
document.getElementById('menuBtn').onclick = () => {
  sidebar.classList.remove('-translate-x-full');
  overlay.classList.remove('hidden');
};
document.getElementById('closeBtn').onclick = closeSidebar;
overlay.onclick = closeSidebar;

function closeSidebar() {
  sidebar.classList.add('-translate-x-full');
  overlay.classList.add('hidden');
}

function showReports(location) {
  const section = document.getElementById('reportSection');
  const cards = document.querySelectorAll('[data-location]');
  const title = document.getElementById('reportTitle');
  const noneMsg = document.getElementById('noReportsMsg');

  section.classList.remove('hidden');
  title.innerText = `Reports from ${location}`;

  let visible = 0;
  cards.forEach(card => {
    if (card.getAttribute('data-location') === location) {
      card.classList.remove('hidden');
      visible++;
    } else {
      card.classList.add('hidden');
    }
  });

  noneMsg.classList.toggle('hidden', visible !== 0);

  Swal.fire({
    toast: true,
    icon: visible ? 'info' : 'warning',
    title: visible ? `Loaded reports from ${location}` : `No pending reports in ${location}`,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500
  });
}

document.addEventListener("click", function (e) {
  const card = e.target.closest(".report-card");
  if (!card || e.target.tagName === "BUTTON" || e.target.closest("form")) return;

  document.getElementById("modalLocation").innerText = card.dataset.location || 'N/A';
  document.getElementById("modalStatus").innerText = card.dataset.status || 'Pending';
  document.getElementById("modalTitle").innerText = card.dataset.title || '[No Title]';
  document.getElementById("modalDescription").innerText = card.dataset.description || '[No Description]';
  document.getElementById("modalUserName").innerText = card.dataset.name || 'Anonymous';
  document.getElementById("modalUserEmail").innerText = card.dataset.email || 'No Email';

  const modal = document.getElementById('reportModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
});

function closeModal() {
  const modal = document.getElementById('reportModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function printReport() {
  const printContents = document.getElementById("printContent").innerHTML;
  const printWindow = window.open('', '', 'width=900,height=600');
  printWindow.document.write(`<html><head><title>Print Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>body{font-family:Inter,sans-serif;padding:40px;background:#fff;}</style></head>
    <body onload="window.print();window.close();">${printContents}</body></html>`);
  printWindow.document.close();
}
</script>

</body>
</html>
