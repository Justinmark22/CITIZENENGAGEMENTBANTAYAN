<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Announcement</title>

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #eef2f7, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
      min-height: 100vh;
    }

    .container {
      display: flex;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
      max-width: 1100px;
      width: 100%;
      overflow: hidden;
    }

    .left-panel {
      background: #f9fafb;
      padding: 40px;
      width: 50%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-right: 1px solid #e5e7eb;
    }

    .left-panel img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      margin-bottom: 20px;
    }

    .definition {
      font-size: 0.95rem;
      color: #4b5563;
      margin-bottom: 20px;
      text-align: center;
    }

    .right-panel {
      padding: 40px;
      width: 50%;
    }

    .card-title {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 6px;
      color: #2d3748;
    }

    .card-subtitle {
      font-size: 1rem;
      color: #718096;
      margin-bottom: 24px;
    }

    .form-group {
      margin-bottom: 22px;
      position: relative;
    }

    .form-group .material-icons {
      position: absolute;
      top: 50%;
      left: 14px;
      transform: translateY(-50%);
      color: #9ca3af;
    }

    input, textarea, select {
      width: 100%;
      padding: 12px 14px 12px 44px;
      font-size: 1rem;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      background: #f9fafb;
      transition: 0.3s all;
    }

    input:focus, textarea:focus, select:focus {
      background: #ffffff;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
      outline: none;
    }

    textarea {
      min-height: 120px;
      resize: vertical;
    }

    .char-counter {
      font-size: 0.8rem;
      color: #9ca3af;
      text-align: right;
      margin-top: 6px;
    }

    .btn-primary {
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(90deg, #3b82f6, #2563eb);
      color: #fff;
      border: none;
      padding: 14px 24px;
      font-size: 1rem;
      font-weight: 500;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      background: linear-gradient(90deg, #2563eb, #1d4ed8);
    }

    .loader {
      border: 3px solid #d1d5db;
      border-top: 3px solid #fff;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .error-message {
      color: #dc2626;
      font-size: 0.85rem;
      margin-top: 6px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left-panel, .right-panel {
        width: 100%;
        padding: 30px;
        border-right: none;
      }

      .left-panel {
        border-bottom: 1px solid #e5e7eb;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Left Info Panel -->
    <div class="left-panel">
      <img src="/images/citizen.png" alt="Logo">
      <div class="definition">
        <strong>Announcement:</strong><br>
        A message from local officials or authorized staff to inform, alert, or engage citizens.
      </div>
      <div class="definition">
        <strong>Location Tag:</strong><br>
        Helps route announcements to the correct barangay or town.
      </div>
      <div class="definition">
        <strong>Message Limit:</strong><br>
        Max 500 characters to keep posts concise and readable.
      </div>
    </div>

    <!-- Right Form Panel -->
    <div class="right-panel">
      <h1 class="card-title">Add Announcement</h1>
      <p class="card-subtitle">Create a new engagement post for the community</p>

      <form method="POST" action="{{ route('admin.announcements.store') }}" id="announcementForm">
        @csrf

        <div class="form-group">
          <span class="material-icons">title</span>
          <input type="text" name="title" placeholder="Title" required value="{{ old('title') }}">
          @error('title') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <span class="material-icons">message</span>
          <textarea name="message" placeholder="Message" maxlength="500" required>{{ old('message') }}</textarea>
          <div class="char-counter" id="messageCounter">0 / 500</div>
          @error('message') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <!-- Time Frame (Start & End Date) -->
<div class="form-group">
  <span class="material-icons">event</span>
  <label for="start_date">Start Date</label>
  <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}">
  @error('start_date') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
  <span class="material-icons">event_available</span>
  <label for="end_date">End Date</label>
  <input type="date" name="end_date" id="end_date" required value="{{ old('end_date') }}">
  @error('end_date') <div class="error-message">{{ $message }}</div> @enderror
</div>


        <div class="form-group">
          <span class="material-icons">location_on</span>
          <select name="location" required>
            <option value="">Select Location</option>
            <option value="Bantayan" {{ old('location')=='Bantayan'?'selected':'' }}>Bantayan</option>
            <option value="Santa.Fe" {{ old('location')=='Santa.Fe'?'selected':'' }}>Sta.Fe</option>
            <option value="Madridejos" {{ old('location')=='Madridejos'?'selected':'' }}>Madridejos</option>
          </select>
          @error('location') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-primary">
          <span id="submitText">Publish</span>
          <span id="loading" style="display:none;"><div class="loader"></div></span>
        </button>
      </form>
    </div>
  </div>

 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('announcementForm');
    const msg = form.message;
    const counter = document.getElementById('messageCounter');
    const submitText = document.getElementById('submitText');
    const loading = document.getElementById('loading');

    // Character count
    msg.addEventListener('input', () => {
      counter.textContent = `${msg.value.length} / 500`;
    });

    // 🔒 Disable past dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').setAttribute('min', today);
    document.getElementById('end_date').setAttribute('min', today);

    // Confirm before form submit
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Confirm Submission',
        text: "Are you sure you want to post this announcement?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Publish',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d1d5db',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-secondary'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          submitText.textContent = '';
          loading.style.display = 'inline-block';
          form.submit();
        }
      });
    });

    // Success alert after submission
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Announcement Posted',
        text: @json(session('success')),
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'Go to List',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      }).then(() => {
        window.location.href = "{{ route('admin.announcements.index') }}";
      });
    @endif
  });
</script>

</body>
</html>
