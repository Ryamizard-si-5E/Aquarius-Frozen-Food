<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .card:hover { cursor: pointer; transform: scale(1.02); }
  </style>
</head>
<?php echo $__env->make('Components.header2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show text-center mt-3" role="alert">
        <strong>✅ Berhasil!</strong> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center mt-3" role="alert">
        <strong>⚠️ Gagal!</strong> <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<body>
<div class="container py-5">
  <h2 class="text-center mb-5 fw-bold">📦 Semua Produk Kami</h2>
  <div class="row g-4">
    <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
      <!-- Card Produk -->
      <div class="card h-100 shadow-sm product-card border-0" role="button" data-bs-toggle="modal" data-bs-target="#popup-<?php echo e($barang->id_barang); ?>">
        <div class="position-relative">
          <img src="<?php echo e(asset('images/'.$barang->gambar)); ?>" class="card-img-top product-img rounded-top" alt="<?php echo e($barang->nama_barang); ?>">

          <?php if($barang->stok == 0): ?>
            <!-- Badge stok habis -->
            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2 rounded-pill">Stok Habis</span>
          <?php else: ?>
            <!-- Badge stok tersedia -->
            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Stok: <?php echo e($barang->stok); ?></span>
          <?php endif; ?>
        </div>
        <div class="card-body text-center">
          <h5 class="card-title fw-bold"><?php echo e($barang->nama_barang); ?></h5>
          <p class="card-text text-success fw-semibold">Rp <?php echo e(number_format($barang->harga)); ?>/<?php echo e($barang->satuan); ?></p>
        </div>
      </div>
    </div>

    <!-- Modal Detail Produk -->
<div class="modal fade" id="popup-<?php echo e($barang->id_barang); ?>" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold"><?php echo e($barang->nama_barang); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <!-- Gambar Produk -->
          <div class="col-md-6 text-center">
            <img src="<?php echo e(asset('images/'.$barang->gambar)); ?>" 
                 class="img-fluid rounded shadow-sm mb-3">
          </div>

          <!-- Detail Produk -->
          <div class="col-md-6">
            <p><strong>Harga:</strong> <span class="text-success">Rp <?php echo e(number_format($barang->harga)); ?>/<?php echo e($barang->satuan); ?></span></p>
            <p><strong>Stok:</strong> <?php echo e($barang->stok); ?></p>

            <?php if($barang->stok > 0): ?>
              <!-- Jika stok masih ada -->
              <form method="POST" action="<?php echo e(route('keranjang.tambah', $barang->id_barang)); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                  <label for="jumlah-<?php echo e($barang->id_barang); ?>" class="form-label">Jumlah</label>
                  <input type="number" name="jumlah" id="jumlah-<?php echo e($barang->id_barang); ?>" 
                         class="form-control" min="1" max="<?php echo e($barang->stok); ?>" value="1">
                </div>

                <?php if(auth()->guard()->check()): ?>
                  <button type="submit" class="btn btn-success w-100 rounded-pill">🛒 Masukkan ke Keranjang</button>
                <?php else: ?>
                  <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 rounded-pill"
                     onclick="alert('Silakan login terlebih dahulu untuk menambahkan ke keranjang');">
                    🛒 Masukkan ke Keranjang
                  </a>
                <?php endif; ?>
              </form>
            <?php else: ?>
              <!-- Jika stok habis -->
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class="me-2">❌</span>
                <div>Maaf, stok produk ini sudah habis.</div>
              </div>
              <button class="btn btn-secondary w-100 rounded-pill" disabled>
                🛒 Masukkan ke Keranjang
              </button>
            <?php endif; ?>

          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>

<!-- CSS tambahan biar gambar seragam + efek hover -->
<style>
    /* Judul Section */
    .section-title {
      font-weight: 800;
      text-align: center;
      margin-bottom: 50px;
      position: relative;
      font-size: 2rem;
    }
    .section-title::after {
      content: "";
      display: block;
      width: 80px;
      height: 4px;
      background: #1abc9c;
      margin: 10px auto 0;
      border-radius: 10px;
      animation: expand 2s infinite alternate;
    }
    @keyframes expand {
      from { width: 40px; }
      to { width: 120px; }
    }

    /* Card Produk */
    .product-card {
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.4s ease;
      background: #fff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    .product-img {
      height: 220px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
      transform: scale(1.1);
    }

    /* Badge stok / promo */
    .badge-custom {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #f39c12;
      color: white;
      padding: 6px 12px;
      border-radius: 15px;
      font-size: 0.85rem;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    /* Modal */
    .modal-content {
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .modal-header {
      background: #f8f9fa;
      border-bottom: none;
    }
    .modal-footer {
      background: #f8f9fa;
      border-top: none;
    }
  </style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->make('Components.footer2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/dashboard.blade.php ENDPATH**/ ?>