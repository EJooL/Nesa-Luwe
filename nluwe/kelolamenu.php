<?php
// =========================================================================
// 1. PENGATURAN KONEKSI DATABASE (GANTI DENGAN KREDENSIAL ASLI ANDA)
// =========================================================================
$servername = "localhost";
$username = "root"; 
$password = ""; // GANTI: Password database Anda
$dbname = "nluwe"; // Nama database Anda di phpMyAdmin

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// =========================================================================
// 2. LOGIKA UNTUK MENGAMBIL DATA
// =========================================================================

// Query untuk mengambil semua menu, digabungkan (JOIN) dengan data Warung/Tenant
$sql = "
    SELECT 
        m.menu_id, 
        m.nama_menu, 
        m.harga, 
        m.deskripsi, 
        m.gambar_menu, 
        t.nama_tenant AS nama_warung 
    FROM menu m
    JOIN tenant t ON m.tenant_id = t.tenant_id  
    ORDER BY m.menu_id DESC
"; 

$result = $conn->query($sql);

$data_menu = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data_menu[] = $row;
    }
}

// Ambil daftar Warung untuk dropdown filter/form
$sql_tenants = "SELECT tenant_id, nama_tenant FROM tenant ORDER BY nama_tenant ASC";
$result_tenants = $conn->query($sql_tenants);
$tenants = [];
if ($result_tenants) {
    while($row = $result_tenants->fetch_assoc()) {
        $tenants[] = $row;
    }
}

// Menutup koneksi (akan dibuka lagi setelah HTML jika ada CRUD)
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu | Admin Nesa Luwe</title>
    
    <style>
        /* CSS umum (dari Kelola Warung) */
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
        
        /* CSS Khusus Menu */
        .status-active { background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .status-inactive { background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .btn-action.primary { background-color: #28a745; }
        .btn-action.primary:hover { background-color: #1e7e34; }
        .btn-action.secondary { background-color: #6c757d; }
        .btn-action.secondary:hover { background-color: #5a6268; }
        .form-group { margin-bottom: 15px; }
        .form-control[style*="inline-block"] { padding: 8px 10px; height: auto; }
        .image-preview { max-width: 50px; max-height: 50px; border-radius: 4px; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">Nesa Luwe Admin</div>
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="kelolawarung.php"><i class="fas fa-store"></i> Kelola Warung</a></li>
                <li><a href="kelolamenu.php" class="active"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="kelolauser.php"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
                <li><a href="stats.php"><i class="fas fa-chart-line"></i> Laporan & Statistik</a></li>
                <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Kelola Menu</h1> 
                <div class="user-info">
                    <span>Selamat Datang, Admin!</span>
                    <a href="#">Logout</a>
                </div>
            </div>

            <div class="content-area">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div class="filter-group">
                        <label for="filter_warung" class="form-label" style="display: inline-block; margin-right: 10px;">Filter Warung:</label>
                        <select id="filter_warung" class="form-control" style="width: auto; display: inline-block;">
                            <option value="all">Semua Warung</option>
                            <?php foreach ($tenants as $tenant): ?>
                                <option value="<?php echo htmlspecialchars($tenant['tenant_id']); ?>">
                                    <?php echo htmlspecialchars($tenant['nama_tenant']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button class="btn-action primary" onclick="showForm()">
                        <i class="fas fa-plus"></i> Tambah Menu Baru
                    </button>
                </div>

                <div class="card">
                    <h3>Daftar Menu Makanan & Minuman</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Menu</th>
                                <th>Warung</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data_menu)): ?>
                                <?php foreach ($data_menu as $menu): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($menu['menu_id']); ?></td>
                                        <td><?php echo htmlspecialchars($menu['nama_menu']); ?></td>
                                        <td><?php echo htmlspecialchars($menu['nama_warung']); ?></td>
                                        <td><?php echo 'Rp.' . number_format($menu['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php if (!empty($menu['gambar_menu'])): ?>
                                                <img src="db/<?php echo htmlspecialchars($menu['gambar_menu']); ?>" alt="Menu Image" class="image-preview">
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn-action edit" onclick="editMenu('<?php echo htmlspecialchars($menu['menu_id']); ?>')">Edit</button>
                                            <a href="?action=delete&id=<?php echo htmlspecialchars($menu['menu_id']); ?>" class="btn-action delete" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">Belum ada data menu yang terdaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card" id="form-menu-card" style="display:none;">
                    <h3 id="form-title-menu">Tambah Menu Baru</h3>
                    <form id="menu-form" method="POST" action="kelolamenu.php" enctype="multipart/form-data">
                        <input type="hidden" name="menu_id_hidden" id="menu_id_hidden">
                        
                        <div class="form-group">
                            <label for="menu_warung" class="form-label">Pilih Warung:</label>
                            <select id="menu_warung" name="tenant_id" class="form-control" required>
                                <option value="">-- Pilih Warung --</option>
                                <?php foreach ($tenants as $tenant): ?>
                                    <option value="<?php echo htmlspecialchars($tenant['tenant_id']); ?>">
                                        <?php echo htmlspecialchars($tenant['nama_tenant']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_menu" class="form-label">Nama Menu:</label>
                            <input type="text" id="nama_menu" name="nama_menu" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi Menu:</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="harga" class="form-label">Harga (Angka):</label>
                            <input type="number" id="harga" name="harga" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar Menu:</label>
                            <input type="file" id="gambar" name="gambar_menu" class="form-control">
                            <small id="gambar_saat_ini" style="color:#007bff; display:none;">Gambar saat ini: -</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="status_menu" class="form-label">Status Ketersediaan:</label>
                            <select id="status_menu" name="status_menu" class="form-control">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Habis">Habis</option>
                            </select>
                        </div>

                        <button type="submit" name="submit_menu" class="btn-action primary">Simpan Menu</button>
                        <button type="button" class="btn-action secondary" onclick="hideForm()">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script>
        function showForm() {
            document.getElementById('form-title-menu').innerText = 'Tambah Menu Baru';
            document.getElementById('menu_id_hidden').value = '';
            document.getElementById('menu-form').reset();
            document.getElementById('gambar_saat_ini').style.display = 'none';
            document.getElementById('form-menu-card').style.display = 'block';
            window.scrollTo(0, document.body.scrollHeight);
        }

        function hideForm() {
            document.getElementById('form-menu-card').style.display = 'none';
        }
        
        // Simulasikan Edit (Perlu AJAX untuk mengisi data dari DB)
        function editMenu(id) {
            // Dalam implementasi nyata, di sini akan ada fungsi AJAX
            // untuk mengambil data menu berdasarkan ID dan mengisi form
            document.getElementById('form-title-menu').innerText = 'Edit Menu ' + id;
            document.getElementById('menu_id_hidden').value = id;
            document.getElementById('form-menu-card').style.display = 'block';
            window.scrollTo(0, document.body.scrollHeight);
        }
    </script>
</body>
</html>

<?php
// =========================================================================
// 3. LOGIKA CRUD (CREATE, UPDATE, DELETE)
// =========================================================================

// --- Koneksi ulang untuk CRUD ---
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }
// ------------------------------

// --- Fungsi Upload Gambar ---
function upload_gambar($file) {
    $target_dir = "../uploads/menu/"; // Pastikan folder ini ada!
    $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_file_name = uniqid() . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;

    // Periksa dan pindahkan file (logika sederhana)
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $new_file_name;
    } else {
        return false;
    }
}

// --- A. Logika TAMBAH / UPDATE Data ---
if (isset($_POST['submit_menu'])) {
    $menu_id = $_POST['menu_id_hidden'];
    $tenant_id = $conn->real_escape_string($_POST['tenant_id']);
    $nama_menu = $conn->real_escape_string($_POST['nama_menu']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $status_menu = $conn->real_escape_string($_POST['status_menu'] ?? 'Tersedia'); // Asumsi ada status

    $nama_gambar = null;
    $upload_success = true;

    // Cek apakah ada file gambar baru diupload
    if (!empty($_FILES['gambar_menu']['name'])) {
        $nama_gambar = upload_gambar($_FILES['gambar_menu']);
        if (!$nama_gambar) {
            $upload_success = false;
            echo "<script>alert('Gagal mengupload gambar.');</script>";
        }
    }

    if ($upload_success) {
        if (empty($menu_id)) {
            // LOGIKA INSERT (Tambah Baru)
            $stmt = $conn->prepare("INSERT INTO menu (tenant_id, nama_menu, harga, deskripsi, gambar_menu) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $tenant_id, $nama_menu, $harga, $deskripsi, $nama_gambar);
        } else {
            // LOGIKA UPDATE (Edit)
            if ($nama_gambar) {
                // Update dengan gambar baru
                $stmt = $conn->prepare("UPDATE menu SET tenant_id=?, nama_menu=?, harga=?, deskripsi=?, gambar_menu=? WHERE menu_id=?");
                $stmt->bind_param("issssi", $tenant_id, $nama_menu, $harga, $deskripsi, $nama_gambar, $menu_id);
            } else {
                // Update tanpa mengubah gambar
                $stmt = $conn->prepare("UPDATE menu SET tenant_id=?, nama_menu=?, harga=?, deskripsi=? WHERE menu_id=?");
                $stmt->bind_param("isssi", $tenant_id, $nama_menu, $harga, $deskripsi, $menu_id);
            }
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data menu berhasil disimpan!'); window.location.href='kelolamenu.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}

// --- B. Logika HAPUS Data ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $menu_id_to_delete = $conn->real_escape_string($_GET['id']);
    
    // *Tambahan: Hapus file gambar terkait dari server*
    // (Logika ini dihilangkan untuk menjaga kode tetap fokus, tapi sangat disarankan)

    $stmt = $conn->prepare("DELETE FROM menu WHERE menu_id = ?");
    $stmt->bind_param("i", $menu_id_to_delete);
    
    if ($stmt->execute()) {
        echo "<script>alert('Menu berhasil dihapus!'); window.location.href='kelolamenu.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus menu: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>