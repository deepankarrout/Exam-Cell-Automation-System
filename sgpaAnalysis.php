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
                                    <h2 class="title">SGPA Analysis</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="#"></i>Result Analysis</a></li>
                                        <li class="active">SGPA Analysis</li>
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
                                                <div class="panel-title">
                                                    <h5>View SGPA Analysis Report</h5>
                                                </div>
                                            </div>
                                        <table>
                                                <tr>
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            <select name="acdYear" class="form-control clid" id="acdYear" required="required">
                                                                <option value="">Select Session</option>
                                                            <?php  
                                                            $sql = "SELECT id,academicyear from academicsession";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            if($query->rowCount() > 0)
                                                            { 
                                                            foreach($results as $res)
                                                            {   ?>
                                                                <option value="<?php echo htmlentities($res->id); ?>"><?php echo htmlentities($res->academicyear); ?></option>
                                                            <?php }} ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <select name="branch" class="form-control clid" id="branch" required="required">
                                                                <option value="">Select Branch</option>
                                                                <?php  
                                                                $sql = "SELECT deptid,deptname from tbldepartment";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                                if($query->rowCount() > 0)
                                                                { 
                                                                foreach($results as $res)
                                                                {   ?>
                                                                <option value="<?php echo htmlentities($res->deptid); ?>"><?php echo htmlentities($res->deptname); ?></option>
                                                                <?php }} ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <button type="submit" class="btn btn-primary" id="courseView" name="courseView">VIEW</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </tr>
                                            </table>
                                        <div class="panel-body p-20">
                                        <!-- BACKLOG TABLE -->
<?php 
if(isset($_POST['courseView']))
{
$acdyear=$_POST['acdYear'];
$branch=$_POST['branch'];
$seme=$_POST['class'];

$sql = "SELECT tblresult.StudentId, tblstudents.StudentName, (SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits))as SGPA, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) > 9.0, 1,0) as count1, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 8.0 AND 9.0, 1,0) as count2, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 7.0 AND 8.0, 1,0) as count3, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 6.0 AND 7.0, 1,0) as count4, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) < 6.0, 1,0) as count5 FROM tblresult join tblsubjects on tblsubjects.id = tblresult.SubjectId join tblstudents on tblstudents.StudentId = tblresult.StudentId WHERE (tblresult.acdemicid=:acdyear and tblresult.deptid=:branch and tblresult.semid=3) GROUP BY tblresult.StudentId";
$query = $dbh->prepare($sql);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

$sql1 = "SELECT tblresult.StudentId, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) > 9.0, 1,0) as count1, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 8.0 AND 9.0, 1,0) as count2, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 7.0 AND 8.0, 1,0) as count3, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) BETWEEN 6.0 AND 7.0, 1,0) as count4, IF(SUM(CASE WHEN tblresult.marks >= 90 THEN 10 WHEN tblresult.marks BETWEEN 80 AND 90 THEN 9 WHEN tblresult.marks BETWEEN 70 AND 80 THEN 8 WHEN tblresult.marks BETWEEN 60 AND 70 THEN 7 WHEN tblresult.marks BETWEEN 50 AND 60 THEN 6 WHEN tblresult.marks BETWEEN 37 AND 50 THEN 5 WHEN tblresult.marks < 37 THEN 2 ELSE 0 END * tblsubjects.credits) / SUM(tblsubjects.credits) < 6.0, 1,0) as count5 FROM tblresult join tblsubjects on tblsubjects.id = tblresult.SubjectId WHERE (tblresult.acdemicid=:acdyear and tblresult.deptid=:branch and tblresult.semid=4) GROUP BY tblresult.StudentId";
$query = $dbh->prepare($sql1);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results1 = $query->fetchAll(PDO::FETCH_OBJ);
//print_r($results);
if($query->rowCount() >= 0)
{
    foreach($results as $result){
        $gt9 += $result->count1;
        $gt8 += $result->count2;
        $gt7 += $result->count3;
        $gt6 += $result->count4;
        $lt6 += $result->count5;
    }
    foreach($results1 as $result1){
        $gt91 += $result1->count1;
        $gt81 += $result1->count2;
        $gt71 += $result1->count3;
        $gt61 += $result1->count4;
        $lt61 += $result1->count5;
    }
 ?>
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
                                                <th>> 9.0 SGPA </th>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt9)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                                <td><?php echo htmlentities(round($gt91)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>8.0 – 9.0 SGPA </th>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt8)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                                <td><?php echo htmlentities(round($gt81)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>7. 0 – 8.0 SGPA</th>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt7)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                                <td><?php echo htmlentities(round($gt71)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>6.0 – 7.0 SGPA </th>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt6)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                                <td><?php echo htmlentities(round($gt61)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>< 6.0 SGPA </th>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt6)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                                <td><?php echo htmlentities(round($lt61)); ?></td>
                                            </tr>
                                        </table>
                                        <div>
                                            <a><b>TOPPER OF THE SEMESTER: </b><?php echo htmlentities($result->StudentName); ?></a>
                                        </div><br><br>
                                        <div id="chart_div"  style="width:100%;height:230px;font-size: 10px;"></div>
<?php }} ?>
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
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Semester', '>9.0 SGPA', '8.0-9.0 SGPA', '7.0-8.0 SGPA', '6.0-7.0 SGPA', '<6.0 SGPA'],
              ['1st', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['2nd', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['3rd', <?php echo htmlentities(round($gt9)); ?>, <?php echo htmlentities(round($gt8)); ?>, <?php echo htmlentities(round($gt7)); ?>, <?php echo htmlentities(round($gt6)); ?>, <?php echo htmlentities(round($lt6)); ?> ],
              ['4th', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['5th', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['6th', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['7th', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ],
              ['8th', <?php echo htmlentities(round($gt91)); ?>, <?php echo htmlentities(round($gt81)); ?>, <?php echo htmlentities(round($gt71)); ?>, <?php echo htmlentities(round($gt61)); ?>, <?php echo htmlentities(round($lt61)); ?> ]
            ]);

            var options = {
              title: 'SGPA Analysis Report',
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
        <!-- <script>//to avoid page resubmission by deeptiranjan & deepankar
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script> -->
    </body>
</html>
<?php } ?>
