<?php
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /ICT_SBA/html/welcome.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: /ICT_SBA/html/welcome.php");
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<head>
    <title> Login </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/ICT_SBA/style/login.css">
    <style>
        body{
            font: 14px sans-serif; 
            min-height: 100vh;
            background: #d3d3d3;
            background-size: cover;
            background-position: center;
        }

        .wrapper{
            height: 430px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;    
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

    <div class="wrapper">
        <h2> Login </h2>
        <p> Please fill in your credentials to login. </p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label> Password </label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p> Don't have an account? <a href="/ICT_SBA/login/register.php"> Sign up now </a>.</p>
        </form>
    </div>

    <div class="footer-container">
        <footer>
            <div class="social">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
            </div>

            <div class="footer">
                <ul>
                    <li><a href="/ICT_SBA/index.html"> Home </a></li>
                    <li><a href=""> About Us </a></li>
                    <li><a href=""> Terms of Services</a></li>
                    <li><a href=".social"> Contact </a></li>
                </ul>
            </div>

            <div class="txt">
                &nbsp&nbsp&nbsp
            </div>
        </footer>
    </div>

    <script src="/ICT_SBA/script/searchbar.js"></script>

</body>
</html>