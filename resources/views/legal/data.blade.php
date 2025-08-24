<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Protection Guidelines | LGU Santa Fe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

  <style>
    .hero-section {
      background-image: url('/images/bantayan.png');
      background-size: cover;
      background-position: center;
    }
    .fade-in-up {
      animation: fadeInUp 1s ease-in-out both;
    }
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-white text-gray-900">

  <!-- Hero Banner -->
  <section class="relative h-96 hero-section flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="z-10 text-center animate__animated animate__fadeInDown">
      <img src="{{ asset('images/citizen.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4 rounded-full shadow-lg">
      <h1 class="text-4xl md:text-5xl font-bold">DATA PRIVACY</h1>
      <p class="text-lg mt-2">Protecting Your Information Under RA 10173</p>
    </div>
  </section>

  <!-- Content Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-6 max-w-5xl space-y-12 fade-in-up">

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Commitment to You</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
          We are committed to upholding the <strong>Data Privacy Act of 2012 (RA 10173)</strong>. This platform ensures that all personal data submitted by citizens is handled with transparency, accountability, and care.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">How We Use Your Data</h2>
        <ul class="list-disc pl-6 space-y-2 text-gray-700 text-lg">
          <li>Data is securely stored and accessed only by authorized personnel.</li>
          <li>Used only for public service: analytics, service improvement, and engagement.</li>
          <li>Never shared with third parties unless legally required or authorized.</li>
          <li>We implement technical and administrative safeguards to protect your information.</li>
        </ul>
      </div>

      <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
        <h3 class="text-xl font-semibold text-blue-700 mb-2">Contact Our Data Protection Officer</h3>
        <p class="text-gray-800 text-lg"><strong>Email:</strong> dpocitizen@.gov.ph</p>
        <p class="text-gray-800 text-lg"><strong>Office Hours:</strong> Monday – Friday, 8:00 AM – 5:00 PM</p>
      </div>

      <div class="text-center mt-8">
        <a href="{{ url('/') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium transition">
          ← Back to Home
        </a>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-12">
    <div class="container mx-auto text-center">
      <p>&copy; {{ date('Y') }} Municipality of Santa Fe. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
