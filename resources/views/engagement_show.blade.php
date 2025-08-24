<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $engagement->title }} - Details</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    /* Smooth mobile menu */
    #mobileMenu {
      transition: max-height 0.4s ease, opacity 0.3s ease;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
    }
    #mobileMenu.open {
      max-height: 500px;
      opacity: 1;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- ✅ Navbar -->
  <nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
      <div class="flex items-center gap-3" data-aos="fade-right">
        <img src="/images/citizen.png" alt="Logo" class="w-10 h-10 rounded-full">
        <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">CEP</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex gap-6" data-aos="fade-down">
        <a href="{{ url('/') }}" class="text-gray-800 hover:text-indigo-600">Home</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-indigo-600">About</a>
        <a href="{{ route('engagements.index') }}" class="text-indigo-600 font-semibold">Engagements</a>
        <a href="{{ route('contact') }}" class="text-gray-800 hover:text-indigo-600">Contact</a>
      </div>

      <!-- Mobile Button -->
      <button id="menuBtn" class="md:hidden text-gray-800 focus:outline-none">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobileMenu" class="bg-white border-t border-gray-200 md:hidden">
      <div class="px-6 py-4 space-y-3">
        <a href="{{ url('/') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Home</a>
        <a href="{{ route('about') }}" class="block text-lg text-gray-800 hover:text-indigo-600">About</a>
        <a href="{{ route('engagements.index') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Engagements</a>
        <a href="{{ route('contact') }}" class="block text-lg text-gray-800 hover:text-indigo-600">Contact</a>
      </div>
    </div>
  </nav>

  <!-- ✅ Engagement Details -->
  <div class="max-w-3xl mx-auto bg-white mt-8 p-6 md:p-8 rounded shadow" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $engagement->title }}</h1>
    <p class="mb-2"><strong>Host:</strong> {{ $engagement->host }}</p>
    <p class="mb-2"><strong>Start Date:</strong> {{ $engagement->start_date }}</p>
    <p class="mb-2"><strong>End Date:</strong> {{ $engagement->end_date }}</p>
    <div class="mt-4 text-gray-700 leading-relaxed">{{ $engagement->description }}</div>

    <!-- Guide Section -->
    <div class="mt-6 bg-gray-50 p-4 rounded" data-aos="fade-left">
      <h3 class="font-semibold text-gray-800 mb-2">Guide to Participate:</h3>
      <ul class="list-disc ml-6 text-gray-700">
        <li>Read all details above.</li>
        <li>Prepare your feedback or questions.</li>
        <li>Submit through the community portal or attend the scheduled date.</li>
      </ul>
    </div>

    <!-- ✅ Comment Section -->
    <div class="mt-10 border-t pt-6" data-aos="fade-right">
      <h3 class="text-xl font-semibold mb-4">Comments</h3>

      @if(session('success'))
        <p class="mb-4 text-green-600">{{ session('success') }}</p>
      @endif

      <!-- Post Comment -->
      <form action="{{ route('engagements.comment', $engagement->id) }}" method="POST" class="mb-6">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium">Your Name</label>
          <input type="text" name="name" required class="mt-1 p-2 w-full border rounded focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Comment</label>
          <textarea name="message" rows="3" required class="mt-1 p-2 w-full border rounded focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Post Comment</button>
      </form>

      <!-- Display Comments -->
      @forelse ($engagement->comments as $comment)
        <div class="mb-4 border-b pb-2" data-aos="fade-up">
          <p class="text-sm font-semibold text-gray-800">{{ $comment->name }}</p>
          <p class="text-gray-600">{{ $comment->message }}</p>
          <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
      @empty
        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
      @endforelse
    </div>

    <a href="{{ route('engagements.index') }}" class="mt-6 inline-block text-indigo-600 hover:underline">← Back to Engagements</a>
  </div>

  <!-- Scripts -->
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
