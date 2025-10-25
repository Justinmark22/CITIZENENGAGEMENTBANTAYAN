<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Santa Fe - Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body { background-color: rgb(181, 202, 199); font-family: 'Segoe UI', sans-serif; }
    .sidebar { height: 100vh; width: 240px; background: linear-gradient(180deg,rgb(130, 228, 174), #1d4ed8); color: #fff; position: fixed; top: 0; left: 0; padding: 2rem 1rem; }
    .sidebar a { display: flex; align-items: center; padding: 0.75rem 1rem; color: #cbd5e1; text-decoration: none; font-weight: 500; border-radius: 8px; margin-bottom: 1rem; }
    .sidebar a:hover { background-color: rgba(255, 255, 255, 0.1); color: #fff; }
    .navbar { padding: 1rem 2rem; background-color: #fff; border-bottom: 1px solid #e2e8f0; margin-left: 240px; }
    .main { margin-left: 240px; padding: 2rem; }
    .report-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(6px); border-radius: 16px; transition: all 0.3s ease-in-out; }
    .report-card:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .hover-glow:hover { box-shadow: 0 0 10px rgba(59, 130, 246, 0.2); }
    .bg-gradient-success { background: linear-gradient(to right, #4ade80, #22c55e); color: #fff !important; }
    .bg-gradient-danger { background: linear-gradient(to right, #f87171, #ef4444); color: #fff !important; }
    .bg-gradient-info { background: linear-gradient(to right, #38bdf8, #0ea5e9); color: #fff !important; }
    .bg-gradient-warning { background: linear-gradient(to right, #facc15, #eab308); color: #000 !important; }
    .cursor-pointer { cursor: pointer; }
    .dropdown-menu { z-index: 2000; }
    /* Modal Animations */
    .modal.fade.custom-fade .modal-dialog { opacity: 0; transform: translateY(40px) scale(0.97); transition: all 0.4s ease; }
    .modal.fade.custom-fade.show .modal-dialog { opacity: 1; transform: translateY(0) scale(1); }
    .hover-scale { transition: transform 0.2s ease-in-out; }
    .hover-scale:hover { transform: scale(1.05); }
  </style>
</head>
<body>

<div class="sidebar p-3">
  <div class="text-center mb-4">
    <img src="{{ asset('images/santafe.png') }}" alt="Santa Fe Logo" class="img-fluid rounded-circle" style="max-height: 80px; width: 80px; object-fit: cover;">
  </div>
  <a href="{{ route('dashboard.santafeadmin') }}"><i data-lucide="home" class="me-2"></i> Dashboard</a>
  <a href="{{ route('santafe.users.index') }}"><i data-lucide="users" class="me-2"></i> Users</a>
  <a href="{{ route('santafe.reports') }}"><i data-lucide="file-text" class="me-2"></i> Reports</a>
  <a href="{{ route('santafe.feedback') }}"><i data-lucide="message-square" class="me-2"></i> Feedback</a>
  <a href="{{ route('santafe.announcements') }}"><i data-lucide="megaphone" class="me-2"></i> Announcements</a>
  <a href="{{ route('santa_fe.events') }}"><i data-lucide="calendar-days" class="me-2"></i> Events</a>
  <a href="{{ route('santafe.updates') }}"><i data-lucide="message-square" class="me-2"></i> Updates</a>
</div>

<div class="navbar d-flex justify-content-between align-items-center">
  <h5 class="mb-0">📣 Announcements Panel</h5>
  <div class="dropdown">
    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 border rounded-pill shadow-sm"
      type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <i data-lucide="user-cog" class="text-primary"></i>
      <span class="text-muted small">Admin • {{ Auth::user()->email ?? 'admin@santafe.gov' }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-lg p-4 rounded-4" style="width: 280px;" aria-labelledby="adminDropdown">
      <li class="mb-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <i data-lucide="moon" class="text-secondary"></i>
          <span class="text-muted">Dark Mode</span>
        </div>
        <div class="form-check form-switch m-0">
          <input class="form-check-input" type="checkbox" id="darkModeToggle">
        </div>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i data-lucide="log-out"></i> Logout
        </a>
      </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
  </div>
</div>

<div class="main">
  <div class="card-box mb-4">
    <h5 class="mb-4">Report Management</h5>

<form method="GET" action="{{ route('santafe.reports') }}" class="row g-2 mb-4">
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">All Status</option>
      <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
      <option value="Ongoing" {{ request('status')=='Ongoing'?'selected':'' }}>Ongoing</option>
      <option value="Resolved" {{ request('status')=='Resolved'?'selected':'' }}>Resolved</option>
      <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary w-100"><i data-lucide="filter" class="me-1"></i> Filter</button>
  </div>
</form>

@forelse ($reports as $report)
  <div class="card border-0 shadow-sm mb-4 report-card position-relative hover-glow">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-start gap-3">
      <div class="flex-grow-1 pe-3">
<h6 class="fw-bold text-dark mb-1 cursor-pointer"
    data-bs-toggle="modal"
    data-bs-target="#reportModal"
    data-title="{{ $report->title }}"
    data-description="{{ $report->description }}"
    data-location="{{ $report->location }}"
    data-status="{{ $report->status }}"
    data-date="{{ $report->created_at->format('M d, Y H:i') }}"
    data-photo="{{ $report->photo ? asset('reports/' . $report->photo) : '' }}"
    data-name="{{ $report->user->name ?? 'Anonymous' }}"
    data-email="{{ $report->user->email ?? 'No Email' }}">
    {{ $report->title }}
</h6>

        <p class="text-muted small mb-2">{{ Str::limit($report->description, 120) }}</p>
        <div class="text-muted small d-flex align-items-center flex-wrap gap-3 mb-1">
          <span><i data-lucide="map-pin" class="me-1"></i> {{ $report->location }}</span>
          <span><i data-lucide="clock" class="me-1"></i> {{ $report->created_at->format('M d, Y H:i') }}</span>
        </div>
        <div class="text-muted small d-flex align-items-center flex-wrap gap-3">
          <span><i data-lucide="user" class="me-1"></i> {{ $report->user->name ?? 'Anonymous' }}</span>
          <span><i data-lucide="mail" class="me-1"></i> {{ $report->user->email ?? 'No Email' }}</span>
        </div>
      </div>

      <!-- Status Badge -->
      <div class="text-end">
        <span class="badge rounded-pill px-3 py-2 fw-semibold text-uppercase shadow-sm
          @if($report->status === 'Resolved') bg-gradient-success
          @elseif($report->status === 'Rejected') bg-gradient-danger
          @elseif($report->status === 'Ongoing') bg-gradient-info
          @else bg-gradient-warning
          @endif">
          {{ $report->status }}
        </span>
      </div>
    </div>
  </div>
@empty
  <div class="alert alert-info">No reports found.</div>
@endforelse

<!-- Report Modal -->
<div class="modal fade custom-fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-animated">
    <div class="modal-content shadow-xl border-0 rounded-4" style="backdrop-filter: blur(18px); background: rgba(255,255,255,0.96); transition: all 0.4s ease;">
      <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, #3b82f6, #06b6d4); border-bottom: none;">
        <h4 class="modal-title d-flex align-items-center gap-2 fw-bold" id="reportModalLabel">
          <i data-lucide="radar" class="me-1"></i> Report Overview
        </h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="px-5 pt-4 pb-3 border-bottom" style="border-color: rgba(0,0,0,0.08);">
        <div class="d-flex flex-wrap gap-4 text-muted small">
          <div class="d-flex align-items-center gap-2">
            <i data-lucide="user" class="text-primary"></i>
            <span id="modalReportName" class="fw-semibold text-dark">Anonymous</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i data-lucide="mail" class="text-primary"></i>
            <span id="modalReportEmail" class="fw-semibold text-dark">No Email</span>
          </div>
        </div>
      </div>
      <div class="modal-body px-5 py-4">
        <div class="row g-4">
          <div class="col-md-7">
            <div class="mb-3"><label class="text-muted small">Title</label><div id="modalReportTitle" class="fw-semibold fs-5 text-dark"></div></div>
            <div class="mb-3"><label class="text-muted small">Location</label><div id="modalReportLoc" class="fs-6 text-dark"></div></div>
            <div class="mb-3"><label class="text-muted small">Description</label><div id="modalReportDesc" class="bg-light p-3 rounded-3 shadow-sm fs-6 text-dark"></div></div>
            <div class="row">
              <div class="col-md-6 mb-3"><label class="text-muted small">Status</label><div id="modalReportStatus" class="badge rounded-pill px-3 py-2 fs-6 text-bg-warning text-uppercase fw-semibold shadow-sm"></div></div>
              <div class="col-md-6 mb-3"><label class="text-muted small">Submitted</label><div id="modalReportDate" class="fs-6 text-dark"></div></div>
            </div>
          </div>
          <div class="col-md-5">
            <label class="text-muted small">Photo</label>
            <div class="bg-light p-3 rounded-3 shadow-sm text-center">
              <img id="modalReportPhoto" src="" alt="Report Photo" class="img-fluid rounded-3 shadow-sm d-none" style="max-height: 280px; object-fit: cover;">
              <p id="noPhotoText" class="text-muted m-0">No photo available</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light border-top rounded-bottom px-4 py-3 d-flex justify-content-between align-items-center">
        <small class="text-muted d-flex align-items-center gap-2"><i data-lucide="cpu"></i> Santa Fe</small>
        <div>
          <button type="button" class="btn btn-outline-secondary hover-scale" data-bs-dismiss="modal"><i data-lucide="x" class="me-1"></i> Close</button>
          <button type="button" id="printButton" class="btn btn-primary hover-scale d-none" onclick="printReport()"><i data-lucide="printer" class="me-1"></i> Print</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('reportModal');

  modal.addEventListener('show.bs.modal', event => {
    const trigger = event.relatedTarget;

    // Fill modal fields
    document.getElementById('modalReportTitle').textContent = trigger.dataset.title;
    document.getElementById('modalReportDesc').textContent = trigger.dataset.description;
    document.getElementById('modalReportLoc').textContent = trigger.dataset.location;
    document.getElementById('modalReportStatus').textContent = trigger.dataset.status;
    document.getElementById('modalReportDate').textContent = trigger.dataset.date;
    document.getElementById('modalReportName').textContent = trigger.dataset.name;
    document.getElementById('modalReportEmail').textContent = trigger.dataset.email;

    const photoEl = document.getElementById('modalReportPhoto');
    const noPhoto = document.getElementById('noPhotoText');

    if(trigger.dataset.photo && trigger.dataset.photo.trim() !== ''){
      photoEl.src = trigger.dataset.photo;
      photoEl.classList.remove('d-none');
      noPhoto.classList.add('d-none');
    } else {
      photoEl.classList.add('d-none');
      noPhoto.classList.remove('d-none');
    }

    // Update badge color
    const badge = document.getElementById('modalReportStatus');
    badge.classList.remove('text-bg-warning', 'text-bg-success', 'text-bg-danger', 'text-bg-info');
    if (trigger.dataset.status === 'Ongoing') badge.classList.add('text-bg-info');
    else if (trigger.dataset.status === 'Resolved') badge.classList.add('text-bg-success');
    else if (trigger.dataset.status === 'Rejected') badge.classList.add('text-bg-danger');
    else badge.classList.add('text-bg-warning');

    // Show print button only if status is Ongoing
    document.getElementById('printButton').classList.toggle('d-none', trigger.dataset.status !== 'Ongoing');
  });
});

// Initialize Lucide icons
lucide.createIcons();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
