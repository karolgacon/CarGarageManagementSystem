<!-- Top Navbar -->
<?php
$photo = $loggedInUser && $loggedInUser->getPhoto() ? htmlspecialchars($loggedInUser->getPhoto()) : '/public/images/default_user.png';
$name = $loggedInUser ? htmlspecialchars($loggedInUser->getName()) : 'Guest';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle profile-dropdown" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $photo; ?>" alt="User" class="rounded-circle" style="width: 40px; height: 40px;">
                    <?php echo $name; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="min-width: 150px;">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>