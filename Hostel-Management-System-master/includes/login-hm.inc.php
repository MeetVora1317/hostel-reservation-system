<?php

if (isset($_POST['login-submit'])) {

  require 'config.inc.php';

  $username = $_POST['username'];
  $password = $_POST['pwd'];

  if (empty($username) || empty($password)) {
    header("Location: ../login-hostel_manager.php?error=emptyfields");
    exit();
  }
  else {
    $sq = "SELECT *FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $sq);
    if($row = mysqli_fetch_assoc($result)){
      $pwdCheck = password_verify($password,$row['password']);
      if($pwdCheck == false){
      //  header("Location: ../login-hostel_manager.php");
        header("Location: ../login-hostel_manager.php?error=wrongpwd");
        exit();
      }
      else if($pwdCheck == true) {
        session_start();
        $_SESSION['username']=$username;
                  
         header("Location: ../admin/admin_home.php?login=success");
        
      }
      else {
        header("Location: ../");
        exit();
      }
    }
    else{
      header("Location: ../login-hostel_manager.php?error=nouser");
      exit();
    }
  }

}
else {
  header("Location: ../");

  exit();
}
?>