<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="In progress">
    <meta name="keywords" content="In progress">
    <meta name="author" content="Michal Szymacha">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Garage Management System</title>
    <link rel="stylesheet" href="data/css/login.css">
</head>
<body>
    <div class="mainContainer">
        <form class="login" action="login" method="post">
            <div class="mainContainer__right">
                <h1 class="mainContainer__right--header">Hi, Welcome Back!</h1>
                <label class="mainContainer__right--text" for="email">
                    <input name="email" type="text" class="mainContainer__right--input" placeholder="Enter Your Email">
                </label>
                <label class="mainContainer__right--text" for="password">
                    <input name="password" type="password" class="mainContainer__right--input" placeholder="Enter Your Password">
                </label>
                <button class="mainContainer__right--button" type="submit" >Login</button>
                 <?php if(isset($messages)) {
                            foreach($messages as $message) {
                                echo $message;
                            }
                    } ?>
                <span class="mainContainer__right--footer">Don't have an account? <a href="register">Sign up</a></span>
            </div>
        </form>
    </div>
</body>
</html>