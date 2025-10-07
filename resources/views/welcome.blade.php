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
    @keyframes blink { 0%,50%,100%{opacity:1;}25%,75%{opacity:0;} }
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
  <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/double-bubble-dark.png')] opacity-30"></div>
  <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>

  <div class="relative max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
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
  </div>
</section>

<!-- Services -->
<section id="services" class="relative py-24 bg-gray-50" x-data>
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16">

    <!-- Left Column -->
    <div class="flex flex-col items-center gap-16">
      <template x-for="service in $store.services.leftServices" :key="service.title">
        <div x-data="typingText(service.texts)"
             x-init="init()"
             class="relative w-72 h-72 rounded-full overflow-hidden shadow-2xl flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-cover bg-center" :style="`background-image: url(${service.image})`"></div>
          <div class="absolute inset-0 bg-black/50 rounded-full"></div>
          <div class="relative z-20 px-4">
            <h2 class="text-xl font-bold mb-2" x-text="service.title"></h2>
            <p class="text-md"><span x-text="displayText"></span><span class="blinking">|</span></p>
          </div>
        </div>
      </template>
    </div>

    <!-- Right Column -->
    <div class="flex flex-col items-center gap-16">
      <template x-for="service in $store.services.rightServices" :key="service.title">
        <div x-data="typingText(service.texts)"
             x-init="init()"
             class="relative w-72 h-72 rounded-full overflow-hidden shadow-2xl flex items-center justify-center text-center text-white transform hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-cover bg-center" :style="`background-image: url(${service.image})`"></div>
          <div class="absolute inset-0 bg-black/50 rounded-full"></div>
          <div class="relative z-20 px-4">
            <h2 class="text-xl font-bold mb-2" x-text="service.title"></h2>
            <p class="text-md"><span x-text="displayText"></span><span class="blinking">|</span></p>
          </div>
        </div>
      </template>
    </div>

  </div>
</section>

<!-- Alpine Stores & Typing Function -->
<script>
document.addEventListener('alpine:init', () => {
  Alpine.store('services', {
    leftServices: [
      { title: 'Disaster Response', image: '{{ asset("images/service1.png") }}', texts: ['MDRRMO: Disaster Preparedness & Emergency Response'] },
      { title: 'Health Services', image: '{{ asset("images/service2.png") }}', texts: ['Accessible Care for Everyone'] },
      { title: 'Waste Management', image: '{{ asset("images/service3.png") }}', texts: ['Keeping Bantayan Clean & Safe'] },
      { title: 'Water Management', image: '{{ asset("images/service4.png") }}', texts: ['Clean Water Access for All'] }
    ],
    rightServices: [
      { title: 'Public Safety', image: '{{ asset("images/service5.png") }}', texts: ['Protecting Our Communities'] },
      { title: 'Education', image: '{{ asset("images/service6.png") }}', texts: ['Learning & Growth Opportunities'] },
      { title: 'Community Engagement', image: '{{ asset("images/service7.png") }}', texts: ['Bridging Citizens and LGUs'] },
      { title: 'Environmental Care', image: '{{ asset("images/service8.png") }}', texts: ['Preserving Natural Resources'] }
    ]
  })
});

function typingText(texts) {
  return {
    texts,
    textIndex: 0,
    displayText: '',
    charIndex: 0,
    init() { this.type(); },
    type() {
      const current = this.texts[this.textIndex];
      if (this.charIndex < current.length) {
        this.displayText += current[this.charIndex++];
        setTimeout(() => this.type(), 50);
      } else { setTimeout(() => this.delete(), 1000); }
    },
    delete() {
      if (this.charIndex > 0) {
        this.displayText = this.displayText.slice(0, -1);
        this.charIndex--;
        setTimeout(() => this.delete(), 25);
      } else {
        this.textIndex = (this.textIndex + 1) % this.texts.length;
        setTimeout(() => this.type(), 500);
      }
    }
  }
}
</script>

<script>
lucide.createIcons();
</script>
