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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                                    <h2 class="title">SGPA Growth</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="fa fa-user"></i>Student Details</a></li>
                                        <li class="active">SGPA Growth</li>
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
$sql3 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END   * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=3 ";
$query = $dbh->prepare($sql3);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results3=$query->fetchAll(PDO::FETCH_ASSOC);

$sql4 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END   * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=4 ";
$query = $dbh->prepare($sql4);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results4=$query->fetchAll(PDO::FETCH_ASSOC);

$sql5 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END   * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=5 ";
$query = $dbh->prepare($sql5);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results5=$query->fetchAll(PDO::FETCH_ASSOC);

$sql6 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END   * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=6 ";
$query = $dbh->prepare($sql6);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results6=$query->fetchAll(PDO::FETCH_ASSOC);

$sql7 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END   * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=7 ";
$query = $dbh->prepare($sql7);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results7=$query->fetchAll(PDO::FETCH_ASSOC);

$sql8 = "SELECT DISTINCT tblstudents.StudentName, tblstudents.RollId, tblstudents.DOB, tblstudents.profile, tblclasses.semname, tblclasses.Section, tblsubjects.SubjectName, tblsubjects.credits, tblresult.marks, tblresult.grade, tblstudents.StudentId, SUM( IF( tblresult.marks <37, 1, 0 ) ) AS backlog, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END  * tblsubjects.credits) / SUM(tblsubjects.credits)) AS SGPA FROM  (((tblstudents  inner join  tblresult on tblresult.StudentId=tblstudents.StudentId)inner join tblsubjects on tblsubjects.id=tblresult.SubjectId)inner join tblclasses on tblclasses.id=tblresult.ClassId) where tblstudents.RollId=:regdno AND tblresult.semid=8 ";
$query = $dbh->prepare($sql8);
$query->bindParam(':regdno',$regdno,PDO::PARAM_STR);
$query->execute();
$results8=$query->fetchAll(PDO::FETCH_ASSOC);
//print_r($results3);
if($results3[0][StudentName] =='')
{ ?>
                                        <p><h3 style=" text-align: center;">Enter a valid registration no.</h3></p>
<?php } else
{   ?>
                                        <table>
                                            <tr><td><b>NAME OF STUDENT :</b> <?php echo htmlentities($results3[0][StudentName]);?></td>
                                                <td rowspan="4" style="text-align: center"><img src="<?php echo htmlentities($results3[0][profile]);?>" height="110px" width="100px"></td>
                                            </tr>
                                            <tr><td><b>REGISTRATION NO :</b> <?php echo htmlentities($results3[0][RollId]);?></td></tr>
                                            <tr><td><b>SEMESTER :</b> <?php echo htmlentities($results3[0][semname]);?> SEMESTER (Section- <?php echo htmlentities($results3[0][Section]);?>)</td></tr>
                                            <tr><td><b>DOB             :</b> <?php echo htmlentities($results3[0][DOB]);?></td></tr>
                                        </table>
                                                
                                        <!-- BACKLOG TABLE -->
                                        <table border="2px" class="gtable">
                                            <tr>
                                                <th>SEMESTER</th>
                                                <th>1st</th>
                                                <th>2nd</th>
                                                <th>3rd</th>
                                                <th>4th</th>
                                                <th>5th</th>
                                                <th>6th</th>
                                                <th>7th</th>
                                                <th>8th</th>

                                            </tr>
                                            <tr>
                                                <th>SGPA</th>
                                                <td><?php echo htmlentities(round($results1[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results2[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results3[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results4[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results5[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results6[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results7[0][SGPA],2));?></td>
                                                <td><?php echo htmlentities(round($results8[0][SGPA],2));?></td>
                                            </tr>
                                            <tr>
                                                <th>NO. OF BACKLOG</th>
                                                <td><?php echo htmlentities(round($results1[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results2[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results3[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results4[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results5[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results6[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results7[0][backlog]));?></td>
                                                <td><?php echo htmlentities(round($results8[0][backlog]));?></td>
                                            </tr>

                                        </table>
                                        <!-- <?php echo $results3[0][SGPA]; ?> -->
                                        <div id="chart_div"  style="width:100%;height:230px;font-size: 10px;"></div>
<?php } ?>
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
        <script type="text/javascript">
          google.charts.load('current', {'packages':['linechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Semester', 'SGPA', 'BACKLOG'],
              ['1st', <?php echo round($results1[0][SGPA],2); ?>, <?php echo round($results1[0][backlog],2); ?> ],
              ['2nd', <?php echo round($results2[0][SGPA],2); ?>, <?php echo round($results2[0][backlog],2); ?> ],
              ['3rd', <?php echo round($results3[0][SGPA],2); ?>, <?php echo round($results3[0][backlog],2); ?> ],
              ['4th', <?php echo round($results4[0][SGPA],2); ?>, <?php echo round($results4[0][backlog],2); ?> ],
              ['5th', <?php echo round($results5[0][SGPA],2); ?>, <?php echo round($results5[0][backlog],2); ?> ],
              ['6th', <?php echo round($results6[0][SGPA],2); ?>, <?php echo round($results6[0][backlog],2); ?> ],
              ['7th', <?php echo round($results7[0][SGPA],2); ?>, <?php echo round($results7[0][backlog],2); ?> ],
              ['8th', <?php echo round($results8[0][SGPA],2); ?>, <?php echo round($results8[0][backlog],2); ?> ]
            ]);

            var options = {
              title: 'SGPA Growth Report',
              curveType: 'function',
              legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
          }
        </script>
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