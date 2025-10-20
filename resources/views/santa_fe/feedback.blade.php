<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Santa Fe Admin Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap + Lucide + Animate -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

  <style>
    body {
      background-color: rgb(181, 202, 199);
      font-family: 'Segoe UI', sans-serif;
      transition: all 0.3s ease;
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

    .main {
      margin-left: 240px;
      padding: 2rem;
    }

    .navbar {
      padding: 1rem 2rem;
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      margin-left: 240px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .card-box {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      box-shadow: 0 10px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s;
    }

    .card-box:hover {
      transform: translateY(-5px);
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: #1f2937;
    }

    footer {
      margin-top: 3rem;
      text-align: center;
      font-size: 0.85rem;
      color: #94a3b8;
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
    <div class="d-flex align-items-center">
      <button class="btn btn-outline-primary me-3" id="toggleSidebar"><i data-lucide="menu"></i></button>
      <h5 class="mb-0">Municipality of Santa Fe - Feedback</h5>
    </div>
    <div class="d-flex align-items-center">
      <span class="me-3 text-muted">Admin • {{ Auth::user()->email ?? 'admin@santafe.gov' }}</span>
    </div>
  </div>
<!-- Keep everything above as-is (head, sidebar, navbar, etc.) -->

<!-- Main Content -->
<div class="main">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
   
    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search feedback...">
  </div>

  <!-- Feedback List -->
  @forelse ($feedbacks as $feedback)
    <div class="card-box feedback-entry animate__animated animate__fadeInUp"
         data-bs-toggle="modal"
         data-bs-target="#feedbackModal"
         data-name="{{ $feedback->user->name ?? 'Anonymous' }}"
         data-email="{{ $feedback->user->email ?? 'No Email' }}"
         data-message="{{ $feedback->feedback }}"
         data-rating="{{ $feedback->rating }}"
         data-time="{{ $feedback->created_at->format('F j, Y g:i A') }}">
      <div class="d-flex justify-content-between">
        <div>
          <h6 class="fw-semibold mb-1 text-primary">
            <i data-lucide="user" class="me-1"></i>{{ $feedback->user->name ?? 'Anonymous' }}
          </h6>
          <p class="mb-1 text-muted">
            <i data-lucide="mail" class="me-1"></i>{{ $feedback->user->email ?? 'No Email' }}
          </p>
          <p class="mb-0 text-dark"><strong>Feedback:</strong> {{ $feedback->feedback }}</p>
          <p class="mb-0 mt-1 text-warning">
            <strong>Rating:</strong>
            @for ($i = 1; $i <= 5; $i++)
              @if ($i <= $feedback->rating)
                ★
              @else
                ☆
              @endif
            @endfor
            <span class="text-muted ms-2">({{ $feedback->rating }}/5)</span>
          </p>
        </div>
        <div class="text-end text-muted small">
          {{ $feedback->created_at->diffForHumans() }}
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">No feedback submitted yet.</div>
  @endforelse

  <!-- Pagination -->
  <div class="mt-4">
    {{ $feedbacks->links() }}
  </div>

  <footer class="mt-5">
    &copy; {{ date('Y') }} Municipality of Santa Fe. All rights reserved.
  </footer>
</div>

<!-- Feedback Modal -->
<div class="modal fade animate__animated animate__fadeInDown" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0 rounded-4">
      
      <!-- Modal Header -->
      <div class="modal-header text-white" style=" background: linear-gradient(180deg,rgb(130, 228, 174), #1d4ed8);">
        <h5 class="modal-title d-flex align-items-center" id="feedbackModalLabel">
          <i data-lucide="message-square" class="me-2"></i> Feedback Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body px-4 py-4" id="feedbackModalBody">

        <!-- Header with Logo -->
        <div class="text-center mb-4 animate__animated animate__fadeInUp">
          <img src="{{ asset('images/santafe.png') }}" alt="Santa Fe Logo" style="height: 80px;" class="mb-2 rounded-circle shadow-sm">
          <h4 class="fw-bold mt-2 text-primary">Municipality of Santa Fe</h4>
          <p class="text-muted mb-0">Citizen Feedback Submission</p>
          <hr class="w-50 mx-auto mt-3">
        </div>

        <!-- Feedback Content -->
        <div class="px-3 animate__animated animate__fadeInUp animate__delay-1s">
          <p><i data-lucide="user" class="me-1 text-primary"></i> <strong>Name:</strong> <span id="modalName"></span></p>
          <p><i data-lucide="mail" class="me-1 text-success"></i> <strong>Email:</strong> <span id="modalEmail"></span></p>
          <p><strong><i data-lucide="message-circle" class="me-1 text-warning"></i> Message:</strong></p>
          <div id="modalMessage" class="text-dark bg-light p-3 rounded border shadow-sm"></div>
          <p class="mt-3"><i data-lucide="star" class="me-1 text-warning"></i><strong>Rating:</strong> <span id="modalRating"></span></p>
          <p><i data-lucide="clock" class="me-1 text-muted"></i><strong>Submitted:</strong> <span id="modalTime"></span></p>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer d-flex justify-content-between bg-light rounded-bottom-4">
        <span class="text-muted small ms-2">Thank you for engaging with us!</span>
        <div>
          <button class="btn btn-secondary me-2" data-bs-dismiss="modal">
            <i data-lucide="x" class="me-1"></i> Close
          </button>
          <button class="btn btn-primary" onclick="printFeedback()">
            <i data-lucide="printer" class="me-1"></i> Print
          </button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();

  // Sidebar toggle
  document.getElementById('toggleSidebar').addEventListener('click', () => {
    document.body.classList.toggle('sidebar-collapsed');
  });

  // Live search
  document.getElementById('searchInput').addEventListener('input', function () {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.feedback-entry').forEach(entry => {
      entry.style.display = entry.innerText.toLowerCase().includes(term) ? '' : 'none';
    });
  });

  // Modal show event
  document.getElementById('feedbackModal').addEventListener('show.bs.modal', function (event) {
    const card = event.relatedTarget;
    document.getElementById('modalName').textContent = card.getAttribute('data-name');
    document.getElementById('modalEmail').textContent = card.getAttribute('data-email');
    document.getElementById('modalMessage').textContent = card.getAttribute('data-message');
    document.getElementById('modalRating').textContent = card.getAttribute('data-rating') + ' / 5';
    document.getElementById('modalTime').textContent = card.getAttribute('data-time');
  });
  function printFeedback() {
    const content = document.getElementById('feedbackModalBody').innerHTML;
    const win = window.open('', '', 'height=800,width=700');
    win.document.write(`
      <html>
      <head>
        <title>Print Feedback</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          body {
            padding: 40px;
            font-family: 'Segoe UI', sans-serif;
          }
          .header {
            text-align: center;
            margin-bottom: 30px;
          }
          .header img {
            height: 80px;
            margin-bottom: 10px;
          }
          .header h2 {
            margin: 0;
          }
          hr {
            border-top: 2px solid #0d6efd;
            margin: 20px 0;
          }
          .content {
            font-size: 16px;
          }
        </style>
      </head>
      <body>
        <div class="header">

        </div>
        <hr>
        <div class="content">${content}</div>
      </body>
      </html>
    `);
    win.document.close();
    setTimeout(() => {
      win.print();
      win.close();
    }, 500);
  }


</script>




  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    lucide.createIcons();

    // Sidebar toggle
    document.getElementById('toggleSidebar').addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
    });

    // Live search
    document.getElementById('searchInput').addEventListener('input', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('.feedback-entry').forEach(entry => {
        entry.style.display = entry.innerText.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
