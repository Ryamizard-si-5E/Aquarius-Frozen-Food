<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <style>
    .section-title { font-weight: 800; text-align: center; margin-bottom: 40px; position: relative; font-size: 2rem; }
    .section-title::after { content: ""; display: block; width: 80px; height: 4px; background: #1abc9c; margin: 10px auto 0; border-radius: 10px; }
    .table { border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
    .total-box { font-size: 1.1rem; font-weight: bold; background: #ecfdf5; border-radius: 15px; padding: 15px; }
    #map-container { height: 320px; border-radius: 10px; overflow: hidden; margin-bottom: 10px; }
  </style>
</head>
<?php echo $__env->make('Components.header2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>
<div class="container py-5">
  <h2 class="section-title">🛒 Keranjang Belanja</h2>

  <?php if($keranjang->isEmpty()): ?>
    <div class="alert alert-info text-center">Keranjang Anda masih kosong.</div>
  <?php else: ?>
    <?php $totalBarang = 0; ?>
    <div class="table-responsive mb-4">
      <table class="table table-bordered align-middle">
        <thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $keranjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $subtotal = $item->barang->harga * $item->quantity;
            $totalBarang += $subtotal;
          ?>
          <tr>
            <td><?php echo e($item->barang->nama_barang); ?></td>
            <td>Rp <?php echo e(number_format($item->barang->harga,0,',','.')); ?></td>
            <td><?php echo e($item->quantity); ?></td>
            <td>Rp <?php echo e(number_format($subtotal,0,',','.')); ?></td>
            <td>
              <form action="<?php echo e(route('keranjang.hapus', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus dari keranjang?')">
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>

    <div class="total-box mb-3 text-end">
      Total Harga Barang: <strong>Rp <?php echo e(number_format($totalBarang,0,',','.')); ?></strong>
    </div>

    <div class="card p-4 shadow-sm rounded-4">
      <form id="checkoutForm" action="<?php echo e(route('keranjang.checkout')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
          <label class="form-label">Metode Pengiriman</label>
          <select name="metode_pengiriman" id="metode_pengiriman" class="form-control rounded-pill" required>
            <option value="">-- Pilih Pengiriman --</option>
            <option value="ambil">Ambil Sendiri</option>
            <option value="kirim">Dikirim oleh Penjual</option>
          </select>
        </div>

        <!-- Input alamat manual dari user -->
        <div class="mb-3" id="alamat-container" style="display:none;">
          <label class="form-label">Alamat Lengkap / Keterangan</label>
          <input type="text" name="alamatt" id="alamatt" class="form-control rounded-pill" placeholder="Masukkan alamat lengkap Anda">
        </div>

        <!-- Map hanya untuk hitung jarak -->
        <div id="map-container" style="display:none;"></div>

        <div class="mb-3" id="jarak-container" style="display:none;">
          <label class="form-label">Jarak ke lokasi (km)</label>
          <input type="number" name="jarak" id="jarak" class="form-control rounded-pill" readonly>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Metode Pembayaran</label>
          <select name="metode_pembayaran" id="metode_pembayaran" class="form-control rounded-pill" required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="Qris">Qris</option>
            <option value="BCA">BCA</option>
            <option value="Dana">Dana</option>
          </select>
        </div>

        <div id="qris-container" class="mb-3 text-center" style="display:none;">
          <label class="form-label">Scan QRIS</label>
          <div><img src="<?php echo e(asset('images/logo.png')); ?>" style="max-width:220px"></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Bukti Pembayaran</label>
          <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control rounded-pill" accept="image/*" required>
        </div>

        <div class="total-box mb-3">
          <div>Ongkos Kirim: <span id="ongkir-text">Rp 0</span></div>
          <div>Total Akhir: <span id="total-text">Rp <?php echo e(number_format($totalBarang,0,',','.')); ?></span></div>
        </div>

        <input type="hidden" name="total_barang" value="<?php echo e($totalBarang); ?>">
        <input type="hidden" name="ongkir" id="ongkir" value="0">
        <input type="hidden" name="total" id="total" value="<?php echo e($totalBarang); ?>">

        <div class="d-flex justify-content-between">
          <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary rounded-pill">⬅️ Lanjut Belanja</a>
          <button type="submit" id="btnBayar" class="btn btn-custom" disabled>💳 Bayar Sekarang</button>
        </div>
      </form>
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const metodePengiriman = document.getElementById('metode_pengiriman');
  const alamatContainer = document.getElementById('alamat-container');
  const alamatInput = document.getElementById('alamatt');
  const mapContainer = document.getElementById('map-container');
  const jarakContainer = document.getElementById('jarak-container');
  const jarakInput = document.getElementById('jarak');
  const ongkirText = document.getElementById('ongkir-text');
  const totalText = document.getElementById('total-text');
  const ongkirHidden = document.getElementById('ongkir');
  const totalHidden = document.getElementById('total');
  const btnBayar = document.getElementById('btnBayar');
  const totalBarang = <?php echo e($totalBarang); ?>;

  const tokoLat = 0.899338849382596;   
  const tokoLon = 108.98216977335917;  

  let map, marker;
  let ongkirValid = false; // cek apakah jarak & ongkir sudah dihitung

  // Fungsi validasi tombol Bayar
  function validateCheckout() {
    if (metodePengiriman.value === 'kirim') {
      if (alamatInput.value.trim() !== '' && ongkirValid) {
        btnBayar.disabled = false;
      } else {
        btnBayar.disabled = true;
      }
    } else {
      btnBayar.disabled = false; // ambil sendiri langsung aktif
    }
  }

  metodePengiriman.addEventListener('change', () => {
    if (metodePengiriman.value === 'kirim') {
      alamatContainer.style.display = 'block';
      mapContainer.style.display = 'block';
      jarakContainer.style.display = 'block';
      btnBayar.disabled = true;
      jarakInput.value = '';
      ongkirText.innerText = 'Rp 0';
      totalText.innerText = 'Rp ' + totalBarang.toLocaleString('id-ID');
      ongkirHidden.value = 0;
      totalHidden.value = totalBarang;
      ongkirValid = false;

      if (!map) {
        map = L.map('map-container').setView([tokoLat, tokoLon], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

        L.marker([tokoLat, tokoLon]).addTo(map).bindPopup('📍 Lokasi Toko').openPopup();

        map.on('click', function(e) {
          if (marker) map.removeLayer(marker);
          marker = L.marker(e.latlng).addTo(map).bindPopup('📍 Lokasi Anda').openPopup();

          // hitung jarak
          fetch("<?php echo e(route('hitung.jarak')); ?>", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
            },
            body: JSON.stringify({
              lat: e.latlng.lat,
              lon: e.latlng.lng,
              total_barang: totalBarang
            })
          })
          .then(r => r.json())
          .then(data => {
            if (data.success) {
              jarakInput.value = data.jarak;
              ongkirText.innerText = 'Rp ' + data.ongkir.toLocaleString('id-ID');
              const totalAkhir = totalBarang + data.ongkir;
              totalText.innerText = 'Rp ' + totalAkhir.toLocaleString('id-ID');
              ongkirHidden.value = data.ongkir;
              totalHidden.value = totalAkhir;
              ongkirValid = true;
              validateCheckout();
            } else {
              alert(data.message || 'Gagal hitung jarak');
              ongkirValid = false;
              validateCheckout();
            }
          })
          .catch(err => {
            console.error('Error hitung jarak:', err);
            alert('Terjadi kesalahan saat menghitung jarak.');
            ongkirValid = false;
            validateCheckout();
          });
        });
      }
    } else {
      // reset saat pilih Ambil Sendiri
      alamatContainer.style.display = 'none';
      mapContainer.style.display = 'none';
      jarakContainer.style.display = 'none';
      jarakInput.value = '';
      ongkirText.innerText = 'Rp 0';
      totalText.innerText = 'Rp ' + totalBarang.toLocaleString('id-ID');
      ongkirHidden.value = 0;
      totalHidden.value = totalBarang;
      ongkirValid = false;
      btnBayar.disabled = false;
    }
  });

  // setiap kali user isi alamat manual, cek validasi
  alamatInput.addEventListener('input', validateCheckout);

  // QRIS toggle
  document.getElementById('metode_pembayaran').addEventListener('change', function(){
    document.getElementById('qris-container').style.display = this.value === 'Qris' ? 'block' : 'none';
  });
</script>


<?php echo $__env->make('Components.footer2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/keranjang.blade.php ENDPATH**/ ?>