<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Bantayan 911</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #111827;
      color: white;
      animation: fadeInBody 1s ease-in-out;
      font-family: 'Segoe UI', sans-serif;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideFadeIn {
      0% { transform: translateY(30px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }

    .form-animate { animation: slideFadeIn 0.8s ease-out; }
    .logo-animate { animation: slideFadeIn 1s ease-out; }

    .form-control {
      background-color: #374151;
      border-color: #4b5563;
      color: white;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .form-control:focus {
      background-color: #374151;
      border-color: #6366f1;
      color: white;
      box-shadow: none;
    }

    .border-custom { border-color: #4b5563 !important; }
    .text-muted-custom { color: #9ca3af !important; }

    .btn-indigo {
      background-color: #6366f1;
      transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-indigo:hover {
      transform: scale(1.02);
      background-color: #4f46e5 !important;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">

  <div class="container">
    <div class="row bg-dark rounded-4 overflow-hidden shadow-lg flex-column flex-lg-row-reverse">
      
      <!-- Left Login Section -->
      <div class="col-lg-6 p-5 form-animate order-2 order-lg-1">
        <div class="text-center mb-4 d-lg-none">
          <img src="{{ asset('images/citizen.png') }}"
               alt="Citizen Logo"
               class="mb-3 rounded-circle shadow"
               style="height: 80px; width: 80px; object-fit: cover;">
          <h1 class="fw-bold">Bantayan 911</h1>
        </div>

        <div class="d-flex align-items-center text-muted-custom mb-4">
          <div class="flex-grow-1 border-top border-custom"></div>
          <div class="mx-3 small">Sign in here</div>
          <div class="flex-grow-1 border-top border-custom"></div>
        </div>

        @if ($errors->any())
        <div class="text-danger small mb-3">
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label small">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   required class="form-control"
                   oninput="this.value = this.value.replace(/[^A-Za-z@.]/g, '')"
                   title="Only letters, @, and . are allowed"/>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label small">Password</label>
            <div class="input-group">
              <input type="password" id="password" name="password" required class="form-control"/>
              <span id="togglePassword" class="input-group-text bg-transparent border-custom text-muted-custom" style="cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </span>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3 small">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember"/>
              <label class="form-check-label" for="remember">Remember me for a week</label>
            </div>
            <a href="" class="text-primary text-decoration-none">register here</a>
          </div>
          <button type="submit" class="btn btn-indigo w-100 text-white">Continue</button>
        </form>
      </div>

      <!-- Right Section with Logo & Description -->
      <div class="col-lg-6 p-5 text-center logo-animate order-1 order-lg-2 d-none d-lg-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('images/citizen.png') }}"
             alt="Citizen Engagement Logo"
             class="mb-3 rounded-circle shadow"
             style="height: 100px; width: 100px; object-fit: cover;">
        <h1 class="fw-bold mb-2">Bantayan 911</h1>
        <p class="text-muted-custom small mt-2 text-center">
          A platform designed to strengthen community interaction and<br>
          empower citizens through inclusive digital services.
        </p>
      </div>

    </div>
  </div>

  <script>
    document.getElementById("togglePassword").addEventListener("click", function () {
      const passwordInput = document.getElementById("password");
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
