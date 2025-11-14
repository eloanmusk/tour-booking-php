<?php
require "infos.php";
$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<style>
    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            background-color: #6b5f5e;
            height: 30px;
            align-items: center;
    }

    nav ul li {
            margin-right: 20px;
            padding: 3px;
    }
    
    a {
        text-decoration: none;
        color: blueviolet;
    }

    .menu {
        color: white;
    }

    .navbar ul li.active {
        border-bottom: 3px solid coral;
    }

    .homeClass {
        margin-left: 10px;
    }

    .logoutMenu {
        color: white;
        font-size: 10px;
    }

</style>

<nav>
    <div class="navbar">
        <ul class="menuList">
            <li class="<?= $currentPage == 'index.php' ? 'active' : '' ?> homeClass"><a class="menu" href="index.php">Home</a></li>
            <li class="<?= $currentPage == 'tourpackages.php' ? 'active' : '' ?>"><a class="menu" href="tourpackages.php">Tour Packages</a></li>
            <?php
                if ($type == "user") {
                    echo "<li class='".($currentPage == "myHolidays.php" ? "active" : "")."'><a class='menu' href='myHolidays.php'>My Holidays</a></li>";
                } else if ($type == "org") {
                    echo "<li class='".($currentPage == "myHolidays.php" ? "active" : "")."'><a class='menu' href='mypackages.php'>My Packages</a></li>";
                    echo "<li class='".($currentPage == "userBookings.php" ? "active" : "")."'><a class = 'menu' href='userBookings.php'>Booked Packages</a></li>";
                }
            ?>
            <?php 
                echo "<li><a class='logoutMenu' href='../loginAndRegister/logout.php'>Logout</a></li>";
            ?>
        </ul>
    </div>
</nav>

<script>
    //spa routing

    const routes = {
        "/home": "index.php",
        "/tourpackages": "tourpackages.php",
        "/myHolidays": "myHolidays.php"
    };

    function render(path) {
        const file = routes[path];
        fetch(file)
        .then(res => res.text())
        .then(html => {
            document.querySelector("main").innerHTML = html;
        })
        .catch(() => {
            document.querySelector("main").innerHTML = "<h1>Error</h1>";
        })
    }

    // spa routing end
    const uls = document.querySelector(".menuList");
    
    function handleulresize() {
        let widthTotal = document.body.offsetWidth;
        if (widthTotal < 430) {
            uls.style.fontSize = 10 + "px";
        } else {
            uls.style.fontSize = "";
        }
    }

    window.addEventListener("resize", handleulresize);
    handleulresize();
</script>