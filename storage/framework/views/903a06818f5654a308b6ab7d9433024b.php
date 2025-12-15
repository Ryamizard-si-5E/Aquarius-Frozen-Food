<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
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
      opacity: 0.5;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .login-box {
      position: relative;
      background: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      width: 360px;
      text-align: center;
      z-index: 1;
    }

    .login-box h2 {
      margin-bottom: 25px;
      letter-spacing: 1px;
      color: #333;
      border-bottom: 2px solid #56ab2f;
      display: inline-block;
      padding-bottom: 5px;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-bottom: 2px solid #56ab2f;
      outline: none;
      background: transparent;
      font-size: 14px;
    }

    .login-box button {
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

    .login-box button:hover {
      transform: scale(1.05);
    }

    .login-box a {
      display: block;
      margin-top: 10px;
      font-size: 13px;
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

  <div class="login-box">
    <h2>LOGIN ADMIN</h2>

    <?php if($errors->any()): ?>
      <div class="alert alert-danger" style="margin-bottom:15px; padding:10px; border-radius:5px;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
      <?php echo csrf_field(); ?>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">LOGIN</button>
    </form>

    <a href="<?php echo e(url('/')); ?>">Kembali ke Halaman Utama</a>
  </div>

  <div class="copyright">
    © Aquarius Frozen Food <?php echo e(date('Y')); ?>

  </div>

</body>

</html>
<?php /**PATH D:\laragon\www\laravel11\resources\views/auth/login.blade.php ENDPATH**/ ?>