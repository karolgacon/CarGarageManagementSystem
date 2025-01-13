<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content mt-5">
    <h1 class="mb-4 text-center">Invoices</h1>

    <!-- Formularz filtrujący -->
    <form class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="client_name" class="form-control" placeholder="Client Name">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="created_at" class="form-control">
            </div>
        </div>
    </form>

    <!-- Tabela faktur -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Service ID</th>
            <th>Client</th>
            <th>Invoice Number</th>
            <th>Created At</th>
            <th>Amount</th>
            <th>Paid On</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?php echo $invoice['service_id']; ?></td>
                <td><?php echo $invoice['first_name'] . ' ' . $invoice['last_name']; ?></td>
                <td><?php echo $invoice['invoice_number']; ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($invoice['created_at'])); ?></td>
                <td><?php echo number_format($invoice['amount'], 2); ?> USD</td>
                <td>
                    <?php if ($invoice['status'] === 'paid' && $invoice['status_updated_at']): ?>
                        <?php
                        $paidAt = new DateTime($invoice['status_updated_at'], new DateTimeZone('UTC'));
                        $paidAt->setTimezone(new DateTimeZone('Europe/Warsaw'));
                        echo $paidAt->format('Y-m-d H:i');
                        ?>
                    <?php endif; ?>
                </td>
                <td><?php echo ucfirst($invoice['status']); ?></td>
                <td>
                    <div class="action-buttons">
                    <a href="/invoice_details?id=<?php echo $invoice['id']; ?>" class="btn btn-primary btn-sm">Details</a>
                    <form action="/invoice_export" method="POST" target="_blank" class="inline">
                        <input type="hidden" name="id" value="<?php echo $invoice['id']; ?>">
                        <button type="submit" class="btn btn-secondary btn-sm">Export PDF</button>
                    </form>
                    <a href="/invoice_delete?id=<?php echo $invoice['id']; ?>" onclick="return confirm('Are you sure you want to delete this invoice?');" class="btn btn-danger btn-sm">Delete</a>
                    <?php if ($invoice['status'] !== 'paid'): ?>
                        <a href="/invoice_mark_paid?id=<?php echo $invoice['id']; ?>" class="btn btn-success btn-sm">Mark as Paid</a>
                    <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="/data/js/pure.js"></script>
<script src="/data/js/invoices.js"></script> <!-- Dołączamy plik JavaScript -->
</body>
</html>
