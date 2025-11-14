<?php
session_start();

if (isset($_SESSION["username"])) {
    header("Location: ../pages/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            background-image: url('../files/imgs/chooseBg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
 

        }

        main {
            width: 100%;
            height: 500px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            position: absolute;
        }

        button {
            background-color: #dadbf0;
            padding: 50px;
            width: 150px;
            height: 150px;
            text-align: center;
            display: inline-block;
            white-space: nowrap;
            font-size: 15px;
            font-weight: bolder;
            margin-right: 10px;
            border-radius: 50%;
            border: 1px solid grey;

            transition: background-color 500ms ease, color 500ms ease, box-shadow 500ms ease;
        }

        h1 {
            position: relative;
            text-align: center;
            top: 150px;
        }

        hr {
            margin-left: 30%;
            margin-right: 30%;
            margin-top: 10px;
        }

        button:hover {
            background-color: black;
            color: white;
            box-shadow: 0 0 15px #ebe6e6;
            cursor: pointer;
        }

        .hover-info {
            position: absolute;
            margin-top: 10px;
            padding: 20px 10px 20px 10px;
            width: 250px;
            border: 1px solid grey;
            box-shadow: 0 0 10px silver;
        }

        .login {
            position: absolute;
            margin-top: 250px;
        }

        .login > a {
            text-decoration: none;
            color: black;
            padding: 5px;
            box-shadow: 0 0 15px black;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <audio id="btnSound" src="../files/sfx/echoBtn.mp3" preload="auto"></audio>

    <h1>Who are you? <hr> </h1>
    <main>
        <div class="user kx">
            <a href="userreg.php"><button>User</button></a>
            <p class="hover-info" hidden>As an user, you will be able to purchase tour package from available lists.</p>
        </div>
        <div class="manager kx">
            <a href="orgreg.php"><button>Package <br> Organizer</button></a>
            <p class="hover-info" hidden>As an package organizer, you will be able to update different tour packages available in your business.</p>
        </div>
        <div class="login">
            <a href="login.php">Or Login</a>
        </div>
    </main>
    <script>
        const btns = document.querySelectorAll("button");
        const sound = document.querySelector("#btnSound");
        const infos = document.querySelectorAll(".hover-info");
        const loginBtn = document.querySelector(".login");

        btns.forEach((btn, index) => {
            btn.addEventListener("mouseenter", () => {
                sound.currentTime = 0;
                sound.play();
                infos[index].hidden = false;
                loginBtn.hidden = true; 
            });

            btn.addEventListener("mouseleave", () => {
                infos[index].hidden = true;
                loginBtn.hidden = false;
            })
        })

    </script>
</body>
</html>