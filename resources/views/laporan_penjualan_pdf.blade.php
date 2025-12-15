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
    <p style="text-align:center;">Tanggal: {{ $tanggal }} | Bulan: {{ $bulan }}</p>
    <hr>

    <div class="summary">
        <table>
            <tr>
                <th>Total Penjualan Hari Ini</th>
                <td>Rp {{ number_format($penjualanPerHari, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Penjualan Bulan Ini</th>
                <td>Rp {{ number_format($penjualanPerBulan, 0, ',', '.') }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Produk Terlaris</th>
                <td>
                    {{ $produkTerlaris?->barang?->nama_barang ?? '-' }}<br>
                    Terjual: {{ $produkTerlaris?->total_terjual ?? 0 }}
                </td>
            </tr>
            <tr>
                <th>Produk Paling Sedikit Terjual</th>
                <td>
                    {{ $produkTersepi?->barang?->nama_barang ?? '-' }}<br>
                    Terjual: {{ $produkTersepi?->total_terjual ?? 0 }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">🗓️ Detail Transaksi Hari {{ $tanggal }}</div>
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
            @forelse($transaksiPerHari as $detail)
                <tr>
                    <td>{{ $detail->id_transaksi }}</td>
                    <td>{{ $detail->transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $detail->jumlah_barang }}</td>
                    <td>Rp {{ number_format($detail->transaksi->total_barang ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">Tidak ada transaksi hari ini</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">📅 Detail Transaksi Bulan {{ $bulan }}</div>
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
            @forelse($transaksiPerBulan as $detail)
                <tr>
                    <td>{{ $detail->id_transaksi }}</td>
                    <td>{{ $detail->transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $detail->jumlah_barang }}</td>
                    <td>Rp {{ number_format($detail->transaksi->total_barang ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">Tidak ada transaksi bulan ini</td></tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align:right; margin-top:50px;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </p>

</body>
</html>
