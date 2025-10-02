<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-md bg-gray-800 rounded-2xl p-8 shadow-lg animate-fadeInUp">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-24 h-24 rounded-full shadow-lg">
    </div>

    <h2 class="text-2xl font-bold text-white mb-4 text-center">Reset Password</h2>

    <!-- Status Message -->
    @if (session('status'))
      <div class="bg-green-500 text-white p-2 rounded mb-4 text-sm text-center">
        {{ session('status') }}
      </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-gray-300 mb-1 text-sm">Email</label>
        <input type="email" name="email" id="email" required
               class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
               placeholder="Enter your email">
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg shadow-md transition transform hover:scale-105">
        Send Password Reset Link
      </button>
    </form>

    <p class="text-center text-gray-400 text-sm mt-4">
      Back to <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Login</a>
    </p>
  </div>

</body>
</html>
