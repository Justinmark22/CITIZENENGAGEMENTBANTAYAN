<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Bantayan 911</title>

  <!-- Transparent favicon -->
  <link rel="icon" href="data:image/png;base64,iVBORw0KGgo=">

  <!-- Tailwind & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide-icons/dist/umd/lucide.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Google reCAPTCHA v3 -->
  <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

  <style>
    body { font-family: 'Roboto', sans-serif; }
    @keyframes fadeInUp { 0% {opacity:0; transform: translateY(30px);} 100% {opacity:1; transform: translateY(0);} }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    .disabled { opacity: 0.6; pointer-events: none; }
  </style>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-4xl bg-gray-800 rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

   <!-- Logo & Description -->
<div class="flex flex-col justify-center items-center p-8 lg:p-12 text-center lg:text-left animate__animated animate__fadeInUp">
  <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Citizen Logo"
       class="w-24 h-24 rounded-full shadow-lg mb-4 lg:mb-6 animate__animated animate__fadeIn animate__delay-1s">
  
  <h1 class="text-3xl font-bold text-white mb-2 animate__animated animate__fadeInDown animate__delay-1s">
    Bantayan 911
  </h1>
  
  <p id="typing-text" class="text-gray-300 text-sm lg:text-base mt-2"></p>
</div>

<!-- Typing Effect Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const text = "A platform designed to strengthen community interaction and empower citizens through inclusive digital services.";
  const typingElement = document.getElementById("typing-text");
  let index = 0;

  function type() {
    if (index < text.length) {
      typingElement.textContent += text.charAt(index);
      index++;
      setTimeout(type, 40); // typing speed (milliseconds)
    }
  }

  // small delay before typing starts
  setTimeout(type, 800);
});
</script>


    <!-- Login Form -->
    <div class="p-8 lg:p-12 animate-fadeInUp">
      <h2 class="text-2xl font-bold text-white mb-6 text-center lg:text-left">Sign in to your account</h2>

      @if ($errors->any())
        <div class="text-red-500 text-sm mb-4">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <!-- Input fields -->
        <fieldset id="loginFieldset">
          <div>
            <label for="email" class="block text-gray-300 text-sm mb-1">Email</label>
            <input type="email" id="email" name="email" required
                   value="{{ old('email') }}"
                   class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   oninput="this.value = this.value.replace(/[^A-Za-z0-9@.]/g, '')"
                   title="Only letters, numbers, @, and . are allowed">
          </div>

          <div>
            <label for="password" class="block text-gray-300 text-sm mb-1">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" required
                     class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                     title="Use at least 12 characters, with uppercase, lowercase, numbers, and symbols.">
              <button type="button" id="togglePassword"
                      class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                           c4.478 0 8.268 2.943 9.542 7
                           -1.274 4.057-5.064 7-9.542 7
                           -4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <p id="passwordHelp" class="text-gray-400 text-xs mt-1">
              Use at least 12 characters, with uppercase, lowercase, numbers, and symbols.
            </p>
          </div>

          <div class="flex flex-col md:flex-row md:justify-between md:items-center text-sm text-gray-300 mt-2">
            <label class="inline-flex items-center gap-2 mb-2 md:mb-0">
              <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-500">
              Remember me for a week
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-400 hover:underline">Forgot Password?</a>
          </div>
        </fieldset>

        <!-- reCAPTCHA -->
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

        <!-- Submit -->
        <button id="loginBtn" type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
          Continue
        </button>

        <p class="text-center text-gray-400 text-sm mt-2">
          Don't have an account? <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">Register here</a>
        </p>
      </form>
    </div>
  </div>
<script>
const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");
const loginForm = document.getElementById("loginForm");
const loginFieldset = document.getElementById("loginFieldset");
const loginBtn = document.getElementById("loginBtn");

// Load attempts and lockout info from localStorage
let attempts = parseInt(localStorage.getItem("login_attempts") || "0");
let lockoutUntil = parseInt(localStorage.getItem("lockout_until") || "0");

// Toggle password visibility
togglePassword.addEventListener("click", () => {
  const type = passwordInput.type === "password" ? "text" : "password";
  passwordInput.type = type;
  togglePassword.classList.toggle("text-indigo-500");
});

// Disable form
function disableForm() {
  loginFieldset.disabled = true;
  loginBtn.disabled = true;
}

// Enable form
function enableForm() {
  loginFieldset.disabled = false;
  loginBtn.disabled = false;
  loginBtn.textContent = "Continue";
}

// Lockout countdown
let countdownInterval;
function startCountdown() {
  const now = Date.now();
  let secondsLeft = Math.ceil((lockoutUntil - now) / 1000);
  disableForm();
  loginBtn.textContent = `Locked. Try again in ${secondsLeft}s`;

  countdownInterval = setInterval(() => {
    secondsLeft--;
    if (secondsLeft <= 0) {
      clearInterval(countdownInterval);
      localStorage.removeItem("lockout_until");
      localStorage.removeItem("login_attempts");
      attempts = 0;
      enableForm();
    } else {
      loginBtn.textContent = `Locked. Try again in ${secondsLeft}s`;
    }
  }, 1000);
}

// Check lockout on page load
function checkLockout() {
  const now = Date.now();
  if (lockoutUntil && now < lockoutUntil) {
    Swal.fire({
      icon: 'error',
      title: 'Account Locked',
      text: 'Too many failed login attempts.',
      allowOutsideClick: false,
      allowEscapeKey: false,
    });
    startCountdown();
    return true;
  } else if (lockoutUntil && now >= lockoutUntil) {
    localStorage.removeItem("lockout_until");
    localStorage.removeItem("login_attempts");
    attempts = 0;
  }
  return false;
}

// Initial lockout check
checkLockout();

// Handle Laravel login errors
const loginErrors = @json($errors->any());
const loggedInStatus = @json(session('status') === 'logged_in');

if (loginErrors) {
  // Increment attempts
  attempts = (attempts || 0) + 1;
  localStorage.setItem("login_attempts", attempts);

  // Lock account after 3 failed attempts
  if (attempts >= 3) { // Lock after 3 attempts
    lockoutUntil = Date.now() + 60 * 1000; // 60 seconds = 1 minute
    localStorage.setItem("lockout_until", lockoutUntil);

    Swal.fire({
      icon: 'error',
      title: 'Account Locked',
      text: 'Too many failed attempts. Please wait 1 minute before trying again.',
    });

    startCountdown(); // Start the live countdown on the login button
  }
}

// Reset attempts after successful login
if (loggedInStatus) {
  localStorage.removeItem("login_attempts");
  localStorage.removeItem("lockout_until");
}

// Prevent submission if locked
loginForm.addEventListener("submit", function(e) {
  const now = Date.now();
  if (lockoutUntil && now < lockoutUntil) {
    e.preventDefault();
    Swal.fire({
      icon: 'error',
      title: 'Account Locked',
      text: 'Too many failed login attempts. Please wait.',
    });
  }
});

// reCAPTCHA v3 token
grecaptcha.ready(function() {
  grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', { action: 'login' }).then(function(token) {
    document.getElementById('g-recaptcha-response').value = token;
  });
});
</script>


</body>
</html>
