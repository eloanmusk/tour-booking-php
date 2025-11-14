<?php
session_start();
require "../dbs/dbcon.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST["username"]);
    $pssd = $_POST["pw"];

    $st = $conn->prepare("SELECT id, username, password_hash, type FROM users WHERE username = :username LIMIT 1");
    $st->execute([':username' => $uname]);
    $res = $st->fetch(PDO::FETCH_ASSOC);
    $_SESSION["s"] = $res;    
    
    if (!$res) {
        $error = "Invalid Username or Password.";
    }

    if ($res && password_verify($pssd, $res["password_hash"])) {
        $_SESSION["type"] = $res["type"];
        $_SESSION["username"] = $res["username"];

        header("Location: ../pages/index.php");
    } else {
        $error = "Invalid Username or Password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            background-image: url('../files/imgs/lgimg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        h3 {
            text-align: center;
        }
        .container {
            height: auto;
            width: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 5px black;
            border-radius: 14px;
            padding: 10px;
            transition: box-shadow 300ms ease;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        input {
            height: 20px;
            border: 0.3px solid;
            border-radius: 6px;
        }

        .form-buttons {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button {
            border-radius: 6px;
            padding: 4px 7px 4px 7px;
        }

        button:hover {
            box-shadow: 0 0 10px black;
            cursor: pointer;
        }

        .container:hover {
            box-shadow: 0 0 9px black;
        }

        h2 {
            margin-top: -401px;
            padding: 10px;
            position: absolute;
            color: green;
            box-shadow: 0 0 10px seagreen;
            border-radius: 20px;

        }

        h2:empty {
            display: none;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2><?php
    if (isset($_SESSION["flashmessage"])) {
        echo "<h2>" . $_SESSION["flashmessage"] . "</h2>";
        unset($_SESSION["flashmessage"]);
    }
    ?></h2>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h3>Login</h3>
            <hr>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>

            <div class="form-group">
                <label for="pw">Password</label>
                <input type="password" id="pw" name="pw">
            </div>
            <div class="form-group">
                <p class="error"><?php echo $error; ?></p>
            </div>
            <div class="form-buttons">
                <button type="submit">Login</button>
            </div>
            <div class="form-group">
                <p>Don't have an account? <a href="../pages/index.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>