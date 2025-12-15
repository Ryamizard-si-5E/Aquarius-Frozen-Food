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

{{-- Header --}}
@include('Components.header-admin')

<body>
<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4 text-center fw-bold text-dark">📦 Daftar Transaksi</h2>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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
                        @forelse($transaksi as $t)
                        <tr>
                            <td class="fw-semibold">{{ $t->id_transaksi }}</td>
                            <td>{{ $t->pelanggan->nama_pelanggan ?? '-' }}</td>

                            <td class="text-primary fw-semibold">
                                Rp {{ number_format($t->total_barang, 0, ',', '.') }}
                            </td>

                            <td class="text-info fw-semibold">
                                Rp {{ number_format($t->ongkir, 0, ',', '.') }}
                            </td>

                            <td class="text-success fw-bold">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>

                            <td><span class="badge badge-metode">{{ $t->metode }}</span></td>

                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($t->metode_pengiriman) }}</span>
                            </td>

                            <td>
                                @if($t->jarak)
                                    {{ $t->jarak }} km
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $t->alamatt ?? '-' }}</td>


                            <td>{{ $t->tanggal }}</td>

                            <td class="text-center">
                                @if($t->bukti_pembayaran)
                                    <img src="{{ asset('storage/' . $t->bukti_pembayaran) }}" 
                                         alt="Bukti" width="80" class="img-thumbnail"
                                         data-bs-toggle="modal" data-bs-target="#modalBukti{{ $t->id_transaksi }}">
                                    <div class="modal fade" id="modalBukti{{ $t->id_transaksi }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $t->bukti_pembayaran) }}" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada bukti</span>
                                @endif
                            </td>

                            <td>
                                <ul class="mb-0 ps-3 text-start">
                                    @foreach($t->details as $d)
                                        <li>{{ $d->barang->nama_barang ?? '-' }} 
                                            <span class="badge bg-secondary">{{ $d->jumlah_barang }} pcs</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $t->status === 'pending' ? 'bg-warning text-dark' : ($t->status === 'diterima' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>

                            <td>
                                @if($t->status === 'pending')
                                    <form action="{{ route('admin.transaksi.terima', $t->id_transaksi) }}" method="POST" class="d-inline">
                                        @csrf
                                        
                                        <button type="submit" class="btn btn-success btn-sm mb-1"
                                                onclick="return confirm('Yakin ingin menerima transaksi ini?')">
                                            <i class="bi bi-check-circle"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transaksi.tolak', $t->id_transaksi) }}" method="POST" class="d-inline">
                                        @csrf
                                        
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                @elseif($t->status === 'diterima' && $t->metode_pengiriman === 'kirim')
                                    {{-- Tombol pengiriman --}}
                                    @if($t->status_pengiriman === null)
                                        <form action="{{ route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'diproses']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-hourglass-split"></i> Diproses
                                            </button>
                                        </form>
                                    @elseif($t->status_pengiriman === 'diproses')
                                        <form action="{{ route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'dikirim']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-truck"></i> Dikirim
                                            </button>
                                        </form>
                                    @elseif($t->status_pengiriman === 'dikirim')
                                        <form action="{{ route('admin.transaksi.updatePengiriman', [$t->id_transaksi, 'selesai']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check2-circle"></i> Selesai
                                            </button>
                                        </form>
                                    @elseif($t->status_pengiriman === 'selesai')
                                        <span class="badge bg-success">Pengiriman selesai</span>
                                    @endif
                                @else
                                    <em class="text-muted">Tidak ada aksi</em>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">🚫 Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

{{-- Footer --}}
@include('Components.footer-admin')

</html>
