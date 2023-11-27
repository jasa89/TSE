

<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
 
// Define variables and initialize with empty values
$heading = $abstract = $post = $image =$published = $category = "";
$heading_err = $abstract_err = $post_err = $image_err = $published_err=$category_err = "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    // Validate heading
    $input_heading = trim($_POST["heading"]);
    if(empty($input_heading)){
        $heading_err = "Please enter a heading.";
    } elseif(!filter_var($input_heading, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $heading_err = "Please enter a valid heading.";
    } else{
        $heading = $input_heading;
    }
    // Validate abstract//
    $input_abstract = trim($_POST["abstract"]);
    if(empty($input_abstract)){
        $abstract_err = "Please enter an abstract.";     
    } else{
        $abstract= $input_abstract;
    }
    // Validate text
    $input_post = trim($_POST["post"]);
    if(empty($input_post)){
        $post_err = "Please enter text for post.";     
    } else{
        $post= $input_post;
    } 
// Validate category//
$input_category = trim($_POST["category"]);
if(empty($input_category)){
    $category_err = "Please enter an category for post.";     
} else{
    $category = $input_category;
}
// Validate published//
$input_published = trim($_POST["published"]);
if(empty($input_published)){
    $published_err = "Please enter if post is published or not.";     
} else{
    $published= $input_published;
}
    //validate image and save to folder
  $input_image = $_FILES["image"];
  if(empty($input_image)){
      $image_err = "Please enter an image.";     
  } else{
     
     // here move image to folder and data validation for image
     $fileName = $_FILES['image'] ['name'];
     $fileTmpName = $_FILES['image'] ['tmp_name'];
     $fileSize = $_FILES['image'] ['size'];
     $fileError = $_FILES['image'] ['error'];
     $fileType = $_FILES['image'] ['type'];
     
     $fileExt = explode('.', $fileName);
     
     $fileActualExt = strtolower(end($fileExt));
     
     $allowed = array('jpg','jpeg','png');/* määrittää sallitut tiedostomuodot*/
     if (in_array($fileActualExt, $allowed)){
     
     if($fileError===0){
     if ($fileSize < 1000000) { /* määrittää tiedoston maksimikoon */
     $fileNameNew= "post_image".$id.".".$fileActualExt;
     
     $fileDestination = 'images/'.$fileNameNew ; /* valitaan latauskohde kansio kuvalle*/
     
     move_uploaded_file($fileTmpName, $fileDestination );  
  }
 
     }}}

    // Check input errors before inserting in database
    if(empty($heading_err) && empty($abstract_err) && empty($post_err)){
        // Prepare an update statement
        $sql = "UPDATE posts SET heading=?, abstract=?, post=?, published=?, img='$fileNameNew', date = now()  WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_heading, $param_abstract, $param_post,$param_published, $param_id);
            
            // Set parameters
            $param_heading = $heading;
            $param_abstract = $abstract;
            $param_post = $post;
            $param_published = $published;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: retrieve_posts.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        } 
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM posts WHERE id = ?";
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
                    $heading = $row["heading"];
                    $abstract = $row["abstract"];
                    $post = $row["post"];
                    $image = $row["img"];
                    $published = $row["published"];
                    $cat = $row["category"];
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
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post"enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Heading</label>
                            <input type="text" name="heading" class="form-control <?php echo (!empty($heading_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $heading; ?>">
                            <span class="invalid-feedback"><?php echo $heading_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Abstract</label>
                            <textarea name="abstract"  rows="4" cols="50"class="form-control <?php echo (!empty($abstract_err)) ? 'is-invalid' : ''; ?>"><?php echo $abstract; ?></textarea>
                            <span class="invalid-feedback"><?php echo $abstract_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="post" rows="10" cols="50" class="form-control <?php echo (!empty($post_err)) ? 'is-invalid' : ''; ?>"><?php echo $post; ?></textarea>
                            <span class="invalid-feedback"><?php echo $post_err;?></span>
                       
                            <div class="form-group">
                        Select image to upload:
                        <input type="file" name="image" id="fileToUpload" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">  
                       
                        </div>
                        <br><br>
                        <label>Is published:</label>
                        <select name="published"class="form-control <?php echo (!empty($published_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $published; ?>">
                        <option value="">Select status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>

                        </select>
                            <br><br>
                   <span class="invalid-feedback"><?php echo $category_err;?></span>   
                    <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="retrieve_posts.php" class="btn btn-secondary ml-2">Cancel</a>
                        <br><br>   
                    </form>
                 </div>
                
                </div>
            </div>        
        </div>
    </div>
</body>
</html>