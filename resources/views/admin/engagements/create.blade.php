<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Post Engagement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Inter', sans-serif;
    }
    .form-section {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }
    .form-label {
      font-weight: 600;
    }
    .form-control:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="form-section animate__animated animate__fadeInUp">
        <h2 class="mb-4 text-center">Post New Engagement</h2>

        <form method="POST" action="{{ route('admin.engagements.store') }}">
          @csrf

          <div class="mb-3">
            <label for="title" class="form-label">Engagement Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Community Meeting" required>
          </div>

          <div class="mb-3">
            <label for="host" class="form-label">Hosted By</label>
            <input type="text" name="host" id="host" class="form-control" placeholder="e.g. LGU Bantayan" required>
          </div>

          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Write brief details about the engagement..." required></textarea>
          </div>

          <div class="text-end">
            <a href="{{ route('admin.engagements.index') }}" class="btn btn-secondary">Cancel</a>
           <button type="button" class="btn btn-primary" onclick="confirmPost()">Post Engagement</button>

          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function confirmPost() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to post this engagement?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, post it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('form').submit();
      }
    });
  }
</script>
<script>
  // Set min date to today for both start and end date
  document.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').setAttribute('min', today);
    document.getElementById('end_date').setAttribute('min', today);
  });

  function confirmPost() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to post this engagement?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, post it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('form').submit();
      }
    });
  }
</script>

</body>
</html>
