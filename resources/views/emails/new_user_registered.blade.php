<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
</head>
<body>
    <h2>New User Registered</h2>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Municipality:</strong> {{ $user->location }}</p>
</body>
</html>
