<?php
require "navbar.php";
require "infos.php";
require "../vendor/autoload.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    try {
        $st = $conn->prepare("SELECT * FROM packages WHERE id = :id");
        $st->execute([":id" => $_GET["id"]]);
        $res = $st->fetch(PDO::FETCH_ASSOC);

        if ($res === false) {
            header("Location: tourpackages.php");
            exit();
        }

        $Parsedown = new Parsedown();
        $title = $res["package_title"];
        $desc = $Parsedown->text($res["package_info"]);
        $contactInfo = $res["contact_info"];
        $organizedBy = $res["organizer"];
        $time = $res["duration"];
        $pic = $res["photo_path"];
        $checkIfBooked = $conn->prepare("SELECT * FROM bookings WHERE package_id = :id AND username = :username");
        $checkIfBooked->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
        $checkIfBooked->bindParam(":username", $user, PDO::PARAM_STR);
        $checkIfBooked->execute();
        $checkVal = $checkIfBooked->fetch();

        if ($checkVal) {
            $actionToPerform = "<a href='cancelBooking.php?id=" . $_GET["id"] . "'>Cancel Booking</a>";
        } else {
            $actionToPerform = "<a href='booking.php?id=" . $_GET["id"] . "'>Book this tour package</a>";
        }
    } catch(PDOException $e) {
        error_log("Database error: " . $e->getMessage()); // debugging purpose
        header("Location: tourpackages.php");
        exit();
    }
} else {

    header("Location: tourpackages.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        echo $title;
    ?></title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        .detailTour {
            padding: 30px 0 0 20px;
        }

        img {
            border-radius: 10px;
            box-shadow: 0 0 5px black;
            max-width: 80%;
        }
    </style>
</head>
<body>
    <main>
        <div class="detailTour">
            <?php
            echo "<div class='insideBox'>" . 
            "<img src='../destImages/" . htmlspecialchars($pic) . "' width='600'>" .
            "<h2>" . $title . "</h2>" . "<br>" . "<p><i>Duration: " . $time . " | Package By: " . $organizedBy . "</i></p>" . "<br><h3>Detailed Information about the tour</h3><br>" . $desc;
            echo "<br><br>";
            echo $actionToPerform;
            echo " | <a href='tourpackages.php'>Return to tour packages</a>";
            ?>
        </div>
    </main>
</body>
</html>