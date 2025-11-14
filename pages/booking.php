<?php

require "infos.php";
if (isset($_GET["id"])) {
    $idToCheck = $_GET["id"];
    $checkBookings = $conn->prepare("SELECT 1 FROM bookings WHERE username = :username AND package_id = :package_id LIMIT 1");
    $checkBookings->execute([":username" => $user, ":package_id" => $idToCheck]);
    $res = $checkBookings->fetchAll();
    $continue = $checkBookings->rowCount() === 0;
    }

    if ($continue) {
        $packageId = $_GET["id"];
        $st = $conn->prepare("UPDATE packages SET bookings = bookings + 1 WHERE id = :id");
        $st->bindParam(":id", $packageId, PDO::PARAM_INT);
        $st->execute();

        $mySt = $conn->prepare("INSERT INTO bookings (username, email, bookingDate, package_id) VALUES (:username, :email, :bookingDate, :package_id)");
        $mySt->bindParam(":username", $user, PDO::PARAM_STR);
        $mySt->bindParam(":email", $mail, PDO::PARAM_STR);
        $mySt->bindParam(":bookingDate", $curDate, PDO::PARAM_STR);
        $mySt->bindParam(":package_id", $packageId, PDO::PARAM_INT);
        $mySt->execute();
        $_SESSION["booked"] = "Successfully booked the package.";
        header("Location: tourpackages.php");
    } else {
        $_SESSION["alreadyBooked"] = "You have already booked this holiday. Please select a new one.";
        header("Location: tourpackages.php");
    }


?>