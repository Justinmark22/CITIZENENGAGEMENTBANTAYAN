<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>All Engagements</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- ✅ Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .glass {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
    }

    .shadow-glow {
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    }

    /* ✅ Table responsive styles */
    @media (max-width: 768px) {
      table thead {
        display: none;
      }
      table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border-radius: 0.5rem;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
      }
      table tbody tr:hover {
        transform: scale(1.02);
      }
      table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f1f1;
      }
      table tbody td:last-child {
        border-bottom: none;
      }
      table tbody td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #4b5563;
      }
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-100 via-white to-purple-200 font-sans min-h-screen p-0 md:p-6" 
      x-data="{ sidebarOpen: false }">

  <!-- ✅ Mobile Navbar -->
  <div class="md:hidden flex items-center justify-between bg-indigo-700 text-white p-4 shadow-lg">
    <h1 class="text-lg font-bold">Admin Panel</h1>
    <button @click="sidebarOpen = !sidebarOpen" class="text-2xl focus:outline-none transition-transform duration-300">
      <i class="bi" :class="sidebarOpen ? 'bi-x-lg' : 'bi-list'"></i>
    </button>
  </div>

  <!-- ✅ Sidebar -->
  <aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white p-6 flex flex-col shadow-2xl z-50 transform transition-transform duration-500 ease-in-out
                md:translate-x-0"
    :class="{'-translate-x-64': !sidebarOpen && window.innerWidth < 768, 'translate-x-0': sidebarOpen}">
    <h1 class="text-2xl font-bold mb-8 hidden md:block">Admin Panel</h1>

    <nav class="flex flex-col gap-4">
      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
        <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.analytics') ? 'bg-white/20 font-semibold' : '' }}">
          <i class="bi bi-graph-up-arrow"></i> Analytics
        </a>
      </div>

      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.users.index') ? 'bg-white/20 font-semibold' : '' }}">
          <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.municipal.index') ? 'bg-white/20 font-semibold' : '' }}">
          <i class="bi bi-person-badge"></i> Municipal Admins
        </a>
      </div>

      <div>
        <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Content</p>
        <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i class="bi bi-megaphone"></i> Announce
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i class="bi bi-file-text"></i> Reports
        </a>
        <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i class="bi bi-plus-square"></i> Updates
        </a>
        <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
          <i class="bi bi-calendar-event"></i> Events
        </a>
        <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white/20 font-semibold hover:bg-white/30 transition">
          <i class="bi bi-people-fill"></i> Engagement
        </a>
      </div>
    </nav>
  </aside>

  <!-- ✅ Content -->
  <div class="transition-all duration-500 ease-in-out md:ml-64 p-4 md:p-8"
       :class="{'ml-0': !sidebarOpen && window.innerWidth < 768, 'ml-64': sidebarOpen && window.innerWidth < 768}">
    <div class="max-w-7xl mx-auto glass rounded-xl shadow-glow p-6 animate__animated animate__fadeIn">

      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 animate__animated animate__fadeInDown">
          All Engagements
        </h1>
        <a href="{{ route('admin.engagements.create') }}"
          class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 animate__animated animate__fadeInDown animate__delay-1s">
          Add Engagement
        </a>
      </div>

      <!-- Engagements Table -->
      <div class="overflow-x-auto animate__animated animate__fadeInUp animate__delay-1s">
        <table class="min-w-full table-auto text-sm text-left text-gray-800">
          <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600">
            <tr>
              <th class="px-6 py-4">Title</th>
              <th class="px-6 py-4">Host</th>
              <th class="px-6 py-4">Start Date</th>
              <th class="px-6 py-4">End Date</th>
              <th class="px-6 py-4 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($engagements as $engagement)
            <tr class="hover:bg-blue-50 transition duration-300 transform hover:scale-[1.01]">
              <td class="px-6 py-4 font-semibold text-gray-900" data-label="Title">{{ $engagement->title }}</td>
              <td class="px-6 py-4" data-label="Host">{{ $engagement->host }}</td>
              <td class="px-6 py-4" data-label="Start">{{ \Carbon\Carbon::parse($engagement->start_date)->toFormattedDateString() }}</td>
              <td class="px-6 py-4" data-label="End">{{ \Carbon\Carbon::parse($engagement->end_date)->toFormattedDateString() }}</td>
              <td class="px-6 py-4 text-center flex justify-center space-x-4" data-label="Actions">
                <a href="{{ route('admin.engagements.show', $engagement->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium underline transition duration-200">
                  View
                </a>
                <button type="button" onclick="confirmDelete(this)" data-id="{{ $engagement->id }}" class="text-red-600 hover:text-red-800 font-medium underline transition duration-200">
                  Delete
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">No engagements available.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ✅ SweetAlert Delete Script -->
  <script>
    function confirmDelete(button) {
      const engagementId = button.getAttribute('data-id');

      Swal.fire({
        title: 'Are you sure?',
        text: "This engagement will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        background: '#fff',
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/admin/engagements/${engagementId}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              }
            })
            .then(res => res.json())
            .then(response => {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: 'Engagement deleted successfully.',
                  timer: 1500,
                  showConfirmButton: false
                });
                button.closest('tr').remove();
              } else {
                Swal.fire('Error', response.message || 'Could not delete.', 'error');
              }
            })
            .catch(() => {
              Swal.fire('Error', 'Something went wrong.', 'error');
            });
        }
      });
    }
  </script>

  <!-- ✅ SweetAlert for success session -->
  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'success',
        title: 'Posted!',
        text: @json(session('success')),
        confirmButtonText: 'OK',
        confirmButtonColor: '#2563eb',
        customClass: {
          confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'
        }
      });
    });
  </script>
  @endif

</body>
</html>
