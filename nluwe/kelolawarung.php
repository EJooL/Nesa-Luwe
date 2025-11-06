<?php
include("koneksi.php");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// =========================================================================
// 2. LOGIKA UNTUK MENGAMBIL DATA WARUNG DARI TABEL 'TENANT'
// =========================================================================
// --- Kueri diperbarui sesuai struktur DB yang baru ---
$sql = "SELECT tenant_id, nama_tenant, deskripsi, no_kontak, jam_buka, jam_tutup, gambar FROM tenant ORDER BY tenant_id ASC";
$result = $conn->query($sql);

$data_warung = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data_warung[] = $row;
    }
}

// Variabel untuk menampung data warung yang akan diedit (jika ada)
$warung_edit = null;

// Logika untuk mengambil data warung saat EDIT (AJAX sederhana)
if (isset($_GET['action']) && $_GET['action'] == 'get_data' && isset($_GET['id'])) {
    header('Content-Type: application/json');
    $id_warung = $conn->real_escape_string($_GET['id']);
    
    $stmt = $conn->prepare("SELECT tenant_id, nama_tenant, deskripsi, no_kontak, jam_buka, jam_tutup, gambar FROM tenant WHERE tenant_id = ?");
    $stmt->bind_param("i", $id_warung);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    
    if ($result_edit->num_rows > 0) {
        echo json_encode($result_edit->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
    $stmt->close();
    $conn->close();
    exit; // Hentikan eksekusi script setelah mengirim JSON
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Warung | Admin Nesa Luwe</title>
    
    <style>
        /* CSS yang Anda sediakan di sini */
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
        /* Tambahan CSS Khusus Halaman Kelola Warung */
        .status-active { background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .status-inactive { background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .btn-action.primary { background-color: #28a745; }
        .btn-action.primary:hover { background-color: #1e7e34; }
        .btn-action.secondary { background-color: #6c757d; }
        .btn-action.secondary:hover { background-color: #5a6268; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">Nesa Luwe Admin</div>
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="kelolawarung.php" class="active"><i class="fas fa-store"></i> Kelola Warung</a></li>
                <li><a href="kelolamenu.php"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Kelola Warung</h1>
                <div class="user-info">
                    <span>Selamat Datang, Admin!</span>
                    <a href="#">Logout</a>
                </div>
            </div>

            <div class="content-area">
                <button class="btn-action primary" onclick="showForm()">
                    <i class="fas fa-plus"></i> Tambah Warung Baru
                </button>
                
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

                <div class="card">
                    <h3>Daftar Warung Aktif</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Warung</th>
                                <th>No. Kontak</th>
                                <th>Jam Operasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data_warung)): ?>
                                <?php foreach ($data_warung as $warung): ?>
                                    <?php
                                        // Menentukan Jam Operasi gabungan
                                        $jam_buka = htmlspecialchars($warung['jam_buka']);
                                        $jam_tutup = htmlspecialchars($warung['jam_tutup']);
                                        $jam_operasi = !empty($jam_buka) && !empty($jam_tutup) ? "{$jam_buka} - {$jam_tutup}" : 'N/A';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($warung['tenant_id']); ?></td>
                                        <td><?php echo htmlspecialchars($warung['nama_tenant']); ?></td>
                                        <td><?php echo htmlspecialchars($warung['no_kontak'] ?? '-'); ?></td>
                                        <td><?php echo $jam_operasi; ?></td>
                                        <td>
                                            <button class="btn-action edit" onclick="editWarung('<?php echo htmlspecialchars($warung['tenant_id']); ?>')">Edit</button>
                                            <a href="?action=delete&id=<?php echo htmlspecialchars($warung['tenant_id']); ?>" class="btn-action delete" onclick="return confirm('Yakin ingin menghapus warung ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">Belum ada data warung yang terdaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card" id="form-warung-card" style="display:none;">
                    <h3 id="form-title">Tambah Warung Baru</h3>
                    <form id="warung-form" method="POST" action="kelolawarung.php" enctype="multipart/form-data"> 
                        <input type="hidden" name="id_warung_hidden" id="id_warung_hidden">
                        
                        <div class="form-group">
                            <label for="nama_warung" class="form-label">Nama Warung:</label>
                            <input type="text" id="nama_warung" name="nama_tenant" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi:</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_kontak" class="form-label">Nomor Kontak:</label>
                            <input type="text" id="no_kontak" name="no_kontak" class="form-control">
                        </div>
                        
                        <div class="form-group" style="display: flex; gap: 20px;">
                            <div style="flex-grow: 1;">
                                <label for="jam_buka" class="form-label">Jam Buka:</label>
                                <input type="time" id="jam_buka" name="jam_buka" class="form-control">
                            </div>
                            <div style="flex-grow: 1;">
                                <label for="jam_tutup" class="form-label">Jam Tutup:</label>
                                <input type="time" id="jam_tutup" name="jam_tutup" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar Warung:</label>
                            <input type="file" id="gambar" name="gambar" class="form-control">
                            <small id="gambar_saat_ini" style="color:#007bff; display:none;">Gambar saat ini: -</small>
                        </div>

                        <button type="submit" name="submit_warung" class="btn-action primary">Simpan Warung</button>
                        <button type="button" class="btn-action secondary" onclick="hideForm()">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script>
        // Fungsi untuk menampilkan form dan meresetnya untuk Tambah Baru
        function showForm() {
            document.getElementById('form-title').innerText = 'Tambah Warung Baru';
            document.getElementById('id_warung_hidden').value = '';
            document.getElementById('warung-form').reset();
            document.getElementById('gambar_saat_ini').style.display = 'none';
            document.getElementById('form-warung-card').style.display = 'block';
            window.scrollTo(0, document.body.scrollHeight);
        }

        // Fungsi untuk menyembunyikan form
        function hideForm() {
            document.getElementById('form-warung-card').style.display = 'none';
        }

        // Fungsi AJAX untuk mengisi form saat tombol Edit diklik
        function editWarung(id) {
            fetch(`kelolawarung.php?action=get_data&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    document.getElementById('form-title').innerText = 'Edit Warung ' + id;
                    document.getElementById('id_warung_hidden').value = id;
                    
                    // Mengisi nilai form sesuai data DB
                    document.getElementById('nama_warung').value = data.nama_tenant;
                    document.getElementById('deskripsi').value = data.deskripsi;
                    document.getElementById('no_kontak').value = data.no_kontak;
                    document.getElementById('jam_buka').value = data.jam_buka;
                    document.getElementById('jam_tutup').value = data.jam_tutup;
                    
                    // Menampilkan informasi gambar saat ini
                    const imgInfo = document.getElementById('gambar_saat_ini');
                    if (data.gambar) {
                        imgInfo.innerText = `Gambar saat ini: ${data.gambar}`;
                        imgInfo.style.display = 'block';
                    } else {
                        imgInfo.style.display = 'none';
                    }

                    document.getElementById('form-warung-card').style.display = 'block';
                    window.scrollTo(0, document.body.scrollHeight);
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
</body>
</html>

<?php
// =========================================================================
// 3. LOGIKA CRUD (CREATE, UPDATE, DELETE)
// =========================================================================

if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }


// --- Fungsi Upload Gambar ---
function upload_gambar($file) {
    // Pastikan Anda sudah membuat folder 'uploads/tenant/' di root project
    $target_dir = "../uploads/tenant/"; 
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_file_name = uniqid('tenant_') . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;

    // Periksa dan pindahkan file (logika sederhana)
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $new_file_name;
    } else {
        return false;
    }
}


// --- A. Logika TAMBAH / UPDATE Data ---
if (isset($_POST['submit_warung'])) {
    $id_warung = $_POST['id_warung_hidden'];
    $nama_tenant = $conn->real_escape_string($_POST['nama_tenant']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $no_kontak = $conn->real_escape_string($_POST['no_kontak']);
    $jam_buka = $conn->real_escape_string($_POST['jam_buka']);
    $jam_tutup = $conn->real_escape_string($_POST['jam_tutup']);
    
    $nama_gambar = null;
    $upload_success = true;
    
    // Cek apakah ada file gambar baru diupload
    if (!empty($_FILES['gambar']['name'])) {
        $nama_gambar = upload_gambar($_FILES['gambar']);
        if (!$nama_gambar) {
            $upload_success = false;
            echo "<script>alert('Gagal mengupload gambar.');</script>";
        }
    }

    if ($upload_success) {
        if (empty($id_warung)) {
            // Logika INSERT (Tambah Baru)
            $stmt = $conn->prepare("INSERT INTO tenant (nama_tenant, deskripsi, no_kontak, jam_buka, jam_tutup, gambar) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nama_tenant, $deskripsi, $no_kontak, $jam_buka, $jam_tutup, $nama_gambar);
        } else {
            // Logika UPDATE (Edit)
            if ($nama_gambar) {
                // Update dengan gambar baru
                $stmt = $conn->prepare("UPDATE tenant SET nama_tenant=?, deskripsi=?, no_kontak=?, jam_buka=?, jam_tutup=?, gambar=? WHERE tenant_id=?");
                $stmt->bind_param("ssssssi", $nama_tenant, $deskripsi, $no_kontak, $jam_buka, $jam_tutup, $nama_gambar, $id_warung);
            } else {
                // Update tanpa mengubah gambar
                $stmt = $conn->prepare("UPDATE tenant SET nama_tenant=?, deskripsi=?, no_kontak=?, jam_buka=?, jam_tutup=? WHERE tenant_id=?");
                $stmt->bind_param("sssssi", $nama_tenant, $deskripsi, $no_kontak, $jam_buka, $jam_tutup, $id_warung);
            }
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data warung berhasil disimpan!'); window.location.href='kelolawarung.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}

// --- B. Logika HAPUS Data ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_warung_to_delete = $conn->real_escape_string($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM tenant WHERE tenant_id = ?");
    $stmt->bind_param("i", $id_warung_to_delete);
    
    if ($stmt->execute()) {
        echo "<script>alert('Warung berhasil dihapus!'); window.location.href='kelolawarung.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus warung: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>