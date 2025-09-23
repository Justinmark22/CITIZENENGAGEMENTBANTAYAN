<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Citizen Engagement Bantayan</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    #mobileMenu {
      transition: max-height 0.4s ease, opacity 0.3s ease;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
    }
    #mobileMenu.open {
      max-height: 400px;
      opacity: 1;
    }
  </style>
</head>
<body class="bg-white text-gray-900">

  <!-- ✅ Navbar -->
  <nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-3" data-aos="fade-right">
        <img src="images/citizen.png" alt="Citizen Logo" class="w-12 h-12 rounded-full border-2 border-blue-600 shadow">
        <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-blue-400">
          Citizen Engagement Bantayan
        </span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-8" data-aos="fade-down">
        <a href="{{ url('/') }}" class="text-gray-800 hover:text-blue-700">Home</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-blue-700">About</a>
        <a href="{{ route('contact') }}" class="text-blue-700 font-semibold border-b-2 border-blue-700">Contact</a>
        <a href="{{ route('faq') }}" class="text-gray-800 hover:text-blue-700">FAQs</a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="menuBtn" class="md:hidden text-gray-800 focus:outline-none">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobileMenu" class="bg-white border-t border-gray-200 md:hidden">
      <div class="px-6 py-4 space-y-3">
        <a href="{{ url('/') }}" class="block text-gray-800 hover:text-blue-700">Home</a>
        <a href="{{ route('about') }}" class="block text-gray-800 hover:text-blue-700">About</a>
        <a href="{{ route('contact') }}" class="block text-blue-700 font-semibold">Contact</a>
        <a href="{{ route('faq') }}" class="block text-gray-800 hover:text-blue-700">FAQs</a>
      </div>
    </div>
  </nav>

  <!-- ✅ Hero Section -->
  <section class="relative h-[22rem] flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/community.png');">
    <div class="absolute inset-0 bg-blue-900 bg-opacity-70"></div>
    <div class="relative z-10 text-center text-white px-4" data-aos="zoom-in">
      <img src="images/citizen.png" alt="Citizen Logo" class="w-20 h-20 mx-auto mb-3 rounded-full shadow-lg border-4 border-blue-600">
      <h1 class="text-3xl md:text-5xl font-bold text-blue-300">CONTACT US</h1>
      <p class="text-lg opacity-90 mt-2">Connecting Citizens, LGUs, and Communities in Bantayan Island</p>
    </div>
  </section>

  <!-- ✅ Contact Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-6">
      <div class="mb-12 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-3">We’d Love to Hear from You</h2>
        <p class="text-gray-600 max-w-xl mx-auto">Have questions, suggestions, or concerns? Reach out and let’s work together for a better Bantayan Island.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start" data-aos="fade-up">
        <!-- Google Map -->
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62878.59934401586!2d123.69296307274998!3d11.195128150419343!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33ab2f3b4b0f5e0f%3A0x6a084a0b5b3bfa36!2sBantayan%20Island%2C%20Cebu!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph"
          width="100%" height="500" class="rounded-lg shadow-md border border-gray-300" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <!-- Contact Form -->
        <div class="border border-gray-200 p-6 rounded-lg shadow-md bg-gray-50">
          <h3 class="text-xl font-semibold mb-4 text-blue-700">Send us a message</h3>
          <form method="POST" action="{{ route('contact.send') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-medium mb-1" for="name">Name</label>
                <input type="text" id="name" name="name" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500" required>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1" for="email">Email</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500" required>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1" for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium mb-1" for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium mb-1" for="message">Message</label>
              <textarea id="message" name="message" rows="5" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            <div class="text-right">
              <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-md font-medium transition shadow-sm hover:shadow-lg">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- ✅ Extra Contact Info -->
      <div class="mt-8 bg-blue-50 p-6 rounded-lg shadow-md" data-aos="fade-up">
        <h3 class="font-semibold text-blue-700 mb-2">Contact Information</h3>
        <p class="text-gray-700"><strong>📍 Address:</strong> Bantayan Island, Cebu, Philippines</p>
        <p class="text-gray-700"><strong>📞 Phone:</strong> <span class="text-blue-700 font-bold">+63 912 345 6789</span></p>
        <p class="text-gray-700"><strong>📧 Email:</strong> engage@bantayancommunity.org</p>
        <p class="text-gray-700"><strong>🕒 Available:</strong> Mon - Sun | 8:00 AM - 6:00 PM</p>
      </div>
    </div>
  </section>

  <!-- ✅ Footer -->
  <footer class="bg-gray-900 text-gray-300 py-6 mt-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <p>&copy; 2025 Citizen Engagement Bantayan. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- ✅ Scripts -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true, offset: 100 });
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('open');
    });
  </script>
</body>
</html>
