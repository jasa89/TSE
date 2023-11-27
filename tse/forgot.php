<?php include 'header.php';?><!-- header osa php tiedostosta-->
<body>
<?php include 'topnav.php';?><!-- topnav osa php tiedostosta-->
  <div class="container">  <!-- forgot sivun sisältöcontaineri-->

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
<div class="center center-join">
    <h2>Reset your password</h2>     <!--Unoihtuiko salasana lomake -->
    <p>Enter email address to send password link</p>
   <form action="includes/reset-request.php" method="post" >
        <input type="text" name="email" placeholder="Enter your e-mail address...">
        <input type="submit" value="Submit" name="submit_email">
      </form>
<?php
if (isset($_GET["reset"])){
if($_GET["reset"]=="success"){
echo'<p class="signupsuccess">Check your e-mail!</p>';

}

}
   ?>
  </div>
</div>
 
 <div class="footer">
   
    <p>Footer</p>
</div>        
</div>
</body>
</html>


