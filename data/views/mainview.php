<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - System Zarządzania Warsztatem</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"> <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container">
        <h1 class="mb-4 text-center">Dashboard</h1>
        <!-- Statystyki w kafelkach -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #27ae60;">
                    <div class="card-body">
                        <h3>📦</h3>
                        <h5>Liczba pojazdów</h5>
                        <p class="display-4"><?php echo $vehiclesCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #f39c12;">
                    <div class="card-body">
                        <h3>👥</h3>
                        <h5>Użytkownicy</h5>
                        <p class="display-4"><?php echo $usersCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #e74c3c;">
                    <div class="card-body">
                        <h3>🔧</h3>
                        <h5>Zlecenia</h5>
                        <p class="display-4"><?php echo $servicesCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white" style="background-color: #2980b9;">
                    <div class="card-body">
                        <h3>💵</h3>
                        <h5>Faktury</h5>
                        <p class="display-4"><?php echo $invoicesCount; ?></p>
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


<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script> <!-- FullCalendar JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/data/js/calendar.js"></script>
</body>
</html>
