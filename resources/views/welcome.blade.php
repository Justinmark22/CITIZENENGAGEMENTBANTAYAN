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
    @keyframes blink { 0%,50%,100% { opacity:1; } 25%,75% { opacity:0; } }

    @keyframes zoomPan {
      0% { transform: scale(1.05) translate(0,0); }
      50% { transform: scale(1.1) translate(10px,10px); }
      100% { transform: scale(1.05) translate(0,0); }
    }
    .animate-zoom-pan { animation: zoomPan 12s ease-in-out infinite; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Navbar -->
<nav class="bg-[#1a4480] fixed top-0 inset-x-0 z-50 shadow">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-10 h-10 rounded-full shadow-md">
        <span class="text-lg md:text-xl font-bold text-white tracking-tight">Bantayan 911</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-white">
        <a href="{{ url('/') }}" class="hover:text-yellow-400 transition">Home</a>
        <a href="{{ route('about') }}" class="hover:text-yellow-400 transition">About</a>
        <a href="{{ route('contact') }}" class="hover:text-yellow-400 transition">Contact</a>
        <a href="{{ route('faq') }}" class="hover:text-yellow-400 transition">FAQs</a>
        <a href="{{ route('login') }}" class="hover:text-yellow-400 transition">Login</a>
        <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-[#1a4480] px-4 py-2 rounded font-semibold transition">Register</a>
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
      <a href="{{ url('/') }}" class="block py-2 text-white hover:text-yellow-400">Home</a>
      <a href="{{ route('about') }}" class="block py-2 text-white hover:text-yellow-400">About</a>
      <a href="{{ route('contact') }}" class="block py-2 text-white hover:text-yellow-400">Contact</a>
      <a href="{{ route('faq') }}" class="block py-2 text-white hover:text-yellow-400">FAQs</a>
      <a href="{{ url('/login') }}" class="block py-2 font-bold text-white">Login</a>
      <a href="{{ url('/register') }}" class="block py-2 bg-yellow-400 text-[#1a4480] rounded text-center mt-2">Register</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="relative bg-gray-50 mt-20 lg:mt-24">
  <div class="max-w-7xl mx-auto px-6 lg:flex lg:items-center lg:justify-between py-24 lg:py-32">
    <div class="lg:w-1/2 space-y-6">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">Strengthening Citizen Engagement</h1>
      <p class="text-lg text-gray-700 max-w-lg leading-relaxed">
        Discover a <span class="font-semibold text-yellow-500">transparent digital platform</span> connecting citizens, LGUs, and communities across Bantayan.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 mt-6">
        <a href="#services" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold rounded shadow transition">Explore Services</a>
        <a href="{{ route('contact') }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-100 text-gray-900 font-semibold rounded transition">Contact Us</a>
      </div>
    </div>
    <div class="lg:w-1/2 mt-10 lg:mt-0">
      <img src="{{ asset('images/bantayan.png') }}" alt="Bantayan Island" class="w-full rounded shadow-lg object-cover">
    </div>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="relative py-24 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">
    <template x-data="serviceCard([
      '{{ asset('images/gsd (1).png') }}',
      '{{ asset('images/sta.fe.png') }}',
      '{{ asset('images/mad.png') }}',
      '{{ asset('images/hasd.png') }}',
      '{{ asset('images/madri.png') }}'
    ], [
      'MDRRMO: Disaster Preparedness & Emergency Response',
      'Waste Management: Keeping Bantayan Clean & Safe',
      'Water Management: Clean Water Access for All',
      'Community Engagement: Bridging Citizens and LGUs'
    ], 'Our Key Services')"></template>

    <template x-data="serviceCard([
      '{{ asset('images/gsd (1).png') }}',
      '{{ asset('images/sta.fe.png') }}',
      '{{ asset('images/mad.png') }}',
      '{{ asset('images/hasd.png') }}',
      '{{ asset('images/madri.png') }}'
    ], [
      'Health Services: Accessible Care for Everyone',
      'Public Safety: Protecting Our Communities',
      'Infrastructure: Building Sustainable Facilities',
      'Education: Learning & Growth Opportunities',
      'Environmental Care: Preserving Natural Resources'
    ], 'Other Services')"></template>
  </div>
</section>

<script>
function serviceCard(images, typingTexts, title) {
  return {
    images, typingTexts, title,
    index: 0, textIndex:0, displayText:'', charIndex:0,
    init() {
      setInterval(() => this.index = (this.index+1)%this.images.length, 4000);
      this.type();
    },
    type() {
      const current = this.typingTexts[this.textIndex];
      if(this.charIndex<current.length){
        this.displayText += current[this.charIndex++];
        setTimeout(()=>this.type(),80);
      } else { setTimeout(()=>this.delete(),1500); }
    },
    delete() {
      if(this.charIndex>0){
        this.displayText = this.displayText.slice(0,-1);
        this.charIndex--;
        setTimeout(()=>this.delete(),50);
      } else {
        this.textIndex = (this.textIndex+1)%this.typingTexts.length;
        setTimeout(()=>this.type(),500);
      }
    }
  }
}
lucide.createIcons();
</script>
</body>
</html>
