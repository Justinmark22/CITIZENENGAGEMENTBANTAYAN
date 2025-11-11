@php
    // ✅ Group historical active sessions excluding:
    // - Location = "Admin" (case-insensitive)
    // - Roles = fire, waste, water, mdrrmo (case-insensitive)
    $excludedRoles = ['fire', 'waste', 'water', 'mdrrmo'];

    $groupedUsersHistory = ($activeUsersHistory ?? collect())
        ->filter(function ($logs, $location) use ($excludedRoles) {
            // Exclude "Admin" location
            if (strtolower(trim($location)) === 'admin') {
                return false;
            }

            // Filter out users with excluded roles
            $filteredLogs = $logs->reject(function ($user) use ($excludedRoles) {
                return in_array(strtolower(trim($user->role)), $excludedRoles);
            });

            // Keep only if there are remaining users after filtering
            return $filteredLogs->isNotEmpty();
        })
        ->map(function ($logs) use ($excludedRoles) {
            return $logs->reject(function ($user) use ($excludedRoles) {
                return in_array(strtolower(trim($user->role)), $excludedRoles);
            });
        });
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Monitoring - System Logs</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .sticky-header th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
    #sidebar { transition: transform 0.3s ease-in-out; }
    @media (max-width: 640px) {
      .stats-card p:first-child { font-size: 0.7rem; }
      .stats-card p:last-child { font-size: 1.2rem; }
      .quick-actions a, .quick-actions button { padding: 0.5rem; font-size: 0.85rem; }
    }
  
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 via-gray-50 to-white text-gray-800 font-sans">

<!-- Mobile Header -->
<header class="fixed top-0 left-0 right-0 bg-gradient-to-r from-blue-800 to-blue-900 text-white flex items-center justify-between p-4 md:hidden shadow-md z-50">
    <button id="sidebarToggle" class="text-white text-2xl">
        <i data-lucide="menu"></i>
    </button>
    <h1 class="text-lg font-semibold">Admin Panel</h1>
    <div class="w-6"></div>
</header>

<!-- ✅ Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-blue-900 to-blue-800 text-white p-6 transform -translate-x-full lg:translate-x-0 z-50">
  <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>
  <nav class="flex flex-col gap-2 text-sm">
    <p class="uppercase text-xs opacity-70">Main</p>
    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-graph-up-arrow"></i> Analytics</a>

    <p class="uppercase text-xs opacity-70 mt-3">User Management</p>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-people"></i> Users</a>
    <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-person-badge"></i> Municipal Admins</a>

    <p class="uppercase text-xs opacity-70 mt-3">Content</p>
    <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-megaphone"></i> Announce</a>
    

    <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white/10"><i class="bi bi-calendar-event"></i> Events</a>
   
  </nav>
</aside>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-30 md:hidden"></div>

<!-- Main Content -->
<main class="pt-16 md:pt-8 md:ml-64 p-6 transition-all duration-300">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">User Activity Logs</h2>
       <span id="liveClock" class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-mono shadow-sm">
    Updated: {{ now('Asia/Manila')->format('d M Y, h:i A') }}
</span>
<script>
    function updateClock() {
        const clock = document.getElementById('liveClock');
        const now = new Date();
        
        // Convert to Manila time
        const options = {
            timeZone: 'Asia/Manila',
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const manilaTime = now.toLocaleString('en-PH', options);
        clock.textContent = `Updated: ${manilaTime}`;
    }

    // Update every second
    setInterval(updateClock, 1000);
    updateClock(); // initial call
</script>

    </div>

    @forelse ($groupedUsersHistory as $location => $usersByLocation)
        @php $locationLabel = $location === 'Santa.Fe' ? 'Sta. Fe' : $location; @endphp

        <section class="mb-10">
            <div class="flex items-center justify-between mb-3">
                <h5 class="text-xl font-semibold text-blue-800 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-5 h-5 text-blue-600"></i> 
                    {{ $locationLabel }} Users
                </h5>
                <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">
                    {{ $usersByLocation->count() }} Active Logs
                </span>
            </div>

            <div class="glass-card rounded-2xl shadow-sm overflow-x-auto border border-gray-100">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-blue-50 text-xs uppercase font-semibold sticky-header text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Location</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Joined</th>
                            <th class="px-4 py-3 text-left">Last Login</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($usersByLocation as $user)
                            <tr class="hover:bg-blue-50 transition duration-200">
                                <td class="px-4 py-2 text-gray-500">{{ $user->user_id }}</td>
                                <td class="px-4 py-2 font-medium text-gray-800">{{ $user->name }}</td>
                                <td class="px-4 py-2">
                                   <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->location) }}" 
   target="_blank" 
   class="text-blue-600 hover:underline">
    {{ $user->email }}
</a>

                                </td>
                                <td class="px-4 py-2">{{ ucfirst($user->location) }}</td>
                                <td class="px-4 py-2">
                                    <span class="text-xs px-2 py-1 rounded-full font-semibold 
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                 <td class="px-4 py-2">
    {{ \Carbon\Carbon::parse($user->created_at)->timezone('Asia/Manila')->format('d M Y') }}
</td>

                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($user->last_login)->timezone('Asia/Manila')->format('d M Y, h:i A') }}
                                </td>
        

                                <td class="px-4 py-2">
                                    <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" 
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg flex items-center gap-1 transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
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
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 p-6 rounded-xl text-center font-medium shadow-sm">
            <i data-lucide="alert-triangle" class="inline-block w-6 h-6 mr-2 align-middle text-yellow-600"></i>
            No user activity found.
        </div>
    @endforelse
</main>

<script>
    lucide.createIcons();

    // Sidebar toggle
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

    // SweetAlert Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'Delete User?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            customClass: { popup: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // SweetAlert notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: { confirmButton: 'bg-green-600 text-white px-4 py-2 rounded-lg' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: { confirmButton: 'bg-red-600 text-white px-4 py-2 rounded-lg' }
        });
    @endif
</script>

</body>
</html>
