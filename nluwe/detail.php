<?php
require 'koneksi.php';

if (!isset($_GET['tenant_id'])) {
  header('Location: katalog.php');
  exit;
}

$tenant_id = (int) $_GET['tenant_id'];


$sqlTenant = "SELECT * FROM tenant WHERE tenant_id = $tenant_id LIMIT 1";
$resTenant = mysqli_query($conn, $sqlTenant);

if (!$resTenant) {
  die("Query tenant error: " . mysqli_error($conn));
}

$tenant = mysqli_fetch_assoc($resTenant);
if (!$tenant) {

  die("Tenant tidak ditemukan.");
}


$sqlMenu = "SELECT * FROM menu WHERE tenant_id = $tenant_id";
$menuQuery = mysqli_query($conn, $sqlMenu);

if (!$menuQuery) {
  die("Query menu error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="" />

  <title>Nesa Luwe - UNESA Laper</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link
    rel="stylesheet"
    type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
    integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
    crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/detail-style.css" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />

</head>

<body class="sub_page">
  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="" />
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="beranda.php">
            <span> Nesa Luwe </span>
          </a>

          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class=""></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="beranda.php">Beranda</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="katalog.php">Katalog</a>
                <span class="sr-only">(current)</span>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="ulasan.php">Ulasan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tentang.php">Tentang</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <div class="container-warung">
    <!-- Header -->
    <div class="deskripsi">
      <button class="btn-back" onclick="history.back()">
        <img src="images/ic-back_97586.svg" alt="Kembali" class="icon-back">
      </button>

      <div class="header-warung">
        <img src="db/<?= $tenant['gambar'] ?>" alt="<?= $tenant['nama_tenant'] ?>" class="store-img" />
        <div class="store-info">
          <h1><?= $tenant['nama_tenant'] ?></h1>
          <p class="category"><?= $tenant['deskripsi'] ?></p>

          <div class="info-boxes">
            <div class="info-box">
              <p class="title">Jam Buka</p>
              <p class="content"><?= $tenant['jam_buka'] ?> – <?= $tenant['jam_tutup'] ?></p>
            </div>

            <div class="info-box">
              <div class="info-rating">
                <p class="rating">⭐ 4.9/5</p>
                <a href="cobacoba.php" class="review-link">Lihat review</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Menu Section (loop banyak) -->
    <h2 class="section-title">Makanan & Minuman</h2>
    <div class="menu-grid">
      <?php
      // Looping menu; pastikan ada data
      if (mysqli_num_rows($menuQuery) > 0):
        while ($row = mysqli_fetch_assoc($menuQuery)):
      ?>
          <div class="menu-item">
            <img src="db/<?= $row['gambar_menu'] ?>" alt="<?= $row['nama_menu'] ?>" />
            <h3><?= $row['nama_menu'] ?></h3>
            <p>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></p>
          </div>
        <?php
        endwhile;
      else:
        ?>
        <p>Tidak ada menu untuk tenant ini.</p>
      <?php endif; ?>
    </div>
  </div>


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <div class="row">
        <div class="col-md-4 footer-col">
          <div class="footer_contact">
            <h4>Contact Us</h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> Footcourt Unesa Ketintang </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span> Call +62 858-2064-0790 </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> ikfiardanikharisma@gmail.com </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <div class="footer_detail">
            <a href="" class="footer-logo"> Nesa Luwe </a>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <h4>Opening Hours</h4>
          <p>Everyday</p>
          <p>07.00 Am - 20.00 Pm</p>
        </div>
      </div>
      <div class="footer-info">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          Kelompok 4 SI 2024 E
        </p>
      </div>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  </script>
</body>

</html>