<!-- resources/views/admin/users/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 5rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1f2937;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 1rem;
            font-weight: bold;
            color: #374151;
        }

        input, select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
        }

        button {
            margin-top: 2rem;
            background-color: #2563eb;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            font-size: 14px;
            color: #4b5563;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
  <div class="container">
    <h2>Edit User</h2>

    <!-- Show Validation Errors -->
    @if ($errors->any())
      <div class="error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}">
      @csrf
      @method('PUT')

      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>

      <label for="location">Location</label>
      <select id="location" name="location" required>
        <option value="Bantayan" {{ old('location', $user->location) == 'Bantayan' ? 'selected' : '' }}>Bantayan</option>
        <option value="Santa.Fe" {{ old('location', $user->location) == 'Santa.Fe' ? 'selected' : '' }}>Santa.Fe</option>
        <option value="Madridejos" {{ old('location', $user->location) == 'Madridejos' ? 'selected' : '' }}>Madridejos</option>
      </select>

      <button type="submit">Update User</button>
    </form>

    <a class="back-link" href="{{ route('users.index') }}">← Back to User List</a>
  </div>
</body>
</html>
