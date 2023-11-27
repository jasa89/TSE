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
      <div class="center-posts"><!--Blogin postaukset laatikoissa ja napit-->
        <?php 
        $sql = "SELECT * FROM privacy";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            echo "<h2>"; 
            echo ($row['heading']."<br><br>"); /* otsikko*/
            echo "</h2>";   
            echo "<h5>";
        echo "Updated , ";    echo  ($row['date']."");/* päivämäärä jolloin postaus on päivitetty*/
                echo "</h5>";  
                echo nl2br($row['body']."<br><br>");/* Postien rivivälit */
          }
        } else {
          echo "0 results";
        }
        ?>
    </div>
 </div>
    </div>
    <?php include('sidebar.php'); ?> <!--include sidebar   -->
        <div class="footer"> 
   
</div>       
    
</div>
</body>
</html>