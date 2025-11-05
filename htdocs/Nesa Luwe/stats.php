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
        /* Styling untuk KPI Cards */
.kpi-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    width: 25%; /* Membagi ruang menjadi empat kolom */
    text-align: left;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.kpi-card h4 {
    margin-top: 0;
    color: #6c757d; /* Abu-abu untuk judul */
    font-size: 1.1em;
}

.kpi-value {
    font-size: 2em;
    font-weight: bold;
    color: #343a40;
    margin: 5px 0 10px 0;
}

.kpi-detail {
    font-size: 0.9em;
}

.green-text {
    color: #28a745; /* Hijau untuk tren positif */
}

.red-text {
    color: #dc3545; /* Merah untuk tren negatif */
}

/* Styling untuk Badge Peringkat */
.rank-badge {
    padding: 3px 8px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 0.9em;
}

.rank-badge.gold {
    background-color: #ffc107;
    color: #333;
}

.rank-badge.silver {
    background-color: #c0c0c0;
    color: #333;
}

.rank-badge.bronze {
    background-color: #cd7f32;
    color: white;
}
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">Nesa Luwe Admin</div>
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="kelolawarung.php"><i class="fas fa-store"></i> Kelola Warung</a></li>
                <li><a href="kelolamenu.php"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="kelolauser.php"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
                <li><a href="stats.php" class="active"><i class="fas fa-chart-line"></i> Laporan & Statistik</a></li>
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
    
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 25px;">
        <label for="periode_filter" class="form-label" style="display: inline-block; margin-right: 10px; font-weight: bold;">Filter Periode:</label>
        <select id="periode_filter" class="form-control" style="width: auto; display: inline-block;">
            <option value="hari_ini">Hari Ini</option>
            <option value="mingguan">7 Hari Terakhir</option>
            <option value="bulanan" selected>Bulan Ini</option>
            <option value="tahunan">Tahun Ini</option>
        </select>
        <button class="btn-action primary" style="margin-left: 10px; background-color: #17a2b8;"><i class="fas fa-filter"></i> Terapkan</button>
    </div>

    <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 30px;">
        <div class="kpi-card">
            <h4>Total Pendapatan</h4>
            <p class="kpi-value">Rp 15.500.000</p>
            <span class="kpi-detail green-text"><i class="fas fa-arrow-up"></i> +12% dari bulan lalu</span>
        </div>
        <div class="kpi-card">
            <h4>Jumlah Pesanan</h4>
            <p class="kpi-value">985</p>
            <span class="kpi-detail green-text"><i class="fas fa-arrow-up"></i> +8% dari bulan lalu</span>
        </div>
        <div class="kpi-card">
            <h4>Warung Teraktif</h4>
            <p class="kpi-value">Warung Makmur</p>
            <span class="kpi-detail">Berdasarkan Total Pesanan</span>
        </div>
        <div class="kpi-card">
            <h4>Rata-rata Nilai Pesanan</h4>
            <p class="kpi-value">Rp 15.736</p>
            <span class="kpi-detail red-text"><i class="fas fa-arrow-down"></i> -2% dari bulan lalu</span>
        </div>
    </div>

    <div class="card">
        <h3>Grafik Tren Penjualan Bulanan</h3>
        <div style="height: 300px; background-color: #f7f7f7; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #777;">
            
            Area Chart (Contoh: Total Penjualan per Hari di Bulan Ini)
        </div>
    </div>

    <div class="card">
        <h3>Peringkat Kinerja Warung (Bulan Ini)</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Warung</th>
                    <th>Total Pesanan</th>
                    <th>Total Pendapatan (Estimasi)</th>
                    <th>Aksi Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="rank-badge gold">#1</span></td>
                    <td>Warung Makmur</td>
                    <td>250</td>
                    <td>Rp 4.500.000</td>
                    <td><button class="btn-action secondary">Lihat Detail</button></td>
                </tr>
                <tr>
                    <td><span class="rank-badge silver">#2</span></td>
                    <td>Soto Ayam Bu Ani</td>
                    <td>180</td>
                    <td>Rp 2.700.000</td>
                    <td><button class="btn-action secondary">Lihat Detail</button></td>
                </tr>
                <tr>
                    <td><span class="rank-badge bronze">#3</span></td>
                    <td>Nasi Uduk Bang Jali</td>
                    <td>155</td>
                    <td>Rp 2.300.000</td>
                    <td><button class="btn-action secondary">Lihat Detail</button></td>
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