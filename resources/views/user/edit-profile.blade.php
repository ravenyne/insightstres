<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil Mahasiswa - Insight Stres</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #e0f7fa 0%, #fce4ec 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .card {
      background: white;
      padding: 40px;
      border-radius: 24px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      position: relative;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      text-align: center;
      margin-bottom: 32px;
    }

    .header-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #90caf9, #f48fb1);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 16px;
      box-shadow: 0 4px 12px rgba(144, 202, 249, 0.3);
    }

    h2 {
      color: #1e293b;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .subtitle {
      color: #64748b;
      font-size: 14px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #334155;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
    }

    input, select {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 15px;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: all 0.3s ease;
      background: #f8fafc;
      color: #1e293b;
    }

    input:focus, select:focus {
      border-color: #90caf9;
      background: white;
      box-shadow: 0 0 0 4px rgba(144, 202, 249, 0.1);
    }

    input:hover, select:hover {
      border-color: #cbd5e1;
      background: white;
    }

    select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      padding-right: 40px;
    }

    button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #90caf9 0%, #f48fb1 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(144, 202, 249, 0.3);
      margin-top: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    button:hover {
      background: linear-gradient(135deg, #64b5f6 0%, #f06292 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(144, 202, 249, 0.4);
    }

    button:active {
      transform: translateY(0);
    }

    .back-link {
      display: inline-block;
      text-align: center;
      width: 100%;
      margin-top: 20px;
      color: #64748b;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.3s ease;
      padding: 8px;
    }

    .back-link:hover {
      color: #90caf9;
    }

    /* Toast Notification */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .toast {
      background: #fff;
      color: #333;
      padding: 16px 20px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      font-size: 14px;
      font-weight: 500;
      min-width: 280px;
      opacity: 0;
      transform: translateX(20px);
      animation: slideIn 0.4s ease forwards;
      position: relative;
      overflow: hidden;
    }

    .toast::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: rgba(0,0,0,0.1);
      animation: progress 3s linear forwards;
    }

    .toast-success {
      border-left: 4px solid #10b981;
      background: #ecfdf5;
      color: #065f46;
    }

    .toast-success::after {
      background: #10b981;
    }

    .toast-error {
      border-left: 4px solid #ef4444;
      background: #fef2f2;
      color: #991b1b;
    }

    .toast-error::after {
      background: #ef4444;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 1;
        transform: translateX(0);
      }
      to {
        opacity: 0;
        transform: translateX(20px);
      }
    }

    @keyframes progress {
      from {
        width: 100%;
      }
      to {
        width: 0%;
      }
    }

    @media (max-width: 480px) {
      .card {
        padding: 30px 24px;
        border-radius: 20px;
      }

      .header-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
      }

      h2 {
        font-size: 20px;
      }

      .form-group {
        margin-bottom: 18px;
      }

      input, select {
        padding: 12px 14px;
        font-size: 14px;
      }

      button {
        padding: 14px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="toast-container" id="toast-container"></div>

  <div class="card">
    <div class="header">
      <div class="header-icon">👤</div>
      <h2>Edit Profil Mahasiswa</h2>
      <p class="subtitle">Perbarui informasi profilmu</p>
    </div>

    <form action="{{ route('user.profile.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Nama</label>
        <div class="input-wrapper">
          <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrapper">
          <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
      </div>

      <div class="form-group">
        <label for="nim">NIM</label>
        <div class="input-wrapper">
          <input type="text" id="nim" name="nim" value="{{ old('nim', $user->nim) }}" required>
        </div>
      </div>

      <div class="form-group">
        <label for="jurusan">Jurusan</label>
        <div class="input-wrapper">
          <select id="jurusan" name="jurusan" required>
            <option value="">Pilih Jurusan</option>
            <option value="Teknik Informatika" {{ old('jurusan', $user->jurusan) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
            <option value="Sistem Informasi" {{ old('jurusan', $user->jurusan) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            <option value="Bisnis Digital" {{ old('jurusan', $user->jurusan) == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
            <option value="Rekayasa Perangkat Lunak" {{ old('jurusan', $user->jurusan) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
            <option value="Manajemen Informatika" {{ old('jurusan', $user->jurusan) == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="semester">Semester</label>
        <div class="input-wrapper">
          <select id="semester" name="semester" required>
            @for ($i = 1; $i <= 8; $i++)
              <option value="{{ $i }}" {{ old('semester', $user->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
            @endfor
          </select>
        </div>
      </div>

      <button type="submit">
        <span>💾</span>
        <span>Simpan Perubahan</span>
      </button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toastContainer = document.getElementById("toast-container");

      // ✅ Success Toast
      @if (session('success'))
        showToast("{{ session('success') }}", "success");
      @endif

      // ❌ Error Toast
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          showToast("{{ $error }}", "error");
        @endforeach
      @endif

      function showToast(message, type = "success") {
        const toast = document.createElement("div");
        toast.classList.add("toast");
        toast.classList.add(type === "success" ? "toast-success" : "toast-error");
        toast.textContent = message;
        toastContainer.appendChild(toast);

        setTimeout(() => {
          toast.style.animation = "fadeOut 0.5s ease forwards";
          setTimeout(() => toast.remove(), 500);
        }, 3000);
      }
    });
  </script>
</body>
</html>
