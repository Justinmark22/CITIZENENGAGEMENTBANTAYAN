{{-- resources/views/dashboard/mdrrmo-santafe.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MDRRMO Santa Fe Dashboard</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ["Inter", "ui-sans-serif"] },
          colors: {
            brand: {
              50: "#eef2ff", 100: "#e0e7ff", 200: "#c7d2fe", 300: "#a5b4fc",
              400: "#818cf8", 500: "#6366f1", 600: "#4f46e5",
              700: "#4338ca", 800: "#3730a3", 900: "#312e81",
            }
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- Alpine -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 9999px; }
    html { scroll-behavior: smooth; }
  </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex flex-col" x-data="{ mobileMenu: false }">
  <div class="flex flex-1 min-h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside 
      class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white p-6 transform transition-transform duration-300 ease-in-out"
      :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
      
      <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2">
          <i data-lucide="shield" class="w-7 h-7 text-brand-400"></i>
          <h1 class="text-xl font-bold tracking-wide">MDRRMO Santa Fe</h1>
        </div>
        <button class="md:hidden" @click="mobileMenu=false">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>

      <nav class="flex-1 space-y-2">
        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="home" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('mdrrmo.reports-santafe') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="file-warning" class="w-5 h-5 text-amber-400"></i> Reports
        </a>
        <a href="#announcements" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="megaphone" class="w-5 h-5 text-blue-400"></i> Announcements
        </a>
        <a href="#events" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="calendar" class="w-5 h-5 text-green-400"></i> Events
        </a>
        <a href="#alerts" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="bell" class="w-5 h-5 text-rose-400"></i> Emergency Alerts
        </a>
        <a href="#feedback" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition">
          <i data-lucide="message-square" class="w-5 h-5 text-cyan-400"></i> Feedback
        </a>
      </nav>

      <form method="POST" action="{{ route('logout') }}" class="mt-6">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 transition font-medium">
          <i data-lucide="log-out" class="w-5 h-5"></i> Logout
        </button>
      </form>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col overflow-y-auto">
      <!-- Topbar -->
      <header class="sticky top-0 z-10 bg-white/90 backdrop-blur-lg border-b border-gray-200">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
          <h2 class="text-lg sm:text-xl font-semibold tracking-wide text-gray-800">📊 Santa Fe MDRRMO Dashboard</h2>
          <div class="flex items-center gap-3">
            <span class="hidden sm:inline text-sm text-gray-600">👤 Officer</span>
            <button class="md:hidden inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white" @click="mobileMenu = true">
              <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
          </div>
        </div>
      </header>

      <!-- Content -->
      <section class="w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
          @php
            $stats = [
              ['label'=>'Total Reports','value'=>$totalReports,'color'=>'text-brand-600','icon'=>'file-warning'],
              ['label'=>'Pending','value'=>$pendingReportsCount,'color'=>'text-amber-500','icon'=>'loader'],
              ['label'=>'Ongoing','value'=>$ongoingReportsCount,'color'=>'text-indigo-500','icon'=>'activity'],
              ['label'=>'Resolved','value'=>$resolvedReportsCount,'color'=>'text-emerald-600','icon'=>'check-circle'],
              ['label'=>'Users','value'=>$totalUsers,'color'=>'text-blue-600','icon'=>'users'],
            ];
          @endphp

          @foreach($stats as $s)
          <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow hover:shadow-xl transition transform hover:scale-105">
            <div class="flex items-center justify-between">
              <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
              <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['color'] }}"></i>
            </div>
            <p class="mt-3 text-3xl font-bold {{ $s['color'] }}">{{ $s['value'] }}</p>
          </div>
          @endforeach
        </div>

        <!-- Reports -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-md overflow-hidden">
          <div class="flex items-center justify-between p-5 border-b border-gray-200">
              <h3 class="text-base font-semibold">📋 Recent Reports</h3>
              <a href="{{ route('mdrrmo.reports-santafe') }}" class="text-sm px-4 py-2 rounded-lg bg-brand-600 text-white hover:bg-brand-700 transition">View All</a>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
              <thead class="bg-gray-50 text-gray-600">
                <tr>
                  <th class="px-5 py-3">ID</th>
                  <th class="px-5 py-3">Type</th>
                  <th class="px-5 py-3">Status</th>
                  <th class="px-5 py-3">Reported At</th>
                  <th class="px-5 py-3">Actions</th>
                </tr>
              </thead>
<tbody class="divide-y divide-gray-100">
  @forelse($reports as $r)
  <tr id="report-row-{{ $r->id }}" class="hover:bg-gray-50 transition">
    <td class="px-5 py-3 font-medium">#{{ $r->id }}</td>
    <td class="px-5 py-3">{{ $r->type }}</td>
    <td class="px-5 py-3">
      @php $badge = $r->status === 'Resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'; @endphp
      <span class="text-xs px-2 py-1 rounded-full {{ $badge }}">{{ $r->status }}</span>
    </td>
    <td class="px-5 py-3">{{ $r->created_at->format('M d, Y') }}</td>
    <td class="px-5 py-3 space-x-2">
      @if($r->status !== 'Resolved')
        <button class="text-xs px-3 py-1 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Resolve</button>
        <button class="text-xs px-3 py-1 rounded-lg bg-rose-600 text-white hover:bg-rose-700">Delete</button>
      @else
        <span class="text-xs px-3 py-1 rounded-lg bg-gray-200 text-gray-600">Resolved</span>
      @endif
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="5" class="text-center py-4 text-gray-500">No forwarded reports yet.</td>
  </tr>
  @endforelse
</tbody>

            </table>
          </div>
        </div>

        <!-- Announcements, Alerts, Events, Feedback -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
          
          <!-- Announcements -->
          <div id="announcements" class="rounded-2xl border border-gray-200 bg-white shadow-md">
            <div class="p-5 border-b border-gray-200 flex items-center gap-2">
              <i data-lucide="megaphone" class="w-5 h-5 text-blue-500"></i>
              <h3 class="text-base font-semibold">Announcements</h3>
            </div>
            <ul class="divide-y divide-gray-100">
              @foreach($announcements ?? [] as $a)
              <li class="p-5 hover:bg-gray-50 transition">
                <p class="font-medium">{{ $a->title }}</p>
                <p class="text-sm text-gray-500">{{ optional($a->when)->format('M d, Y') }}</p>
              </li>
              @endforeach
            </ul>
          </div>

          <!-- Alerts -->
          <div id="alerts" class="rounded-2xl border border-gray-200 bg-white shadow-md">
            <div class="p-5 border-b border-gray-200 flex items-center gap-2">
              <i data-lucide="bell" class="w-5 h-5 text-rose-500"></i>
              <h3 class="text-base font-semibold">Emergency Alerts</h3>
            </div>
            <ul class="divide-y divide-gray-100">
              @foreach($alerts ?? [] as $al)
              <li class="p-5 bg-rose-50 border-l-4 border-rose-500">🚨 {{ $al->message }}</li>
              @endforeach
            </ul>
          </div>

          <!-- Events -->
          <div id="events" class="rounded-2xl border border-gray-200 bg-white shadow-md">
            <div class="p-5 border-b border-gray-200 flex items-center gap-2">
              <i data-lucide="calendar" class="w-5 h-5 text-green-500"></i>
              <h3 class="text-base font-semibold">Upcoming Events</h3>
            </div>
            <ul class="divide-y divide-gray-100">
              @foreach($events ?? [] as $e)
              <li class="p-5 hover:bg-gray-50 transition">
                <p class="font-medium">{{ $e->title }}</p>
                <p class="text-sm text-gray-500">📅 {{ $e->date->format('M d, Y') }}</p>
              </li>
              @endforeach
            </ul>
          </div>

          <!-- Feedback -->
          <div id="feedback" class="rounded-2xl border border-gray-200 bg-white shadow-md">
            <div class="p-5 border-b border-gray-200 flex items-center gap-2">
              <i data-lucide="message-square" class="w-5 h-5 text-cyan-500"></i>
              <h3 class="text-base font-semibold">Citizen Feedback</h3>
            </div>
            <ul class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
              @foreach($feedback ?? [] as $f)
              <li class="p-5 hover:bg-gray-50 transition">
                <p class="text-gray-700">"{{ $f->message }}"</p>
                <p class="text-xs text-gray-500 mt-1">— {{ $f->user->name ?? 'Anonymous' }}</p>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
