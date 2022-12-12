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
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <script src="js/modernizr/modernizr.min.js"></script>
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
table.dataTable thead tr {
  background-color: #66c2ff;
}
table.dataTable tbody {
  background-color: #ccebff;
}
        </style>
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
                                    <h2 class="title">Grade Analysis</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i>Home</a></li>
                                        <li><a href="#"><i class="#"></i>Result Analysis</a></li>
                                        <li class="active">Grade Analysis</li>
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
                                                    <h5>View Grade Analysis Report</h5>
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

                                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>COURSE CODE</th>
                                                            <th>COURSE</th>
                                                            <th>SECTION</th>
                                                            <th>FACULTY</th>
                                                            <th>O GRADE</th>
                                                            <th>E GRADE</th>
                                                            <th>A GRADE</th>
                                                            <th>B GRADE</th>
                                                            <th>C GRADE</th>
                                                            <th>D GRADE</th>
                                                            <th>F GRADE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php 
if(isset($_POST['courseView']))
{
$acdyear=$_POST['acdYear'];
$branch=$_POST['branch'];
$seme=$_POST['class'];

$sql = "SELECT tblresult.SubjectId, SUM( IF( tblresult.marks <35, 1, 0 ) ) AS F, SUM( IF( tblresult.marks BETWEEN 35 AND 50, 1, 0 ) ) AS D, SUM( IF( tblresult.marks BETWEEN 50 AND 60 , 1, 0 ) ) AS C, SUM( IF( tblresult.marks BETWEEN 60 AND 70, 1, 0 ) ) AS B, SUM( IF( tblresult.marks BETWEEN 70 AND 80, 1, 0 ) ) AS A, SUM( IF( tblresult.marks BETWEEN 80 AND 90, 1, 0 ) ) AS E, SUM( IF( tblresult.marks >90, 1, 0 ) ) AS O, tblresult.marks AS mark, tblsubjects.SubjectName, tblsubjects.SubjectCode, tblclasses.semname as sem, tblclasses.Section as sec, tblsubjectcombination.fid, tblfaculties.e_name FROM (((tblresult join tblsubjects on tblsubjects.id=tblresult.SubjectId) join tblclasses on tblclasses.id=tblresult.ClassId) join tblsubjectcombination on tblsubjectcombination.SubjectId=tblresult.SubjectId Join tblfaculties on tblfaculties.id=tblsubjectcombination.fid ) WHERE tblresult.acdemicid=:acdyear  AND tblresult.ClassId=:sem GROUP BY tblresult.SubjectId";
$query = $dbh->prepare($sql); 
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':sem', $seme,PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// $query1 = $dbh->prepare("SELECT tblresult.SubjectId, COUNT(tblresult.marks) AS O FROM tblresult WHERE tblresult.marks BETWEEN 90 AND 100 AND tblresult.acdemicid=:acdyear  AND tblresult.ClassId=:sem GROUP BY tblresult.SubjectId");
// $query1->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
// $query1->bindParam(':sem', $seme,PDO::PARAM_STR);
// $query1->execute();
// $results1 = $query1->fetchAll(PDO::FETCH_ASSOC);
// foreach($results as $key => $value){
//     foreach($results1 as $value2){
//         if($value['SubjectId'] === $value2['SubjectId']){
//             $results[$key]['O'] = $value2['O'];
//         }               
//     }
// }
//print_r($results);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{     ?>
                                                        <tr>
                                                            <td style="text-align: center"><?php echo htmlentities($cnt);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['SubjectCode']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['SubjectName']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['sem']);?>(<?php echo htmlentities($result['sec']);?>)</td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['e_name']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['O']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['E']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['A']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['B']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['C']);?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($result['D']);?></td>
                                                            <td style="color: red;text-align: center;"><?php echo htmlentities($result['F']);?></td>
                                                        </tr>
<?php $cnt=$cnt+1;}}} ?>
                                                    </tbody>
                                                </table>
                                                <!-- /.col-md-12 -->
                                                <!-- Bar Chart -->
                                                <div id="chart_div"></div>
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
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script src="js/production-chart.js"></script>
        <script src="js/traffic-chart.js"></script>
        <script src="js/task-list.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
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
                toastr["success"]( "Welcome to Faculties Dashoboard!");

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