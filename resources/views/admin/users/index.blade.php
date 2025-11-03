@php
  $groupedUsers = $users->where('role', '!=', 'Admin')->groupBy('location');
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Users</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- Leaflet CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    .sticky-header th {
      position: sticky;
      top: 0;
      background-color: #f8fafc;
      z-index: 10;
    }
    .cursor-pointer { cursor: pointer; }
    /* Modal for Leaflet Map */
    #mapModal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    #mapModalContent {
      width: 90%;
      max-width: 600px;
      height: 400px;
      background: white;
      border-radius: 0.5rem;
      overflow: hidden;
      position: relative;
    }
    #mapModalClose {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      cursor: pointer;
      font-weight: bold;
      font-size: 1.5rem;
      z-index: 10;
    }
    #mapid { height: 100%; width: 100%; }
  </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

  <!-- Mobile Header -->
  <header class="fixed top-0 left-0 right-0 bg-gradient-to-r from-blue-800 to-blue-900 text-white flex items-center justify-between p-4 md:hidden shadow-md z-50">
    <button id="sidebarToggle" class="text-white text-2xl">
      <i data-lucide="menu"></i>
    </button>
    <h1 class="text-lg font-semibold">Admin Panel</h1>
    <div class="w-6"></div>
  </header>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white p-6 flex flex-col shadow-xl z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <h1 class="text-2xl font-bold mb-8 hidden md:block">Admin Panel</h1>
    <nav class="flex flex-col gap-8 text-sm">
      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
        <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.analytics') ? 'bg-white/20 font-semibold' : '' }}">
          <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
          <span>Analytics</span>
        </a>
      </div>
      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.users.index') ? 'bg-white/20 font-semibold' : '' }}">
          <i data-lucide="users" class="w-5 h-5"></i>
          <span>Users</span>
        </a>
        <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.municipal.index') ? 'bg-white/20 font-semibold' : '' }}">
          <i data-lucide="user-cog" class="w-5 h-5"></i>
          <span>Municipal Admins</span>
        </a>
      </div>
      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Content</p>
        <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="megaphone" class="w-5 h-5"></i>
          <span>Announcements</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          <span>Reports</span>
        </a>
        <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="plus-square" class="w-5 h-5"></i>
          <span>Updates</span>
        </a>
        <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="calendar" class="w-5 h-5"></i>
          <span>Events</span>
        </a>
        <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i data-lucide="users-2" class="w-5 h-5"></i>
          <span>Engagements</span>
        </a>
      </div>
    </nav>
  </aside>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-30 md:hidden"></div>

  <!-- Map Modal -->
  <div id="mapModal" class="flex">
    <div id="mapModalContent">
      <span id="mapModalClose">&times;</span>
      <div id="mapid"></div>
    </div>
  </div>

  <!-- Main Content -->
  <main class="pt-16 md:pt-8 md:ml-64 p-6 transition-all duration-300 ease-in-out">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/citizen.png') }}" class="h-10 w-auto" alt="Logo">
        <h2 class="text-2xl font-bold">Manage Users</h2>
      </div>

      <!-- Search -->
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex w-full md:w-auto max-w-md">
        <input type="text" name="search" value="{{ request()->search }}" placeholder="Search users..."
          class="flex-1 px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded-r-lg hover:bg-blue-700 flex items-center justify-center">
          <i data-lucide="search" class="w-5 h-5"></i>
        </button>
      </form>
    </div>

    <!-- Users Table -->
    @forelse ($groupedUsers as $location => $usersByLocation)
      @php $locationLabel = $location === 'Santa.Fe' ? 'Sta. Fe' : $location; @endphp
      <section class="mb-8">
        <h5 class="text-lg font-semibold text-blue-700 mb-3 border-l-4 border-blue-600 pl-2">{{ $locationLabel }} Users</h5>

        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
          <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase sticky-header">
              <tr>
                <th class="px-4 py-2"><input type="checkbox"></th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Location</th>
                <th class="px-4 py-2 text-left">Registered</th>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach ($usersByLocation as $user)
              <tr class="hover:bg-blue-50 transition">
                <td class="px-4 py-2"><input type="checkbox"></td>
                <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-2 cursor-pointer text-blue-600 hover:underline"
                    onclick="openMap({{ $user->latitude ?? 0 }}, {{ $user->longitude ?? 0 }}, '{{ $user->name }}')">
                  {{ $user->email }}
                </td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $locationLabel }}</span>
                </td>
                <td class="px-4 py-2">{{ optional($user->created_at)->format('d M Y') ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">
                  @if($user->status === 'active')
                    <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">Login Successful</span>
                  @else
                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">Inactive</span>
                  @endif
                </td>
                <td class="px-4 py-2 text-center flex justify-center gap-2">
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">
                    <i data-lucide="edit" class="w-5 h-5"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline delete-user-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="text-red-600 hover:text-red-800 delete-user-btn" data-user="{{ $user->name }}">
                      <i data-lucide="trash-2" class="w-5 h-5"></i>
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

    <div class="mt-6">{{ $users->links('pagination::tailwind') }}</div>

  </main>

  <script>
    lucide.createIcons();

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn?.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });
    overlay?.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    });

    document.querySelectorAll('.delete-user-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const form = btn.closest('form');
        const name = btn.dataset.user;
        Swal.fire({
          title: 'Delete User?',
          html: `<small>Are you sure you want to delete <strong>${name}</strong>?</small>`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'bg-red-600 text-white px-4 py-2 rounded-lg mx-2',
            cancelButton: 'bg-gray-200 px-4 py-2 rounded-lg'
          }
        }).then(r => { if (r.isConfirmed) form.submit(); });
      });
    });

    // Leaflet Map Modal
    const mapModal = document.getElementById('mapModal');
    const mapClose = document.getElementById('mapModalClose');
    let mapInstance;

    function openMap(lat, lng, name) {
      if(!lat || !lng) { alert("Location not available for this user."); return; }
      mapModal.style.display = 'flex';
      setTimeout(() => {
        if(mapInstance) { mapInstance.remove(); } // Remove previous map
        mapInstance = L.map('mapid').setView([parseFloat(lat), parseFloat(lng)], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapInstance);
        L.marker([parseFloat(lat), parseFloat(lng)]).addTo(mapInstance)
          .bindPopup(name)
          .openPopup();
      }, 50);
    }

    mapClose.onclick = () => mapModal.style.display = 'none';
    window.onclick = (e) => { if(e.target == mapModal) mapModal.style.display = 'none'; };

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
    