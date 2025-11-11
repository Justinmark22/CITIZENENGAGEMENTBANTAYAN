<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madridejos Forwarded Announcements & Events</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  body { font-family: 'Inter', sans-serif; background: #f9fafb; }
  .fade-in { animation: fadeIn 0.5s ease-in-out; }
  @keyframes fadeIn { from { opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }
  .badge { display:inline-block; padding:.25rem .5rem; font-size:.75rem; font-weight:600; border-radius:.375rem; }
  .card:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,0.1); }
  th, td { border-bottom: 1px solid #e5e7eb; padding: 0.75rem; text-align: left; }
  th { background: #f3f4f6; font-weight: 600; color: #374151; }
</style>
</head>
<body class="min-h-screen">

<!-- Header -->
<header class="bg-white shadow py-6 px-6 sm:px-10 mb-8">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 flex items-center gap-3">
      <i data-lucide="bell" class="w-8 h-8 text-green-600"></i>
      Madridejos Forwarded Announcements & Events
    </h1>
    <p class="text-gray-500 mt-2 sm:mt-0 text-sm sm:text-base">
      Forwarded Announcements and Events for Madridejos.
    </p>
  </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 fade-in space-y-12">

  <!-- ✅ Forwarded Announcements (Original) -->
  <section>
    <h2 class="text-2xl sm:text-3xl font-semibold mb-6 text-gray-800 border-l-4 border-green-500 pl-3">Forwarded Announcements</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
      @php
        $validAnnouncements = $announcements->filter(function($a){
          return \Carbon\Carbon::parse($a->end_date)->isFuture() || \Carbon\Carbon::parse($a->end_date)->isToday();
        });
      @endphp

      @forelse($validAnnouncements as $announcement)
        <div class="bg-white p-6 rounded-xl shadow-sm card transition-all duration-200">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h3>
            <span class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y h:i A') }}</span>
          </div>
          <p class="text-gray-700 mb-4 line-clamp-3">{{ $announcement->message ?? '-' }}</p>
          <div class="flex flex-wrap gap-2 text-sm">
            <span class="badge bg-blue-100 text-blue-800">{{ $announcement->barangay ?? '-' }}</span>
            <span class="badge bg-green-100 text-green-800">Forwarded by {{ $announcement->forwarded_by ?? '-' }}</span>
            <span class="badge bg-gray-100 text-gray-800">From: {{ \Carbon\Carbon::parse($announcement->start_date)->format('M d, Y') }}</span>
            <span class="badge bg-gray-100 text-gray-800">To: {{ \Carbon\Carbon::parse($announcement->end_date)->format('M d, Y') }}</span>
          </div>
        </div>
      @empty
        <p class="col-span-full text-gray-500 italic text-center">No forwarded announcements found.</p>
      @endforelse
    </div>
  </section>

  <!-- ✅ Forwarded Events (Original) -->
  <section>
    <h2 class="text-2xl sm:text-3xl font-semibold mb-6 text-gray-800 border-l-4 border-purple-500 pl-3">Forwarded Events</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
      @php
        $validEvents = $events->filter(function($e){
          return isset($e->event_date) && (\Carbon\Carbon::parse($e->event_date)->isFuture() || \Carbon\Carbon::parse($e->event_date)->isToday());
        });
      @endphp

      @forelse($validEvents as $event)
        <div class="bg-white p-6 rounded-xl shadow-sm card transition-all duration-200">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
            <span class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($event->created_at)->format('M d, Y h:i A') }}</span>
          </div>
          <p class="text-gray-700 mb-4 line-clamp-3">{{ $event->description ?? '-' }}</p>
          <div class="flex flex-wrap gap-2 text-sm">
            <span class="badge bg-purple-100 text-purple-800">{{ $event->category ?? '-' }}</span>
            <span class="badge bg-blue-100 text-blue-800">{{ $event->barangay ?? '-' }}</span>
            <span class="badge bg-green-100 text-green-800">Forwarded by {{ $event->forwarded_by ?? '-' }}</span>
            <span class="badge bg-gray-100 text-gray-800">
              {{ isset($event->event_date) ? \Carbon\Carbon::parse($event->event_date)->format('M d, Y') : '-' }}
              {{ $event->event_time ?? '' }}
            </span>
          </div>
        </div>
      @empty
        <p class="col-span-full text-gray-500 italic text-center">No forwarded events found.</p>
      @endforelse
    </div>
  </section>
<!-- 🌟 Clean & Polished Announcement Details (Non-Modal Version) -->
<section class="announcement-details my-5">
  <div class="container">
    <div class="shadow-xl border-0 rounded-4 overflow-hidden"
         style="backdrop-filter: blur(18px); background: rgba(255,255,255,0.96); transition: all 0.4s ease;">

      <!-- 🔹 Header -->
      <div class="text-white py-3 px-4 d-flex justify-content-between align-items-center"
           style="background: linear-gradient(135deg, #f59e0b, #facc15); border-bottom: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h4 class="d-flex align-items-center gap-2 fw-bold mb-0">
          <i data-lucide="megaphone" class="me-1"></i> Announcement Details
        </h4>
        <small class="text-sm opacity-90">
          <i data-lucide="calendar" class="me-1"></i>
          <span id="announcementDate">Nov 10, 2025</span>
        </small>
      </div>

      <!-- 🔹 Body -->
      <div class="px-5 py-4">
        <div class="row g-4 align-items-start">

          <!-- 📌 Left Column -->
          <div class="col-md-7">
            <div class="mb-3">
              <label class="text-muted small">Title</label>
              <div id="announcementTitle" class="fw-semibold fs-5 text-dark">
                Barangay Coastal Clean-Up Drive
              </div>
            </div>

            <div class="mb-3">
              <label class="text-muted small">Category</label>
              <div id="announcementCategory" class="fs-6 text-dark">Environment</div>
            </div>

            <div class="mb-3">
              <label class="text-muted small">Location</label>
              <div id="announcementLocation" class="fs-6 text-dark">Madridejos</div>
            </div>

            <div class="mb-3">
              <label class="text-muted small">Description</label>
              <div id="announcementDescription" class="bg-light p-3 rounded-3 shadow-sm fs-6 text-dark">
                Join us for our annual coastal clean-up event! Let's work together to protect our beaches and marine life.
              </div>
            </div>
          </div>

          <!-- 📌 Right Column -->
          <div class="col-md-5">
            <label class="text-muted small">Photo</label>
            <div class="bg-light p-3 rounded-3 shadow-sm text-center position-relative">
              <img id="announcementPhoto" src="{{ asset('storage/uploads/cleanup.jpg') }}" alt="Announcement Photo"
                   class="img-fluid rounded-3 shadow-sm border"
                   style="max-height: 280px; object-fit: cover; border-color: #ccc;">
            </div>
          </div>

        </div>
      </div>

      <!-- 🔹 Footer -->
      <div class="bg-light border-top rounded-bottom px-4 py-3 d-flex justify-content-between align-items-center">
        <small class="text-muted d-flex align-items-center gap-2">
          <i data-lucide="map-pin"></i> Madridejos
        </small>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary hover-scale">
          <i data-lucide="arrow-left" class="me-1"></i> Back
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ✨ Animations and Effects -->
<style>
  .hover-scale {
    transition: transform 0.2s ease-in-out;
  }
  .hover-scale:hover {
    transform: scale(1.05);
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => lucide.createIcons());
</script>

</main>

<footer class="text-center text-sm text-gray-500 py-6 bg-white shadow-inner mt-12">
  &copy; {{ date('Y') }} bantayan911
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  if (window.lucide) lucide.createIcons();
});
</script>
</body>
</html>
