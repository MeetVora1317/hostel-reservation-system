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
    $sq = "SELECT *FROM hostel_manager WHERE Username = '$username'";
    $result = mysqli_query($conn, $sq);
    if($row = mysqli_fetch_assoc($result)){
      $pwdCheck = password_verify($password,$row['Pwd']);
      if($pwdCheck == false){
      //  header("Location: ../login-hostel_manager.php");
        header("Location: ../hostel_manager-login.php?error=wrongpwd");
        exit();
      }
      else if($pwdCheck == true) {
        session_start();
       $_SESSION['username']=$username;
          $_SESSION['hostel_man_id'] = $row['Hostel_man_id'];
        $_SESSION['fname'] = $row['Fname'];
        $_SESSION['lname'] = $row['Lname'];
        $_SESSION['mob_no'] = $row['Mob_no'];
       $_SESSION['username'] = $row['Username'];
        $_SESSION['hostel_id'] = $row['Hostel_id'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['isadmin'] = $row['Isadmin'];
        $_SESSION['PSWD'] = $row['Pwd'];

         header("Location: ../home_manager.php?login=success");
        
      }
      else {
        header("Location: ../");
        exit();
      }
    }
    else{
      header("Location: ../Hostel_manager-login.php?error=nouser");
      exit();
    }
  }

}
else {
  header("Location: ../");

  exit();
}
