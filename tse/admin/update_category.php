<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
 
// Define variables and initialize with empty values
$categoryName = $categorySlug = "";
$categoryName_err = $categorySlug_err  = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate  category name
    $input_categoryName = trim($_POST["categoryName"]);
    if(empty($input_categoryName)){
        $categoryName_err = "Please enter a  category name.";
    } elseif(!filter_var($input_categoryName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $categoryName_err = "Please enter a valid category name.";
    } else{
        $categoryName = $input_categoryName;
    }
    
    // Validate category slug
    $input_categorySlug = trim($_POST["categorySlug"]);
    if(empty($input_categorySlug)){
        $categorySlug_err = "Please enter an slug description.";     
    } else{
        $categorySlug = $input_categorySlug;
    }
    
    // Check input errors before inserting in database
    if(empty($categoryName_err) && empty($categorySlug_err)){
        // Prepare an update statement
        $sql = "UPDATE categories SET categoryName=?, categorySlug=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_categoryName, $param_categorySlug, $param_id);
            
            // Set parameters
            $param_categoryName = $categoryName;
            $param_categorySlug = $categorySlug;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: retrieve_categories.php");
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
        $sql = "SELECT * FROM categories WHERE id = ?";
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
                    $categoryName = $row["categoryName"];
                    $categorySlug = $row["categorySlug"];
                  
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
    <title>Update category Record</title>
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
                    <h2 class="mt-5">Update category Record</h2>
                    <p>Please edit the input values and submit to update the category record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="categoryName" class="form-control <?php echo (!empty($categoryName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categoryName; ?>">
                            <span class="invalid-feedback"><?php echo $categoryName_err;?></span>
                        </div>
                       
                        <div class="form-group">
                            <label>Category slug description</label>
                            <input type="text" name="categorySlug" class="form-control <?php echo (!empty($categorySlug_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categorySlug; ?>">
                            <span class="invalid-feedback"><?php echo $categorySlug_err;?></span>
                        </div>
                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="retrieve_categories.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>