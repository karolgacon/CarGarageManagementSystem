<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="In progress">
    <meta name="keywords" content="In progress">
    <meta name="author" content="Karol Gacon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Garage Management System - Register</title>
    <link rel="stylesheet" href="data/css/register.css">
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
    <div class="mainContainer">
        <div class="mainContainer__left">
            <div class="mainContainer__left--title">
            </div>
        </div>
        <form class="mainContainer__right register" action="register" method="post">
            <h1 class="mainContainer__right--header">Create an account</h1>
            <div class="mainContainer__right--login">
                <span class="mainContainer__right--text">First Name</span>
                <input name="name" type="text" class="mainContainer__right--input" placeholder="Enter Your First Name" required>

                <span class="mainContainer__right--text">Last Name</span>
                <input name="surname" type="text" class="mainContainer__right--input" placeholder="Enter Your Last Name" required>

                <span class="mainContainer__right--text">Email</span>
                <input name="email" type="email" class="mainContainer__right--input" placeholder="Enter Your Email" required>

                <span class="mainContainer__right--text">Password</span>
                <input name="password" type="password" class="mainContainer__right--input" placeholder="Enter Your Password" required>

                <button class="mainContainer__right--button" type="submit">Sign up</button>

                <?php if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo "<p class='message'>$message</p>";
                    }
                }
                if (isset($redirect) && $redirect === true) {
                    echo "<script>
        setTimeout(function() {
            window.location.href = '/login';
        }, 5000); 
    </script>";
                }
                ?>


                <span class="mainContainer__right--footer">Already have an account? <a href="login">Login</a></span>
            </div>
        </form>

    </div>
    <script src="/data/js/pure.js"></script>
</body>
</html>
