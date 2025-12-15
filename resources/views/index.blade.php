<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
    .badge-habis {
      position: absolute;
      top: 15px;
      left: 15px;
      background: #e74c3c;
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

    /* Tombol login */
    .btn-login {
      background: linear-gradient(135deg, #1abc9c, #16a085, #2ecc71);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 30px;
      font-weight: 600;
      transition: 0.3s;
      width: 100%;
    }
    .btn-login:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }
  </style>
</head>

@include('Components.header3')
<body>

<div class="container py-5">
  <h2 class="section-title">📦 Semua Produk Kami</h2>
  <div class="row g-4">
    @foreach($barangs as $barang)
    <div class="col-md-4">
      <!-- Card Produk -->
      <div class="card product-card h-100 position-relative" role="button" data-bs-toggle="modal" data-bs-target="#popup-{{ $barang->id_barang }}">
        <div class="position-relative">
          <img src="{{ asset('images/'.$barang->gambar) }}" class="card-img-top product-img" alt="{{ $barang->nama_barang }}">
          
          @if($barang->stok == 0)
            <!-- Badge stok habis -->
            <span class="badge-habis">Stok Habis</span>
          @else
            <!-- Badge stok tersedia -->
            <span class="badge-custom">Stok: {{ $barang->stok }}</span>
          @endif
        </div>
        <div class="card-body text-center">
          <h5 class="card-title fw-bold">{{ $barang->nama_barang }}</h5>
          <p class="card-text text-success fs-5">Rp {{ number_format($barang->harga) }}/{{ $barang->satuan }}</p>
        </div>
      </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="popup-{{ $barang->id_barang }}" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">{{ $barang->nama_barang }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row align-items-center">
              <div class="col-md-6 text-center">
                <img src="{{ asset('images/'.$barang->gambar) }}" class="img-fluid rounded shadow mb-3">
              </div>
              <div class="col-md-6">
                <p class="text-muted">{{ $barang->deskripsi }}</p>
                <p><strong>Harga:</strong> <span class="text-success">Rp {{ number_format($barang->harga) }}/{{ $barang->satuan }}</span></p>
                <p><strong>Stok:</strong> {{ $barang->stok }}</p>

                @if($barang->stok > 0)
                  <div class="mb-3">
                    <label for="jumlah-{{ $barang->id_barang }}" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1" max="{{ $barang->stok }}" value="1" disabled>
                  </div>

                  <a href="#"
   class="btn btn-login"
   onclick="showLoginAlert(event)">
   🛒 Masukkan ke Keranjang
</a>

                @else
                  <!-- ALERT jika stok habis -->
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <span class="me-2">❌</span>
                    <div>Maaf, stok produk ini sudah habis.</div>
                  </div>
                  <!-- Tombol nonaktif -->
                  <button class="btn btn-secondary w-100" disabled>
                    🛒 Masukkan ke Keranjang
                  </button>
                @endif

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
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
            window.location.href = "{{ route('login') }}";
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('Components.footer3')
</body>
</html>
