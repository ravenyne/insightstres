<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Admin - Insight Stres</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e0f2fe, #fce7f3);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      width: 400px;
      text-align: center;
    }
    h2 {
      color: #2563eb;
      margin-bottom: 20px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
    }
    input:focus {
      border-color: #7c3aed;
    }
    button {
      background: linear-gradient(135deg, #2563eb, #7c3aed);
      color: #fff;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }
    button:hover {
      transform: scale(1.05);
    }
    a {
      display: block;
      margin-top: 15px;
      text-decoration: none;
      color: #2563eb;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Tambah Admin Baru</h2>
    <form action="{{ route('admin.admins.store') }}" method="POST">
      @csrf
      <input type="text" name="name" placeholder="Nama Admin" required>
      <input type="email" name="email" placeholder="Email Admin" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Simpan Admin</button>
    </form>
    <a href="{{ route('admin.admins') }}">⬅️ Kembali</a>
  </div>
</body>
</html>
