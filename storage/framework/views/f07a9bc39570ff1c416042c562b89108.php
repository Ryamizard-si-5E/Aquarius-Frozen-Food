<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    /* Judul Section */
    .section-title {
      font-weight: 800;
      text-align: center;
      margin: 40px 0 30px;
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

    /* Card Notifikasi */
    .notif-card {
      border-radius: 15px;
      padding: 15px 20px;
      margin-bottom: 15px;
      background: #ffffff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      transition: 0.3s ease;
      position: relative;
    }
    .notif-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* Ikon Notifikasi */
    .notif-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      font-size: 1.2rem;
      color: #fff;
      background: linear-gradient(135deg, #1abc9c, #16a085);
    }

    .notif-time {
      font-size: 0.85rem;
      color: #888;
    }

    /* Badge pengiriman */
    .status-badge {
      font-size: 0.85rem;
      padding: 5px 10px;
      border-radius: 20px;
      font-weight: 600;
    }
    .diproses { background: #f1c40f; color: #fff; }
    .dikirim { background: #3498db; color: #fff; }
    .selesai { background: #2ecc71; color: #fff; }
  </style>
</head>
<?php echo $__env->make('Components.header2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>

<div class="container py-5">
  <h2 class="section-title">🔔 Notifikasi Anda</h2>

  <?php if(session('success')): ?>
      <div class="alert alert-success text-center rounded-pill"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <?php if($notifikasi->isEmpty()): ?>
      <div class="alert alert-info text-center">Tidak ada notifikasi.</div>
  <?php else: ?>
      <div class="list-group">
          <?php $__currentLoopData = $notifikasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="notif-card d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                      <div class="notif-icon">📩</div>
                      <div>
                          <p class="mb-1"><?php echo e($notif->pesan); ?></p>
                          <small class="notif-time"><?php echo e($notif->created_at->diffForHumans()); ?></small>
                      </div>
                  </div>

                  
                  <?php if($notif->metode_pengiriman == 'kirim'): ?>
                      <span class="status-badge 
                        <?php if($notif->status_pengiriman == 'diproses'): ?> diproses 
                        <?php elseif($notif->status_pengiriman == 'dikirim'): ?> dikirim 
                        <?php elseif($notif->status_pengiriman == 'selesai'): ?> selesai 
                        <?php endif; ?>">
                          <?php echo e(ucfirst($notif->status_pengiriman)); ?>

                      </span>
                  <?php endif; ?>
              </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  <?php endif; ?>
</div>

<?php echo $__env->make('Components.footer2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/notifikasi.blade.php ENDPATH**/ ?>