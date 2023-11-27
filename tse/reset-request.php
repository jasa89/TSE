<?php

if(isset($_POST["reset-request-submit"])){

$selector =bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = "www.website.net/forgottenpwd/create-new-password.php?selector=" . $selector . "&validator" . bin2hex($token);

$expires = date("U") + 1800;

require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 

$userEmail = $POST["email"];

$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt, $sql)){
    echo"There was an error! ";
    exit();
}else{

mysqli_stmt_bind_param($stmt, "s", $userEmail);
mysqli_stmt_execute($stmt);
}

$sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires ) VALUES(?, ?, ?, ?);";

$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt, $sql)){
    echo"There was an error! ";
    exit();
}else{
$hashedToken = password_hash($token, PASSWORD_DEFAULT);
mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
mysqli_stmt_execute($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($link);

$to = $userEmail;

$subject = 'Reset your password for TSE';
$message= '<p> We recieved a password reset request. The link to reset your pssword is below. If you did not make this request you can ignore this email</p> <br> ';
$message .= '<p> Here is your password reset link: </p> <br> ';
$message .= '<a href="' . $url . '">' .$url . '</a></p>';

$headers = "From: TSE <totallysafe@gmail.com>\r\n";
$headers .= "Reply-To:  totallysafe@gmail.com\r\n";
$headers .= "Content-type: text/html\r\n";

mail($to, $subject, $message, $headers);

header("Location: /forgot.php?reset_success");

}else{

    header("Location:join.php");
}

?>

