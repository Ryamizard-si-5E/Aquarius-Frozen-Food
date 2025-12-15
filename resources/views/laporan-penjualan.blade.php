<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
@include('Components.header-admin')
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="text-center mb-4 fw-bold">📊 Laporan Penjualan</h2>

            {{-- Filter Tanggal & Bulan --}}
            <form class="row g-3 mb-4" method="GET">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Bulan</label>
                    <input type="month" name="bulan" value="{{ $bulan }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            {{-- Ringkasan --}}
            <div class="row text-center">
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-success text-white rounded-4">
                        <h4>Total Penjualan Hari Ini</h4>
                        <h3>Rp {{ number_format($penjualanPerHari, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-info text-white rounded-4">
                        <h4>Total Penjualan Bulan Ini</h4>
                        <h3>Rp {{ number_format($penjualanPerBulan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            {{-- Produk Terlaris & Tersepi --}}
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="fw-bold text-success">Produk Terlaris</h5>
                        @if($produkTerlaris)
                            <p>{{ $produkTerlaris->barang->nama_barang }} <br>
                            Terjual: <b>{{ $produkTerlaris->total_terjual }}</b></p>
                        @else
                            <p class="text-muted">Belum ada data</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="fw-bold text-danger">Produk Paling Sedikit Terjual</h5>
                        @if($produkTersepi)
                            <p>{{ $produkTersepi->barang->nama_barang }} <br>
                            Terjual: <b>{{ $produkTersepi->total_terjual }}</b></p>
                        @else
                            <p class="text-muted">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Chart Produk --}}
            <div class="mt-4">
                <canvas id="chartProduk"></canvas>
            </div>

            {{-- Detail Transaksi Per Hari --}}
<div class="mt-5">
    <h4 class="fw-bold mb-3">🗓️ Detail Transaksi Hari {{ $tanggal }}</h4>
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
            @forelse($transaksiPerHari as $detail)
                <tr>
                    <td>{{ $detail->id_transaksi }}</td>
                    <td>{{ optional(optional($detail->transaksi)->pelanggan)->nama_pelanggan ?? 'Tidak Diketahui' }}</td>
                    <td>{{ optional($detail->barang)->nama_barang ?? 'Produk Hilang' }}</td>
                    <td>{{ $detail->jumlah_barang }}</td>
                    <td>
                        Rp {{ number_format(optional($detail->transaksi)->total_barang ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi hari ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Detail Transaksi Per Bulan --}}
<div class="mt-5">
    <h4 class="fw-bold mb-3">📅 Detail Transaksi Bulan {{ $bulan }}</h4>
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
            @forelse($transaksiPerBulan as $detail)
                <tr>
                    <td>{{ $detail->id_transaksi }}</td>
                    <td>{{ optional(optional($detail->transaksi)->pelanggan)->nama_pelanggan ?? 'Tidak Diketahui' }}</td>
                    <td>{{ optional($detail->barang)->nama_barang ?? 'Produk Hilang' }}</td>
                    <td>{{ $detail->jumlah_barang }}</td>
                    <td>
                        Rp {{ number_format(optional($detail->transaksi)->total_barang ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi bulan ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- Tombol Download PDF --}}
<div class="text-end mb-3">
    <a href="{{ route('laporan.download', ['tanggal' => $tanggal, 'bulan' => $bulan]) }}" 
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
        labels: @json($produkTerjual->pluck('barang.nama_barang')),
        datasets: [{
            label: 'Jumlah Terjual',
            data: @json($produkTerjual->pluck('total_terjual')),
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
@include('Components.footer-admin')
</body>
</html>
