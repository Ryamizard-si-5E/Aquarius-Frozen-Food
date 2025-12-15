<!DOCTYPE html>
<html lang="id">
<head>
    <title>Broadcast WhatsApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php echo $__env->make('Components.header-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container py-4">
    <h2 class="mb-4 text-center">📢 Kirim Broadcast WhatsApp</h2>

    <!-- Notifikasi -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    

    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
    <div class="card p-3 text-center">
        <h5 class="mb-3">📱 Status WhatsApp</h5>
        <img id="qrImage" src="" alt="QR Code WhatsApp" style="display:none; max-width:250px; margin:10px auto; border:2px solid #ddd; border-radius:10px;">
        <div id="waStatus" class="fw-semibold text-danger">
            🔄 Mengecek status...
        </div>
    </div>
</div>
        <!-- Form Broadcast -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    ✉️ Form Kirim Pesan
                </div>
                <div class="card-body">
                    <form action="<?php echo e(url('/wa/send')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Pesan Broadcast</label>
                            <textarea 
                                class="form-control" 
                                name="message" 
                                rows="5" 
                                required 
                                placeholder="Tulis pesan yang akan dikirim ke semua pelanggan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            🚀 Kirim ke Semua Pelanggan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let waReadyShown = false;

    function loadQR() {
        fetch('http://localhost:3000/qr')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'QR') {
                    // tampilkan QR code
                    document.getElementById('qrImage').style.display = 'block';
                    document.getElementById('qrImage').src = data.image;
                    document.getElementById('waStatus').innerText = "🔄 Scan QR untuk login WhatsApp";
                } else if (data.status === 'READY' && !waReadyShown) {
                    // sembunyikan QR code, tampilkan pesan sekali
                    document.getElementById('qrImage').style.display = 'none';
                    document.getElementById('waStatus').innerText = "✅ WhatsApp sudah siap!";
                    waReadyShown = true;

                    // tampilkan alert sekali
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
    }

    loadQR();
    setInterval(loadQR, 5000); // refresh tiap 5 detik
</script>

<?php echo $__env->make('Components.footer-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/wa-form.blade.php ENDPATH**/ ?>