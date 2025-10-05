<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Citizen Engagement Platform</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827;">
    <h2>Welcome, {{ $user->name }}!</h2>
    <p>Thank you for registering at the <strong>Citizen Engagement Platform</strong>.</p>
    <p>Your registered municipality: <strong>{{ $user->location }}</strong></p>
    <p>You can now log in and start collaborating with your barangay:</p>
    <p><a href="{{ route('login') }}" style="color: #6366f1; text-decoration: none;">Login Here</a></p>
    <br>
    <p>We’re excited to have you onboard!</p>
    <p>— Citizen Engagement Platform Team</p>
</body>
</html>
