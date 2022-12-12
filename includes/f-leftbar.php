<?php
session_start();
error_reporting(0);
include('includes/config.php');
$session_id = $_SESSION['alogin'];

?>
<div class="left-sidebar bg-black-300 box-shadow ">
                        <div class="sidebar-content">
                            <div class="user-info closed">

<?php $sql = "SELECT tblfaculties.e_name,tblfaculties.profile,tblfaculties.dept,tbldepartment.deptname,tbldepartment.deptcode FROM tblfaculties join tbldepartment on tbldepartment.deptid=tblfaculties.dept WHERE username ='$session_id'";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                <img src="<?php echo htmlentities($result->profile);?>" height="90px" width="90px" alt="profile-img" class="img-circle profile-img">
                                <h6 class="title">Mr. <?php echo htmlentities($result->e_name);?></h6>
                                <small class="info">Department of <?php echo htmlentities($result->deptcode);?></small>
<?php }} ?>
                            </div>
                            <!-- /.user-info -->

                            <div class="sidebar-nav">
                                <ul class="side-nav color-gray">
                                    <li class="nav-header">
                                        <span class="">Main Category</span>
                                    </li>
                                    <li>
                                        <a href="fdashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                                     
                                    </li>

                                    <li class="nav-header">
                                        <span class="">Analysis</span>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-user"></i> <span>Student Details</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="stuPerformance.php"><i class="fa fa-percent"></i> <span>Student Performance</span></a></li>
                                            <li><a href="sgpaGrowth.php"><i class="fa fa-line-chart"></i> <span>SGPA Growth</span></a></li>
                                           
                                        </ul>
                                    </li>
  <li class="has-children">
                                        <a href="#"><i class="fa fa-signal"></i> <span>Result Analysis</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="courseAnalysis.php"><i class="fa fa-bar-chart"></i> <span>Course Analysis</span></a></li>
                                            <li><a href="gradeAnalysis.php"><i class="fa fa fa-server"></i> <span>Grade Analysis</span></a></li>
                                           <li><a href="backlogAnalysis.php"><i class="fa fa-pie-chart"></i> <span>Backlog Analysis</span></a></li>
                                           <li><a href="growthAnalysis.php"><i class="fa fa-line-chart"></i> <span>Growth Analysis</span></a></li>
                                          <li> <a href="sgpaAnalysis.php"><i class="fa fa-area-chart"></i> <span>SGPA Analysis</span></a></li>
                                        </ul>
                                    </li>

<li class="has-children">
                                        
                                        <li><a href="change-password.php"><i class="fa fa-pencil-square"></i> <span>Change Password</span></a></li>
                                           
                                    </li>
                            </div>
                            <!-- /.sidebar-nav -->
                        </div>
                        <!-- /.sidebar-content -->
                    </div>