<?php
include 'C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php';
date_default_timezone_set('Europe/Helsinki'); /* asetetaan dafault aikavyöhyke*/

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adminpanel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/tse/styles.css"><!--Ulkoisen css tiedoston linkki -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
 <div class="container1 container1-posts"> <h1>TSE</h1> <!-- Container jonka sisällä otsake -->
<h2>Totally Safe electronics</h2> 

</div>  

<div class=" center">
<h4> Admin panel:</h4>
<br>    
 
 <form action="retrieve_posts.php" ><!-- Avaa ikkunan jossa voi tarkastella julkaistuja postauksia -->

    <button type="submit"> Posts details </button>
 </form>
 <br> 
 <form action="retrieve_categories.php" ><!-- Avaa ikkunan jossa voi tarkastella julkaistuja postauksia -->
      <button type="submit">Open post categories</button>
      </form>
      <br><br>
 <form action="retrieve_users.php" ><!--postausten julkaisuikkunan avaava painike -->

         <button type="submit">Users list </button>
      </form>
      <br><br>
    
      <form action="retrieve_comments.php" ><!-- Avaa ikkunan jossa voi tarkastella julkaistuja postauksia -->
<button type="submit"> Comment details </button>
</form>
<br><br><br>
      <a href="logout.php" class="btn btn-primary ml-3">Log out from adminpanel</a>   <!--Kirjaudu ulos admin paneelista painike -->
<br>
<br><br><br><br>
   </div>
</body>
</html>




