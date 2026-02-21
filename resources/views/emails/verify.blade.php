<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Akun Insight Stres</title>
</head>
<body style="font-family: 'Poppins', Arial, sans-serif; background-color: #f5f9fc; margin: 0; padding: 40px;">

  <div style="max-width: 600px; margin: 0 auto; background: linear-gradient(180deg, #ffffff 0%, #f2f8ff 100%);
              border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden;">

    <!-- Header -->
    <div style="background-color: #d6e6f2; padding: 30px; text-align: center;">
      <h2 style="margin: 10px 0 0; color: #204060;">Insight Stres</h2>
    </div>

    <!-- Body -->
    <div style="padding: 35px 30px; color: #333;">
      <h3 style="margin-top: 0; color: #204060;">Halo, {{ $user->name }} ☁️</h3>
      <p style="font-size: 15px; line-height: 1.7; color: #444;">
        Terima kasih sudah mendaftar di <strong>Insight Stres</strong>!  
        Untuk mengaktifkan akunmu, silakan klik tombol di bawah ini ✨
      </p>

      <div style="text-align: center; margin: 35px 0;">
        <a href="{{ url('/verify/' . $user->verification_token) }}" 
           style="background: linear-gradient(90deg, #A8D8EA, #74bde0);
                  color:white;
                  padding:14px 28px;
                  text-decoration:none;
                  border-radius:8px;
                  font-weight:600;
                  display:inline-block;">
          Verifikasi Sekarang
        </a>
      </div>

      <p style="font-size: 14px; color: #777; text-align: center;">
        Jika kamu tidak merasa mendaftar, abaikan saja email ini <br>
        Link ini akan kadaluarsa dalam 24 jam.
      </p>
    </div>

    <!-- Footer -->
    <div style="background-color: #eef6fb; text-align: center; padding: 15px; font-size: 12px; color: #7a8da3;">
      <p style="margin: 0;">🌤️ Tenangkan pikiranmu, mulai dari sini.</p>
      <p style="margin: 6px 0 0;">© 2025 Insight Stres</p>
    </div>
  </div>

</body>
</html>
