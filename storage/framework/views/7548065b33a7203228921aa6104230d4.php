<footer class="bg-dark text-light mt-5 pt-5 pb-3">
  <div class="container">
    <div class="row">

      <!-- Tentang -->
      <div class="col-md-4 mb-4">
        <h5>Aquarius Frozen Food</h5>
        <p>Kami menyediakan berbagai macam makanan beku berkualitas tinggi dan siap masak untuk keluarga Anda.</p>
      </div>

      <!-- Navigasi -->
      <div class="col-md-4 mb-4">
        <h5>Menu</h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo e(route('admin.dashboard')); ?>">Beranda</a></li>
          <li><a href="<?php echo e(route('wa.form')); ?>">Broadcast Stok</a></li>
          <li><a href="<?php echo e(route('admin.verify.pelanggan')); ?>">Verfikasi</a></li>
          <li><a href="<?php echo e(route('admin.transaksi')); ?>">Transaksi</a><li>
            <li><a href="<?php echo e(route('admin.laporan.penjualan')); ?>">Laporan</a></li>
             <li><a href="<?php echo e(route('pelanggan.index')); ?>">User</a><li>
            <li><a href="<?php echo e(route('awal')); ?>">Keluar</a><li>
        </ul>
      </div>

      <!-- Kontak -->
      <div class="col-md-4 mb-4">
        <h5>Hubungi Kami</h5>
        <p>Telepon: +62 812 5628 425</p>
        <p>Alamat: Jl. Gusti Sulung Lalanang No. 46, Singkawang</p>
      </div>

    </div>

    <hr class="border-light">
    <div class="text-center">
      <small>&copy; <?php echo e(date('Y')); ?> Aquarius Frozen Food. All rights reserved.</small>
    </div>
  </div>
</footer>
<?php /**PATH D:\laragon\www\laravel11\resources\views/Components/footer-admin.blade.php ENDPATH**/ ?>