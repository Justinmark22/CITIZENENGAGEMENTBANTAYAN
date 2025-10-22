<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bantayan 911</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide/dist/lucide.min.js"></script>

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      scroll-behavior: smooth;
    }

    /* Hero overlay */
    .hero-overlay {
      background: linear-gradient(to bottom right, rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://www.toptal.com/designers/subtlepatterns/patterns/lines.png');
      background-repeat: repeat;
    }

    .hero-text-shadow {
      text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
    }
  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <img src="{{ asset('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png') }}" alt="Logo" class="rounded-circle" width="50" height="50">
      <span class="fw-bold fs-4">Bantayan 911</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">FAQs</a></li>
      </ul>
      <div class="d-flex ms-lg-3 gap-2">
        <a href="{{ url('/login') }}" class="btn btn-outline-primary">Log In</a>
        <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-overlay text-white d-flex align-items-center" style="height: 90vh; position: relative;">
  <div class="container text-center text-lg-start position-relative" style="z-index: 2;">
    <h2 class="fs-3 text-warning mb-2">Welcome to Bantayan Island</h2>
    <h1 class="display-4 fw-bold hero-text-shadow mb-4">
      Strengthening Citizen Engagement Across Communities
    </h1>
    <p class="fs-5 mb-4 hero-text-shadow">
      Discover a <span class="fw-semibold text-warning">transparent digital platform</span> that connects citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
    </p>
    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
      <a href="#services" class="btn btn-warning btn-lg text-dark fw-bold">Explore Services</a>
      <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg fw-bold">Contact Us</a>
    </div>
  </div>

  <!-- Image Carousel -->
  <div id="heroCarousel" class="carousel slide position-absolute top-0 end-0 bottom-0 start-50 translate-middle-x" style="width: 50%; height: 90%;">
    <div class="carousel-inner h-100 rounded shadow-lg border border-white-20">
      <div class="carousel-item active h-100">
        <img src="{{ asset('images/bantayan.png') }}" class="d-block w-100 h-100 object-fit-cover" alt="Bantayan">
      </div>
      <div class="carousel-item h-100">
        <img src="{{ asset('images/sta.fe.png') }}" class="d-block w-100 h-100 object-fit-cover" alt="Santa Fe">
      </div>
      <div class="carousel-item h-100">
        <img src="{{ asset('images/madridejos.png') }}" class="d-block w-100 h-100 object-fit-cover" alt="Madridejos">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <!-- Left Column -->
      <div class="col-md-6">
        <div class="row g-4">
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/dis.png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Disaster Response</h5>
              <p class="text-muted mb-0">MDRRMO: Disaster Preparedness & Emergency Response</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/asd.png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Health Services</h5>
              <p class="text-muted mb-0">Accessible Care for Everyone</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/wat.png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Waste Management</h5>
              <p class="text-muted mb-0">Keeping Bantayan Clean & Safe</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/wat.png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Water Management</h5>
              <p class="text-muted mb-0">Clean Water Access for All</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-md-6">
        <div class="row g-4">
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/SAN.PNG') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Public Safety</h5>
              <p class="text-muted mb-0">Protecting Our Communities</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/as.png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Education</h5>
              <p class="text-muted mb-0">Learning & Growth Opportunities</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/asdas (2).png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Community Engagement</h5>
              <p class="text-muted mb-0">Bridging Citizens and LGUs</p>
            </div>
          </div>
          <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ asset('images/gsd (1).png') }}" class="rounded-circle shadow-lg" width="80" height="80">
            <div>
              <h5 class="fw-bold">Environmental Care</h5>
              <p class="text-muted mb-0">Preserving Natural Resources</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-light pt-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3">
        <h5 class="fw-bold">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Bantayan Updates</a></li>
          <li><a href="#" class="text-light text-decoration-none">Santa Fe Updates</a></li>
          <li><a href="#" class="text-light text-decoration-none">Madridejos Updates</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="fw-bold">Legal & Policies</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('privacy.policy') }}" class="text-light text-decoration-none">Privacy Policy</a></li>
          <li><a href="{{ route('terms.service') }}" class="text-light text-decoration-none">Terms of Service</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="fw-bold">Contact</h5>
        <p class="small">📍 Bantayan Island, Cebu<br>📧 info@citizenengage.ph<br>☎ +63 912 345 6789</p>
      </div>
      <div class="col-md-3">
        <h5 class="fw-bold">Stay Connected</h5>
        <ul class="list-unstyled small">
          <li><a href="#" class="text-light text-decoration-none">🌐 Facebook</a></li>
          <li><a href="#" class="text-light text-decoration-none">🐦 Twitter</a></li>
          <li><a href="#" class="text-light text-decoration-none">📷 Instagram</a></li>
          <li><a href="#" class="text-light text-decoration-none">▶ YouTube</a></li>
        </ul>
      </div>
    </div>
    <hr class="bg-secondary mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small pb-3">
      <p class="mb-0">&copy; 2025 Citizen Engagement Bantayan — Connecting People, Building Communities</p>
      <p class="mb-0">Powered by Local Government & Communities</p>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  lucide.createIcons();
</script>

</body>
</html>
