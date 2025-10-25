<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Bantayan - Reports</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* small helpers */
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(6px); }
  </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">

  <!-- Layout: Sidebar -->
  <aside class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-emerald-400 to-sky-600 text-white p-6">
    <div class="flex flex-col items-center gap-3 mb-6">
      <img src="{{ asset('images/santafe.png') }}" alt="logo" class="w-20 h-20 rounded-full object-cover">
      <div class="text-center">
        <div class="font-semibold">Bantayan Admin</div>
        <div class="text-xs opacity-90">Municipal Dashboard</div>
      </div>
    </div>

    <nav class="flex flex-col gap-2 text-sm">
      <a href="{{ route('dashboard.bantayanadmin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="home" class="w-4 h-4"></i> Dashboard
      </a>
      <a href="{{ route('bantayan.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="users" class="w-4 h-4"></i> Users
      </a>
      <a href="{{ route('bantayan.reports') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white/20">
        <i data-lucide="file-text" class="w-4 h-4"></i> Reports
      </a>
      <a href="{{ route('bantayan.feedback') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
      </a>
      <a href="{{ route('bantayan.announcements') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="megaphone" class="w-4 h-4"></i> Announcements
      </a>
      <a href="{{ route('bantayan.events') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="calendar-days" class="w-4 h-4"></i> Events
      </a>
      <a href="{{ route('bantayan.updates') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
        <i data-lucide="message-square" class="w-4 h-4"></i> Updates
      </a>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="ml-64 p-8">
    <!-- Navbar -->
    <header class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-semibold flex items-center gap-3"><i data-lucide="radar" class="w-5 h-5 text-sky-600"></i> Report Management</h1>
        <p class="text-sm text-slate-600">Manage incoming reports, forward to departments, update status, export and print.</p>
      </div>

      <div class="flex items-center gap-3">
        <div class="text-sm text-slate-600 flex items-center gap-2 bg-white/80 px-3 py-2 rounded-full shadow">
          <i data-lucide="user-cog" class="w-4 h-4 text-sky-600"></i>
          {{ Auth::user()->email ?? 'admin@santafe.gov' }}
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
      </div>
    </header>

    <!-- Filters + Chart -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
      <div class="lg:col-span-2 glass p-4 rounded-xl shadow-sm">
        <form method="GET" action="{{ route('bantayan.reports') }}" class="flex flex-wrap gap-3 items-center">
          <select name="status" class="p-2 border rounded-lg text-sm">
            <option value="">All Status</option>
            <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
            <option value="Ongoing" {{ request('status')=='Ongoing'?'selected':'' }}>Ongoing</option>
            <option value="Resolved" {{ request('status')=='Resolved'?'selected':'' }}>Resolved</option>
            <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
          </select>
          <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-sm">Filter</button>
          <div class="ml-auto text-sm text-slate-600">Showing <strong>{{ $reports->count() }}</strong> results</div>
        </form>

        <!-- optional chart area -->
        <div class="mt-4">
          <canvas id="reportsChart" height="80"></canvas>
        </div>
      </div>

     
    </section>

    <!-- Reports grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($reports as $report)
        <article
          class="glass p-4 rounded-2xl shadow hover:shadow-lg transition cursor-pointer relative"
          data-id="{{ $report->id }}"
          data-title="{{ htmlspecialchars($report->title, ENT_QUOTES) }}"
          data-description="{{ htmlspecialchars($report->description, ENT_QUOTES) }}"
          data-location="{{ htmlspecialchars($report->location, ENT_QUOTES) }}"
          data-status="{{ $report->status }}"
          data-date="{{ $report->created_at->format('M d, Y H:i') }}"
          data-photo="{{ $report->photo ? asset('storage/'.$report->photo) : '' }}"
          data-update-url="{{ route('bantayan.reports.update', $report->id) }}"
         
          data-forward-url="{{ route('reports.forward') }}"
          onclick="openModalFromCard(this)"
        >
          <div class="flex items-start gap-3">
            <div class="flex-1">
              <h4 class="font-semibold text-slate-800">{{ $report->title }}</h4>
              <p class="text-sm text-slate-600 mt-1">{{ Str::limit($report->description, 110) }}</p>
              <div class="mt-3 flex items-center justify-between gap-2 text-xs">
                <div class="flex items-center gap-2 text-slate-500">
                  <i data-lucide="map-pin" class="w-4 h-4"></i>
                  <span>{{ $report->location }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="px-2 py-1 rounded-full text-xs font-semibold
                    @if($report->status==='Resolved') bg-green-500 text-white
                    @elseif($report->status==='Rejected') bg-red-500 text-white
                    @elseif($report->status==='Ongoing') bg-sky-500 text-white
                    @else bg-yellow-400 text-black @endif">
                    {{ $report->status }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- actions (small) -->
          <div class="mt-4 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
              <!-- Export (if resolved) -->
              @if($report->status === 'Resolved')
                <a href="{{ route('bantayan.export', $report->id) }}" class="text-sky-600 text-sm flex items-center gap-1">
                  <i data-lucide="download" class="w-4 h-4"></i> Export
                </a>
              @endif
            </div>

            <div class="flex items-center gap-2">
              <!-- Inline actions: update status forms (we'll use JS fetch for these) -->
              <button class="text-xs px-2 py-1 rounded-md border" onclick="event.stopPropagation(); updateStatusConfirm({{ $report->id }}, 'Ongoing', '{{ route('bantayan.reports.update', $report->id) }}')">Mark Ongoing</button>
              <button class="text-xs px-2 py-1 rounded-md border" onclick="event.stopPropagation(); updateStatusConfirm({{ $report->id }}, 'Resolved', '{{ route('bantayan.reports.update', $report->id) }}')">Resolve</button>

              <!-- forward dropdown -->
              <div class="relative" onclick="event.stopPropagation()">
                <button onclick="toggleForwardMenu(event, {{ $report->id }})" class="text-xs px-2 py-1 rounded-md border flex items-center gap-1">
                  <i data-lucide="send" class="w-4 h-4"></i> Forward
                </button>
                <div id="forward-menu-{{ $report->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white shadow rounded-md p-2 z-50">
                  <button class="w-full text-left text-sm px-2 py-1 rounded hover:bg-slate-50" onclick="forwardReport({{ $report->id }}, 'MDRRMO', '{{ route('reports.forward') }}')">MDRRMO</button>
                  <button class="w-full text-left text-sm px-2 py-1 rounded hover:bg-slate-50" onclick="forwardReport({{ $report->id }}, 'Waste Management', '{{ route('reports.forward') }}')">Waste Management</button>
                  <button class="w-full text-left text-sm px-2 py-1 rounded hover:bg-slate-50" onclick="forwardReport({{ $report->id }}, 'Water Management', '{{ route('reports.forward') }}')">Water Management</button>
                  <button class="w-full text-left text-sm px-2 py-1 rounded hover:bg-slate-50" onclick="forwardReport({{ $report->id }}, 'Fire Department', '{{ route('reports.forward') }}')">Fire Department</button>
                </div>
              </div>

            
            </div>
          </div>
        </article>
      @empty
        <div class="col-span-full text-center text-slate-600 py-8">No reports found.</div>
      @endforelse
    </section>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $reports->withQueryString()->links() }}
    </div>
  </div>

  <!-- Modal (hidden by default) -->
  <div id="reportModal" class="fixed inset-0 z-60 hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-black/40" onclick="closeModal()"></div>

    <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden z-70">
      <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-sky-600 to-teal-400 text-white">
        <div class="flex items-center gap-3">
          <i data-lucide="radar" class="w-5 h-5"></i>
          <h3 class="text-lg font-semibold">Report Overview</h3>
        </div>
        <div class="flex items-center gap-3">
          <button class="text-white/80" onclick="closeModal()"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
      </div>

      <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
          <div class="mb-3">
            <label class="text-sm text-slate-500">Title</label>
            <div id="modalReportTitle" class="text-lg font-semibold text-slate-900"></div>
          </div>

          <div class="mb-3">
            <label class="text-sm text-slate-500">Location</label>
            <div id="modalReportLoc" class="text-sm text-slate-700"></div>
          </div>

          <div class="mb-3">
            <label class="text-sm text-slate-500">Description</label>
            <div id="modalReportDesc" class="mt-2 text-sm text-slate-700 bg-slate-50 p-3 rounded"></div>
          </div>

          <div class="flex gap-4 mt-4">
            <div>
              <label class="text-sm text-slate-500">Status</label>
              <div id="modalReportStatus" class="mt-1 px-3 py-1 rounded-full text-sm font-semibold bg-yellow-400"></div>
            </div>
            <div>
              <label class="text-sm text-slate-500">Submitted</label>
              <div id="modalReportDate" class="mt-1 text-sm text-slate-700"></div>
            </div>
          </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-3">
          <div id="modalPhotoWrap" class="w-full flex items-center justify-center bg-slate-50 rounded p-4">
            <img id="modalReportPhoto" src="" alt="photo" class="max-h-60 object-cover rounded hidden">
            <p id="noPhotoText" class="text-sm text-slate-500">No photo available</p>
          </div>

          <div class="w-full flex justify-between gap-2">
            <button onclick="printReport()" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Print</button>
            <div class="flex gap-2">
              <button id="modalResolveBtn" class="px-3 py-2 bg-green-600 text-white rounded-lg" onclick="updateStatusConfirmFromModal('Resolved')">Mark Resolved</button>
              <button id="modalOngoingBtn" class="px-3 py-2 bg-sky-600 text-white rounded-lg" onclick="updateStatusConfirmFromModal('Ongoing')">Mark Ongoing</button>
            </div>
          </div>
        </div>
      </div>

      <div class="px-6 py-4 bg-slate-50 flex items-center justify-between">
        <div class="text-sm text-slate-500">Bantayan • Admin Panel</div>
        <div class="flex items-center gap-2">
          <button class="px-3 py-2 rounded bg-white border" onclick="closeModal()">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // initialize icons
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());

    // chart
    fetch('/reports/chart-data')
      .then(res => res.json())
      .then(data => {
        const ctx = document.getElementById('reportsChart');
        if (!ctx) return;
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data.labels,
            datasets: [{ label: 'Report Count', data: data.counts, backgroundColor: ['#facc15','#f97316','#22c55e'], borderRadius: 8 }]
          },
          options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
      })
      .catch(()=>{ /* ignore chart load errors gracefully */ });

    // Helpers
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentModalReport = null;

    // open modal from card element
    function openModalFromCard(card) {
      const id = card.dataset.id;
      const title = card.dataset.title;
      const desc = card.dataset.description;
      const loc = card.dataset.location;
      const status = card.dataset.status;
      const date = card.dataset.date;
      const photo = card.dataset.photo || '';

      currentModalReport = {
        id, title, desc, loc, status, date, photo,
        updateUrl: card.dataset.updateUrl,
        deleteUrl: card.dataset.deleteUrl,
        forwardUrl: card.dataset.forwardUrl
      };

      populateModal(currentModalReport);
      showModal();
    }

    function populateModal(data) {
      document.getElementById('modalReportTitle').textContent = data.title;
      document.getElementById('modalReportDesc').textContent = data.desc;
      document.getElementById('modalReportLoc').textContent = data.loc;
      const statusEl = document.getElementById('modalReportStatus');
      statusEl.textContent = data.status;
      // color
      statusEl.className = 'mt-1 px-3 py-1 rounded-full text-sm font-semibold ' + (
        data.status === 'Resolved' ? 'bg-green-500 text-white' :
        data.status === 'Rejected' ? 'bg-red-500 text-white' :
        data.status === 'Ongoing' ? 'bg-sky-500 text-white' : 'bg-yellow-400 text-black'
      );

      document.getElementById('modalReportDate').textContent = data.date;

      const img = document.getElementById('modalReportPhoto');
      const noPhoto = document.getElementById('noPhotoText');
      if (data.photo && data.photo.trim() !== '') {
        img.src = data.photo;
        img.classList.remove('hidden');
        noPhoto.classList.add('hidden');
      } else {
        img.classList.add('hidden');
        noPhoto.classList.remove('hidden');
      }
    }

    function showModal() {
      const modal = document.getElementById('reportModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      lucide.createIcons();
    }

    function closeModal() {
      const modal = document.getElementById('reportModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      currentModalReport = null;
    }

    // Forward report via SweetAlert + fetch
    async function forwardReport(reportId, office, forwardUrl) {
      const result = await Swal.fire({
        title: `Forward report #${reportId}?`,
        text: `Send this report to ${office}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, forward',
      });
      if (!result.isConfirmed) return;

      Swal.fire({ title: 'Forwarding...', allowOutsideClick: false, didOpen: ()=>Swal.showLoading() });

      try {
        const res = await fetch(forwardUrl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
          body: JSON.stringify({ report_id: reportId, forwarded_to: office })
        });
        const data = await res.json();
        Swal.close();
        if (res.ok && data.success) {
          Swal.fire({ icon: 'success', title: 'Forwarded', text: data.message || `Report forwarded to ${office}`, timer: 1700, showConfirmButton: false });
          // update any UI badge if present (we use simple approach: update modal text)
          if (currentModalReport && currentModalReport.id == reportId) {
            currentModalReport.status = `Forwarded to ${office}`;
            populateModal(currentModalReport);
          }
        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Forward failed' });
        }
      } catch (err) {
        Swal.close();
        Swal.fire({ icon: 'error', title: 'Request failed', text: err.message || 'Try again' });
      }
    }

    // Toggle simple forward menu
    function toggleForwardMenu(e, id) {
      e.stopPropagation();
      document.querySelectorAll('[id^="forward-menu-"]').forEach(el => el.classList.add('hidden'));
      const menu = document.getElementById(`forward-menu-${id}`);
      if (menu) menu.classList.toggle('hidden');
      window.addEventListener('click', () => { if(menu) menu.classList.add('hidden') }, { once: true });
    }

    // Update status with confirmation
    async function updateStatusConfirm(reportId, status, updateUrl) {
      const r = await Swal.fire({
        title: `Change status to ${status}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, change'
      });
      if (!r.isConfirmed) return;

      // send request (use POST with _method=PUT)
      try {
        const res = await fetch(updateUrl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
          body: JSON.stringify({ _method: 'PUT', status })
        });
        const data = await res.json();
        if (res.ok) {
          Swal.fire({ icon: 'success', title: 'Updated', text: data.message || 'Status changed', timer: 1500, showConfirmButton: false });
          // reflect in modal if open
          if (currentModalReport && currentModalReport.id == reportId) {
            currentModalReport.status = status;
            populateModal(currentModalReport);
          }
          // optionally reload small portion or page to show badge changes
          setTimeout(()=>location.reload(), 800);
        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Update failed' });
        }
      } catch (err) {
        Swal.fire({ icon: 'error', title: 'Request failed', text: err.message || 'Try again' });
      }
    }

    // Modal buttons call this with current report
    function updateStatusConfirmFromModal(status) {
      if (!currentModalReport) return;
      updateStatusConfirm(currentModalReport.id, status, currentModalReport.updateUrl);
    }

    // Delete report with confirmation
    async function deleteReportConfirm(reportId, deleteUrl) {
      const r = await Swal.fire({ title: `Delete report #${reportId}?`, text: 'This action cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Delete' });
      if (!r.isConfirmed) return;

      try {
        const res = await fetch(deleteUrl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
          body: JSON.stringify({ _method: 'DELETE' })
        });
        const data = await res.json();
        if (res.ok) {
          Swal.fire({ icon: 'success', title: 'Deleted', text: data.message || 'Report removed', timer: 1400, showConfirmButton: false });
          setTimeout(()=>location.reload(), 700);
        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Delete failed' });
        }
      } catch (err) {
        Swal.fire({ icon: 'error', title: 'Request failed', text: err.message || 'Try again' });
      }
    }

    // Print: builds a printable HTML from current modal fields
    function printReport() {
      if (!currentModalReport) return Swal.fire({ icon: 'info', title: 'No report selected' });
      const r = currentModalReport;
      const content = `
        <div style="font-family:Segoe UI, Arial; padding:20px; color:#0f172a;">
          <div style="display:flex; gap:20px; align-items:center; margin-bottom:20px;">
            <img src="${'{{ asset("images/santafe.png") }}'}" style="height:80px;">
            <div>
              <h1 style="margin:0; font-size:20px;">Municipality of Santa Fe</h1>
              <div style="color:#475569;">Incident Report Summary</div>
            </div>
          </div>
          <hr style="border:none; border-top:1px solid #ccc; margin-bottom:20px;">
          <p><strong>Name:</strong> ${document.getElementById('modalReportName') ? document.getElementById('modalReportName').textContent : 'Anonymous'}</p>
          <p><strong>Email:</strong> ${document.getElementById('modalReportEmail') ? document.getElementById('modalReportEmail').textContent : 'No Email'}</p>
          <p><strong>Title:</strong> ${escapeHtml(r.title)}</p>
          <p><strong>Description:</strong><br>${escapeHtml(r.desc)}</p>
          <p><strong>Location:</strong> ${escapeHtml(r.loc)}</p>
          <p><strong>Status:</strong> ${escapeHtml(r.status)}</p>
          <p><strong>Submitted:</strong> ${escapeHtml(r.date)}</p>
        </div>
      `;
      const w = window.open('', '_blank', 'width=900,height=700');
      w.document.write(content);
      w.document.close();
      w.focus();
      w.print();
      // don't auto-close to let user confirm printing
    }

    // small escape helper for print
    function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    // small helper to keep forward menus closed when clicking outside
    document.addEventListener('click', (e) => {
      document.querySelectorAll('[id^="forward-menu-"]').forEach(m => {
        if (!m.contains(e.target)) m.classList.add('hidden');
      });
    });

  </script>
</body>
</html>
