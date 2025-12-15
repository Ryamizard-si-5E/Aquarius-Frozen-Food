{{-- resources/views/admin/verify-pelanggan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .card-title {
            font-weight: 700;
            color: #000; /* diubah jadi hitam */
        }
        table th {
            background: #0d6efd;
            color: white;
        }
        .badge {
            font-size: 0.85rem;
            padding: 6px 10px;
        }
        .btn-sm {
            border-radius: 8px;
        }
    </style>
</head>
@include('Components.header-admin')
<body class="bg-light">

<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">👤 Verifikasi Pelanggan</h2>

            {{-- Alert sukses --}}
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
                            <th>Nama</th>
                            <th>Username</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggan as $p)
                            @php
                                $nomorSudahAda = \App\Models\Pelanggan::where('no_hp', $p->no_hp)
                                    ->where('status', 'active')
                                    ->where('id_pelanggan', '!=', $p->id_pelanggan)
                                    ->exists();
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $p->nama_pelanggan }}</td>
                                <td>{{ $p->username }}</td>
                                <td>
                                    {{ $p->no_hp }}
                                    <span class="badge {{ $nomorSudahAda ? 'bg-danger' : 'bg-success' }}">
                                        {{ $nomorSudahAda ? 'Nomor sudah digunakan' : 'Nomor tersedia' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.verify.pelanggan.approve', $p->id_pelanggan) }}" method="POST" class="d-inline approve-form">
                                        @csrf
                                        <input type="hidden" name="nomor_sudah_ada" value="{{ $nomorSudahAda ? 1 : 0 }}">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.verify.pelanggan.reject', $p->id_pelanggan) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-4">
                                    🚫 Tidak ada pelanggan yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.approve-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            let nomorSudahAda = this.querySelector('input[name="nomor_sudah_ada"]').value;
            if (nomorSudahAda == "1") {
                e.preventDefault();
                alert('⚠️ Nomor HP ini sudah dipakai oleh pelanggan lain. Tidak bisa disetujui.');
            }
        });
    });
});
</script>

@include('Components.footer-admin')
</body>
</html>
