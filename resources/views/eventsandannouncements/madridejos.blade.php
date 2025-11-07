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
</style>
</head>
<body class="min-h-screen">

<!-- Header -->
<header class="bg-white shadow py-6 px-6 sm:px-10 mb-8">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 flex items-center gap-3">
      <i data-lucide="bell" class="w-8 h-8 text-green-600"></i>
    
    </h1>
    <p class="text-gray-500 mt-2 sm:mt-0 text-sm sm:text-base">
      Forwarded Announcements and Events for Madridejos .
    </p>
  </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 fade-in space-y-12">

  <!-- Forwarded Announcements -->
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

  <!-- Forwarded Events -->
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

</main>

<footer class="text-center text-sm text-gray-500 py-6 bg-white shadow-inner mt-12">
  &copy; {{ date('Y') }} bantayan911 — Madridejos Forwarded Announcements & Events
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  if (window.lucide) lucide.createIcons();
});
</script>
</body>
</html>
