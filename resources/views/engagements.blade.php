@php
  use App\Models\Engagement;
  use Illuminate\Support\Str;

  $engagements = Engagement::latest()->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Engagements - Citizen Engagement Platform</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    /* Smooth mobile menu animation */
    #mobileMenu {
      transition: max-height 0.4s ease, opacity 0.3s ease;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
    }
    #mobileMenu.open {
      max-height: 500px;
      opacity: 1;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-900">

  <!-- Navbar -->
  <nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center gap-3" data-aos="fade-right">
        <img src="/images/citizen.png" alt="Logo" class="w-14 h-14 rounded-full">
        <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
          CEP in Bantayan
        </span>
      </div>

      <!-- Desktop Nav -->
      <div class="hidden md:flex space-x-8" data-aos="fade-down">
        <a href="{{ url('/') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Home</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-indigo-600 font-medium">About</a>
        <a href="{{ route('engagements.index') }}" class="text-indigo-600 font-bold border-b-2 border-indigo-600">Engagements</a>
        <a href="{{ route('contact') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-800 hover:text-indigo-600 font-medium">FAQs</a>
      </div>

      <!-- Auth Buttons -->
      <div class="hidden md:flex space-x-3" data-aos="fade-left">
        <a href="{{ url('/login') }}" class="text-indigo-600 font-medium hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-300">Register</a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="menuBtn" class="text-gray-800 focus:outline-none">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="bg-white border-t border-gray-200 md:hidden">
      <div class="px-6 py-4 space-y-3">
        <a href="{{ url('/') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Home</a>
        <a href="{{ route('about') }}" class="block text-lg text-gray-800 hover:text-indigo-600">About</a>
        <a href="{{ route('engagements.index') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Engagements</a>
        <a href="{{ route('contact') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Contact</a>
        <a href="{{ route('faq') }}" class="block text-lg text-gray-800 hover:text-indigo-600">FAQs</a>
        <hr class="my-2">
        <a href="{{ url('/login') }}" class="block text-lg text-indigo-600">Log In</a>
        <a href="{{ url('/register') }}" class="block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg text-lg text-center">Register</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative h-[26rem] flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/bantayan.png');">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative z-10 text-center text-white px-4" data-aos="zoom-in">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-lg border-4 border-white">
      <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide">COMMUNITY ENGAGEMENTS</h1>
      <p class="text-lg mt-2 opacity-90">Be part of change. Share your voice, shape your future.</p>
    </div>
  </section>

  <!-- Engagement Section -->
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-12 text-gray-800" data-aos="fade-up">Featured Engagements</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach ($engagements as $engagement)
          <div class="bg-white rounded-xl shadow hover:shadow-lg p-6 transition transform hover:-translate-y-1" data-aos="fade-up">
            <h3 class="text-xl font-bold text-indigo-700 mb-2">{{ $engagement->title }}</h3>
            <p class="text-gray-600 text-sm mb-3 leading-relaxed">{{ Str::limit($engagement->description, 160) }}</p>

            <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
              <p><strong>Host:</strong> {{ $engagement->host }}</p>
              <p><strong>Location:</strong> {{ $engagement->location ?? 'Bantayan Island' }}</p>
              <p><strong>Start:</strong> {{ $engagement->start_date }}</p>
              <p><strong>End:</strong> {{ $engagement->end_date }}</p>
            </div>

            <div class="mt-4 flex justify-between items-center">
              <span class="text-xs text-gray-500">Category: {{ $engagement->category ?? 'General' }}</span>
              <a href="{{ route('engagements.show', $engagement->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Take Part
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ✅ CTA Section Restored -->
  <section class="relative mt-20">
    <div class="relative h-80 bg-cover bg-center flex items-center justify-center" style="background-image: url('/images/hasd.png');">
      <div class="absolute inset-0 bg-black bg-opacity-60"></div>
      <div class="relative z-10 text-center text-white px-6" data-aos="zoom-in">
        <h2 class="text-2xl md:text-3xl font-semibold mb-4">Empowering Bantayan Citizens' Voices</h2>
        <a href="#" class="inline-block bg-orange-500 hover:bg-orange-600 text-white text-lg font-medium py-3 px-6 rounded-lg transition transform hover:scale-105">GET STARTED</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-10 mt-16">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-sm">&copy; 2025 Citizen Engagement Platform. All Rights Reserved.</p>
      <div class="flex space-x-6">
        <a href="#" class="hover:text-white transition">Facebook</a>
        <a href="#" class="hover:text-white transition">Twitter</a>
        <a href="#" class="hover:text-white transition">Instagram</a>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true, offset: 100 });
    lucide.createIcons();

    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('open');
    });
  </script>

</body>
</html>
