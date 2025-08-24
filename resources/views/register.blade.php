<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Citizen Engagement Platform</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #111827;
      color: white;
      animation: fadeInBody 1s ease-in-out;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from {
        transform: translateY(30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .form-animate {
      animation: slideUp 0.8s ease-out;
    }

    .form-control {
      background-color: #374151;
      border-color: #4b5563;
      color: white;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      background-color: #374151;
      border-color: #6366f1;
      color: white;
      box-shadow: none;
    }

    .border-custom {
      border-color: #4b5563 !important;
    }

    .text-muted-custom {
      color: #9ca3af !important;
    }

    .btn-indigo {
      background-color: #6366f1;
      transition: all 0.3s ease;
    }

    .btn-indigo:hover {
      background-color: #4f46e5;
      transform: scale(1.02);
    }

    .logo-animate {
      animation: slideUp 1s ease-in-out;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">
  <div class="container">
    <div class="row bg-dark rounded-4 overflow-hidden shadow-lg form-animate">
      <!-- Left Section -->
      <div class="col-lg-6 p-5">
        <div class="text-center mb-4">
          <h1 class="fw-bold">Create an Account</h1>
        </div>

        <div class="d-flex align-items-center text-muted-custom mb-4">
          <div class="flex-grow-1 border-top border-custom"></div>
          <div class="mx-3 small">Sign up below</div>
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
<form method="POST" action="{{ route('register.submit') }}">
  @csrf

  <div class="mb-3">
    <label for="name" class="form-label small">Full Name</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}" 
           required class="form-control"
           oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
           maxlength="100"
           title="Only letters and spaces allowed"/>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label small">Email Address</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" 
           required class="form-control"
           maxlength="255"
           title="Enter a valid email address"/>
  </div>

  <div class="mb-3">
    <label for="location" class="form-label small">Municipality</label>
    <select id="location" name="location" required class="form-control">
      <option value="" disabled selected>Select your Municipality</option>
      <option value="Bantayan" {{ old('location') == 'Bantayan' ? 'selected' : '' }}>Bantayan</option>
      <option value="Santa.Fe" {{ old('location') == 'Santa.Fe' ? 'selected' : '' }}>Santa.Fe</option>
      <option value="Madridejos" {{ old('location') == 'Madridejos' ? 'selected' : '' }}>Madridejos</option>
    </select>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label small">Password</label>
    <input type="password" id="password" name="password" required class="form-control"
           minlength="8"
           pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*?&]).{8,}$"
           title="At least 8 characters with uppercase, lowercase, number, and special character"/>
  </div>

  <div class="mb-3">
    <label for="password_confirmation" class="form-label small">Confirm Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control"/>
  </div>

  <button type="submit" class="btn btn-indigo w-100 text-white">Register</button>

  <div class="text-center small mt-3">
    Already have an account?
    <a href="{{ route('login') }}" class="text-primary text-decoration-none">Login here</a>
  </div>
</form>
  </div>

      <!-- Right Section -->
      <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center align-items-center bg-black p-5 text-center logo-animate">
        <h2 class="h4 fw-bold mb-3 text-white">A Platform with Purpose</h2>
        <p class="text-muted-custom mb-4">
          Collaborate with your barangay and contribute to decision-making by participating in surveys, reporting issues, and attending events.
        </p>
        <img src="{{ asset('images/citizen.png') }}" alt="Platform Preview"
             class="img-fluid rounded-circle border border-custom shadow"
             style="width: 160px; height: 160px; object-fit: cover;" />
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
