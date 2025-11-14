<?php
require "infos.php";
require "navbar.php";
require "../vendor/autoload.php";

if (isset($_SESSION["booked"])) {
    echo "<h3 class='bookingDone'>" . $_SESSION["booked"] . "</h3>";
    unset($_SESSION["booked"]);
}

if (isset($_SESSION["alreadyBooked"])) {
    echo "<h3 class='alreadyBooked'>" . $_SESSION["alreadyBooked"] . "</h3>";
    unset($_SESSION["alreadyBooked"]);
}
try {
    $st = $conn->prepare("SELECT * FROM packages");
    $st->execute();
    $res = $st->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Sorry! An error occured. Error code: " . $e->getCode(); 
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All tour packages</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        .heading {
            margin-left: 20px;
            margin-top: 10px;
        }

        .bookingDone {
            color: green;
            padding: 10px;
            margin: 10px;
            border: 1px solid green;
            box-shadow: 0 0 4px seagreen;
        }

        .alreadyBooked {
            color: red;
            padding: 10px;
            margin: 10px;
            border: 1px solid green;
            box-shadow: 0 0 4px seagreen;
        }

        .tourLists {
            display: flex;
            flex-direction: column;
            margin: 10px 0 30px 30px;
        }

        .packages_list {
            padding: 10px;
            margin-bottom: 20px;
        }


        img {
            border-radius: 10px;
            box-shadow: 0 0 5px black;
            width: 60%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <main>
        <div class="heading">
            <h2>Here are the list of tour packages available as of now:</h2>
            <p>Please click on the title to go into details.</p>
        </div>
        <div class="tourLists">
            <?php
                $Parsedown = new Parsedown();
                
                foreach($res as $packz) {
                    $packz["package_title"] = "<a href='package_details.php?id=" . $packz["id"] . "'>" . $packz["package_title"] . "</a>";
                    $packz["package_info"] = $Parsedown->text(substr($packz["package_info"], 0, 60) . "...");
                    echo "<div class='packages_list'>" . "<img src='../destImages/" . $packz["photo_path"] . "'><br><h3>" . $packz["package_title"] . "</h3>"
                     . "<p><i>Duration: " . $packz["duration"] . "</i></p>"
                    . "<p><strong>" . $packz["organizer"] . "</strong></p>" .
                    "<p>" . $packz["package_info"] . "</p>" . "<br>"
                    . "<p>Contact Info: " . $packz["contact_info"] . "</p>" . "<p>Bookings till now: " . $packz["bookings"] . "</p>"
                    . "<br><hr></div>";
                }
            ?>
        </div>
    </main>
</body>
</html>