<?php
require "infos.php";


if (!isset($_SESSION["username"])) {
    echo "You cannot do that.";
    exit();
}

if (isset(($_GET["id"]))) {
    $contentTitle = $_GET["id"];
    try {
    $st = $conn->prepare("DELETE FROM packages WHERE id = :id");
    $st->execute([":id" => $contentTitle]);
    $_SESSION["deleted"] = "Successfully deleted.";
    header("Location: mypackages.php");

    echo "DELETED";
    } catch(PDOException $e) {
        echo "Error occured: " . $e->getMessage();
    }
}
?>