<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        h2, h3, h4 {
            text-align: center;
            margin-bottom: 10px;
        }
        .summary {
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .section-title {
            background: #e8e8e8;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 25px;
        }
    </style>
</head>
<body>

    <h2>Aquarius Frozen Food</h2>
    <h3>Laporan Penjualan</h3>
    <p style="text-align:center;">Tanggal: <?php echo e($tanggal); ?> | Bulan: <?php echo e($bulan); ?></p>
    <hr>

    <div class="summary">
        <table>
            <tr>
                <th>Total Penjualan Hari Ini</th>
                <td>Rp <?php echo e(number_format($penjualanPerHari, 0, ',', '.')); ?></td>
            </tr>
            <tr>
                <th>Total Penjualan Bulan Ini</th>
                <td>Rp <?php echo e(number_format($penjualanPerBulan, 0, ',', '.')); ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Produk Terlaris</th>
                <td>
                    <?php echo e($produkTerlaris?->barang?->nama_barang ?? '-'); ?><br>
                    Terjual: <?php echo e($produkTerlaris?->total_terjual ?? 0); ?>

                </td>
            </tr>
            <tr>
                <th>Produk Paling Sedikit Terjual</th>
                <td>
                    <?php echo e($produkTersepi?->barang?->nama_barang ?? '-'); ?><br>
                    Terjual: <?php echo e($produkTersepi?->total_terjual ?? 0); ?>

                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">🗓️ Detail Transaksi Hari <?php echo e($tanggal); ?></div>
    <table>
        <thead>
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
                    <td><?php echo e($detail->transaksi->pelanggan->nama_pelanggan ?? '-'); ?></td>
                    <td><?php echo e($detail->barang->nama_barang ?? '-'); ?></td>
                    <td><?php echo e($detail->jumlah_barang); ?></td>
                    <td>Rp <?php echo e(number_format($detail->transaksi->total_barang ?? 0, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" style="text-align:center;">Tidak ada transaksi hari ini</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="section-title">📅 Detail Transaksi Bulan <?php echo e($bulan); ?></div>
    <table>
        <thead>
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
                    <td><?php echo e($detail->transaksi->pelanggan->nama_pelanggan ?? '-'); ?></td>
                    <td><?php echo e($detail->barang->nama_barang ?? '-'); ?></td>
                    <td><?php echo e($detail->jumlah_barang); ?></td>
                    <td>Rp <?php echo e(number_format($detail->transaksi->total_barang ?? 0, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" style="text-align:center;">Tidak ada transaksi bulan ini</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p style="text-align:right; margin-top:50px;">
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i')); ?>

    </p>

</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/laporan_penjualan_pdf.blade.php ENDPATH**/ ?>