<?php
session_start();
require '../dbs/dbcon.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    * {
      padding: 0;
      margin: 0;
    }
    body {
      width: 100%;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      background-image: url('../files/imgs/bgimg.jpg');
      background-position: center;
      background-repeat: no-repeat;
      
    }
    .container {
      width: auto;
      height: auto;
      position: absolute;
      border-radius: 20px;
      padding: 0 60px 30px 60px;
      box-shadow: 0 0 3px black;
      color: black;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }
    #register {
      text-align: center;
    }
    .form-buttons {
      height: 80px;
      position: relative;
      display: flex;
      justify-content: space-evenly;
      align-items: center;
    }
    button {
      padding: 5px;
      border-radius: 10px;
      border: 1px solid #cbcdd1;
    }

    input {
      border-radius: 4px;
      border: 0.2px solid;
      height: 20px;
    }

    button:hover {
      box-shadow: 0 0 3px black;
    }

    .container:hover {
      box-shadow: 0 0 12px black;
    }

    .error {
      color: red;
    }

    h3 {
      padding-top: 20px;
      padding-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php

  
  $usernameErr = $emailErr = $addressErr = $dobErr = $passErr= "";
  $username = $email = $address = $dob = $pw = "";
  $type = "org";
  $anyError = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Username
    if (empty($_POST["username"])) {
      $usernameErr = "Please enter your username.";
      $anyError = true;
    } else {
      if (!preg_match("/^[0-9a-zA-Z-']*$/", $_POST["username"])) {
        $usernameErr = "Username shall only contain alphabets and numbers.";
        $anyError = true;
      }
      $username = $_POST["username"];
    };

    // email
    if (empty($_POST["email"])) {
      $emailErr = "Please enter your email.";
      $anyError = true;
    } else {
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
        $anyError = true;
      }
      $email = $_POST["email"];
    };

    // address
    if (empty($_POST["address"])) {
      $addressErr = "Please enter your address.";
      $anyError = true;
    } else {
      $address = $_POST["address"];
    };

    // dob
    if (empty($_POST["dob"])) {
      $dobErr = "Please enter your date of birth.";
      $anyError = true;
    } else {
      $dob = $_POST["dob"];
    };

    // pass

    if (empty($_POST["pw"])) {
      $passErr = "Please enter password.";
      $anyError = true;
    } else if (!preg_match("/^.{12,}$/", $_POST["pw"])) {
      $passErr = "Password should atleast be 12 characters long.";
      $anyError = true;

    } else {
      if ($_POST["pw"] !== $_POST["cpw"]) {
        $passErr = "Passwords do not match.";
      } else {
        $pw = password_hash($_POST["pw"], PASSWORD_DEFAULT);
      }
    }
    // header
  if (!$anyError) {
    // Prepare the query to check if the username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the query returned any results
    if (!empty($results)) {
        // If there are results, that means the username or email is already taken
        echo "<p class='error'>Username or Email address already in use.</p>";
    } else {
        // If no results, we can safely insert the new user
        $st = $conn->prepare("INSERT INTO users (username, email, type, address, birthDate, password_hash) 
                              VALUES (:username, :email, :type, :address, :birthDate, :password_hash)");

        // Bind the values to the placeholders in the INSERT query
        $st->bindParam(':username', $username, PDO::PARAM_STR);
        $st->bindParam(':email', $email, PDO::PARAM_STR);
        $st->bindParam(':type', $type, PDO::PARAM_STR);
        $st->bindParam(':address', $address, PDO::PARAM_STR);
        $st->bindParam(':birthDate', $dob, PDO::PARAM_STR);
        $st->bindParam(':password_hash', $pw, PDO::PARAM_STR);


        // Execute the insert query
        $st->execute();
        $_SESSION["flashmessage"] = "You are registered. Please login.";
        header("Location: login.php");
    }
}
  };

  
  
  ?>
  <div class="container">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <div class="form-group">
        <h3 id="register">Register</h3><hr>

        <label for="uname" style="padding-top: 20px;">Username<span class="error">*</span></label>
        <p class="error"><?php echo $usernameErr; ?></p>
        <input type="text" id="uname" name="username" value="<?php echo $username; ?>">

      </div>

      <div class="form-group">

        <label for="email">Email<span class="error">*</span></label>
        <p class="error"><?php echo $emailErr; ?></p>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>">

      </div>

      <div class="form-group">

        <label for="address">Address</label>
        <p class="error"><?php echo $addressErr; ?></p>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>">

      </div>

      <div class="form-group">

        <label for="dob">Date of establishment</label>
        <p class="error"><?php echo $dobErr; ?></p>
        <input type="date" id="dob" name="dob">

      </div>

      <div class="form-group">

        <label for="pw">Password</label>
        <p class="error"><?php echo $passErr; ?></p>
        <input type="password" id="pw" name="pw">

      </div>

      <div class="form-group">

        <label for="cpw">Confirm password</label>
        <p class="error"><?php echo $passErr; ?></p>
        <input type="password" id="cpw" name="cpw">

      </div>

      <div class="form-buttons">

        <button type="submit">Submit</button>
        <button type="reset">Reset</button>

      </div>

      <div class="form-group">
        <p>Already an user? <a href="login.php">Login</a></p>
      </div>
    </form>

  </div>
  <script>
  </script>
</body>
</html>