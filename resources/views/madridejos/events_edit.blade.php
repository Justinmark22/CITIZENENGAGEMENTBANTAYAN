<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Event #{{ $event->id }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Event</h4>
        <span class="badge bg-light text-success">ID: {{ $event->id }}</span>
      </div>
      <div class="card-body">
        <form action="{{ route('madridejos.events_update', $event->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="title" class="form-label fw-bold">Title</label>
              <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="location" class="form-label fw-bold">Location</label>
              <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="category" class="form-label fw-bold">Category</label>
              <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $event->category) }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="event_date" class="form-label fw-bold">Date</label>
              <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date', $event->event_date) }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="event_time" class="form-label fw-bold">Time</label>
              <input type="time" name="event_time" id="event_time" class="form-control" value="{{ old('event_time', $event->event_time) }}" required>
            </div>


          <div class="d-flex justify-content-between">
            <a href="{{ route('bantayan.events') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle"></i> Update Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
