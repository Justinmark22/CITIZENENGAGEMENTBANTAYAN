<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">

  <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden">
    <div class="grid md:grid-cols-2">
      
      <!-- Left Form Section -->
      <div class="p-10 space-y-6">
        <h2 class="text-3xl font-bold text-indigo-400 text-center">Create Your Account</h2>

        @if ($errors->any())
          <div class="bg-red-600 text-sm p-3 rounded-lg">
            <ul class="list-disc pl-4">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
          @csrf

          <div>
            <label for="name" class="block text-sm mb-1">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              required maxlength="100"
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
          </div>

          <div>
            <label for="email" class="block text-sm mb-1">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              required
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <div>
            <label for="location" class="block text-sm mb-1">Municipality</label>
            <select id="location" name="location" required
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" disabled selected>Select Municipality</option>
              <option value="Bantayan">Bantayan</option>
              <option value="Santa.Fe">Santa.Fe</option>
              <option value="Madridejos">Madridejos</option>
            </select>
          </div>

          <!-- Password with Suggest Button -->
          <div class="relative">
            <label for="password" class="block text-sm mb-1">Password</label>
            <div class="flex gap-2">
              <input type="password" id="password" name="password" required
                minlength="12"
                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <button type="button" id="suggestPassword" 
                class="bg-indigo-500 hover:bg-indigo-400 text-white px-3 py-1 rounded-lg text-sm">
                Suggest
              </button>
            </div>
            <p id="passwordHelp" class="text-gray-400 text-sm mt-1">
              Minimum 12 characters, including uppercase, lowercase, numbers, and symbols.
            </p>
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg font-semibold transition transform hover:scale-105">
            Register
          </button>

          <p class="text-center text-sm mt-4 text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Login here</a>
          </p>
        </form>
      </div>

      <!-- Right Info Section -->
      <div class="hidden md:flex flex-col items-center justify-center bg-gray-900 p-8 text-center">
        <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-32 h-32 rounded-full mb-4 border border-gray-700 shadow-lg">
        <h3 class="text-2xl font-bold mb-2">Welcome to Bantayan 911</h3>
        <p class="text-gray-400 text-sm max-w-xs">
          Join our platform to stay updated, report emergencies, and help make Bantayan safer together.
        </p>
      </div>

    </div>
  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const passwordHelp = document.getElementById('passwordHelp');
    const suggestBtn = document.getElementById('suggestPassword');

    // Password strength feedback
    passwordInput.addEventListener('input', () => {
      const val = passwordInput.value;
      const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;

      if(strongPassword.test(val)) {
        passwordHelp.textContent = "Strong password ✅";
        passwordHelp.classList.replace("text-gray-400", "text-green-500");
      } else {
        passwordHelp.textContent = "Weak password ❌ Minimum 12 chars, uppercase, lowercase, number, symbol.";
        passwordHelp.classList.replace("text-green-500", "text-red-500");
      }
    });

    // ✅ Suggested random password popup
    suggestBtn.addEventListener('click', () => {
      const suggested = generateStrongPassword(16);
      Swal.fire({
        title: 'Suggested Password',
        html: `<input type="text" id="suggestedPassword" class="w-full bg-gray-700 text-white px-2 py-1 rounded" value="${suggested}">`,
        showCancelButton: true,
        confirmButtonText: 'Use Password',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
          const val = document.getElementById('suggestedPassword').value;
          return val;
        }
      }).then(result => {
        if(result.isConfirmed) {
          passwordInput.value = result.value;
          passwordInput.dispatchEvent(new Event('input')); // trigger strength check
        }
      });
    });

    // Generate strong random password
    function generateStrongPassword(length = 16) {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?";
      let pass = "";
      for(let i=0;i<length;i++){
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return pass;
    }
  </script>
</body>
</html>
