<?php include 'header.php';?><!-- header osa php tiedostosta-->

<body>
  
  <div class="container">  <!--  sivun sisältöcontaineri-->
   
<div class="center center-join">
<?php

$selector = $_GET["selector"];
$validator = $_GET["validator"];

if(empty($selector)|| empty($validator)) {
echo"Could not validate your request!";
}else{
if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
?>
<form action="reset-password.php" method="post">
<input type="hidden" name="selector" value="<?php echo $selector?>">
<input type="hidden" name="validator" value="<?php echo $validator?>">
<input type="password" name="pwd" placeholder="Enter a new password...">
<input type="password" name="pwd-repreat" placeholder="Repeat new password...">
<button type="submit" name="reset-password-submit">Reset password</button>
</form>
<?php
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


