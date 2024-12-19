<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Main View">
    <meta name="keywords" content="Main View">
    <meta name="author" content="Karol Gacon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main View</title>
    <link rel="stylesheet" href="data/css/mainview.css">
</head>
<body>
<div class="mainContainer">
    <h1>Welcome to the Main View</h1>
    <p>You are now logged in as <?php echo $_SESSION['email']; ?>.</p>
    <nav>
        <ul>
            <li><a href="task_list">Task List</a></li>
            <li><a href="task_add">Add Task</a></li>
            <li><a href="logout">Logout</a></li>
        </ul>
    </nav>
</div>
</body>
</html>