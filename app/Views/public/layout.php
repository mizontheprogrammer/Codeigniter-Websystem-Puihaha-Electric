<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Puihaha Electric') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/public-site.css') ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('/') ?>"><i class="fas fa-bolt text-warning me-2"></i>Puihaha Electric</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link <?= ($page ?? '') === 'home' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page ?? '') === 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page ?? '') === 'services' ? 'active' : '' ?>" href="<?= site_url('services') ?>">Services</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page ?? '') === 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Contact</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page ?? '') === 'register' ? 'active' : '' ?>" href="<?= site_url('register') ?>">Register</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn btn-sm btn-outline-primary" href="<?= site_url('login') ?>"><i class="fas fa-lock me-1"></i> Staff Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main><?= $this->renderSection('content') ?></main>
    <footer class="footer"><div class="container">
        <div class="row g-4">
            <div class="col-lg-4"><h5><i class="fas fa-bolt text-warning me-2"></i>Puihaha Electric</h5><p>Providing reliable and sustainable electrical solutions for homes and businesses.</p></div>
            <div class="col-lg-2 col-md-4"><h5>Quick Links</h5><ul class="list-unstyled"><li><a href="<?= site_url('/') ?>">Home</a></li><li><a href="<?= site_url('about') ?>">About</a></li><li><a href="<?= site_url('services') ?>">Services</a></li><li><a href="<?= site_url('contact') ?>">Contact</a></li></ul></div>
            <div class="col-lg-3 col-md-4"><h5>Services</h5><ul class="list-unstyled"><li>Residential Wiring</li><li>Commercial Installation</li><li>Emergency Repairs</li><li>Solar Solutions</li></ul></div>
            <div class="col-lg-3 col-md-4"><h5>Customer Access</h5><p><a href="<?= site_url('register') ?>">Create an account</a></p><p><a href="<?= site_url('login') ?>">Staff administration</a></p></div>
        </div><hr><p class="mb-0">&copy; <?= date('Y') ?> Puihaha Electric. All rights reserved.</p>
    </div></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/public-site.js') ?>"></script>
</body>
</html>
