<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Bantayan User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Lucide -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      background-color: rgb(181, 202, 199);
      font-family: 'Segoe UI', sans-serif;
    }

    .container-box {
      max-width: 700px;
      margin: 3rem auto;
      background-color: #fff;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .form-label {
      font-weight: 500;
      color: #1f2937;
    }

    .form-control {
      border-radius: 8px;
    }

    h4 {
      color: #1d4ed8;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <div class="container-box">
    <h4 class="mb-4"><i data-lucide="edit-3" class="me-2"></i>Edit User</h4>

    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Whoops!</strong> Please fix the following errors:
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('bantayan.users.update', $user->id) }}">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
      </div>

      

      <div class="d-flex justify-content-between">
        <a href="{{ route('bantayan.users.index') }}" class="btn btn-secondary">
          <i data-lucide="arrow-left" class="me-1" style="width: 16px;"></i> Back
        </a>
        <button type="submit" class="btn btn-primary">
          <i data-lucide="save" class="me-1" style="width: 16px;"></i> Save Changes
        </button>
      </div>
    </form>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
