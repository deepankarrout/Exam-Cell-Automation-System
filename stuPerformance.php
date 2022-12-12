<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
        ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Exam Cell | DRIEMS | Dashboard</title>
        <link rel="shortcut icon" type="image/png" href="images/logo.png">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen" >
        <link rel="stylesheet" href="css/icheck/skins/line/blue.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/red.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/green.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">
              <?php include('includes/f-topbar.php');?>
            <div class="content-wrapper">
                <div class="content-container">

                    <?php include('includes/f-leftbar.php');?>  

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-sm-6">
                                    <h2 class="title">Student Performance Sheet</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="fa fa-user"></i>Student Details</a></li>
                                        <li class="active">Student Performance Sheet</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                      
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <form action="" method="post">
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-2 control-label">Registration Number:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="regdno" placeholder="Search By Regd. No" autocomplete="off" name="regdno">
                                                        </div>
                                                    </div>
                                                </form><br><br>
                                            </div>
                                            <div class="panel-body p-20">
<?php 
$regdno = $_POST['regdno'];

$sql = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.internalmark, tblresult.marks, tblresult.grade from (((tblstudents  join  tblresult on tblresult.StudentId=tblstudents.StudentId)join tblsubjects on tblsubjects.id=tblresult.SubjectId)join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblsubjects.subtype='Theory' ";
$query = $dbh->prepare($sql);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
//$Name=$query->fetchAll()->fetchColumn();
//$regdno=$query->fetchColumn();
//print_r($results);
if($query->rowCount() > 0)
{
?>
                                            <table>
                                                <tr><td><b>NAME OF STUDENT :</b> <?php echo htmlentities($results[0][StudentName]);?></td>
                                                    <td rowspan="4" style="text-align: center"><img src="<?php echo htmlentities($results[0][profile]);?>" height="150px" width="120px"></td>
                                                </tr>
                                                <tr><td><b>REGISTRATION NO :</b> <?php echo htmlentities($results[0][RollId]);?></td></tr>
                                                <tr><td><b>SEMESTER :</b> <?php echo htmlentities($results[0][semname]);?> SEMESTER (Section- <?php echo htmlentities($results[0][Section]);?>)</td></tr>
                                                <tr><td><b>DOB             :</b> <?php echo htmlentities($results[0][DOB]);?></td></tr>
                                            </table>

                                            <!-- BACKLOG TABLE -->
                                                <table border="2px" class="gtable">
                                                    <tr>
                                                        <th colspan="10" style="text-align: center" bgcolor="#85e085">THEORY PAPERS</th>                                                       
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[0][SubjectName]);?></th> 
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[1][SubjectName]);?></th> 
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[2][SubjectName]);?></th>                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo htmlentities($results[0][internalmark]);?></td>
                                                        <td><?php if ($results[0][marks]>90)
                                                                    {
                                                                        $point = 10 * $results[0][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[0][marks]>80)
                                                                    {
                                                                        $point = 9 * $results[0][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[0][marks]>70)
                                                                    {
                                                                        $point = 8 * $results[0][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[0][marks]>60)
                                                                    {
                                                                        $point = 7 * $results[0][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[0][marks]>50)
                                                                    {
                                                                        $point = 6 * $results[0][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[0][marks]>=37)
                                                                    {
                                                                        $point = 5 * $results[0][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[0][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point = 2 * $results[0][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point = 0 * $results[0][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td><?php echo htmlentities($results[1][internalmark]);?></td>
                                                        <td><?php if ($results[1][marks]>90)
                                                                    {
                                                                        $point1 = 10 * $results[1][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[1][marks]>80)
                                                                    {
                                                                        $point1 = 9 * $results[1][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[1][marks]>70)
                                                                    {
                                                                        $point1 = 8 * $results[1][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[1][marks]>60)
                                                                    {
                                                                        $point1 = 7 * $results[1][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[1][marks]>50)
                                                                    {
                                                                        $point1 = 6 * $results[1][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[1][marks]>=37)
                                                                    {
                                                                        $point1 = 5 * $results[1][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[1][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point1 = 2 * $results[1][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point1 = 0 * $results[1][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td><?php echo htmlentities($results[2][internalmark]);?></td>
                                                        <td><?php if ($results[2][marks]>=90)
                                                                    {
                                                                        $point2 = 10 * $results[2][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[2][marks]>=80)
                                                                    {
                                                                        $point2 = 9 * $results[2][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[2][marks]>70)
                                                                    {
                                                                        $point2 = 8 * $results[2][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[2][marks]>60)
                                                                    {
                                                                        $point2 = 7 * $results[2][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[2][marks]>50)
                                                                    {
                                                                        $point2 = 6 * $results[2][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[2][marks]>=37)
                                                                    {
                                                                        $point2 = 5 * $results[2][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[2][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point2 = 2 * $results[2][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point2 = 0 * $results[2][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[3][SubjectName]);?></th> 
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[4][SubjectName]);?></th> 
                                                        <th colspan="3" style="text-align: center"><?php echo htmlentities($results[5][SubjectName]);?></th>                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>INTERNAL MARKS (50)</th>
                                                        <th>SEMESTER GRADE</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php if ($results[3][marks]>=90)
                                                                    {
                                                                        $point3 = 10 * $results[3][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[3][marks]>=80)
                                                                    {
                                                                        $point3 = 9 * $results[3][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[3][marks]>70)
                                                                    {
                                                                        $point3 = 8 * $results[3][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[3][marks]>60)
                                                                    {
                                                                        $point3 = 7 * $results[3][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[3][marks]>50)
                                                                    {
                                                                        $point3 = 6 * $results[3][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[3][marks]>=37)
                                                                    {
                                                                        $point3 = 5 * $results[3][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[3][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point3 = 2 * $results[3][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point3 = 0 * $results[3][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php if ($results[4][marks]>=90)
                                                                    {
                                                                        $point4 = 10 * $results[4][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[4][marks]>=80)
                                                                    {
                                                                        $point4 = 9 * $results[4][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[4][marks]>70)
                                                                    {
                                                                        $point4 = 8 * $results[4][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[4][marks]>60)
                                                                    {
                                                                        $point4 = 7 * $results[4][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[4][marks]>50)
                                                                    {
                                                                        $point4 = 6 * $results[4][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[4][marks]>=37)
                                                                    {
                                                                        $point4 = 5 * $results[4][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[4][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point4 = 2 * $results[4][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point4 = 0 * $results[4][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php if ($results[5][marks]>=91)
                                                                    {
                                                                        $point5 = 10 * $results[5][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($results[5][marks]>=81)
                                                                    {
                                                                        $point5 = 9 * $results[5][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($results[5][marks]>70)
                                                                    {
                                                                        $point5 = 8 * $results[5][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($results[5][marks]>60)
                                                                    {
                                                                        $point5 = 7 * $results[5][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($results[5][marks]>50)
                                                                    {
                                                                        $point5 = 6 * $results[5][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($results[5][marks]>=37)
                                                                    {
                                                                        $point5 = 5 * $results[5][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($results[5][marks]>0 && $results[5][marks]<37)
                                                                    {
                                                                        $point5 = 2 * $results[5][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point5 = 0 * $results[5][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="10"></th>                                                       
                                                    </tr>
<?php } ?>
<?php 
$regdno = $_POST['regdno'];
$sql1 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.internalmark, tblresult.marks, tblresult.grade from (((tblstudents  join  tblresult on tblresult.StudentId=tblstudents.StudentId)join tblsubjects on tblsubjects.id=tblresult.SubjectId)join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblsubjects.subtype='Practical' ";
$query1 = $dbh->prepare($sql1);
$query1->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query1->execute();
$result=$query1->fetchAll(PDO::FETCH_ASSOC);
//$Name=$query->fetchAll()->fetchColumn();
//$regdno=$query->fetchColumn();
//print_r($result);
if($query1->rowCount() > 0)
{
?>
                                                    <tr>
                                                        <th colspan="10" style="text-align: center" bgcolor="#85e085">SESSIONAL PAPERS</th>                                                       
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center"><?php echo htmlentities($result[0][SubjectName]);?></th> 
                                                        <th colspan="2" style="text-align: center"><?php echo htmlentities($result[1][SubjectName]);?></th> 
                                                        <th colspan="2" style="text-align: center"><?php echo htmlentities($result[2][SubjectName]);?></th>
                                                        <th colspan="2" style="text-align: center"><?php echo htmlentities($result[3][SubjectName]);?></th>
                                                        <th colspan="2" style="text-align: center"></th>                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>GRADE</th>
                                                        <th>ATTENDANCE %AGE</th>
                                                        <th>GRADE</th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php if ($result[0][marks]>=90)
                                                                    {
                                                                       $point6 = 10 * $result[0][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($result[0][marks]>=80)
                                                                    {
                                                                        $point6 = 9 * $result[0][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($result[0][marks]>70)
                                                                    {
                                                                        $point6 = 8 * $result[0][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($result[0][marks]>60)
                                                                    {
                                                                        $point6 = 7 * $result[0][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($result[0][marks]>50)
                                                                    {
                                                                        $point6 = 6 * $result[0][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($result[0][marks]>=37)
                                                                    {
                                                                        $point6 = 5 * $result[0][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($result[0][marks]>0 && $result[0][marks]<37)
                                                                    {
                                                                        $point6 = 2 * $result[0][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point6 = 0 * $result[0][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td><?php if ($result[1][marks]>=90)
                                                                    {
                                                                        $point9 = 10 * $result[1][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($result[1][marks]>=80)
                                                                    {
                                                                        $point9 = 9 * $result[1][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($result[1][marks]>70)
                                                                    {
                                                                        $point9 = 8 * $result[1][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($result[1][marks]>60)
                                                                    {
                                                                        $point9 = 7 * $result[1][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($result[1][marks]>50)
                                                                    {
                                                                        $point9 = 6 * $result[1][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($result[1][marks]>=37)
                                                                    {
                                                                        $point9 = 5 * $result[1][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($result[1][marks]>0 && $result[1][marks]<37)
                                                                    {
                                                                        $point9 = 2 * $result[1][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point9 = 0 * $result[1][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td><?php if ($result[2][marks]>=90)
                                                                    {
                                                                        $point7 = 10 * $result[2][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($result[2][marks]>=80)
                                                                    {
                                                                        $point7 = 9 * $result[2][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($result[2][marks]>70)
                                                                    {
                                                                        $point7 = 8 * $result[2][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($result[2][marks]>60)
                                                                    {
                                                                        $point7 = 7 * $result[2][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($result[2][marks]>50)
                                                                    {
                                                                        $point7 = 6 * $result[2][credits];
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($result[2][marks]>=37)
                                                                    {
                                                                        $point7 = 5 * $result[2][credits];
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($result[2][marks]>0 && $result[2][marks]<37)
                                                                    {
                                                                        $point7 = 2 * $result[2][credits];
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point7 = 0 * $result[2][credits];
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                        <td></td>
                                                        <td><?php if ($result[3][marks]>=90)
                                                                    {
                                                                        $point8 = 10 * $result[3][credits];
                                                                     echo htmlentities(O);
                                                                    }
                                                                    elseif($result[3][marks]>=80)
                                                                    {
                                                                        $point8 = 9 * $result[3][credits];
                                                                     echo htmlentities(E);
                                                                    }
                                                                    elseif($result[3][marks]>70)
                                                                    {
                                                                        $point8 = 8 * $result[3][credits];
                                                                     echo htmlentities(A);
                                                                    }
                                                                    elseif($result[3][marks]>60)
                                                                    {
                                                                        $point8 = 7 * $result[3][credits];
                                                                     echo htmlentities(B);
                                                                    }
                                                                    elseif($result[3][marks]>50)
                                                                    {
                                                                        $point8 = 6 * $result[3][credits];;
                                                                     echo htmlentities(C);
                                                                    }
                                                                    elseif($result[3][marks]>=37)
                                                                    {
                                                                        $point8 = 5 * $result[3][credits];;
                                                                     echo htmlentities(D);
                                                                    }
                                                                    elseif($result[3][marks]>0 && $result[3][marks]<37)
                                                                    {
                                                                        $point8 = 2 * $result[3][credits];;
                                                                     echo htmlentities(F);
                                                                    }
                                                                    else
                                                                    {
                                                                        $point8 = 0 * $result[3][credits];;
                                                                       echo htmlentities(); 
                                                                    }
                                                                    ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="10" style="text-align: center";>SGPA: <?php $sgpa = round(($point+$point1+$point2+$point3+$point4+$point5+$point6+$point9+$point7+$point8)/($results[0][credits]+$results[1][credits]+$results[2][credits]+$results[3][credits]+$results[4][credits]+$results[5][credits]+$result[0][credits]+$result[1][credits]+$result[2][credits]+$result[3][credits]),2);
                                                                        
                                                                                     echo htmlentities($sgpa);?></th>
                                                    </tr>
                                                </table>
<?php } elseif($results[0][RollId] != $regdno){ ?>
                                                <p><h1 style="color: red; text-align: center;">Record Not Found</h1></p>
<?php } ?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                    
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/waypoint/waypoints.min.js"></script>
        <script src="js/counterUp/jquery.counterup.min.js"></script>
        <script src="js/amcharts/amcharts.js"></script>
        <script src="js/amcharts/serial.js"></script>
        <script src="js/amcharts/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
        <script src="js/amcharts/themes/light.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/icheck/icheck.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script src="js/production-chart.js"></script>
        <script src="js/traffic-chart.js"></script>
        <script src="js/task-list.js"></script>
        <script>
            $(function(){

                // Counter for dashboard stats
                $('.counter').counterUp({
                    delay: 10,
                    time: 1000
                });

                // Welcome notification
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                //toastr["success"]( "Welcome to Faculties Dashoboard!");

            });
        </script>
        <script>//to avoid page resubmission by deeptiranjan & deepankar
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
<?php } ?>
