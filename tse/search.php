
<?php   // Include config file
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php";?>
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
<?php 
                    if(isset($_POST['search'])){ //Attempt select query execution to serach results//
                        $search = mysqli_real_escape_string($link, $_POST['search']);
                        
                        $sql = "SELECT * FROM posts WHERE heading LIKE '%$search%' OR post LIKE '%$search%'OR date LIKE '%$search%' OR category LIKE '%$search%' "; 
                        $result= mysqli_query($link, $sql);
                        $queryResult = mysqli_num_rows($result);
                        echo "<div class='row'>";
                        echo "<div class='card' id='postcard'><h2>"; 
                        echo"There are ".$queryResult." results";
                        echo "</div>";  
                        echo "</div>";
                        if($queryResult > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<div class='row'>";
                            echo " <div class='card' id='postcard'><h2>"; 
                            echo '<a  href="read.php?id='. $row['id']. '">'. $row['heading']. '</a>'; /* Otsikko jossa linkki otsikon osoittamaan postaukseen */  /* otsikko*/
                            echo "</h2>";   
                            echo "<h5>";
                            echo ($row['date']."<br><br>");/* päivämäärä jolloin postaus on päivitetty*/
                                echo "</h5>";  
                                echo "<p>";  
                                echo nl2br($row['post']."<br><br>");/* Postien rivivälit rivivälit*/
                                echo "</p>";  
                                echo "</div>";
                              echo "</div>";  
                        }
               
                        }
                        
                        } else {
                            echo "There are no results matching your search!";
                       
                        }
                    ?>
 </div>
 <?php include('sidebar.php'); ?> <!--include sidebar   -->
        <div class="footer"> 
  
</div>       
</div>
</body>
</html>