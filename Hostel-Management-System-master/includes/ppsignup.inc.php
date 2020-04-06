<?php

if (isset($_POST['hm_signup_submit'])) {

  require 'config.inc.php';
$roll = $_POST['roll_no'];
   $fname = $_POST['p_fname'];
  $lname = $_POST['p_lname'];
  $mobile = $_POST['mobile_no'];
//  $hostel_name = $_POST['hostel_name'];
  $email = $_POST['email'];
  $password = ($_POST['pwd']);
  $cnfpassword =($_POST['confirmpwd']);


  if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
    header("Location:?error=invalidusername");
    exit();
  }
  else if($password !== $cnfpassword){
    header("Location: ../admin/create_hm.php?error=passwordcheck");
    exit();
  }
  else {

    $sql = "SELECT parents FROM Hostel_Manager WHERE Username=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../admin/create_hm.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../admin/create_hm.php?error=userexists");
        exit();
      }
      else {
      //  $sql = "INSERT INTO Hostel_Manager (Student_id, Fname, Lname, Mob_no, Dept, Year_of_study, Pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
        //$sql = "INSERT INTO Hostel_Manager (Username, Fname, Lname, Mob_no, Hostel_id, Email, Pwd, Isadmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        //$stmt = mysqli_stmt_init($conn);

          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          $sql = "SELECT *FROM parent WHERE  parent_id = '$roll'";
          $result = mysqli_query($conn, $sql);
          if($row = mysqli_fetch_assoc($result)){
            $HostelID = $row[parents_id];
            $zz = 0;
            $sql = "INSERT INTO parent(parent_id,Fname,Lname, Mob_no,Email, Pwd) VALUES ('$roll', '$fname', '$lname', '$mobile', '$HostelID','$hashedPwd')";
          //  mysqli_stmt_bind_param($stmt, "ssssssss",'$username', $fname, $lname, $mobile, $HostelID, $email, $hashedPwd, $zz);
          //  mysqli_stmt_execute($stmt);
          $result = mysqli_query($conn, $sql);
          if($result){
            header("Location: ../admin/create_hm.php?added=success");
          }
          else {
            header("Location: ../admin/create_hm.php?added=failure");
          }

          //  exit();
          }
          else {
            header("Location: ../admin/create_hm.php?error=nohostel");
            exit();
          }


      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  header("Location: ../admin/create_hm.php");
  exit();
}
