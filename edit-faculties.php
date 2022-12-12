<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$fid=intval($_GET['fid']);

if(isset($_POST['submit']))
{
$facultyname=$_POST['fullanme'];
$username=$_POST['username'];
$designation=$_POST['designation'];
$empid=$_POST['empid']; 
$femail=$_POST['emailid'];
$fcontact=$_POST['phone'];
$fgender=$_POST['gender']; 
$dept=$_POST['dept']; 
$fdob=$_POST['dob'];
$status=$_POST['status'];

$profile=$_FILES['profile'];
$profilename=$profile['name'];
$profileerror=$profile['error'];
$profiletmp=$profile['tmp_name'];
$profileext = explode('.', $profilename);
$profilechk = strtolower(end($profileext));
$fileextstored = array('png', 'jpg', 'jpeg');

if(in_array($profilechk, $fileextstored)){
    $destinationfile = 'upload/'.$profilename;
    move_uploaded_file($profiletmp, $destinationfile);
}

$sql="UPDATE tblfaculties SET e_id=:empid,e_type=:designation,username=:username,e_name=:facultyname,e_email=:femail,e_contact=:fcontact,gender=:fgender,dob=:fdob,profile=:destinationfile,status=:status WHERE id=:fid ";
$query = $dbh->prepare($sql);
$query->bindParam(':facultyname',$facultyname,PDO::PARAM_STR);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':designation',$designation,PDO::PARAM_STR);
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':femail',$femail,PDO::PARAM_STR);
$query->bindParam(':fcontact',$fcontact,PDO::PARAM_STR);
$query->bindParam(':fgender',$fgender,PDO::PARAM_STR);
//$query->bindParam(':dept',$dept,PDO::PARAM_STR);
$query->bindParam(':fdob',$fdob,PDO::PARAM_STR);
$query->bindParam(':destinationfile',$destinationfile,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':fid',$fid,PDO::PARAM_STR);
$query->execute();

$msg="Faculty details updated successfully";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DRIEMS| ADMIN </title>
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
                                    <h2 class="title">Faculties Registration</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Faculty Details</li>
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
                                                    <h5>Fill the Faculty info</h5>
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
<form class="form-horizontal" method="post" enctype="multipart/form-data">

<?php 

$sql = "SELECT tblfaculties.e_id,tblfaculties.e_type,tblfaculties.username,tblfaculties.e_name,tblfaculties.e_email,tblfaculties.e_contact,tblfaculties.gender,tblfaculties.dob,tblfaculties.dept,tblfaculties.profile,tblfaculties.status,tbldepartment.deptname,tbldepartment.deptcode from tblfaculties join tbldepartment on tbldepartment.deptid=tblfaculties.dept where tblfaculties.id=:fid";
$query = $dbh->prepare($sql);
$query->bindParam(':fid',$fid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Full Name</label>
    <div class="col-sm-4">
        <input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($result->e_name)?>" required="required" autocomplete="off">
    </div>
    <label for="default" class="col-sm-2 control-label">User Name</label>
    <div class="col-sm-4">
        <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlentities($result->username)?>" required="required" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Designation</label>
    <div class="col-sm-10">
        <input type="text" name="designation" class="form-control" id="designation" value="<?php echo htmlentities($result->e_type)?>" required="required" autocomplete="off">
    </div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Teacher Id</label>
<div class="col-sm-10">
    <input type="text" name="empid" class="form-control" id="empid" maxlength="" value="<?php echo htmlentities($result->e_id)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email id</label>
<div class="col-sm-10">
    <input type="email" name="emailid" class="form-control" id="emailid" value="<?php echo htmlentities($result->e_email)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Phone No</label>
<div class="col-sm-10">
    <input type="tel" name="phone" class="form-control" id="phone" maxlength='10' value="<?php echo htmlentities($result->e_contact)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<?php  $gndr=$result->gender;
if($gndr=="Male")
{
?>
<input type="radio" name="gender" id="gender" value="Male" required="required" checked>Male 
<input type="radio" name="gender" id="gender" value="Female" required="required">Female 
<input type="radio" name="gender" id="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Female")
{
?>
<input type="radio" name="gender" id="gender" value="Male" required="required" >Male 
<input type="radio" name="gender" id="gender" value="Female" required="required" checked>Female 
<input type="radio" name="gender" id="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Other")
{
?>
<input type="radio" name="gender" id="gender" value="Male" required="required" >Male 
<input type="radio" name="gender" id="gender" value="Female" required="required">Female 
<input type="radio" name="gender" id="gender" value="Other" required="required" checked>Other
<?php }?>
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
        <input type="date"  name="dob" class="form-control" id="dob" value="<?php echo htmlentities($result->dob)?>">
    </div>
</div>
                                                    
<div class="form-group">
    <label for="file" class="col-sm-2 control-label">Photo</label>
    <div class="col-sm-10">
        <input type="file" name="profile" class="form-control" id="profile" value="<?php echo htmlentities($result->profile)?>">
    </div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Status</label>
<div class="col-sm-10">
<?php  $stats=$result->status;
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
                                                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
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
