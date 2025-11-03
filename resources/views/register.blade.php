<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"/>

</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">

  <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden">
    <div class="grid md:grid-cols-2">

      <!-- Left Form Section -->
      <div class="p-10 space-y-6">
        <h2 class="text-3xl font-bold text-indigo-400 text-center">Create Your Account</h2>

        <!-- Display validation errors -->
        @if ($errors->any())
          <div class="bg-red-600 text-sm p-3 rounded-lg">
            <ul class="list-disc pl-4">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4" onsubmit="return checkTermsAgreement()">
          @csrf

          <!-- Name -->
          <div>
            <label for="name" class="block text-sm mb-1">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              required maxlength="100"
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm mb-1">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              required
              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Location -->
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

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm mb-1">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" required minlength="12"
                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <button type="button" id="togglePassword"
                class="absolute right-2 top-2.5 text-gray-400 hover:text-indigo-500">👁️</button>
            </div>
            <p id="passwordHelp" class="text-gray-400 text-xs mt-1">
              Minimum 12 characters, including uppercase, lowercase, numbers, and symbols.
            </p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm mb-1">Confirm Password</label>
            <div class="relative">
              <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <button type="button" id="toggleConfirm"
                class="absolute right-2 top-2.5 text-gray-400 hover:text-indigo-500">👁️</button>
            </div>
          </div>

          <!-- Terms & Conditions -->
          <div class="flex items-start space-x-2">
            <input type="checkbox" id="terms" name="terms"
              class="mt-1 text-indigo-500 border-gray-600 focus:ring-indigo-500">
            <label for="terms" class="text-sm text-gray-300">
              I agree to the
              <button type="button" onclick="showTerms()" class="text-indigo-400 hover:text-indigo-300 underline">
                Terms & Conditions
              </button>.
            </label>
          </div>

          <!-- Submit -->
          <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg font-semibold transition transform hover:scale-105">
            Register
          </button>

          <p class="text-center text-sm mt-4 text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Login here</a>
          </p>
        </form>
      </div>

   <!-- Right Info Section -->
<div class="hidden md:flex flex-col items-center justify-center bg-gray-900 p-8 text-center animate__animated animate__fadeInRight">
  <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Logo"
    class="w-32 h-32 rounded-full mb-4 border border-gray-700 shadow-lg animate__animated animate__fadeIn animate__delay-1s">
  
  <h3 class="text-2xl font-bold mb-2 text-white animate__animated animate__fadeInDown animate__delay-1s">
    Welcome to Bantayan 911
  </h3>
  
  <p id="typing-info" class="text-gray-400 text-sm max-w-xs mt-2"></p>
</div>

<!-- Typing Effect Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const text = "Join our platform to stay updated and report emergencies in real time. Access vital public services and receive alerts straight from your local responders. Bantayan 911 empowers every citizen to take part in building a safer community. Share information, connect with others, and make your voice heard in times of need. Together, we can create a stronger, smarter, and more resilient Bantayan.";

  const typingElement = document.getElementById("typing-info");
  let index = 0;

  function type() {
    if (index < text.length) {
      typingElement.textContent += text.charAt(index);
      index++;
      setTimeout(type, 20); 
    }
  }
  setTimeout(type, 1000);
});
</script>


    </div>
  </div>

  <!-- Scripts -->
  <script>
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const passwordHelp = document.getElementById('passwordHelp');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirm = document.getElementById('toggleConfirm');
    let popupShown = false;

    // Show/hide password
    togglePassword.addEventListener('click', () => {
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    });
    toggleConfirm.addEventListener('click', () => {
      confirmInput.type = confirmInput.type === 'password' ? 'text' : 'password';
    });

    // Password strength check
    passwordInput.addEventListener('input', () => {
      const val = passwordInput.value;
      const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;
      if (strongPassword.test(val)) {
        passwordHelp.textContent = "Strong password ✅";
        passwordHelp.classList.replace("text-gray-400", "text-green-500");
        passwordHelp.classList.remove("text-red-500");
      } else {
        passwordHelp.textContent = "Weak password ❌ Minimum 12 chars, uppercase, lowercase, number, symbol.";
        passwordHelp.classList.replace("text-green-500", "text-red-500");
        passwordHelp.classList.add("text-gray-400");
      }
    });
// 💡 Google-style Password Suggestion Popup
passwordInput.addEventListener('focus', () => {
  if (popupShown) return;
  popupShown = true;

  const suggested = generateStrongPassword(16);
  
  Swal.fire({
    title: '<span class="text-indigo-400 font-semibold text-lg">Strong Password Suggestion</span>',
    html: `
      <div class="flex flex-col items-center justify-center space-y-3 text-gray-200">
        <input 
          type="text" 
          id="suggestedPassword" 
          class="w-full text-center bg-gray-800 border border-gray-700 text-white px-3 py-2 rounded-lg font-mono text-sm tracking-wider select-all"
          value="${suggested}" 
          readonly>
        <p class="text-xs text-gray-400 italic">Auto-generated for strong security — copy & use if you’d like.</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Use Password',
    cancelButtonText: 'Cancel',
    focusConfirm: false,
    background: '#1f2937', // Tailwind gray-800
    color: '#E5E7EB', // gray-200
    width: 400,
    padding: '1.5rem',
    confirmButtonColor: '#6366F1', // Indigo
    cancelButtonColor: '#4B5563', // Gray
    customClass: {
      popup: 'rounded-2xl shadow-lg border border-gray-700',
      confirmButton: 'px-4 py-2 text-sm font-semibold rounded-lg',
      cancelButton: 'px-4 py-2 text-sm font-medium rounded-lg',
    },
    didOpen: () => {
      const input = document.getElementById('suggestedPassword');
      input.select();
    },
    preConfirm: () => document.getElementById('suggestedPassword').value
  }).then(result => {
    if (result.isConfirmed) {
      passwordInput.value = result.value;
      passwordInput.dispatchEvent(new Event('input')); // trigger strength validation

      // Success copy notification
      navigator.clipboard.writeText(result.value).then(() => {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'Password copied to clipboard',
          showConfirmButton: false,
          timer: 2000,
          background: '#111827',
          color: '#E5E7EB',
          customClass: {
            popup: 'rounded-xl shadow-md border border-gray-700'
          }
        });
      });
    }
  });
});

// 🔐 Generate Strong Random Password (optimized & readable)
function generateStrongPassword(length = 16) {
  const charset = {
    upper: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
    lower: "abcdefghijklmnopqrstuvwxyz",
    number: "0123456789",
    symbol: "!@#$%^&*()_+[]{}|;:,.<>?"
  };
  let password = "";
  
  // Ensure at least one of each type
  password += charset.upper[Math.floor(Math.random() * charset.upper.length)];
  password += charset.lower[Math.floor(Math.random() * charset.lower.length)];
  password += charset.number[Math.floor(Math.random() * charset.number.length)];
  password += charset.symbol[Math.floor(Math.random() * charset.symbol.length)];

  const allChars = Object.values(charset).join('');
  for (let i = 4; i < length; i++) {
    password += allChars[Math.floor(Math.random() * allChars.length)];
  }

  // Shuffle for randomness
  return password.split('').sort(() => Math.random() - 0.5).join('');
}

   // Show Terms popup (modern and optimized)
function showTerms() {
  Swal.fire({
    title: '<span class="text-indigo-400 text-2xl font-semibold">Terms & Conditions</span>',
    html: `
      <div class="text-left text-gray-200 text-sm leading-relaxed space-y-3 max-h-60 overflow-y-auto px-2">
        <p><strong class="text-indigo-400">1.</strong> You agree to provide <span class="font-medium">accurate and truthful information</span> when creating and managing your account.</p>
        <p><strong class="text-indigo-400">2.</strong> You must not use this platform for <span class="font-medium">unauthorized, harmful, or illegal</span> activities.</p>
        <p><strong class="text-indigo-400">3.</strong> All personal data is handled in accordance with our <span class="font-medium">Privacy Policy</span> and applicable data protection laws.</p>
        <p><strong class="text-indigo-400">4.</strong> Bantayan 911 may contact you for <span class="font-medium">emergency alerts, verification, or updates</span> regarding your account.</p>
        <p><strong class="text-indigo-400">5.</strong> Continued use of this platform constitutes <span class="font-medium">acceptance</span> of these terms and future updates.</p>
        <p class="border-t border-gray-700 pt-2 text-gray-400 text-xs italic">
          Updated as of <span class="text-indigo-400 font-semibold">${new Date().toLocaleDateString()}</span>
        </p>
      </div>
    `,
    width: 550,
    padding: '1.5rem',
    background: '#1f2937', // Tailwind's gray-800
    color: '#E5E7EB', // gray-200
    confirmButtonText: 'I Understand & Agree',
    confirmButtonColor: '#6366F1', // indigo-500
    showClass: {
      popup: 'animate__animated animate__fadeInDown animate__faster'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp animate__faster'
    },
  });
}


    // Prevent submit if terms not checked
    function checkTermsAgreement() {
      const checkbox = document.getElementById('terms');
      if (!checkbox.checked) {
        Swal.fire({
          icon: 'warning',
          title: 'Agreement Required',
          text: 'You must agree to the Terms & Conditions before registering.',
          confirmButtonColor: '#6366F1'
        });
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
