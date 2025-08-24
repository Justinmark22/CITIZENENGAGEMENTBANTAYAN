<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sta.Fe Dashboard</title>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
:root {
  --primary: #0a2e61;
  --bg-light: #f8fafc;
  --bg-card: #ffffff;
  --text-muted: #6b7280;
  --shadow: 0 2px 10px rgba(0,0,0,0.08);
  --radius: 12px;
}

/* Prevent horizontal scroll */
body, html {
  overflow-x: hidden;
  -webkit-text-size-adjust: 100%;
  -moz-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  text-size-adjust: 100%;
}

/* Ensure images/videos scale on mobile */
img, video {
  max-width: 100%;
  height: auto;
}

/* ✅ Base Styling */
body {
  font-family: 'Inter', sans-serif;
  background-color: var(--bg-light);
  color: #1f2937;
  margin: 0;
  padding: 0;
  line-height: 1.5;
}

/* Responsive container */
.container {
  width: 100%;
  max-width: 100%;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
}

@media(min-width: 768px) {
  .container {
    max-width: 720px;
  }
}
@media(min-width: 992px) {
  .container {
    max-width: 960px;
  }
}
@media(min-width: 1200px) {
  .container {
    max-width: 1140px;
  }
}

/* ✅ Section Titles scale down on small screens */
.section-title {
  font-size: clamp(1rem, 4vw, 1.6rem);
  font-weight: 700;
  border-left: 4px solid var(--primary);
  padding-left: 0.5rem;
  margin-bottom: 1rem;
}

/* Button adjustments for small screens */
.btn {
  padding: 0.5rem 1rem;
  font-weight: 600;
  font-size: 0.9rem;
  border-radius: 0.5rem;
  width: auto;
}

@media (max-width: 480px) {
  .btn {
    padding: 0.6rem 1rem;
    font-size: 1rem;
  }
  .section-title {
    font-size: 1.2rem;
  }
}

/* ✅ Dashboard cards with mobile spacing */
.dashboard-card {
  background: var(--bg-card);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 1rem;
  margin-bottom: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.dashboard-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

/* ✅ Responsive Grid */
.grid-responsive {
  display: grid;
  gap: 1rem;
  grid-template-columns: 1fr;
}
@media (min-width: 640px) {
  .grid-responsive {
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  }
}

/* ✅ Scrollable lists safe height */
.scrollable-list {
  max-height: 250px;
  overflow-y: auto;
}

/* ✅ Image Item Cards */
.item-with-image {
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: var(--radius);
  padding: 0.75rem;
  gap: 0.75rem;
  box-shadow: inset 0 0 0 1px #e2e8f0;
}
.item-with-image .thumbnail {
  width: 100%;
  max-height: 180px;
  object-fit: cover;
  border-radius: 0.5rem;
}
.item-with-image .content {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

/* ✅ On larger screens, switch layout */
@media (min-width: 768px) {
  .item-with-image {
    flex-direction: row;
  }
  .item-with-image .thumbnail {
    width: 120px;
    height: 120px;
  }
}

/* ✅ Animations */
.smooth-fade-slide {
  animation: fadeSlideIn 0.6s ease-out both;
}
@keyframes fadeSlideIn {
  0% { opacity: 0; transform: translateY(40px); }
  100% { opacity: 1; transform: translateY(0); }
}
.slide-down {
  animation: slideDown 0.5s ease-out both;
}
@keyframes slideDown {
  0% { opacity: 0; transform: translateY(-20px); }
  100% { opacity: 1; transform: translateY(0); }
}
.fade-in {
  opacity: 0;
  animation: fadeIn 0.6s ease forwards;
}
@keyframes fadeIn {
  to { opacity: 1; }
}
.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }

/* ✅ Input focus effect */
.smooth-field {
  transition: all 0.3s ease;
}
.smooth-field:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
}

/* ✅ Pulse animation */
.pulse-olive {
  animation: pulseOlive 2s infinite;
}
@keyframes pulseOlive {
  0% { box-shadow: 0 0 0 0 rgba(128, 128, 0, 0.5); }
  70% { box-shadow: 0 0 0 10px rgba(128, 128, 0, 0); }
  100% { box-shadow: 0 0 0 0 rgba(128, 128, 0, 0); }
}
/* Sidebar container */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 250px;
  background-color: var(--primary);
  color: white;
  padding: 1rem;
  box-shadow: var(--shadow);
  overflow-y: auto;
  transition: transform 0.3s ease;
  z-index: 1000;
}

/* Sidebar hidden by default on mobile */
.sidebar.closed {
  transform: translateX(-100%);
}

/* Sidebar visible on desktop */
@media (min-width: 768px) {
  .sidebar {
    transform: translateX(0) !important;
    position: relative;
    height: auto;
    box-shadow: none;
  }
}

/* Content area with sidebar margin */
.content {
  margin-left: 0;
  transition: margin-left 0.3s ease;
}

@media (min-width: 768px) {
  .content {
    margin-left: 250px;
  }
}

/* Overlay for mobile when sidebar is open */
.sidebar-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.4);
  z-index: 999;
  transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
  display: block;
}

  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4 py-3">
  <div class="container-fluid">
    <!-- Left side: logo + title -->
    <a class="navbar-brand d-flex align-items-center gap-3" href="#" style="min-width: 180px;">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" width="48" height="48" class="rounded-circle" style="object-fit: cover;">
      <span class="fs-5 fw-semibold mb-0 text-dark">Santa.Fe Dashboard</span>
    </a>

    <!-- Mobile toggler -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Right side nav items -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center gap-3" style="flex-wrap: wrap;">
        <li class="nav-item">
          <button type="button" class="btn btn-sm rounded-pill px-4 py-2 fw-semibold text-white" style="background-color: olive; min-width: 140px; white-space: nowrap;">
            <i class="bi bi-ui-checks-grid me-2"></i> Join the Survey
          </button>
        </li>
        
       <li class="nav-item">
  <a class="nav-link d-flex align-items-center gap-1 text-dark" href="{{ route('certificate.request') }}" style="cursor: pointer;">
    <i class="bi bi-file-earmark-text fs-5"></i> Request Certificate
  </a>
</li>


        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center gap-1 text-dark" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="markAlertsAsRead()" style="cursor: pointer;">
            <i class="bi bi-bell fs-5"></i> Alerts
            @if($alerts->count() > 0)
              <span id="alertBadge" class="badge bg-danger ms-1" style="font-size: 0.65rem;">{{ $alerts->count() }}</span>
            @endif
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3 shadow rounded-3" aria-labelledby="alertsDropdown" style="min-width: 320px; max-height: 360px; overflow-y: auto;">
            <h6 class="dropdown-header mb-3 text-dark">Nearby Alerts</h6>
            @forelse ($alerts as $alert)
              <li onclick="showAlertModal({{ $alert->id }}, '{{ $alert->title }}', '{{ $alert->message }}')" 
                  class="dropdown-item small bg-light rounded mb-2 border-start border-4 border-primary text-dark" 
                  style="cursor: pointer;">
                <strong class="me-1">🚨 {{ $alert->title }}</strong>
                <em class="text-muted">{{ $alert->message }}</em>
              </li>
            @empty
              <li class="dropdown-item text-muted small">No alerts available.</li>
            @endforelse
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center gap-1 text-dark" href="#" id="feedbackDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <i class="bi bi-chat-dots fs-5"></i> Feedback
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3 shadow rounded-3" aria-labelledby="feedbackDropdown" style="min-width: 280px;">
            <li>
              <a href="{{ route('feedback.page') }}" class="text-dark small text-decoration-none d-block p-2 rounded bg-light border-start border-4 border-primary">
                <h6 class="fw-semibold mb-1">Got ideas or concerns?</h6>
                <p class="mb-0">Share your thoughts.</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center gap-1 text-dark" href="#" id="supportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <i class="bi bi-life-preserver fs-5"></i> Support
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-2 shadow rounded-3" aria-labelledby="supportDropdown" style="min-width: 220px;">
            <li>
              <a href="{{ route('contact.support.page') }}" class="dropdown-item d-flex align-items-center gap-2 text-dark">
                <i class="bi bi-life-preserver"></i> Contact Support
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link text-dark fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#reportModal" aria-label="Submit a new concern" style="letter-spacing: 0.04em;">
            + Submit Concern
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center gap-2 text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 36px; height: 36px;">
              <i class="bi bi-person-circle fs-5 text-primary"></i>
            </div>
            <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Guest' }}</span>
            <i class="bi bi-chevron-down small"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-4 border-0 animate__animated animate__fadeIn" aria-labelledby="userDropdown" style="min-width: 280px;">
            <li class="px-3 py-3 bg-light rounded-top">
              <div class="d-flex flex-column">
                <strong class="text-dark">{{ Auth::user()->name ?? 'Guest' }}</strong>
                <small class="text-muted">{{ Auth::user()->email ?? 'No Email' }}</small>
                <small class="text-secondary">{{ Auth::user()->location ?? 'No Location' }}</small>
              </div>
            </li>
            <li><hr class="dropdown-divider my-1" /></li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-gear text-primary"></i> <span>Settings</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Logout Confirmation',
      text: "Do you really want to logout?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#2563eb',
      cancelButtonColor: '#9ca3af',
      confirmButtonText: 'Logout',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-secondary'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }
</script>


      </ul>
    </div>

  </div>
</nav>
<!-- Report Modal -->
<div class="modal fade animate__animated animate__fadeInDown" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg border-0">
      <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title d-flex align-items-center gap-2" id="reportModalLabel">
            <i class="bi bi-exclamation-octagon-fill fs-5"></i>
            Report an Issue
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body px-4 py-3">
          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-tags me-1 text-primary"></i>Category</label>
            <select name="category" class="form-select shadow-sm" required>
              <option value="" disabled selected>Select category</option>
              <option>Road Issue</option>
              <option>Water Management</option>
              <option>Waste Management</option>
              <option>Noise Complaint</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-type me-1 text-primary"></i>Title</label>
            <input name="title" type="text" class="form-control shadow-sm" placeholder="E.g. Damaged signage" required />
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1 text-primary"></i>Description</label>
            <textarea name="description" rows="4" class="form-control shadow-sm" placeholder="More details..." required></textarea>
          </div>

          <!-- 📸 Photo Upload -->
          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-image me-1 text-primary"></i>Upload Photo</label>
            <input type="file" name="photo" class="form-control shadow-sm" accept="image/*">
            <small class="text-muted">Optional: Upload a supporting image (JPG, PNG)</small>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-send-fill me-1"></i> Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(session('report_success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: '{{ session('report_success') }}',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      background: '#e0f7e9',
      color: '#1e4620'
    });
  });
</script>
@endif


<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered animate__animated animate__fadeInUp">
    <form method="POST" action="{{ route('user.update.settings') }}" id="settingsForm">
      @csrf
      @method('PUT')
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="animation: fadeIn 0.5s ease-in-out;">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="settingsModalLabel"> Account Settings</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-5 bg-white">
          <p class="text-muted mb-4 fs-6">
            Update your basic profile details. Your location is fixed to ensure accurate community-based access.
          </p>
          <div class="row g-4">
            <div class="col-md-6">
              <label for="name" class="form-label"> Full Name</label>
              <input name="name" type="text" class="form-control form-control-lg" id="name" value="{{ Auth::user()->name }}" placeholder="Enter your full name" required />
              <small class="text-muted">This name appears on your profile and submissions.</small>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email Address</label>
              <input name="email" type="email" class="form-control form-control-lg" id="email" value="{{ Auth::user()->email }}" placeholder="Enter your email" required />
              <small class="text-muted">Used for notifications.</small>
            </div>
            <div class="col-md-6">
              <label for="location" class="form-label"> Your Location</label>
              <input type="text" class="form-control bg-light form-control-lg" value="{{ Auth::user()->location }}" readonly />
              <small class="text-muted">location (fixed).</small>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light px-5 py-4 d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary btn-lg" onclick="confirmSettingsSave()">Save Changes</button>

        </div>
      </div>
    </form>
  </div>
</div>
<script>
  function confirmSettingsSave() {
    Swal.fire({
      title: 'Save changes?',
      text: "Your profile details will be updated.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, save it'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('settingsForm').submit();
      }
    });
  }
</script>
<!-- Hero Section (Slider) -->
<div x-data="{ currentSlide: 0 }" class="position-relative overflow-hidden py-5" style="background-color: #EFF9F1;">
  <!-- Gradient Background Circles -->
  <div class="position-absolute top-0 start-0 rounded-circle bg-success opacity-25" style="width: 200px; height: 200px; z-index: -1;"></div>
  <div class="position-absolute top-0 end-0 rounded-circle bg-success opacity-25" style="width: 400px; height: 400px; z-index: -1;"></div>
  <div class="position-absolute bottom-0 start-0 rounded-circle bg-success opacity-25" style="width: 400px; height: 400px; z-index: -1;"></div>

  <!-- Slides -->
  <div class="d-flex overflow-auto scroll-smooth" x-ref="slider"
    @scroll.debounce.300ms="currentSlide = Math.round($refs.slider.scrollLeft / $refs.slider.clientWidth)">
    
    <!-- Slide 1 -->
   <div class="min-vw-100 d-flex flex-column flex-lg-row align-items-start justify-content-start px-4 pt-4">
  <!-- Left Text -->
  <div class="text-dark" style="max-width: 600px; font-family: 'Poppins', sans-serif;">
  <h1 class="fw-bold display-5 mb-2">
    Welcome, <span class="text-success">{{ Auth::user()->name ?? 'Guest' }}</span>
  </h1>
  <h2 class="h4 text-black fw-semibold mb-3">to the Citizen Engagement Platform</h2>

  
  <p class="fs-5 text-muted mb-4">
    Nurturing and encouraging people's participation through inclusive<br />
    and accessible platforms for evidence-based policy/decision making.
  </p>


    <!-- Stats -->
    <div class="d-flex flex-wrap gap-4">
      <div class="d-flex align-items-center gap-2">
        <div class="bg-white p-2 rounded-circle shadow">
          <i class="bi bi-bar-chart-fill text-secondary"></i>
        </div>
        <span><strong class="text-success">1</strong> Project(s)</span>
      </div>
      <div class="d-flex align-items-center gap-2">
        <div class="bg-white p-2 rounded-circle shadow">
          <i class="bi bi-people-fill text-secondary"></i>
        </div>
        <span><strong class="text-success">3382</strong> Participant(s)</span>
      </div>
    </div>
  </div>


  <div class="row g-4">
   <!-- Barangay Updates -->
<div class="col-lg-6">
  <div class="card border-start border-success border-4 h-100">
    <div class="card-body">
      <h5 class="card-title text-success">Municipal Updates</h5>

      @php
        $now = \Carbon\Carbon::now();
      @endphp

      @forelse($updates as $update)
        @php
          $updateTime = \Carbon\Carbon::parse($update->update_date);
        @endphp

        @continue($now->diffInHours($updateTime) > 24)

        <div class="mb-3 p-3 bg-light border-start border-4 rounded 
          @if($update->location == 'Bantayan') border-primary 
          @elseif($update->location == 'Madridejos') border-warning 
          @else border-success @endif">
          <h6 class="fw-bold">{{ $update->title }}</h6>
          <p class="mb-1">{{ $update->message }}</p>
          <small class="text-muted">{{ $update->location }} — {{ $updateTime->toFormattedDateString() }}</small>
        </div>
      @empty
        <p class="text-muted">No recent updates available.</p>
      @endforelse

    </div>
  </div>
</div>


  <!-- Recent Reports by Status -->
<div class="col-lg-6">
  <div class="card border-start border-primary border-4 shadow-sm h-100 rounded-3">
    <div class="card-body">
      <h5 class="card-title text-primary fw-semibold mb-4">
        <i class="bi bi-clipboard-data"></i> Recent Reports
      </h5>

      <div class="overflow-auto" style="max-height: 360px;">
        @php
          $badgeColors = [
            'Pending' => 'warning',
            'Ongoing' => 'primary',
            'Resolved' => 'success',
            'Rejected' => 'danger',
          ];

          // Fetch forwarded reports for Santa.Fe (or adjust location)
          $reports = \App\Models\ForwardedReport::with('user')
                      ->where('location', 'Santa.Fe')
                      ->latest()
                      ->get();

          $groupedReports = $reports->groupBy('status');
        @endphp

        @forelse ($groupedReports as $status => $statusReports)
          <div class="mb-4">
            <h6 class="text-uppercase small fw-bold text-muted border-start border-4 ps-3 border-{{ $badgeColors[$status] ?? 'secondary' }}">
              {{ $status }}
            </h6>

            @foreach ($statusReports as $report)
              <div class="mb-3 p-3 rounded bg-light border-start border-4 border-{{ $badgeColors[$report->status] ?? 'secondary' }} shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <strong class="text-dark">{{ $report->title }}</strong>
                    <div class="small text-muted">
                      <em>{{ $report->category }}</em> |
                      <span>By: {{ $report->user ? $report->user->name : 'N/A' }}</span>
                    </div>
                  </div>
                  <span class="badge bg-{{ $badgeColors[$report->status] ?? 'secondary' }}">
                    {{ $report->status }}
                  </span>
                </div>
                <div class="small text-muted mt-1">
                  {{ $report->created_at->format('M d, Y h:i A') }}
                </div>
              </div>
            @endforeach
          </div>
        @empty
          <p class="text-muted small">No recent reports available.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>


<div class="row g-4">
  
<!-- Forwarded Announcements -->
<div class="col-lg-6">
  <div class="card shadow-lg h-100 rounded-4 border-start border-4" style="border-left-color: #fd7e14;">
    <div class="card-body p-4">
      <h5 class="card-title fw-semibold mb-4 d-flex align-items-center" style="color: #fd7e14;">
        <i class="me-2" data-lucide="repeat" style="color: #fd7e14;"></i>
        Latest Announcements
      </h5>

      <div class="overflow-auto" style="max-height: 420px;">
        @php $now = \Carbon\Carbon::now(); @endphp

        @forelse ($forwardedAnnouncements as $announcement)
          @php
            $start = \Carbon\Carbon::parse($announcement->start_date);
            $end = \Carbon\Carbon::parse($announcement->end_date);

            if ($end->lt($now)) continue;

            $status = $now->lt($start) ? 'Upcoming' : 'Ongoing';
            $badgeClass = $now->lt($start) ? 'badge bg-info' : 'badge bg-success';
          @endphp

          <div class="mb-4 p-3 rounded-3 bg-white border-start border-5 shadow-sm position-relative" style="border-left-color: #fd7e14;">
            <div class="d-flex justify-content-between align-items-start">
              <h6 class="fw-bold text-dark mb-1">{{ $announcement->title }}</h6>
              <span class="{{ $badgeClass }}">{{ $status }}</span>
            </div>

            <p class="text-muted small mb-2">{{ Str::limit($announcement->message, 150) }}</p>

            <div class="d-flex flex-column small text-secondary">
              <div class="mb-1"><strong>Barangay:</strong> {{ $announcement->barangay }}</div>
              <div class="mb-1"><strong>Start Date:</strong> {{ $start->format('M d, Y') }}</div>
              <div class="mb-1"><strong>End Date:</strong> {{ $end->format('M d, Y') }}</div>
              <div><i class="bi bi-clock me-1"></i>Forwarded on {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}</div>
            </div>
          </div>
        @empty
          <p class="text-muted small">No forwarded announcements available.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

   <!-- Upcoming Events -->
<div class="col-lg-6">
  <div class="card border-start border-info border-4 shadow-sm h-100">
    <div class="card-body">
      <h5 class="card-title text-info">Upcoming Events</h5>

      @php
        $today = \Carbon\Carbon::today();
        $hasUpcoming = false;
      @endphp

      @foreach($forwardedEvents as $event)
        @php
          $eventDate = \Carbon\Carbon::parse($event->event_date);
        @endphp

        @continue($eventDate->lt($today)) {{-- Skip if past the event date --}}

        @php $hasUpcoming = true; @endphp

        <div class="mb-3 p-3 bg-white border-start border-4 rounded 
            @if($event->location == 'Bantayan') border-primary 
            @elseif($event->location == 'Madridejos') border-warning 
            @else border-success @endif">
          <h6 class="fw-bold">{{ $event->title }}</h6>
          <p class="mb-1">
            <span class="badge bg-secondary">{{ $event->category }}</span>
          </p>
          <p class="mb-0"><strong>Date:</strong> {{ $eventDate->format('F j, Y') }}</p>
          <p class="mb-0"><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
          <small class="text-muted">{{ $event->location }}</small>
        </div>
      @endforeach

      @if(!$hasUpcoming)
        <p class="text-muted">No upcoming forwarded events in Santa Fe.</p>
      @endif

    </div>
  </div>
</div>



      <!-- Right Image -->
      <div class="text-center">
       
      </div>
    </div>
    
  
  </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
  </div>
</body>
</html>



</body>
</html>
