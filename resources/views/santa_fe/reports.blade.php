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
    body {
      background-color: rgb(181, 202, 199);
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      height: 100vh;
      width: 240px;
       background: linear-gradient(180deg,rgb(130, 228, 174), #1d4ed8);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      padding: 2rem 1rem;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: #cbd5e1;
      text-decoration: none;
      font-weight: 500;
      border-radius: 8px;
      margin-bottom: 1rem;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }
    .navbar {
      padding: 1rem 2rem;
      background-color: #fff;
      border-bottom: 1px solid #e2e8f0;
      margin-left: 240px;
    }

    .main {
      margin-left: 240px;
      padding: 2rem;
    }
    
    .report-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(6px);
    border-radius: 16px;
    transition: all 0.3s ease-in-out;
  }

  .report-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
  }

  .hover-glow:hover {
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
  }

  .bg-gradient-success {
    background: linear-gradient(to right, #4ade80, #22c55e);
    color: #fff !important;
  }

  .bg-gradient-danger {
    background: linear-gradient(to right, #f87171, #ef4444);
    color: #fff !important;
  }

  .bg-gradient-info {
    background: linear-gradient(to right, #38bdf8, #0ea5e9);
    color: #fff !important;
  }

  .bg-gradient-warning {
    background: linear-gradient(to right, #facc15, #eab308);
    color: #000 !important;
  }

  .cursor-pointer {
    cursor: pointer;
  }
  .dropdown-menu {
  z-index: 2000; /* Force it above modal/content */
}

  </style>
</head>
<body>

  <div class="sidebar p-3 bg-light" style="min-height: 100vh;">
  

  
<!-- Logo Section -->
 <div class="text-center mb-4">
  <img src="{{ asset('images/santafe.png') }}" alt="Santa Fe Logo" class="img-fluid rounded-circle" style="max-height: 80px; width: 80px; object-fit: cover;">
</div>

  <!-- Menu Links -->
  <a href="{{ route('dashboard.santafeadmin') }}">
  <i data-lucide="home" class="me-2"></i> Dashboard
</a>
  <a href="{{ route('santafe.users.index') }}">
    <i data-lucide="users" class="me-2"></i> Users
  </a>
  <a href="{{ route('santafe.reports') }}">
    <i data-lucide="file-text" class="me-2"></i> Reports
  </a>
  <a href="{{ route('santafe.feedback') }}">
    <i data-lucide="message-square" class="me-2"></i> Feedback
  </a>
  <a href="{{ route('santafe.announcements') }}">
    <i data-lucide="megaphone" class="me-2"></i> Announcements
  </a>
  <a href="{{ route('santa_fe.events') }}">
    <i data-lucide="calendar-days" class="me-2"></i> Events
  </a>
 <a href="{{ route('santafe.updates') }}">
  <i data-lucide="message-square" class="me-2"></i> Updates
</a>
 
</div>
  <!-- Navbar -->
<div class="navbar d-flex justify-content-between align-items-center">
  <h5 class="mb-0">📣 Announcements Panel</h5>
    <div class="dropdown">
  <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 border rounded-pill shadow-sm"
          type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i data-lucide="user-cog" class="text-primary"></i>
    <span class="text-muted small">
      Admin • {{ Auth::user()->email ?? 'admin@santafe.gov' }}
    </span>
  </button>

  <ul class="dropdown-menu dropdown-menu-end shadow-lg p-4 rounded-4" style="width: 280px;" aria-labelledby="adminDropdown">
    
    <!-- Dark Mode Toggle -->
    <li class="mb-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <i data-lucide="moon" class="text-secondary"></i>
        <span class="text-muted">Dark Mode</span>
      </div>
      <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="darkModeToggle"
               title="Toggle dark theme">
      </div>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- Logout -->
    <li>
      <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i data-lucide="log-out"></i> Logout
      </a>
    </li>
  </ul>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</div>
  </div>
  </div>
<div class="main">
  <div class="card-box mb-4">
    <h5 class="mb-4">Report Management</h5>

    <!-- Filters -->
   <form method="GET" action="{{ route('santafe.reports') }}" class="row g-2 mb-4">
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">All Status</option>
      <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
      <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
      <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
      <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary w-100"><i data-lucide="filter" class="me-1"></i> Filter</button>
  </div>
</form>
<!-- Reports List -->
@forelse ($reports as $report)
  <div class="card border-0 shadow-sm mb-4 report-card position-relative hover-glow">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-start gap-3">
      <!-- Report Info -->
      <div class="flex-grow-1 pe-3">
        <h6 class="fw-bold text-dark mb-1 cursor-pointer d-flex align-items-center gap-2"
            data-bs-toggle="modal"
            data-bs-target="#reportModal"
            data-title="{{ $report->title }}"
            data-description="{{ $report->description }}"
            data-location="{{ $report->location }}"
            data-status="{{ $report->status }}"
            data-date="{{ $report->created_at->format('M d, Y H:i') }}"
            data-photo="{{ $report->photo ? asset('storage/'.$report->photo) : '' }}">
          {{ $report->title }}
        </h6>

        <p class="text-muted small mb-2">{{ Str::limit($report->description, 120) }}</p>

        <!-- Report Meta Info -->
        <div class="text-muted small d-flex align-items-center flex-wrap gap-3 mb-1">
          <span><i data-lucide="map-pin" class="me-1"></i> {{ $report->location }}</span>
          <span><i data-lucide="clock" class="me-1"></i> {{ $report->created_at->format('M d, Y H:i') }}</span>
        </div>

        <div class="text-muted small d-flex align-items-center flex-wrap gap-3">
          <span><i data-lucide="user" class="me-1"></i> {{ $report->user->name ?? 'Anonymous' }}</span>
          <span><i data-lucide="mail" class="me-1"></i> {{ $report->user->email ?? 'No Email' }}</span>
        </div>

        <!-- Debug Photo -->
        <div class="mt-2">
          @if ($report->photo)
            <p class="text-success small">Photo exists: {{ asset('storage/'.$report->photo) }}</p>
            <img src="{{ asset('storage/'.$report->photo) }}" alt="Report Photo" class="img-thumbnail" style="max-width:150px;">
          @else
            <p class="text-danger small">No photo uploaded</p>
          @endif
        </div>
      </div>

      <div class="mt-4">
        {{ $reports->withQueryString()->links() }}
      </div>

      <!-- Report Status & Dropdown -->
      <div class="text-end" style="z-index: 1050;">
        <!-- Status Badge -->
        <span class="badge rounded-pill px-3 py-2 fw-semibold text-uppercase shadow-sm mb-2 d-inline-block
          @if($report->status === 'Resolved') bg-gradient-success 
          @elseif($report->status === 'Rejected') bg-gradient-danger 
          @elseif($report->status === 'Ongoing') bg-gradient-info 
          @else bg-gradient-warning 
          @endif">
          {{ $report->status }}
        </span>

        <!-- Dropdown Actions -->
        <div class="dropup">
          <button 
            class="btn btn-sm bg-light border-0 shadow-sm rounded-3 px-3 py-2 d-flex align-items-center gap-2 dropdown-toggle" 
            type="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
            style="font-size: 0.875rem;">
            <i data-lucide="settings" class="text-muted"></i> Actions
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow rounded-3" style="z-index: 2000;">
            @if($report->status === 'Resolved')
              <li>
                <a href="{{ route('santafe.export', $report->id) }}" class="dropdown-item d-flex align-items-center gap-2 text-primary">
                  <i data-lucide="download"></i> Export PDF
                </a>
              </li>
            @else
              <li>
                <form method="POST" action="{{ route('santafe.reports.update', $report->id) }}">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="Ongoing">
                  <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-info">
                    <i data-lucide="loader"></i> Mark as Ongoing
                  </button>
                </form>
              </li>
              <li>
                <form method="POST" action="{{ route('santafe.reports.update', $report->id) }}">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="Resolved">
                  <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-success">
                    <i data-lucide="check-circle"></i> Mark as Resolved
                  </button>
                </form>
              </li>
              <li>
                <form method="POST" action="{{ route('santafe.reports.update', $report->id) }}">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="Rejected">
                  <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                    <i data-lucide="x-circle"></i> Mark as Rejected
                  </button>
                </form>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
@empty
  <div class="alert alert-info">No reports found.</div>
@endforelse


  </div>
</div>
<!-- 🌟 Clean & Polished Report Modal -->
<div class="modal fade custom-fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-animated">
    <div class="modal-content shadow-xl border-0 rounded-4"
         style="backdrop-filter: blur(18px); background: rgba(255,255,255,0.96); transition: all 0.4s ease;">

      <!-- 🔹 Header -->
      <div class="modal-header text-white py-3 px-4"
           style="background: linear-gradient(135deg, #3b82f6, #06b6d4); border-bottom: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h4 class="modal-title d-flex align-items-center gap-2 fw-bold" id="reportModalLabel">
          <i data-lucide="radar" class="me-1"></i> Report Overview
        </h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- 🔹 Reporter Info -->
      <div class="px-5 pt-4 pb-3 border-bottom" style="border-color: rgba(0,0,0,0.08);">
        <div class="d-flex flex-wrap gap-4 text-muted small">
          <div class="d-flex align-items-center gap-2">
            <i data-lucide="user" class="text-primary"></i>
            <span id="modalReportName" class="fw-semibold text-dark">{{ $report->user->name ?? 'Anonymous' }}</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i data-lucide="mail" class="text-primary"></i>
            <span id="modalReportEmail" class="fw-semibold text-dark">{{ $report->user->email ?? 'No Email' }}</span>
          </div>
        </div>
      </div>

      <!-- 🔹 Body -->
      <div class="modal-body px-5 py-4">
        <div class="row g-4">

          <!-- 📌 Left Column: Details -->
          <div class="col-md-7">
            <div class="mb-3">
              <label class="text-muted small">Title</label>
              <div id="modalReportTitle" class="fw-semibold fs-5 text-dark"></div>
            </div>

            <div class="mb-3">
              <label class="text-muted small">Location</label>
              <div id="modalReportLoc" class="fs-6 text-dark"></div>
            </div>

            <div class="mb-3">
              <label class="text-muted small">Description</label>
              <div id="modalReportDesc" class="bg-light p-3 rounded-3 shadow-sm fs-6 text-dark"></div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-muted small">Status</label>
                <div id="modalReportStatus"
                     class="badge rounded-pill px-3 py-2 fs-6 text-bg-warning text-uppercase fw-semibold shadow-sm"></div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="text-muted small">Submitted</label>
                <div id="modalReportDate" class="fs-6 text-dark"></div>
              </div>
            </div>
          </div>

          <!-- 📌 Right Column: Photo -->
          <div class="col-md-5">
            <label class="text-muted small">Photo</label>
            <div class="bg-light p-3 rounded-3 shadow-sm text-center">
              <img id="modalReportPhoto" src="" alt="Report Photo"
                   class="img-fluid rounded-3 shadow-sm d-none" style="max-height: 280px; object-fit: cover;">
              <p id="noPhotoText" class="text-muted m-0">No photo available</p>
            </div>
          </div>

        </div>
      </div>
<!-- 🔹 Footer -->
<div class="modal-footer bg-light border-top rounded-bottom px-4 py-3 d-flex justify-content-between align-items-center">
  <small class="text-muted d-flex align-items-center gap-2">
    <i data-lucide="cpu"></i> Santa Fe
  </small>

 @foreach ($reports as $report)
  <div id="report-{{ $report->id }}" class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">

      <!-- Status badge -->
      <span class="badge {{ $report->status === 'Forwarded' ? 'bg-success' : 'bg-secondary' }}" data-role="status-badge">
        {{ $report->status ?? 'Pending' }}
      </span>

      <!-- Forward Dropdown -->
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button"
                id="forwardDropdown{{ $report->id }}" data-bs-toggle="dropdown" aria-expanded="false">
          <i data-lucide="send" class="me-1"></i> Forward To
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3"
            aria-labelledby="forwardDropdown{{ $report->id }}">
          <li><a class="dropdown-item" href="javascript:void(0)" onclick="forwardReport({{ $report->id }}, 'MDRRMO')">MDRRMO</a></li>
          <li><a class="dropdown-item" href="javascript:void(0)" onclick="forwardReport({{ $report->id }}, 'WASTEMANAGEMENT')">WASTEMANAGEMENT</a></li>
          <li><a class="dropdown-item" href="javascript:void(0)" onclick="forwardReport({{ $report->id }}, 'WATERMANAGEMENT')">WATERMANAGEMENT</a></li>
          <li><a class="dropdown-item" href="javascript:void(0)" onclick="forwardReport({{ $report->id }}, 'Health Office')">Health Office</a></li>
        </ul>
      </div>

    </div>
  </div>
@endforeach
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide/dist/lucide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Initialize Lucide icons
  lucide.createIcons();

  // Forward report function
  function forwardReport(reportId, office) {
    Swal.fire({
      title: "Forward Report?",
      text: `Do you want to forward report #${reportId} to ${office}?`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, forward",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (!result.isConfirmed) return;

      Swal.fire({
        title: "Forwarding...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });

      fetch("{{ route('reports.forward') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ report_id: reportId, forwarded_to: office })
      })
      .then(async res => {
        let data = await res.json();
        Swal.close();
        if (res.ok && data.success) {
          Swal.fire({
            icon: "success",
            title: "Forwarded!",
            text: `Report has been forwarded to ${office}.`,
            timer: 2000,
            showConfirmButton: false
          });
          const badge = document.querySelector(`#report-${reportId} [data-role="status-badge"]`);
          if (badge) {
            badge.textContent = `Forwarded to ${office}`;
            badge.classList.remove("bg-secondary");
            badge.classList.add("bg-success");
          }
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message || "Something went wrong."
          });
        }
      })
      .catch(err => {
        Swal.close();
        Swal.fire({
          icon: "error",
          title: "Request Failed",
          text: err.message || "Please try again."
        });
      });
    });
  }

  // Modal event listener
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('reportModal');

    modal.addEventListener('show.bs.modal', function (event) {
      const trigger = event.relatedTarget;

      const title = trigger.getAttribute('data-title');
      const desc = trigger.getAttribute('data-description');
      const loc = trigger.getAttribute('data-location');
      const status = trigger.getAttribute('data-status');
      const date = trigger.getAttribute('data-date');
      const photo = trigger.getAttribute('data-photo');

      document.getElementById('modalReportTitle').textContent = title;
      document.getElementById('modalReportDesc').textContent = desc;
      document.getElementById('modalReportLoc').textContent = loc;
      document.getElementById('modalReportStatus').textContent = status;
      document.getElementById('modalReportDate').textContent = date;

      // Photo handling
      const photoElement = document.getElementById('modalReportPhoto');
      const noPhotoText = document.getElementById('noPhotoText');
      if(photo && photo.trim() !== '') {
        photoElement.src = photo;
        photoElement.classList.remove('d-none');
        noPhotoText.classList.add('d-none');
      } else {
        photoElement.classList.add('d-none');
        noPhotoText.classList.remove('d-none');
      }

      // Status badge color
      const badge = document.getElementById('modalReportStatus');
      badge.classList.remove('text-bg-warning', 'text-bg-success', 'text-bg-danger', 'text-bg-info');
      if (status === 'Ongoing') badge.classList.add('text-bg-info');
      else if (status === 'Resolved') badge.classList.add('text-bg-success');
      else if (status === 'Rejected') badge.classList.add('text-bg-danger');
      else badge.classList.add('text-bg-warning');

      // Print button
      document.getElementById('printButton').classList.toggle('d-none', status !== 'Ongoing');
    });
  });

  // Print function
  function printReport() {
    const getText = (id) => document.getElementById(id)?.textContent.trim() || 'N/A';
    const title = getText('modalReportTitle');
    const desc = getText('modalReportDesc');
    const location = getText('modalReportLoc');
    const status = getText('modalReportStatus');
    const date = getText('modalReportDate');
    const name = getText('modalReportName');
    const email = getText('modalReportEmail');

    const content = `
      <div style="display:flex; align-items:center; gap:20px; margin-bottom:30px;">
        <img src="/images/santafe.png" alt="Santa Fe Logo" style="height:90px;">
        <div>
          <h1 style="margin:0; font-size:26px; color:#0f172a;">Municipality of Santa Fe</h1>
          <h3 style="margin:5px 0 0; font-weight:normal; color:#475569;">Incident Report Summary</h3>
        </div>
      </div>
      <hr style="margin-bottom:30px; border-top:2px solid #94a3b8;">
      <div style="font-size:16px; color:#1e293b;">
        <p><strong>👤 Name:</strong> ${name}</p>
        <p><strong>✉️ Email:</strong> ${email}</p>
        <p><strong>📌 Title:</strong> ${title}</p>
        <p><strong>📝 Description:</strong><br><span style="margin-left:20px;">${desc}</span></p>
        <p><strong>📍 Location:</strong> ${location}</p>
        <p><strong>📊 Status:</strong> ${status}</p>
        <p><strong>📅 Submitted:</strong> ${date}</p>
      </div>
    `;

    const printWindow = window.open('', '_blank', 'width=900,height=700');
    printWindow.document.write(`<!DOCTYPE html><html><head><title>Santa Fe Incident Report</title><style>
      body { font-family:'Segoe UI',sans-serif; padding:40px; color:#1f2937; background:#fff; }
      h1,h3 { margin:0; } p { margin:12px 0; line-height:1.6; } hr { border:none; border-top:1px solid #ccc; }
      @media print { body { margin:0; padding:20px; } }
    </style></head><body>${content}</body></html>`);
    printWindow.document.close();
    printWindow.focus();
    printWindow.onload = () => { printWindow.print(); printWindow.close(); };
  }

  // Fetch reports chart
  fetch('/reports/chart-data')
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('reportsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Report Count',
            data: data.counts,
            backgroundColor: ['#facc15','#f97316','#22c55e'],
            borderRadius: 10
          }]
        },
        options: {
          responsive: true,
          animation: { duration: 1000 },
          scales: { y: { beginAtZero: true } }
        }
      });
    });
</script>
</body>
</html>