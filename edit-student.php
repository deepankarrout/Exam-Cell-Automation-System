<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$stid=intval($_GET['stid']);

if(isset($_POST['submit']))
{
$studentname=$_POST['fullanme'];
$academicyear=$_POST['ayear'];
$roolid=$_POST['rollid']; 
$studentemail=$_POST['emailid'];
$phoneno=$_POST['phone'];
$gender=$_POST['gender']; 
$seme=$_POST['seme'];
$dept=$_POST['dept'];
$dob=$_POST['dob'];
$lateral=$_POST['lateral'];
$status=$_POST['status'];

$profile=$_FILES['profile'];
$profilename=$profile['name'];
$profileerror=$profile['error'];
$profiletmp=$profile['tmp_name'];
$profileext = explode('.', $profilename);
$profilechk = strtolower(end($profileext));
$fileextstored = array('png', 'jpg', 'jpeg');

if(in_array($profilechk, $fileextstored)){
    $destinationfile = 'supload/'.$profilename;
    move_uploaded_file($profiletmp, $destinationfile);
}

$sql="update tblstudents set StudentName=:studentname,RollId=:roolid,StudentEmail=:studentemail,phoneno=:phoneno,Gender=:gender,ClassId=:seme,DOB=:dob,profile=:destinationfile,islateral=:lateral,Status=:status where StudentId=:stid ";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
//$query->bindParam(':academicyear',$academicyear,PDO::PARAM_STR);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':studentemail',$studentemail,PDO::PARAM_STR);
$query->bindParam(':phoneno',$phoneno,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':seme',$seme,PDO::PARAM_STR);
//$query->bindParam(':dept',$dept,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':destinationfile',$destinationfile,PDO::PARAM_STR);
$query->bindParam(':lateral',$lateral,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();

$msg="Student info updated successfully";
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DRIEMS | ADMIN </title>
        <link rel="shortcut icon" type="image/png" href="images/logo.png">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Information</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Student Information</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Update Student info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post"  action="#" enctype="multipart/form-data">
<?php 

$sql = "SELECT tblstudents.StudentName,tblstudents.academicyear,tblstudents.RollId,tblstudents.RegDate,tblstudents.StudentId,tblstudents.profile,tblstudents.Status,tblstudents.StudentEmail,tblstudents.phoneno,tblstudents.Gender,tblstudents.DOB,tblstudents.islateral,tblclasses.semname,tblclasses.Section,tbldepartment.deptname,tbldepartment.deptcode from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId join tbldepartment on tbldepartment.deptid=tblstudents.deptid where tblstudents.StudentId=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($result->StudentName)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Session</label>
<div class="col-sm-10">
<input type="text" name="ayear" class="form-control" id="ayear" value="<?php echo htmlentities($result->academicyear)?>" readonly>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Regd. No</label>
<div class="col-sm-10">
<input type="text" name="rollid" class="form-control" id="rollid" value="<?php echo htmlentities($result->RollId)?>" maxlength="5" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email id</label>
<div class="col-sm-10">
<input type="email" name="emailid" class="form-control" id="email" value="<?php echo htmlentities($result->StudentEmail)?>" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Phone No</label>
<div class="col-sm-10">
<input type="tel" name="phone" class="form-control" id="phone" value="<?php echo htmlentities($result->phoneno)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<?php  $gndr=$result->Gender;
if($gndr=="Male")
{
?>
<input type="radio" name="gender" value="Male" required="required" checked>Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Female")
{
?>
<input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required" checked>Female <input type="radio" name="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Other")
{
?>
<input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required" checked>Other
<?php }?>
</div>
</div>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Semester</label>
<div class="col-sm-10">
<input type="text" name="seme" class="form-control" id="seme" value="<?php echo htmlentities($result->semname)?> Seme (Sec-<?php echo htmlentities($result->Section)?>)" readonly>
</div>
</div>

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Department</label>
    <div class="col-sm-10">
<input type="text" name="dept" class="form-control" id="dept" value="<?php echo htmlentities($result->deptname)?>(<?php echo htmlentities($result->deptcode)?>)" readonly>
    </div>
</div>

<div class="form-group">
<label for="date" class="col-sm-2 control-label">DOB</label>
<div class="col-sm-10">
<input type="date"  name="dob" class="form-control" value="<?php echo htmlentities($result->DOB)?>" id="date">
</div>
</div>

<div class="form-group">
    <label for="file" class="col-sm-2 control-label">Photo</label>
    <div class="col-sm-10">
        <input type="file" name="profile" class="form-control" id="profile" value="<?php echo htmlentities($result->profile)?>">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Is Lateral</label>
<div class="col-sm-10">
<?php  $latrl=$result->islateral;
if($latrl=="1")
{
?>
<input type="radio" name="lateral" value="1" required="required" checked>Yes 
<input type="radio" name="lateral" value="0" required="required">No 
<?php }?>
<?php  
if($latrl=="0")
{
?>
<input type="radio" name="lateral" value="1" required="required" >Yes 
<input type="radio" name="lateral" value="0" required="required" checked>No 
<?php }?>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Reg Date: </label>
<div class="col-sm-10">
<?php echo htmlentities($result->RegDate)?>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Status</label>
<div class="col-sm-10">
<?php  $stats=$result->Status;
if($stats=="1")
{
?>
<input type="radio" name="status" value="1" required="required" checked>Active <input type="radio" name="status" value="0" required="required">Block 
<?php }?>
<?php  
if($stats=="0")
{
?>
<input type="radio" name="status" value="1" required="required" >Active <input type="radio" name="status" value="0" required="required" checked>Block 
<?php }?>



</div>
</div>

<?php }} ?>                                                    

                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
        <script>//to avoid page resubmission by deeptiranjan & deepankar
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
<?PHP } ?>
