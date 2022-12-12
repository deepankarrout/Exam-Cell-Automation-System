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
                                    <h2 class="title">Backlog Analysis</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="#"></i>Result Analysis</a></li>
                                        <li class="active">Backlog Analysis</li>
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
                                                    <h5>View Backlog Analysis Report</h5>
                                                </div>
                                            </div>
                                            <table>
                                                <tr>
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <div class="col-sm-2">
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
                                                                <option value="<?php echo htmlentities($res->academicyear); ?>"><?php echo htmlentities($res->academicyear); ?></option>
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

                                                        <div class="col-sm-4">
                                                            <select name="class" class="form-control clid" id="class" required="required">
                                                                <option value="">Select Seme</option>
                                                                <?php  
                                                                $sql = "SELECT id,semname,Section from tblclasses";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                                if($query->rowCount() > 0)
                                                                { 
                                                                foreach($results as $res)
                                                                {   ?>
                                                                <option value="<?php echo htmlentities($res->id); ?>"><?php echo htmlentities($res->semname); ?> SEMESTER &nbsp;( Section-<?php echo htmlentities($res->Section); ?> )</option>
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
                                            <table class="backtable" border="2px">
<?php 
if(isset($_POST['courseView']))
{
$acdyear=$_POST['acdYear'];
$branch=$_POST['branch'];
$seme=$_POST['class'];

$sql = "SELECT COUNT(tblstudents.StudentId) as totalstudent,(SELECT COUNT(DISTINCT tblresult.StudentId) FROM tblresult WHERE tblstudents.academicyear=:acdyear AND tblstudents.ClassId=:sem) as apprstudent FROM tblstudents  WHERE tblstudents.academicyear=:acdyear AND tblstudents.ClassId=:sem";
$query = $dbh->prepare($sql);
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':sem', $seme,PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

//$query1 = $dbh->prepare("SELECT count(tr.StudentId)as allclear FROM tblresult tr WHERE (SELECT count(tr.StudentId) FROM tblstudents ts WHERE tr.StudentId = ts.StudentId) = (SELECT count(tr.StudentId) FROM tblstudents ts WHERE tr.StudentId = ts.StudentId AND tr.marks >= 35)");
$query1 = $dbh->prepare("SELECT COUNT(StudentId) as allclear FROM (SELECT StudentId, COUNT(StudentId) as cleared FROM tblresult WHERE ClassId=:sem GROUP BY StudentId) AS T1 WHERE StudentId AND cleared IN (SELECT COUNT(StudentId) as cleared FROM tblresult WHERE marks >= 35 AND ClassId=:sem GROUP BY StudentId)");
$query1->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query1->bindParam(':sem', $seme,PDO::PARAM_STR);
$query1->execute();
$results1 = $query1->fetchAll(PDO::FETCH_ASSOC);

$query2 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as obacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) = 1 )");
$query2->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query2->bindParam(':sem', $seme,PDO::PARAM_STR);
$query2->execute();
$results2 = $query2->fetchAll(PDO::FETCH_ASSOC);

$query3 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as tbacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) = 2 )");
$query3->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query3->bindParam(':sem', $seme,PDO::PARAM_STR);
$query3->execute();
$results3 = $query3->fetchAll(PDO::FETCH_ASSOC);

$query4 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as thbacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) = 3 )");
$query4->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query4->bindParam(':sem', $seme,PDO::PARAM_STR);
$query4->execute();
$results4 = $query4->fetchAll(PDO::FETCH_ASSOC);

$query5 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as fbacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) = 4 )");
$query5->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query5->bindParam(':sem', $seme,PDO::PARAM_STR);
$query5->execute();
$results5 = $query5->fetchAll(PDO::FETCH_ASSOC);

$query6 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as fvbacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) = 5 )");
$query6->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query6->bindParam(':sem', $seme,PDO::PARAM_STR);
$query6->execute();
$results6 = $query6->fetchAll(PDO::FETCH_ASSOC);

$query7 = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) as allbacklog FROM tblresult WHERE StudentId IN (SELECT StudentId FROM tblresult WHERE marks < 35 GROUP BY StudentId HAVING count(*) >= 6 )");
$query7->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query7->bindParam(':sem', $seme,PDO::PARAM_STR);
$query7->execute();
$results7 = $query7->fetchAll(PDO::FETCH_ASSOC);
//print_r($results6);
if($query->rowCount() > 0)
{
 ?>
                                                <tr>
                                                    <th>Total No. of Students</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results[0][totalstudent]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>No. of student Not Appear</th>
                                                    <td style="text-align: center"><?php $notappr = $results[0][totalstudent]-$results[0][apprstudent];
                                                        echo htmlentities($notappr);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with All Clear</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results1[0][allclear]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with 1 Backlog</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results2[0][obacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with 2 Backlog</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results3[0][tbacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with 3 Backlog</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results4[0][thbacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with 4 Backlog</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results5[0][fbacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with 5 Backlog</th>
                                                    <td style="text-align: center"><?php echo htmlentities($results6[0][fvbacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Students with All Backlog</th>
                                                    <td style="color: red; text-align: center"><?php echo htmlentities($results7[0][allbacklog]);?></td>
                                                </tr>
                                                <tr>
                                                    <th>%age Of Final Result</th>
                                                    <td style="text-align: center"><?php $apprstd = $results[0][apprstudent];
                                                                                         $allclr = $results1[0][allclear];
                                                                                         $pass_per = round(($allclr/$apprstd)*100);
                                                                                         echo htmlentities($pass_per);?>%</td>
                                                </tr>
<?php }} ?>
                                             </table>

                                             <div id="piechart_3d" style="width:100%;height:500px;font-size: 10px;"></div>

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
        <!-- PIECHART -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Analysis', 'no of student per semester '],

              ['No. of student Not Appear', <?php echo $notappr; ?>],
              ['Number of Students with All Clear', <?php echo $results1[0][allclear]; ?>],
              ['Number of Students with 1 Backlog', <?php echo $results2[0][obacklog]; ?>],
              ['Number of Students with 2 Backlog', <?php echo $results3[0][tbacklog]; ?>],
              ['Number of Students with 3 Backlog', <?php echo $results4[0][thbacklog]; ?>],
              ['Number of Students with 4 Backlog', <?php echo $results5[0][fbacklog]; ?>],
              ['Number of Students with 5 Backlog', <?php echo $results6[0][fvbacklog]; ?>],
              ['Number of Students with all Backlog',<?php echo $results7[0][allbacklog]; ?>],
            ]);

            var options = {
              title: 'Backlog Analysis',
              is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
          }
        </script>
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
