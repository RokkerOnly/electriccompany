<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Customer Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Add Customer Account</h2>
            </div>

            <div class="card-body">

                <?php if (!empty($validation)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($validation as $error): ?>
                        <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php endif ?>

                <form method="POST" action="<?= base_url('account/create') ?>">
                    <?= csrf_field() ?>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="account_number" class="form-label">
                                Account Number
                            </label>

                            <input type="text" class="form-control" id="account_number" name="account_number"
                                value="<?= esc(old('account_number')) ?>" placeholder="Example: EC-2026-0026" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">
                                Customer Name
                            </label>

                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="<?= esc(old('customer_name')) ?>" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">
                                Address
                            </label>

                            <textarea class="form-control" id="address" name="address" rows="3"
                                required><?= esc(old('address')) ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                Phone
                            </label>

                            <input type="text" class="form-control" id="phone" name="phone"
                                value="<?= esc(old('phone')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= esc(old('email')) ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="meter_number" class="form-label">
                                Meter Number
                            </label>

                            <input type="text" class="form-control" id="meter_number" name="meter_number"
                                value="<?= esc(old('meter_number')) ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="connection_type" class="form-label">
                                Connection Type
                            </label>

                            <select class="form-select" id="connection_type" name="connection_type" required>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="industrial">Industrial</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>

                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save Account
                        </button>

                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>