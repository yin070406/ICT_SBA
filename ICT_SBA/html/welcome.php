<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /ICT_SBA/login/login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ICT_SBA/style/style.css">
    <style>
        body{ 
            font: 14px sans-serif; 
            text-align: center; 
        }

        .settingtxt{
            font-size: 32px;
        }
    </style>
</head>
<body>

    <div class="nav">
        <a href="/ICT_SBA/index.html" class="logo"> <img src="/ICT_SBA/images/icon.png"> </a>
        <nav>
            <a href="/ICT_SBA/index.html"> Home </a>
            <a href="/ICT_SBA/html/trending.html"> TRENDING NEW </a>
            <a href="/ICT_SBA/html/best.html"> BEST GAMES </a>
            <a href="/ICT_SBA/html/new.html"> NEW GAMES </a>
        </nav>
        <a href="/ICT_SBA/login/login.php" class="logintxt"> Login </a>
        <input type="text" placeholder=" Search games.." name="search" class="searchbar">
    </div>

    <h1 class="my-5" > Welcome, <b> <?php echo htmlspecialchars($_SESSION["username"]); ?> </h1>
    <hr>
    <h1 class="settingtxt"> Account Setting </h1>
    <br>
    <p>
        <a href="/ICT_SBA/login/reset-password.php" class="btn btn-warning"> Reset Your Password </a>
        <a href="/ICT_SBA/login/logout.php" class="btn btn-danger ml-3"> Sign Out of Your Account </a>
    </p>
</body>
</html>