<!DOCTYPE html>
<html lang="en" x-data>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - 911 Hotline Bantayan Island</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    /* Optional: floating 3D effect for circles */
    .float-3d {
      transition: transform 0.5s ease;
    }
    .float-3d:hover {
      transform: rotateY(15deg) rotateX(10deg) scale(1.1);
    }
  </style>
</head>

<body class="bg-green-50 text-gray-900 font-roboto scroll-smooth">

  <!-- Navbar (Same style as Welcome page) -->
  <nav class="bg-white shadow-md fixed top-0 inset-x-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-md">
          <span class="text-xl md:text-2xl font-extrabold text-black tracking-tight">911 Bantayan Island</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 text-sm font-medium">
          <a href="{{ url('/') }}" class="hover:text-green-700 transition">Home</a>
          <a href="{{ route('about') }}" class="text-green-700 font-bold border-b-2 border-green-700">About</a>
          <a href="{{ route('contact') }}" class="hover:text-green-700 transition">Contact</a>
          <a href="{{ route('faq') }}" class="hover:text-green-700 transition">FAQs</a>
        </div>

        <!-- Auth -->
        <div class="hidden md:flex items-center gap-3">
          <a href="{{ url('/login') }}" class="text-sm font-bold text-green-700 hover:underline">Log In</a>
          <a href="{{ url('/register') }}" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg font-semibold text-sm shadow-md transition">Register</a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden" x-data="{ open: false }">
          <button @click="open = !open" class="text-gray-800 focus:outline-none">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>

          <div x-show="open" x-transition class="absolute top-20 left-0 w-full bg-white shadow-md px-6 py-4 space-y-2 md:hidden">
            <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-green-700">Home</a>
            <a href="{{ route('about') }}" class="block py-2 text-green-700 font-semibold">About</a>
            <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-green-700">Contact</a>
            <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-green-700">FAQs</a>
            <a href="{{ url('/login') }}" class="block py-2 font-semibold text-green-700">Log In</a>
            <a href="{{ url('/register') }}" class="block py-2 mt-2 bg-green-700 hover:bg-green-800 text-white rounded-lg text-center font-semibold">Register</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative pt-32 pb-24 bg-gradient-to-b from-green-50 to-green-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
      <!-- Image -->
      <div class="w-full lg:w-1/2 relative rounded-xl overflow-hidden shadow-2xl h-64 sm:h-80 lg:h-96 float-3d">
        <img src="{{ asset('images/bantayan.png') }}" alt="Bantayan Island" class="w-full h-full object-cover">
      </div>
      <!-- Text -->
      <div class="w-full lg:w-1/2 text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold text-green-700 mb-4">About Us</h1>
        <p class="text-lg text-gray-700 mb-4 leading-relaxed">
          The 911 Hotline Bantayan Island is a unified emergency response system serving Santa Fe, Bantayan, and Madridejos.
        </p>
        <p class="text-gray-700 mb-4 leading-relaxed">
          We provide rapid assistance for medical emergencies, fire, disaster response, and law enforcement.
        </p>
        <p class="text-gray-700 leading-relaxed">
          Our mission is to protect lives, enhance community safety, and deliver professional emergency services.
        </p>
      </div>
    </div>
  </section>

  <!-- Core Values / Services Style Section -->
  <section class="py-20 bg-green-50 overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">

      <div class="flex flex-col items-center gap-4 float-3d bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition">
        <img src="{{ asset('images/service1.png') }}" class="w-24 h-24 rounded-full object-cover shadow-lg" alt="">
        <h3 class="text-xl font-bold text-green-700">Swift Response</h3>
        <p class="text-gray-600 text-center text-sm mt-1">Every emergency call is answered promptly.</p>
      </div>

      <div class="flex flex-col items-center gap-4 float-3d bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition">
        <img src="{{ asset('images/service2.png') }}" class="w-24 h-24 rounded-full object-cover shadow-lg" alt="">
        <h3 class="text-xl font-bold text-green-700">Dedication to Service</h3>
        <p class="text-gray-600 text-center text-sm mt-1">Committed to protecting the community with professionalism.</p>
      </div>

      <div class="flex flex-col items-center gap-4 float-3d bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition">
        <img src="{{ asset('images/service3.png') }}" class="w-24 h-24 rounded-full object-cover shadow-lg" alt="">
        <h3 class="text-xl font-bold text-green-700">Transparency & Accountability</h3>
        <p class="text-gray-600 text-center text-sm mt-1">We operate with integrity in all emergency operations.</p>
      </div>

      <div class="flex flex-col items-center gap-4 float-3d bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition">
        <img src="{{ asset('images/service4.png') }}" class="w-24 h-24 rounded-full object-cover shadow-lg" alt="">
        <h3 class="text-xl font-bold text-green-700">Teamwork & Community</h3>
        <p class="text-gray-600 text-center text-sm mt-1">Collaborating with citizens, LGUs, and local responders.</p>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-10 mt-16">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-sm">&copy; 2025 911 Hotline Bantayan Island. All Rights Reserved.</p>
      <div class="flex space-x-6">
        <a href
