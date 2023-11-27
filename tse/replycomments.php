<?php
date_default_timezone_set('Europe/Helsinki'); /* asetetaan dafault aikavyöhyke*/
include 'comments_inc.php';
?>
<?php include 'header.php';?><!-- header osa php tiedostosta-->
<body>
<?php include 'topnav.php';?><!-- topnav osa php tiedostosta-->
  <div class="container container-posts">  <!-- Posts sivun sisältöalue-->
    
<!-- The sidebar collapse avattava ja suljettava -->
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="index.html">Home</a>
  <a href="posts.html">Posts</a>
  <a href="privacy.html">Privacy policy</a>
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
    
 <div class="card"> <!--Kommenttialue joka tulee kaikille sivuille -->
  <a id="a-heading"href="post3.html"> <h2> Comments card</h2></a> 
  <div class="center-posts"><!--Blogin postaukset laatikoissa ja napit-->
<br>
<p> Edit a comment:</p><!--Kommenttien lähetys kantaan-->
<div class="form">  
<?php
  $cid = $_POST['comment_id'];
  $uid = $_POST['user_id'];
  $date = $_POST['date'];
  $message = $_POST['message'];
 echo "<form method='POST' action='".replyComments($link)."'>
 <input type='hidden' name='comment_id' value='".$cid."'> 
 <input type='hidden' name='user_id' value='".$uid."'>
  <input type='hidden' name='date' value='".$date."'>
  <textarea name='message'>".$message." </textarea>
   <button type='submit' name='commentSubmit'>Reply </button>
 </form>";
?>
</div>
</div>
</div>
</div>
<?php include('sidebar.php'); ?> <!--include sidebar   -->
  
        <div class="footer-posts"> 
    <p>Footer</p>
</div>           
</div>
</body>
</html> 