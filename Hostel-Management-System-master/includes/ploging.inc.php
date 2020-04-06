<?php

if (isset($_POST['login-submit'])) {

  require 'config.inc.php';

  $roll = $_POST['username'];
  $password = $_POST['pass'];

  if (empty($roll) || empty($password)) {
    header("Location:../ploging.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT *FROM parent WHERE parent_id = '$roll'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($result));
    if($row = mysqli_fetch_assoc($result)){
      $passCheck = password_verify($password, $row['Pwd']);
      if($passCheck == false){
        header("Location:../pparentloging.php?error=wrongpass");
        exit();
      }
      else if($passCheck == true) {

        session_start();
        $_SESSION['roll'] = $row['parent_id'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['mob_no'] = $row['Mob_no'];
  
        $_SESSION['email'] = $row['email'];
    

         header("Location: ../phome.php?login=success");
        
      }
      else {
        header("Location: ../");
        exit();
      }
    }
    else{
      header("Location:pparentloging.php?error=nouser");
      exit();
    }
  }

}
else {
  header("Location:ploging.php?error=nouser");

  exit();
}