<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .header {
            background-color: #17cf42; /* hijau */
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
        }

        .logo-area {
            display: flex;
            align-items: center;
        }

        .logo-area img {
            height: 40px;
            margin-right: 10px;
        }

        .nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-area">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo"> 
        </div>
        <div class="nav">
            <a href="<?php echo e(route('awal2')); ?>">Beranda</a>
            <a href="<?php echo e(route('profil')); ?>">Profil</a>
            <a href="<?php echo e(route('dashboard')); ?>">Produk</a>
            <a href="<?php echo e(route('keranjang.index')); ?>">Keranjang</a>
            <a href="<?php echo e(route('notifikasi')); ?>">Notifikasi</a>
            <a href="<?php echo e(route('awal')); ?>">Keluar</a>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/Components/header2.blade.php ENDPATH**/ ?>