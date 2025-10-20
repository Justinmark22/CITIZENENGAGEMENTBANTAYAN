<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Madridejos Announcements</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & SweetAlert -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      background-color: rgb(181, 202, 199);
      font-family: 'Segoe UI', sans-serif;
    }
.sidebar {
      height: 100vh;
      width: 250px;
        background: linear-gradient(180deg,rgba(225, 242, 127, 1), #0e0e0dff);
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
      margin-left: 250px;
      padding: 1rem 2rem;
      background: #ffffff;
      border-bottom: 1px solid #e5e7eb;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .main {
      margin-left: 250px;
      padding: 2rem;
      min-height: 100vh;
    }

    .card-box {
      background-color: #fff;
      border-radius: 16px;
      padding: 1.75rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .card-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1f2937;
    }

    .btn-primary {
      background-color: #2563eb;
      border: none;
    }

    .btn-outline-primary:hover {
      background-color: #2563eb;
      color: white;
    }

    .modal-header {
      background-color: #f3f4f6;
    }

    .modal-footer {
      background-color: #f9fafb;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar p-3 bg-light" style="min-height: 100vh;">
  

  
<!-- Logo Section -->
 <div class="text-center mb-4">
  <img src="{{ asset('images/madri.png') }}" alt="Santa Fe Logo" class="img-fluid rounded-circle" style="max-height: 80px; width: 80px; object-fit: cover;">
</div>

 <!-- Menu Links -->
  <a href="{{ route('dashboard.madridejosadmin') }}">
  <i data-lucide="home" class="me-2"></i> Dashboard
</a>
  <a href="{{ route('madridejos.users.index') }}">
    <i data-lucide="users" class="me-2"></i> Users
  </a>
  <a href="{{ route('madridejos.reports') }}">
    <i data-lucide="file-text" class="me-2"></i> Reports
  </a>
  <a href="{{ route('madridejos.feedback') }}">
    <i data-lucide="message-square" class="me-2"></i> Feedback
  </a>
  <a href="{{ route('madridejos.announcements') }}">
    <i data-lucide="megaphone" class="me-2"></i> Announcements
  </a>
  <a href="{{ route('madridejos.events') }}">
    <i data-lucide="calendar-days" class="me-2"></i> Events
  </a>
<a href="{{ route('madridejos.updates.index') }}">
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
<!-- Main Content -->
<div class="main">

  @if(session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: '{{ session('success') }}',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true
        });
      });
    </script>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="section-title"><i data-lucide="megaphone" class="me-2"></i> Latest Announcements</h4>
    <a href="{{ route('bantayan.announcements.create') }}" class="btn btn-primary">
      <i data-lucide="plus" class="me-1"></i> Add Announcement
    </a>
  </div>

  <!-- Search and Filters -->
  <form method="GET" action="{{ route('bantayan.announcements') }}" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search by keyword..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
      <input type="date" name="from" class="form-control" value="{{ request('from') }}">
    </div>
    <div class="col-md-3">
      <input type="date" name="to" class="form-control" value="{{ request('to') }}">
    </div>
    <div class="col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-outline-primary w-100">
        <i data-lucide="search" class="me-1"></i> Filter
      </button>
    </div>
  </form>

 @forelse($announcements as $announcement)
  <div class="card shadow-sm border-0 mb-4 animate__animated animate__fadeInUp">
    <div class="card-body">
      <h5 class="card-title text-primary mb-1">{{ $announcement->title }}</h5>
      <p class="card-subtitle text-muted mb-3">{{ $announcement->created_at->format('F d, Y') }}</p>
      <p class="card-text text-secondary mb-4">{{ $announcement->body }}</p>

      <div class="d-flex justify-content-between align-items-center">
        
        <!-- Forward Button (left) -->
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#forwardModal{{ $announcement->id }}">
          <i data-lucide="send" class="me-1"></i> Forward
        </button>

        <!-- Edit and Delete Buttons (right) -->
        <div class="d-flex gap-2">
          <a href="{{ route('madridejos.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-outline-secondary">
            <i data-lucide="edit" class="me-1"></i> Edit
          </a>

          <form action="{{ route('madridejos.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
              <i data-lucide="trash" class="me-1"></i> Delete
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>




<!-- Fullscreen Modal -->
<div class="modal fade" id="forwardModal{{ $announcement->id }}" tabindex="-1" aria-labelledby="forwardModalLabel{{ $announcement->id }}" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <form method="POST" action="{{ route('santafe.announcements.forward', $announcement->id) }}">
      @csrf
      <div class="modal-content animate__animated animate__fadeIn">

        <!-- Header -->
        <div class="modal-header bg-light border-bottom">
          <h5 class="modal-title fw-semibold" id="forwardModalLabel{{ $announcement->id }}">
            📢 Forward Announcement #{{ $announcement->id }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="modal-body d-flex justify-content-center align-items-center text-start" style="min-height: 80vh;">
          <div class="w-100" style="max-width: 750px;">

            <!-- Title -->
            <div class="mb-4">
              <label class="fw-semibold">Title:</label>
              <div class="form-control bg-light">{{ $announcement->title }}</div>
            </div>

            <!-- Message -->
            <div class="mb-4">
              <label class="fw-semibold">Message:</label>
              <div class="form-control bg-light" style="min-height: 120px; white-space: pre-line;">{{ $announcement->message ?? $announcement->body }}</div>
            </div>

            <!-- Location -->
            <div class="mb-4">
              <label class="fw-semibold">Location:</label>
              <div class="form-control bg-light">{{ $announcement->location }}</div>
            </div>

            <!-- Dates -->
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="fw-semibold">Start Date:</label>
                <div class="form-control bg-light">{{ \Carbon\Carbon::parse($announcement->start_date)->format('F d, Y') }}</div>
              </div>
              <div class="col-md-6">
                <label class="fw-semibold">End Date:</label>
                <div class="form-control bg-light">{{ \Carbon\Carbon::parse($announcement->end_date)->format('F d, Y') }}</div>
              </div>
            </div>

            <!-- Created/Updated -->
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="fw-semibold">Created At:</label>
                <div class="form-control bg-light">{{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y h:i A') }}</div>
              </div>
              <div class="col-md-6">
                <label class="fw-semibold">Updated At:</label>
                <div class="form-control bg-light">{{ \Carbon\Carbon::parse($announcement->updated_at)->format('F d, Y h:i A') }}</div>
              </div>
            </div>

            <!-- Forward to Barangay -->
            <div class="mb-4">
              <label for="barangay{{ $announcement->id }}" class="form-label fw-semibold">Select Barangay</label>
              <select name="barangay" id="barangay{{ $announcement->id }}" class="form-select form-select-lg text-center" required>
                <option value="">-- Choose Barangay --</option>
                <option value="Atop-Atop">Atop-Atop</option>
                <option value="Baigad">Baigad</option>
                <option value="Baod">Baod</option>
                <option value="Binaobao">Binaobao</option>
                <option value="Botigues">Botigues</option>
                <option value="Kabac">Kabac</option>
                <option value="Doong">Doong</option>
                <option value="Hilotongan">Hilotongan</option>
                <option value="Guiwanon">Guiwanon</option>
                <option value="Kabangbang">Kabangbang</option>
                <option value="Kampingganon">Kampingganon</option>
                <option value="Kangkaibe">Kangkaibe</option>
                <option value="Lipayran">Lipayran</option>
                <option value="Luyongbaybay">Luyongbaybay</option>
                <option value="Mojon">Mojon</option>
                <option value="Obo-ob">Obo-ob</option>
                <option value="Patao">Patao</option>
                <option value="Putian">Putian</option>
                <option value="Sillon">Sillon</option>
                <option value="Sungko">Sungko</option>
                <option value="Suba">Suba</option>
                <option value="Sulangan">Sulangan</option>
                <option value="Tamiao">Tamiao</option>
                <option value="Bantigue">Bantigue</option>
                <option value="Ticad">Ticad</option>
                
              </select>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-center gap-3">
              <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                <i data-lucide="x" class="me-1"></i> Cancel
              </button>
              <button type="submit" class="btn btn-success px-4">
                <i data-lucide="send" class="me-1"></i> Forward
              </button>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-top bg-light justify-content-center">
          <small class="text-muted">You are viewing complete details of this announcement.</small>
        </div>
      </div>
    </form>
  </div>
</div>


  @empty
    <div class="alert alert-info">No announcements found.</div>
  @endforelse

  <div class="mt-4">
    {{ $announcements->appends(request()->query())->links('pagination::bootstrap-5') }}
  </div>
</div>

<!-- JS Scripts at bottom -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();
  });
</script>

</body>
</html>
