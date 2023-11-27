<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php";
 
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err= $email_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username, );
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
   /*Sähköpostin validointi  joka ottaa huomioon tyhjät kentät ja onko sähköposti oikesssa muodossa*/
   /*tyhjä email*/
   if(empty(trim($_POST["email"]))){
    $email_err = "Please enter a email.";     
}  
elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["email"]))){
    $email = trim($_POST["email"]); 
} 
    else{
 $email_err = "email must be in right form.";
}
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }   
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($username_err) &&empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password ) VALUES (?, ?, ?)";
        if(mysqli_query($link, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            // Set parameters
            $param_username = $username;
            $param_email= $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection//
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
  <a href="index.php">Home</a>
  <a href="posts.php">Posts</a>
  <a href="privacy.php">Privacy policy</a>
</div>

<div id="main">
  <button class="openbtn" onclick="openNav()">☰</button>  
</div>
<div class="center center-join">
    <h2>Create new account</h2>     
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- rekisteröintilomake lomake jossa kentät käyttäjätunnus ja salasana  post metodi lähetys kantaan-->
    <div class="form-group">
    <label for="fname">Username</label>  <input type="text" class=" form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" id="uname" name="username" placeholder="Username" minlength="4" maxlength="10" size="20">
    <span class="invalid-feedback"><?php echo $username_err; ?></span>
   </div>
   <div class="form-group">
   <label for="e-mail">e-mail</label>  
    <input type="email" id="email" class=" form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?> " name="email" placeholder="e-mail"><!-- Muista sähköpostin php osuus yläpuolelle -->
    <span class="invalid-feedback"><?php echo $email_err; ?></span>   
</div>
    <div class="form-group">
    <label for="pass">Password:</label> 
    <input type="password" id="password" name="password"  class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" >   
     <input type="checkbox" onclick="passFunction()">Show Password
    </div>
  
     <div class="form-group">
    <label for="confirm-password"> confirm password:</label> 
   <input type="password" id="confirm" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?> " name="confirm">
<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
</div>

<div class="form-group">
    <input type="submit" value="Create account"> <!-- Create account painike -->            
                     
  <p>By creating an account you agree to our Terms & <a href="privacy.php">Privacy</a></p>
 
   <p>Already have an account? <a href="login.php">Sign in</a></p>  
   </div>
  </form>
<!-- Täällä resetointia pyytäneille käyttäjille ilmoitetaan että he ovat vaihtaneet salasanansa onnistuneesti -->
<?php
  if(isset($GET["newpwd"])){
  if($GET["newpwd"] == "passwordupdated"){
    echo"Your password has been reset";
}
  }
    
  ?>
</div>
</div>
 
 <div class="footer footer-login">
   
    <p>Footer</p>
</div>         
</div>
</body>
</html>
