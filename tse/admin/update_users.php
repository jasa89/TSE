<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
 
// Define variables and initialize with empty values
$userName = $status = "";
$userName_err = $status_err  = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate  username name
    $input_userName = trim($_POST["userName"]);
    if(empty($input_userName)){
        $userName_err = "Please enter a  user name.";
    
       
    } else{
        $userName = $input_userName;
    }
    
    // Validate Role
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please select if user is admin or not.";     
    } else{
        $status = $input_status;
    }
    
    // Check input errors before inserting in database
    if(empty($userName_err) && empty($status_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET username=?, role=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_userName, $param_status, $param_id);
            
            // Set parameters
            $param_userName = $userName;
            $param_status = $status;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: retrieve_users.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $userName = $row["username"];
                    $status = $row["role"];
                  
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update user Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update user Record</h2>
                    <p>Please edit the input values and submit to update the user record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="userName" class="form-control <?php echo (!empty($userName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $userName; ?>">
                            <span class="invalid-feedback"><?php echo $userName_err;?></span>
                        </div>
                        <label>Is Admin:</label>
                        <select name="status"class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                        <option value="">Select status</option>
                        <option value="Admin">Yes</option>
                        <option value="user">No</option>
                        </select>
                            <br><br>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="retrieve_users.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>