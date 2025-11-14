<?php
require "../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "navbar.php";
require "../dbs/dbcon.php";
if (isset($_SESSION["added"])) {
    echo "<p class='flash'>" . $_SESSION["added"] . "</p>";
    unset($_SESSION["added"]); 
}
if (isset($_SESSION["deleted"])) {
    echo "<p class='deletedFlash'>" . $_SESSION["deleted"] . "</p>";
    unset($_SESSION["deleted"]);
}
$org = $_SESSION["username"];
$st = $conn->prepare("SELECT * FROM packages WHERE organizer = :organizer");
$st->execute([":organizer" => $org]);

$res = $st->fetchAll(PDO::FETCH_ASSOC);
$offeredPackages = count($res);

if ($offeredPackages == 0) {
    echo "<div class='container'>
        <h2 class='noPackages'>You currently do not have any packages to offer to the customers.</h2>
            <a href='addPackage.php' class='newPackage'>Add a new package</a>
    </div>";
} else {
    echo "<div class='boxForAll'><h2>Here are your packages</h2>";
    $Parsedown = new Parsedown();
    foreach($res as $packz) {
        echo "<div class='packages_list'><h3>" . $packz["package_title"] . "</h3>"
        . "<br>" . "<p><i>" . $packz["duration"] . "</i></p>"
        . "<p><strong>" . $packz["organizer"] . "</strong></p>" .
        "<p>" . $Parsedown->text($packz["package_info"]) . "</p>" . "<br>"
        . "<p>Contact Info: " . $packz["contact_info"] . "</p>"
        . "<a class='delBtn' href='delete.php?id=" . $packz["id"] . "'>Delete</a>"
        . "<hr></div>";
    }
    echo "    <div class='packages_list'>
            <a href='addPackage.php' class='newPackage'>Add a new package</a>
    </div>";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }


        .flash {
            color: green;
            margin: 0px 0px 20px 5px;
            font-size: 26px;
            font-weight: bolder;
            box-shadow: 0 0 10px black;
        }

        .deletedFlash {
            color: red;
            margin: 0px 0px 20px 5px;
            font-size: 26px;
            font-weight: bolder;
            box-shadow: 0 0 10px black;
        }
        .boxForAll {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: left;
            margin-left: 10px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .packages_list {
            height: auto;
            width: auto;
            margin-top: 10px;
            padding: 5px 5px 20px 5px;
            margin-bottom: 20px;
        }

        hr {
            margin-top: 10px;
        }

        .newPackage {
            color: blue;
            margin-left: 20px;
            
        }
        .newPackage {
        }
    </style>
</head>
<body>

</body>
<script>
    let del = document.querySelectorAll(".delBtn");
    del.forEach(btn => {
        btn.onclick = function() {
            return confirm("Are you sure?");
        }
    })
</script>
</html>