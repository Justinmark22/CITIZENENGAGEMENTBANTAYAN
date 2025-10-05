{{-- resources/views/dashboard/mdrrmo-santafe.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MDRRMO Bantayan Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/lucide@latest"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
      colors: {
        mdrrmo: {
          blue: '#1e3a8a',
          red: '#dc2626',
          green: '#16a34a',
          amber: '#f59e0b',
          gray: '#4b5563',
          light: '#f3f4f6'
        }
      },
      backgroundImage: {
        'page-gradient': 'linear-gradient(to right, #e0e7ff, #f3f4f6)',
        'card-texture': 'repeating-linear-gradient(45deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 8px)'
      }
    }
  }
}
</script>
</head>
<body class="bg-page-gradient font-sans h-screen flex overflow-hidden text-gray-800" x-data="{ mobileMenu:false }">

<aside class="fixed md:static inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-200 to-blue-100 text-gray-800 p-6 transform transition-transform duration-300 z-40 shadow-lg"
       :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

 <div class="flex items-center justify-between mb-10">
  <!-- Larger Circular Logo -->
<img src="{{ asset('/images/mad.png') }}" alt="MDRRMO Logo" class="h-16 w-16 rounded-full object-cover">
    <span class="text-2xl font-extrabold tracking-wide drop-shadow-sm">MDRRMO BANTAYAN</span>
  </div>
  <button class="md:hidden text-2xl font-bold" @click="mobileMenu=false">✕</button>
</div>
  <nav class="flex flex-col gap-4">
    <!-- Dashboard -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Dashboard</p>
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-300 hover:bg-blue-200 transition-all">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span class="font-medium">Overview</span>
      </a>
    </div>

    <!-- Reports -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Reports</p>
      <a href="{{ route('mdrrmo.reports-bantayan') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="file-text" class="w-5 h-5"></i>
        <span>All Reports</span>
      </a>
    </div>

    <!-- Communications -->
    <div>
      <p class="uppercase text-xs font-semibold text-gray-500 px-4 mb-2">Communications</p>
      <a href="{{ route('mdrrmo.mdrrmo_bantayan-announcements') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-200 transition-all">
        <i data-lucide="megaphone" class="w-5 h-5"></i>
        <span>Announcements</span>
      </a>
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
      @csrf
      <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-400 hover:bg-red-500 font-semibold shadow transition-all">
        Logout
      </button>
    </form>
</aside>


<!-- Main -->
<main class="flex-1 flex flex-col overflow-y-auto">

  <!-- Topbar -->
  <header class="sticky top-0 z-20 bg-white shadow-md border-b border-gray-200">
    <div class="flex justify-between items-center px-6 py-4">
      <h2 class="text-2xl font-bold text-gray-800">MDRRMO Dashboard</h2>
      <button class="md:hidden px-3 py-2 rounded-lg bg-gray-900 text-white" @click="mobileMenu = true">☰</button>
    </div>
  </header>

  <section class="px-6 py-8 space-y-8">

   <!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6">
  @foreach([
    ['label'=>'Total Reports','value'=>$totalReports,'color'=>'mdrrmo.blue','icon'=>'bar-chart-2'],
    ['label'=>'Pending','value'=>$pendingReportsCount,'color'=>'mdrrmo.amber','icon'=>'clock'],
    ['label'=>'Ongoing','value'=>$ongoingReportsCount,'color'=>'mdrrmo.gray','icon'=>'refresh-cw'],
    ['label'=>'Resolved','value'=>$resolvedReportsCount,'color'=>'mdrrmo.green','icon'=>'check-circle'],
    ['label'=>'Users','value'=>$totalUsers,'color'=>'mdrrmo.blue','icon'=>'users'],
  ] as $s)
  <div class="relative bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-xl border-l-4 border-{{ $s['color'] }} p-5 hover:shadow-2xl transition-transform transform hover:-translate-y-1 hover:scale-105 bg-card-texture">
    
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-semibold text-gray-500">{{ $s['label'] }}</p>
        <p class="mt-2 text-3xl font-bold {{ $s['color'] }}" 
           x-data="{ count:0 }" 
           x-init="let i=0; const interval=setInterval(()=>{ if(i<={{ $s['value'] }}) { count=i++; } else clearInterval(interval); },20)">
          <span x-text="count"></span>
        </p>
      </div>
      <div class="w-12 h-12 flex items-center justify-center rounded-full bg-{{ $s['color'] }}/10">
        <i data-lucide="{{ $s['icon'] }}" class="w-6 h-6 text-{{ $s['color'] }}"></i>
      </div>
    </div>

    <div class="mt-4 h-2 bg-gray-200 rounded-full overflow-hidden">
      <div class="h-2 rounded-full bg-gradient-to-r from-{{ $s['color'] }}-400 to-{{ $s['color'] }}-600 transition-all duration-500"
           :style="'width:' + ({{ $s['value'] }} > 100 ? 100 : {{ $s['value'] }}) + '%'">
      </div>
    </div>

  </div>
  @endforeach
</div>


   <!-- Recent Reports Table -->
<div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
  <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-gray-50">
    <h3 class="font-bold text-gray-800 text-lg">Recent Reports</h3>
    <a href="{{ route('mdrrmo.reports-bantayan') }}" class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700 transition text-sm">View All</a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full min-w-[650px] text-left text-sm">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Reported At</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Details</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($reports as $r)
        <tr class="hover:bg-gray-50 transition-all">
          <td class="px-4 py-3 font-medium">#{{ $r->id }}</td>
          <td class="px-4 py-3">{{ $r->created_at->format('M d, Y') }}</td>
          <td class="px-4 py-3">
            @php
              $badge = match($r->status) {
                'Resolved' => 'bg-green-100 text-green-700',
                'Ongoing' => 'bg-gray-100 text-gray-700',
                'Pending' => 'bg-amber-100 text-amber-700',
                default => 'bg-gray-100 text-gray-700'
              };
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $r->status }}</span>
          </td>
          <td class="px-4 py-3">
            <p class="text-gray-700 text-sm truncate" title="{{ $r->description ?? 'No details available' }}">
              {{ $r->description ?? 'No details available' }}
            </p>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center py-6 text-gray-500 font-medium">No reports yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


    <!-- Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
      @foreach([
        ['id'=>'announcements','title'=>'Announcements','items'=>$announcements ?? []],
        ['id'=>'alerts','title'=>'Emergency Alerts','items'=>$alerts ?? []],
        ['id'=>'events','title'=>'Upcoming Events','items'=>$events ?? []],
        ['id'=>'feedback','title'=>'Citizen Feedback','items'=>$feedback ?? []],
      ] as $widget)
      <div id="{{ $widget['id'] }}" class="bg-white shadow-xl rounded-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all">
        <div class="p-4 border-b border-gray-200 bg-gray-50 font-bold text-gray-800 flex items-center justify-between">
          <span>{{ $widget['title'] }}</span>
          <i data-lucide="pin" class="w-4 h-4 text-gray-400"></i>
        </div>
        <ul class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
          @forelse($widget['items'] as $item)
          <li class="p-4 hover:bg-gray-50 cursor-pointer transition-all">
            @if($widget['id']==='feedback')
              <p class="text-gray-700 font-medium">"{{ $item->message }}"</p>
              <p class="text-xs text-gray-500 mt-1">— {{ $item->user->name ?? 'Anonymous' }}</p>
            @elseif($widget['id']==='alerts')
              <p class="font-semibold text-red-600">🚨 {{ $item->message }}</p>
            @else
              <p class="font-medium">{{ $item->title }}</p>
              <p class="text-xs text-gray-500">{{ optional($item->when ?? $item->date)->format('M d, Y') }}</p>
            @endif
          </li>
          @empty
          <li class="p-4 text-gray-500 text-sm font-medium">No {{ strtolower($widget['title']) }}.</li>
          @endforelse
        </ul>
      </div>
      @endforeach
    </div>

  </section>
</main>
</body>
</html>
