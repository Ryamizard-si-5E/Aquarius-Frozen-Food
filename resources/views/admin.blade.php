<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Produk</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f9fafc;
    }
    .card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .card img {
      height: 220px;
      object-fit: cover;
    }
    .card-title {
      font-weight: 600;
    }
    .add-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .modal-content {
      border-radius: 15px;
      box-shadow: 0 6px 25px rgba(0,0,0,0.15);
    }
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

    /* Tambahan untuk stok habis */
    .stok-habis {
      color: #dc3545;
      font-weight: bold;
      font-size: 0.95rem;
      margin-top: 5px;
      animation: blink 1.2s infinite;
    }
    @keyframes blink {
      50% { opacity: 0.4; }
    }
  </style>
</head>
<body>
@include('Components.header-admin')

<div class="container py-5">
  <h2 class="section-title">📦 Manajemen Produk</h2>
  <div class="row">
    @foreach($barangs as $barang)
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <img src="{{ asset('images/'.$barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $barang->nama_barang }}</h5>
          <p class="card-text text-success fw-bold mb-1">Rp {{ number_format($barang->harga) }}/{{ $barang->satuan }}</p>
          
          <!-- Stok Notice -->
          @if($barang->stok > 0)
            <p class="card-text"><span class="badge bg-info text-dark">Stok: {{ $barang->stok }}</span></p>
          @else
            <p class="card-text"><span class="badge bg-danger text-light">Stok: 0</span></p>
            <div class="stok-habis">⚠️ Stok Habis!</div>
          @endif
          
          <div class="mt-auto">
            <!-- Update stok -->
            <form method="POST" action="{{ route('admin.updateStok', $barang->id_barang) }}" class="d-flex align-items-center mb-2">
              @csrf
              <div class="input-group input-group-sm" style="width: 120px;">
                <button type="button" class="btn btn-outline-secondary btn-minus">−</button>
                <input type="number" name="stok" class="form-control text-center" min="1" value="{{ $barang->stok }}">
                <button type="button" class="btn btn-outline-secondary btn-plus">+</button>
              </div>
              <button type="submit" class="btn btn-sm btn-warning ms-2">Update</button>
            </form>

            <!-- Hapus produk -->
            <form method="POST" action="{{ route('admin.hapusProduk', $barang->id_barang) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Tombol Tambah Produk (Floating Button) -->
<button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
  +
</button>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.simpanProduk') }}" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Produk Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Produk</label>
          <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" step="1000" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Stok</label>
          <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Satuan</label>
          <input type="text" name="satuan" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<script>
document.querySelectorAll('.btn-plus').forEach(btn => {
  btn.addEventListener('click', function() {
    let input = this.parentElement.querySelector('input');
    input.value = parseInt(input.value) + 1;
  });
});
document.querySelectorAll('.btn-minus').forEach(btn => {
  btn.addEventListener('click', function() {
    let input = this.parentElement.querySelector('input');
    let value = parseInt(input.value) - 1;
    if (value >= 1) input.value = value;
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('Components.footer-admin')
</body>
</html>
