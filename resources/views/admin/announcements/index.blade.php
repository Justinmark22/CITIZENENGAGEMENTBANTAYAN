<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Announcements</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { font-family: 'Inter', sans-serif; }
    /* ✅ Smooth animation */
    .sidebar-transition {
      transition: all 0.3s ease-in-out;
    }
    /* ✅ Mobile overlay */
    .sidebar-overlay {
      transition: opacity 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- ✅ Mobile Header with Hamburger -->
<div class="lg:hidden fixed top-0 left-0 right-0 bg-blue-700 text-white flex items-center justify-between px-4 py-3 z-50 shadow">
  <h1 class="text-lg font-bold">Admin Panel</h1>
  <button id="sidebarToggle" class="text-white text-2xl focus:outline-none">
    <i class="bi bi-list"></i>
  </button>
</div>

<!-- ✅ Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white p-6 flex flex-col shadow-xl z-50 sidebar-transition -translate-x-full lg:translate-x-0">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold hidden lg:block">Admin Panel</h1>
    <!-- Close button for mobile -->
    <button id="closeSidebar" class="lg:hidden text-white text-2xl">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  
  <nav class="flex flex-col gap-4">
    <!-- 📊 Dashboard Section -->
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">Main</p>
      <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.analytics') ? 'bg-white/20 font-semibold' : '' }}">
        <i class="bi bi-graph-up-arrow"></i> Analytics
      </a>
    </div>

    <!-- 👥 User Management -->
    <div>
      <p class="text-xs uppercase tracking-wider text-white/60 mb-2">User Management</p>
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.users.index') ? 'bg-white/20 font-semibold' : '' }}">
        <i class="bi bi-people"></i> Users
      </a>
      <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('admin.municipal.index') ? 'bg-white/20 font-semibold' : '' }}">
        <i class="bi bi-person-badge"></i> Municipal Admins
      </a>
    </div>

    <!-- 📢 Content Section -->
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
      <a href="{{ route('admin.engagements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people-fill"></i> Engagement
      </a>
    </div>
  </nav>
</aside>

<!-- ✅ Mobile Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden sidebar-overlay"></div>

<!-- ✅ Main Content -->
<div class="lg:ml-64 pt-16 lg:pt-6 p-4 lg:p-6 max-w-7xl mx-auto sidebar-transition">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
    <a href="{{ route('admin.announcements.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow-sm">➕ Add Announcement</a>
  </div>

  <!-- ✅ Filters -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col md:flex-row gap-3 mb-4">
    <input id="searchInput" type="text" placeholder=" Search announcements..." class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
    <select id="locationFilter" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
      <option value="">All Locations</option>
      <option value="Bantayan">Bantayan</option>
      <option value="Santa.Fe">Santa.Fe</option>
      <option value="Madridejos">Madridejos</option>
    </select>
    <button id="resetFilters" class="bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-sm">Reset</button>
  </div>

  <!-- ✅ Table -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
    <!-- ✅ Your announcement table stays the same -->
    @php $grouped = $announcements->groupBy('location'); @endphp

    <table class="w-full text-sm" id="announcementTable">
      <thead class="bg-gray-100 sticky top-0">
        <tr class="text-gray-700">
          <th class="px-4 py-3 text-left">Title</th>
          <th class="px-4 py-3 text-left">Message</th>
          <th class="px-4 py-3">Start Date</th>
          <th class="px-4 py-3">End Date</th>
          <th class="px-4 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($grouped as $location => $items)
          <tr class="bg-gray-50 location-header" data-location="{{ $location }}">
            <td colspan="5" class="px-4 py-2 font-semibold text-gray-600">
              {{ $location === 'Santa.Fe' ? 'Sta.Fe' : $location }}
            </td>
          </tr>
          @foreach ($items as $announcement)
            <tr class="hover:bg-blue-50 transition announcement-row" data-location="{{ $location }}">
              <td class="px-4 py-3">{{ $announcement->title }}</td>
              <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($announcement->message, 60) }}</td>
              <td class="px-4 py-3 text-center">{{ $announcement->start_date ? \Carbon\Carbon::parse($announcement->start_date)->format('M d, Y') : 'N/A' }}</td>
              <td class="px-4 py-3 text-center">{{ $announcement->end_date ? \Carbon\Carbon::parse($announcement->end_date)->format('M d, Y') : 'N/A' }}</td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center gap-3">
                  <button 
                    class="text-blue-600 hover:underline edit-btn"
                    data-id="{{ $announcement->id }}"
                    data-title="{{ $announcement->title }}"
                    data-message="{{ $announcement->message }}"
                    data-start="{{ $announcement->start_date }}"
                    data-end="{{ $announcement->end_date }}">Edit</button>

                  <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->id) }}">
                    @csrf @method('DELETE')
                    <button type="button" class="text-red-600 hover:underline delete-announcement-btn" data-announcement="{{ $announcement->title }}">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        @empty
          <tr><td colspan="5" class="text-center py-6 text-gray-500">No announcements found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-xl p-6">
    <h2 class="text-lg font-semibold mb-4">Edit Announcement</h2>
    <form id="editForm" method="POST" class="space-y-3">
      @csrf @method('PUT')
      <input type="hidden" name="id" id="editId">
      <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" id="editTitle" class="w-full border rounded-lg px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Message</label>
        <textarea name="message" id="editMessage" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm font-medium">Start Date</label>
          <input type="date" name="start_date" id="editStart" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium">End Date</label>
          <input type="date" name="end_date" id="editEnd" class="w-full border rounded-lg px-3 py-2">
        </div>
      </div>
      <div class="flex justify-end gap-3 pt-3">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
// ✅ Sidebar toggle
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const closeSidebar = document.getElementById('closeSidebar');
const overlay = document.getElementById('overlay');

sidebarToggle.addEventListener('click', () => {
  sidebar.classList.remove('-translate-x-full');
  overlay.classList.remove('hidden');
});
closeSidebar.addEventListener('click', () => {
  sidebar.classList.add('-translate-x-full');
  overlay.classList.add('hidden');
});
overlay.addEventListener('click', () => {
  sidebar.classList.add('-translate-x-full');
  overlay.classList.add('hidden');
});

// ✅ Filtering logic
const searchInput = document.getElementById('searchInput');
const locationFilter = document.getElementById('locationFilter');
const resetFilters = document.getElementById('resetFilters');
const rows = document.querySelectorAll('.announcement-row');
const headers = document.querySelectorAll('.location-header');

function filterTable(){
  const q = searchInput.value.toLowerCase();
  const loc = locationFilter.value;
  const locationVisibility = {};

  rows.forEach(row=>{
    const text = row.innerText.toLowerCase();
    const rowLoc = row.dataset.location;
    const match = text.includes(q);
    const matchLoc = loc==='' || rowLoc===loc;
    const show = match && matchLoc;

    row.style.display = show ? '' : 'none';
    if(show){ locationVisibility[rowLoc]=true; }
  });

  headers.forEach(header=>{
    const locName = header.dataset.location;
    header.style.display = locationVisibility[locName] ? '' : 'none';
  });
}

searchInput.addEventListener('input', filterTable);
locationFilter.addEventListener('change', filterTable);
resetFilters.addEventListener('click', () => {
  searchInput.value = '';
  locationFilter.value = '';
  filterTable();
});

// ✅ Edit Modal
document.querySelectorAll('.edit-btn').forEach(btn=>{
  btn.addEventListener('click',function(){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
    document.getElementById('editId').value=this.dataset.id;
    document.getElementById('editTitle').value=this.dataset.title;
    document.getElementById('editMessage').value=this.dataset.message;
    document.getElementById('editStart').value=this.dataset.start;
    document.getElementById('editEnd').value=this.dataset.end;
    document.getElementById('editForm').action=`/admin/announcements/${this.dataset.id}`;
  });
});

document.getElementById('editForm').addEventListener('submit', function(e){
  e.preventDefault();
  const form = this;
  const title = document.getElementById('editTitle').value;

  Swal.fire({
    title: 'Update Announcement?',
    text: `"${title}" will be updated.`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Update',
    cancelButtonText: 'Cancel'
  }).then(res=>{
    if(res.isConfirmed){
      Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: `"${title}" has been updated successfully.`,
        timer: 1500,
        showConfirmButton: false
      });
      setTimeout(()=> form.submit(), 1500);
    }
  });
});

function closeModal(){
  document.getElementById('editModal').classList.add('hidden');
  document.getElementById('editModal').classList.remove('flex');
}

// ✅ Delete Confirmation
document.querySelectorAll('.delete-announcement-btn').forEach(btn=>{
  btn.addEventListener('click',function(){
    const form = this.closest('form');
    const title = this.dataset.announcement;

    Swal.fire({
      title: 'Delete this announcement?',
      text: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel'
    }).then(res=>{
      if(res.isConfirmed){
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: `"${title}" has been removed.`,
          timer: 1500,
          showConfirmButton: false
        });
        setTimeout(()=> form.submit(), 1500);
      }
    });
  });
});
</script>
</body>
</html>
