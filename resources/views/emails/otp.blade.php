<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bantayan 911 | OTP Verification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Segoe UI', Arial, sans-serif;">
  <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #f4f6f8; padding: 30px 0;">
    <tr>
      <td align="center">
        <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="max-width: 540px; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
          <tr>
            <td style="background: linear-gradient(135deg, #2563eb, #1e40af); padding: 25px 0; text-align: center;">
             <!-- Bantayan 911 Circle Logo -->
<!-- Bantayan 911 Circle Logo -->
<img 
  src="{{ $message->embed(public_path('images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png')) }}" 
  alt="Bantayan 911 Logo" 
  width="70" 
  style="border-radius: 50%; background: #fff; padding: 8px;"
>
<h1 style="color: #fff; font-size: 22px; margin-top: 10px; letter-spacing: 1px;">
  BANTAYAN 911
</h1>


            </td>
          </tr>
          <tr>
            <td style="padding: 30px 40px; color: #333;">
              <h2 style="color: #1a202c; margin-bottom: 10px;">OTP Verification</h2>
              <p style="font-size: 15px; line-height: 1.6; color: #4a5568;">
                Hello,<br><br>
                Your One-Time Password (OTP) to securely sign in to <strong>Bantayan 911</strong> is:
              </p>
              <div style="text-align: center; margin: 30px 0;">
                <h1 style="display: inline-block; background: #edf2f7; color: #1a202c; font-size: 36px; padding: 12px 25px; border-radius: 8px; letter-spacing: 4px;">
                  {{ $otp }}
                </h1>
              </div>
              <p style="font-size: 15px; color: #4a5568;">
                This OTP will expire in <strong>3 minutes</strong>. Please do not share it with anyone.
              </p>
              <p style="font-size: 14px; color: #718096; margin-top: 25px;">
                If you did not request this code, please ignore this message.
              </p>
              <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
              <p style="font-size: 13px; color: #a0aec0; text-align: center;">
                © 2025 Bantayan 911. All rights reserved.<br>
                Emergency Response System for Bantayan, Cebu
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
