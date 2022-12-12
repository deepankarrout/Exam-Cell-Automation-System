<?php
session_start();
error_reporting(0);
include('includes/config.php');
// $role_code=md5(rand());
// $_SESSION['role_code']=$role_code;

// if($_SESSION['user_type']!='')
// {
//   $_SESSION['user_type']='';
// }

if($_SESSION['alogin']!='')
{
  $_SESSION['alogin']='';
}
if(isset($_POST['login']))
{
  $uname=$_POST['username'];
  $password=$_POST['password'];
  $usertype=$_POST['usertype'];
  $sql = "SELECT * FROM admin WHERE UserName=:uname and Password=:password and usertype=:usertype";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
  $query-> bindParam(':password', $password, PDO::PARAM_STR);
  $query-> bindParam(':usertype', $usertype, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($results){
    if($usertype=="admin"){
      $_SESSION['alogin']= $uname;
      //$_SESSION['user_type']= $usertype;
      echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    }
    else{
      $_SESSION['alogin']= $uname;
      //$_SESSION['user_type']= $usertype;
      echo "<script type='text/javascript'> document.location = 'fdashboard.php'; </script>";
    }
  }
  else{
    echo "<script>alert('Invalid Details');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	 <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

<body>
  <div class = "container2">
    <Marquee direction="right" behavior="alternate" scrollamount='9' OnmouseOver=this.stop() OnmouseOut=this.start()>
      <font>EXAMINATION CELL, DRIEMS</font></Marquee>
  </div>
  <div class="container">
    <img src="images/logo.png">
    <form action="#" method="post">
      <div class="form_input">
        <input type="text" name="username" class="input" id="inputEmail3" placeholder="Enter Username" required>
      </div>
      <div class="form_input">
        <input type="password" name="password" id="inputPassword3" placeholder="Enter Password" required>
      </div>
      <div class="form_input">
        <select name="usertype" class="select" style="width:340px;" required>
          <option value="">Select User :</option>
          <option value="admin">Admin</option>
          <option value="faculty">Faculty</option>
        </select>
      </div>
      <input type="submit" name="login" value="Login" class="btn-login btn1">
    </form>
  </div>
</body>
</html>
