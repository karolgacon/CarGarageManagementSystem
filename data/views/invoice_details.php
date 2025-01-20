<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="container mt-5">
    <div class="content">
    <h1 class="mb-4">Invoice Details</h1>

    <!-- Informacje o fakturze -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Invoice Information</h3>
            <p><strong>Invoice Number:</strong> <?php echo $invoice['invoice_number']; ?></p>
            <p><strong>Issued Date:</strong> <?php echo date('Y-m-d H:i', strtotime($invoice['created_at'])); ?></p>
            <p><strong>Status:</strong>
                <?php echo ucfirst($invoice['status']); ?>
                <?php if ($invoice['status'] === 'paid' && $invoice['status_updated_at']): ?>
                    (Paid on: <?php echo date('Y-m-d H:i', strtotime($invoice['status_updated_at'])); ?>)
                <?php endif; ?>
            </p>
            <p><strong>Total Amount:</strong> <?php echo number_format($invoice['amount'], 2); ?> USD</p>
        </div>
    </div>

    <!-- Informacje o kliencie -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Client Information</h3>
            <p><strong>Name:</strong> <?php echo $client['name'] . ' ' . $client['surname']; ?></p>
            <p><strong>Email:</strong> <?php echo $client['email']; ?></p>
        </div>
    </div>

    <!-- Informacje o usłudze -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Service Details</h3>
            <p><strong>Description:</strong> <?php echo $service['description']; ?></p>
            <p><strong>Date:</strong> <?php echo date('Y-m-d H:i', strtotime($service['date'])); ?></p>
            <p><strong>Service Cost:</strong> <?php echo number_format($service['cost'], 2); ?> USD</p>
        </div>
    </div>

    <!-- Informacje o częściach -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Parts Used</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Part</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $partsTotal = 0;
                foreach ($parts as $part):
                    $partTotal = $part['quantity'] * $part['price'];
                    $partsTotal += $partTotal;
                    ?>
                    <tr>
                        <td><?php echo $part['name']; ?></td>
                        <td><?php echo $part['quantity']; ?></td>
                        <td><?php echo number_format($part['price'], 2); ?> USD</td>
                        <td><?php echo number_format($partTotal, 2); ?> USD</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Podsumowanie -->
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Summary</h3>
            <p><strong>Service Cost (Net):</strong> <?php echo number_format($service['cost'], 2); ?> USD</p>
            <p><strong>Parts Total (Net):</strong> <?php echo number_format($partsTotal, 2); ?> USD</p>
            <p><strong>Total Amount (Net):</strong> <?php echo number_format($invoice['amount'], 2); ?> USD</p>
            <p><strong>VAT (23%):</strong>
                <?php echo number_format($invoice['amount'] * 0.23, 2); ?> USD
            </p>
            <p><strong>Total Amount (Gross):</strong>
                <?php echo number_format($invoice['amount'], 2); ?> USD
            </p>
        </div>
    </div>

    <!-- Akcje -->
    <div class="mt-4">
        <a href="/invoices" class="btn btn-secondary">Back to Invoices</a>
        <form action="/invoice_export" method="POST" target="_blank" class="inline">
            <input type="hidden" name="id" value="<?php echo $invoice['id']; ?>">
            <button type="submit" class="btn btn-primary">Export PDF</button>
        </form>
    </div>
    </div>
</div>

<script src="/data/js/pure.js"></script>
</body>
</html>
