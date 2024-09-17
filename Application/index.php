<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//header("Location: View/operations_01/option_Ent_Sor.php");
include "Config/connect_db.php";
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>

    <title>Document</title>
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
</head>
<body>
<style>
    .main{
        width: 100%;
        height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .content{
        width: 80%;
        display: flex;
        justify-content: center;
    }

    .input-div{
        /*width: 100%;*/
        display: flex;
        justify-content: space-between;
        border: 2px solid black;
        border-radius: 20px;
        padding: 10px;
        margin-top: 40px;
    }


    input[type="password"], input[type="text"] {
        border:none;
        /*padding: 10px;*/
        width: 100%;
        font-size: 26px;
        outline: none;

    }
    input:focus{
        border:none;
    }

    .show-btn {
        background: none;
        border: none;
        cursor: pointer;
    }

</style>

<h1>Welcome</h1>

<div class="main">

    <div class="content">





            <form class="form" action="Config/connecter.php" method="post">
                <h1>Entrer your password</h1>
                <div class="input-div">
                    <input type="text" name="user_name">
                </div>
                <div class="input-div">
                    <input type="password" id="password" class="" name="password">
                    <button type="button" class="show-btn" onclick="togglePassword()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                        </svg></button>
                </div>

                <button type="submit">Se connecter</button>

            </form>




    </div>

</div>










<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var showBtn = document.querySelector(".show-btn");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
        </svg>`;
        } else {
            passwordInput.type = "password";
            showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
  <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
  <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
</svg>`;
        }
    }
</script>

</body>
</html>

