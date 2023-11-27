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
  <!-- Muista lisätä kaikille sivuille sidebarin osat-->
  <?php
       $category=$_GET['id']; // apumuuttuja jolla saadaan tulostettua kategoriat sivulle tai tyhjä sivu kun kategoriassa ei ole postauksia
       if(empty($category)){
          header("location:posts.php");
       }
       // Attempt select query execution  join categories display posts in selected category 
     $sql = "SELECT * FROM posts LEFT JOIN categories ON posts.category=categories.id WHERE categories.id='$category' ORDER BY date DESC";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                          
                                while($row = mysqli_fetch_array($result)){
                                if($row['published']==true){     
                                  echo "<div class='row'>";
                                  echo "<div class='card' id='postcard'>"; 
                                                                          
                                        echo "<h2>";
                                        echo "<h4>" . $row['heading'] . "</h4><br>";/*heading*/
                                       
                                        echo "</h2><br>";
                                        echo "<h4>" . $row['date'] . "</h4><br>";/*date*/
                                      
                                        echo"<img src='admin/images/".$row['img']."' id='image'> <br><br>"; /* Tulostetaan postausten kuvat postauksiin*/
                                     echo "<p>" ; 
                                        echo nl2br($row['post']."<br><br>");/* Postien rivivälit rivivälit*/
                                       echo"</p>";
                                        echo "<td>";
                                        echo "</td>";
                                    echo "</tr>";
                                    echo "</div>";  
                                   echo "</div>";  
                                  }  
                                 }
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
 </div>
  
 <?php include('sidebar.php'); ?> <!--include sidebar   -->
 
        <div class="footer"> 
   
</div>       
      
</div>
</body>
</html>


