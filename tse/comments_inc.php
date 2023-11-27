<?php
/* Funktio jota kutsumalla saadaan kommentit lähetettyä tietokantaan*/ 
function setComments($link){   
    if(isset($_POST['commentSubmit'])){
        $uid = $_SESSION['id'];
         $pid = $_POST['pid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
   if($message!=""){
    $sql = "INSERT INTO comments (user_id, post_id, date, message) VALUES ('$uid','$pid', '$date', '$message')";
$result = $link->query($sql);
header("Location:posts.php?message sent successfully");   
}
} 
}
/* Funktio jota kutsumalla saadaan kommentit näkymään verkkosivulla sivukohtaisesti*/ 
function getComments($link){ 
   // SELECT from comments johon tulee read sivun id jotta saadaan kommentit yksittäisille sivuille//
   $id=$_GET['id'];
   $sql="SELECT * FROM comments WHERE post_id='$id' " ;    
    // proceed only if a query is executed
    if($result = $link->query($sql)){
        while ($row = $result->fetch_assoc()) {
            $id_user=$row['user_id'];
            $sql2="SELECT * FROM users WHERE id='$id_user'"; /* toinen sql kysely joka vertaa käyttäjä id:t ja läehettää sivulle kommentin kirjoittajan käyttäjänimen*/

            if($result2 = $link->query($sql2)){  
                while ($row2 = $result2->fetch_assoc()) {
            echo "<div class='comment-container'>";
        echo "<div class='comment-card'><p>"; 
       echo" <img src='uploads/".$row2['image']."' id=' ' height='100px' width='80px'class='avatar' >  "; /* Tulostetaan käyttäjien avatarit kommenttikortteihin*/
        echo ($row2['username']."<br><br>");
            echo ($row['date']."<br><br>");
            echo nl2br($row['message']."<br><br>");/* Kommenttien rivivälit*/
            echo "</div>";
           echo "</p>"; 
           if(isset($_SESSION['id'])){

                if ($_SESSION['id']==$row2['id']){
                    echo" <form class ='delete-form' method='POST' action='".deleteComments($link)."'>
                        <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
                       
                        <button type='submit' name='commentDelete'>Delete</button>
                    </form>
                    <form class ='edit-form' method='POST' action='editcomment.php'>
                        <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
                        <input type='hidden' name='user_id' value='".$row['user_id']."'>
                        <input type='hidden' name='date' value='".$row['date']."'>
                        <input type='hidden' name='message' value='".$row['message']."'>
                        <button>Edit</button>
                    </form>";
                }
            }
             
           echo " </div>";
        }
    }     
}

} 
}
      /* Funktio jolla voidaan muokata tiettyä kommenttia*/   
  function editComments($link){  
    if(isset($_POST['commentSubmit'])){
        $comment_id = $_POST['comment_id'];
        $uid = $_POST['user_id'];
        $date = $_POST['date'];
        $message = $_POST['message'];
    $sql = "UPDATE comments SET message='$message' WHERE comment_id='$comment_id'";
$result = $link->query($sql);
header("Location:index.php");   
} 
}
/* Funktio jolla voidaan poistaa tietty kommentti*/
function deleteComments($link){
        if(isset($_POST['commentDelete'])){
            $comment_id = $_POST['comment_id'];
        $sql = "DELETE FROM comments WHERE comment_id ='$comment_id'";
    $result = $link->query($sql);
    } 
}
?>