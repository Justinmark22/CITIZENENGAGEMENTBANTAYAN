<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Announcement #{{ $announcement->id }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Lucide -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.272.0/dist/umd/lucide.min.js"></script>

  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }
    .form-label {
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card p-4">
      <h4 class="mb-4 text-primary">
        <i data-lucide="edit" class="me-2"></i> Edit Announcement #{{ $announcement->id }}
      </h4>
<form method="POST" action="{{ route('madridejos.announcements.update', $announcement->id) }}">
  @csrf
  @method('PUT')

  <!-- Title -->
  <div class="mb-3">
    <label for="title" class="form-label fw-semibold">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $announcement->title) }}" required>
  </div>

  <!-- Message -->
  <div class="mb-3">
    <label for="message" class="form-label fw-semibold">Message</label>
    <textarea name="message" class="form-control" id="message" rows="6" required>{{ old('message', $announcement->message ?? $announcement->body) }}</textarea>
  </div>

  <!-- Location -->
  <div class="mb-3">
    <label for="location" class="form-label fw-semibold">Location</label>
    <input type="text" name="location" class="form-control" id="location" value="{{ old('location', $announcement->location) }}" required>
  </div>

  <!-- Start Date -->
  <div class="mb-3">
    <label for="start_date" class="form-label fw-semibold">Start Date</label>
    <input type="date" name="start_date" class="form-control" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($announcement->start_date)->format('Y-m-d')) }}" required>
  </div>

  <!-- End Date -->
  <div class="mb-3">
    <label for="end_date" class="form-label fw-semibold">End Date</label>
    <input type="date" name="end_date" class="form-control" id="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($announcement->end_date)->format('Y-m-d')) }}" required>
  </div>

  <!-- Submit Button -->
  <div class="mt-4 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">
      <i data-lucide="save" class="me-1"></i> Save Changes
    </button>
  </div>
</form>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
