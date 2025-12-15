<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
        }
        .table thead th {
            background: #000000;
            color: white;
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #f1f5ff;
            transition: 0.2s;
        }
        .badge {
            font-size: 0.85rem;
            padding: 6px 10px;
            border-radius: 8px;
        }
        .badge-metode {
            background-color: #0d3b66;
            color: #fff;
        }
        .btn-sm {
            border-radius: 8px;
        }
        .img-thumbnail {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .img-thumbnail:hover {
            transform: scale(1.05);
        }
    </style>
</head>


<?php echo $__env->make('Components.header-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4 text-center fw-bold text-dark">📦 Daftar Transaksi</h2>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Harga Barang</th>
                            <th>Ongkir</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Metode Pengiriman</th>
                            <th>Jarak</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Bukti Pembayaran</th>
                            <th>Detail Barang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-semibold"><?php echo e($t->id_transaksi); ?></td>
                            <td><?php echo e($t->pelanggan->nama_pelanggan ?? '-'); ?></td>

                            <td class="text-primary fw-semibold">
                                Rp <?php echo e(number_format($t->total_barang, 0, ',', '.')); ?>

                            </td>

                            <td class="text-info fw-semibold">
                                Rp <?php echo e(number_format($t->ongkir, 0, ',', '.')); ?>

                            </td>

                            <td class="text-success fw-bold">
                                Rp <?php echo e(number_format($t->total_harga, 0, ',', '.')); ?>

                            </td>

                            <td><span class="badge badge-metode"><?php echo e($t->metode); ?></span></td>

                            <td>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($t->metode_pengiriman)); ?></span>
                            </td>

                            <td>
                                <?php if($t->jarak): ?>
                                    <?php echo e($t->jarak); ?> km
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($t->alamatt ?? '-'); ?></td>


                            <td><?php echo e($t->tanggal); ?></td>

                            <td class="text-center">
                                <?php if($t->bukti_pembayaran): ?>
                                    <img src="<?php echo e(asset('storage/' . $t->bukti_pembayaran)); ?>" 
                                         alt="Bukti" width="80" class="img-thumbnail"
                                         data-bs-toggle="modal" data-bs-target="#modalBukti<?php echo e($t->id_transaksi); ?>">
                                    <div class="modal fade" id="modalBukti<?php echo e($t->id_transaksi); ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <img src="<?php echo e(asset('storage/' . $t->bukti_pembayaran)); ?>" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Tidak ada bukti</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <ul class="mb-0 ps-3 text-start">
                                    <?php $__currentLoopData = $t->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($d->barang->nama_barang ?? '-'); ?> 
                                            <span class="badge bg-secondary"><?php echo e($d->jumlah_barang); ?> pcs</span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </td>

                            <td>
                                <span class="badge 
                                    <?php echo e($t->status === 'pending' ? 'bg-warning text-dark' : ($t->status === 'diterima' ? 'bg-success' : 'bg-danger')); ?>">
                                    <?php echo e(ucfirst($t->status)); ?>

                                </span>
                            </td>

                            <td>
                                <?php if($t->status === 'pending'): ?>
                                    <form action="<?php echo e(route('admin.transaksi.terima', $t->id_transaksi)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        
                                        <button type="submit" class="btn btn-success btn-sm mb-1"
                                                onclick="return confirm('Yakin ingin menerima transaksi ini?')">
                                            <i class="bi bi-check-circle"></i> Terima
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.transaksi.tolak', $t->id_transaksi)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                <?php elseif($t->status === 'diterima' && $t->metode_pengiriman === 'kirim'): ?>
                                    
                                    <?php if($t->status_pengiriman === null): ?>
                                        <form action="<?php echo e(route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'diproses'])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-hourglass-split"></i> Diproses
                                            </button>
                                        </form>
                                    <?php elseif($t->status_pengiriman === 'diproses'): ?>
                                        <form action="<?php echo e(route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'dikirim'])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-truck"></i> Dikirim
                                            </button>
                                        </form>
                                    <?php elseif($t->status_pengiriman === 'dikirim'): ?>
                                        <form action="<?php echo e(route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'selesai'])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check2-circle"></i> Selesai
                                            </button>
                                        </form>
                                    <?php elseif($t->status_pengiriman === 'selesai'): ?>
                                        <span class="badge bg-success">Pengiriman selesai</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <em class="text-muted">Tidak ada aksi</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">🚫 Belum ada transaksi</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


<?php echo $__env->make('Components.footer-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/transaksi.blade.php ENDPATH**/ ?>