<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">

  <div class="bg-gray-800 p-8 rounded-2xl w-full max-w-md text-center shadow-lg">
    <h2 class="text-white text-2xl font-bold mb-4">Verify Your Login</h2>
    <p class="text-gray-400 mb-6">Enter the 6-digit OTP sent to your email.</p>

    @if ($errors->any())
      <div class="text-red-400 text-sm mb-4">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('otp.verify') }}" method="POST" class="space-y-4">
      @csrf
      <input type="text" name="otp" maxlength="6" required
             class="w-full text-center text-xl tracking-widest px-4 py-3 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-indigo-500"
             placeholder="Enter OTP">
      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
        Verify OTP
      </button>
    </form>
  </div>

</body>
</html>
