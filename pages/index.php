<?php
include 'navbar.php';

if (!isset($_SESSION["username"])) {
    header("Location: ../loginAndRegister/choose.php");
    exit;
}
$user = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        main {
            margin: 20px 0 0 20px;

        }

        .searchBox {
            position: relative;
            display: inline-block;
            margin-top: 20px;
        }

        .searchInput {
            padding: 0 29px 0 10px;
            height: 35px;
            font-size: 16px;
            outline: none;
            border-radius: 10px;
            border: 1px solid grey;

        }

        .searchIcon {
            position: relative;
            width: 20px;
            height: 20px;
            right: 30px;
            top: 4px;
            cursor: pointer;
        }

        .searchResults {
            display: flex;
            flex-direction: column;
        }

        ol {
            padding-left: 20px;
            font-size: 20px;
            border-radius: 0 0 10px black;
        }

        footer {
            margin-left: 50px;
        }
    </style>
</head>
<body>
    <main>
        <div class="welcomeMsg">
            <h2>Hello, <?php echo $user; ?></h2>
        </div>
        <div class="searchBox">
            <form method="get">
                <input type="text" placeholder="Search" name="searchInput" class="searchInput">
                <img src="../files/imgs/srch.png" class="searchIcon">
            </form>
        </div>

        <div class="searchResults">
            <?php
            
            if (isset($_GET["searchInput"]) && !empty($_GET["searchInput"])) {
                $query = trim(strtolower($_GET["searchInput"]));
                $searchingQuery = "%" . $query . "%";
                $st = $conn->prepare("SELECT * FROM packages WHERE package_title LIKE :searched or package_info LIKE :searched");
                $st->bindParam(":searched", $searchingQuery, PDO::PARAM_STR);
                $st->execute();
                $res = $st->fetchAll(PDO::FETCH_ASSOC);
                if (count($res) > 0) {
                    echo "<p>Search results for <strong>" . htmlspecialchars($query) . "</strong></p><br>";
                    echo "<ol>";
                    foreach($res as $tour) {
                    echo "<li><a href='package_details.php?id=" . $tour["id"] . "'>" . $tour["package_title"] . "</a>" . "</li>";
                    }
                    echo "</ol>";
                } else {
                    echo "<p>No results found for " . $query . "</p>";
                }
            } else if (isset($_GET["searchInput"]) && empty($_GET["searchInput"])) {
                echo "<p>Please enter a search query.</p>";
            }

            ?>
        </div>
    </main>
    <script>
        const searchIconBtn = document.querySelector(".searchIcon");
        searchIconBtn.addEventListener("click", () => {
            const form = document.querySelector("form");
            form.submit();
        })
    </script>
</body>
</html>