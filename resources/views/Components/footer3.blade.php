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
          <li><a href="{{ route('awal') }}" class="text-light text-decoration-none">Beranda</a></li>
          <li><a href="{{ route('index') }}" class="text-light text-decoration-none">Produk</a></li>
          <li><a href="{{ route('login') }}" class="text-light text-decoration-none">Masuk</a><li>
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
      <small>&copy; {{ date('Y') }} Aquarius Frozen Food. All rights reserved.</small>
    </div>
  </div>
</footer>
