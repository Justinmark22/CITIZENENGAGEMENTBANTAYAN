<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Municipal Admins</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { opacity: 0; transition: opacity 0.3s ease-in-out; }
    body.loaded { opacity: 1; }
    @media (max-width: 768px) {
      table thead { display: none; }
      table tr { 
        display: block; 
        margin-bottom: 1rem; 
        border-radius: 0.5rem; 
        background: white; 
        box-shadow: 0 2px 6px rgba(0,0,0,0.05); 
      }
      table td { 
        display: flex; 
        justify-content: space-between; 
        padding: 0.5rem 0.75rem; 
        border-bottom: 1px solid #e5e7eb; 
      }
      table td:last-child { border-bottom: none; }
      table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #374151;
      }
    }
    @keyframes fadeIn { from {opacity:0; transform:scale(0.95);} to {opacity:1; transform:scale(1);} }
    .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex min-h-screen">

 
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
  <!-- ✅ Mobile Overlay -->
  <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden"></div>

  <!-- ✅ Main Content -->
  <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
    <header class="flex items-center justify-between bg-white dark:bg-gray-800 shadow px-3 py-2 lg:hidden">
      <button onclick="toggleSidebar()" class="text-xl text-gray-700 dark:text-gray-200" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
      </button>
      <h1 class="font-bold text-base">Municipal Admins</h1>
    </header>

    <main class="flex-1 p-3 lg:p-6">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
          <i class=""></i> Manage Admins
        </h1>

        <!-- ✅ Search -->
        <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                 class="px-3 py-2 border rounded-lg w-full sm:w-1/3 text-sm focus:ring-2 focus:ring-blue-500 transition-all" />
          <button type="submit"
                  class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 active:scale-95 transition">
            <i class="bi bi-search"></i>
          </button>
        </form>

        <!-- ✅ Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                  <th class="p-2 text-left">ID</th>
                  <th class="p-2 text-left">Name</th>
                  <th class="p-2 text-left">Email</th>
                  <th class="p-2 text-left">Location</th>
                  <th class="p-2 text-left">Role</th>
                  <th class="p-2 text-left">Status</th>
                  <th class="p-2 text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($groupedAdmins as $location => $admins)
                  <tr class="bg-blue-50 dark:bg-blue-900/40">
                    <td colspan="7" class="p-2 font-semibold text-blue-800 dark:text-blue-300">{{ $location ?? 'No Location' }}</td>
                  </tr>
                  @foreach($admins as $admin)
                  <tr id="row-{{ $admin->id }}" class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="p-2" data-label="ID">{{ $admin->id }}</td>
                    <td class="p-2" data-label="Name" id="name-{{ $admin->id }}">{{ $admin->name }}</td>
                    <td class="p-2" data-label="Email" id="email-{{ $admin->id }}">{{ $admin->email }}</td>
                    <td class="p-2" data-label="Location" id="location-{{ $admin->id }}">{{ $admin->location }}</td>
                    <td class="p-2" data-label="Role" id="role-{{ $admin->id }}">{{ $admin->role }}</td>
                    <td class="p-2" data-label="Status" id="status-{{ $admin->id }}">
                      @if($admin->status === 'active')
                        <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                      @elseif($admin->status === 'disabled')
                        <span class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs">Disabled</span>
                      @else
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-800 rounded-full text-xs">Offline</span>
                      @endif
                    </td>
                    <td class="p-2 text-center flex flex-wrap gap-2 justify-center" data-label="Actions">
                      <button
                        onclick="openEditModal('{{ $admin->id }}','{{ $admin->name }}','{{ $admin->email }}','{{ $admin->location }}','{{ $admin->role }}','{{ $admin->status }}')"
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs transition"
                      >
                        Edit
                      </button>
                      @if($admin->status === 'active')
                        <button
                          onclick="confirmDisable({{ $admin->id }})"
                          class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition"
                        >
                          Disable
                        </button>
                      @else
                        <button
                          onclick="confirmEnable({{ $admin->id }})"
                          class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs transition"
                        >
                          Enable
                        </button>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- ✅ Edit Modal -->
  <div
    id="editModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50"
    role="dialog"
    aria-modal="true"
    aria-labelledby="editModalTitle"
  >
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative animate-fadeIn">
      <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-500" aria-label="Close edit modal">✕</button>
      <h2 id="editModalTitle" class="text-xl font-bold mb-4">Edit Admin</h2>
      <form id="editForm">
        @csrf
        <input type="hidden" name="id" id="editId" />
        <label class="block mb-2 text-sm" for="editName">Name</label>
        <input type="text" name="name" id="editName" class="w-full px-3 py-2 border rounded mb-3" />
        <label class="block mb-2 text-sm" for="editEmail">Email</label>
        <input type="email" name="email" id="editEmail" class="w-full px-3 py-2 border rounded mb-3" />
        <label class="block mb-2 text-sm" for="editLocation">Location</label>
        <input type="text" name="location" id="editLocation" class="w-full px-3 py-2 border rounded mb-3" />
        <label class="block mb-2 text-sm" for="editRole">Role</label>
        <input type="text" name="role" id="editRole" class="w-full px-3 py-2 border rounded mb-3" />
        <label class="block mb-2 text-sm" for="editStatus">Status</label>
        <select name="status" id="editStatus" class="w-full px-3 py-2 border rounded mb-4">
          <option value="active">Active</option>
          <option value="disabled">Disabled</option>
          <option value="offline">Offline</option>
        </select>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.body.classList.add('loaded');
    });

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }

    function openEditModal(id, name, email, location, role, status) {
      const modal = document.getElementById('editModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editEmail').value = email;
      document.getElementById('editLocation').value = location;
      document.getElementById('editRole').value = role;
      document.getElementById('editStatus').value = status;
    }

    function closeEditModal() {
      const modal = document.getElementById('editModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      const id = formData.get('id');

      fetch(`/admin/municipal-admins/update/${id}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Update table values
          document.getElementById(`name-${id}`).innerText = data.name;
          document.getElementById(`email-${id}`).innerText = data.email;
          document.getElementById(`location-${id}`).innerText = data.location;
          document.getElementById(`role-${id}`).innerText = data.role;

          const statusCell = document.getElementById(`status-${id}`);
          if (data.status === 'active') {
            statusCell.innerHTML = '<span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">Active</span>';
          } else if (data.status === 'disabled') {
            statusCell.innerHTML = '<span class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs">Disabled</span>';
          } else {
            statusCell.innerHTML = '<span class="px-2 py-0.5 bg-gray-100 text-gray-800 rounded-full text-xs">Offline</span>';
          }

          closeEditModal();
          Swal.fire('Updated!', 'Admin updated successfully.', 'success');
        } else {
          Swal.fire('Error', 'Failed to update admin.', 'error');
        }
      })
      .catch(() => Swal.fire('Error', 'Something went wrong.', 'error'));
    });

    function confirmDisable(id) {
      Swal.fire({
        title: 'Disable Admin?',
        showCancelButton: true,
        confirmButtonText: 'Yes, disable',
        cancelButtonText: 'Cancel'
      }).then(r => {
        if (r.isConfirmed) window.location.href = `/admin/municipal-admins/disable/${id}`;
      });
    }

    function confirmEnable(id) {
      Swal.fire({
        title: 'Enable Admin?',
        showCancelButton: true,
        confirmButtonText: 'Yes, enable',
        cancelButtonText: 'Cancel'
      }).then(r => {
        if (r.isConfirmed) window.location.href = `/admin/municipal-admins/enable/${id}`;
      });
    }
  </script>
</body>
</html>
