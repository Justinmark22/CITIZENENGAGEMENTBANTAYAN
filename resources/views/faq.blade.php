<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FAQs - Citizen Engagement Platform</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    .hero-section {
      background-image: url('/images/bantayan.png');
      background-size: cover;
      background-position: center;
    }
    .menu-enter {
      animation: slideDown 0.3s ease-out forwards;
    }
    @keyframes slideDown {
      0% { opacity: 0; transform: translateY(-10px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="bg-gray-50 font-sans text-gray-900">

  <!-- ✅ Navbar -->
  <nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-14 h-14 rounded-full border border-gray-300 shadow">
        <span class="text-lg md:text-xl font-bold text-indigo-700">CEP in Bantayan</span>
      </div>

      <!-- Desktop Links -->
      <div class="hidden md:flex space-x-6">
        <a href="{{ url('/') }}" class="hover:text-indigo-600">Home</a>
        <a href="{{ route('about') }}" class="hover:text-indigo-600">About</a>
        <a href="{{ route('engagements.index') }}" class="hover:text-indigo-600">Engagements</a>
        <a href="{{ route('contact') }}" class="hover:text-indigo-600">Contact</a>
        <a href="{{ route('faq') }}" class="text-indigo-600 font-semibold">FAQs</a>
      </div>

      <!-- CTA & Hamburger -->
      <div class="flex items-center gap-3">
        <a href="{{ url('/login') }}" class="hidden md:inline text-indigo-600 hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="hidden md:inline bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Register</a>
        <button id="menu-btn" class="md:hidden p-2 rounded hover:bg-gray-100 focus:outline-none">
          <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobile-menu" class="hidden flex-col bg-white shadow-md md:hidden menu-enter px-6 py-4 space-y-3">
      <a href="{{ url('/') }}" class="block py-1 hover:text-indigo-600">Home</a>
      <a href="{{ route('about') }}" class="block py-1 hover:text-indigo-600">About</a>
      <a href="{{ route('engagements.index') }}" class="block py-1 hover:text-indigo-600">Engagements</a>
      <a href="{{ route('contact') }}" class="block py-1 hover:text-indigo-600">Contact</a>
      <a href="{{ route('faq') }}" class="block py-1 text-indigo-600 font-semibold">FAQs</a>
      <div class="pt-2 border-t">
        <a href="{{ url('/login') }}" class="block py-1 text-indigo-600 hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="block py-2 bg-indigo-600 text-white text-center rounded-md hover:bg-indigo-700">Register</a>
      </div>
    </div>
  </nav>

  <!-- ✅ Hero Section -->
  <section class="relative h-80 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/citizen.png') }}" class="w-20 h-20 mx-auto mb-4 rounded-full border-4 border-white shadow-lg" alt="Logo">
      <h1 class="text-3xl md:text-5xl font-bold">FAQs</h1>
      <p class="text-lg mt-2">Find quick answers to your questions</p>
    </div>
  </section>

  <!-- ✅ FAQ Section -->
  <section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6 animate__animated animate__fadeInUp animate__delay-1s">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-indigo-700">Frequently Asked Questions</h2>
        <p class="text-gray-600 mt-2">Learn more about how the Citizen Engagement Platform works and how you can participate.</p>
      </div>

      @php
        $faqs = [
          ['question' => 'What is CEP?', 'answer' => 'The Citizen Engagement Platform connects citizens with local governments to share feedback and participate in decision-making.'],
          ['question' => 'How can I participate?', 'answer' => 'Register on the platform and engage in surveys, polls, and local initiatives.'],
          ['question' => 'Is this platform free?', 'answer' => 'Yes, CEP is completely free for all residents of Bantayan Island municipalities.'],
          ['question' => 'Who manages CEP?', 'answer' => 'The platform is run by local government units with support from community developers and IT experts.'],
          ['question' => 'Can I use CEP on mobile?', 'answer' => 'Yes! CEP is mobile-friendly and accessible from smartphones and tablets.']
        ];
      @endphp

      @foreach ($faqs as $faq)
        <div class="mb-6 bg-gray-50 p-5 rounded-lg shadow-sm hover:shadow-md transition duration-300">
          <h3 class="text-lg md:text-xl font-semibold text-indigo-700 mb-2">{{ $faq['question'] }}</h3>
          <p class="text-gray-700">{{ $faq['answer'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <!-- ✅ Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-10">
    <div class="max-w-6xl mx-auto text-center px-4">
      <p>&copy; 2025 Citizen Engagement Platform. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- ✅ Mobile Menu Script -->
  <script>
    document.getElementById('menu-btn').addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });
  </script>

</body>
</html>
