<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Puihaha Electric Company</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('style/loginview_cs.css') ?>">
</head>
<body class="blue-mode">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?= esc(implode(' ', session()->getFlashdata('errors'))) ?>
        </div>
    <?php endif ?>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <h1>Log In</h1>
                <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?>" required autofocus>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i id="eyePassword" class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('password', 'eyePassword')"></i>
                </div>
                <button type="submit" id="sign-in-btn">Log In</button>
                <a href="<?= site_url('/') ?>" style="display: inline-block; padding: 9px 16px; border: 1px solid #0d6efd; border-radius: 8px; font-weight: 600; text-transform: uppercase;">
                    <i class="fa-solid fa-arrow-left"></i> Back to Main Website
                </a>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome!</h1>
                    <p>Remember your password?</p>
                    <button class="hidden" id="login" type="button">Log In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Puihaha Electric Company</h1>
                    <p>Use an account stored in the database to open the customer dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('javascript/login_js.js') ?>"></script>
</body>
</html>
