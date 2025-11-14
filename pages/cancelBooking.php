<?php

require "infos.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    try {
        $st = $conn->prepare("DELETE FROM bookings WHERE username = :username AND package_id = :id");
        $st->bindParam(":username", $user, PDO::PARAM_STR);
        $st->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
        $st->execute();
        
        // need to update bookings in packages db.

        $_SESSION["cancelled"] = "Successfully cancelled the booking.";
        header("Location: myHolidays.php");

    } catch(PDOException $e) {
        echo "Some error occurred." . $e->getMessage();
    }
}

?>