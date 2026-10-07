<?= $this->extend('public/layout') ?>
<?= $this->section('content') ?>
<section class="page-hero"><div class="container text-center"><h1>Join Puihaha Electric</h1><p>Register as a customer and save your account information securely.</p></div></section>
<section class="section-padding"><div class="container"><div class="section-title"><h2>Customer Benefits</h2></div><div class="row g-4"><div class="col-md-3"><div class="card h-100 text-center p-4"><div class="feature-icon"><i class="fas fa-calendar-check"></i></div><h5>Priority Scheduling</h5></div></div><div class="col-md-3"><div class="card h-100 text-center p-4"><div class="feature-icon"><i class="fas fa-percent"></i></div><h5>Exclusive Discounts</h5></div></div><div class="col-md-3"><div class="card h-100 text-center p-4"><div class="feature-icon"><i class="fas fa-history"></i></div><h5>Service History</h5></div></div><div class="col-md-3"><div class="card h-100 text-center p-4"><div class="feature-icon"><i class="fas fa-headset"></i></div><h5>Customer Support</h5></div></div></div></div></section>
<section class="section-padding bg-light-custom"><div class="container"><div class="row"><div class="col-lg-9 mx-auto"><div class="card shadow border-0"><div class="card-body p-4 p-md-5">
    <div class="text-center mb-4"><h2 class="text-primary-custom">Create Your Account</h2><p class="text-muted">Register once, then use your username and password to log in.</p></div>
    <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><i class="fas fa-circle-check me-2"></i><?= esc(session()->getFlashdata('success')) ?></div><?php endif ?>
    <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><i class="fas fa-circle-exclamation me-2"></i><?= esc(session()->getFlashdata('error')) ?></div><?php endif ?>
    <?php $errors = session()->getFlashdata('validation') ?? []; ?>
    <?php if ($errors): ?><div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul></div><?php endif ?>
    <form method="post" action="<?= site_url('register') ?>" id="registerForm"><?= csrf_field() ?>
        <h4 class="form-heading"><i class="fas fa-user me-2"></i>Personal Information</h4><div class="row g-3 mb-4">
            <div class="col-md-6"><label class="form-label" for="first_name">First Name *</label><input class="form-control form-control-lg" id="first_name" name="first_name" value="<?= old('first_name') ?>" required></div>
            <div class="col-md-6"><label class="form-label" for="last_name">Last Name *</label><input class="form-control form-control-lg" id="last_name" name="last_name" value="<?= old('last_name') ?>" required></div>
            <div class="col-md-6"><label class="form-label" for="email">Email Address *</label><input class="form-control form-control-lg" type="email" id="email" name="email" value="<?= old('email') ?>" required></div>
            <div class="col-md-6"><label class="form-label" for="phone">Phone Number *</label><input class="form-control form-control-lg" id="phone" name="phone" value="<?= old('phone') ?>" required></div>
        </div>
        <h4 class="form-heading"><i class="fas fa-location-dot me-2"></i>Address Information</h4><div class="row g-3 mb-4">
            <div class="col-12"><label class="form-label" for="address">Street Address *</label><input class="form-control form-control-lg" id="address" name="address" value="<?= old('address') ?>" required></div>
            <div class="col-md-5"><label class="form-label" for="city">City *</label><input class="form-control form-control-lg" id="city" name="city" value="<?= old('city') ?>" required></div>
            <div class="col-md-4"><label class="form-label" for="state">State/Province *</label><input class="form-control form-control-lg" id="state" name="state" value="<?= old('state') ?>" required></div>
            <div class="col-md-3"><label class="form-label" for="zip_code">ZIP Code *</label><input class="form-control form-control-lg" id="zip_code" name="zip_code" value="<?= old('zip_code') ?>" required></div>
        </div>
        <h4 class="form-heading"><i class="fas fa-lock me-2"></i>Account Security</h4><div class="row g-3 mb-4">
            <div class="col-12"><label class="form-label" for="username">Username *</label><input class="form-control form-control-lg" id="username" name="username" value="<?= old('username') ?>" minlength="4" maxlength="100" autocomplete="username" required><div class="form-text">Use this username to log in after registration.</div></div>
            <div class="col-md-6"><label class="form-label" for="password">Password *</label><input class="form-control form-control-lg" type="password" id="password" name="password" minlength="8" required><div class="form-text">At least 8 characters</div></div>
            <div class="col-md-6"><label class="form-label" for="confirm_password">Confirm Password *</label><input class="form-control form-control-lg" type="password" id="confirm_password" name="confirm_password" minlength="8" required></div>
        </div>
        <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="terms" name="terms" value="1" required><label class="form-check-label" for="terms">I agree to the terms of service and privacy policy.</label></div>
        <div class="text-center"><button class="btn btn-primary btn-lg px-5" type="submit"><i class="fas fa-user-plus me-2"></i>Create Account</button></div>
    </form>
</div></div></div></div></div></section>
<?= $this->endSection() ?>
