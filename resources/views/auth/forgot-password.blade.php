<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">
  <div class="bg-gray-800 w-full max-w-md rounded-2xl shadow-xl p-8">
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Forgot your password?</h1>
    <p class="text-gray-300 text-sm text-center mb-6">
      Enter your email and we’ll send you a link to reset your password.
    </p>

    @if (session('status'))
      <div class="bg-green-600 text-white text-sm p-3 rounded mb-4 text-center">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-red-600 text-white text-sm p-3 rounded mb-4">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-gray-300 mb-1">Email</label>
        <input type="email" name="email" required
               class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Send Reset Link
      </button>

      <p class="text-center text-gray-400 text-sm mt-4">
        <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Back to login</a>
      </p>
    </form>
  </div>
</body>
</html>
