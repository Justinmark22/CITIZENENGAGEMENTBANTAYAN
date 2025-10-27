<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Support</title>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gradient-to-r from-green-50 to-lime-50 min-h-screen font-sans text-gray-800">

<!-- Navbar -->
<nav class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm px-4 md:px-6 py-3 sticky top-0 z-50" x-data="{ open: false, userOpen: false }">
  <div class="flex items-center justify-between">
    <!-- Logo -->
    <a href="#" class="flex items-center gap-3">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-200 shadow-sm">
      <span class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">Contact Support</span>
    </a>

    <!-- Hamburger (Mobile) -->
    <button @click="open = !open" class="md:hidden flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition">
      <i class="bi bi-list text-xl text-gray-800"></i>
    </button>

    <!-- Desktop Links -->
    <div class="hidden md:flex items-center gap-4 md:gap-5">
      <a href="{{ route('feedback.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
        <i data-lucide="message-square" class="w-4 h-4"></i> Feedback
      </a>
      <a href="{{ route('contact.support.page') }}" class="flex items-center gap-1 text-gray-700 hover:text-green-700 transition">
        <i data-lucide="life-buoy" class="w-4 h-4"></i> Support
      </a>
     

      <!-- User Dropdown -->
      <div class="relative" @click.away="userOpen = false">
        <button @click="userOpen = !userOpen" class="flex items-center gap-2 text-gray-700 hover:text-green-700 transition">
          <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shadow-inner">
            <i data-lucide="user" class="w-4 h-4"></i>
          </div>
          <span class="hidden md:inline font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
          <i data-lucide="chevron-down" class="w-4 h-4"></i>
        </button>
        <div x-show="userOpen" x-transition class="absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-64 overflow-hidden border border-gray-100 z-50" x-cloak>
          <div class="px-5 py-4 bg-gray-50">
            <p class="font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
            <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? 'No Email' }}</p>
            <p class="text-gray-400 text-sm">{{ Auth::user()->location ?? 'No Location' }}</p>
          </div>
          <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition">
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
    <button onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Logout</button>
    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
  </div>
</div>

  </div>
</nav>
<!-- 🌟 Hero + Support Section -->
<section class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-r from-green-50 to-lime-50">
  <!-- Background Blobs -->
  <div class="absolute top-0 left-0 w-40 md:w-56 h-40 md:h-56 bg-green-200 rounded-full opacity-30 blur-2xl -z-10"></div>
  <div class="absolute bottom-0 right-0 w-60 md:w-80 h-60 md:h-80 bg-lime-200 rounded-full opacity-30 blur-2xl -z-10"></div>

  <div class="px-6 md:px-10 flex flex-col lg:flex-row items-center justify-between gap-10 max-w-7xl mx-auto">
    
   <!-- 🟩 Left Column: Welcome Text -->
<div class="lg:w-1/2 max-w-xl flex flex-col justify-center">
  <h1 class="text-3xl md:text-5xl font-extrabold mb-1 md:mb-2 leading-tight text-gray-900">
    Welcome, <span class="text-green-700">{{ Auth::user()->name ?? 'Guest' }}</span>
  </h1>
  <p class="text-gray-600 text-sm md:text-base mb-4">
    {{ Auth::user()->email ?? 'No Email' }}
  </p>

  <h2 class="text-xl md:text-2xl font-semibold mb-4 text-gray-700">Citizen Assistance & Support</h2>
  <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
    We're here to assist you with care and efficiency.  
    Whether you need help, have concerns, or wish to share your experience,  
    our support team is dedicated to providing responsive and meaningful assistance  
    to ensure your needs are met with satisfaction and respect.
  </p>

 
</div>


    <!-- 🟢 Right Column: Support Form -->
    <div class="w-full lg:w-1/2 max-w-md">
      <div class="relative group bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-3xl p-6 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-500 overflow-hidden animate__animated animate__fadeInUp">
        <div class="absolute inset-0 bg-green-200/10 rounded-3xl -z-10"></div>

        <!-- Header -->
        <div class="text-green-800 text-center pb-4">
          <h2 class="text-xl md:text-2xl font-bold">Contact Support</h2>
          <p class="text-green-700 mt-1 text-sm md:text-base">
            Need assistance? Our support team is ready to help — just let us know how we can assist you.
          </p>
        </div>

        <!-- Session Messages -->
        @if(session('success'))
          <div class="bg-green-100 border-l-4 border-green-600 p-3 rounded text-green-800 text-sm mb-2">{{ session('success') }}</div>
        @elseif(session('error'))
          <div class="bg-red-100 border-l-4 border-red-600 p-3 rounded text-red-800 text-sm mb-2">{{ session('error') }}</div>
        @endif

        @if($errors->any())
          <div class="bg-red-100 border-l-4 border-red-600 p-3 rounded text-red-800 text-sm mb-2">
            <ul class="list-disc list-inside mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('contact.send') }}" class="space-y-4">
          @csrf
          <div>
            <label class="block text-green-800 font-semibold mb-1 text-sm">Name</label>
            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="w-full px-4 py-2 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm" required>
          </div>
          <div>
            <label class="block text-green-800 font-semibold mb-1 text-sm">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" class="w-full px-4 py-2 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm" required>
          </div>
          <div>
           <div>
  <label class="block text-green-800 font-semibold mb-1 text-sm">Phone</label>
  <input 
    type="text" 
    name="phone" 
    maxlength="11"
    inputmode="numeric"
    pattern="\d{11}"
    placeholder="Enter 11-digit phone number"
    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
    class="w-full px-4 py-2 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm"
    required
  >
  <small class="text-gray-500 text-xs">* Must be 11 digits only</small>
</div>

          <div>
            <label class="block text-green-800 font-semibold mb-1 text-sm">Subject</label>
            <input type="text" name="subject" class="w-full px-4 py-2 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm">
          </div>
          <div>
            <label class="block text-green-800 font-semibold mb-1 text-sm">Message</label>
            <textarea name="message" rows="4" class="w-full px-4 py-2 rounded-xl border border-green-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/80 text-sm" required></textarea>
          </div>

          <button type="submit" class="w-full py-2.5 rounded-2xl bg-green-600 text-white font-semibold text-sm hover:bg-green-700 transition animate__animated animate__pulse animate__delay-1s">
            Submit
          </button>
        </form>
      </div>
    </div>
  </div>
</section>


@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Submitted!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
  });
</script>
@endif

</body>
</html>
