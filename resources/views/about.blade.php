<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Bantayan 911</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-b from-green-50 via-green-100 to-green-200 text-gray-900 font-roboto scroll-smooth">
 <!-- Navbar -->
<nav class="bg-white border-b border-gray-200 shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-20">

      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex items-center gap-3">
        <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-sm">
        <span class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight">Bantayan 911</span>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-800">
        <a href="{{ url('/') }}" class="hover:text-green-700 transition">Home</a>
        <a href="{{ route('about') }}" class="hover:text-green-700 transition">About</a>
        <a href="{{ route('contact') }}" class="hover:text-green-700 transition">Contact</a>
        <a href="{{ route('faq') }}" class="hover:text-green-700 transition">FAQs</a>
      </div>

  </div>
</nav>

<!-- ✅ Mobile Menu Button -->
<div class="md:hidden px-4 py-2 flex justify-end bg-white border-b border-gray-200">
  <button @click="open = !open" class="focus:outline-none text-gray-700">
    <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    <svg x-show="open" x-transition class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
    </svg>
  </button>
</div>

<!-- ✅ Mobile Dropdown -->
<div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-200">
  <div class="flex flex-col px-4 py-3 space-y-2">
    <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-black">Home</a>
    <a href="{{ route('about') }}" class="block py-2 text-black font-semibold">About</a>
    <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-black">Contact</a>
    <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-black">FAQs</a>
  </div>
</div>

<!-- ✅ Hero Section -->
<section class="relative h-[28rem] flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/bantayan.png');">
  <div class="absolute inset-0 bg-black bg-opacity-70"></div>
  <div class="relative z-10 text-center text-white px-4" data-aos="zoom-in">
    <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="911 Logo" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-white">
    <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide">ABOUT US</h1>
    <p class="text-lg mt-2 opacity-90">Emergency Response for Bantayan Island</p>
  </div>
</section>

<!-- ✅ About Content -->
<section class="py-20">
  <div class="max-w-6xl mx-auto px-6 space-y-20">

    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-md transition-all duration-500" data-aos="fade-up">
      <h2 class="text-3xl font-bold mb-4 text-black">Who We Are</h2>
      <p class="text-gray-800 leading-relaxed text-lg">
        The Bantayan 911   is a unified emergency response system serving the municipalities of Santa Fe, Bantayan, and Madridejos. 
        We are dedicated to providing quick, reliable, and life-saving assistance during medical emergencies, fire incidents, disasters, and law enforcement situations.
      </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-md transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
      <h2 class="text-3xl font-bold mb-4 text-black">Our Mission</h2>
      <p class="text-gray-800 leading-relaxed text-lg">
        To safeguard the lives and well-being of Bantayan Island residents and visitors by delivering fast, coordinated, and professional emergency response services.
      </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-md transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
      <h2 class="text-3xl font-bold mb-4 text-black">Our Vision</h2>
      <p class="text-gray-800 leading-relaxed text-lg">
        A safer Bantayan Island where every emergency call is answered promptly, every community feels protected, and every life is given the best chance of survival and recovery.
      </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-8" data-aos="fade-up" data-aos-delay="300">
      <h2 class="text-3xl font-bold mb-6 text-center text-black">Our Core Values</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
        <div class="border border-gray-200 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✔ Swift Response</div>
        <div class="border border-gray-200 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✔ Dedication to Service</div>
        <div class="border border-gray-200 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✔ Transparency & Accountability</div>
        <div class="border border-gray-200 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✔ Teamwork & Collaboration</div>
        <div class="border border-gray-200 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✔ Community Safety</div>
      </div>
    </div>

  </div>
</section>

<!-- ✅ Footer -->
<footer class="bg-black text-gray-200 py-10 mt-16" data-aos="fade-up">
  <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <p class="text-sm">&copy; 2025 911 Hotline Bantayan Island. All Rights Reserved.</p>
    <div class="flex space-x-6">
      <a href="#" class="hover:text-white transition">Facebook</a>
      <a href="#" class="hover:text-white transition">Twitter</a>
      <a href="#" class="hover:text-white transition">Instagram</a>
    </div>
  </div>
</footer>

<!-- AOS & Alpine.js -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
    offset: 100
  });
</script>
</body>
</html>
