<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php echo $__env->make('Components.header-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="text-center mb-4 fw-bold">📊 Laporan Penjualan</h2>

            
            <form class="row g-3 mb-4" method="GET">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo e($tanggal); ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Bulan</label>
                    <input type="month" name="bulan" value="<?php echo e($bulan); ?>" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            
            <div class="row text-center">
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-success text-white rounded-4">
                        <h4>Total Penjualan Hari Ini</h4>
                        <h3>Rp <?php echo e(number_format($penjualanPerHari, 0, ',', '.')); ?></h3>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-info text-white rounded-4">
                        <h4>Total Penjualan Bulan Ini</h4>
                        <h3>Rp <?php echo e(number_format($penjualanPerBulan, 0, ',', '.')); ?></h3>
                    </div>
                </div>
            </div>

            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="fw-bold text-success">Produk Terlaris</h5>
                        <?php if($produkTerlaris): ?>
                            <p><?php echo e($produkTerlaris->barang->nama_barang); ?> <br>
                            Terjual: <b><?php echo e($produkTerlaris->total_terjual); ?></b></p>
                        <?php else: ?>
                            <p class="text-muted">Belum ada data</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="fw-bold text-danger">Produk Paling Sedikit Terjual</h5>
                        <?php if($produkTersepi): ?>
                            <p><?php echo e($produkTersepi->barang->nama_barang); ?> <br>
                            Terjual: <b><?php echo e($produkTersepi->total_terjual); ?></b></p>
                        <?php else: ?>
                            <p class="text-muted">Belum ada data</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="mt-4">
                <canvas id="chartProduk"></canvas>
            </div>

            
<div class="mt-5">
    <h4 class="fw-bold mb-3">🗓️ Detail Transaksi Hari <?php echo e($tanggal); ?></h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID Transaksi</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transaksiPerHari; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($detail->id_transaksi); ?></td>
                    <td><?php echo e(optional(optional($detail->transaksi)->pelanggan)->nama_pelanggan ?? 'Tidak Diketahui'); ?></td>
                    <td><?php echo e(optional($detail->barang)->nama_barang ?? 'Produk Hilang'); ?></td>
                    <td><?php echo e($detail->jumlah_barang); ?></td>
                    <td>
                        Rp <?php echo e(number_format(optional($detail->transaksi)->total_barang ?? 0, 0, ',', '.')); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi hari ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<div class="mt-5">
    <h4 class="fw-bold mb-3">📅 Detail Transaksi Bulan <?php echo e($bulan); ?></h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID Transaksi</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transaksiPerBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($detail->id_transaksi); ?></td>
                    <td><?php echo e(optional(optional($detail->transaksi)->pelanggan)->nama_pelanggan ?? 'Tidak Diketahui'); ?></td>
                    <td><?php echo e(optional($detail->barang)->nama_barang ?? 'Produk Hilang'); ?></td>
                    <td><?php echo e($detail->jumlah_barang); ?></td>
                    <td>
                        Rp <?php echo e(number_format(optional($detail->transaksi)->total_barang ?? 0, 0, ',', '.')); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi bulan ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="text-end mb-3">
    <a href="<?php echo e(route('laporan.download', ['tanggal' => $tanggal, 'bulan' => $bulan])); ?>" 
       class="btn btn-danger btn-lg rounded-3 shadow-sm">
       📥 Download PDF
    </a>
</div>


        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('chartProduk');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($produkTerjual->pluck('barang.nama_barang'), 15, 512) ?>,
        datasets: [{
            label: 'Jumlah Terjual',
            data: <?php echo json_encode($produkTerjual->pluck('total_terjual'), 15, 512) ?>,
            borderWidth: 1,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?php echo $__env->make('Components.footer-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/laporan-penjualan.blade.php ENDPATH**/ ?>