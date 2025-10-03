{{-- resources/views/auth/passwords/reset.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Bantayan 911</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>

        {{-- Status Message --}}
        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email Address</label>
                <input id="email" type="email" 
                       name="email" value="{{ old('email', request()->email) }}" required autofocus
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">New Password</label>
                <input id="password" type="password" 
                       name="password" required
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password-confirm" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input id="password-confirm" type="password" 
                       name="password_confirmation" required
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                Reset Password
            </button>
        </form>
    </div>

</body>
</html>
