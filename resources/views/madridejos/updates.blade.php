<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Madridejos | Updates</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      background-color: #e2f1ef;
      font-family: 'Segoe UI', sans-serif;
    }
    .main {
      margin-left: 240px;
      padding: 2rem;
    }
    .sidebar {
      width: 240px;
      position: fixed;
      height: 100vh;
      background: linear-gradient(180deg,rgba(225, 242, 127, 1), #0e0e0dff);
      padding: 2rem 1rem;
      color: white;
    }
    .sidebar a {
      color: #e0f2fe;
      padding: 10px 15px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      border-radius: 8px;
      margin-bottom: 1rem;
      transition: background 0.2s ease-in-out;
    }
    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.15);
      color: white;
    }

    .card-box {
      background-color: white;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      position: relative;
    }
    .card-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
    }
    .card-actions {
      position: absolute;
      top: 1rem;
      right: 1rem;
      display: flex;
      gap: 0.5rem;
    }
    .card-actions .btn {
      padding: 4px 8px;
      font-size: 0.8rem;
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 0;
        padding: 1rem;
      }
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
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

<!-- Main Content -->
<div class="main">
  <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h4 class="fw-bold text-primary d-flex align-items-center">
      <i data-lucide="message-square" class="me-2"></i> Updates
    </h4>
    <a href="{{ route('madridejos.updates.create') }}" class="btn btn-success rounded-pill shadow-sm d-flex align-items-center">
      <i data-lucide="plus" class="me-1" style="height: 18px;"></i> Post New Update
    </a>
  </div>

  @forelse($updates as $update)
  <div class="card-box animate__animated animate__fadeInUp mb-4 border-start border-4 border-primary">
    <!-- Header: Title, Date, and Status -->
    <div class="d-flex justify-content-between align-items-start mb-2">
      <div>
        <h5 class="text-dark fw-semibold mb-1">#{{ $update->id }} — {{ $update->title }}</h5>
        <small class="text-muted"><i data-lucide="clock" class="me-1" style="height: 14px;"></i> {{ \Carbon\Carbon::parse($update->update_date)->format('F j, Y • g:i A') }}</small>
      </div>
      <span class="badge bg-info text-dark px-3 py-1 rounded-pill align-self-center">Info</span> <!-- You can change this based on update type -->
    </div>

    <!-- Message -->
    <p class="mb-2 text-secondary" style="line-height: 1.6;">{{ $update->message }}</p>

    <!-- Location and Actions -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="text-muted small d-flex align-items-center">
        <i data-lucide="map-pin" class="me-1" style="height: 14px;"></i> {{ $update->location }}
      </div>

      <div class="d-flex gap-2">
        <!-- Edit Button -->
        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal" data-bs-target="#editModal{{ $update->id }}">
          <i data-lucide="edit-3" class="me-1" style="height: 16px;"></i> Edit
        </button>

        <!-- Delete Form -->
        <form action="{{ route('madridejos.updates.destroy', $update->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this update?')" class="d-inline">
          @csrf
          @method('DELETE')
          <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
            <i data-lucide="trash-2" class="me-1" style="height: 16px;"></i> Delete
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal{{ $update->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $update->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title" id="editModalLabel{{ $update->id }}">
            <i data-lucide="edit-3" class="me-2"></i>Edit Update #{{ $update->id }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('madridejos.updates.update', $update->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-semibold">Title</label>
              <input type="text" name="title" class="form-control rounded-pill" value="{{ $update->title }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Message</label>
              <textarea name="message" class="form-control rounded-4" rows="5" required>{{ $update->message }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Location</label>
              <input type="text" name="location" class="form-control rounded-pill" value="{{ $update->location }}" required>
            </div>
          </div>
          <div class="modal-footer bg-light rounded-bottom-4">
            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success rounded-pill">
              <i data-lucide="save" class="me-1"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

  <!-- Modal for Editing -->
  <div class="modal fade animate__animated animate__zoomIn" id="editModal{{ $update->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $update->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title" id="editModalLabel{{ $update->id }}">
            <i data-lucide="edit-3" class="me-2"></i>Edit Update #{{ $update->id }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('madridejos.updates.update', $update->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-semibold">Title</label>
              <input type="text" name="title" class="form-control rounded-pill" value="{{ $update->title }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Message</label>
              <textarea name="message" class="form-control rounded-4" rows="5" required>{{ $update->message }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Location</label>
              <input type="text" name="location" class="form-control rounded-pill" value="{{ $update->location }}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success rounded-pill">
              <i data-lucide="save" class="me-1"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Lucide Init -->
<script>
  lucide.createIcons();
</script>

</body>
</html>
