<?php
session_start();
require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php";
$id = $_SESSION['id'];
/* Toiminta alkaa jos lomake lähetetään*/
if (isset($_POST['submit'])){
$file = $_FILES['file'];
/*tiedoston nimi, koko, tyyppi ja error muutujat*/

$fileName = $_FILES['file'] ['name'];
$fileTmpName = $_FILES['file'] ['tmp_name'];
$fileSize = $_FILES['file'] ['size'];
$fileError = $_FILES['file'] ['error'];
$fileType = $_FILES['file'] ['type'];

$fileExt = explode('.', $fileName);

$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg','jpeg','png');/* määrittää sallitut tiedostomuodot*/
if (in_array($fileActualExt, $allowed)){

if($fileError===0){
if ($fileSize < 1000000) { /* määrittää tiedoston maksimikoon */
$fileNameNew= "profile".$id.".".$fileActualExt;

$fileDestination = 'uploads/'.$fileNameNew ; /* valitaan latauskohde kansio kuvalle*/

move_uploaded_file($fileTmpName, $fileDestination );        /*siiretään tiedosto kansioon*/
$sql="UPDATE users SET image='$fileNameNew' WHERE id='$id';";   
  $result = mysqli_query($link, $sql);     

  header("Location: profile.php?uploadsuccess");
}else{
echo "Your file is too big";
}

}
else{
    echo "There was an error uploading your file!";
}
} else{
    echo "You cannot upload files of this type!";
}

}
?>  