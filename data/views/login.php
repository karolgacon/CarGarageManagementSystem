<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="In progress">
    <meta name="keywords" content="In progress">
    <meta name="author" content="Karol Gacon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Garage Management System</title>
    <link rel="stylesheet" href="data/css/login.css">
</head>
<body>
    <div class="mainContainer">
        <div class="mainContainer__left">
            <div class="mainContainer__left--title">
            </div>
        </div>
        <form class="mainContainer__right login" action="login" method="POST">
            <h1 class="mainContainer__right--header">Hi, Welcome Back!</h1>
            <div class="mainContainer__right--login">
                <span class="mainContainer__right--text">Email</span>
                <input name="email" type="email" class="mainContainer__right--input" placeholder="Enter Your Email">
                <span class="mainContainer__right--text">Password</span>
                <input name="password" type="password" class="mainContainer__right--input" placeholder="Enter Your Password">
                <button class="mainContainer__right--button" type="submit">Login</button>
                <?php if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo "<p class='message'>$message</p>";
                    }
                } ?>
                <span class="mainContainer__right--footer">Don't have an account? <a href="register">Sign up</a></span>
            </div>
        </form>
    </div>
</body>
</html>
