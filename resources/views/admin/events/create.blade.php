<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Community Events</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Sidebar */
    .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 240px; background: linear-gradient(180deg, #1e3a8a, #1e40af); color: #fff; padding: 32px 20px; display: flex; flex-direction: column; box-shadow: 4px 0 16px rgba(0, 0, 0, 0.1); border-top-right-radius: 20px; border-bottom-right-radius: 20px; z-index: 1000; }
    .sidebar-nav { display: flex; flex-direction: column; gap: 16px; margin-top: 20px; }
    .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: 12px; text-decoration: none; color: #e0e7ff; font-weight: 500; font-size: 15px; transition: all 0.3s ease; }
    .sidebar-link:hover { background-color: rgba(255, 255, 255, 0.15); transform: translateX(6px); }
    .sidebar-link.active { background-color: rgba(255, 255, 255, 0.25); font-weight: 600; }
    .main-content { margin-left: 260px; padding: 20px; }
    @media (max-width: 992px) {
      .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
      .sidebar.show { transform: translateX(0); }
      .main-content { margin-left: 0; }
    }

    /* Animations */
    @keyframes fadeScaleIn {
      0% { opacity: 0; transform: scale(0.9); }
      100% { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeScaleOut {
      0% { opacity: 1; transform: scale(1); }
      100% { opacity: 0; transform: scale(0.9); }
    }
    @keyframes slideFadeIn {
      0% { opacity: 0; transform: translateY(10px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animate-row { animation: slideFadeIn 0.4s ease forwards; }
    .modal-open { animation: fadeScaleIn 0.3s ease forwards; }
    .modal-close { animation: fadeScaleOut 0.2s ease forwards; }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<style>
  /* Sidebar animation fix */
  @media (max-width: 992px) {
    #sidebar {
      transition: transform 0.3s ease;
    }
    #sidebar.show {
      transform: translateX(0) !important;
    }
  }
</style>

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

<!-- ✅ Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-40 hidden lg:hidden z-40" onclick="toggleSidebar()"></div>

<!-- ✅ Mobile Toggle Button -->
<button class="fixed top-4 left-4 bg-blue-600 text-white p-2 rounded-lg z-50 lg:hidden" onclick="toggleSidebar()">☰ Menu</button>

<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  sidebar.classList.toggle('show');
  overlay.classList.toggle('hidden');
}

// ✅ Close sidebar when clicking any link (mobile only)
document.querySelectorAll('#sidebar .sidebar-link').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 992) toggleSidebar();
  });
});
</script>


<div class="max-w-5xl mx-auto px-4 py-10">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold"> Community Events</h1>
    <button onclick="toggleEventForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">➕ Add Event</button>
  </div>

  <!-- Add Event Form -->
  <div id="eventForm" class="hidden mb-6 transition-all duration-300">
    <form id="eventFormElement" class="grid grid-cols-3 gap-0 border border-gray-300 rounded-md overflow-hidden bg-white shadow">
      @csrf
      <!-- Title -->
      <div class="col-span-1 bg-gray-100 font-bold p-3">Title</div>
      <div class="col-span-2 p-2 border-t border-l">
        <input type="text" name="title" class="w-full bg-gray-50 p-2 border rounded" required>
      </div>
      <!-- Category -->
      <div class="col-span-1 bg-gray-100 font-bold p-3">Category</div>
      <div class="col-span-2 p-2 border-t border-l">
        <input type="text" name="category" class="w-full bg-gray-50 p-2 border rounded" required>
      </div>
      <!-- Location -->
      <div class="col-span-1 bg-gray-100 font-bold p-3">Location</div>
      <div class="col-span-2 p-2 border-t border-l">
        <select name="location" class="w-full bg-gray-50 p-2 border rounded" required>
          <option value="">Select</option>
          <option value="Bantayan">Bantayan</option>
          <option value="Madridejos">Madridejos</option>
          <option value="Santa.Fe">Sta.Fe</option>
        </select>
      </div>
      <!-- Date -->
      <div class="col-span-1 bg-gray-100 font-bold p-3">Date</div>
      <div class="col-span-2 p-2 border-t border-l">
        <input type="date" name="event_date" class="w-full bg-gray-50 p-2 border rounded">
      </div>
      <!-- Time -->
      <div class="col-span-1 bg-gray-100 font-bold p-3">Time</div>
      <div class="col-span-2 p-2 border-t border-l">
        <input type="time" name="event_time" class="w-full bg-gray-50 p-2 border rounded">
      </div>
      <!-- Publish Button -->
      <div class="col-span-3 p-4 text-right border-t">
        <button type="button" onclick="confirmPublish()" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Publish
        </button>
      </div>
    </form>
  </div>
<!-- Events Table (Desktop) -->
<div class="bg-white rounded-md shadow overflow-x-auto hidden sm:block">
  <table class="min-w-full text-sm border border-gray-300" id="eventTable">
    <thead class="bg-gray-100 text-left">
      <tr>
        <th class="px-4 py-2 border-r">Title</th>
        <th class="px-4 py-2 border-r">Category</th>
        <th class="px-4 py-2 border-r">Location</th>
        <th class="px-4 py-2 border-r">Date</th>
        <th class="px-4 py-2 border-r">Time</th>
        <th class="px-4 py-2 text-center">Actions</th>
      </tr>
    </thead>
    <tbody id="eventTableBody"></tbody>
  </table>
</div>

<!-- Mobile Cards -->
<div id="eventMobileCards" class="sm:hidden space-y-4"></div>


<!-- ✅ Edit Modal -->
<div id="editEventModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-2xl transform opacity-0 scale-95 transition-all duration-300 ease-out" id="modalContent">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">Edit Event</h2>
      <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
    </div>
    <form id="editEventForm" class="space-y-4">
      @csrf
      <input type="hidden" name="id" id="edit-id">
      <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" id="edit-title" name="title" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Content</label>
        <input type="text" id="edit-category" name="category" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Location</label>
        <select id="edit-location" name="location" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
          <option value="Bantayan">Bantayan</option>
          <option value="Madridejos">Madridejos</option>
          <option value="Santa.Fe">Sta.Fe</option>
        </select>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium">Date</label>
          <input type="date" id="edit-date" name="event_date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
          <label class="block text-sm font-medium">Time</label>
          <input type="time" id="edit-time" name="event_time" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>
      </div>
      <div class="flex justify-end space-x-2 pt-2 border-t mt-4">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
  const csrfToken = @json(csrf_token());
  const storeUrl = @json(route('admin.events.store'));
  const allEventsUrl = @json(route('admin.events.all'));
  const updateUrl = id => `/admin/events/${id}`;   // Laravel RESTful route
  const deleteUrl = id => `/admin/events/${id}`;   // Laravel RESTful route

  function toggleEventForm() {
    document.getElementById('eventForm').classList.toggle('hidden');
  }
function confirmPublish() {
  Swal.fire({
    title: 'Publish Event?',
    text: "Do you want to publish this event?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, Publish'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById('eventFormElement');
      const formData = new FormData(form);

      fetch(storeUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.id) {
          Swal.fire('✅ Published!', 'Event has been added.', 'success');
          addEventRow(data); // Add to table and mobile cards
          form.reset();
          document.getElementById('eventForm').classList.add('hidden');
        } else {
          Swal.fire('⚠️ Error', 'Failed to publish event.', 'error');
        }
      })
      .catch(() => Swal.fire('❌ Error', 'Could not connect to server.', 'error'));
    }
  });
}
  function addEventRow(event) {
  // ✅ Desktop Table Row
  const tbody = document.getElementById('eventTableBody');
  const tr = document.createElement('tr');
  tr.setAttribute('data-id', event.id);
  tr.classList.add('animate-row');
  tr.innerHTML = `
    <td class="border px-4 py-2">${event.title}</td>
    <td class="border px-4 py-2">${event.category}</td>
    <td class="border px-4 py-2">${event.location}</td>
    <td class="border px-4 py-2">${event.event_date ?? '-'}</td>
    <td class="border px-4 py-2">${event.event_time ?? '-'}</td>
    <td class="border px-4 py-2 text-center space-x-2">
      <a href="#" class="text-yellow-600 hover:underline" onclick="openEditEventModal(this)"
         data-id="${event.id}"
         data-title="${event.title}"
         data-category="${event.category}"
         data-location="${event.location}"
         data-date="${event.event_date || ''}"
         data-time="${event.event_time || ''}">Edit</a>
      <a href="#" onclick="deleteRow(this)" data-id="${event.id}" class="text-red-600 hover:underline">Delete</a>
    </td>
  `;
  tbody.prepend(tr);

  // ✅ Mobile Card
  const cardContainer = document.getElementById('eventMobileCards');
  const card = document.createElement('div');
  card.setAttribute('data-id', event.id);
  card.className = "bg-white rounded-lg shadow p-4 border animate-row";
  card.innerHTML = `
    <div class="mb-2"><strong>Title:</strong> ${event.title}</div>
    <div class="mb-2"><strong>Category:</strong> ${event.category}</div>
    <div class="mb-2"><strong>Location:</strong> ${event.location}</div>
    <div class="mb-2"><strong>Date:</strong> ${event.event_date ?? '-'}</div>
    <div class="mb-2"><strong>Time:</strong> ${event.event_time ?? '-'}</div>
    <div class="flex justify-end space-x-3 mt-2">
      <button class="text-yellow-600 underline"
        onclick="openEditEventModal(this)"
        data-id="${event.id}"
        data-title="${event.title}"
        data-category="${event.category}"
        data-location="${event.location}"
        data-date="${event.event_date || ''}"
        data-time="${event.event_time || ''}">Edit</button>
      <button class="text-red-600 underline" onclick="deleteRow(this)" data-id="${event.id}">Delete</button>
    </div>
  `;
  cardContainer.prepend(card);
}


  function openEditEventModal(link) {
    document.getElementById('edit-id').value = link.dataset.id;
    document.getElementById('edit-title').value = link.dataset.title;
    document.getElementById('edit-category').value = link.dataset.category;
    document.getElementById('edit-location').value = link.dataset.location;
    document.getElementById('edit-date').value = link.dataset.date;
    document.getElementById('edit-time').value = link.dataset.time;

    const modal = document.getElementById('editEventModal');
    const content = document.getElementById('modalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => content.classList.remove('opacity-0', 'scale-95'), 10);
  }

  function closeEditModal() {
    const modal = document.getElementById('editEventModal');
    const content = document.getElementById('modalContent');
    content.classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }, 200);
  }

  // ✅ UPDATE EVENT
  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const formData = new FormData(this);

    fetch(updateUrl(id), {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'X-HTTP-Method-Override': 'PUT'
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      Swal.fire('✅ Updated!', 'Event updated successfully.', 'success');
      closeEditModal();

      // 🔄 Update the row
      const row = document.querySelector(`tr[data-id="${id}"]`);
      row.children[0].textContent = data.title;
      row.children[1].textContent = data.category;
      row.children[2].textContent = data.location;
      row.children[3].textContent = data.event_date ?? '-';
      row.children[4].textContent = data.event_time ?? '-';
    })
    .catch(() => Swal.fire('❌ Error', 'Could not update event.', 'error'));
  });

  // ✅ DELETE EVENT
  function deleteRow(el) {
    const id = el.dataset.id;
    Swal.fire({
      title: 'Are you sure?',
      text: "This will permanently delete the event.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(deleteUrl(id), {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-HTTP-Method-Override': 'DELETE'
          }
        })
        .then(res => res.json())
        .then(() => {
          Swal.fire(' Deleted!', 'Event has been deleted.', 'success');
          el.closest('tr').remove();
        })
        .catch(() => Swal.fire('❌ Error', 'Could not delete event.', 'error'));
      }
    });
  }

  // ✅ Load all events
  document.addEventListener('DOMContentLoaded', () => {
    fetch(allEventsUrl)
      .then(res => res.json())
      .then(data => data.forEach(event => addEventRow(event)));
  });
  // Disable past dates
  document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.querySelector('input[name="event_date"]');
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);

    const editDateInput = document.getElementById('edit-date');
    if (editDateInput) editDateInput.setAttribute('min', today);
  });
</script>


</body>
</html>
