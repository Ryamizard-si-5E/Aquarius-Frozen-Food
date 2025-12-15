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

        #popup-login {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 999;
    }

    .popup-content {
        background-color: #fff;
        padding: 20px;
        margin: 150px auto;
        width: 300px;
        text-align: center;
        border-radius: 8px;
    }

    .popup-content button {
        margin: 10px;
        padding: 8px 12px;
    }
    </style>
</head>
<script>
    function handleKeranjangClick(event) {
        event.preventDefault(); // Mencegah navigasi langsung
        document.getElementById('popup-login').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup-login').style.display = 'none';
    }
</script>
<body>
    <div class="header">
        <div class="logo-area">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo"> 
        </div>
        <div class="nav">
            <a href="<?php echo e(route('awal')); ?>">Beranda</a>
           <a href="<?php echo e(route('index')); ?>" >Produk</a>
            <a href="<?php echo e(route('login')); ?>">Masuk</a>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/Components/header3.blade.php ENDPATH**/ ?>