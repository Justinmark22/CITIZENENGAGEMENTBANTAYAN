<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Terms of Service - Bantayan 911</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    .hero-section {
      background-image: url('/images/bantayan.png');
      background-size: cover;
      background-position: center;
    }
    .fade-in-up {
      animation: fadeInUp 1s ease-in-out both;
    }
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body class="bg-gradient-to-b from-green-50 via-green-100 to-green-200 text-gray-900 font-sans scroll-smooth">

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
    </div>
  </nav>

  <!-- Hero Banner -->
  <section class="relative h-96 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-lg">
      <h1 class="text-4xl md:text-5xl font-bold">Terms of Service</h1>
      <p class="text-lg mt-2">Please Read Carefully Before Using Bantayan 911</p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="py-16">
    <div class="container mx-auto px-6 max-w-5xl space-y-12 fade-in-up">

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Agreement to Terms</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          By accessing and using the <strong>Bantayan 911 Citizen Engagement Platform</strong>, you acknowledge and agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree, you are prohibited from using or accessing this site.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">User Responsibilities</h2>
        <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
          <li>Use the platform in a respectful, lawful, and responsible manner</li>
          <li>Do not impersonate others or provide false information</li>
          <li>Avoid posting harmful, offensive, or misleading content</li>
        </ul>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Changes to Terms</h2>
        <p class="text-gray-700 text-lg">
          We reserve the right to revise these terms at any time. Updates will be posted on this page, and continued use of the platform after changes means you accept the updated terms.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Termination</h2>
        <p class="text-gray-700 text-lg">
          We may suspend or terminate your access to the platform without notice if you violate these terms or engage in activities that compromise the community’s trust and safety.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Contact Information</h2>
        <p class="text-gray-700 text-lg">
          For any questions or concerns about these terms, please contact us at 
          <strong>support@bantayan911.gov.ph</strong>.
        </p>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-green-800 text-white py-6 mt-12">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 Bantayan 911. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
