<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f3e8ff);
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }

        h1 {
            text-align: center;
            color: #4338ca;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        th {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            text-transform: uppercase;
            padding: 12px;
            font-size: 13px;
        }

        td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        tr:hover { background: #f8fafc; }

        button {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        button:hover { background: #dc2626; }

        .add-btn {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #4f46e5, #9333ea);
        }

        a.back {
            display: inline-block;
            margin-top: 20px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        a.back:hover { color: #3730a3; }

        .btn-tambah {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            margin-bottom: 20px;

        .btn-tambah:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #4f46e5, #9333ea);
}

    </style>
</head>
<body>
    <h1>Kelola Admin</h1>

    @if(session('success'))
        <p style="color:green; text-align:center;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red; text-align:center;">{{ session('error') }}</p>
    @endif

    <a href="{{ route('admin.admins.create') }}" class="btn-tambah">+ Tambah Admin</a>


    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($admins as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->name }}</td>
                <td>{{ $a->email }}</td>
                <td>{{ $a->created_at->format('Y-m-d') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.delete', $a->id) }}" onsubmit="return confirm('Hapus admin ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:#9ca3af; padding:20px;">Belum ada admin terdaftar.</td></tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" class="back">⬅️ Kembali ke Dashboard</a>
</body>
</html>
