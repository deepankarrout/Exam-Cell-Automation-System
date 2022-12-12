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
                                    <h2 class="title">Growth Analysis</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="#"></i>Result Analysis</a></li>
                                        <li class="active">Growth Analysis</li>
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
                                                    <h5>View Growth Analysis Report</h5>
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

                                                        <div class="col-sm-6">
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
                                        <table border="2px" class="gtable">
<?php 
if(isset($_POST['courseView']))
{
$acdyear=$_POST['acdYear'];
$branch=$_POST['branch'];

$sql1 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.semid=1 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=1) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=1";
$query = $dbh->prepare($sql1);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results1 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.semid=2 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch ) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=2) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=2";
$query = $dbh->prepare($sql2);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results2 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(DISTINCT tblresult.StudentId) as totalstudent, COUNT(DISTINCT tblresult.StudentId) as pass FROM tblresult WHERE tblresult.StudentId IN (SELECT tblresult.StudentId FROM tblresult WHERE tblresult.marks >= 35 GROUP BY tblresult.StudentId HAVING count(*) >= 1 ) AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=3";
$query = $dbh->prepare($sql);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
print_r($results);

$sql4 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=4) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=4) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=4";
$query = $dbh->prepare($sql4);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results4 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql5 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch  AND tblresult.semid=5) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=5) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=5";
$query = $dbh->prepare($sql5);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results5 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql6 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=6) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=6) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.ClassID=6";
$query = $dbh->prepare($sql6);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results6 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql7 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=7) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=7) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=7";
$query = $dbh->prepare($sql7);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results7 = $query->fetchAll(PDO::FETCH_ASSOC);

$sql8 = "SELECT COUNT(tblresult.StudentId) as totalstudent, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks>= 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=8) as pass, (SELECT COUNT(tblresult.marks) FROM tblresult WHERE tblresult.marks< 35 AND tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=8) as fail FROM tblresult WHERE tblresult.acdemicid=:acdyear AND tblresult.deptid=:branch AND tblresult.semid=8";
$query = $dbh->prepare($sql8);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':branch', $branch,PDO::PARAM_STR);
$query->execute();
$results8 = $query->fetchAll(PDO::FETCH_ASSOC);
//$resultss = array_values(array_replace_recursive($results, $results1, $results2));
//print_r($results);
if($query->rowCount() > 0)
{
 ?>
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
                                                <th>NUMBER OF STUDENT APPEARED</th>
                                                <td><?php echo htmlentities($results1[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results2[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results4[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results5[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results6[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results7[0][totalstudent]);?></td>
                                                <td><?php echo htmlentities($results8[0][totalstudent]);?></td>
                                            </tr>
                                            <tr>
                                                <th>NUMBER OF STUDENT PASSED</th>
                                                <td><?php echo htmlentities($results1[0][pass]);?></td>
                                                <td><?php echo htmlentities($results2[0][pass]);?></td>
                                                <td><?php echo htmlentities($results[0][pass]);?></td>
                                                <td><?php echo htmlentities($results4[0][pass]);?></td>
                                                <td><?php echo htmlentities($results5[0][pass]);?></td>
                                                <td><?php echo htmlentities($results6[0][pass]);?></td>
                                                <td><?php echo htmlentities($results7[0][pass]);?></td>
                                                <td><?php echo htmlentities($results8[0][pass]);?></td>
                                            </tr>
                                            <tr>
                                                <th>NUMBER OF STUDENT FAILED</th>
                                                <td><?php echo htmlentities($results1[0][fail]);?></td>
                                                <td><?php echo htmlentities($results2[0][fail]);?></td>
                                                <td><?php echo htmlentities($results[0][fail]);?></td>
                                                <td><?php echo htmlentities($results4[0][fail]);?></td>
                                                <td><?php echo htmlentities($results5[0][fail]);?></td>
                                                <td><?php echo htmlentities($results6[0][fail]);?></td>
                                                <td><?php echo htmlentities($results7[0][fail]);?></td>
                                                <td><?php echo htmlentities($results8[0][fail]);?></td>
                                            </tr>
                                            <tr>
                                                <th>PASS %AGE</th>
                                                <td><?php $pass_per1=round(($results1[0][pass]/$results1[0][totalstudent])*100);
                                                                        if(is_nan($pass_per1)){
                                                                            $pass_per1=0;
                                                                        }
                                                                        echo htmlentities($pass_per1);?>%</td>
                                                <td><?php $pass_per2=round(($results2[0][pass]/$results2[0][totalstudent])*100);
                                                                        if(is_nan($pass_per2)){
                                                                            $pass_per2=0;
                                                                        }
                                                                        echo htmlentities($pass_per2);?>%</td>
                                                <td><?php $pass_per=round(($results[0][pass]/$results[0][totalstudent])*100);
                                                                        if(is_nan($pass_per)){
                                                                            $pass_per=0;
                                                                        }
                                                                        echo htmlentities($pass_per);?>%</td>
                                                <td><?php $pass_per4=round(($results4[0][pass]/$results4[0][totalstudent])*100);
                                                                        if(is_nan($pass_per4)){
                                                                            $pass_per4=0;
                                                                        }
                                                                        echo htmlentities($pass_per4);?>%</td>
                                                <td><?php $pass_per5=round(($results5[0][pass]/$results5[0][totalstudent])*100);
                                                                        if(is_nan($pass_per5)){
                                                                            $pass_per5=0;
                                                                        }
                                                                        echo htmlentities($pass_per5);?>%</td>
                                                <td><?php $pass_per6=round(($results6[0][pass]/$results6[0][totalstudent])*100);
                                                                        if(is_nan($pass_per6)){
                                                                            $pass_per6=0;
                                                                        }
                                                                        echo htmlentities($pass_per6);?>%</td>
                                                <td><?php $pass_per7=round(($results7[0][pass]/$results7[0][totalstudent])*100);
                                                                        if(is_nan($pass_per7)){
                                                                            $pass_per7=0;
                                                                        }
                                                                        echo htmlentities($pass_per7);?>%</td>
                                                <td><?php $pass_per8=round(($results8[0][pass]/$results8[0][totalstudent])*100);
                                                                        if(is_nan($pass_per8)){
                                                                            $pass_per8=0;
                                                                        }
                                                                        echo htmlentities($pass_per8);?>%</td>
                                            </tr>
<?php }} ?>
                                        </table>

                                        <div id="chart_div"  style="width:100%;height:230px;font-size: 10px;"></div>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

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
          ['Semester', 'Pass Percentage'],
          ['1st', <?php echo $pass_per1; ?> ],
          ['2nd', <?php echo $pass_per2; ?> ],
          ['3rd', <?php echo $pass_per; ?> ],
          ['4th', <?php echo $pass_per4; ?> ],
          ['5th', <?php echo $pass_per5; ?> ],
          ['6th', <?php echo $pass_per6; ?> ],
          ['7th', <?php echo $pass_per7; ?> ],
          ['8th', <?php echo $pass_per8; ?> ]
        ]);

        var options = {
          title: 'Growth Report',
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
        <script>//to avoid page resubmission by deeptiranjan
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
<?php } ?>
