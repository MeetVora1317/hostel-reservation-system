<?php

if (isset($_POST['signup-submit'])) {

  require 'config.inc.php';

  $parents_id = $_POST['student_roll_no'];
  $fname = $_POST['p_fname'];
  $lname = $_POST['p_lname'];
  $mobile = $_POST['mobile_no'];
  $email = $_POST['email'];
  
  $password = $_POST['pwd'];
  $cnfpassword = $_POST['confirmpwd'];



  if(!preg_match("/^[a-zA-Z0-9]*$/",$roll)){
    header("Location: ../p.signup.php?error=invalidroll");
    exit();
  }
  else if($password !== $cnfpassword){
    header("Location: ../p.signup.php?error=passwordcheck");
    exit();
  }
  else {

    $sql = "SELECT Student_id FROM Student WHERE Student_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../p.signup.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $roll);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../p.signup.php?error=userexists");
        exit();
      }
      else {
      
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {

          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          echo "$roll"."$fname";
            $sql = "INSERT INTO parents (parents_id, fname, lname,mob,email,pass) VALUES ('$roll','$fname','$lname','$mobile','$email','$hashedpwd')";

          $result = mysqli_query($conn, $sql);
          if($result){
            echo "sucess";
          }
         // else {
          //  header("Location: ../admin/create_hm.php?added=failure");
         // }
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  header("Location: ../signup.php");
  exit();
}
