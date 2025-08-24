<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit User</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #e0f2fe, #f0f4f8);
      padding: 60px 20px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .wrapper {
      display: flex;
      max-width: 1000px;
      width: 100%;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .left-panel {
      width: 40%;
      background: #f9fafb;
      padding: 2rem;
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
      margin-bottom: 1.5rem;
    }

    .definition {
      font-size: 0.9rem;
      color: #374151;
      text-align: center;
      margin-bottom: 1rem;
      line-height: 1.4;
    }

    .right-panel {
      width: 60%;
      padding: 2.5rem;
    }

    h2 {
      margin-bottom: 2rem;
      color: #1e3a8a;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.75rem;
    }

    label {
      display: block;
      font-weight: 600;
      margin-top: 1.2rem;
      color: #1f2937;
      font-size: 0.95rem;
    }

    .input-group {
      position: relative;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 0.75rem;
      transform: translateY(-50%);
      color: #6b7280;
    }

    input, select {
      width: 100%;
      padding: 0.75rem 0.75rem 0.75rem 2.5rem;
      margin-top: 0.5rem;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      font-size: 1rem;
      background-color: #f9fafb;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    input:focus, select:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
      outline: none;
      background-color: #ffffff;
    }

    button {
      margin-top: 2rem;
      background: #2563eb;
      color: white;
      padding: 0.75rem 1.8rem;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    button:hover {
      background: #1d4ed8;
      transform: scale(1.03);
    }

    @media (max-width: 768px) {
      .wrapper {
        flex-direction: column;
      }

      .left-panel, .right-panel {
        width: 100%;
        padding: 2rem;
      }

      .left-panel {
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
      }
    }

    .swal2-popup {
      border-radius: 16px !important;
      font-family: 'Inter', sans-serif;
    }

    .swal2-confirm.btn-custom {
      background-color: #2563eb !important;
      color: #fff !important;
      padding: 0.6rem 1.4rem;
      border-radius: 10px;
      font-weight: 500;
      font-size: 1rem;
    }
  </style>
</head>
<body>

  <div class="wrapper">
    <!-- Left Definitions Panel -->
    <div class="left-panel">
      <img src="/images/citizen.png" alt="Logo">
      <div class="definition">
        <strong>Name:</strong><br>
        Full name of the registered user.
      </div>
      <div class="definition">
        <strong>Email:</strong><br>
        Used for system communication and login credentials.
      </div>
      <div class="definition">
        <strong>Location:</strong><br>
        Indicates the user’s barangay or area. This field is fixed for data consistency.
      </div>
    </div>

    <!-- Right Form Panel -->
    <div class="right-panel">
      <h2><i class="bi bi-pencil-square"></i> Edit User</h2>

      <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <div class="input-group">
          <i class="bi bi-person"></i>
          <input type="text" name="name" id="name" value="{{ $user->name }}" required>
        </div>

        <label for="email">Email</label>
        <div class="input-group">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" id="email" value="{{ $user->email }}" required>
        </div>

        <label for="location">Location</label>
        <div class="input-group">
          <i class="bi bi-geo-alt"></i>
          <select name="location" id="location" required disabled>
            <option value="{{ $user->location }}">{{ $user->location }}</option>
          </select>
          <input type="hidden" name="location" value="{{ $user->location }}">
        </div>

<button type="button" onclick="confirmUpdate()"><i class="bi bi-save2-fill"></i> Update</button>

      </form>
    </div>
  </div>
<script>
  function confirmUpdate() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to update this user’s information?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#2563eb',
      cancelButtonColor: '#9ca3af',
      confirmButtonText: '<i class="bi bi-check-circle"></i> Yes, update it',
      cancelButtonText: '<i class="bi bi-x-circle"></i> Cancel',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'swal2-confirm btn-custom',
        cancelButton: 'swal2-cancel btn-custom'
      },
      background: '#f9fafb'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('form').submit();
      }
    });
  }
</script>

</body>
</html>
