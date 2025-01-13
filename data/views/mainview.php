<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - System Zarządzania Warsztatem</title>
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"><!-- FullCalendar CSS -->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container">
        <h1>Dashboard - Witaj, <?php echo htmlspecialchars($user->getName() . ' ' . $user->getSurname()); ?>!</h1>

        <!-- Statystyki w kafelkach -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #27ae60;">
                    <div class="card-body">
                        <h3>📦</h3>
                        <h5>Twoje pojazdy</h5>
                        <p class="display-4"><?php echo $vehiclesCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #f39c12;">
                    <div class="card-body">
                        <h3>🔧</h3>
                        <h5>Twoje zlecenia</h5>
                        <p class="display-4"><?php echo $servicesCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #2980b9;">
                    <div class="card-body">
                        <h3>💵</h3>
                        <h5>Twoje faktury</h5>
                        <p class="display-4"><?php echo $invoicesCount; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista zleceń -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Twoje zlecenia</div>
                    <div class="card-body">
                        <?php if (!empty($services)): ?>
                            <ul class="list-group">
                                <?php foreach ($services as $service): ?>
                                    <li class="list-group-item">
                                        <strong><?php echo $service['description']; ?></strong>
                                        Data: <?php echo date('Y-m-d', strtotime($service['date'])); ?>,
                                        Status: <?php echo ucfirst($service['status']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Brak przypisanych zleceń.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Lista faktur -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Twoje faktury</div>
                    <div class="card-body">
                        <?php if (!empty($invoices)): ?>
                            <ul class="list-group">
                                <?php foreach ($invoices as $invoice): ?>
                                    <li class="list-group-item">
                                       <strong>Faktura: <?php echo $invoice['invoice_number']; ?> </strong>
                                        Kwota: <?php echo number_format($invoice['amount'], 2); ?> USD,
                                        Status: <?php echo ucfirst($invoice['status']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Brak przypisanych faktur.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalendarz -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Kalendarz wydarzeń</div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-dark text-light text-center">
    <div class="container">
        <span>© 2025 Garage Master. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
<script src="/data/js/calendar.js"></script>
<script src="/data/js/pure.js"></script>

</body>
</html>
