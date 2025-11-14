<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require "../dbs/dbcon.php";
    if (!isset($_SESSION["username"])) {
        header("Location: ../loginAndRegister/login.php");
    }

    try {
        $curDate = date("Y-m-d H:i:s");
        $user = $_SESSION["username"];
        $st = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $st->execute([":username" => $user]);
        $res = $st->fetch(PDO::FETCH_ASSOC);
        
        $dob = $res["birthDate"];
        $address = $res["address"];
        $mail = $res["email"];
        $type = $res["type"];
    } catch(PDOException $e) {
        echo "Error Occurred.";
    }

?>