<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FAQs - Bantayan 911</title>

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
    .hero-overlay {
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(2px);
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

  <!-- ✅ Hero Section -->
  <section class="relative h-80 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" class="w-20 h-20 mx-auto mb-4 rounded-full border-4 border-white shadow-lg" alt="Logo">
      <h1 class="text-3xl md:text-5xl font-bold">Frequently Asked Questions</h1>
      <p class="text-lg mt-2 text-green-100">Find quick answers to your questions</p>
    </div>
  </section>

  <!-- ✅ FAQ Section -->
  <section class="py-16">
    <div class="max-w-4xl mx-auto px-6 animate__animated animate__fadeInUp animate__delay-1s">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-green-700">Frequently Asked Questions</h2>
        <p class="text-gray-600 mt-2">Learn more about how the Citizen Engagement Platform works and how you can participate.</p>
      </div>

      @php
        $faqs = [
          ['question' => 'What is Bantayan 911?', 'answer' => 'Bantayan 911 connects citizens with local governments to share feedback and participate in decision-making.'],
          ['question' => 'How can I participate?', 'answer' => 'Register on the platform and engage in surveys, polls, and local initiatives.'],
          ['question' => 'Is this platform free?', 'answer' => 'Yes, Bantayan 911 is completely free for all residents of Bantayan Island municipalities.'],
          ['question' => 'Who manages Bantayan 911?', 'answer' => 'The platform is managed by local government units with support from community developers and IT experts.'],
          ['question' => 'Can I use Bantayan 911 on mobile?', 'answer' => 'Yes! Bantayan 911 is mobile-friendly and accessible from smartphones and tablets.']
        ];
      @endphp

      @foreach ($faqs as $faq)
        <div class="mb-6 bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition duration-300 border-l-4 border-green-500">
          <h3 class="text-lg md:text-xl font-semibold text-green-700 mb-2">{{ $faq['question'] }}</h3>
          <p class="text-gray-700">{{ $faq['answer'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <!-- ✅ Footer -->
  <footer class="bg-green-800 text-white py-6 mt-10 shadow-inner">
    <div class="max-w-6xl mx-auto text-center px-4">
      <p>&copy; 2025 Bantayan 911. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
