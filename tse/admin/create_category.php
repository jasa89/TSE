<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 

// Define variables and initialize with empty values
$categoryName = $categorySlug =  "";
$categorySlug_err = $categorySlug_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_categoryName = trim($_POST["categoryName"]);
    if(empty($input_categoryName)){
        $categoryName_err = "Please enter a  category name.";
    
    } else{
        $categoryName = $input_categoryName;
    }
    
    // Validate category slug description
    $input_categorySlug = trim($_POST["categorySlug"]);
    if(empty($input_categorySlug)){
        $categorySlug_err = "Please enter an slug description.";     
    } else{
        $categorySlug = $input_categorySlug;
    }
    
   
     // Check input errors before inserting in database
    if(empty($categoryName_err) && empty($categorySlug_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO categories (categoryName, categorySlug ) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_categoryName, $param_categorySlug);
            
            // Set parameters
            $param_categoryName = $categoryName;
            $param_categorySlug = $categorySlug;
         
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create category</h2>
                    <p>Please fill this form and submit to add category  record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>category name</label>
                            <input type="text" name="categoryName" class="form-control <?php echo (!empty($categoryName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categoryName; ?>">
                            <span class="invalid-feedback"><?php echo $categoryName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>slug description</label>
                            <input type="text" name="categorySlug" class="form-control <?php echo (!empty($categorySlug_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categorySlug; ?>">
                            <span class="invalid-feedback"><?php echo $categorySlug_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>