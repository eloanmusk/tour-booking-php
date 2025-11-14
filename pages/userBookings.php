<?php

require "navbar.php";

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

        table, tr, td,th {
            border-collapse: collapse;
            border: 1px solid;
        }

        table {
            margin: 20px 0px 0px 50px;
        }

        td, th {
            padding:10px;
        }
    </style>
</head>
<body>
    <div class="bookedTable">
    <?php
    // Prepare the query to fetch all bookings with associated package details in one go
    $st = $conn->prepare("
        SELECT b.username, b.bookingDate, p.package_title, p.organizer
        FROM bookings b
        JOIN packages p ON b.package_id = p.id
        WHERE p.organizer = :user
    ");
    // Bind user parameter and execute query
    $st->execute([":user" => $user]);
    $res = $st->fetchAll(PDO::FETCH_ASSOC);

    if (count($res) == 0) {
        echo "There are no bookings for your tour packages yet.";
    } else {
        echo "<table>";
        echo "<thead><tr><th>Username</th><th>Title</th><th>Booked Date</th></tr></thead><tbody>";

        // Loop through the result and display each booking
        foreach ($res as $tourPackage) {
            echo "<tr><td>" . htmlspecialchars($tourPackage["username"]) . "</td>
                      <td>" . htmlspecialchars(substr($tourPackage["package_title"], 0, 20)) . "</td>
                      <td>" . htmlspecialchars($tourPackage["bookingDate"]) . "</td></tr>";
        }

        echo "</tbody></table>";
    }
    ?>
</div>

</body>
</html>