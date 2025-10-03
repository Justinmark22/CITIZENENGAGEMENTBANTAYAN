<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Bantayan 911</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Roboto', sans-serif; }
    @keyframes fadeInUp {
      0% {opacity:0; transform: translateY(30px);}
      100% {opacity:1; transform: translateY(0);}
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    .disabled { opacity: 0.6; pointer-events: none; }
  </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-4xl bg-gray-800 rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">
    
    <!-- Logo & Description -->
    <div class="flex flex-col justify-center items-center p-8 lg:p-12 text-center lg:text-left animate-fadeInUp">
      <img src="{{ asset('images/citizen.png') }}" alt="Citizen Logo"
           class="w-24 h-24 rounded-full shadow-lg mb-4 lg:mb-6">
      <h1 class="text-3xl font-bold text-white mb-2">Bantayan 911</h1>
      <p class="text-gray-300 text-sm lg:text-base">
        A platform designed to strengthen community interaction and empower citizens through inclusive digital services.
      </p>
    </div>

    <!-- Login & MFA Form Wrapper -->
    <div class="p-8 lg:p-12 animate-fadeInUp">

      <!-- Login Form -->
      <div id="loginWrapper">
        <h2 class="text-2xl font-bold text-white mb-6 text-center lg:text-left">Sign in to your account</h2>

        <!-- Countdown Timer (shows only when locked) -->
        <div id="countdownWrapper" class="hidden mb-4 text-center">
          <p class="text-red-400 font-semibold">
            Account locked. Please try again in <span id="countdown">60</span> seconds.
          </p>
        </div>

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
                     class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <button type="button" id="togglePassword"
                      class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
          </div>

          <div class="flex flex-col md:flex-row md:justify-between md:items-center text-sm text-gray-300">
            <label class="inline-flex items-center gap-2 mb-2 md:mb-0">
              <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-500">
              Remember me for a week
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-400 hover:underline">Forgot Password?</a>
          </div>

          <button id="loginBtn" type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
            Continue
          </button>

          <p class="text-center text-gray-400 text-sm mt-2">
            Don't have an account? <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">Register here</a>
          </p>
        </form>
      </div>

      <!-- MFA OTP Form -->
      <div id="mfaWrapper" class="hidden">
        <h2 class="text-2xl font-bold text-white mb-6 text-center lg:text-left">Enter Verification Code</h2>
        <p class="text-gray-300 mb-4">A verification code has been sent to your email. Please enter it below.</p>

        <form id="mfaForm" method="POST" action="{{ route('mfa.verify') }}" class="space-y-4">
          @csrf
          <div>
            <label for="otp" class="block text-gray-300 text-sm mb-1">OTP Code</label>
            <input type="text" id="otp" name="otp" required maxlength="6"
                   class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   title="Only numbers allowed">
          </div>

          <button type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
            Verify
          </button>

          <p class="text-center text-gray-400 text-sm mt-2">
            Didn't receive code? 
            <button type="button" id="resendOtp" class="text-indigo-400 hover:underline">Resend OTP</button>
          </p>
        </form>
      </div>

    </div>
  </div>

  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    togglePassword.addEventListener("click", () => {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
    });

    // Login Attempt Lockout + Countdown
    const loginForm = document.getElementById("loginForm");
    const loginBtn = document.getElementById("loginBtn");
    const countdownWrapper = document.getElementById("countdownWrapper");
    const countdownEl = document.getElementById("countdown");

    let attempts = parseInt(localStorage.getItem("login_attempts")) || 0;
    let lockUntil = localStorage.getItem("lock_until");

    function startCountdown(seconds) {
      countdownWrapper.classList.remove("hidden");
      let interval = setInterval(() => {
        let remaining = Math.ceil((lockUntil - Date.now()) / 1000);
        if (remaining <= 0) {
          clearInterval(interval);
          localStorage.removeItem("lock_until");
          localStorage.removeItem("login_attempts");
          countdownWrapper.classList.add("hidden");
          loginBtn.classList.remove("disabled");
          return;
        }
        countdownEl.textContent = remaining;
      }, 1000);
    }

    function checkLock() {
      if (lockUntil && Date.now() < lockUntil) {
        loginBtn.classList.add("disabled");
        startCountdown(Math.ceil((lockUntil - Date.now()) / 1000));
        return true;
      } else {
        loginBtn.classList.remove("disabled");
        countdownWrapper.classList.add("hidden");
        return false;
      }
    }

    checkLock();

    loginForm.addEventListener("submit", function (e) {
      if (checkLock()) {
        e.preventDefault();
        return;
      }

      // Simulate wrong login attempt (for demo only, Laravel should handle real auth errors)
      @if ($errors->any())
        attempts++;
        localStorage.setItem("login_attempts", attempts);

        if (attempts >= 3) {
          let lockTime = Date.now() + 60 * 1000; // 1 min lock
          localStorage.setItem("lock_until", lockTime);
          lockUntil = lockTime;
          checkLock();
          e.preventDefault();
        }
      @endif
    });

    // MFA: Show OTP form if session indicates MFA is required
    @if (session('mfa_required'))
      document.getElementById("loginWrapper").classList.add("hidden");
      document.getElementById("mfaWrapper").classList.remove("hidden");
    @endif

    // Resend OTP button
    const resendOtp = document.getElementById("resendOtp");
    resendOtp?.addEventListener("click", () => {
      fetch("{{ route('mfa.resend') }}", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
      }).then(res => res.json())
        .then(data => {
          Swal.fire({
            icon: "success",
            title: "OTP Sent!",
            text: "A new verification code has been sent to your email."
          });
        });
    });

    // Reset lock if login succeeds
    @if (session('status') === 'logged_in')
      localStorage.removeItem("login_attempts");
      localStorage.removeItem("lock_until");
    @endif
  </script>
</body>
</html>
