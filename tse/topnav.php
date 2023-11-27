
<div class="topnav" id="myTopnav"> <!-- Responsiivinen top nav  uusi-->
    <div class="logo"><a href="index.php" id="a-home"><img src="Logo v2.png" id="home" alt="TSE logo" width="40px" height="60px"></a> </div> <!-- logo jossa linkki etusivulle -->
    <?php
// tarkastetaan onko käyttäjä kirjautunut sisään, jos on painike on logout painike
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
 echo" <a id='toplogin' href='login.php' target='_blank'>Login</a>";
 } else{
    echo" <a id='toplogin' href='logout.php'>Logout</a>";
  }  
?>
    <a  id ="topmyprofile" href="profile.php" target="_blank">My profile</a> <!--My profile linkki profiiliin  -->
    <a id="arrow" href="javascript:void(0);" class="icon" onclick="myFunction()"> <!--navbarin responsiivinen toiminto linkki ja nuolen suunnan vaihto funktio  -->
      <i onclick="my2Function(this)" class="fa fa-arrow-down"></i>
    </a> 
    <a> <div class="search-container">
      <form action="search.php "method="post">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>   
    </div></a>
  </div> 
  
  
  
 