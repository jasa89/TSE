<!DOCTYPE html>
<html lang="en">
<head>
<title>TSE</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="\tse\styles.css"> <!-- Erillinen stylesheet muotoiluun -->
<link rel="icon" type="image/x-icon" href="\tse\Logo v2.png"> <!-- Sivun yläosan logo kuvake joka näkyy välilehdessä -->
<script src="\tse\script.js"></script><!--Ulkoinen javascript tiedosto -->
</head>
<body>
  <div class="topnav" id="myTopnav"> <!-- Responsiivinen top nav -->
    <div class="logo"><a href="\tse\index.php" id="a-home"><img src="\tse\Logo v2.png" id="home" alt="TSE logo" width="40px" height="60px"></a> </div> 
     <a id="toplogin" href="\tse\login.php" target="_blank">Login</a>
   <a  id ="topmyprofile" href="\tse\profile.php" target="_blank">My profile</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
   <i onclick="my2Function(this)" class="fa fa-arrow-down"></i>  </a> <!--Topnavin avaus ja sulkemis painike nuolilla -->
   <a><div class="search-container">
      <form action="\tse\action_page.php">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>   
    </div></a>
  </div>
     
  <div class="container container-posts">  <!-- Posts sivun sisältöalue-->
    
<!-- The sidebar collapse avattava ja suljettava -->
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="\tse\index.php">Home</a>
  <a href="\tse\posts.php">Posts</a>
  <a href="\tse\privacy.php">Privacy policy</a>
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
  
  <?php
    /*kuukauden perusteella tehtävä kysely*/
    require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php";
    $sql = "SELECT * FROM posts WHERE date BETWEEN '2023-06-01 ' AND '2023-06-31 ' ORDER BY date DESC";
    $result = $link->query($sql);
    echo "<div class='row'>";
    echo "<div class='card' id='postcard'><h2>"; 
     // Date Format: Y/m/d
        echo "Month: "; 
           $date = date_create("2023-06-01");
      echo date_format($date,"F");
    echo "</div>";  
    echo "</div>";
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        if($row['published']==true){
        echo "<div class='row'>";
        echo "<div class='card' id='postcard'><h2>";    
      echo "<br><br>";  
        echo ($row['heading']."<br><br>"); /* otsikko*/
        echo "</h2>";   
        echo "<h5>";
        echo ($row['date']."<br><br>");/* päivämäärä jolloin postaus on päivitetty*/
            echo "</h5>";  
            echo "  <div class='fakeimg' style='height:200px;'>Image</div>";
          
            echo nl2br($row['abstract']."<br><br>");/* Postien rivivälit rivivälit*/
            echo "</div>"; 
          echo "</div>";  
   
      }}
    } else {
      echo "0 results";
    }
    ?>
 </div>
 <?php include('sidebar.php'); ?> <!--include sidebar   -->
        <div class="footer"> 
   
</div>       
      
</div>
</body>
</html>





