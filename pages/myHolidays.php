<?php
require_once "infos.php";
require_once "navbar.php";

if (!isset($_SESSION["username"])) {
    echo "<p>Please <a href='login.php'>Login</a> to access this page.</p>";
    exit;
}

$st = $conn->prepare("
    SELECT b.*, p.package_title, b.bookingDate
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    WHERE b.username = :username
");
$st->execute([":username" => $user]);
$res = $st->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booked</title>
  <style>
    * {
        padding: 0;
        margin: 0;
    }

    .bookList {
      margin: 20px 0 0 30px;
      color: green;
    }

    .bookList ol {
      margin-left: 20px;
    }

    p { 
        color: red;
        margin-bottom: 20px;
    }

    .innerList {
        font-size: 26px;
        color: black;
    }

    .bookedDate {
        font-style: italic;
        font-size: 16px;
    }

    .cancelledBookingMessage {
      font-size: 17px;
      color: red;
      margin-top: 10px;
      padding: 10px 0 10px 2px;
      border: 1px solid red;
      box-shadow: 0 0 14px red;
      width: 50%;
    }

    .noBooking {
      margin-left: 20px;
    }

  </style>
</head>
<body>
  <main>
    <?php 
    
    if (isset($_SESSION["cancelled"])) {
      echo "<p class='cancelledBookingMessage'>" . $_SESSION["cancelled"] . "</p>";
      unset($_SESSION["cancelled"]);
    }

    ?>
    <?php if (!$res): ?>
      <div class="noBooking">
        <h2>No bookings yet.</h2>
        <a href="tourpackages.php">Add to your holidays now.</a>
      </div>
      
    <?php else: ?>
      <div class="bookList">
        <h2>Your bookings</h2>
        <p><i>If you wish to cancel the booking, please click the title to go into detail page.</i></p>
        <ol>
          <?php foreach ($res as $booking): ?>
            <li class="innerList">
              <a href="package_details.php?id=<?= $booking['package_id'] ?>">
                <?= htmlspecialchars($booking['package_title']) ?>
              </a>
              <span class="bookedDate">(Booked on: <?= $booking["bookingDate"] ?>)</span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
