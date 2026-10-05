<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="section-padding bg-light-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-bolt text-warning fa-3x mb-3"></i>
                        <h2>Login</h2>
                        <p class="text-muted">
                            Access the customer account dashboard
                        </p>
                    </div>
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                    <?php endif ?>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                    <?php endif ?>
                    <form method="POST" action="<?= base_url('login') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Enter your email" value="<?= esc(old('email')) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>

                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="Enter your password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Login
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>