<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Bantayan 911</title>

  <!-- Tailwind & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

  <style>
    body { font-family: 'Roboto', sans-serif; }
    .disabled { opacity: 0.6; pointer-events: none; }
  </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

<div class="w-full max-w-4xl bg-gray-800 rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

  <!-- Logo & Description -->
  <div class="flex flex-col justify-center items-center p-8 lg:p-12 text-center lg:text-left">
    <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo" class="w-24 h-24 rounded-full shadow-lg mb-4 lg:mb-6">
    <h1 class="text-3xl font-bold text-white mb-2">Bantayan 911</h1>
    <p class="text-gray-300 text-sm lg:text-base">
      A platform designed to strengthen community interaction and empower citizens through inclusive digital services.
    </p>
  </div>

  <!-- Login Form -->
  <div class="p-8 lg:p-12">
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
      <fieldset id="loginFieldset">
        <div>
          <label for="email" class="block text-gray-300 text-sm mb-1">Email</label>
          <input type="email" id="email" name="email" required
                 value="{{ old('email') }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="password" class="block text-gray-300 text-sm mb-1">Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-500">
              Show
            </button>
          </div>
        </div>

        <div class="flex justify-between items-center text-sm text-gray-300 mt-2">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-500"> Remember me
          </label>
          <a href="{{ route('password.request') }}" class="text-indigo-400 hover:underline">Forgot Password?</a>
        </div>
      </fieldset>

      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

      <button id="loginBtn" type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
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

  let attempts = parseInt(localStorage.getItem("login_attempts") || "0");
  let lockoutUntil = parseInt(localStorage.getItem("lockout_until") || "0");

  // Toggle password visibility
  togglePassword.addEventListener("click", () => {
    const type = passwordInput.type === "password" ? "text" : "password";
    passwordInput.type = type;
  });

  // Disable form
  function disableForm() {
    loginFieldset.disabled = true;
    document.getElementById("loginBtn").disabled = true;
  }

  // Enable form
  function enableForm() {
    loginFieldset.disabled = false;
    document.getElementById("loginBtn").disabled = false;
  }

  // Lockout logic
  function startLockout(seconds = 60) {
    const until = Date.now() + seconds * 1000;
    localStorage.setItem("lockout_until", until);
    disableForm();

    let timerInterval;
    Swal.fire({
      icon: 'error',
      title: 'Account Locked',
      html: `Too many failed attempts. Try again in <b>${seconds}</b> seconds.`,
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => {
        const b = Swal.getHtmlContainer().querySelector('b');
        timerInterval = setInterval(() => {
          const remaining = Math.ceil((until - Date.now()) / 1000);
          if (remaining <= 0) {
            clearInterval(timerInterval);
            Swal.close();
            localStorage.removeItem("lockout_until");
            localStorage.removeItem("login_attempts");
            attempts = 0;
            enableForm();
          } else {
            b.textContent = remaining;
          }
        }, 500);
      }
    });
  }

  // Check on page load
  if (lockoutUntil && Date.now() < lockoutUntil) {
    const remaining = Math.ceil((lockoutUntil - Date.now()) / 1000);
    startLockout(remaining);
  }

  // Handle Laravel errors
  const loginErrors = @json($errors->any());

  if (loginErrors) {
    attempts++;
    localStorage.setItem("login_attempts", attempts);
    if (attempts >= 3) {
      startLockout(60);
    }
  }

  // reCAPTCHA
  grecaptcha.ready(function() {
    grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', { action: 'login' }).then(function(token) {
      document.getElementById('g-recaptcha-response').value = token;
    });
  });
</script>

</body>
</html>
