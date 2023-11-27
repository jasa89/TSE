
<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to My profile page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profile.php");
    exit();
}
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php";
date_default_timezone_set('Europe/Helsinki'); /* asetetaan dafault aikavyöhyke*/
include 'comments_inc.php';
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["id"] = $id;    
                            // Redirect user to my profile page
                            header("location: profile.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
<title>TSE</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="Logo v2.png"> <!-- Sivun yläosan logo kuvake joka näkyy välilehdessä -->
<script src="script.js"></script><!--Ulkoinen javascript tiedosto -->
</head>
<body>
<?php include 'topnav.php';?><!-- topnav osa php tiedostosta-->
  <div class="container">  <!-- Index sivun sisältöcontaineri-->
<!-- The sidebar collapse avattava ja suljettava -->
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="index.html">Home</a>
  <a href="posts.html">Posts</a>
  <a href="privacy.html">Privacy policy</a>
</div>
<div id="main">
  <button class="openbtn" onclick="openNav()">☰</button>  
</div>

<div class=" center center-login">
    <h2>Login</h2>     
    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Login lomake jossa kentät käyttäjätunnus ja salasana myös tarvittavat validoinnit -->
    <div class="form-group">
    <label for="fname">Username:</label> <input type="text" id="uname" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?> " name="username">
    <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>
    <div class="form-group">
    <label for="pass">Password:</label> <input type="password"id="pass" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> " name="password">
    <span class="invalid-feedback"><?php echo $password_err; ?></span>
</div>
<div class="form-group">      
<input type="submit" value="Sign in"> <!-- Kirjautumispainike ja peruuta painike -->
     <p>Are you new? <a  href="join.php"> Join TSE</a>  </p> <!-- Linkki uusille käyttäjille voissa voi luoda käyttäjätunnuksen -->
     <p>Forgot <a  href="forgot.html"> password?</a>  </p> <!-- Unohditko salasanasi linkki -->
    </div>
  </form>
  </div>
</div>
 <div class=" footer footer-login">
   
 
</div>       
</div>
</body>
</html>
