<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>OTP Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
  <div style="max-width: 500px; margin: auto; background: #fff; border-radius: 8px; padding: 20px;">
    <h2 style="color: #2b6cb0;">Hello!</h2>
    <p>Your One-Time Password (OTP) for logging in to <strong>Bantayan 911</strong> is:</p>
    <h1 style="text-align: center; color: #1a202c;">{{ $otp }}</h1>
    <p>This code will expire in <strong>3 minutes</strong>.</p>
    <p style="font-size: 14px; color: #666;">If you didn’t request this, you can safely ignore this email.</p>
  </div>
</body>
</html>
