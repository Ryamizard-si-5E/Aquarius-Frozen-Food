<!DOCTYPE html>
<html>
<head>
    <title>Profil Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Judul Section */
        .section-title {
            font-weight: 800;
            text-align: center;
            margin-bottom: 40px;
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

        /* Card Profil */
        .profile-card {
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .profile-card p {
            font-size: 1.05rem;
            margin-bottom: 12px;
        }
        .profile-card strong {
            color: #16a085;
        }

        /* Tombol */
        .btn-edit {
            background: linear-gradient(135deg, #1abc9c, #16a085, #2ecc71);
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 25px;
            transition: 0.3s;
        }
        .btn-edit:hover {
            transform: scale(1.05);
            opacity: 0.9;
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
    </style>
</head>
<?php echo $__env->make('Components.header2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>

<div class="container py-5">
    <h2 class="section-title">👤 Profil Saya</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center rounded-pill"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-card">
                <p><strong>Username:</strong> <?php echo e($pelanggan->username); ?></p>
                <p><strong>Nama:</strong> <?php echo e($pelanggan->nama_pelanggan); ?></p>
                <p><strong>Alamat:</strong> <?php echo e($pelanggan->alamat); ?></p>
                <p><strong>Email:</strong> <?php echo e($pelanggan->email); ?></p>
                <p><strong>No HP:</strong> <?php echo e($pelanggan->no_hp); ?></p>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editModal">
                    ✏️ Edit Profil
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="<?php echo e(route('profil.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="<?php echo e(old('username', $pelanggan->username)); ?>" class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" value="<?php echo e(old('nama_pelanggan', $pelanggan->nama_pelanggan)); ?>" class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control rounded" required><?php echo e(old('alamat', $pelanggan->alamat)); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <textarea name="email" class="form-control rounded" required><?php echo e(old('email', $pelanggan->email)); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $pelanggan->no_hp)); ?>" class="form-control rounded-pill" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-edit">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php echo $__env->make('Components.footer2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/pelangganprofil.blade.php ENDPATH**/ ?>