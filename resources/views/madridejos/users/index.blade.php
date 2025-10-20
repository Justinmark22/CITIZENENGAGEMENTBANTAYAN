
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Madridejos Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Animate + Lucide -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
     background-color:rgba(250, 250, 248, 1);
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      width: 240px;
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
      background-color:rgb(211, 214, 220); /* <-- dirty white */
      border-radius: 16px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }
.table-spreadsheet {
  border-collapse: collapse;
  width: 100%;
  font-size: 14px;
  background-color: #f9fafb;
}

.table-spreadsheet thead th {
  position: sticky;
  top: 0;
  background-color: #f1f5f9;
  z-index: 2;
  border-bottom: 2px solid #cbd5e1;
  padding: 0.75rem 1rem;
  font-weight: 600;
  color: #1e293b;
  text-align: left;
}

.table-spreadsheet tbody td {
  padding: 0.65rem 1rem;
  border-bottom: 1px solid #e2e8f0;
  vertical-align: middle;
  color: #334155;
}

.table-spreadsheet tbody tr:nth-child(even) {
  background-color: #f8fafc;
}

.table-spreadsheet tbody tr:hover {
  background-color: #e2e8f0;
  transition: background 0.2s ease;
}

.table-spreadsheet .btn-sm {
  padding: 4px 10px;
  font-size: 13px;
  border-radius: 6px;
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
    <h5 class="mb-0">Manage Madridejos Users</h5>
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
    <div class="card-box animate__animated animate__fadeInUp">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title">Manage Bantayan Users</div>
        <input type="text" class="form-control w-25" id="userSearch" placeholder="Search users...">
      </div>

      <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
  <table class="table table-spreadsheet">
    <thead>
      <tr>
        <th>#</th>
        <th><i data-lucide="user" class="me-1"></i> Name</th>
        <th><i data-lucide="mail" class="me-1"></i> Email</th>
       
        <th><i data-lucide="calendar" class="me-1"></i> Registered</th>
        <th class="text-end"><i data-lucide="settings" class="me-1"></i> Actions</th>
      </tr>
    </thead>
    <tbody id="userTable">
      @php $row = 1; @endphp
      @forelse ($users as $user)
        @if ($user->email !== 'admin@santafe.com')
          <tr class="user-row">
            <td>{{ $row++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
          
            <td>{{ $user->created_at->format('M d, Y') }}</td>
            <td class="text-end">
              <a href="{{ route('madridejos.users.edit', $user->id) }}"
                 class="btn btn-sm btn-edit btn-animated me-2"
                 data-bs-toggle="tooltip" title="Edit this user">
                <i data-lucide="edit-3" class="me-1" style="width:16px;"></i> Edit
              </a>
              <form action="{{ route('madridejos.users.destroy', $user->id) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-delete btn-animated"
                        data-bs-toggle="tooltip" title="Delete this user permanently">
                  <i data-lucide="trash-2" class="me-1" style="width:16px;"></i> Delete
                </button>
              </form>
            </td>
          </tr>
        @endif
      @empty
        <tr><td colspan="6" class="text-center text-muted">No users from Santa Fe found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>


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
