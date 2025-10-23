<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP | Bantayan 911</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide-icons/dist/umd/lucide.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { font-family: 'Roboto', sans-serif; }
    @keyframes fadeInUp { 0% {opacity:0; transform: translateY(30px);} 100% {opacity:1; transform: translateY(0);} }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
  </style>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-4xl bg-gray-800 rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

    <!-- Left Section: Branding -->
    <div class="flex flex-col justify-center items-center p-8 lg:p-12 text-center lg:text-left animate-fadeInUp">
      <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo"
           class="w-24 h-24 rounded-full shadow-lg mb-4 lg:mb-6">
      <h1 class="text-3xl font-bold text-white mb-2">Bantayan 911</h1>
      <p class="text-gray-300 text-sm lg:text-base max-w-sm">
        Protecting your account with two-factor verification. Enter the code sent to your registered email.
      </p>
    </div>

    <!-- Right Section: OTP Form -->
    <div class="p-8 lg:p-12 animate-fadeInUp">
      <h2 class="text-2xl font-bold text-white mb-6 text-center lg:text-left">Verify Your OTP</h2>

      @if ($errors->any())
        <div class="text-red-500 text-sm mb-4">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-6">
        @csrf

        <!-- OTP Input -->
        <div>
          <label for="otp" class="block text-gray-300 text-sm mb-1">One-Time Password (OTP)</label>
          <div class="relative">
            <input type="text" name="otp" id="otp" maxlength="6" required
                   class="w-full text-center text-2xl tracking-widest px-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Enter 6-digit code">
            <span class="absolute right-4 top-3 text-gray-400 text-sm">🔒</span>
          </div>
          <p class="text-gray-400 text-xs mt-1 text-center">The code will expire in 3 minutes.</p>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
          Verify & Continue
        </button>

        <!-- Resend Link -->
        <p class="text-center text-gray-400 text-sm mt-2">
          Didn’t receive the code?
          <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Resend OTP</a>
        </p>
      </form>
    </div>
  </div>

  <script>
    // Optional: Auto-focus OTP input on load
    window.addEventListener("DOMContentLoaded", () => {
      document.getElementById("otp").focus();
    });

    // Optional: SweetAlert for status message
    @if (session('status'))
      Swal.fire({
        icon: 'info',
        title: 'OTP Sent',
        text: '{{ session('status') }}',
        timer: 3000,
        showConfirmButton: false,
        background: '#1f2937',
        color: '#fff'
      });
    @endif
  </script>

</body>
</html>
