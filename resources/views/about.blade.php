<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - 911 Hotline Bantayan Island</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans" x-data="{ open: false }">

  <!-- Navbar -->
  <nav class="bg-black/70 backdrop-blur-md sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/images/911.png" alt="911 Logo" class="w-12 h-12 md:w-14 md:h-14 rounded-full border border-white/20 shadow-sm">
        <span class="text-lg md:text-2xl font-extrabold text-red-500">911 Bantayan Island</span>
      </div>

      <!-- Desktop Links -->
      <div class="hidden md:flex space-x-6 lg:space-x-8">
        <a href="{{ url('/') }}" class="text-gray-300 hover:text-red-500 transition font-medium">Home</a>
        <a href="{{ route('about') }}" class="text-red-500 font-bold border-b-2 border-red-500">About</a>
        <a href="{{ route('contact') }}" class="text-gray-300 hover:text-red-500 transition font-medium">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-300 hover:text-red-500 transition font-medium">FAQs</a>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="open = !open" class="md:hidden focus:outline-none text-gray-300">
        <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg x-show="open" x-transition class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="md:hidden bg-black/80 backdrop-blur-md border-t border-white/20">
      <div class="flex flex-col px-4 py-3 space-y-2">
        <a href="{{ url('/') }}" class="block py-2 hover:text-red-500">Home</a>
        <a href="{{ route('about') }}" class="block py-2 text-red-500 font-semibold">About</a>
        <a href="{{ route('contact') }}" class="block py-2 hover:text-red-500">Contact</a>
        <a href="{{ route('faq') }}" class="block py-2 hover:text-red-500">FAQs</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section with textured transparent black background -->
  <section class="relative h-[28rem] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0" 
         style="background-color: rgba(0,0,0,0.6); 
                background-image: url('https://www.toptal.com/designers/subtlepatterns/patterns/double-bubble-dark.png'); 
                background-repeat: repeat;"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-black/50 via-black/30 to-black/50"></div>

    <div class="relative z-10 text-center px-4">
      <img src="{{ asset('images/911.png') }}" alt="911 Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-xl border-4 border-white/30">
      <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide text-red-500">ABOUT US</h1>
      <p class="text-lg mt-2 text-gray-200">Emergency Response for Bantayan Island</p>
    </div>
  </section>

  <!-- About Content -->
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6 space-y-20">

      <div class="bg-black/50 backdrop-blur-md rounded-xl p-8 hover:shadow-xl transition-all duration-500">
        <h2 class="text-3xl font-bold text-red-500 mb-4">Who We Are</h2>
        <p class="text-gray-200 leading-relaxed text-lg">
          The 911 Hotline Bantayan Island is a unified emergency response system serving the municipalities of Santa Fe, Bantayan, and Madridejos. 
          We are dedicated to providing quick, reliable, and life-saving assistance during medical emergencies, fire incidents, disasters, and law enforcement situations.
        </p>
      </div>

      <div class="bg-black/50 backdrop-blur-md rounded-xl p-8 hover:shadow-xl transition-all duration-500">
        <h2 class="text-3xl font-bold text-red-500 mb-4">Our Mission</h2>
        <p class="text-gray-200 leading-relaxed text-lg">
          To safeguard the lives and well-being of Bantayan Island residents and visitors by delivering fast, coordinated, and professional emergency response services.
        </p>
      </div>

      <div class="bg-black/50 backdrop-blur-md rounded-xl p-8 hover:shadow-xl transition-all duration-500">
        <h2 class="text-3xl font-bold text-red-500 mb-4">Our Vision</h2>
        <p class="text-gray-200 leading-relaxed text-lg">
          A safer Bantayan Island where every emergency call is answered promptly, every community feels protected, and every life is given the best chance of survival and recovery.
        </p>
      </div>

      <div class="bg-black/50 backdrop-blur-md rounded-xl p-8">
        <h2 class="text-3xl font-bold text-red-500 mb-6 text-center">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-gray-200">
          <div class="bg-red-600/10 border border-red-500/20 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Swift Response</div>
          <div class="bg-red-600/10 border border-red-500/20 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Dedication to Service</div>
          <div class="bg-red-600/10 border border-red-500/20 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Transparency & Accountability</div>
          <div class="bg-red-600/10 border border-red-500/20 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Teamwork & Collaboration</div>
          <div class="bg-red-600/10 border border-red-500/20 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Community Safety</div>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black/80 text-gray-300 py-10 mt-16 backdrop-blur-md">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-sm">&copy; 2025 911 Hotline Bantayan Island. All Rights Reserved.</p>
      <div class="flex space-x-6">
        <a href="#" class="hover:text-white transition">Facebook</a>
        <a href="#" class="hover:text-white transition">Twitter</a>
        <a href="#" class="hover:text-white transition">Instagram</a>
      </div>
    </div>
  </footer>

  <!-- Alpine.js -->
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
