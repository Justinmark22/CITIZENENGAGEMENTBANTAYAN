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

      <!-- Desktop Auth Buttons -->
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ url('/login') }}" class="text-sm font-semibold text-green-700 hover:underline focus:outline-none focus:ring-2 focus:ring-green-500 rounded">Log In</a>
        <a href="{{ url('/register') }}" class="px-5 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg font-semibold text-sm shadow transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500">Register</a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden" x-data="{ open: false }">
        <button @click="open = !open" aria-label="Toggle menu" class="text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 rounded">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition class="absolute top-20 left-0 w-full bg-white shadow-md px-6 py-4 space-y-2 md:hidden">
          <a href="{{ url('/') }}" class="block py-2 text-gray-800 hover:text-green-700 transition">Home</a>
          <a href="{{ route('about') }}" class="block py-2 text-gray-800 hover:text-green-700 transition">About</a>
          <a href="{{ route('contact') }}" class="block py-2 text-gray-800 hover:text-green-700 transition">Contact</a>
          <a href="{{ route('faq') }}" class="block py-2 text-gray-800 hover:text-green-700 transition">FAQs</a>
          <a href="{{ url('/login') }}" class="block py-2 font-semibold text-green-700 hover:underline">Log In</a>
          <a href="{{ url('/register') }}" class="block py-2 mt-2 bg-green-700 hover:bg-green-800 text-white rounded-lg text-center font-semibold">Register</a>
        </div>
      </div>

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
<!-- ✅ 3D Image Carousel with Fade-In Animation -->
<div 
  class="w-full lg:w-1/2 relative rounded-xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] border border-white/20 h-64 sm:h-80 lg:h-96 order-1 lg:order-2 transform-style-3d animate-carouselFadeIn"
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
      // Auto-rotate images every 3 seconds
      setInterval(() => this.index = (this.index + 1) % this.images.length, 3000);

      // Add 3D rotation on mouse movement
      this.$el.addEventListener('mousemove', e => {
        const rect = this.$el.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        this.rotationY = x * 0.03;
        this.rotationX = -y * 0.03;
      });

      // Reset rotation when mouse leaves
      this.$el.addEventListener('mouseleave', () => {
        this.rotationX = 0;
        this.rotationY = 0;
      });
    }
  }"
  :style="`transform: rotateX(${rotationX}deg) rotateY(${rotationY}deg); perspective: 1200px;`"
>
  <template x-for="(img, i) in images" :key="i">
    <img 
      :src="img"
      alt="Municipality image"
      loading="lazy"
      class="absolute inset-0 w-full h-full object-cover transition-all duration-[1500ms] ease-in-out shadow-2xl"
      :class="index === i ? 'opacity-100 scale-100 z-10' : 'opacity-0 scale-105 z-0'"
    >
  </template>


<!-- ✨ Fade + Carousel Animations -->
<style>
@keyframes carouselFadeIn {
  from { opacity: 0; transform: translateY(20px) scale(0.98); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.animate-carouselFadeIn {
  animation: carouselFadeIn 1.2s ease forwards;
}
</style>

      <div class="absolute inset-0 bg-gradient-to-t from-green-50/40 to-green-100/20"></div>
      <!-- Light Bloom Glow -->
      <div class="absolute inset-0 pointer-events-none bg-gradient-to-tr from-yellow-300/10 via-pink-200/5 to-purple-400/10 mix-blend-screen animate-pulse"></div>
    </div>
    <!-- Text Content -->
<div class="w-full lg:w-1/2 text-left order-2 lg:order-1 relative z-10 text-black">
  <h2 class="fade-typing text-base lg:text-lg font-semibold mb-1 text-green-700 drop-shadow-[0_2px_10px_rgba(0,0,0,0.2)]" style="animation-delay: 0s;">
    Welcome to Bantayan Island
  </h2>

  <h1 class="fade-typing text-lg lg:text-xl font-bold mb-3 leading-snug text-green-900 drop-shadow-[0_4px_20px_rgba(0,0,0,0.25)]" style="animation-delay: 1.5s;">
    Strengthening Collaboration Across Bantayan Island's Communities.
  </h1>

  <p class="fade-typing text-xs lg:text-sm text-gray-700 mb-6 leading-relaxed drop-shadow-[0_2px_8px_rgba(0,0,0,0.15)]" style="animation-delay: 4s;">
    Discover a <span class="font-semibold text-green-800">transparent digital platform</span> connecting citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
    <br><span class="text-gray-600/90">Experience real-time engagement, local updates, and community-driven initiatives in stunning clarity.</span>
  </p>

  <div class="flex flex-col sm:flex-row gap-3 justify-start opacity-0 animate-fadeIn" style="animation-delay: 7s;">
    <a href="#services" class="px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white rounded-md font-semibold text-sm shadow-lg transition transform hover:scale-105">
      Explore Services
    </a>
    <a href="{{ route('contact') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white rounded-md font-semibold text-sm shadow-lg transition transform hover:scale-105 text-green-900">
      Contact Us
    </a>
  </div>
</div>

<!-- ✨ Typing + Fade Animations -->
<style>
@keyframes typing {
  from { width: 0; }
  to { width: 100%; }
}
@keyframes blink {
  50% { border-color: transparent; }
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Typing Animation */
.fade-typing {
  overflow: hidden;
  white-space: nowrap;
  border-right: 2px solid black;
  width: 0;
  opacity: 0;
  display: inline-block;
  animation: fadeIn 0.6s ease forwards, typing 3.5s steps(80, end) forwards, blink .8s infinite;
}

/* Staggered delays */
.fade-typing:nth-of-type(1) { animation-delay: 0s, 0s, 0s; }
.fade-typing:nth-of-type(2) { animation-delay: 1.5s, 1.5s, 1.5s; }
.fade-typing:nth-of-type(3) { animation-delay: 4s, 4s, 4s; }

.animate-fadeIn {
  animation: fadeIn 1s ease forwards;
  animation-fill-mode: forwards;
}
</style>


    
  </div>
</section><!-- Services Section -->
<section id="services" class="relative py-32 bg-gradient-to-b from-green-50 to-green-100 overflow-hidden">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-28">

    <!-- Left Column -->
    <div class="flex flex-col justify-between gap-24">
      <template x-for="service in $store.services.leftServices" :key="service.title">
        <div class="flex items-center gap-8" x-data="typingEffect(service)">
          <!-- Floating 3D Circle -->
          <div 
            class="w-36 h-36 md:w-40 md:h-40 flex-shrink-0 rounded-full overflow-hidden shadow-[0_15px_35px_rgba(0,0,0,0.2)] bg-white transform transition-all duration-500 hover:rotate-6 hover:scale-110"
            x-data="{ float: 0 }"
            x-init="setInterval(() => float = (float + 1) % 360, 50)"
            :style="`transform: translateY(${Math.sin(float/20)*8}px) rotate(${Math.sin(float/30)*4}deg);`"
          >
            <img :src="service.image" alt="" class="w-full h-full object-cover">
          </div>

          <!-- Text -->
          <div class="text-left max-w-[280px]">
            <h3 class="text-xl md:text-2xl font-extrabold text-green-700/80 relative">
              <span x-text="typedTitle"></span><span class="animate-pulse">|</span>
            </h3>
            <p class="text-gray-600 mt-2 text-sm md:text-base leading-relaxed">
              <span x-text="typedText"></span><span class="animate-pulse">|</span>
            </p>
          </div>
        </div>
      </template>
    </div>

    <!-- Right Column -->
    <div class="flex flex-col justify-between gap-24">
      <template x-for="service in $store.services.rightServices" :key="service.title">
        <div class="flex items-center gap-8" x-data="typingEffect(service)">
          <!-- Floating 3D Circle -->
          <div 
            class="w-36 h-36 md:w-40 md:h-40 flex-shrink-0 rounded-full overflow-hidden shadow-[0_15px_35px_rgba(0,0,0,0.2)] bg-white transform transition-all duration-500 hover:-rotate-6 hover:scale-110"
            x-data="{ float: 0 }"
            x-init="setInterval(() => float = (float + 1) % 360, 50)"
            :style="`transform: translateY(${Math.sin(float/20)*8}px) rotate(${Math.sin(float/30)*4}deg);`"
          >
            <img :src="service.image" alt="" class="w-full h-full object-cover">
          </div>

          <!-- Text -->
          <div class="text-left max-w-[280px]">
            <h3 class="text-xl md:text-2xl font-extrabold text-green-700/80 relative">
              <span x-text="typedTitle"></span><span class="animate-pulse">|</span>
            </h3>
            <p class="text-gray-600 mt-2 text-sm md:text-base leading-relaxed">
              <span x-text="typedText"></span><span class="animate-pulse">|</span>
            </p>
          </div>
        </div>
      </template>
    </div>

  </div>
</section>

<!-- Alpine Store and Typing Script -->
<script>
  document.addEventListener('alpine:init', () => {
    // Alpine Store: Services
    Alpine.store('services', {
      leftServices: [
        {
          title: 'Disaster Response',
          image: '{{ asset("images/haha.png") }}',
          texts: [
            'MDRRMO: Disaster Preparedness & Emergency Response.',
            'Quick and coordinated action during calamities.',
            'Community drills and real-time hazard updates for safety awareness.'
          ]
        },
        {
          title: 'Health Services',
          image: '{{ asset("images/asd.png") }}',
          texts: [
            'Accessible Care for Everyone through local health centers.',
            'Regular medical missions and free consultations.',
            'Promoting health awareness, nutrition, and preventive care.'
          ]
        },
        {
          title: 'Waste Management',
          image: '{{ asset("images/waste.png") }}',
          texts: [
            'Keeping Bantayan Clean & Safe for all residents.',
            'Daily waste collection and segregation programs.',
            'Encouraging recycling and proper waste disposal habits.'
          ]
        },
        {
          title: 'Water Management',
          image: '{{ asset("images/watttt.png") }}',
          texts: [
            'Clean Water Access for All households and facilities.',
            'Sustainable water conservation and maintenance initiatives.',
            'Ensuring safe, reliable, and eco-friendly water supply systems.'
          ]
        }
      ],

      rightServices: [
        {
          title: 'Public Safety',
          image: '{{ asset("images/SAN.PNG") }}',
          texts: [
            'Protecting Our Communities with coordinated security measures.',
            'Active patrol and community watch initiatives.',
            'Emergency hotlines and police visibility in key areas.'
          ]
        },
        {
          title: 'Education',
          image: '{{ asset("images/as.png") }}',
          texts: [
            'Learning & Growth Opportunities for the youth and adults.',
            'Scholarship programs and digital literacy workshops.',
            'Empowering the next generation through quality education.'
          ]
        },
        {
          title: 'Community Engagement',
          image: '{{ asset("images/asdas (2).png") }}',
          texts: [
            'Bridging Citizens and LGUs for a stronger partnership.',
            'Encouraging transparency and participatory governance.',
            'Creating platforms for dialogue and collaborative solutions.'
          ]
        },
        {
          title: 'Environmental Care',
          image: '{{ asset("images/gsd (1).png") }}',
          texts: [
            'Preserving Natural Resources for future generations.',
            'Mangrove rehabilitation and coastal cleanup drives.',
            'Promoting green living and climate resilience.'
          ]
        }
      ]
    });

    // Typing Animation Data Component
    Alpine.data('typingEffect', (service) => ({
      typedTitle: '',
      typedText: '',
      async init() {
        while (true) {
          await this.typeAndErase(service.title, 'title');
          for (const text of service.texts) {
            await this.typeAndErase(text, 'text');
          }
        }
      },
      async typeAndErase(str, type) {
        // Type forward
        for (let i = 0; i <= str.length; i++) {
          if (type === 'title') this.typedTitle = str.slice(0, i);
          else this.typedText = str.slice(0, i);
          await this.sleep(70);
        }
        await this.sleep(1500); // pause after typing
        // Erase backward
        for (let i = str.length; i >= 0; i--) {
          if (type === 'title') this.typedTitle = str.slice(0, i);
          else this.typedText = str.slice(0, i);
          await this.sleep(40);
        }
      },
      sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      }
    }));
  });
</script>


  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">
     
      <div>
        <h4 class="text-white text-lg font-bold mb-4">Legal & Policies</h4>
        <ul class="space-y-3 text-sm">
          <li><a href="{{ route('privacy.policy') }}" class="hover:text-blue-400">Privacy Policy</a></li>
          <li><a href="{{ route('terms.service') }}" class="hover:text-blue-400">Terms of Service</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white text-lg font-bold mb-4">Contact</h4>
        <p class="text-gray-400 text-sm">📍 Bantayan Island, Cebu<br>📧 bantayan911@gmail.com<br>☎ +63 994 309 5640</p>
      </div>
      <div>
        <h4 class="text-white text-lg font-bold mb-4">Stay Connected</h4>
        <div class="flex flex-col space-y-2 text-sm">
          <a href="
web.facebook.com/justinmark.kaquilala.9" class="hover:text-blue-400">🌐 Facebook</a>
          <a href="#" class="hover:text-blue-400">🐦 Twitter</a>
          <a href="#" class="hover:text-blue-400">📷 Instagram</a>
          <a href="#" class="hover:text-blue-400">▶ YouTube</a>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-700 mt-8">
      <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
        <p>&copy; 2025 Bantayan 911 — Connecting People, Building Communities</p>
        <p class="mt-2 md:mt-0">Powered by Local Government & Communities</p>
      </div>
    </div>
  </footer>
wasdhasdasdsad
</body>
</html>
