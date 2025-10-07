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
  </style>
</head>
<body class="bg-gray-100 font-sans">

<!-- Navbar -->
<nav class="bg-[#064e3b] shadow-md fixed top-0 inset-x-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-md">
        <span class="text-xl md:text-2xl font-extrabold text-white tracking-tight">Bantayan 911</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-8 text-sm font-medium">
        <a href="{{ url('/') }}" class="text-white hover:text-[#064e3b] transition">Home</a>
        <a href="{{ route('about') }}" class="text-white hover:text-[#064e3b] transition">About</a>
        <a href="{{ route('contact') }}" class="text-white hover:text-[#064e3b] transition">Contact</a>
        <a href="{{ route('faq') }}" class="text-white hover:text-[#064e3b] transition">FAQs</a>
      </div>
    </div>
  </div>
</nav>

      <!-- Desktop Auth -->
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ url('/login') }}" class="text-white font-bold hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="bg-white text-[#1a4480] hover:bg-gray-100 px-5 py-2 rounded-lg font-semibold text-sm shadow-md transition">Register</a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button @click="open = !open" class="text-white focus:outline-none">
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
    <div x-show="open" x-transition class="md:hidden bg-[#1a4480] px-6 py-4 space-y-2">
      <a href="{{ url('/') }}" class="block py-2 text-white hover:text-[#1a4480]">Home</a>
      <a href="{{ route('about') }}" class="block py-2 text-white hover:text-[#1a4480]">About</a>
      <a href="{{ route('contact') }}" class="block py-2 text-white hover:text-[#1a4480]">Contact</a>
      <a href="{{ route('faq') }}" class="block py-2 text-white hover:text-[#1a4480]">FAQs</a>
      <a href="{{ url('/login') }}" class="block py-2 font-bold text-white">Log In</a>
      <a href="{{ url('/register') }}" class="block py-2 bg-white text-[#1a4480] rounded-md text-center mt-2">Register</a>
    </div>
  </div>
</nav>


<!-- Hero Section -->
<section class="relative bg-gray-50 mt-20 lg:mt-24">
  <div class="max-w-7xl mx-auto px-6 lg:flex lg:items-center lg:justify-between py-24 lg:py-32">
    
    <!-- Left Content -->
    <div class="lg:w-1/2 space-y-6">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
        Strengthening Citizen Engagement
      </h1>
      <p class="text-lg text-gray-700 max-w-lg leading-relaxed">
        Discover a <span class="font-semibold text-yellow-500">transparent digital platform</span> 
        that connects citizens, LGUs, and communities across Bantayan, Santa Fe, and Madridejos.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 mt-6">
        <a href="#services" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded shadow-md transition">
          Explore Services
        </a>
        <a href="{{ route('contact') }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-100 text-gray-900 font-semibold rounded transition">
          Contact Us
        </a>
      </div>
    </div>

    <!-- Right Image -->
    <div class="lg:w-1/2 mt-10 lg:mt-0 relative">
      <img src="{{ asset('images/bantayan.png') }}" alt="Bantayan Island" class="w-full rounded shadow-lg object-cover">
    </div>

  </div>
</section>


<!-- Advanced Services Section with Full-Width Patterned Black Background -->
<section id="services" class="relative py-24">
  <!-- Full-width Patterned Black Background -->
  <div class="absolute inset-0 bg-black/80"
       style="background-image: url('https://www.toptal.com/designers/subtlepatterns/patterns/black-thread.png');
              background-repeat: repeat;
              z-index: -10;"></div>

  <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">

    <!-- Card 1: Services Overview -->
    <div x-data="{
          images: [
             '{{ asset('images/gsd (1).png') }}',
            '{{ asset('images/sta.fe.png') }}',
            '{{ asset('images/mad.png') }}',
            '{{ asset('images/hasd.png') }}',
            '{{ asset('images/madri.png') }}'
          ],
          index: 0,
          typingTexts: [
            'MDRRMO: Disaster Preparedness & Emergency Response',
            'Waste Management: Keeping Bantayan Clean & Safe',
            'Water Management: Clean Water Access for All',
            'Community Engagement: Bridging Citizens and LGUs'
          ],
          textIndex: 0,
          displayText: '',
          charIndex: 0,
          init() {
            // Background slideshow
            setInterval(() => this.index = (this.index + 1) % this.images.length, 4000);
            this.type();
          },
          type() {
            const current = this.typingTexts[this.textIndex];
            if (this.charIndex < current.length) {
              this.displayText += current[this.charIndex];
              this.charIndex++;
              setTimeout(() => this.type(), 80);
            } else {
              setTimeout(() => this.delete(), 1500);
            }
          },
          delete() {
            if (this.charIndex > 0) {
              this.displayText = this.displayText.slice(0, -1);
              this.charIndex--;
              setTimeout(() => this.delete(), 50);
            } else {
              this.textIndex = (this.textIndex + 1) % this.typingTexts.length;
              setTimeout(() => this.type(), 500);
            }
          }
        }"
        class="relative rounded-2xl overflow-hidden shadow-2xl h-96 flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">

      <!-- Background Images with zoom/pan animation -->
      <template x-for="(img, i) in images" :key="i">
        <div :class="index === i ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0 scale-105'"
             class="absolute inset-0 w-full h-full bg-cover bg-center transition-all duration-1000 transform scale-105 animate-zoom-pan"
             :style="`background-image: url(${img})`"></div>
      </template>

      <!-- Semi-transparent Overlay -->
      <div class="absolute inset-0 bg-black/50"></div>

      <!-- Typing Text Content -->
      <div class="relative z-20 px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Key Services</h2>
        <p class="text-lg md:text-xl leading-relaxed tracking-wide">
          <span x-text="displayText"></span><span class="blinking">|</span>
        </p>
      </div>
    </div>

    <!-- Card 2: Additional Services -->
    <div x-data="{
          images: [
            '{{ asset('images/gsd (1).png') }}',
            '{{ asset('images/sta.fe.png') }}',
            '{{ asset('images/mad.png') }}',
            '{{ asset('images/hasd.png') }}',
            '{{ asset('images/madri.png') }}'
          ],
          index: 0,
          typingTexts: [
            'Health Services: Accessible Care for Everyone',
            'Public Safety: Protecting Our Communities',
            'Infrastructure: Building Sustainable Facilities',
            'Education: Learning & Growth Opportunities',
            'Environmental Care: Preserving Natural Resources'
          ],
          textIndex: 0,
          displayText: '',
          charIndex: 0,
          init() {
            setInterval(() => this.index = (this.index + 1) % this.images.length, 4000);
            this.type();
          },
          type() {
            const current = this.typingTexts[this.textIndex];
            if (this.charIndex < current.length) {
              this.displayText += current[this.charIndex];
              this.charIndex++;
              setTimeout(() => this.type(), 80);
            } else {
              setTimeout(() => this.delete(), 1500);
            }
          },
          delete() {
            if (this.charIndex > 0) {
              this.displayText = this.displayText.slice(0, -1);
              this.charIndex--;
              setTimeout(() => this.delete(), 50);
            } else {
              this.textIndex = (this.textIndex + 1) % this.typingTexts.length;
              setTimeout(() => this.type(), 500);
            }
          }
        }"
        class="relative rounded-2xl overflow-hidden shadow-2xl h-96 flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">

      <!-- Background Images with zoom/pan animation -->
      <template x-for="(img, i) in images" :key="i">
        <div :class="index === i ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0 scale-105'"
             class="absolute inset-0 w-full h-full bg-cover bg-center transition-all duration-1000 transform scale-105 animate-zoom-pan"
             :style="`background-image: url(${img})`"></div>
      </template>

      <!-- Semi-transparent Overlay -->
      <div class="absolute inset-0 bg-black/50"></div>

      <!-- Typing Text Content -->
      <div class="relative z-20 px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Other Services</h2>
        <p class="text-lg md:text-xl leading-relaxed tracking-wide">
          <span x-text="displayText"></span><span class="blinking">|</span>
        </p>
      </div>
    </div>

  </div>
</section>

<style>
  .blinking {
    animation: blink 1s infinite;
  }
  @keyframes blink {
    0%, 50%, 100% { opacity: 1; }
    25%, 75% { opacity: 0; }
  }

  /* Zoom/Pan Animation */
  @keyframes zoomPan {
    0% { transform: scale(1.05) translate(0px, 0px); }
    50% { transform: scale(1.1) translate(10px, 10px); }
    100% { transform: scale(1.05) translate(0px, 0px); }
  }
  .animate-zoom-pan {
    animation: zoomPan 12s ease-in-out infinite;
  }
</style>

     
<!-- News & Updates -->
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-8 text-center">📰 Latest News & Updates</h2>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="p-6 border rounded-lg shadow hover:shadow-xl transition transform hover:-translate-y-1">
        <img src="{{ asset('images/news1.jpg') }}" class="w-full h-40 object-cover rounded-lg mb-4">
        <h3 class="font-bold text-lg mb-2">Barangay Coastal Cleanup 2025</h3>
        <p class="text-gray-600 text-sm">Hundreds of citizens joined hands for a cleaner Bantayan shoreline.</p>
      </div>
      <div class="p-6 border rounded-lg shadow hover:shadow-xl transition transform hover:-translate-y-1">
        <img src="{{ asset('images/news2.jpg') }}" class="w-full h-40 object-cover rounded-lg mb-4">
        <h3 class="font-bold text-lg mb-2">Digital Skills Training</h3>
        <p class="text-gray-600 text-sm">Youth were trained in basic coding and digital literacy for future opportunities.</p>
      </div>
      <div class="p-6 border rounded-lg shadow hover:shadow-xl transition transform hover:-translate-y-1">
        <img src="{{ asset('images/news3.jpg') }}" class="w-full h-40 object-cover rounded-lg mb-4">
        <h3 class="font-bold text-lg mb-2">Emergency Response Drill</h3>
        <p class="text-gray-600 text-sm">Santa Fe held a community-wide drill to strengthen disaster preparedness.</p>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="py-16 bg-blue-700 text-white text-center">
  <div class="max-w-3xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-4">📩 Stay Updated</h2>
    <p class="mb-6 text-blue-100">Subscribe to our newsletter and get the latest updates on community events, reports, and announcements.</p>
    <form class="flex flex-col md:flex-row items-center justify-center gap-4">
      <input type="email" placeholder="Enter your email" class="w-full md:w-2/3 px-4 py-3 rounded-lg text-gray-800" required>
      <button class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-bold shadow-md transition">Subscribe</button>
    </form>
  </div>
</section>

<!-- CTA -->
<section class="relative mt-20">
  <div class="relative h-80 bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('images/community.png') }}');">
    <div class="bg-black bg-opacity-60 absolute inset-0"></div>
    <div class="z-10 text-center text-white px-6">
      <h2 class="text-3xl font-semibold mb-4">Empowering Communities with <span class="text-blue-400">Citizen Engagement</span></h2>
      <a href="{{ route('contact') }}" class="inline-block mt-4 bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-md transition">Join Now</a>
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
        <a href="#" class="hover:text-blue-400">🌐 Facebook</a>
        <a href="#" class="hover:text-blue-400">🐦 Twitter</a>
        <a href="#" class="hover:text-blue-400">📷 Instagram</a>
        <a href="#" class="hover:text-blue-400">▶ YouTube</a>
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
</script>

</body>
</html>
