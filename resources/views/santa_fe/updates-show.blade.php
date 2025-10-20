<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $update->title }} | Update</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body style="background-color:rgb(181, 202, 199);font-family: 'Segoe UI'; padding: 2rem;">

<div class="container">
  <div class="mb-4">
    <a href="{{ route('santafe.updates') }}" class="btn btn-outline-secondary rounded-pill mb-3">
      <i data-lucide="arrow-left" class="me-1"></i> Back to Updates
    </a>
    <h2>{{ $update->title }}</h2>
    <p class="text-muted">{{ $update->created_at->format('F j, Y • g:i A') }}</p>
    <hr>
    <p style="white-space: pre-wrap;">{{ $update->content }}</p>
  </div>
</div>

<script>lucide.createIcons();</script>
</body>
</html>
