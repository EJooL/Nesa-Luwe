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
        /* Styling untuk Navigasi Tab Pengaturan */
.setting-tabs {
    border-bottom: 2px solid #ddd;
    margin-bottom: 25px;
    display: flex;
}

.tab-button {
    background-color: transparent;
    border: none;
    border-bottom: 3px solid transparent; /* Garis bawah transparan */
    padding: 12px 20px;
    cursor: pointer;
    font-size: 16px;
    color: #6c757d;
    transition: all 0.3s;
    margin-right: 1px; /* Jarak antar tombol */
}

.tab-button i {
    margin-right: 8px;
}

.tab-button:hover {
    color: #343a40;
}

.tab-button.active {
    color: #007bff; /* Warna biru untuk tab aktif */
    border-bottom-color: #007bff; /* Garis bawah biru */
    font-weight: bold;
}

/* Penyesuaian Form pada Halaman Pengaturan */
.form-group small {
    display: block;
    margin-top: 5px;
    color: #888;
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
                <li><a href="stats.php"><i class="fas fa-chart-line"></i> Laporan & Statistik</a></li>
                <li><a href="pengaturan.php" class="active"><i class="fas fa-cog"></i> Pengaturan</a></li>
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
    <h2>Pengaturan Sistem & Akun</h2>

    <div class="setting-tabs">
        <button class="tab-button active" onclick="showTab('umum')">
            <i class="fas fa-cogs"></i> Umum
        </button>
        <button class="tab-button" onclick="showTab('akun')">
            <i class="fas fa-user-shield"></i> Akun Admin
        </button>
    </div>

    <div id="tab-umum" class="tab-content active">
        <div class="card">
            <h3>Detail Foodcourt Nesa Luwe</h3>
            <form>
                <div class="form-group">
                    <label for="nama_sistem" class="form-label">Nama Sistem/Foodcourt:</label>
                    <input type="text" id="nama_sistem" class="form-control" value="Nesa Luwe - Foodcourt UNESA Ketintang">
                </div>
                <div class="form-group">
                    <label for="deskripsi_sistem" class="form-label">Deskripsi Singkat:</label>
                    <textarea id="deskripsi_sistem" class="form-control" rows="3">Foodcourt resmi yang melayani pemesanan makanan dan minuman untuk area kampus UNESA Ketintang.</textarea>
                </div>
                <div class="form-group">
                    <label for="jam_operasional_sistem" class="form-label">Jam Operasional Default:</label>
                    <input type="text" id="jam_operasional_sistem" class="form-control" value="Senin - Sabtu, 08:00 - 17:00">
                </div>
                <div class="form-group">
                    <label for="kontak_darurat" class="form-label">Nomor Kontak Darurat Admin:</label>
                    <input type="tel" id="kontak_darurat" class="form-control" value="0812-XXXX-XXXX">
                </div>
                <button type="submit" class="btn-action primary">Simpan Pengaturan Umum</button>
            </form>
        </div>
    </div>

    <div id="tab-akun" class="tab-content" style="display:none;">
        <div class="card">
            <h3>Ubah Profil & Keamanan</h3>
            <form>
                <div class="form-group">
                    <label for="username" class="form-label">Username Admin:</label>
                    <input type="text" id="username" class="form-control" value="admin_utama" readonly>
                    <small class="text-muted">Username tidak dapat diubah.</small>
                </div>
                <div class="form-group">
                    <label for="email_admin" class="form-label">Email Kontak:</label>
                    <input type="email" id="email_admin" class="form-control" value="admin@nesaluwe.ac.id">
                </div>
                <div class="form-group">
                    <label for="password_baru" class="form-label">Password Baru:</label>
                    <input type="password" id="password_baru" class="form-control" placeholder="Isi hanya jika ingin mengubah password">
                </div>
                <button type="submit" class="btn-action primary">Update Akun</button>
            </form>
        </div>
    </div>
</div>

<script>
    // FUNGSI JAVASCRIPT UNTUK MENGGANTI TAB
    function showTab(tabName) {
        // Sembunyikan semua konten tab
        var contents = document.getElementsByClassName('tab-content');
        for (var i = 0; i < contents.length; i++) {
            contents[i].style.display = 'none';
        }

        // Hapus status 'active' dari semua tombol
        var buttons = document.getElementsByClassName('tab-button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }

        // Tampilkan konten tab yang dipilih
        document.getElementById('tab-' + tabName).style.display = 'block';
        
        // Atur tombol yang diklik menjadi 'active'
        // Logika ini akan lebih mudah jika tombol memiliki ID yang sesuai, tapi kita gunakan cara ini:
        event.currentTarget.classList.add('active'); 
    }
</script>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>