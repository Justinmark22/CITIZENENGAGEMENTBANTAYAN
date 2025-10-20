<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Update | Santa Fe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Lucide -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
     background-color: #e2f1ef;
      padding: 2rem;
      animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
      border-color: #198754;
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .custom-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .btn-success {
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success:hover {
      background-color: #157347;
      transform: scale(1.03);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-dark d-flex align-items-center">
      <i data-lucide="plus-circle" class="me-2"></i> Post a New Update
    </h4>
    <a href="{{ route('santafe.updates') }}" class="btn btn-outline-secondary rounded-pill d-flex align-items-center">
      <i data-lucide="arrow-left" class="me-1"></i> Back
    </a>
  </div>

  <form action="{{ route('santafe.updates.store') }}" method="POST" class="custom-card animate__animated animate__fadeIn">
    @csrf

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control rounded-pill shadow-sm" placeholder="Enter update title" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Content</label>
      <textarea name="content" rows="6" class="form-control rounded-4 shadow-sm" placeholder="Write your update here..." required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Date</label>
      <input type="date" name="date" class="form-control rounded-pill shadow-sm" required>
    </div>

    <div class="mb-4">
      <label class="form-label">Location</label>
      <input type="text" class="form-control rounded-pill shadow-sm" name="location" value="Santa.Fe" readonly>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-success rounded-pill px-4 d-flex align-items-center">
        <i data-lucide="send" class="me-1"></i> Post
      </button>
    </div>
  </form>
</div>
<script>
  // Set today's date as the minimum date
  const today = new Date().toISOString().split('T')[0];
  document.querySelector('input[name="date"]').setAttribute('min', today);

  lucide.createIcons();
</script>

<script>
  lucide.createIcons();
</script>
</body>
</html>
