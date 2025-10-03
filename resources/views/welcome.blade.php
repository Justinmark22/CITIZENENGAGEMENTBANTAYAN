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
    .glass-nav { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.7); }
    .hover-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
  </style>
</head>

<body class="bg-white text-gray-900">

<!-- Navbar -->
<nav class="glass-nav border-b border-gray-200 shadow-md fixed top-0 inset-x-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="images/citizen.png" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-md">
        <span class="text-xl md:text-2xl font-extrabold text-blue-700 tracking-tight">Bantayan 911</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-8 text-sm font-medium">
        <a href="{{ url('/') }}" class="hover:text-blue-700 transition">Home</a>
        <a href="{{ route('about') }}" class="hover:text-blue-700 transition">About</a>
        <a href="{{ route('contact') }}" class="hover:text-blue-700 transition">Contact</a>
        <a href="{{ route('faq') }}" class="hover:text-blue-700 transition">FAQs</a>
      </div>

      <!-- Desktop Auth -->
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ url('/login') }}" class="text-sm font-bold text-blue-700 hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:opacity-90 text-white px-5 py-2 rounded-lg font-semibold text-sm shadow-md transition">Register</a>
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
    <div x-show="open" x-transition class="md:hidden bg-white shadow-lg px-6 py-4 space-y-2 rounded-lg mt-2">
      <a href="{{ url('/') }}" class="block py-2 hover:text-blue-700">Home</a>
      <a href="{{ route('about') }}" class="block py-2 hover:text-blue-700">About</a>
      <a href="{{ route('contact') }}" class="block py-2 hover:text-blue-700">Contact</a>
      <a href="{{ route('faq') }}" class="block py-2 hover:text-blue-700">FAQs</a>
      <a href="{{ url('/login') }}" class="block py-2 font-bold text-blue-700">Log In</a>
      <a href="{{ url('/register') }}" class="block py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md text-center mt-2">Register</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 text-white">
  <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
    <!-- Left -->
    <div class="lg:w-1/2 text-center lg:text-left animate-fadeInUp">
      <h1 class="text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">
        Strengthening Citizen Engagement in Bantayan Island
      </h1>
      <p class="text-lg mb-6 opacity-90">
        A transparent and collaborative <span class="font-bold">digital platform</span> connecting citizens, LGUs, and communities in Bantayan, Santa Fe, and Madridejos.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
        <a href="{{ route('contact') }}" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-1">
          Get Involved Today
        </a>
        <a href="{{ route('about') }}" class="px-8 py-4 border-2 border-white hover:bg-white hover:text-blue-700 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-1">
          Learn More
        </a>
      </div>
    </div>
    <!-- Right -->
    <div class="lg:w-1/2 relative rounded-xl overflow-hidden shadow-xl border border-white/30 w-full">
      <div class="relative w-full h-80 sm:h-96">
        <img src="images/bantayan.png" class="carousel-slide active absolute inset-0 w-full h-full object-cover rounded-xl">
        <img src="images/madridejos.png" class="carousel-slide absolute inset-0 w-full h-full object-cover rounded-xl opacity-0">
        <img src="images/sta.fe.png" class="carousel-slide absolute inset-0 w-full h-full object-cover rounded-xl opacity-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-xl"></div>
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold mb-12">🌐 Featured Services</h2>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="p-8 bg-white rounded-2xl shadow hover-card transition transform">
        <h3 class="font-bold text-xl text-blue-700 mb-3 flex items-center gap-2"><i data-lucide="megaphone"></i> Announcements</h3>
        <p class="text-gray-600">Stay informed with real-time updates from your community leaders.</p>
      </div>
      <div class="p-8 bg-white rounded-2xl shadow hover-card transition transform">
        <h3 class="font-bold text-xl text-green-700 mb-3 flex items-center gap-2"><i data-lucide="file-text"></i> Certificate Requests</h3>
        <p class="text-gray-600">Request barangay certificates, clearances, and other documents online.</p>
      </div>
      <div class="p-8 bg-white rounded-2xl shadow hover-card transition transform">
        <h3 class="font-bold text-xl text-yellow-700 mb-3 flex items-center gap-2"><i data-lucide="alert-circle"></i> Report Incidents</h3>
        <p class="text-gray-600">Submit reports on emergencies, issues, or concerns directly to your LGU.</p>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white text-center">
  <div class="max-w-3xl mx-auto px-6 bg-white/10 backdrop-blur-lg p-10 rounded-2xl shadow-lg">
    <h2 class="text-3xl font-bold mb-4">📩 Stay Updated</h2>
    <p class="mb-6 text-blue-100">Subscribe to our newsletter and get the latest updates on community events, reports, and announcements.</p>
    <form class="flex flex-col md:flex-row items-center justify-center gap-4">
      <input type="email" placeholder="Enter your email" class="w-full md:w-2/3 px-4 py-3 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-400 outline-none" required>
      <button class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-bold shadow-md transition">Subscribe</button>
    </form>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 mt-16">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Quick Links</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="#" class="hover:text-blue-400">Bantayan Updates</a></li>
        <li><a href="#" class="hover:text-blue-400">Santa Fe Updates</a></li>
        <li><a href="#" class="hover:text-blue-400">Madridejos Updates</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Legal & Policies</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="{{ route('privacy.policy') }}" class="hover:text-blue-400">Privacy Policy</a></li>
        <li><a href="{{ route('terms.service') }}" class="hover:text-blue-400">Terms of Service</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Contact</h4>
      <p class="text-gray-400 text-sm">📍 Bantayan Island, Cebu<br>📧 info@citizenengage.ph<br>☎ +63 912 345 6789</p>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Stay Connected</h4>
      <div class="flex flex-col space-y-2 text-sm">
        <a href="#" class="hover:text-blue-400 flex items-center gap-2"><i data-lucide="facebook"></i> Facebook</a>
        <a href="#" class="hover:text-blue-400 flex items-center gap-2"><i data-lucide="twitter"></i> Twitter</a>
        <a href="#" class="hover:text-blue-400 flex items-center gap-2"><i data-lucide="instagram"></i> Instagram</a>
        <a href="#" class="hover:text-blue-400 flex items-center gap-2"><i data-lucide="youtube"></i> YouTube</a>
      </div>
    </div>
  </div>
  <div class="border-t border-gray-700 mt-8">
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
      <p>&copy; 2025 Citizen Engagement Bantayan — Connecting People, Building Communities</p>
      <p class="mt-2 md:mt-0">Powered by Local Government & Communities</p>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script>
  lucide.createIcons();
  const slides = document.querySelectorAll('.carousel-slide');
  let current = 0;
  setInterval(() => {
    slides[current].classList.remove('active');
    slides[current].style.opacity = 0;
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
    slides[current].style.opacity = 1;
  }, 4000);
</script>

</body>
</html>
