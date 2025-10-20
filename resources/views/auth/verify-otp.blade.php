<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP | Bantayan 911</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center min-h-screen px-4">

  <div class="bg-gray-800/90 backdrop-blur-md p-8 rounded-2xl w-full max-w-md text-center shadow-xl border border-gray-700">
    
    <!-- 🔹 Logo Section -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Bantayan 911 Logo" class="h-16 w-16 rounded-full border-2 border-indigo-500 shadow-lg">
    </div>

    <!-- 🔹 Heading -->
    <h2 class="text-white text-2xl font-extrabold mb-2">Two-Factor Verification</h2>
    <p class="text-gray-400 mb-6">Please enter the 6-digit OTP sent to your registered email.</p>

    <!-- 🔹 Error Messages -->
    @if ($errors->any())
      <div class="bg-red-900/50 text-red-300 text-sm rounded-lg p-3 mb-4 border border-red-700">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <!-- 🔹 Form -->
    <form action="{{ route('otp.verify.submit') }}" method="POST" class="space-y-4">
      @csrf

      <div class="relative">
        <input type="text" name="otp" maxlength="6" required
               class="w-full text-center text-2xl tracking-widest px-4 py-3 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-gray-500"
               placeholder="Enter OTP">
        <span class="absolute right-4 top-3 text-gray-400 text-sm">🔒</span>
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-200">
        Verify OTP
      </button>

      <p class="text-gray-500 text-sm mt-4">Didn’t receive the code?
        <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Resend</a>
      </p>
    </form>
  </div>

</body>
</html>
