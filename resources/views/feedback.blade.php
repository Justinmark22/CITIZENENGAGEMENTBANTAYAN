<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Submit Feedback</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
  body {
    background: linear-gradient(120deg, #e0f2fe, #f8fafc);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
  }

  .feedback-card {
    backdrop-filter: blur(14px);
    background: rgba(255, 255, 255, 0.75);
    border: none;
    border-radius: 1.5rem;
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
    animation: fadeInUp 0.8s ease-in-out;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .feedback-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 40px rgba(0, 0, 0, 0.12);
  }

  .feedback-card-header {
    background: linear-gradient(to right, #3b82f6, #1e40af);
    color: white;
    border-top-left-radius: 1.5rem;
    border-top-right-radius: 1.5rem;
    padding: 2rem;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  }

  .form-control, .form-select {
    border-radius: 0.7rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.2);
  }

  .btn-primary {
    background: linear-gradient(to right, #2563eb, #1d4ed8);
    font-weight: 600;
    border-radius: 0.75rem;
    border: none;
    transition: background 0.3s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(to right, #1e40af, #1d4ed8);
  }

  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(40px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Navbar Tweaks */
  .navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.9) !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  }

  .nav-link:hover {
    text-decoration: underline;
  }

  /* Modal style enhancement */
  .modal-content {
    border-radius: 1.25rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .modal-header {
    background-color: #f1f5f9;
    border-top-left-radius: 1.25rem;
    border-top-right-radius: 1.25rem;
  }

  .modal-footer {
    background-color: #f8fafc;
    border-bottom-left-radius: 1.25rem;
    border-bottom-right-radius: 1.25rem;
  }

  /* Smooth transition for dropdowns */
  .dropdown-menu {
    transition: all 0.3s ease-in-out;
  }

  .dropdown-menu.show {
    animation: fadeInUp 0.25s ease;
  }
</style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 py-3">
  <div class="d-flex align-items-center gap-4">
    <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="rounded-circle" width="50" height="50" style="object-fit: cover;" />
    <span class="fw-semibold fs-5 text-black mb-0">Sta.Fe Dashboard</span>
  </div>

  <div class="ms-auto d-flex align-items-center gap-5">


    <!-- Feedback -->
    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center" role="button" id="feedbackDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 0.3rem;">
        <i class="bi bi-chat-dots fs-5"></i> Feedback
      </a>
      <ul class="dropdown-menu dropdown-menu-end p-3 shadow rounded-3" aria-labelledby="feedbackDropdown" style="min-width: 280px;">
        <li>
          <a href="{{ route('feedback.page') }}" class="text-black small text-decoration-none d-block p-2 rounded bg-light border-start border-4 border-dark">
            <h6 class="fw-semibold mb-1">Got ideas or concerns?</h6>
            <p class="mb-0">Share your thoughts.</p>
          </a>
        </li>
      </ul>
    </div>

    <!-- Support -->
    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center" role="button" id="supportDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 0.3rem;">
        <i class="bi bi-life-preserver fs-5"></i> Support
      </a>
      <ul class="dropdown-menu dropdown-menu-end p-2 shadow rounded-3" aria-labelledby="supportDropdown" style="min-width: 220px;">
        <li>
          <a href="{{ route('contact.support.page') }}" class="dropdown-item d-flex align-items-center gap-2 text-black">
            <i class="bi bi-life-preserver"></i> Contact Support
          </a>
        </li>
      </ul>
    </div>

    <!-- Submit Concern -->
    <a href="#" class="nav-link text-black fw-semibold" data-bs-toggle="modal" data-bs-target="#reportModal" aria-label="Submit a new concern" style="letter-spacing: 0.04em;">
      + Submit Concern
    </a>

    <!-- User Dropdown -->
    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center gap-2" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 0.3rem;">
        <i class="bi bi-person-circle fs-5"></i>
        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Guest' }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow rounded-3" aria-labelledby="userDropdown" style="min-width: 240px;">
        <li class="dropdown-item-text small text-muted px-3" style="color: black;">
          <strong>{{ Auth::user()->name ?? 'Guest' }}</strong><br />
          {{ Auth::user()->email ?? 'No Email' }}<br />
          <small class="text-secondary">{{ Auth::user()->location ?? 'No Location' }}</small>
        </li>
        <li><hr class="dropdown-divider" /></li>
        <li><a class="dropdown-item text-black" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-gear me-2"></i>Settings</a></li>
        <li>
          <a class="dropdown-item text-black" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
      </ul>
    </div>

  </div>
</nav>
<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4">
      <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">Report an Issue</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
              <option value="" disabled selected>Select category</option>
              <option>Road Issue</option>
              <option>Water Supply</option>
              <option>Waste Management</option>
              <option>Noise Complaint</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" placeholder="E.g. Damaged signage" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control" placeholder="More details..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Feedback Form -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card feedback-card">
        <div class="feedback-card-header text-center">
          <h4 class="mb-0"> Submit Your Feedback</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('feedback.submit') }}" method="POST">
            @csrf

            <!-- Location -->
            <div class="mb-4">
              <label for="location" class="form-label"> Location</label>
              <input type="text" id="location" name="location" class="form-control" value="{{ Auth::user()->location ?? 'No Location' }}" readonly>
            </div>

            <!-- Feedback Textarea -->
            <div class="mb-4">
              <label for="feedback" class="form-label"> Your Feedback</label>
              <textarea name="feedback" id="feedback" class="form-control" rows="5" placeholder="Write your feedback here..." required></textarea>
            </div>

            <!-- Rating Dropdown -->
            <div class="mb-4">
              <label for="rating" class="form-label"> Rating</label>
              <select name="rating" id="rating" class="form-select" required>
                <option value="" disabled selected>Choose a rating</option>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
              </select>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg animate__animated animate__pulse animate__delay-1s">
                 Submit Feedback
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Feedback Submitted!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 2000
    });
  </script>
@endif


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
