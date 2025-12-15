<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Aquarius Frozen Food</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    /* Hero Section Fullscreen */
    .hero-section {
      position: relative;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(135deg, #1abc9c, #16a085, #2ecc71);
      background-size: 300% 300%;
      animation: gradientMove 10s ease infinite;
      color: white;
      padding: 20px;
      overflow: hidden;
    }
    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      animation: float 6s ease-in-out infinite alternate;
      z-index: 0;
    }
    .circle1 { width: 200px; height: 200px; top: 10%; left: 15%; animation-delay: 0s; }
    .circle2 { width: 300px; height: 300px; bottom: 15%; right: 10%; animation-delay: 2s; }
    .circle3 { width: 150px; height: 150px; bottom: 5%; left: 5%; animation-delay: 4s; }

    @keyframes float {
      from { transform: translateY(0px); }
      to { transform: translateY(-30px); }
    }

    .hero-title {
      font-size: 3rem;
      font-weight: 800;
      animation: fadeInUp 1s ease forwards;
      opacity: 0;
      z-index: 1;
    }
    .hero-subtitle {
      font-size: 1.5rem;
      margin: 20px 0;
      animation: fadeInUp 1.5s ease forwards;
      opacity: 0;
      animation-delay: 0.5s;
      z-index: 1;
    }
    .hero-btn {
      padding: 12px 25px;
      font-size: 1.2rem;
      border-radius: 30px;
      border: none;
      background-color: #fff;
      color: #2c3e50;
      font-weight: 600;
      transition: transform 0.3s ease, background-color 0.3s ease;
      animation: fadeInUp 2s ease forwards;
      opacity: 0;
      animation-delay: 1s;
      z-index: 1;
    }
    .hero-btn:hover {
      transform: scale(1.05);
      background-color: #f1f1f1;
    }
    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    @keyframes fadeInUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Tombol Sosial Media */
    .btn-social {
      color: white;
      border-radius: 50px;
      font-weight: 600;
      padding: 12px 25px;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 1.5s ease forwards;
    }
    .btn-social:nth-child(1) { animation-delay: 0.8s; }
    .btn-social:nth-child(2) { animation-delay: 1s; }
    .btn-social:nth-child(3) { animation-delay: 1.2s; }

    .btn-social:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 10px 20px rgba(0,0,0,0.25);
      opacity: 0.95;
    }

    /* Produk Card & Modal */
    .section-title {
      font-weight: 800;
      position: relative;
      display: inline-block;
    }
    .section-title::after {
      content: "";
      display: block;
      width: 60%;
      height: 4px;
      background: #1abc9c;
      margin: 10px auto 0;
      border-radius: 10px;
    }
    .product-card {
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.4s ease;
      cursor: pointer;
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .product-img {
      height: 220px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
      transform: scale(1.08);
    }
    .badge-custom {
      position: absolute;
      top: 15px;
      left: 15px;
      background: #e74c3c;
      color: white;
      padding: 6px 12px;
      border-radius: 15px;
      font-size: 0.85rem;
      font-weight: 600;
    }
    .btn-gradient {
      background: linear-gradient(135deg, #1abc9c, #16a085, #2ecc71);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-gradient:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }
    .modal-content {
      border-radius: 20px;
    }
  </style>
</head>

<?php echo $__env->make('Components.header3', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>

<!-- Hero Section -->
<section class="hero-section">
  <div class="circle circle1"></div>
  <div class="circle circle2"></div>
  <div class="circle circle3"></div>
  
  <h1 class="hero-title">Selamat Datang di Aquarius Frozen Food 🧊</h1>
  <p class="hero-subtitle">Menyediakan berbagai macam makanan beku berkualitas tinggi dan siap masak untuk keluarga Anda.</p>
  
  <!-- Tombol Sosial Media -->
  <div class="d-flex gap-3 mt-4 justify-content-center z-1">
    <a href="https://www.instagram.com/aquariusfrozenfood" target="_blank" 
       class="btn btn-lg btn-social"
       style="background: linear-gradient(45deg,#feda75,#fa7e1e,#d62976,#962fbf,#4f5bd5);">
      📷 Instagram
    </a>
    <a href="https://www.google.com/maps/place/Aquarius+Frozen+Food/@0.8991243,108.9787473,17z" target="_blank" 
       class="btn btn-lg btn-social"
       style="background: #4285F4;">
      📍 Maps
    </a>
    <a href="https://wa.me/628125628425" target="_blank" 
       class="btn btn-lg btn-social"
       style="background: #25D366;">
      💬 WhatsApp
    </a>
  </div>

  <!-- Tombol Lihat Produk -->
  <a href="#produk-unggulan" class="hero-btn mt-4">Lihat Produk</a>
</section>

<!-- Produk Unggulan -->
<div class="container py-5" id="produk-unggulan">
  <div class="text-center mb-5">
    <h2 class="section-title">✨ Produk Unggulan ✨</h2>
    <p class="text-muted">Pilihan terbaik yang paling diminati pelanggan kami</p>
  </div>

  <div class="row g-4">
    <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3">
      <!-- Card Produk -->
      <div class="card product-card h-100 shadow-sm" 
           data-bs-toggle="modal" 
           data-bs-target="#popup-<?php echo e($barang->id_barang); ?>">
        
        <?php if($barang->stok > 50): ?>
          <span class="badge badge-custom">Best Seller</span>
        <?php endif; ?>

        <img src="<?php echo e(asset('images/'.$barang->gambar)); ?>" 
             class="card-img-top product-img" 
             alt="<?php echo e($barang->nama_barang); ?>">
        <div class="card-body text-center">
          <h5 class="card-title fw-bold"><?php echo e($barang->nama_barang); ?></h5>
          <p class="card-text text-success fs-5">Rp <?php echo e(number_format($barang->harga)); ?>/<?php echo e($barang->satuan); ?></p>

          
          <?php if($barang->stok == 0): ?>
            <span class="badge bg-danger">Stok Habis</span>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Modal Detail Produk -->
<div class="modal fade" id="popup-<?php echo e($barang->id_barang); ?>" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php echo e($barang->nama_barang); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img src="<?php echo e(asset('images/'.$barang->gambar)); ?>" class="img-fluid rounded shadow mb-3">
          </div>
          <div class="col-md-6">
            <p class="text-muted"><?php echo e($barang->deskripsi); ?></p>
            <p><strong>Harga:</strong> Rp <?php echo e(number_format($barang->harga)); ?>/<?php echo e($barang->satuan); ?></p>
            <p><strong>Stok:</strong> <?php echo e($barang->stok); ?></p>

            <?php if($barang->stok > 0): ?>
              <div class="mb-3">
                <label for="jumlah-<?php echo e($barang->id_barang); ?>" class="form-label">Jumlah</label>
                <input type="number" class="form-control" min="1" max="<?php echo e($barang->stok); ?>" value="1" disabled>
              </div>
              <a href="#"
   class="btn btn-gradient w-100"
   onclick="showLoginAlert(event)">
   🛒 Masukkan ke Keranjang
</a>
            <?php else: ?>
              <!-- ALERT jika stok habis -->
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class="me-2">❌</span>
                <div>Maaf, stok produk ini sudah habis.</div>
              </div>
              <!-- Tombol nonaktif -->
              <button class="btn btn-secondary w-100" disabled>
                🛒 Masukkan ke Keranjang
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- Tombol Selengkapnya -->
  <div class="text-center mt-5">
    <a href="<?php echo e(route('index')); ?>" class="btn btn-lg btn-gradient">
      Lihat Semua Produk →
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showLoginAlert(e) {
    e.preventDefault(); // supaya tidak langsung ke login
    Swal.fire({
        icon: 'warning',
        title: 'Login Dulu!',
        text: 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang',
        confirmButtonText: 'Login Sekarang'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo e(route('login')); ?>";
        }
    });
}
</script>

<?php echo $__env->make('Components.footer3', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/awal.blade.php ENDPATH**/ ?>