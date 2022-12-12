<?php
session_start();
error_reporting(0);
include('includes/config.php');
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
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="content-wrapper">
                <div class="content-container">

         
                    <!-- /.left-sidebar -->

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-12">
                                    <h2 class="title" align="center">Exam Cell Automation System</h2>
                                </div>
                            </div>
                            <!-- /.row -->
                          
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section" id="exampl">
                            <div class="container-fluid">

                                <div class="row">
                              
                             

                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h3 align="center">DRIEMS<br>(An Autonomous Engineering College)</h3>
                                                    <h6 align="center"><b style="color: green">STUDENT RESULT SUMMARY</b></h6>
                                                    <hr />
<?php
// code Student Data
$rollid=$_POST['rollid'];
$classid=$_POST['class'];
$_SESSION['rollid']=$rollid;
$_SESSION['classid']=$classid;
$qery = "SELECT tblstudents.StudentName,tblstudents.RollId,tblstudents.RegDate,tblstudents.StudentId,tblstudents.profile,tblstudents.Status,tblclasses.semname,tblclasses.Section from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.RollId=:rollid and tblstudents.ClassId=:classid ";
$stmt = $dbh->prepare($qery);
$stmt->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$stmt->bindParam(':classid',$classid,PDO::PARAM_STR);
$stmt->execute();
$resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($stmt->rowCount() > 0)
{
foreach($resultss as $row)
{   ?>
<table>
    <tr><td><b>Student Name :</b> <?php echo htmlentities($row->StudentName);?></td>
        <td rowspan="4" style="text-align: center"><img src="<?php echo htmlentities($row->profile);?>" height="110px" width="90px"></td></tr>
    <tr><td><b>Student Roll Id :</b> <?php echo htmlentities($row->RollId);?></td></tr>
    <tr><td><b>Student Class :</b> <?php echo htmlentities($row->semname);?> SEMESTER (SECTION-<?php echo htmlentities($row->Section);?>)</td></tr>
</table>
<?php }

    ?>
                                            </div>
                                            <div class="panel-body p-20">







                                                <table class="table table-hover table-bordered" border="1" width="100%">
                                                <thead>
                                                        <tr style="text-align: center">
                                                            <th style="text-align: center">SN.</th>
                                                            <th style="text-align: center">Subject Code</th>
                                                            <th style="text-align: center">Subject</th>
                                                            <th style="text-align: center">T/P</th>
                                                            <!-- <th style="text-align: center">Marks</th>  -->
                                                            <th style="text-align: center">Credit</th>   
                                                            <th style="text-align: center">Grade</th>
                                                        </tr>
                                               </thead>
  


                                                	
                                                	<tbody>
<?php                                              
// Code for result

 $query ="select t.StudentName,t.RollId,t.ClassId,t.marks,t.grade,t.gpoint,tblsubjects.credits,CASE WHEN tblsubjects.subtype = 'Theory' THEN 'T' WHEN tblsubjects.subtype = 'Practical' THEN 'P' END as tp,tblsubjects.SubjectCode,tblsubjects.SubjectName from (select sts.StudentName,sts.RollId,sts.ClassId,tr.marks,CASE WHEN tr.marks >= 90 THEN 'O' WHEN tr.marks BETWEEN 80 AND 90 THEN 'E' WHEN tr.marks BETWEEN 70 AND 80 THEN 'A' WHEN tr.marks BETWEEN 60 AND 70 THEN 'B' WHEN tr.marks BETWEEN 50 AND 60 THEN 'C' WHEN tr.marks BETWEEN 37 AND 50 THEN 'D' WHEN tr.marks < 37 THEN 'F' ELSE 0 END as grade,CASE WHEN tr.marks >= 90 THEN 10 WHEN tr.marks BETWEEN 80 AND 90 THEN 9 WHEN tr.marks BETWEEN 70 AND 80 THEN 8 WHEN tr.marks BETWEEN 60 AND 70 THEN 7 WHEN tr.marks BETWEEN 50 AND 60 THEN 6 WHEN tr.marks BETWEEN 37 AND 50 THEN 5 WHEN tr.marks < 37 THEN 2 ELSE 0 END as gpoint,SubjectId from tblstudents as sts join tblresult as tr on tr.StudentId=sts.StudentId) as t join tblsubjects on tblsubjects.id=t.SubjectId where (t.RollId=:rollid and t.ClassId=:classid)";
$query= $dbh -> prepare($query);
$query->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query-> execute();  
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($countrow=$query->rowCount()>0)
{ 
foreach($results as $result){

    ?>

                                                		<tr>
<td scope="row" style="text-align: center"><?php echo htmlentities($cnt);?></td>
<td style="text-align: center"><?php echo htmlentities($result->SubjectCode);?></td>
<td style="text-align: center"><?php echo htmlentities($result->SubjectName);?></td>
<td style="text-align: center"><?php echo htmlentities($result->tp);?></td>
<!-- <td style="text-align: center"><?php echo htmlentities($totalmarks=$result->marks);?></td> -->
<td style="text-align: center"><?php echo htmlentities($totalcrdts=$result->credits);?></td>
<td style="text-align: center"><?php echo htmlentities($result->grade);?></td>
                                                		</tr>
<?php 
$totalcrdt+=$totalcrdts;
$crdtindx+=($result->gpoint * $result->credits);
$sgpa=round($crdtindx / $totalcrdt,2);
$totlcount+=$totalmarks;
$cnt++;}
?>
<!-- <tr>
<th scope="row" colspan="2" style="text-align: center">Total Marks</th>
<td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b> out of <b><?php echo htmlentities($outof=($cnt-1)*100); ?></b></td>
                                                        </tr> -->
<tr>
<th scope="row" colspan="4" style="text-align: center;font-size:12px;color: green">“Success is not final, failure is not fatal: it is the courage to continue that counts.”</th>
<td style="text-align: center"><b>Total Credit  :  <?php echo htmlentities($totalcrdt); ?></b></td>
<td style="text-align: center"><b>SGPA  :  <?php echo htmlentities($sgpa); ?></b></td>
                                                        </tr>
<!-- <tr>
<th scope="row" colspan="4" style="text-align: center">Percntage</th>           
<td colspan="2" style="text-align: center"><b><?php echo  htmlentities(($sgpa-0.50)*10); ?> %</b></td>
</tr> -->

 <?php } else { ?>     
<div class="alert alert-warning left-icon-alert" role="alert">
                                            <strong> Notice! </strong> Your result not declare yet !
 <?php }
?>
                                        </div>
 <?php 
 } else
 {?>

<div class="alert alert-danger left-icon-alert" role="alert">
<strong>Oh snap!</strong>
<?php
echo htmlentities("Invalid Roll Id");
 }
?>
                                        </div>



                                                	</tbody>
                                                </table>
<p style="font-size:10px;"><b>For any query : Please email at : driemsexamination@gmail.com</b><br>
1. The Result is Provisional.<br>
2. In case of any typological error or discrepancy, the student is  required to report at their respective  department for necessary   information to the principal.<br>
3. As Per the Provisional Grading System of the University/Autonomous,'M'   denotes MALPRACTICE 
(Grade Point 0)  and "S"  denotes ABSENT (Grade Point 0) and F Grade in (Int=Internal,Ext=External).<br>
4. The SGPA shown for the subjects displayed in the Page.<br>
5. (*) with grade in result indicates result after rechecking. <br><br>
<b>The Seven Point Grading System on Basis of 10 shall be followed in the university. Categorizaton of these as follows.</b>
<table  border="1px" style="font-size:10px;">
<tr><th>Score in 100 Percentage Point</th>
<th>>=90% & <=100%</th>
<th>>=80% & <=89%</th>
<th>>=70% & <=79%</th>
<th>>=60% & <=69%</th>
<th>>=50% & <=59%</th>
<th>>=35% & <=49%</th>
<th><35%</th></tr>
<tr><td>POINT</td>
<td>10</td>
<td>9</td>
<td>8</td>
<td>7</td>
<td>6</td>
<td>5</td>
<td>2</td></tr>
<tr><td>GRADE</td>
<td>"O"</td>
<td>"E"</td>
<td>"A"</td>
<td>"B"</td>
<td>"C"</td>
<td>"D"</td>
<td>"F"</td></tr>
</table>
&nbsp;&nbsp;&nbsp;<img src="images/examcontroller.jpg" height="80px" width="150px"><br>
<b>Controller of Examination</b><br>
<p style="color: red;font-size:13px;">Disclaimer :<br>
        1.       The results are Provisional and subject to change after post publication scrutinity by College.</p>
<p align="center"><i class="fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" OnClick="CallPrint(this.value)" ></i></p>
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                    <div class="form-group">
                                                           
                                                            <div class="col-sm-6">
                                                               <a href="find-result.php">Back to Home</a>
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
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {

            });


            function CallPrint(strid) {
var prtContent = document.getElementById("exampl");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
}
</script>

        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    </body>
</html>
