<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Announcement</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    body {
      background: linear-gradient(to right, #f8fafc, #e2e8f0);
      font-family: 'Inter', sans-serif;
    }
    .page-header {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      padding: 1.5rem;
      border-radius: 1rem 1rem 0 0;
      color: white;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    .card {
      background-color: white;
      border-radius: 1rem;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      animation: fadeInUp 0.6s ease;
    }
    .form-label {
      font-weight: 600;
      color: #374151;
    }
    .input-field {
      transition: all 0.2s ease;
    }
    .input-field:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }
    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body class="antialiased">

  <div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-3xl card animate__animated animate__fadeIn">

      <!-- Header -->
      <div class="page-header flex justify-between items-center">
        <h2 class="text-xl font-bold flex items-center gap-2">
          <i class="bi bi-megaphone text-white"></i> Edit Announcement
        </h2>
        <a href="{{ route('admin.announcements.index') }}"
           class="text-sm bg-white/20 px-3 py-1 rounded-md hover:bg-white/30 transition">
           ← Back to List
        </a>
      </div>

      <!-- Form Body -->
      <div class="p-6 bg-white">
        <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}">
          @csrf
          @method('PUT')

          <!-- Title -->
          <div class="mb-5">
            <label for="title" class="form-label block mb-2">Title</label>
            <input
              type="text"
              name="title"
              id="title"
              value="{{ old('title', $announcement->title) }}"
              class="w-full rounded-md border border-gray-300 px-4 py-2 input-field"
              required>
            @error('title')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Message -->
          <div class="mb-5">
            <label for="message" class="form-label block mb-2">Message</label>
            <textarea
              name="message"
              id="message"
              rows="5"
              class="w-full rounded-md border border-gray-300 px-4 py-2 input-field"
              required>{{ old('message', $announcement->message) }}</textarea>
            @error('message')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Action Button -->
          <div class="flex justify-end mt-6">
            <button type="button" onclick="confirmUpdate()"
              class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md transition transform hover:scale-105">
              Update Announcement
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
  function confirmUpdate() {
    Swal.fire({
      title: 'Confirm Update',
      text: "Are you sure you want to update this announcement?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#2563eb',
      cancelButtonColor: '#9ca3af',
      confirmButtonText: 'Yes, update it',
      cancelButtonText: 'Cancel',
      background: '#f9fafb',
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('form').submit();
      }
    });
  }

  // Success alert after update
  document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: @json(session('success')),
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Back to List'
      }).then(() => {
        window.location.href = "{{ route('admin.announcements.index') }}";
      });
    @endif
  });
</script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
