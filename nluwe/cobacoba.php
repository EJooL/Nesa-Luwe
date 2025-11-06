<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Warung Soto Bakso P'Ji - Ulasan</title>
  <link rel="stylesheet" href="cobacoba.css" />
  <!-- Font Awesome untuk ikon bintang -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <header class="topbar">
    <button class="btn-back" onclick="history.back()">
      <img src="images/ic-back_97586.svg" alt="Kembali" class="icon-back">
    </button>
    <h1 class="title">Warung Soto Bakso P'Ji</h1>
  </header>

  <main class="container">
    <section class="hero">
      <div class="rating-card">
        <div class="score">
          <div class="value">4.9/5</div>
          <div class="sub">1k+ ratings</div>
        </div>
        <div class="stars">★★★★★</div>
      </div>

      <button id="tambahUlasanBtn" class="btn-tambah">
        ✎ Tambah Ulasan
      </button>
    </section>

    <section class="ulasan" aria-labelledby="ulasan-heading">
      <h2 id="ulasan-heading">Ulasan</h2>

      <!-- contoh ulasan -->
      <article class="review">
        <div class="profil">
          <img src="https://i.pravatar.cc/80?img=5" alt="avatar" />
          <div class="meta">
            <div class="name">Kuki Kharisma</div>
            <div class="starline">★★★★★</div>
          </div>
        </div>
        <p class="review-text">
          Suasana ok. Pelayanan super lama. Sekali datang ga enak. Padahal langganan dari lama gacoan...
        </p>
      </article>

      <!-- tempat menambahkan ulasan baru (JS akan memasukkan elemen di sini) -->
      <div id="reviewsList"></div>
    </section>
  </main>

  <!-- Modal form -->
  <div id="modal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-content" role="document">
      <button id="closeModal" class="modal-close" aria-label="tutup">✕</button>
      <h3>Tambah Ulasan</h3>
      <form id="reviewForm">
        <label>
          Nama
          <input type="text" name="name" required />
        </label>

        <label>
          Rating
          <div class="rating-input" id="starRating">
            <i class="fa fa-star" data-value="1"></i>
            <i class="fa fa-star" data-value="2"></i>
            <i class="fa fa-star" data-value="3"></i>
            <i class="fa fa-star" data-value="4"></i>
            <i class="fa fa-star" data-value="5"></i>
          </div>
          <input type="hidden" name="rating" id="ratingInput" required>
        </label>

        <label>
          Ulasan
          <textarea name="text" rows="4" required></textarea>
        </label>

        <div class="modal-actions">
          <button type="button" id="cancelBtn" class="btn-secondary">Batal</button>
          <button type="submit" class="btn-primary">Kirim</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // modal handling
    const tambahBtn = document.getElementById('tambahUlasanBtn');
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('reviewForm');
    const reviewsList = document.getElementById('reviewsList');

    function openModal() {
      modal.style.display = 'flex';
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      form.name.focus();
    }

    function hideModal() {
      modal.style.display = 'none';
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      form.reset();

      // reset bintang
      stars.forEach(s => {
        s.classList.remove('selected');
        s.style.color = '#ccc';
      });
      ratingInput.value = '';
    }

    tambahBtn.addEventListener('click', openModal);
    closeModal.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);
    modal.addEventListener('click', (e) => {
      if (e.target === modal) hideModal();
    });

    // submit form -> buat elemen ulasan dan tambahkan ke daftar
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const data = new FormData(form);
      const name = data.get('name').trim();
      const rating = data.get('rating');
      const text = data.get('text').trim();

      // create review node
      const article = document.createElement('article');
      article.className = 'review';

      const profil = document.createElement('div');
      profil.className = 'profil';

      const avatar = document.createElement('img');
      const avatarId = Math.abs(hashCode(name)) % 70 + 1;
      avatar.src = 'https://i.pravatar.cc/80?img=' + avatarId;
      avatar.alt = name + ' avatar';

      const meta = document.createElement('div');
      meta.className = 'meta';

      const n = document.createElement('div');
      n.className = 'name';
      n.textContent = name;

      const s = document.createElement('div');
      s.className = 'starline';
      s.textContent = '★'.repeat(Number(rating)) + '☆'.repeat(5 - Number(rating));

      meta.appendChild(n);
      meta.appendChild(s);
      profil.appendChild(avatar);
      profil.appendChild(meta);

      const p = document.createElement('p');
      p.className = 'review-text';
      p.textContent = text;

      article.appendChild(profil);
      article.appendChild(p);

      reviewsList.prepend(article);

      hideModal();
    });

    // helper simple untuk hash nama -> avatar id
    function hashCode(str) {
      let h = 0;
      for (let i = 0; i < str.length; i++) {
        h = (h << 5) - h + str.charCodeAt(i);
        h |= 0;
      }
      return h;
    }

    // interaksi klik bintang
    const starContainer = document.getElementById('starRating');
    const stars = starContainer.querySelectorAll('.fa-star');
    const ratingInput = document.getElementById('ratingInput');

    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        const value = index + 1;
        ratingInput.value = value;

        // ubah tampilan bintang aktif
        stars.forEach((s, i) => {
          s.classList.toggle('selected', i < value);
        });
      });

      // efek hover preview
      star.addEventListener('mouseover', () => {
        const hoverValue = index + 1;
        stars.forEach((s, i) => {
          s.style.color = i < hoverValue ? '#f6c600' : '#ccc';
        });
      });

      star.addEventListener('mouseout', () => {
        const selectedValue = Number(ratingInput.value);
        stars.forEach((s, i) => {
          s.style.color = i < selectedValue ? '#f6c600' : '#ccc';
        });
      });
    });

    // inisialisasi modal disembunyikan
    hideModal();
  </script>
</body>

</html>