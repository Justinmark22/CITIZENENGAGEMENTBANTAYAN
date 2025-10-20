@php
  $groupedUsers = $users->where('role', '!=', 'Admin')->groupBy('location');
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Users</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Sticky table header */
    .sticky-header th {
      position: sticky;
      top: 0;
      background-color: #f1f5f9;
      z-index: 10;
      border-bottom: 2px solid #cbd5e1;
    }
  </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

  <!-- Mobile header with hamburger -->
  <header class="fixed top-0 left-0 right-0 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white flex items-center justify-between p-4 md:hidden z-50 shadow-md">
    <button id="sidebarToggle" aria-label="Toggle sidebar" class="text-white text-2xl focus:outline-none">
      <i class="bi bi-list"></i>
    </button>
    <h1 class="text-lg font-bold">Admin Panel</h1>
    <div class="w-8"></div> <!-- placeholder to center title -->
  </header>

  <!-- Sidebar -->
  <aside
    id="sidebar"
    class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white p-6 flex flex-col shadow-xl z-40
           transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
  >
    <h1 class="text-2xl font-bold mb-8 hidden md:block">Admin Panel</h1>

   <nav class="flex flex-col gap-6">
  <!-- Main -->
  <div>
    <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.analytics') ? 'bg-white/20 font-semibold' : '' }}">
      <i class="bi bi-graph-up-arrow"></i> <span>Analytics</span>
    </a>
  </div>

  <!-- User Management -->
  <div>
    <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.users.index') ? 'bg-white/20 font-semibold' : '' }}">
      <i class="bi bi-people"></i> <span>Users</span>
    </a>
    <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.municipal.index') ? 'bg-white/20 font-semibold' : '' }}">
      <i class="bi bi-person-badge"></i> <span>Municipal Admins</span>
    </a>
  </div>

  <!-- Content -->
  <div>
    <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Content</p>
    <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-megaphone"></i> <span>Announce</span>
    </a>
    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-file-text"></i> <span>Reports</span>
    </a>
    <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-plus-square"></i> <span>Updates</span>
    </a>
    <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-calendar-event"></i> <span>Events</span>
    </a>
    <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
      <i class="bi bi-people-fill"></i> <span>Engagement</span>
    </a>
  </div>
</nav>
  </aside>
  <!-- Overlay when sidebar is open on mobile -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>

  <!-- Main Content -->
  <div class="pt-16 md:pt-6 md:ml-64 p-4 md:p-6 transition-all duration-300 ease-in-out">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/citizen.png') }}" class="h-10 w-auto" alt="Logo" />
        <h2 class="text-2xl font-bold">Manage Users</h2>
      </div>

      <!-- Search form -->
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex max-w-xl w-full md:w-auto">
        <input
          type="text"
          name="search"
          placeholder="Search users..."
          value="{{ request()->search }}"
          class="flex-1 px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />
        <button type="submit" class="px-4 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 flex items-center justify-center">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>

    <!-- Users grouped by location -->
    @forelse ($groupedUsers as $location => $usersByLocation)
      @php $locationLabel = $location === 'Santa.Fe' ? 'Sta. Fe' : $location; @endphp

      <section class="mb-8">
        <h5 class="text-lg font-bold text-blue-700 mb-3 border-l-4 border-blue-600 pl-2">{{ $locationLabel }} Users</h5>

        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700 text-xs uppercase sticky-header">
              <tr>
                <th class="px-4 py-2"><input type="checkbox"></th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Location</th>
                <th class="px-4 py-2 text-left">Registered</th>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach ($usersByLocation as $user)
                <tr class="hover:bg-green-50 transition">
                  <td class="px-4 py-2"><input type="checkbox" /></td>
                  <td class="px-4 py-2">{{ $user->name }}</td>
                  <td class="px-4 py-2">{{ $user->email }}</td>
                  <td class="px-4 py-2">
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $locationLabel }}</span>
                  </td>
                  <td class="px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                  <td class="px-4 py-2">{{ $user->id }}</td>
                  <td class="px-4 py-2 text-center">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" aria-label="Edit {{ $user->name }}">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline delete-user-form">
                      @csrf
                      @method('DELETE')
                      <button
                        type="button"
                        class="text-red-600 hover:text-red-800 mx-1 delete-user-btn"
                        data-user="{{ $user->name }}"
                        aria-label="Delete {{ $user->name }}"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    @empty
      <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-lg">No users found.</div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-6">{{ $users->links('pagination::tailwind') }}</div>
  </div>

  <!-- SweetAlert Delete -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Sidebar toggle
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleBtn = document.getElementById('sidebarToggle');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
      }

      toggleBtn.addEventListener('click', () => {
        if (sidebar.classList.contains('-translate-x-full')) {
          openSidebar();
        } else {
          closeSidebar();
        }
      });

      overlay.addEventListener('click', () => {
        closeSidebar();
      });

      // SweetAlert delete confirmation
      document.querySelectorAll('.delete-user-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const form = btn.closest('form');
          const userName = btn.dataset.user;
          Swal.fire({
            title: 'Delete User?',
            html: `<small>Are you sure you want to delete <strong>${userName}</strong>?</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'bg-red-600 text-white px-4 py-2 rounded-lg mx-2',
              cancelButton: 'bg-gray-200 px-4 py-2 rounded-lg'
            }
          }).then(result => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });
    });
  </script>

  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: '{{ session('success') }}',
      confirmButtonText: 'OK',
      buttonsStyling: false,
      customClass: { confirmButton: 'bg-green-600 text-white px-4 py-2 rounded-lg' }
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: '{{ session('error') }}',
      confirmButtonText: 'OK',
      buttonsStyling: false,
      customClass: { confirmButton: 'bg-red-600 text-white px-4 py-2 rounded-lg' }
    });
  </script>
  @endif

</body>
</html>
