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
        /* Styling untuk Badge Role */
.role-badge {
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.9em;
    font-weight: 600;
}

.role-badge.super-admin {
    background-color: #343a40; /* Hitam/Dark */
    color: white;
}

.role-badge.admin {
    background-color: #007bff; /* Biru */
    color: white;
}

.role-badge.pengelola {
    background-color: #ffc107; /* Kuning */
    color: #333;
}

.role-badge.pelanggan {
    background-color: #28a745; /* Hijau */
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
                <li><a href="kelolauser.php" class="active"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
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
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="filter-group">
            <label for="filter_role" class="form-label" style="display: inline-block; margin-right: 10px;">Filter Role:</label>
            <select id="filter_role" class="form-control" style="width: auto; display: inline-block;">
                <option value="all">Semua Role</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="pengelola_warung">Pengelola Warung</option>
                <option value="pelanggan">Pelanggan</option>
            </select>
        </div>
        
        <button class="btn-action primary" onclick="document.getElementById('form-user-card').style.display='block';">
            <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
        </button>
    </div>

    <div class="card">
        <h3>Daftar Akun Sistem</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>U001</td>
                    <td>Admin Utama</td>
                    <td>admin.utama@nesaluwe.ac.id</td>
                    <td><span class="role-badge super-admin">Super Admin</span></td>
                    <td><span class="status-active">Aktif</span></td>
                    <td>
                        <button class="btn-action edit" onclick="editUser('U001')" disabled>Edit</button>
                        <button class="btn-action delete">Nonaktifkan</button>
                    </td>
                </tr>
                <tr>
                    <td>U002</td>
                    <td>Ibu Ani (Warung Soto)</td>
                    <td>ibuani@soto.com</td>
                    <td><span class="role-badge pengelola">Pengelola Warung</span></td>
                    <td><span class="status-active">Aktif</span></td>
                    <td>
                        <button class="btn-action edit" onclick="editUser('U002')">Edit</button>
                        <button class="btn-action delete">Nonaktifkan</button>
                    </td>
                </tr>
                <tr>
                    <td>U003</td>
                    <td>Pengelola Kasir</td>
                    <td>kasir@nesaluwe.ac.id</td>
                    <td><span class="role-badge admin">Admin</span></td>
                    <td><span class="status-inactive">Nonaktif</span></td>
                    <td>
                        <button class="btn-action edit" onclick="editUser('U003')">Edit</button>
                        <button class="btn-action primary">Aktifkan</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card" id="form-user-card" style="display:none;">
        <h3 id="form-title-user">Tambah Pengguna Baru</h3>
        <form id="user-form">
            <div class="form-group">
                <label for="nama_user" class="form-label">Nama Lengkap:</label>
                <input type="text" id="nama_user" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email_user" class="form-label">Email:</label>
                <input type="email" id="email_user" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="role_user" class="form-label">Pilih Role:</label>
                <select id="role_user" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="pengelola_warung">Pengelola Warung</option>
                    </select>
            </div>

            <div class="form-group" id="warung_id_group" style="display:none;">
                <label for="warung_id" class="form-label">Warung yang Dikelola (Jika Pengelola Warung):</label>
                <select id="warung_id" class="form-control">
                    <option value="">-- Pilih Warung --</option>
                    <option value="W001">Warung Makmur</option>
                    <option value="W002">Soto Ayam Bu Ani</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="password_user" class="form-label">Password:</label>
                <input type="password" id="password_user" class="form-control" required>
            </div>

            <button type="submit" class="btn-action primary">Simpan Pengguna</button>
            <button type="button" class="btn-action secondary" onclick="document.getElementById('form-user-card').style.display='none';">Batal</button>
        </form>
    </div>
</div>

<script>
    // Fungsi JavaScript untuk edit user
    function editUser(id) {
        document.getElementById('form-title-user').innerText = 'Edit Pengguna ' + id;
        document.getElementById('email_user').value = 'user_' + id + '@example.com'; 
        document.getElementById('form-user-card').style.display = 'block';
        window.scrollTo(0, document.body.scrollHeight);
    }

    // Fungsi untuk menampilkan Warung ID hanya jika role yang dipilih adalah Pengelola Warung
    document.getElementById('role_user').addEventListener('change', function() {
        var warungGroup = document.getElementById('warung_id_group');
        if (this.value === 'pengelola_warung') {
            warungGroup.style.display = 'block';
        } else {
            warungGroup.style.display = 'none';
        }
    });
</script>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>