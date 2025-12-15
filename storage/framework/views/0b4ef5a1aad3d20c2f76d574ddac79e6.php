<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Pelanggan</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom, #a8e063, #17cf42);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Background logo transparan */
    body::before {
      content: "";
      background: url('<?php echo e(asset('images/logo.png')); ?>') no-repeat center center;
      background-size: 60%;
      opacity: 0.5; /* Transparansi halus */
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0; /* Tetap di belakang */
    }

    .register-box {
      position: relative;
      background: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      width: 360px;
      text-align: center;
      z-index: 1; /* Di atas background logo */
    }

    .register-box h2 {
      margin-bottom: 25px;
      letter-spacing: 1px;
      color: #333;
      border-bottom: 2px solid #56ab2f;
      display: inline-block;
      padding-bottom: 5px;
    }

    .register-box input[type="text"],
    .register-box input[type="username"],
    .register-box input[type="password"],
    .register-box input[type="email"],
    .register-box input[type="no_hp"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: none;
      border-bottom: 2px solid #56ab2f;
      outline: none;
      background: transparent;
      font-size: 14px;
    }

    .register-box button {
      margin-top: 20px;
      background: linear-gradient(to right, #56ab2f, #a8e063);
      border: none;
      padding: 10px 30px;
      color: white;
      border-radius: 20px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s ease;
    }

    .register-box button:hover {
      transform: scale(1.05);
    }

    .register-box a {
      display: block;
      margin-top: 15px;
      font-size: 12px;
      color: #56ab2f;
      text-decoration: none;
    }

    .copyright {
      position: absolute;
      bottom: 20px;
      width: 100%;
      text-align: center;
      font-size: 12px;
      color: #222;
      z-index: 1;
    }
  </style>
</head>
<body>

  <div class="register-box">
    <h2>REGISTRASI</h2>
   <form action="<?php echo e(route('pelanggan.register')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <input type="text" name="nama_pelanggan" placeholder="Nama Lengkap" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="text" name="no_hp" placeholder="No. HP" required>
      <input type="text" name="alamat" placeholder="Alamat" required>
      <input type="text" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
      <button type="submit">DAFTAR</button>
    </form>
    <a href="<?php echo e(route('login')); ?>">Sudah punya akun? Login di sini</a>
  </div>

  <div class="copyright">
    © Aquarius Frozen Food <?php echo e(date('Y')); ?>

  </div>

</body>
</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/auth/pelanggan-register.blade.php ENDPATH**/ ?>