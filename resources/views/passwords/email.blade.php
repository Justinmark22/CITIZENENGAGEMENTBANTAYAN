<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Roboto', sans-serif; }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
  </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-md bg-white rounded-2xl p-8 shadow-lg animate-fadeInUp">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-20 h-20 rounded-full shadow-md">
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mb-2 text-center">Forgot your password?</h2>
    <p class="text-center text-gray-500 text-sm mb-6 leading-relaxed">
      No worries! Just enter your registered email address and we'll send you a secure link to reset your password. 
      Make sure to check your <span class="font-semibold">Spam/Junk folder</span> if you don’t see it in your inbox.
    </p>

    <!-- Form -->
    <form id="forgotForm" method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-gray-700 mb-1 text-sm font-medium">Email address</label>
        <input type="email" name="email" id="email" required
               value="{{ old('email') }}"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 text-sm"
               placeholder="you@example.com">
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg shadow-md transition transform hover:scale-105 font-medium">
        Send Reset Link
      </button>
    </form>

    <div class="text-center text-gray-500 text-sm mt-6">
      Remember your password? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
    </div>

    <!-- Optional Info Footer -->
    <p class="text-center text-gray-400 text-xs mt-6">
      Bantayan 911 &copy; {{ date('Y') }} — Stay safe & secure.
    </p>
  </div>

  <script>
    document.getElementById("forgotForm").addEventListener("submit", function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Send Reset Link?',
        text: "We’ll send a reset link to your email.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send it'
      }).then((result) => {
        if (result.isConfirmed) {
          e.target.submit();
        }
      });
    });

    // SweetAlert messages from Laravel session
    @if (session('status'))
      Swal.fire({
        icon: 'success',
        title: 'Email Sent!',
        text: "{{ session('status') }}",
        confirmButtonColor: '#2563eb'
      });
    @endif

    @if ($errors->any())
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ $errors->first() }}",
        confirmButtonColor: '#2563eb'
      });
    @endif
  </script>

</body>
</html>
