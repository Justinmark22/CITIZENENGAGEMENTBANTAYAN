<!DOCTYPE html>
<html lang="en" x-data="{ mobileOpen: false }" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bantayan 911 — Citizen Engagement</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/lucide-icons/dist/umd/lucide.min.js"></script>

  <style>
    html,body { font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .gov-hero { background: linear-gradient(180deg,#0b3b6f 0%, #063058 60%); }
    .gov-alert { background: #c82333; }
    .gov-card { background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); }
    /* subtle animation / a11y */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0);} }
    .fade-in { animation: fadeInUp .7s ease both; }
    .visually-hidden { position: absolute !important; height: 1px; width: 1px; overflow: hidden; clip: rect(1px, 1px, 1px, 1px); white-space: nowrap; border: 0; padding: 0; margin: -1px; }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

  <!-- Top thin gov alert strip (for emergency/notice) -->
  <div class="gov-alert text-white text-sm px-4 py-2">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1" /></svg>
        <span class="font-medium">Alert:</span>
        <span class="ml-1">Check latest advisories — stay safe and follow official updates.</span>
      </div>
      <div class="hidden sm:flex gap-4">
        <a href="{{ route('about') }}" class="underline">About</a>
        <a href="{{ route('privacy.policy') }}" class="underline">Privacy</a>
      </div>
    </div>
  </div>

  <!-- Main header/navigation -->
  <header class="bg-white border-b sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between h-20">
        <div class="flex items-center gap-4">
          <img src="{{ asset('images/citizen.png') }}" alt="Bantayan 911 logo" class="w-12 h-12 rounded-full border shadow-sm bg-white">
          <div>
            <a href="{{ url('/') }}" class="block text-lg font-extrabold text-blue-800">Bantayan 911</a>
            <p class="text-xs text-gray-500 -mt-1">Citizen Engagement • Preparedness • Reporting</p>
          </div>
        </div>

        <!-- desktop nav -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
          <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-800">Home</a>
          <a href="{{ route('engagements.index') }}" class="text-gray-700 hover:text-blue-800">Engagements</a>
          <a href="{{ route('reports.bantayan') }}" class="text-gray-700 hover:text-blue-800">Reports</a>
          <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-800">Contact</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
          <a href="{{ url('/login') }}" class="text-sm text-blue-800 font-semibold hover:underline">Log in</a>
          <a href="{{ url('/register') }}" class="ml-2 inline-block bg-blue-800 text-white px-4 py-2 rounded-md text-sm font-semibold shadow-sm hover:bg-blue-900">Register</a>
        </div>

        <!-- mobile toggle -->
        <div class="md:hidden">
          <button @click="mobileOpen = !mobileOpen" aria-expanded="false" :aria-expanded="mobileOpen.toString()" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
      </div>

      <!-- mobile menu -->
      <div x-show="mobileOpen" x-cloak class="md:hidden pb-4 border-t">
        <div class="pt-3 pb-4 space-y-1 px-3">
          <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Home</a>
          <a href="{{ route('engagements.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Engagements</a>
          <a href="{{ route('reports.bantayan') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Reports</a>
          <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Contact</a>
          <div class="mt-2 flex gap-2 px-3">
            <a href="{{ url('/login') }}" class="flex-1 text-center py-2 rounded-md border text-sm font-semibold">Log in</a>
            <a href="{{ url('/register') }}" class="flex-1 text-center py-2 rounded-md bg-blue-800 text-white text-sm font-semibold">Register</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero (ready.gov-inspired layout) -->
  <main>
    <section class="gov-hero text-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
        <div class="fade-in">
          <p class="inline-flex items-center gap-3 bg-white/10 rounded-full px-3 py-1 text-sm font-semibold text-yellow-200 w-max">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
            Community Preparedness
          </p>

          <h1 class="mt-6 text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight">Bantayan 911 — Strengthening Citizen Engagement & Emergency Preparedness</h1>

          <p class="mt-4 max-w-xl text-gray-200 text-lg">A trusted platform connecting citizens, local government units, and responders — report issues, get updates, and access preparedness resources for Bantayan, Santa Fe, and Madridejos.</p>

          <div class="mt-6 flex flex-wrap gap-3">
            <a href="#services" class="inline-flex items-center px-5 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-md shadow hover:bg-yellow-500">Explore services</a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-3 border border-white/25 text-white rounded-md hover:bg-white/5">Contact us</a>
          </div>

          <!-- quick links row (ready.gov style) -->
          <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
            <a href="{{ route('reports.bantayan') }}" class="bg-white/6 hover:bg-white/8 p-3 rounded-md text-sm text-white text-center">
              <div class="font-semibold">Report an Incident</div>
              <div class="text-xs text-gray-200">Submit photos & details</div>
            </a>
            <a href="{{ route('engagements.index') }}" class="bg-white/6 hover:bg-white/8 p-3 rounded-md text-sm text-white text-center">
              <div class="font-semibold">Community Events</div>
              <div class="text-xs text-gray-200">Announcements & trainings</div>
            </a>
            <a href="{{ route('privacy.policy') }}" class="bg-white/6 hover:bg-white/8 p-3 rounded-md text-sm text-white text-center">
              <div class="font-semibold">Privacy & Safety</div>
              <div class="text-xs text-gray-200">How we protect data</div>
            </a>
            <a href="{{ route('about') }}" class="bg-white/6 hover:bg-white/8 p-3 rounded-md text-sm text-white text-center">
              <div class="font-semibold">About Bantayan 911</div>
              <div class="text-xs text-gray-200">Mission & partners</div>
            </a>
          </div>
        </div>

        <!-- right: large image carousel -->
        <div class="rounded-xl overflow-hidden shadow-2xl border border-white/10 h-80 relative" x-data="{
          images: ['{{ asset('images/bantayan.png') }}','{{ asset('images/sta.fe.png') }}','{{ asset('images/madridejos.png') }}'],
          idx:0,
          init(){ setInterval(()=> this.idx = (this.idx+1) % this.images.length, 3500) }
        }">
          <template x-for="(img,i) in images" :key="i">
            <img :src="img" alt="location image" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700" :class="idx===i ? 'opacity-100 z-10' : 'opacity-0 z-0'">
          </template>
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
          <div class="absolute bottom-4 left-4 text-white z-20">
            <div class="bg-black/50 px-3 py-1 rounded text-sm">Bantayan • Santa Fe • Madridejos</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services (two large feature tiles with typing effect) -->
    <section id="services" class="py-16">
      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-8">
        <!-- primary service tile -->
        <div x-data="{
            images: ['{{ asset('images/gsd (1).png') }}','{{ asset('images/sta.fe.png') }}','{{ asset('images/mad.png') }}'],
            idx:0,
            typingTexts: [
              'MDRRMO: Disaster Preparedness & Emergency Response',
              'Waste Management: Keeping Bantayan Clean & Safe',
              'Water Management: Clean Water Access for All',
              'Community Engagement: Bridging Citizens and LGUs'
            ],
            tIndex:0, dText:'', cIndex:0,
            init(){ setInterval(()=> this.idx = (this.idx+1) % this.images.length, 4200); this.type(); },
            type(){ const cur = this.typingTexts[this.tIndex]; if(this.cIndex < cur.length){ this.dText += cur[this.cIndex++]; setTimeout(()=>this.type(),60) } else{ setTimeout(()=>this.delete(),1500) } },
            delete(){ if(this.cIndex>0){ this.dText=this.dText.slice(0,-1); this.cIndex--; setTimeout(()=>this.delete(),40) } else { this.tIndex = (this.tIndex+1) % this.typingTexts.length; setTimeout(()=>this.type(),500) } }
        }" class="relative rounded-xl overflow-hidden gov-card shadow-lg h-96 flex items-center justify-center text-center text-gray-50">
          <template x-for="(img,i) in images" :key="i">
            <div :style="`background-image:url(${img})`" :class="idx===i ? 'opacity-100 z-10' : 'opacity-0 z-0'" class="absolute inset-0 bg-cover bg-center transition-all duration-1000"></div>
          </template>
          <div class="absolute inset-0 bg-black/55"></div>
          <div class="relative z-20 px-6">
            <h3 class="text-2xl font-bold mb-3">Key Services</h3>
            <p class="text-lg leading-relaxed"><span x-text="dText"></span><span class="inline-block ml-1 animate-pulse">|</span></p>
          </div>
        </div>

        <!-- secondary tile -->
        <div x-data="{
            images: ['{{ asset('images/gsd (1).png') }}','{{ asset('images/sta.fe.png') }}','{{ asset('images/mad.png') }}'],
            idx:0,
            typingTexts: [
              'Health Services: Accessible Care for Everyone',
              'Public Safety: Protecting Our Communities',
              'Infrastructure: Building Sustainable Facilities',
              'Education: Learning & Growth Opportunities'
            ],
            tIndex:0, dText:'', cIndex:0,
            init(){ setInterval(()=> this.idx = (this.idx+1) % this.images.length, 4200); this.type(); },
            type(){ const cur = this.typingTexts[this.tIndex]; if(this.cIndex < cur.length){ this.dText += cur[this.cIndex++]; setTimeout(()=>this.type(),60) } else{ setTimeout(()=>this.delete(),1500) } },
            delete(){ if(this.cIndex>0){ this.dText=this.dText.slice(0,-1); this.cIndex--; setTimeout(()=>this.delete(),40) } else { this.tIndex = (this.tIndex+1) % this.typingTexts.length; setTimeout(()=>this.type(),500) } }
        }" class="relative rounded-xl overflow-hidden gov-card shadow-lg h-96 flex items-center justify-center text-center text-gray-50">
          <template x-for="(img,i) in images" :key="i">
            <div :style="`background-image:url(${img})`" :class="idx===i ? 'opacity-100 z-10' : 'opacity-0 z-0'" class="absolute inset-0 bg-cover bg-center transition-all duration-1000"></div>
          </template>
          <div class="absolute inset-0 bg-black/55"></div>
          <div class="relative z-20 px-6">
            <h3 class="text-2xl font-bold mb-3">Other Services</h3>
            <p class="text-lg leading-relaxed"><span x-text="dText"></span><span class="inline-block ml-1 animate-pulse">|</span></p>
          </div>
        </div>
      </div>
    </section>

    <!-- News & Updates -->
    <section class="py-12 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold">Latest News & Updates</h2>
          <a href="{{ route('engagements.index') }}" class="text-sm text-blue-800 font-semibold">View all</a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
          <article class="bg-white rounded-lg border hover:shadow-lg transition p-4">
            <img src="{{ asset('images/news1.jpg') }}" alt="news 1" class="w-full h-44 object-cover rounded-md mb-4">
            <h3 class="font-semibold text-lg">Barangay Coastal Cleanup 2025</h3>
            <p class="text-sm text-gray-600 mt-1">Hundreds of citizens joined hands for a cleaner Bantayan shoreline.</p>
          </article>

          <article class="bg-white rounded-lg border hover:shadow-lg transition p-4">
            <img src="{{ asset('images/news2.jpg') }}" alt="news 2" class="w-full h-44 object-cover rounded-md mb-4">
            <h3 class="font-semibold text-lg">Digital Skills Training</h3>
            <p class="text-sm text-gray-600 mt-1">Youth were trained in basic coding and digital literacy for future opportunities.</p>
          </article>

          <article class="bg-white rounded-lg border hover:shadow-lg transition p-4">
            <img src="{{ asset('images/news3.jpg') }}" alt="news 3" class="w-full h-44 object-cover rounded-md mb-4">
            <h3 class="font-semibold text-lg">Emergency Response Drill</h3>
            <p class="text-sm text-gray-600 mt-1">Santa Fe held a community-wide drill to strengthen disaster preparedness.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="py-12 bg-blue-800 text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-bold">Stay Informed — Subscribe to Updates</h3>
        <p class="mt-2 text-sm text-blue-100">Get official announcements and resources delivered to your inbox.</p>

        <form action="#" method="POST" class="mt-6 flex flex-col sm:flex-row gap-3 justify-center" onsubmit="/* wire to your subscription endpoint */ return true;">
          <input aria-label="Email address" type="email" required placeholder="you@example.com" class="w-full sm:w-2/3 px-4 py-3 rounded-md text-gray-800" />
          <button type="submit" class="px-6 py-3 rounded-md bg-yellow-400 text-gray-900 font-semibold">Subscribe</button>
        </form>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-12">
      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-6 items-center">
        <div>
          <h4 class="text-2xl font-bold">Empowering Communities with Citizen Engagement</h4>
          <p class="mt-2 text-gray-700">Join trainings, report incidents, and collaborate with local government units to make our islands safer and more resilient.</p>
          <div class="mt-4">
            <a href="{{ route('contact') }}" class="inline-block px-5 py-3 bg-blue-800 text-white rounded-md font-semibold">Join now</a>
          </div>
        </div>
        <div class="rounded-lg overflow-hidden h-56 border shadow-sm" style="background-image:url('{{ asset('images/community.png') }}'); background-size:cover; background-position:center;">
          <div class="h-full w-full bg-black/35 flex items-center justify-center text-white"> </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-6">
      <div>
        <h5 class="text-white font-bold mb-3">About</h5>
        <p class="text-sm">Bantayan 911 connects people and local government for faster reporting and better preparedness.</p>
      </div>

      <div>
        <h5 class="text-white font-bold mb-3">Quick links</h5>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('view.bantayan') }}" class="hover:text-white">Bantayan Updates</a></li>
          <li><a href="{{ route('view.santafe') }}" class="hover:text-white">Santa Fe Updates</a></li>
          <li><a href="{{ route('view.madridejos') }}" class="hover:text-white">Madridejos Updates</a></li>
        </ul>
      </div>

      <div>
        <h5 class="text-white font-bold mb-3">Contact</h5>
        <p class="text-sm">📍 Bantayan Island, Cebu<br>📧 info@citizenengage.ph<br>☎ +63 912 345 6789</p>
      </div>

      <div>
        <h5 class="text-white font-bold mb-3">Legal</h5>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('privacy.policy') }}" class="hover:text-white">Privacy Policy</a></li>
          <li><a href="{{ route('terms.service') }}" class="hover:text-white">Terms of Service</a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-6 py-4 text-xs text-gray-500 flex flex-col md:flex-row justify-between items-center">
        <span>© {{ date('Y') }} Citizen Engagement Bantayan</span>
        <span>Powered by Local Government & Communities</span>
      </div>
    </div>
  </footer>

  <script>
    // Activate lucide icons
    lucide.createIcons();

    // Small accessibility enhancement: close mobile menu on escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const root = document.documentElement;
        if (root && root.__x) { try { root.__x.$data.mobileOpen = false; } catch(e){} }
      }
    });
  </script>
</body>
</html>
