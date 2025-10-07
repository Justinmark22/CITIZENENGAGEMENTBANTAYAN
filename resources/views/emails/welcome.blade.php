<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg overflow-hidden">

    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 to-orange-500 text-white text-center py-5">
      <h2 class="text-2xl font-bold tracking-wide">Welcome to Bantayan 911!</h2>
    </div>

    <!-- Content -->
    <div class="p-6 text-gray-800 text-[15px] leading-relaxed">
      <p class="mb-3">Hi <span class="font-semibold">{{ $user->name }}</span>,</p>

      <p class="mb-3">
        We’re honored to have you join <span class="font-semibold text-red-600">Bantayan 911</span> — 
        your trusted digital emergency and community response platform.
      </p>

      <p class="mb-3">
        Stay informed with real-time alerts, community announcements, and important updates 
        from your local government and emergency responders.
      </p>

      <div class="text-center my-6">
        <a href="{{ route('login') }}" 
           class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition">
           Login to Your Account
        </a>
      </div>

      <p>
        Thank you for being part of a safer community,<br>
        <span class="font-semibold">The Bantayan 911 Team</span>
      </p>
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 text-center py-4 text-gray-500 text-xs">
      © {{ date('Y') }} Bantayan 911. All rights reserved.
    </div>
  </div>
</body>
</html>
