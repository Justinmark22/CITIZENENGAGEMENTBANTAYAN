<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Privacy Policy - Bantayan 911</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    .hero-section {
      background-image: url('{{ asset('images/bantayan.png') }}');
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

  <!-- ✅ Hero Banner -->
  <section class="relative h-96 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-white shadow-lg">
      <h1 class="text-4xl md:text-5xl font-bold">Privacy Policy</h1>
      <p class="text-lg mt-2 text-green-100">How We Protect Your Personal Information</p>
    </div>
  </section>

  <!-- ✅ Main Content -->
  <section class="py-16">
    <div class="max-w-5xl mx-auto px-6 space-y-12 fade-in-up bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-8">

      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">Overview</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          The Citizen Engagement Platform under Bantayan 911 is committed to protecting your personal data in compliance with the Data Privacy Act of 2012 (RA 10173). We uphold your rights as a data subject and ensure transparency in how your data is collected, processed, and stored.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">What Information We Collect</h2>
        <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
          <li>Personal details such as name, email, and contact number</li>
          <li>Submitted reports, feedback, and engagement activity</li>
          <li>Browser and device data for security and analytics</li>
        </ul>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">How We Use Your Data</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          Your data is used to provide and improve public services, respond to your feedback, and generate insights to enhance community programs. We do not sell or share your data with third parties unless required by law.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">Your Rights</h2>
        <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
          <li>Access your personal data and request for correction</li>
          <li>Withdraw consent or request data deletion</li>
          <li>File a complaint with our Data Protection Officer</li>
        </ul>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">Contact</h2>
        <p class="text-gray-700 text-lg">
          For inquiries or concerns about your data privacy, contact our Data Protection Officer at 
          <strong class="text-green-700">dpo@bantayan.gov.ph</strong>.
        </p>
      </div>

    </div>
  </section>

  <!-- ✅ Footer -->
  <footer class="bg-green-800 text-white py-6 mt-12 shadow-inner">
    <div class="max-w-6xl mx-auto text-center px-4">
      <p>&copy; 2025 Bantayan 911 – Citizen Engagement Platform. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
