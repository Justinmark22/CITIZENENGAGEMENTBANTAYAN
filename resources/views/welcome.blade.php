<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>911  Bantayan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Roboto', sans-serif; scroll-behavior: smooth; }
    
    /* Fade-in + slide animations */
    @keyframes fadeInUp { 0% {opacity:0;transform:translateY(40px);} 100% {opacity:1;transform:translateY(0);} }
    .animate-fadeInUp { animation: fadeInUp 1s ease-out forwards; }
    
    /* Carousel */
    .carousel-slide { transition: opacity 1s ease-in-out, transform 1s ease-in-out; }
    .carousel-slide.active { transform: scale(1.05); opacity: 1 !important; }
    
    /* Mobile menu */
    #mobileMenu { transition: all 0.4s ease-in-out; }
  </style>
</head>

<body class="bg-white text-gray-900">

<!-- ✅ Navbar -->
<nav class="bg-white border-b border-gray-200 shadow-md fixed top-0 inset-x-0 z-50">
  <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
    <div class="flex justify-between items-center h-20">
      <div class="flex items-center gap-4">
        <img src="images/911.png" alt="911 Logo" class="w-14 h-14 rounded-full shadow-md">
        <span class="text-2xl md:text-3xl font-extrabold text-red-600 tracking-tight">911 Bantayan</span>
      </div>
      <div class="hidden md:flex space-x-8">
        <a href="{{ url('/') }}" class="text-gray-800 hover:text-red-600 font-medium transition">Home</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-red-600 font-medium transition">About</a>
        <a href="{{ route('contact') }}" class="text-gray-800 hover:text-red-600 font-medium transition">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-800 hover:text-red-600 font-medium transition">FAQs</a>
      </div>
      <div class="hidden md:flex items-center gap-4">
        <a href="{{ url('/login') }}" class="text-lg font-bold text-red-600 hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-md transition">Register</a>
      </div>
      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="mobileMenuBtn" class="text-gray-800 focus:outline-none">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div id="mobileMenu" class="md:hidden bg-white shadow-lg px-6 py-4 hidden">
    <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-red-600">Home</a>
    <a href="{{ route('about') }}" class="block py-2 text-gray-800 hover:text-red-600">About</a>
    <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-red-600">Contact</a>
    <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-red-600">FAQs</a>
    <a href="{{ url('/login') }}" class="block py-2 font-bold text-red-600">Log In</a>
    <a href="{{ url('/register') }}" class="block py-2 bg-red-600 text-white rounded-md text-center mt-2">Register</a>
  </div>
</nav>
<!-- ✅ Hero Section -->
<section class="bg-white pt-32 pb-20 border-b border-gray-200">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
    
    <!-- Left Content -->
    <div class="lg:w-1/2 text-center lg:text-left">
      <h1 class="text-4xl lg:text-5xl font-extrabold mb-4 leading-tight text-gray-900">
        Emergency Hotline for Bantayan Island
      </h1>
      <p class="text-lg text-gray-700 mb-6">
        Call <span class="font-bold text-red-600">911</span> for emergencies. Fast, reliable, and connected to all LGUs across Bantayan, Santa Fe, and Madridejos.
      </p>
      <a href="{{ route('contact') }}" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold shadow-lg transition">
        Call Now
      </a>
    </div>
    
    <!-- Right Image Carousel -->
    <div class="lg:w-1/2 relative rounded-xl overflow-hidden shadow-xl border border-gray-200">
      <img src="images/bantayan.png" class="carousel-slide active w-full h-80 object-cover">
      <img src="images/madridejos.png" class="carousel-slide absolute top-0 left-0 w-full h-80 object-cover opacity-0">
      <img src="images/sta.fe.png" class="carousel-slide absolute top-0 left-0 w-full h-80 object-cover opacity-0">
      
      <!-- Optional subtle overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
    </div>
  </div>
</section>


<!-- ✅ Emergency Categories -->
<section class="py-20 bg-gray-50 animate-fadeInUp">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-4xl font-bold mb-6 text-gray-900 tracking-tight">Emergency Categories</h2>
    <p class="text-lg text-gray-600 mb-14 max-w-2xl mx-auto">
      Select the type of emergency you need help with. Our team will connect you to the right responders immediately.
    </p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <!-- Medical -->
      <div class="bg-white border rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 p-10">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 text-red-600 text-3xl">
          🚑
        </div>
        <h3 class="text-xl font-semibold mb-3 text-gray-900">Medical Emergencies</h3>
        <p class="text-gray-600">Immediate assistance for accidents, injuries, and urgent health crises.</p>
      </div>

      <!-- Fire -->
      <div class="bg-white border rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 p-10">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 text-red-600 text-3xl">
          🔥
        </div>
        <h3 class="text-xl font-semibold mb-3 text-gray-900">Fire & Rescue</h3>
        <p class="text-gray-600">Rapid response to fire incidents, rescue operations, and disaster aid.</p>
      </div>

      <!-- Police -->
      <div class="bg-white border rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 p-10">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 text-red-600 text-3xl">
          👮
        </div>
        <h3 class="text-xl font-semibold mb-3 text-gray-900">Police Assistance</h3>
        <p class="text-gray-600">Report crimes, disturbances, or request urgent law enforcement support.</p>
      </div>
    </div>
  </div>
</section>


<!-- ✅ Bantayan Island Map -->
<section class="py-20 bg-gray-50 animate-fadeInUp">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold mb-8">📍 Bantayan Island Coverage</h2>
    <p class="text-gray-600 mb-6">Our 911 services cover the entire island — Bantayan, Santa Fe, and Madridejos.</p>
    <div class="w-full h-96 rounded-xl overflow-hidden shadow-2xl border bg-white bg-opacity-80 backdrop-blur-lg">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62891.93853362131!2d123.66712135292486!3d11.171104087352572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33067ebff1b14b7f%3A0x9e1082c1a657d816!2sBantayan%20Island!5e0!3m2!1sen!2sph!4v1697903417620!5m2!1sen!2sph" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>

<!-- ✅ Call-to-Action -->
<section class="relative mt-20 animate-fadeInUp">
  <div class="relative h-80 bg-cover bg-center flex items-center justify-center" style="background-image: url('/images/hasd.png');">
    <div class="bg-black bg-opacity-60 absolute inset-0"></div>
    <div class="z-10 text-center text-white px-6">
      <h2 class="text-3xl font-semibold mb-4">One Island. One Hotline. <span class="text-red-500">911 Bantayan</span></h2>
      <a href="tel:911" class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-md transition">📞 Call Now</a>
    </div>
  </div>
</section>

<!-- ✅ Footer -->
<footer class="bg-gray-900 text-gray-300 mt-16">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Emergency Links</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="#" class="hover:text-red-400">• Bantayan MDRRMO</a></li>
        <li><a href="#" class="hover:text-red-400">• Santa Fe MDRRMO</a></li>
        <li><a href="#" class="hover:text-red-400">• Madridejos MDRRMO</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">Legal & Policies</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="{{ route('privacy.policy') }}" class="hover:text-red-400">• Privacy Policy</a></li>
        <li><a href="{{ route('terms.service') }}" class="hover:text-red-400">• Terms of Service</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white text-lg font-bold mb-4">About 911 Bantayan</h4>
      <p class="text-gray-400 text-sm">911 Hotline Bantayan connects citizens to emergency services across the island, ensuring quick response and saving lives.</p>
    </div>
  </div>
  <div class="border-t border-gray-700 mt-8">
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
      <p>&copy; 2025 911 Hotline Bantayan — Saving Lives, Protecting Communities</p>
    </div>
  </div>
</footer>

<!-- ✅ Scripts -->
<script>
  // Carousel
  const slides = document.querySelectorAll('.carousel-slide');
  let current = 0;
  setInterval(() => {
    slides[current].classList.remove('active');
    slides[current].style.opacity = 0;
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
    slides[current].style.opacity = 1;
  }, 4000);

  // Mobile menu toggle
  const mobileBtn = document.getElementById("mobileMenuBtn");
  const mobileMenu = document.getElementById("mobileMenu");
  mobileBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });
</script>

</body>
</html>
