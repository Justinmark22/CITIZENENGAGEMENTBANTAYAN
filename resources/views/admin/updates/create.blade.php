<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Community Updates</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Sidebar animation */
    .sidebar-transition { transition: transform 0.3s ease-in-out; }
    @media (max-width: 768px) {
      body { padding-left: 0 !important; }
      #updateCards { padding-bottom: 2rem; }
    }
  </style>
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-800">

<!-- ✅ Mobile Top Bar -->
<div class="md:hidden bg-blue-800 text-white flex items-center justify-between p-4 shadow-lg">
  <h1 class="text-lg font-bold">Admin Panel</h1>
  <button onclick="toggleSidebar()" class="text-white text-2xl">
    <i class="bi bi-list"></i>
  </button>
</div>

<!-- ✅ Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white p-6 flex flex-col shadow-xl z-50 sidebar-transition transform md:translate-x-0 -translate-x-full md:block">
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold">Admin Panel</h1>
    <button class="md:hidden text-white text-2xl" onclick="toggleSidebar()"><i class="bi bi-x"></i></button>
  </div>

  <nav class="flex flex-col gap-4 overflow-y-auto">
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
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-people"></i> Users
      </a>
      <a href="{{ route('admin.municipal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
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
      <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition bg-white/10">
        <i class="bi bi-plus-square"></i> Updates
      </a>
      <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20 transition">
        <i class="bi bi-calendar-event"></i> Events
      </a>
    </div>
  </nav>
</aside>

<!-- ✅ Main Content -->
<div class="transition-all md:pl-64 p-4 md:p-10">
  <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
    <h1 class="text-2xl font-bold">Community Updates</h1>
    <button onclick="toggleForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">➕ Add Update</button>
  </div>

  <!-- ✅ Toggle Add Form -->
  <div id="updateForm" class="hidden mb-6">
    <form id="updateFormElement" class="space-y-4 bg-white p-4 rounded shadow">
      <div>
        <label class="font-bold block mb-1">Title</label>
        <input type="text" name="title" class="w-full bg-gray-50 p-2 border rounded" required>
      </div>
      <div>
        <label class="font-bold block mb-1">Message</label>
        <textarea name="message" rows="3" class="w-full bg-gray-50 p-2 border rounded" required></textarea>
      </div>
      <div>
        <label class="font-bold block mb-1">Location</label>
        <select name="location" class="w-full bg-gray-50 p-2 border rounded" required>
          <option value="">Select</option>
          <option value="Bantayan">Bantayan</option>
          <option value="Madridejos">Madridejos</option>
          <option value="Santa.Fe">Sta.Fe</option>
        </select>
      </div>
      <div>
        <label class="font-bold block mb-1">Date</label>
        <input type="date" name="update_date" class="w-full bg-gray-50 p-2 border rounded">
      </div>
      <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Publish</button>
      </div>
    </form>
  </div>

  <!-- ✅ Table (Responsive to Cards) -->
  <div class="bg-white rounded-md shadow overflow-x-auto">
    <table class="min-w-full text-sm border border-gray-300 hidden md:table" id="updateTable">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="px-4 py-2 border-r">Title</th>
          <th class="px-4 py-2 border-r">Message</th>
          <th class="px-4 py-2 border-r">Location</th>
          <th class="px-4 py-2 border-r">Date</th>
          <th class="px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="updateTableBody"></tbody>
    </table>

    <!-- ✅ Mobile Card View -->
    <div id="updateCards" class="md:hidden divide-y"></div>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold mb-4">Edit Update</h2>
    <form id="editForm">
      <input type="hidden" name="id" id="edit-id">
      <div class="mb-3">
        <label class="block text-sm font-medium">Title</label>
        <input type="text" id="edit-title" name="title" class="w-full p-2 border rounded" required>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Message</label>
        <textarea id="edit-message" name="message" class="w-full p-2 border rounded" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Location</label>
        <select id="edit-location" name="location" class="w-full p-2 border rounded" required>
          <option value="Bantayan">Bantayan</option>
          <option value="Madridejos">Madridejos</option>
          <option value="Santa.Fe">Sta.Fe</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium">Date</label>
        <input type="date" id="edit-date" name="update_date" class="w-full p-2 border rounded">
      </div>
      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
  // ✅ Sidebar Toggle
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
  }

  function toggleForm() {
    document.getElementById('updateForm').classList.toggle('hidden');
  }

  // ✅ Fetch Updates on Load
  document.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split("T")[0];
    const dateInput = document.querySelector('input[name="update_date"]');
    if (dateInput) dateInput.setAttribute("min", today);

    fetch("{{ route('admin.updates.all') }}")
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById('updateTableBody');
        const cards = document.getElementById('updateCards');
        data.forEach(update => addRow(update, tbody, cards));
      });
  });

  // ✅ Add Row (Table + Card)
  function addRow(update, tbody, cards) {
    if (update.update_date) {
      const updateTime = new Date(update.update_date).getTime();
      const now = new Date().getTime();
      const diffHours = (now - updateTime) / (1000 * 60 * 60);
      if (diffHours > 24) return;
    }

    // Desktop Table Row
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="border px-4 py-2">${update.title}</td>
      <td class="border px-4 py-2">${update.message}</td>
      <td class="border px-4 py-2">${update.location}</td>
      <td class="border px-4 py-2">${update.update_date ?? '-'}</td>
      <td class="border px-4 py-2 text-center">
        <a href="#" class="text-yellow-600 hover:underline"
           onclick="openEditModal(this)"
           data-id="${update.id}"
           data-title="${update.title}"
           data-message="${update.message}"
           data-location="${update.location}"
           data-date="${update.update_date ?? ''}">Edit</a>
        <a href="#" onclick="deleteRow(this)" data-id="${update.id}" class="text-red-600 hover:underline">Delete</a>
      </td>`;
    tbody.appendChild(tr);

    // Mobile Card View
    const card = document.createElement('div');
    card.className = "bg-white m-3 p-4 rounded-xl shadow-md border border-gray-100";
    card.innerHTML = `
      <div class="flex justify-between items-center mb-2">
        <h3 class="font-bold text-lg text-gray-800">${update.title}</h3>
        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium">${update.location}</span>
      </div>
      <p class="text-gray-700 mb-3">${update.message}</p>
      <div class="flex justify-between items-center text-sm text-gray-500 border-t pt-2">
        <span>📅 ${update.update_date ?? '-'}</span>
        <div class="flex gap-3">
          <button class="text-yellow-600 hover:text-yellow-800 transition"
            onclick="openEditModal(this)"
            data-id="${update.id}"
            data-title="${update.title}"
            data-message="${update.message}"
            data-location="${update.location}"
            data-date="${update.update_date ?? ''}">
            <i class="bi bi-pencil-square text-lg"></i>
          </button>
          <button class="text-red-600 hover:text-red-800 transition"
            onclick="deleteRow(this)"
            data-id="${update.id}">
            <i class="bi bi-trash text-lg"></i>
          </button>
        </div>
      </div>
    `;
    cards.appendChild(card);
  }

  // ✅ Add Update
  document.getElementById('updateFormElement').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch("{{ route('admin.updates.store') }}", {
      method: "POST",
      headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      Swal.fire({ icon: 'success', title: 'Update Posted!', timer: 2000, showConfirmButton: false });
      addRow(data, document.getElementById('updateTableBody'), document.getElementById('updateCards'));
      form.reset();
      toggleForm();
    });
  });

  // ✅ Delete Row
  function deleteRow(link) {
    const id = link.getAttribute('data-id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This update will be permanently deleted!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#e3342f'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`/admin/updates/${id}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(res => {
          if (res.ok) {
            Swal.fire('Deleted!', 'The update has been removed.', 'success');
            link.closest('tr')?.remove();
            link.closest('div')?.remove();
          } else {
            Swal.fire('Error!', 'Failed to delete the update.', 'error');
          }
        });
      }
    });
  }

  // ✅ Fixed Open Edit Modal
  function openEditModal(el) {
    let dataset = el.dataset;
    document.getElementById('edit-id').value = dataset.id;
    document.getElementById('edit-title').value = dataset.title;
    document.getElementById('edit-message').value = dataset.message;
    document.getElementById('edit-location').value = dataset.location;
    document.getElementById('edit-date').value = dataset.date;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');

    window.currentRow = document.querySelector(`tr a[data-id="${dataset.id}"]`)?.closest('tr') || null;
    window.currentCard = document.querySelector(`#updateCards button[data-id="${dataset.id}"]`)?.closest('div') || null;
  }

  function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
  }

  // ✅ Fixed Save Edit
  document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const id = formData.get('id');
    formData.append('_method', 'PUT');

    fetch(`/admin/updates/${id}`, {
      method: "POST",
      headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      Swal.fire({ icon: 'success', title: 'Update Saved!', timer: 1500, showConfirmButton: false });

      if (window.currentRow) {
        window.currentRow.children[0].innerText = data.title;
        window.currentRow.children[1].innerText = data.message;
        window.currentRow.children[2].innerText = data.location;
        window.currentRow.children[3].innerText = data.update_date || '-';
      }

      if (window.currentCard) {
        window.currentCard.querySelector('h3').innerText = data.title;
        window.currentCard.querySelector('p.text-gray-700').innerText = data.message;
        window.currentCard.querySelector('span.bg-blue-100').innerText = data.location;
        window.currentCard.querySelector('span').innerText = `📅 ${data.update_date || '-'}`;
        window.currentCard.querySelectorAll('button').forEach(btn => {
          btn.dataset.title = data.title;
          btn.dataset.message = data.message;
          btn.dataset.location = data.location;
          btn.dataset.date = data.update_date || '';
        });
      }

      closeModal();
    });
  });
</script>

</body>
</html>
