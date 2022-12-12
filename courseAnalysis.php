<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/check.php');
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
        <title>Exam Cell | DRIEMS | Dashboard </title>
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
#chartdiv {
    width       : 100%;
    height      : 435px;
    font-size   : 15px;
    font-weight : bold;
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
                                    <h2 class="title">Course Analysis</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="fdashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#"><i class="#"></i>Result Analysis</a></li>
                                        <li class="active">Course Analysis</li>
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
                                                    <h5>View Course Analysis Report</h5>
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
                                                            <button type="submit" class="btn btn-primary fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" OnClick="CallPrint(this.value)" ></button>
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
                                                                <th>NUMBER OF STUDENTS APPEARED</th>
                                                                <th>NUMBER OF STUDENTS PASSED</th>
                                                                <th>NUMBER OF STUDENT FAILED</th>
                                                                <th>PASS %AGE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
$totalPass = array();
if(isset($_POST['courseView']))
{
$acdyear=$_POST['acdYear'];
$branch=$_POST['branch'];
$seme=$_POST['class'];
$query = $dbh->prepare("SELECT tblresult.SubjectId, SUM( IF( tblresult.marks >= 35, 1, 0 ) ) AS pass, SUM( IF( tblresult.marks < 35, 1, 0 ) ) AS fail, COUNT(tblresult.StudentId) AS totalstd, tblsubjects.SubjectName, tblsubjects.SubjectCode, tblclasses.semname as sem, tblclasses.Section as sec, tblsubjectcombination.fid, tblfaculties.e_name FROM (((tblresult join tblsubjects on tblsubjects.id=tblresult.SubjectId) join tblclasses on tblclasses.id=tblresult.ClassId) join tblsubjectcombination on tblsubjectcombination.SubjectId=tblresult.SubjectId Join tblfaculties on tblfaculties.id=tblsubjectcombination.fid ) WHERE tblresult.acdemicid=:acdyear  AND tblresult.ClassId=:sem  GROUP BY tblresult.SubjectId");
$query->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
$query->bindParam(':sem', $seme,PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// $query1 = $dbh->prepare("SELECT tblresult.SubjectId, COUNT(tblresult.marks) as  pass FROM tblresult WHERE tblresult.marks>=35 AND tblresult.acdemicid=:acdyear  AND tblresult.ClassId=:sem GROUP BY tblresult.SubjectId");
// $query1->bindParam(':acdyear', $acdyear,PDO::PARAM_STR);
// $query1->bindParam(':sem', $seme,PDO::PARAM_STR);
// $query1->execute();
// $rests = $query1->fetchAll(PDO::FETCH_ASSOC);

// $resultss = array_values(array_replace_recursive($results, $rests, $restss));
//print_r($resultss);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
    //print_r(array_column($result, 'totalstd'));
    ?>
                                                            <tr>
                                                                <td style="text-align: center"><?php echo htmlentities($cnt);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['SubjectCode']);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['SubjectName']);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['sem']);?>(<?php echo htmlentities($result['sec']);?>)</td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['e_name']);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['totalstd']);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['pass']);?></td>
                                                                <td style="text-align: center"><?php echo htmlentities($result['fail']);?></td>
                                                                <td style="text-align: center"><?php $pass_per=round(($result['pass']/$result['totalstd'])*100);
                                                                        echo htmlentities($pass_per);
                                                                        array_push($totalPass, $pass_per);
                                                                ?>%</td>
                                                            </tr>
<?php $cnt=$cnt+1;}}} ?>
                                                        </tbody>
                                                    </table>
                                                    <!-- /.col-md-12 -->
                                                    <!-- Bar Chart -->
                                                    <div class="box-body">
                                                        <div id="chartdiv" style="width:100%;height:230px;font-size: 10px;"></div>
                                                    </div>
                                                </div>
                                            </div>
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
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        
        <script>
            var chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'chartdiv',
                                type: 'column',
                                options3d: {
                                    enabled: true,
                                    alpha: 0,
                                    beta: 0,
                                    depth: 20,
                                    viewDistance: 25
                                }
                            },
                            xAxis:{
                                categories: ['<?php echo $results[0]['SubjectName'] ?>','<?php echo $results[1]['SubjectName'] ?>','<?php echo $results[2]['SubjectName'] ?>','<?php echo $results[3]['SubjectName'] ?>','<?php echo $results[4]['SubjectName'] ?>','<?php echo $results[5]['SubjectName'] ?>','<?php echo $results[6]['SubjectName'] ?>','<?php echo $results[7]['SubjectName'] ?>','<?php echo $results[8]['SubjectName'] ?>','<?php echo $results[9]['SubjectName'] ?>','<?php echo $results[10]['SubjectName'] ?>','<?php echo $results[11]['SubjectName'] ?>','<?php echo $results[12]['SubjectName'] ?>'],
                                title:{
                                    text:'Subjects Name'
                                }
                            },
                            yAxis:{
                                allowDecimals: true,
                                min: 0,
                                max: 100,
                                title: {
                                    text: 'Pass percentage'
                                }
                            },
                            title:{text:null},
                            subtitle: {
                                text: "Course Analysis"
                            },
                            plotOptions: {
                                column: {
                                    depth: 35
                                }
                            },
                            series: [{
                                showInLegend: false,
                                name:'Percentage',
                                data: [<?php echo $totalPass[0] ?>,<?php echo $totalPass[1] ?>,<?php echo $totalPass[2] ?>,<?php echo $totalPass[3] ?>,<?php echo $totalPass[4] ?>,<?php echo $totalPass[5] ?>,<?php echo $totalPass[6] ?>,<?php echo $totalPass[7] ?>,<?php echo $totalPass[8] ?>,<?php echo $totalPass[9] ?>,<?php echo $totalPass[10] ?>,<?php echo $totalPass[11] ?>,<?php echo $totalPass[12] ?>]
                            }],
                            exporting: {
                                enabled: false
                            },
                            credits: {
                                enabled: false
                            }
                        });
            
        </script>
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
