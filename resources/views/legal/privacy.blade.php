<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Privacy Policy - Citizen Engagement Platform</title>
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

<body class="bg-white text-gray-900">

  <!-- Navbar -->
  <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center gap-2">
        <img src="/images/citizen.png" alt="Logo" class="w-20 h-20">
        <span class="text-xl font-bold">CEP in Bantayan</span>
      </div>
      <div class="hidden md:flex space-x-6">
        <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
        <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 font-medium">About</a>
                <a href="{{ route('engagements.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Engagements</a>
        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-700 hover:text-indigo-600 font-medium">FAQs</a>
      </div>
      <div class="space-x-3">
        <a href="{{ url('/login') }}" class="text-indigo-600 font-medium hover:underline">Log In</a>
        <a href="{{ url('/register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition-shadow">Register</a>
      </div>
    </div>
  </nav>

  <!-- Hero Banner -->
  <section class="relative h-96 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-lg">
      <h1 class="text-4xl md:text-5xl font-bold">Privacy Policy</h1>
      <p class="text-lg mt-2">How We Protect Your Personal Information</p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-6 max-w-5xl space-y-12 fade-in-up">
      
      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Overview</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          The Citizen Engagement Platform is committed to protecting your personal data in compliance with the Data Privacy Act of 2012 (RA 10173). We uphold your rights as a data subject and strive to ensure transparency in how your data is collected, processed, and stored.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">What Information We Collect</h2>
        <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
          <li>Personal details such as name, email, and contact number</li>
          <li>Submitted reports, feedback, and engagement activity</li>
          <li>Browser and device data for security and analytics</li>
        </ul>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">How We Use Your Data</h2>
        <p class="text-gray-700 text-lg">
          Your data is used to provide and improve public services, respond to your feedback, and generate insights to enhance community programs. We do not sell or share your data with third parties unless required by law.
        </p>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Your Rights</h2>
        <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
          <li>Access to your data and request for correction</li>
          <li>Withdraw consent or request data deletion</li>
          <li>File a complaint with our Data Protection Officer</li>
        </ul>
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Contact</h2>
        <p class="text-gray-700 text-lg">
          If you have any concerns or inquiries regarding our privacy practices, you may contact our Data Protection Officer at <strong>dpo@santafe.gov.ph</strong>.
        </p>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-12">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 Citizen Engagement Platform. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
