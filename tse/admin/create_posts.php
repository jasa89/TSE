<?php
// Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
 
// Define variables and initialize with empty values
$heading = $abstract = $post = $image= "";
$heading_err = $abstract_err =$post_err = $image_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        $abstract_err = "Please enter an abstract for post.";     
    } else{
        $abstract = $input_abstract;
    }
    
    // Validate text//
    $input_post = trim($_POST["post"]);
    if(empty($input_post)){
        $post_err = "Please enter text for post.";     
    } else{
        $post = $input_post;
    }
     // Validate category//
     $input_category = trim($_POST["category"]);
     if(empty($input_category)){
         $category_err = "Please enter an category for post.";     
     } else{
         $category = $input_category;
     }
      
    // Validate image
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
        // Prepare an insert statement
        $sql = "INSERT INTO posts (heading, abstract, post, category, img, date) VALUES (?, ?, ?, ?, ?, now())"; 
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_heading, $param_abstract, $param_post, $param_category, $param_image); /* Tänne vielä onko julkaistu vai ei*/
            
            // Set parameters
            $param_heading = $heading;
            $param_abstract = $abstract;
            $param_post = $post;
            $param_category = $category;
             $param_image = $fileNameNew;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: retrieve_posts.php");
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

<?php
$sql="SELECT * FROM categories";
$query=mysqli_query($link,$sql);


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
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
                    <h2 class="mt-5">Create A new post</h2>
                    <p>Please fill this form and submit to add new blog post  to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Heading</label>
                            <input type="text" name="heading" class="form-control <?php echo (!empty($heading_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $heading; ?>">
                            <span class="invalid-feedback"><?php echo $heading_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Abstract</label>
                            <textarea name="abstract" class="form-control <?php echo (!empty($abstract_err)) ? 'is-invalid' : ''; ?>"><?php echo $abstract; ?></textarea>
                            <span class="invalid-feedback"><?php echo $abstract_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="post" class="form-control <?php echo (!empty($post_err)) ? 'is-invalid' : ''; ?>"><?php echo $post; ?></textarea>
                            <span class="invalid-feedback"><?php echo $post_err;?></span>
                            
                            <div class="form-group">
                            <label>Select category</label>
                            <select name="category" class="form-control"> 
                                <option value="">Select Category</option>
                           <?php while($cats=mysqli_fetch_assoc($query)){ ?>
                   <option value="<?=$cats['id'] ?>"><?= $cats['categoryName'] ?> </option>
                     <?php  }?>   
                    </select>     
                        <span class="invalid-feedback"><?php echo $category_err;?></span>   
            </div>
                        </div> 
                      <div class="form-group">
                        Select image to upload:
                        <input type="file" name="image" id="fileToUpload" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">  
                       
                        </div>     
                      <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="retrieve_posts.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>        
        </div>
    </div>
</body>
</html>