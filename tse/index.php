<?php include 'header.php';?><!-- header osa php tiedostosta-->
<body>
<?php include 'topnav.php';?><!-- topnav osa php tiedostosta-->
     
  <div class="container">  <!-- Index sivun sisältöcontaineri-->
  
<!-- The sidebar collapse avattava ja suljettava -->
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</i></a>
  <a href="index.php">Home</a>
  <a href="posts.php">Posts</a>
  <a href="privacy.php">Privacy policy</a>
</div>
<div id="main">
  <button class="openbtn" onclick="openNav()">☰</button>  
</div>
<div class="container1"> <!-- Otsake containeri-->
<!-- Privacy policy banneri-->
<!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
<script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
document.addEventListener('DOMContentLoaded', function () {
cookieconsent.run({"notice_banner_type":"simple","consent_type":"express","palette":"light","language":"en","page_load_consent_levels":["strictly-necessary"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":false,"page_refresh_confirmation_buttons":false,"website_name":"TSE "});
});
</script>
<noscript>Cookie Consent by <a href="https://www.freeprivacypolicy.com/">Free Privacy Policy Generator</a></noscript>
<!-- End Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com  <a href="#" id="open_preferences_center">Update cookies preferences</a> -->

  <h1>TSE</h1>
<h2>Totally Safe electronics</h2> 
</div>
<div class="content" id="content"><!--Sisältöalue jossa blogin sisältölaatikot-->  
 <!--Blogin postaukset laatikoissa ja napit-->
  <?php
     $sql = "SELECT * FROM posts";// Attempt select query execution 
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){      
                          while($row = mysqli_fetch_array($result)){
                            if($row['published']==true){ 
                            echo "<div class='row'>";
                                  echo "<div class='center'>"; 
                                        echo "<h2>" . $row['heading'] . "</h2><br>";/*heading*/
                                        echo "<h4>" . $row['date'] . "</h4><br>";/*date*/
                                        echo "<p>"; 
                                        echo nl2br($row['abstract']."<br><br>");/* Postien rivivälit rivivälit INDEX sivulle postauksen tiivistelmä*/
                                        echo"</p>";
                                        echo ' <a href="read.php?id='. $row['id'] .'" class="button" title="View Post" data-toggle="tooltip">Read more...</a>'; /*Etusivun readmore, joka näyttää koko postauksen painettaessa*/   
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
                    // Close connection
                    mysqli_close($link); ?>
 <div>
</div>
</div>
 <div class="footer">
</div>       
</div>
</body>
</html>


