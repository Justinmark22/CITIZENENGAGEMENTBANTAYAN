
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Santa Fe Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Animate + Lucide -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      width: 240px;
      background: linear-gradient(180deg, #2563eb, #1d4ed8);
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

    .card-box {
      background-color: #fff;
      border-radius: 16px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #1f2937;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Manage Santa Fe Users</h5>
    <span class="text-muted">Admin • {{ Auth::user()->email ?? 'admin@santafe.gov' }}</span>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="card-box animate__animated animate__fadeInUp">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title">Manage Santa Fe Users</div>
        <input type="text" class="form-control w-25" id="userSearch" placeholder="Search users...">
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th><i data-lucide="user" class="me-1"></i> Name</th>
              <th><i data-lucide="mail" class="me-1"></i> Email</th>
              <th><i data-lucide="map-pin" class="me-1"></i> Barangay</th>
              <th><i data-lucide="calendar" class="me-1"></i> Registered</th>
              <th class="text-end"><i data-lucide="settings" class="me-1"></i> Actions</th>
            </tr>
          </thead>
<tbody id="userTable">
  @php $row = 1; @endphp
  @forelse ($users as $user)
    @if ($user->email !== 'admin@santafe.gov')
      <tr class="user-row">
        <td>{{ $row++ }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->barangay }}</td>
        <td>{{ $user->created_at->format('M d, Y') }}</td>
        <td class="text-end">
          <a href="{{ route('santafe.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
            <i data-lucide="edit-3" class="me-1" style="width:16px;"></i>Edit
          </a>
          <form action="{{ route('santafe.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
              <i data-lucide="trash-2" class="me-1" style="width:16px;"></i>Delete
            </button>
          </form>
        </td>
      </tr>
    @endif
  @empty
    <tr><td colspan="6" class="text-center text-muted">No users from Santa Fe found.</td></tr>
  @endforelse
</tbody>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    lucide.createIcons();

    // Search functionality
    document.getElementById('userSearch').addEventListener('input', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('.user-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
