<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Santa Fe Admin - Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap, Lucide, Animate.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  <!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />


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

    .card {
      border-left: 4px solid #22c55e;
    }

    .event-entry {
      border-left-color: #22c55e;
    }

    footer {
      margin-top: 2rem;
      text-align: center;
      font-size: 0.85rem;
      color: #94a3b8;
    }
    @keyframes smoothFadeSlide {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .modal.fade .modal-dialog {
    transition: transform 0.4s ease-out, opacity 0.4s ease-in-out;
    animation: smoothFadeSlide 0.4s ease-out;
  }
  .card:hover {
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
  transform: scale(1.01);
  transition: 0.3s;
}

  </style>
</head>
<body>

<body>

   <!-- Sidebar -->
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
    <h5 class="mb-0">Posted Events</h5>
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
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-success d-flex align-items-center">
      <i data-lucide="calendar-days" class="me-2"></i> Upcoming Events
    </h4>
    <span class="badge rounded-pill bg-success fs-6">{{ count($events) }} Total</span>
  </div>

  <div class="row row-cols-1 row-cols-md-2 g-4">
    @php $now = \Carbon\Carbon::now(); @endphp

    @forelse ($events as $event)
      @php
        $eventDate = \Carbon\Carbon::parse($event->event_date);
        $eventTime = \Carbon\Carbon::parse($event->event_time);
        $isUpcoming = $eventDate->isFuture();
        $status = $isUpcoming ? 'Upcoming' : 'Ongoing';
        $badgeClass = $isUpcoming ? 'bg-info' : 'bg-success';
      @endphp

      <div class="col">
        <div class="card shadow border-0 rounded-4 h-100">
          <div class="card-body d-flex flex-column justify-content-between">

            <!-- Title + Status -->
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title fw-semibold text-dark mb-0">{{ $event->title }}</h5>
              <span class="badge {{ $badgeClass }}">{{ $status }}</span>
            </div>

            <!-- Meta -->
            <div class="text-muted small mb-2">
              <span class="me-3"><i class="bi bi-tags"></i> {{ $event->category }}</span>
              <span><i class="bi bi-geo-alt"></i> {{ $event->location }}</span>
            </div>

            <ul class="list-unstyled text-secondary small mb-3">
              <li><strong>Date:</strong> {{ $eventDate->format('F d, Y') }}</li>
              <li><strong>Time:</strong> {{ $eventTime->format('h:i A') }}</li>
              <li><strong>Posted:</strong> {{ $event->created_at->format('M d, Y h:i A') }}</li>
            </ul>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
              <!-- Forward Button -->
              <button class="btn btn-sm btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#forwardModal{{ $event->id }}">
                <i class="bi bi-share me-1"></i> Forward
              </button>

              <!-- Edit & Delete -->
              <div class="d-flex gap-2 mt-2">
                <a href="{{ route('santafe.events_edit', $event->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('santafe.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>



<!-- Modal -->
<div class="modal fade" id="forwardModal{{ $event->id }}" tabindex="-1" aria-labelledby="forwardModalLabel{{ $event->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form method="POST" action="{{ route('santafe.events.forward', $event->id) }}">
      @csrf
      <div class="modal-content animate__animated animate__fadeInDown rounded-4 shadow-lg border-0">

        <!-- Modal Header -->
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #16a34a, #059669); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
          <h5 class="modal-title fw-semibold d-flex align-items-center" id="forwardModalLabel{{ $event->id }}">
            <i class="bi bi-send me-2"></i> Forward Event: {{ $event->title }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body bg-light px-4 py-3">
          <div class="row g-4">

            <div class="col-md-6">
              <label class="form-label text-dark fw-semibold">Title</label>
              <div class="form-control bg-white shadow-sm">{{ $event->title }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label text-dark fw-semibold">Category</label>
              <div class="form-control bg-white shadow-sm">{{ $event->category }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label text-dark fw-semibold">Date</label>
              <div class="form-control bg-white shadow-sm">{{ $eventDate->format('F d, Y') }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label text-dark fw-semibold">Time</label>
              <div class="form-control bg-white shadow-sm">{{ $eventTime->format('h:i A') }}</div>
            </div>

            <div class="col-12">
              <label class="form-label text-dark fw-semibold">Location</label>
              <div class="form-control bg-white shadow-sm">{{ $event->location }}</div>
            </div>

            <!-- Updated Dropdown -->
            <div class="col-12">
              <label for="barangaySelect{{ $event->id }}" class="form-label text-dark fw-semibold">Forward to Barangay</label>
              <select name="barangay" id="barangaySelect{{ $event->id }}" class="form-select barangay-dropdown shadow-sm border-success" style="width: 100%;" required>
                <option value="">-- Select Barangay --</option>
                <optgroup label="Island Barangays">
                  <option value="Hilantagaan">Hilantagaan</option>
                  <option value="Kinatarkan">Kinatarkan</option>
                </optgroup>
                <optgroup label="Mainland Barangays">
                  <option value="Kandaya">Hagdan</option>
                  <option value="Talisay">Talisay</option>
                  <option value="Langub">Langub</option>
                  <option value="Maricaban">Maricaban</option>
                  <option value="Okoy">Okoy</option>
                  <option value="Poblacion">Poblacion</option>
                  <option value="Balidbid">Balidbid</option>
                  <option value="Pooc">Pooc</option>
                </optgroup>
              </select>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Forward</button>
        </div>
      </div>
    </form>
  </div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<footer class="pt-5">
  <hr>
  <p class="text-muted text-center">&copy; {{ date('Y') }} Municipality of Santa Fe. Designed with 💚</p>
</footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>lucide.createIcons();</script>

<!-- Scrollable dropdown style -->
<style>
  .select2-results__options {
    max-height: 200px !important;
    overflow-y: auto !important;
  }
</style>

<!-- Initialize Select2 only inside modals -->
<script>
  $(document).ready(function () {
    $('.modal').on('shown.bs.modal', function () {
      $(this).find('.barangay-dropdown').select2({
        dropdownParent: $(this),
        placeholder: "-- Select Barangay --",
        width: '100%',
        language: {
          noResults: function () {
            return "No barangay found.";
          }
        }
      });
    });
  });
</script>

@empty
  <div class="col">
    <div class="alert alert-warning text-center">
      No events scheduled at the moment.
    </div>
  </div>
@endforelse

    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <footer class="pt-5">
      <hr>
      <p class="text-muted text-center">&copy; {{ date('Y') }} Municipality of Santa Fe. Designed with 💚</p>
    </footer>
  </div>

  <script>lucide.createIcons();</script>
  

</body>
