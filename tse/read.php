<?php
date_default_timezone_set('Europe/Helsinki'); /* asetetaan dafault aikavyöhyke*/
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
    // Prepare a select statement
    $sql = "SELECT * FROM posts WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        // Set parameters
        $param_id = trim($_GET["id"]);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                // Retrieve individual field value
                $heading = $row["heading"];
                $date = $row["date"];
                $post = $row["post"];
                $id=$row['id'];
              } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<?php include 'header.php';?><!-- header osa php tiedostosta-->
<body>
<?php include 'topnav.php';?><!-- topnav osa php tiedostosta-->
  
  <div class="container container-posts">  <!-- Posts sivun sisältöalue-->
  
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
<div class="container1 container1-posts"> <h1>TSE</h1> <!-- Container jonka sisällä otsake -->
<h2>Totally Safe electronics</h2> 
</div>
<div class="content-posts" id="content"> <!--Sisältöalue Posts sivulla oma muotoilu asettelu-->
 <div class="row"> <!-- Rivi jossa columnit on jaettu osiin-->
  <div class="leftcolumn"> <!-- Vasen columni jossa kortti jonka sisällä postaukset näkyvät-->
    <div class="card" id="postcard">
    <?php 
     if($row['published']==true){
   echo "<h2>"; 
    echo ($row['heading']."<br><br>"); /* otsikko*/
    echo "</h2>";   
    echo "<h5>";
    echo ($row['date']."");/* päivämäärä jolloin postaus on päivitetty*/
        echo "</h5>";  
        echo"<img src='admin/images/".$row['img']."' id='image'> <br><br>"; /* Tulostetaan postausten kuvat postauksiin*/
       
        echo nl2br($row['post']."<br><br>");/* Postien rivivälit */
         echo "</div>";
}  
  ?>
 <div class="card"> <!--Kommenttialue joka tulee kaikille sivuille -->
  <h2> Comments card</h2></a> 
  <div class="center-posts"><!--Blogin postaukset laatikoissa ja napit-->
 <?php include 'comments.php';?><!-- comments osa php tiedostosta-->
<?php include('sidebar.php'); ?> <!--include sidebar   -->
       
<div class="footer"> 
</div>                 
</div>
</body>
</html>



   