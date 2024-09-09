<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /ICT_SBA/login/login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: /ICT_SBA/login/login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Reset Password </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/ICT_SBA/style/style.css">
    <style>
        .nav > a{
            text-decoration: none;
        }
        body{
            font: 14px sans-serif;
        }
        .wrapper{
            margin-top: 50px;
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
        <h2> Reset Password </h2>
        <p> Please fill out this form to reset your password. </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label> New Password </label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label> Confirm Password </label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"> <?php echo $confirm_password_err; ?> </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="/ICT_SBA/html/welcome.php"> Cancel </a>
            </div>
        </form>

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

    </div>    
</body>
</html>