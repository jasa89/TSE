<div class="rightcolumn">
    <div class="card">
    <h2>Latest Posts</h2>
      <ul>
      <?php
                    // Attempt select query execution to fetch latest posts
     $sql = "SELECT * FROM posts ORDER BY date DESC limit 4";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                          
                                while($row = mysqli_fetch_array($result)){
                                if($row['published']==true){
                               
                                        echo "<p>";
                                        echo '<a id="a-side" href="/tse/read.php?id='. $row['id']. '">'. $row['heading']./* Otsikko jossa linkki otsikon osoittamaan postaukseen */
                                        '</a>';
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
     </ul>
    </div>
    <div class="card">
    <h2>Latest comments</h2> 
   <?php
                    // Attempt select query execution to fetch latest posts
     $sql = "SELECT * FROM comments ORDER BY date DESC limit 4";     
     if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                  $sentence = $row['message'];
                                  // Use trim() and explode() function to
                                  // get the first word of a comment string
                                  $arr = explode(' ', trim($sentence)); // otetaan uusimmista kommenteista näytettäväksi kaksi ensimmäistä sanaa ja listataan ne sidebariin
                                     echo "<p>";                    
                                  echo $arr[0]; echo" ";  echo $arr[1]; echo"..."; 
                                  echo "</p>";
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
     </ul>

    </div>
   
    <div class="card">
      <ul>
        <h2>Archives</h2> 
     
      <p><a  id="a-side" href="archives\april.php">April 2023</a></p>
        <p><a  id="a-side" href="archives\may.php">May 2023</a></p>
        <p><a  id="a-side" href="archives\june.php">June 2022</a></p>
        <p><a  id="a-side" href="archives\july.php">July 2022</a></p>
     </ul>
    </div>
    <div class="card">
      <h2>Categories</h2> 
    <?php    
    $select="SELECT * FROM categories";
    $query=mysqli_query($link,$select);
    
    ?>
      <ul> 
    <?php  while($cats=mysqli_fetch_assoc($query))  {?>
      <p> 
      <a  id="a-side" href="category.php?id=<?= $cats['id']?>
      ">  
      <?= $cats['categoryName']?></a>
    </p>
    <?php } mysqli_close($link);   // Close connection ?>
    </ul>
    </div>
  </div>
</div>