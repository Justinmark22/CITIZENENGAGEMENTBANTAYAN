<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Support</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f7f7f7;
      font-family: 'Arial', sans-serif;
    }

    .container {
      max-width: 800px;
      margin-top: 50px;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #4e73df;
      color: white;
      text-align: center;
      border-radius: 15px 15px 0 0;
    }

    .contact-form-card {
      padding: 2rem;
      background-color: #f9f9f9;
      border-radius: 12px;
      transition: box-shadow 0.3s ease;
    }

    .contact-form-card:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .contact-form-input:focus {
      border-color: #6366f1 !important;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .submit-btn {
      background-image: linear-gradient(to right, #6366f1, #4f46e5);
      transition: all 0.3s ease;
    }

    .submit-btn:hover {
      background-image: linear-gradient(to right, #4f46e5, #4338ca);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
    }

    .alert-success {
      background-color: #d1fae5;
      border: 1px solid #10b981;
      color: #065f46;
    }

    .alert-error {
      background-color: #fee2e2;
      border: 1px solid #ef4444;
      color: #991b1b;
    }

    .faq-section {
      margin-top: 30px;
    }

    .faq-title {
      font-weight: bold;
      color: #4e73df;
    }

    .faq-item {
      margin-bottom: 15px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #fefefe;
    }

    .faq-question {
      font-weight: 600;
      color: #333;
    }

    .faq-answer {
      margin-top: 5px;
      color: #555;
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
    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center" data-bs-toggle="dropdown">
        <i class="bi bi-chat-dots fs-5"></i> Feedback
      </a>
      <ul class="dropdown-menu dropdown-menu-end p-3 shadow rounded-3">
        <li>
          <a href="{{ route('feedback.page') }}" class="text-black small text-decoration-none d-block p-2 rounded bg-light border-start border-4 border-dark">
            <h6 class="fw-semibold mb-1">Got ideas or concerns?</h6>
            <p class="mb-0">Share your thoughts.</p>
          </a>
        </li>
      </ul>
    </div>

    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center" data-bs-toggle="dropdown">
        <i class="bi bi-life-preserver fs-5"></i> Support
      </a>
      <ul class="dropdown-menu dropdown-menu-end p-2 shadow rounded-3">
        <li>
          <a href="{{ route('contact.support.page') }}" class="dropdown-item d-flex align-items-center gap-2 text-black">
            <i class="bi bi-life-preserver"></i> Contact Support
          </a>
        </li>
      </ul>
    </div>

    <a href="#" class="nav-link text-black fw-semibold" data-bs-toggle="modal" data-bs-target="#reportModal">
      + Submit Concern
    </a>

    <div class="dropdown">
      <a href="#" class="nav-link text-black fw-semibold d-flex align-items-center gap-2" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle fs-5"></i>
        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Guest' }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow rounded-3">
        <li class="dropdown-item-text small text-muted px-3">
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

<!-- Contact Support Card -->
<div class="container">
  <div class="card">
    <div class="card-header">
      <h3>Contact Support</h3>
    </div>
    <div class="card-body">
      
      <!-- Session Alerts -->
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Contact Form -->
      <div class="contact-form-card">
        <form method="POST" action="{{ route('contact.send') }}">
          @csrf
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control contact-form-input" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control contact-form-input" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control contact-form-input">
            </div>
            <div class="col-md-6">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control contact-form-input">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" rows="5" class="form-control contact-form-input" required></textarea>
          </div>
          <div class="text-end">
            <button type="submit" class="btn submit-btn text-white px-4 py-2">Submit</button>
          </div>
        </form>
      </div>

      <!-- FAQ -->
      <div class="faq-section mt-5">
        <h4 class="faq-title">Frequently Asked Questions</h4>

        <div class="faq-item">
          <p class="faq-question">How can I reset my password?</p>
          <p class="faq-answer">Go to the login page and click "Forgot Password" to receive a reset link via email.</p>
        </div>

        <div class="faq-item">
          <p class="faq-question">How do I update my profile details?</p>
          <p class="faq-answer">Log in and go to Profile Settings to update name, email, or location.</p>
        </div>

        <div class="faq-item">
          <p class="faq-question">What if I encounter a technical issue?</p>
          <p class="faq-answer">Submit the issue in detail via this form, and our team will assist you promptly.</p>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
