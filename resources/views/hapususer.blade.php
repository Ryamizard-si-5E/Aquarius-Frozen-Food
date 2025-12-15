<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pelanggan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
        background: #f8f9fa;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .table thead th {
        font-weight: 600;
        text-align: center;
    }
    .table tbody tr:hover {
        background-color: #f1f5ff;
        transition: 0.2s;
    }
    .btn-sm {
        border-radius: 8px;
    }
  </style>
</head>
<body>
@include('Components.header-admin')

<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4 text-center fw-bold text-dark">👥 Daftar Pelanggan</h2>

            {{-- Pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle text-center mb-0">
                    <thead class="border-bottom">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $p->username }}</td>
                                <td>{{ $p->nama_pelanggan }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->no_hp ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" 
                                          onsubmit="return confirm('Yakin hapus pelanggan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-danger py-4 fw-semibold">
                                    <i class="bi bi-slash-circle"></i> Tidak ada pelanggan
                                </td>
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
@include('Components.footer-admin')
</html>
