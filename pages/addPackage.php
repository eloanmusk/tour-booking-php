<?php
include "navbar.php";
require "infos.php";


$titleErr = $photoErr = $descriptionErr = $durationErr = $contactErr = "";
$title = $desc = $duration = $contact = "";
$targetDir = "../destImages/";
$filename = "";
$org = $user;
$presenceOfError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["packageTitle"])) {
        $presenceOfError = true;
        $titleErr = "Please enter a title.";
    } else {
        $title = $_POST["packageTitle"];
    }

    if (empty($_POST["packageInfo"])) {
        $presenceOfError = true;
        $descriptionErr = "Please enter a description.";
    } else {
        $desc = $_POST["packageInfo"];
    }

    if (empty($_POST["packageDuration"])) {
        $presenceOfError = true;
        $durationErr = "Please enter a duration.";
    } else {
        $duration = $_POST["packageDuration"];
    }

    if (empty($_POST["contactInfo"])) {
        $presenceOfError = true;
        $contactErr = "Please provide a contact info.";
    } else {
        $contact = $_POST["contactInfo"];
    }

    if (isset($_FILES["refImage"]) && $_FILES["refImage"]["error"] === 0) {
        $filename = time() . "_" . basename($_FILES["refImage"]["name"]);
        $targetFile = $targetDir . $filename;

        $info = getimagesize($_FILES["refImage"]["tmp_name"]);
        if ($info["mime"] == 'image/jpeg') {
            $image = imagecreatefromjpeg($_FILES["refImage"]["tmp_name"]);
            imagejpeg($image, $targetFile, 70);
            imagedestroy($image);
        } else if ($info["mime"] == 'image/png') {
            $image = imagecreatefrompng($_FILES["refImage"]["tmp_name"]);
            imagepng($image, $targetFile, 6);
            imagedestroy($image);
        } else {
            $photoErr = "Only JPG or PNG allowed.";
            $presenceOfError = true;
        }
    } else {
        $presenceOfError = true;
    }

    if (!$presenceOfError) {
        $st = $conn->prepare("INSERT INTO packages (organizer, package_title, duration, package_info, contact_info, photo_path) VALUES (:organizer, :package_title, :duration, :package_info, :contact_info, :photo_path)");
        $st->bindParam(":organizer", $org, PDO::PARAM_STR);
        $st->bindParam(":package_title", $title, PDO::PARAM_STR);
        $st->bindParam(":duration", $duration, PDO::PARAM_STR);
        $st->bindParam(":package_info", $desc, PDO::PARAM_STR);
        $st->bindParam(":contact_info", $contact, PDO::PARAM_STR);
        $st->bindParam(":photo_path", $filename, PDO::PARAM_STR);

        try {
            $st->execute();
            $_SESSION["added"] = "You have added a new package.";
            header("Location: mypackages.php");

        } catch(PDOException $e) {
            echo $e->getMessage();
            echo "<p class='error'>Sorry, an error occured.</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        .container {
            margin-top: 10px;
            margin-left: 10px;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: left;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .submitButton {
            margin-top: 10px;
        }

        textarea, input {
            margin-bottom: 10px;
            font-size: 16px;
        }

        textarea {
            resize: none;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="packageTitle">Title of your tour package</label>
                <p class="error"><?php echo $titleErr; ?></p>
                <textarea placeholder="Eg. Kathmandu to Pokhara" id="packageTitle" name="packageTitle"></textarea>
            </div>
            <div class="form-group">
                <label for="packageDuration">Duration of the tour</label>
                <p class="error"><?php echo $durationErr; ?></p>
                <input type="text" placeholder="Eg. 2 nights 3 days" name="packageDuration" id="packageDuration" value="<?php echo $duration; ?>">
            </div>

            <div class="form-group">
                <label for="packageInfo">Description of your tour</label>
                <p class="error"><?php echo $descriptionErr; ?></p>
                <textarea rows="10" cols="60" name="packageInfo" id="packageInfo"></textarea>
            </div>
            <div class="form-group">
                <label for="contactInfo">Contact info</label>
                <p class="error"><?php echo $contactErr; ?></p>
                <input type="text" name="contactInfo" id="contactInfo" value="<?php echo $contact; ?>">
            </div>
            <div class="form-group">
                <label for="refImage">Photo of destination *jpg or png only</label>
                <input type="file" id="refImage" name="refImage" required>
            </div>
            <div class="submitButton">
                <input type="submit">
            </div>
</form>
    </div>
</body>
</html>