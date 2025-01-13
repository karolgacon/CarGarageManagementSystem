<!-- Top Navbar -->
<?php
$photo = $loggedInUser && $loggedInUser->getPhoto() ? htmlspecialchars($loggedInUser->getPhoto()) : '/public/images/default_user.png';
$name  = $loggedInUser ? htmlspecialchars($loggedInUser->getName()) : 'Guest';
?>
<!-- Zacznijmy od podstawowego stylu (inline) -->
<style>

    .navbar-nav {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .navbar-nav li {
        list-style-type: none;
    }

    .navbar {
        /* Podstawowy wygląd paska nawigacji */
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 0.5rem 1rem;
        border-bottom: 1px solid #ddd;
        position: sticky; /* lub fixed, wedle upodobań */
        top: 0;
        z-index: 100;
    }

    .container-fluid {
        /* Kontener wewnątrz navbara */
        display: flex;
        width: 100%;
        justify-content: space-between; /* Lewa i prawa część */
    }

    .navbar-nav.ms-auto {
        /* Wyrównanie listy do prawej */
        margin-left: auto;
        display: flex;
        align-items: center;
    }

    /* Link w menu (avatar + nazwa + strzałka) */
    .profile-dropdown {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        position: relative;
        cursor: pointer;
        padding: 0.5rem 0.8rem;
    }

    .profile-dropdown img.rounded-circle {
        /* Avatar użytkownika */
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 8px;
    }

    /* Ewentualnie można delikatnie wzmocnić nazwę */
    .profile-dropdown span.profile-name {
        font-weight: 600;
        margin-right: 4px;
    }

    /* Strzałka w dół (caret) - symbol Unicode ▼ (&#9662;) */
    .arrow-down {
        font-size: 0.8rem;  /* Możesz dopasować rozmiar */
        color: #666;
        transition: transform 0.3s;
    }

    /* Domyślnie menu dropdown (ul) - ukryte */
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;    /* poniżej linka */
        right: 0;     /* wyrównanie do prawej */
        background-color: #fff;
        min-width: 150px;
        margin: 0.5rem 0 0 0;
        padding: 0.5rem 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        border-radius: 4px;
        list-style: none;
        z-index: 999;
    }

    /* Linki w menu */
    .dropdown-item {
        display: block;
        padding: 0.5rem 1rem;
        color: #333;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .dropdown-item:hover {
        background-color: #f2f2f2;
    }

    /* Jeśli chcesz animować obrót strzałki, możesz dodać klasę .show do .profile-dropdown */
    .profile-dropdown.show .arrow-down {
        transform: rotate(180deg); /* odwrócenie strzałki */
    }
</style>

<nav class="navbar">
    <div class="container-fluid">
        <!-- Tu może być Twoja lewa część (np. logo, linki) –
             NIE ruszamy jej, jeśli nie chcesz.
             Możesz mieć np. <div class="navbar-left">coś tam</div> -->

        <!-- Prawa część – MS-AUTO sprawia, że ląduje w rogu -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown" style="position: relative;">
                <a href="#" class="nav-link profile-dropdown" id="profileDropdown">
                    <!-- Avatar -->
                    <img src="<?php echo $photo; ?>" alt="User" class="rounded-circle">
                    <!-- Nazwa -->
                    <span class="profile-name"><?php echo $name; ?></span>
                    <!-- Strzałka ▼ -->
                    <span class="arrow-down">&#9662;</span>
                </a>

                <!-- Menu rozwijane -->
                <ul class="dropdown-menu" id="profileDropdownMenu">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Prosty skrypt JS do obsługi rozwijanego menu -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownToggle = document.getElementById('profileDropdown');
        const dropdownMenu   = document.getElementById('profileDropdownMenu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', (event) => {
                event.preventDefault();

                // 1) Przełącz widoczność menu
                if (dropdownMenu.style.display === '' || dropdownMenu.style.display === 'none') {
                    dropdownMenu.style.display = 'block';
                } else {
                    dropdownMenu.style.display = 'none';
                }

                // 2) Dodaj/usuń klasę .show na linku, by np. obrócić strzałkę
                dropdownToggle.classList.toggle('show');
            });

            // Kliknięcie w dowolne miejsce poza menu -> zamknij
            document.addEventListener('click', (event) => {
                // Sprawdź, czy klik nie był w avatar/nazwa/strzałka ani w samym menu
                const isClickInside = dropdownToggle.contains(event.target)
                    || dropdownMenu.contains(event.target);
                if (!isClickInside) {
                    dropdownMenu.style.display = 'none';
                    dropdownToggle.classList.remove('show');
                }
            });
        }
    });
</script>
