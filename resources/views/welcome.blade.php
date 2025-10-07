<!DOCTYPE html>
<html lang="en" x-data="{ open: false }">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide-icons/dist/umd/lucide.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    body { font-family: 'Roboto', sans-serif; scroll-behavior: smooth; }
    @keyframes fadeInUp { 0% {opacity:0;transform:translateY(40px);} 100% {opacity:1;transform:translateY(0);} }
    .animate-fadeInUp { animation: fadeInUp 1s ease-out forwards; }
    .blinking { animation: blink 1s infinite; }
    @keyframes blink { 0%,50%,100%{opacity:1;} 25%,75%{opacity:0;} }
  </style>
</head>
<body class="bg-gray-50 font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-md fixed top-0 inset-x-0 z-50">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-10 h-10 rounded-full shadow-md">
        <span class="text-lg md:text-xl font-extrabold text-gray-800 tracking-tight">Bantayan 911</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-4 text-sm font-medium">
        <a href="{{ url('/') }}" class="text-gray-800 hover:text-[#006c42] transition">Home</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-[#006c42] transition">About</a>
        <a href="{{ route('contact') }}" class="text-gray-800 hover:text-[#006c42] transition">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-800 hover:text-[#006c42] transition">FAQs</a>
        <a href="{{ route('login') }}" class="text-gray-800 hover:text-[#006c42] transition">Login</a>
        <a href="{{ route('register') }}" class="bg-[#006c42] text-white px-4 py-1 rounded-lg font-semibold hover:bg-[#004f33] transition">Register</a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button @click="open = !open" class="text-gray-800 focus:outline-none">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="md:hidden bg-white px-4 py-4 space-y-2 shadow-lg">
      <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-[#006c42]">Home</a>
      <a href="{{ route('about') }}" class="block py-2 text-gray-800 hover:text-[#006c42]">About</a>
      <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-[#006c42]">Contact</a>
      <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-[#006c42]">FAQs</a>
      <a href="{{ route('login') }}" class="block py-2 text-gray-800 hover:text-[#006c42]">Login</a>
      <a href="{{ route('register') }}" class="block py-2 bg-[#006c42] text-white text-center rounded-lg hover:bg-[#004f33] transition">Register</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="relative bg-gray-50 mt-16 lg:mt-20">
  <div class="max-w-7xl mx-auto px-6 lg:flex lg:items-center lg:justify-between py-20 lg:py-32">
    <!-- Left -->
    <div class="lg:w-1/2 space-y-6 text-center lg:text-left">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
        Strengthening Citizen Engagement
      </h1>
      <p class="text-lg text-gray-700 max-w-lg mx-auto lg:mx-0 leading-relaxed">
        Discover a <span class="font-semibold text-yellow-500">transparent digital platform</span> that connects citizens, LGUs, and communities across Bantayan, Santa Fe, and Madridejos.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 mt-6 justify-center lg:justify-start">
        <a href="#services" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded shadow-md transition">
          Explore Services
        </a>
        <a href="{{ route('contact') }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-100 text-gray-900 font-semibold rounded transition">
          Contact Us
        </a>
      </div>
    </div>
    <!-- Right -->
    <div class="lg:w-1/2 mt-10 lg:mt-0">
      <img src="{{ asset('images/bantayan.png') }}" alt="Bantayan Island" class="w-full rounded shadow-lg object-cover">
    </div>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="py-24 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">
    <!-- Card Example -->
    <div class="relative rounded-2xl overflow-hidden shadow-2xl h-96 flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500 bg-cover bg-center" style="background-image: url('{{ asset('images/gsd (1).png') }}')">
      <div class="absolute inset-0 bg-black/50"></div>
      <div class="relative z-10 px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">MDRRMO Services</h2>
        <p class="text-lg md:text-xl leading-relaxed tracking-wide">Disaster Preparedness & Emergency Response</p>
      </div>
    </div>
    <!-- Repeat similar cards for other services -->
    <div class="relative rounded-2xl overflow-hidden shadow-2xl h-96 flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500 bg-cover bg-center" style="background-image: url('{{ asset('images/sta.fe.png') }}')">
      <div class="absolute inset-0 bg-black/50"></div>
      <div class="relative z-10 px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Waste Management</h2>
        <p class="text-lg md:text-xl leading-relaxed tracking-wide">Keeping Bantayan Clean & Safe</p>
      </div>
    </div>
  </div>
</section>

<!-- News Section -->
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-8 text-center">📰 Latest News & Updates</h2>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="p-6 border rounded-lg shadow hover:shadow-xl transition transform hover:-translate-y-1">
        <img src="{{ asset('images/news1.jpg') }}" class="w-full h-40 object-cover rounded-lg mb-4">
        <h3 class="font-bold text-lg mb-2">Barangay Coastal Cleanup 2025</h3>
        <p class="text-gray-600 text-sm">Hundreds of citizens joined hands for a cleaner Bantayan shoreline.</p>
      </div>
      <!-- Repeat other news cards -->
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 mt-16">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Quick Links</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="#" class="hover:text-blue-400">Bantayan Updates</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Legal & Policies</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="{{ route('privacy.policy') }}" class="hover:text-blue-400">Privacy Policy</a></li>
      </ul>
    </div>
  </div>
</footer>

<script>lucide.createIcons();</script>
</body>
</html>
