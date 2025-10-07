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

<body class="bg-white text-gray-900">

<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 shadow-md fixed top-0 inset-x-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-12 h-12 rounded-full shadow-md">
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
    <div x-show="open" x-transition class="md:hidden bg-white shadow-lg px-6 py-4 space-y-2">
      <a href="{{ url('/') }}" class="block py-2 hover:text-blue-700">Home</a>
      <a href="{{ route('about') }}" class="block py-2 hover:text-blue-700">About</a>
      <a href="{{ route('contact') }}" class="block py-2 hover:text-blue-700">Contact</a>
      <a href="{{ route('faq') }}" class="block py-2 hover:text-blue-700">FAQs</a>
      <a href="{{ url('/login') }}" class="block py-2 font-bold text-blue-700">Log In</a>
      <a href="{{ url('/register') }}" class="block py-2 bg-blue-700 text-white rounded-md text-center mt-2">Register</a>
    </div>
  </div>
</nav>
<!-- Hero -->
<section class="relative pt-32 pb-24 bg-gray-900 text-white overflow-hidden">
  <!-- Patterned Background -->
  <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/double-bubble-dark.png')] opacity-30"></div>
  <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>

  <div class="relative max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
   <!-- Left (Updated Text) -->
<div class="lg:w-1/2 text-center lg:text-left animate-fadeInUp">
  <h2 class="text-xl lg:text-2xl font-semibold text-yellow-400 mb-2">Welcome to Bantayan Island</h2>
  <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight text-white">
    Strengthening Citizen Engagement Across Communities
  </h1>
  <p class="text-lg text-gray-300 mb-8 leading-relaxed">
    Discover a <span class="font-semibold text-yellow-400">transparent digital platform</span> that connects citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
  </p>
  <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
    <a href="#services" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg font-bold shadow-md transition">
      Explore Services
    </a>
    <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/20 hover:bg-white/30 border border-white rounded-lg font-bold shadow-md transition">
      Contact Us
    </a>
  </div>
</div>

<div class="lg:w-1/2 relative rounded-xl overflow-hidden shadow-2xl border border-white/20 h-96"
     x-data="{
       images: ['{{ asset('images/bantayan.png') }}', '{{ asset('images/sta.fe.png') }}', '{{ asset('images/madridejos.png') }}'],
       index: 0,
       init() { setInterval(() => this.index = (this.index + 1) % this.images.length, 3000) }
     }">
  <template x-for="(img, i) in images" :key="i">
    <img :src="img"
         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000"
         :class="index === i ? 'opacity-100 z-10' : 'opacity-0 z-0'">
  </template>
  <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
</div>

</section><section id="services" class="relative py-24 bg-gray-50 flex flex-col items-center gap-16">

  <!-- Card 1 -->
  <div x-data="typingText([
      'MDRRMO: Disaster Preparedness & Emergency Response',
      'Waste Management: Keeping Bantayan Clean & Safe',
      'Water Management: Clean Water Access for All',
      'Community Engagement: Bridging Citizens and LGUs'
    ])"
    class="relative w-80 h-80 rounded-full overflow-hidden shadow-2xl flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">

    <!-- Static Background -->
    <div class="absolute inset-0 w-full h-full bg-cover bg-center" 
         style="background-image: url('{{ asset('images/gsd (1).png') }}');"></div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 rounded-full"></div>

    <!-- Typing Text -->
    <div class="relative z-20 px-4">
      <h2 class="text-2xl font-bold mb-2">Our Key Services</h2>
      <p class="text-center text-md">
        <span x-text="displayText"></span><span class="blinking">|</span>
      </p>
    </div>
  </div>

  <!-- Card 2 -->
  <div x-data="typingText([
      'Health Services: Accessible Care for Everyone',
      'Public Safety: Protecting Our Communities',
      'Infrastructure: Building Sustainable Facilities',
      'Education: Learning & Growth Opportunities',
      'Environmental Care: Preserving Natural Resources'
    ])"
    class="relative w-80 h-80 rounded-full overflow-hidden shadow-2xl flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">

    <!-- Static Background -->
    <div class="absolute inset-0 w-full h-full bg-cover bg-center" 
         style="background-image: url('{{ asset('images/sta.fe.png') }}');"></div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 rounded-full"></div>

    <!-- Typing Text -->
    <div class="relative z-20 px-4">
      <h2 class="text-2xl font-bold mb-2">Other Services</h2>
      <p class="text-center text-md">
        <span x-text="displayText"></span><span class="blinking">|</span>
      </p>
    </div>
  </div>

</section>

<script>
function typingText(texts) {
  return {
    texts,
    textIndex: 0,
    displayText: '',
    charIndex: 0,
    init() { this.type(); },
    type() {
      const current = this.texts[this.textIndex];
      if(this.charIndex < current.length){
        this.displayText += current[this.charIndex++];
        setTimeout(() => this.type(), 80);
      } else { setTimeout(() => this.delete(), 1500); }
    },
    delete() {
      if(this.charIndex > 0){
        this.displayText = this.displayText.slice(0, -1);
        this.charIndex--;
        setTimeout(() => this.delete(), 50);
      } else {
        this.textIndex = (this.textIndex + 1) % this.texts.length;
        setTimeout(() => this.type(), 500);
      }
    }
  }
}
</script>

<style>
.blinking { animation: blink 1s infinite; }
@keyframes blink { 0%,50%,100%{opacity:1;}25%,75%{opacity:0;} }
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
