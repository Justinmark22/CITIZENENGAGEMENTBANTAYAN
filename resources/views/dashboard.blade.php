<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Citizen Engagement Platform</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9fafb;
      margin: 0;
      padding: 0;
    }

    .header {
      background: #2563eb;
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h1 {
      margin: 0;
      font-size: 20px;
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      padding: 2rem;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .logout-button {
      background: #ef4444;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    .logout-button:hover {
      background: #dc2626;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Citizen Dashboard</h1>
    <form method="POST" action="">
      @csrf
      <button class="logout-button">Logout</button>
    </form>
  </div>

  <div class="container">
    <h2>Welcome, {{ Auth::user()->name }}!</h2>
    <p>You are logged in as a citizen from <strong>{{ Auth::user()->location }}</strong>.</p>
    <p>This is your dashboard. You can now participate in engagements, read updates, and more.</p>
  </div>
</body>
</html>
