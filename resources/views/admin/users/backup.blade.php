<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recycle Bin – Deleted Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to bottom right, #f8fafc, #eef2f7);
    }
    .fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .glass {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.9);
    }
    @media (max-width: 640px) {
      .header-title { font-size: 1.5rem; }
      .card { padding: 1rem; }
    }
  </style>
</head>

<body class="min-h-screen flex flex-col items-center py-6 px-3 sm:px-6">

  <!-- Main Container -->
  <div class="w-full max-w-6xl glass rounded-3xl shadow-xl p-6 sm:p-8 fade-in border border-gray-200">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
      <div>
        <h1 class="header-title text-2xl sm:text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i data-lucide="trash-2" class="w-6 h-6 sm:w-7 sm:h-7 text-red-600"></i> Recycle Bin
        </h1>
        <p class="text-sm text-gray-500 mt-1">
          Deleted users are temporarily stored here. Review details anytime.
        </p>
      </div>

      <a href="{{ route('admin.users.index') }}"
         class="flex items-center justify-center gap-2 w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl font-medium shadow-md transition-all text-center">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
      </a>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 bg-gray-50 border border-gray-200 rounded-xl p-4">
      <div class="flex items-center gap-2 text-gray-700 text-sm">
        <i data-lucide="info" class="w-4 h-4"></i>
        <span>Archived users are hidden from the active list.</span>
      </div>

      <!-- ✅ Fixed Form with DELETE method -->
      <form method="POST" action="{{ route('admin.users.emptyBin') }}">
        @csrf
        @method('DELETE')
        
      </form>
    </div>

    <!-- Empty State -->
    @if (!isset($trashData) || count($trashData) === 0)
      <div class="text-center py-16 sm:py-20">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png"
             alt="Empty Bin" class="mx-auto w-20 sm:w-28 mb-5 opacity-90">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-700">Recycle Bin is Empty</h2>
        <p class="text-gray-500 text-sm mt-2">No deleted users found in your backup data.</p>
      </div>
    @else
      <!-- Users Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @foreach ($trashData as $user)
          <div class="card group bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 sm:p-6 relative overflow-hidden">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 bg-gradient-to-r from-blue-500 to-purple-500 transition"></div>

            <!-- Avatar and Info -->
            <div class="flex items-center gap-3 mb-4">
              <div class="bg-gradient-to-br from-gray-200 to-gray-300 rounded-full w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center text-gray-700 font-bold text-lg shadow-inner">
                {{ strtoupper(substr($user['name'] ?? '?', 0, 1)) }}
              </div>
              <div class="truncate">
                <h3 class="font-semibold text-gray-900 text-base sm:text-lg truncate">{{ $user['name'] ?? '—' }}</h3>
                <p class="text-sm text-gray-500 truncate">{{ $user['email'] ?? '—' }}</p>
              </div>
            </div>

            <!-- Details -->
            <div class="text-sm text-gray-700 space-y-1.5">
              <p><span class="font-medium">📍 Location:</span> {{ $user['location'] ?? '—' }}</p>
              <p><span class="font-medium">🧩 Role:</span> {{ $user['role'] ?? '—' }}</p>
              <p><span class="font-medium">🗓 Deleted:</span>
                <span class="text-gray-500">
                  {{ isset($user['deleted_at']) ? \Carbon\Carbon::parse($user['deleted_at'])->format('M d, Y h:i A') : '—' }}
                </span>
              </p>
            </div>

            <!-- Tag -->
            <div class="absolute top-3 right-3 bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1 rounded-full">
              Archived
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  <!-- Footer -->
  <footer class="mt-10 text-xs sm:text-sm text-gray-500 text-center px-4">
    <p>© {{ date('Y') }} BarangayConnect Admin Dashboard — Recycle Bin</p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      if (window.lucide) lucide.createIcons();
    });
  </script>
</body>
</html>
