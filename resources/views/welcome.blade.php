<!DOCTYPE html>
<html lang="en" x-data="{ open: false }">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bantayan 911</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide/dist/lucide.min.js"></script>
  <!-- Include Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


  <!-- Tailwind Custom Animations -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { roboto: ['Roboto', 'sans-serif'] },
          keyframes: {
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(40px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            blink: {
              '0%, 50%, 100%': { opacity: '1' },
              '25%, 75%': { opacity: '0' }
            }
          },
          animation: {
            fadeInUp: 'fadeInUp 1s ease-out forwards',
            blink: 'blink 1s infinite'
          }
        }
      }
    }
  </script>
</head>

<body class="bg-white text-gray-900 font-roboto scroll-smooth">

  <!-- Navbar -->
  <nav class="bg-white border-b border-gray-200 shadow-md fixed top-0 inset-x-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-md">
          <span class="text-xl md:text-2xl font-extrabold text-black tracking-tight">Bantayan 911</span>
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
          <a href="{{ url('/register') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-lg font-semibold text-sm shadow-md transition">Register</a>
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
      <div x-show="open" x-transition x-cloak class="md:hidden bg-white shadow-lg px-6 py-4 space-y-2">
        <a href="{{ url('/') }}" class="block py-2 hover:text-blue-700">Home</a>
        <a href="{{ route('about') }}" class="block py-2 hover:text-blue-700">About</a>
        <a href="{{ route('contact') }}" class="block py-2 hover:text-blue-700">Contact</a>
        <a href="{{ route('faq') }}" class="block py-2 hover:text-blue-700">FAQs</a>
        <a href="{{ url('/login') }}" class="block py-2 font-bold text-blue-700">Log In</a>
        <a href="{{ url('/register') }}" class="block py-2 bg-blue-700 text-white rounded-md text-center mt-2">Register</a>
      </div>
    </div>
  </nav>
<!-- Hero Section -->
<section class="relative pt-32 pb-24 text-gray-900 overflow-hidden">
  <!-- Background Gradient (matching Services Section) -->
  <div class="absolute inset-0 bg-gradient-to-b from-green-50 to-green-100"></div>
  <!-- Optional subtle pattern overlay for texture -->
  <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/lines.png')] bg-repeat opacity-10"></div>

  <div class="relative max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">

    <!-- ✅ 3D Image Carousel -->
    <div 
      class="w-full lg:w-1/2 relative rounded-xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] border border-white/20 h-64 sm:h-80 lg:h-96 order-1 lg:order-2 transform-style-3d"
      x-data="{
        images: [
          '{{ asset('images/bantayan.png') }}',
          '{{ asset('images/sta.fe.png') }}',
          '{{ asset('images/madridejos.png') }}'
        ],
        index: 0,
        rotationX: 0,
        rotationY: 0,
        init() {
          setInterval(() => this.index = (this.index + 1) % this.images.length, 3000);
          this.$el.addEventListener('mousemove', e => {
            const rect = this.$el.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width/2;
            const y = e.clientY - rect.top - rect.height/2;
            this.rotationY = x * 0.03;
            this.rotationX = -y * 0.03;
          });
          this.$el.addEventListener('mouseleave', () => { this.rotationX = 0; this.rotationY = 0; });
        }
      }"
      :style="`transform: rotateX(${rotationX}deg) rotateY(${rotationY}deg); perspective: 1200px;`"
    >
      <template x-for="(img, i) in images" :key="i">
        <img 
          :src="img"
          alt="Municipality image"
          loading="lazy"
          class="absolute inset-0 w-full h-full object-cover transition-opacity duration-[1500ms] shadow-2xl"
          :class="index === i ? 'opacity-100 z-10' : 'opacity-0 z-0'"
        >
      </template>
      <div class="absolute inset-0 bg-gradient-to-t from-green-50/40 to-green-100/20"></div>
      <!-- Light Bloom Glow -->
      <div class="absolute inset-0 pointer-events-none bg-gradient-to-tr from-yellow-300/10 via-pink-200/5 to-purple-400/10 mix-blend-screen animate-pulse"></div>
    </div>

    <!-- Text Content -->
    <div class="w-full lg:w-1/2 text-left animate-fadeInUp order-2 lg:order-1 relative z-10">
      <h2 class="text-xl lg:text-2xl font-semibold text-green-700 mb-2 drop-shadow-[0_2px_10px_rgba(0,0,0,0.2)]">Welcome to Bantayan Island</h2>
      <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight text-green-900 drop-shadow-[0_4px_20px_rgba(0,0,0,0.25)]">
        Strengthening Citizen Engagement Across Communities
      </h1>
      <p class="text-gray-700 mb-8 leading-relaxed drop-shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
        Discover a <span class="font-semibold text-green-800">transparent digital platform</span> connecting citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
        <br><span class="text-gray-600/90">Experience real-time engagement, local updates, and community-driven initiatives in stunning clarity.</span>
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-start">
        <a href="#services" class="px-8 py-4 bg-green-700 hover:bg-green-800 text-white rounded-lg font-bold shadow-lg transition transform hover:scale-105">
          Explore Services
        </a>
        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/20 hover:bg-white/30 border border-white rounded-lg font-bold shadow-lg transition transform hover:scale-105 text-green-900">
          Contact Us
        </a>
      </div>
    </div>
    
  </div>
</section>

<<!-- Hero Section -->
<section class="relative pt-32 pb-24 text-gray-900 overflow-hidden bg-gradient-to-b from-green-50 to-green-100">
  <!-- Optional subtle pattern overlay -->
  <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/lines.png')] bg-repeat opacity-10"></div>

  <div class="relative max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">

    <!-- ✅ 3D Image Carousel -->
    <div 
      class="w-full lg:w-1/2 relative rounded-xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] border border-white/20 h-64 sm:h-80 lg:h-96 order-1 lg:order-2 transform-style-3d"
      x-data="{
        images: [
          '{{ asset('images/bantayan.png') }}',
          '{{ asset('images/sta.fe.png') }}',
          '{{ asset('images/madridejos.png') }}'
        ],
        index: 0,
        rotationX: 0,
        rotationY: 0,
        init() {
          setInterval(() => this.index = (this.index + 1) % this.images.length, 3000);
          this.$el.addEventListener('mousemove', e => {
            const rect = this.$el.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width/2;
            const y = e.clientY - rect.top - rect.height/2;
            this.rotationY = x * 0.03;
            this.rotationX = -y * 0.03;
          });
          this.$el.addEventListener('mouseleave', () => { this.rotationX = 0; this.rotationY = 0; });
        }
      }"
      :style="`transform: rotateX(${rotationX}deg) rotateY(${rotationY}deg); perspective: 1200px;`"
    >
      <template x-for="(img, i) in images" :key="i">
        <img 
          :src="img"
          alt="Municipality image"
          loading="lazy"
          class="absolute inset-0 w-full h-full object-cover transition-opacity duration-[1500ms] shadow-2xl"
          :class="index === i ? 'opacity-100 z-10' : 'opacity-0 z-0'"
        >
      </template>
      <div class="absolute inset-0 bg-gradient-to-t from-green-50/40 to-green-100/20"></div>
      <!-- Light Bloom Glow -->
      <div class="absolute inset-0 pointer-events-none bg-gradient-to-tr from-yellow-300/10 via-pink-200/5 to-purple-400/10 mix-blend-screen animate-pulse"></div>
    </div>

    <!-- Text Content with floating 3D effect -->
    <div 
      class="w-full lg:w-1/2 text-left order-2 lg:order-1 relative z-10"
      x-data="{ float: 0 }"
      x-init="setInterval(() => float = (float + 1) % 360, 50)"
      :style="`transform: translateY(${Math.sin(float/20)*6}px);`"
    >
      <h2 class="text-xl lg:text-2xl font-semibold text-green-700/80 mb-2 drop-shadow-[0_2px_10px_rgba(0,0,0,0.2)] animate-fadeInUp">Welcome to Bantayan Island</h2>
      <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight text-green-900 drop-shadow-[0_4px_20px_rgba(0,0,0,0.25)] animate-fadeInUp delay-200">
        Strengthening Citizen Engagement Across Communities
      </h1>
      <p class="text-gray-700 mb-8 leading-relaxed drop-shadow-[0_2px_8px_rgba(0,0,0,0.15)] animate-fadeInUp delay-400">
        Discover a <span class="font-semibold text-green-800">transparent digital platform</span> connecting citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
        <br><span class="text-gray-600/90">Experience real-time engagement, local updates, and community-driven initiatives in stunning clarity.</span>
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-start animate-fadeInUp delay-600">
        <a 
          href="#services" 
          class="px-8 py-4 bg-green-700 hover:bg-green-800 text-white rounded-lg font-bold shadow-lg transition transform hover:scale-105 hover:-translate-y-1"
        >
          Explore Services
        </a>
        <a 
          href="{{ route('contact') }}" 
          class="px-8 py-4 bg-white/20 hover:bg-white/30 border border-white rounded-lg font-bold shadow-lg transition transform hover:scale-105 hover:-translate-y-1 text-green-900"
        >
          Contact Us
        </a>
      </div>
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

  <!-- Alpine Store -->
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('services', {
        leftServices: [
          { title: 'Disaster Response', image: '{{ asset("images/haha.png") }}', texts: ['MDRRMO: Disaster Preparedness & Emergency Response'] },
          { title: 'Health Services', image: '{{ asset("images/asd.png") }}', texts: ['Accessible Care for Everyone'] },
          { title: 'Waste Management', image: '{{ asset("images/waste.png") }}', texts: ['Keeping Bantayan Clean & Safe'] },
          { title: 'Water Management', image: '{{ asset("images/watttt.png") }}', texts: ['Clean Water Access for All'] }
        ],
        rightServices: [
          { title: 'Public Safety', image: '{{ asset("images/SAN.PNG") }}', texts: ['Protecting Our Communities'] },
          { title: 'Education', image: '{{ asset("images/as.png") }}', texts: ['Learning & Growth Opportunities'] },
          { title: 'Community Engagement', image: '{{ asset("images/asdas (2).png") }}', texts: ['Bridging Citizens and LGUs'] },
          { title: 'Environmental Care', image: '{{ asset("images/gsd (1).png") }}', texts: ['Preserving Natural Resources'] }
        ]
      });
    });
  </script>
</body>
</html>
