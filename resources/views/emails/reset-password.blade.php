<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password - Insight Stress</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%); min-height: 100vh;">
  
  <!-- Main Container -->
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 40px 20px;">
    <tr>
      <td align="center">
        
        <!-- Email Card -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; background: #ffffff; border-radius: 24px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15); overflow: hidden;">
          
          <!-- Header with Gradient -->
          <tr>
            <td style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); padding: 50px 40px; text-align: center; position: relative;">
              <!-- Decorative circles -->
              <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
              <div style="position: absolute; bottom: -20px; left: -20px; width: 80px; height: 80px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
              
              <!-- Lock Icon -->
              <div style="position: relative; z-index: 1;">
                <div style="display: inline-block; width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; margin-bottom: 20px; padding: 20px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                  <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block; margin: 0 auto;">
                    <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm0 2c1.654 0 3 1.346 3 3v3H9V7c0-1.654 1.346-3 3-3zm0 10c-1.103 0-2 .897-2 2s.897 2 2 2 2-.897 2-2-.897-2-2-2z" fill="white"/>
                  </svg>
                </div>
                <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">Reset Password</h1>
                <p style="margin: 12px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px; font-weight: 400;">Insight Stress - Platform Deteksi Stres</p>
              </div>
            </td>
          </tr>
          
          <!-- Body Content -->
          <tr>
            <td style="padding: 50px 40px;">
              
              <!-- Greeting -->
              <h2 style="margin: 0 0 20px; color: #1f2937; font-size: 24px; font-weight: 600;">Halo! 👋</h2>
              
              <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.7;">
                Kami menerima permintaan untuk <strong style="color: #14b8a6;">mereset password</strong> akun Anda di <strong>Insight Stress</strong>.
              </p>
              
              <p style="margin: 0 0 35px; color: #4b5563; font-size: 16px; line-height: 1.7;">
                Untuk melanjutkan proses reset password, silakan klik tombol di bawah ini:
              </p>
              
              <!-- CTA Button -->
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td align="center" style="padding: 0 0 35px;">
                    <a href="{{ $resetUrl }}" 
                       style="display: inline-block; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: #ffffff; text-decoration: none; padding: 18px 40px; border-radius: 12px; font-weight: 600; font-size: 16px; box-shadow: 0 10px 30px rgba(20, 184, 166, 0.4); transition: all 0.3s ease;">
                      🔐 Reset Password Sekarang
                    </a>
                  </td>
                </tr>
              </table>
              
              <!-- Alternative Link -->
              <div style="margin: 0 0 35px; padding: 20px; background: #f9fafb; border-radius: 12px; border-left: 4px solid #14b8a6;">
                <p style="margin: 0 0 10px; color: #6b7280; font-size: 13px; font-weight: 500;">Atau copy link berikut ke browser Anda:</p>
                <p style="margin: 0; word-break: break-all;">
                  <a href="{{ $resetUrl }}" style="color: #14b8a6; text-decoration: none; font-size: 13px;">{{ $resetUrl }}</a>
                </p>
              </div>
              
              <!-- Important Notes -->
              <div style="margin: 0 0 30px; padding: 24px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; border: 1px solid #fbbf24;">
                <div style="display: flex; align-items: flex-start;">
                  <div style="margin-right: 12px; font-size: 24px;">⚠️</div>
                  <div>
                    <p style="margin: 0 0 12px; color: #92400e; font-size: 14px; font-weight: 600;">Catatan Penting:</p>
                    <ul style="margin: 0; padding-left: 20px; color: #92400e; font-size: 14px; line-height: 1.8;">
                      <li>Link ini akan <strong>kadaluarsa dalam 60 menit</strong></li>
                      <li>Jika Anda tidak melakukan permintaan ini, abaikan email ini</li>
                      <li>Password Anda tidak akan berubah sampai Anda mengklik link di atas</li>
                    </ul>
                  </div>
                </div>
              </div>
              
              <!-- Security Tips -->
              <div style="margin: 0; padding: 24px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; border: 1px solid #60a5fa;">
                <div style="display: flex; align-items: flex-start;">
                  <div style="margin-right: 12px; font-size: 24px;">💡</div>
                  <div>
                    <p style="margin: 0 0 8px; color: #1e40af; font-size: 14px; font-weight: 600;">Tips Keamanan:</p>
                    <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.7;">
                      Pastikan password baru Anda kuat dan unik. Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan maksimal.
                    </p>
                  </div>
                </div>
              </div>
              
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style="background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%); padding: 35px 40px; text-align: center; border-top: 1px solid #e5e7eb;">
              <p style="margin: 0 0 12px; color: #14b8a6; font-size: 18px; font-weight: 600;">🌤️ Tenangkan pikiranmu, mulai dari sini.</p>
              <p style="margin: 0 0 20px; color: #6b7280; font-size: 14px;">
                Butuh bantuan? Hubungi kami di 
                <a href="mailto:support@insightstress.com" style="color: #14b8a6; text-decoration: none; font-weight: 500;">support@insightstress.com</a>
              </p>
              <div style="margin: 0 0 15px; padding-top: 20px; border-top: 1px solid #d1d5db;">
                <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                  © 2025 Insight Stress. All rights reserved.
                </p>
              </div>
              <!-- Social Links (Optional) -->
              <div style="margin: 0;">
                <a href="#" style="display: inline-block; margin: 0 8px; color: #14b8a6; text-decoration: none; font-size: 12px;">Instagram</a>
                <span style="color: #d1d5db;">•</span>
                <a href="#" style="display: inline-block; margin: 0 8px; color: #14b8a6; text-decoration: none; font-size: 12px;">Twitter</a>
                <span style="color: #d1d5db;">•</span>
                <a href="#" style="display: inline-block; margin: 0 8px; color: #14b8a6; text-decoration: none; font-size: 12px;">Website</a>
              </div>
            </td>
          </tr>
          
        </table>
        
      </td>
    </tr>
  </table>
  
</body>
</html>
