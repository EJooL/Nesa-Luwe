<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Nesa Luwe</title>
    <style>
        /* CSS Kustom di sini */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f8f9fa; }
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #2c3e50; color: #ecf0f1; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        .sidebar .logo { text-align: center; margin-bottom: 30px; font-size: 24px; font-weight: bold; color: #fff; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin-bottom: 15px; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; display: block; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s; }
        .sidebar ul li a:hover, .sidebar ul li a.active { background-color: #34495e; }
        .main-content { flex-grow: 1; display: flex; flex-direction: column; }
        .header { background-color: #ffffff; padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .header h1 { margin: 0; font-size: 24px; color: #343a40; }
        .user-info { display: flex; align-items: center; }
        .user-info span { margin-right: 15px; color: #555; }
        .user-info a { color: #dc3545; text-decoration: none; padding: 8px 15px; border-radius: 5px; background-color: #f8d7da; }
        .user-info a:hover { background-color: #e2b7bd; }
        .content-area { padding: 30px; flex-grow: 1; background-color: #fff; margin: 20px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.05); }
        .card { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; color: #333; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; }
        .btn-action { background-color: #007bff; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; margin-right: 5px; }
        .btn-action.edit { background-color: #ffc107; }
        .btn-action.delete { background-color: #dc3545; }
        .btn-action:hover { opacity: 0.9; }
        .form-control { width: calc(100% - 22px); padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .form-label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">Nesa Luwe Admin</div>
            <ul>
                <li><a href="admin.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="kelolawarung.php"><i class="fas fa-store"></i> Kelola Warung</a></li>
                <li><a href="kelolamenu.php"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="kelolauser.php"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
                <li><a href="stats.php"><i class="fas fa-chart-line"></i> Laporan & Statistik</a></li>
                <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Dashboard Admin</h1>
                <div class="user-info">
                    <span>Selamat Datang, Admin!</span>
                    <a href="#">Logout</a>
                </div>
            </div>

            <div class="content-area">
                <div class="card">
                    <h3>Ringkasan Foodcourt</h3>
                    <p>Total Warung: <strong>10</strong></p>
                    <p>Total Menu: <strong>150</strong></p>
                    <p>Pesanan Hari Ini: <strong>25</strong></p>
                    <p>Pengguna Aktif: <strong>500+</strong></p>
                </div>

                <div class="card">
                    <h3>Aktivitas Terbaru</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023-10-27 10:30</td>
                                <td>Menambahkan menu "Nasi Goreng Spesial"</td>
                                <td>Admin Utama</td>
                            </tr>
                            <tr>
                                <td>2023-10-27 09:45</td>
                                <td>Mengupdate jam operasional Warung 'Makmur'</td>
                                <td>Admin Utama</td>
                            </tr>
                            </tbody>
                    </table>
                </div>

                </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>