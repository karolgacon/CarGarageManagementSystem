<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Main View">
    <meta name="keywords" content="Main View">
    <meta name="author" content="Karol Gacon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main View</title>
    <link rel="stylesheet" href="data/css/main.css">
    <link rel="stylesheet" href="data/css/login.css">
    <link rel="stylesheet" href="data/css/mainview.css">
    <script src="data/js/mainview.js" defer></script>
</head>
<body onload="loadContent('views/repairs.php', 'repairs')">
<div class="mainContainer">
    <aside class="sidebar">
        <nav>
            <ul>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="#" id="users" onclick="loadContent('/data/views/users.php', 'users')">Users</a></li>
                    <li><a href="#" id="vehicles" onclick="loadContent('/data/views/vehicles.php', 'vehicles')">Vehicles</a></li>
                    <li><a href="#" id="car_parts" onclick="loadContent('/data/views/car_parts.php', 'car_parts')">Car Parts</a></li>
                    <li><a href="#" id="calendar" onclick="loadContent('/data/views/calendar.php', 'calendar')">Calendar</a></li>
                    <li><a href="#" id="invoice" onclick="loadContent('/data/views/invoice.php', 'invoice')">Generate Invoice</a></li>
                    <li><a href="#" id="repairs" onclick="loadContent('/data/views/repairs.php', 'repairs')" class="active">Repairs</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </aside>
    <main class="content">
        <header>
            <h1>Welcome to the Workshop Management System</h1>
            <p>You are logged in as <?php echo $_SESSION['email']; ?>.</p>
        </header>
        <div id="contentContainer">
            <p>Select a menu option to see its content.</p>
        </div>
    </main>
</div>
</body>
</html>
