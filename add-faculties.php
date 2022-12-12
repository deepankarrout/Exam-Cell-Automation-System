<?php
session_start();
error_reporting(0);
include('includes/check.php');
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
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
$status=1;

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

$sql="INSERT INTO tblfaculties(e_name, username, e_type, e_id, e_email, e_contact, gender, dept, dob, profile, status) VALUES(:facultyname,:username,:designation,:empid,:femail,:fcontact,:fgender,:dept,:fdob,:destinationfile,:status); INSERT INTO admin(UserName, displayname, Password, usertype) VALUES(:username,:facultyname, 1234,'faculty');";
$query = $dbh->prepare($sql);
$query->bindParam(':facultyname',$facultyname,PDO::PARAM_STR);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':designation',$designation,PDO::PARAM_STR);
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':femail',$femail,PDO::PARAM_STR);
$query->bindParam(':fcontact',$fcontact,PDO::PARAM_STR);
$query->bindParam(':fgender',$fgender,PDO::PARAM_STR);
$query->bindParam(':dept',$dept,PDO::PARAM_STR);
$query->bindParam(':fdob',$fdob,PDO::PARAM_STR);
$query->bindParam(':destinationfile',$destinationfile,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Student info added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

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
                                    <h2 class="title">Faculties Registration</h2>
                                </div>
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></l>
                                        <li class="active">Faculties Registration</li>
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
                                            <h5>Fill the Faculties info</h5>
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
                                    <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Full Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="fullanme" class="form-control" id="fullanme" required="required" autocomplete="off">
                                            </div>
                                            <label for="default" class="col-sm-2 control-label">User Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="username" class="form-control" id="username" required="required" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Designation</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="designation" class="form-control" id="designation" required="required" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Teacher Id</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="empid" class="form-control" id="empid" maxlength="" required="required" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Email id</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="emailid" class="form-control" id="emailid" required="required" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Phone No</label>
                                            <div class="col-sm-10">
                                                <input type="tel" name="phone" class="form-control" id="phone" maxlength='10' required="required" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Gender</label>
                                            <div class="col-sm-10">
                                                <input type="radio" name="gender" id="gender" value="Male" required="required" checked="">Male 
                                                <input type="radio" name="gender" id="gender" value="Female" required="required">Female 
                                                <input type="radio" name="gender" id="gender" value="Other" required="required">Other
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="default" class="col-sm-2 control-label">Department</label>
                                            <div class="col-sm-10">
                                                <select name="dept" class="form-control" id="dept" required="required">
                                                    <option value="">Select Department</option>
<?php $sql = "SELECT * from tbldepartment";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                    <option value="<?php echo htmlentities($result->deptid); ?>"><?php echo htmlentities($result->deptname); ?>&nbsp; (<?php echo htmlentities($result->deptcode); ?>)</option>
<?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label">DOB</label>
                                                <div class="col-sm-10">
                                                    <input type="date"  name="dob" class="form-control" id="dob">
                                                </div>
                                            </div>
                                                                                                
                                            <div class="form-group">
                                                <label for="file" class="col-sm-2 control-label">Photo</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="profile" class="form-control" id="profile" required="required">
                                                </div>
                                            </div>
                                                    
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
