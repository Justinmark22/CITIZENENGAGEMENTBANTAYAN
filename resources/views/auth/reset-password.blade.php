<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1a73e8', // Google blue tone
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md px-8 py-10">
  <!-- Logo -->
<div class="flex justify-center mb-6">
  <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" 
       alt="Bantayan 911" 
       class="w-16 h-16 rounded-full shadow-md">
</div>


    <!-- Heading -->
    <h1 class="text-2xl font-semibold text-gray-800 text-center mb-2">Reset your password</h1>
    <p class="text-gray-500 text-sm text-center mb-6">Secure your account with a new password</p>

    <!-- Error -->
    @if ($errors->any())
      <div class="bg-red-100 text-red-700 text-sm p-3 rounded mb-4 border border-red-300">
        {{ $errors->first() }}
      </div>
    @endif

    <!-- Form -->
    <form id="resetForm" method="POST" action="{{ route('password.update') }}" class="space-y-5">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <!-- Email -->
      <div>
        <input type="email" name="email" required
               placeholder="Email"
               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" id="password" name="password" required minlength="8"
               placeholder="New password"
               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}"
               title="At least 8 characters, uppercase, lowercase, number, and special character"
               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
        <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary transition">
          👁️
        </button>
        <p id="passwordError" class="text-red-500 text-xs mt-1 hidden">
          Password must contain uppercase, lowercase, number, and special character.
        </p>
      </div>

      <!-- Confirm Password -->
      <div class="relative">
        <input type="password" id="confirmPassword" name="password_confirmation" required
               placeholder="Confirm new password"
               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
        <button type="button" id="toggleConfirm"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary transition">
          👁️
        </button>
        <p id="confirmError" class="text-red-500 text-xs mt-1 hidden">
          Passwords do not match.
        </p>
      </div>

      <!-- Suggested Password -->
      <div class="text-right">
        <button type="button" id="suggestBtn"
                class="text-primary text-sm hover:underline font-medium">
          Suggest strong password
        </button>
      </div>

      <!-- Submit -->
      <button type="submit"
              class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
        Reset Password
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-gray-500 text-xs mt-6">
      © 2025 Bantayan 911. All rights reserved.
    </p>
  </div>

  <!-- Script -->
  <script>
    const form = document.getElementById('resetForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const passwordError = document.getElementById('passwordError');
    const confirmError = document.getElementById('confirmError');
    const suggestBtn = document.getElementById('suggestBtn');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirm = document.getElementById('toggleConfirm');

    // 👁️ Toggle password visibility
    togglePassword.addEventListener('click', () => {
      password.type = password.type === 'password' ? 'text' : 'password';
      togglePassword.textContent = password.type === 'password' ? '👁️' : '🙈';
    });
    toggleConfirm.addEventListener('click', () => {
      confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
      toggleConfirm.textContent = confirmPassword.type === 'password' ? '👁️' : '🙈';
    });

    // 🔐 Suggest strong password
    suggestBtn.addEventListener('click', () => {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@$!%*?&#";
      let suggestion = "";
      for (let i = 0; i < 12; i++) suggestion += chars.charAt(Math.floor(Math.random() * chars.length));
      password.value = suggestion;
      confirmPassword.value = suggestion;
      passwordError.classList.add('hidden');
      confirmError.classList.add('hidden');
    });

    // ✅ Validation on submit
    form.addEventListener('submit', (e) => {
      const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/;
      passwordError.classList.add('hidden');
      confirmError.classList.add('hidden');

      if (!strongRegex.test(password.value)) {
        e.preventDefault();
        passwordError.classList.remove('hidden');
      } else if (password.value !== confirmPassword.value) {
        e.preventDefault();
        confirmError.classList.remove('hidden');
      }
    });
  </script>
</body>
</html>
