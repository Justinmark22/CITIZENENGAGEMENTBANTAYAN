<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Submit Feedback</title>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gradient-to-r from-green-50 to-lime-50 text-gray-800 font-sans min-h-screen">

<!-- Navigation -->
<nav class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm px-4 md:px-6 py-3 sticky top-0 z-50" x-data="{ open: false, userOpen: false }">
  <div class="flex items-center justify-between">
    <!-- Logo -->
    <a href="#" class="flex items-center gap-3">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-200 shadow-sm">
      <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">submit feedback</span>
    </a>

    <!-- Hamburger (Mobile) -->
    <button @click="open = !open" class="md:hidden flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition">
      <i class="bi bi-list text-xl text-gray-800"></i>
    </button>

    <!-- Desktop Links -->
    <div class="hidden md:flex items-center gap-4 md:gap-5">
      <a href="{{ route('feedback.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
        <i data-lucide="message-square" class="w-4 h-4"></i> <span class="hidden md:inline">Feedback</span>
      </a>

      <a href="{{ route('contact.support.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
        <i data-lucide="life-buoy" class="w-4 h-4"></i> <span class="hidden md:inline">Support</span>
      </a>


      <!-- User Dropdown -->
      <div class="relative" @click.away="userOpen = false">
        <button @click="userOpen = !userOpen" class="flex items-center justify-between md:justify-start gap-2 text-gray-700 hover:text-green-700 transition">
          <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
            <i data-lucide="user" class="w-4 h-4"></i>
          </div>
          <span class="md:inline hidden font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
          <i data-lucide="chevron-down" class="w-4 h-4"></i>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="userOpen" x-transition class="absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-64 overflow-hidden border border-gray-100 z-50" x-cloak>
          <div class="px-5 py-4 bg-gray-50">
            <p class="font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
            <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? 'No Email' }}</p>
            <p class="text-gray-400 text-sm">{{ Auth::user()->location ?? 'No Location' }}</p>
          </div>
          <button onclick="confirmLogout(event)" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition">
            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
          </button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" @click.outside="open = false" class="md:hidden mt-2 space-y-2 px-2" x-cloak>
    <a href="{{ route('feedback.page') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-green-100 transition">Feedback</a>
    <a href="{{ route('contact.support.page') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-green-100 transition">Support</a>
   
    <!-- Mobile User Dropdown -->
    <div x-data="{ mobileUserOpen: false }" class="space-y-1">
      <button @click="mobileUserOpen = !mobileUserOpen" class="w-full text-left px-4 py-2 rounded-lg bg-green-50 hover:bg-green-100 transition">
        User Options
      </button>
      <div x-show="mobileUserOpen" x-transition class="space-y-1 px-2" x-cloak>
        <p class="font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
        <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? 'No Email' }}</p>
        <p class="text-gray-400 text-sm">{{ Auth::user()->location ?? 'No Location' }}</p>
        <button onclick="confirmLogout(event)" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Logout</button>
      </div>
    </div>
  </div>
</nav>
<script>
  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Are you sure?',
      text: "You will be logged out.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#16a34a', // green
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, logout!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }
</script>


<!-- 🌟 Hero Section -->
<section class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-r from-green-50 to-lime-50">
  <!-- Background blobs -->
  <div class="absolute top-0 left-0 w-40 md:w-56 h-40 md:h-56 bg-green-200 rounded-full opacity-30 blur-2xl -z-10"></div>
  <div class="absolute top-0 right-0 w-60 md:w-80 h-60 md:h-80 bg-lime-200 rounded-full opacity-30 blur-2xl -z-10"></div>

  <div class="px-6 md:px-8 flex flex-col lg:flex-row gap-10 items-start">
    <!-- Left Column: Hero Text -->
    <div class="lg:w-1/2 max-w-xl flex flex-col justify-center">
  <h1 class="text-3xl md:text-5xl font-extrabold mb-1 md:mb-2 leading-tight text-gray-900">
    Welcome, <span class="text-green-700">{{ Auth::user()->name ?? 'Guest' }}</span>
</h1>
<p class="text-gray-600 text-sm md:text-base mb-4">
    {{ Auth::user()->email ?? 'No Email' }}
</p>

  <h2 class="text-xl md:text-2xl font-semibold mb-4 text-gray-700">Your Feedback Matters</h2>
  <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
    We invite you to share your valuable insights and experiences.  
    Your thoughtful feedback helps us enhance our services and cultivate a more rewarding and seamless experience for the entire community.
  </p>



    </div>
<!-- Feedback Form -->
<div class="container mx-auto py-8 px-4 sm:px-6">
  <div class="max-w-lg mx-auto">
    <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-3xl p-5 sm:p-6 shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-500 overflow-hidden animate__animated animate__fadeInUp">
      <div class="absolute inset-0 bg-green-200/10 rounded-3xl -z-10"></div>
      <div class="text-green-800 text-center py-4 sm:py-6 px-2 sm:px-4">
        <h2 class="text-xl sm:text-2xl font-bold">Submit Your Feedback</h2>
      </div>
      <div class="space-y-4">
        <form action="{{ route('feedback.submit') }}" method="POST">
          @csrf
          <div>
            <label for="location" class="block text-green-800 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">Location</label>
            <input type="text" id="location" name="location" value="{{ Auth::user()->location ?? 'No Location' }}" readonly
                   class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm sm:text-base" />
          </div>
          <div>
            <label for="feedback" class="block text-green-800 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">Your Feedback</label>
            <textarea id="feedback" name="feedback" rows="4" placeholder="Write your feedback here..."
                      class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm sm:text-base" required></textarea>
          </div>
          <div>
            <label for="rating" class="block text-green-800 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">Rating</label>
            <select id="rating" name="rating" required
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm sm:text-base">
              <option value="" disabled selected>Choose a rating</option>
              <option value="1">1 - Poor</option>
              <option value="2">2 - Fair</option>
              <option value="3">3 - Good</option>
              <option value="4">4 - Very Good</option>
              <option value="5">5 - Excellent</option>
            </select>
          </div>
          <button type="submit"
                  class="w-full py-2.5 sm:py-3 rounded-2xl bg-green-600 text-white font-semibold text-base sm:text-lg hover:bg-green-700 transition animate__animated animate__pulse animate__delay-1s">
            Submit Feedback
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Feedback Submitted!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
  });
</script>
@endif

</body>
</html>
