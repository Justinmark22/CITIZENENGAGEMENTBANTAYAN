<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - 911 Hotline Bantayan Island</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-900 font-sans" x-data="{ open: false }">
<!-- ✅ Navbar -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 md:py-4 flex justify-between items-center">
    
    <!-- Logo -->
    <div class="flex items-center gap-3" data-aos="fade-right">
      <img src="/images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png" alt="911 Logo" class="w-12 h-12 md:w-14 md:h-14 rounded-full border border-gray-200 shadow-sm">
      <span class="text-lg md:text-2xl font-extrabold text-black">
        911 Bantayan Island
      </span>
    </div>

    <!-- Desktop Links -->
    <div class="hidden md:flex space-x-6 lg:space-x-8" data-aos="fade-down">
      <a href="{{ url('/') }}" class="text-black hover:text-red-600 font-medium transition">Home</a>
      <a href="{{ route('about') }}" class="text-black font-bold border-b-2 border-red-600">About</a>
      <a href="{{ route('contact') }}" class="text-black hover:text-red-600 font-medium transition">Contact</a>
      <a href="{{ route('faq') }}" class="text-black hover:text-red-600 font-medium transition">FAQs</a>
    </div>
  </div>
</nav>

      <!-- ✅ Mobile Menu Button -->
      <button @click="open = !open" class="md:hidden focus:outline-none text-gray-700">
        <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg x-show="open" x-transition class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- ✅ Mobile Dropdown -->
    <div x-show="open" x-transition class="md:hidden bg-white shadow-lg border-t">
      <div class="flex flex-col px-4 py-3 space-y-2">
        <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-red-600">Home</a>
        <a href="{{ route('about') }}" class="block py-2 text-red-600 font-semibold">About</a>
        <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-red-600">Contact</a>
        <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-red-600">FAQs</a>
      </div>
    </div>
  </nav>

  <!-- ✅ Hero Section -->
  <section class="relative h-[28rem] flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/bantayan.png');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
    <div class="relative z-10 text-center text-white px-4" data-aos="zoom-in">
      <img src="{{ asset('images/911.png') }}" alt="911 Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-xl border-4 border-white">
      <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide text-red-500">ABOUT US</h1>
      <p class="text-lg mt-2 opacity-90">Emergency Response for Bantayan Island</p>
    </div>
  </section>

  <!-- ✅ About Content -->
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6 space-y-20">

      <div class="bg-white rounded-xl shadow-sm p-8 hover:shadow-md transition-all duration-500" data-aos="fade-up">
        <h2 class="text-3xl font-bold text-red-600 mb-4">Who We Are</h2>
        <p class="text-gray-700 leading-relaxed text-lg">
          The 911 Hotline Bantayan Island is a unified emergency response system serving the municipalities of Santa Fe, Bantayan, and Madridejos. 
          We are dedicated to providing quick, reliable, and life-saving assistance during medical emergencies, fire incidents, disasters, and law enforcement situations.
        </p>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-8 hover:shadow-md transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-3xl font-bold text-red-600 mb-4">Our Mission</h2>
        <p class="text-gray-700 leading-relaxed text-lg">
          To safeguard the lives and well-being of Bantayan Island residents and visitors by delivering fast, coordinated, and professional emergency response services.
        </p>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-8 hover:shadow-md transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-3xl font-bold text-red-600 mb-4">Our Vision</h2>
        <p class="text-gray-700 leading-relaxed text-lg">
          A safer Bantayan Island where every emergency call is answered promptly, every community feels protected, and every life is given the best chance of survival and recovery.
        </p>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-8" data-aos="fade-up" data-aos-delay="300">
        <h2 class="text-3xl font-bold text-red-600 mb-6 text-center">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Swift Response</div>
          <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Dedication to Service</div>
          <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Transparency & Accountability</div>
          <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Teamwork & Collaboration</div>
          <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 p-6 rounded-lg shadow-sm hover:shadow-lg transition">✅ Community Safety</div>
        </div>
      </div>

    </div>
  </section>

  <!-- ✅ Footer -->
  <footer class="bg-gray-900 text-gray-300 py-10 mt-16" data-aos="fade-up">
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
