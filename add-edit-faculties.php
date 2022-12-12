<?php
$tab = isset($_REQUEST['tab'])!=''?$_REQUEST['tab']:'';
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
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script>
        function navigate(){
            window.location.href="downloadUploadStudents.php";
        }
        $(document).ready(function(){  
            $('#fileUpload').change(function(){  
                $('#excelForm').submit();  
            });  
            $('#excelForm').on('submit', function(event){  
                event.preventDefault();  
                $.ajax({  
                    url:"excel_upload_faculty_data.php",
                    method:"POST",  
                    data:new FormData(this),  
                    contentType:false,  
                    processData:false,  
                    success:function(data){  
                         $('#divStudentSectionData').html(data);  
                         $('#fileUpload').val('');  
                    }  
                });  
            });  
        });  
    </script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
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
                                    <h2 class="title" style="color: #00004d;font-size: 30px;">Faculties Registration</h2>
                                </div>
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
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
                                        <!-- Main content -->
                                        <section class="content">
                                            <!-- Small boxes (Stat box) -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <li class="<?php echo $tab=='' ? 'active' :'' ;?>"><a href="#tabAddFaculties" data-toggle="tab">ADD</a></li>
                                                            <li class="<?php echo $tab=='upload' ? 'active' :'' ;?>"><a href="#tabUploadFaculties" data-toggle="tab">UPLOAD</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <!--ADD STUDENT START--> 
                                                            <div class="tab-pane <?php echo $tab=='' ? 'active' :'' ;?>" id="tabAddFaculties">
                                                                <form name="frmHostelDetail" id="frmHostelDetail" method="POST" action="">                                                                                      
                                                                    <div class="panel panel-primary">
                                                                        <div class="panel-heading" style="text-align: center;color: white;font-size: 16px;font-weight: 600;">Faculties Record</div>
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    </h2><button type="button" class="btn btn-primary" id="" name="" data-toggle="modal" data-target="#AddFacultyModal"><i class="fa fa-fw fa-plus"></i> ADD FACULTY</button>
                                                                                </div>
                                                                                
                                                                            </div></br>
                                                                            <div class="row">
                                                                                <div class="col-lg-12">                                     
                                                                                    <table id="dtblFaculty" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Name</th>
                                                                                                <th>Teacher Id</th>
                                                                                                <th>Department</th>
                                                                                                <th>Contact No</th>
                                                                                                <th>Profile</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
<?php $sql = "SELECT tblfaculties.id,tblfaculties.e_name,tblfaculties.e_id,tblfaculties.dept,tblfaculties.e_contact,tblfaculties.profile,tblfaculties.status,tbldepartment.deptname,tbldepartment.deptcode from tblfaculties join tbldepartment on tbldepartment.deptid=tblfaculties.dept";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                                                            <tr>
                                                                                                <td><?php echo htmlentities($cnt);?></td>
                                                                                                <td><?php echo htmlentities($result->e_name);?></td>
                                                                                                <td><?php echo htmlentities($result->e_id);?></td>
                                                                                                <td><?php echo htmlentities($result->deptname);?>(<?php echo htmlentities($result->deptcode);?>)</td>
                                                                                                <td><?php echo htmlentities($result->e_contact);?></td>
                                                                                                <td><img src="<?php echo htmlentities($result->profile);?>" height="30px" width="30px"></td>
                                                                                                <td><?php if($result->status==1)
                                                                                                {
                                                                                                    echo htmlentities('Active');
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    echo htmlentities('Blocked'); 
                                                                                                }
                                                                                                ?></td>
                                                                                                <td>
                                                                                                    <a href="edit-faculties.php?fid=<?php echo htmlentities($result->id);?>"><i class="fa fa-edit" title="Edit Record"></i> </a> 
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php $cnt=$cnt+1;}} ?>
                                                                                        </tbody>                                                                                                        
                                                                                    </table>
                                                                                </div>
                                                                            </div>                                              
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <!--ADD/EDIT MODAL FORM START-->                                    
                                                                <div class="modal fade" id="AddFacultyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop = "static">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="text-align: center;color: white;font-size: 16px;font-weight: 600;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                                &times;
                                                                            </button>
                                                                            <h4 class="modal-title" id="myModalLabel"><span id="lblAddFacultyModal"> </span> ADD FACULTY </h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row setup-content" id="step-2">
                                                                                <div class="col-xs-12 ">
                                                                                    <div class="col-md-12">
                                                                                        <form class="form-horizontal" method="post" role="form" id="frmAddFacultyModal" action="#" enctype="multipart/form-data">
                                                                                            <div class="form-group" hidden="">
                                                                                                <label class="col-sm-3 control-label">HIDE code</label> 
                                                                                                <div class="col-sm-9">
                                                                                                    <input type="text" class="form-control" id="hidhosteltypeid" name="hidhosteltypeid">
                                                                                                </div>
                                                                                            </div>

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

                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-close"></i>&nbsp;Close</button> 
                                                                                                <button type="submit" name="submit" class="btn btn-primary" id="addStudent"><i class="fa fa-fw fa-save"></i>&nbsp;Save</button>             
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--ADD/EDIT MODAL FORM END-->
                                                            </div>  
                                                            <!--ADD STUDENT END-->                      

                                                            <!--EXCEL UOLOAD START-->
                                                            <div class="tab-pane <?php echo $tab=='upload' ? 'active' :'' ;?>" id="tabUploadFaculties">                                        
                                                                <div class="panel panel-primary">
                                                                    <div class="panel-heading" style="text-align: center;color: white;font-size: 16px;font-weight: 600;">Excel Upload</div>
                                                                    <div class="panel-body"> 
                                                                        <div class="box-body">
                                                                            <form method="post" action="" class="form-horizontal" id="excelForm" name="excelForm" role="form" enctype="multipart/form-data" >   
                                                                                <div class="row" style="background-color: #FFF;padding: 10px;margin-top: -15px;">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="col-lg-12">
                                                                                            <fieldset style="width:100%;margin-top:7px;">
                                                                                                <legend style="margin-bottom:12px;color: #C52929;font-size: 17px;">Browse Excel To Upload Data</legend>                     
                                                                                                Step 1. Download:  <button type="button" class="btn btn-primary btn-xs custombtn" onclick = "navigate();">Template</button><br>                                                     
                                                                                                Step 2. Fill the data in the downloaded excel file.<br />
                                                                                                Step 3. Browse and upload. 
                                                                                                <div class="form-group" style="padding-top: 5px;">
                                                                                                    <div class="col-sm-5">
                                                                                                        <input type="file" id="fileUpload" name="fileUpload" class="form-control"/>
                                                                                                    </div>
                                                                                                    
                                                                                                    <!-- <div class="col-sm-2">
                                                                                                        <input type="button" id="btnUploadData" name="btnUploadData" value="Upload" onclick="" style="display: inline" class="btn btn-primary custombtn"/>
                                                                                                    </div> -->
                                                                                                    <!-- <div class="col-sm-2" id="divUpload">
                                                                                                        <input type="button" id="btnUploadData" name="btnUploadData" value="Upload" onclick="" style="display: inline" class="btn btn-primary custombtn"/> -->
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>
                                                                                        <div class="row"> 
                                                                                            <div class="col-lg-12" id="divStudentSectionData">
                                                                                                
                                                                                            </div>
                                                                                        </div>                                                      
                                                                                    </div>                                              
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>                                       
                                                            </div>
                                                            <!--EXCEL UOLOAD END-->          
                                                        </div>
                                                    </div>
                                                </div><!-- /.col (main col) -->
                                            </div><!-- /.row (main row) -->
                                        </section><!-- /.content -->
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
        <script src="js/DataTables/datatables.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#dtblFaculty').DataTable();

                $('#dtblFaculty2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );
                $('#dtblFaculty3').DataTable();
                
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
