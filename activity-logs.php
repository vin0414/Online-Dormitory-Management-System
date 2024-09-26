<?php
    session_start();
    require_once("resources/dbconfig.php");
    if(empty($_SESSION['sess_fullname']) || $_SESSION['sess_fullname'] == ''){
    header("Location: https://jmdormitory.000webhostapp.com/");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>J-M Dormitory Reservation System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <!-- Weather css -->
    <link href="assets/css/svg-weather.css" rel="stylesheet">


    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <style>
        /* Track */
            ::-webkit-scrollbar-track {
              background: #f1f1f1; 
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
              background: #888; 
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
              background: #555; 
            }
            ::-webkit-scrollbar {
                height: 4px;              /* height of horizontal scrollbar ← You're missing this */
                width: 4px;               /* width of vertical scrollbar */
                border: 1px solid #d5d5d5;
              }
            .tableFixHead thead th { position: sticky; top: 0; z-index: 1;color:#fff;background-color:#0275d8;}

                /* Just common table stuff. Really. */
                table  { border-collapse: collapse; width: 100%; }
                th, td { padding: 8px 16px;color:#000; }
                tbody{color:#000;}
            tr:nth-child(even) {
                  background-color: #f2f2f2;
                }
            
    </style>
</head>

<body class="sidebar-mini fixed">
   <div class="loader-bg">
      <div class="loader-bar">
      </div>
   </div>
   <div class="wrapper">
      <!-- Navbar-->
      <header class="main-header-top hidden-print">
         <a href="admin-panel.php" class="logo">
             <img src="assets/images/logo.png" alt="logo" width="50"/>
             J-M Dormitory
         </a>
         <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu f-right">
               <ul class="top-nav">
                  <!--Notification Menu-->
                  <li class="pc-rheader-submenu">
                     <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                        <i class="icon-size-fullscreen"></i>
                     </a>

                  </li>
                  <!-- User Menu-->
                  <li class="dropdown">
                     <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                        <span><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                        <span><?php echo $_SESSION['sess_fullname']; ?> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="logout.php"><i class="icon-logout"></i> Logout</a></li>

                     </ul>
                  </li>
               </ul>
         </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print ">
         <section class="sidebar" id="sidebar-scroll">
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="admin-panel.php">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="employee.php">
                        <i class="icofont icofont-users"></i><span> Employee</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="rooms.php">
                        <i class="icofont icofont-hotel"></i><span> Rooms</span>
                    </a>                
                </li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="activity-logs.php">
                        <i class="icofont icofont-contacts"></i><span> Activity Logs</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="upload-file.php">
                        <i class="icofont icofont-cloud-upload"></i><span> Upload Files</span>
                    </a>                
                </li>
            </ul>
         </section>
      </aside>
      <div class="content-wrapper">
         <!-- Container-fluid starts -->
         <!-- Main content starts -->
         <div class="container-fluid">
            <div class="row">
               <div class="main-header">
                  <h4>Activity Logs</h4>
               </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#customer" role="tab">Customer</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#user" role="tab">User Logs</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#time" role="tab">Time In/Out</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="customer" role="tabpanel">
                            <br/>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Search</label>
                                    <input type="search" class="form-control" id="search"/>
                                </div>
                                <div class="col-md-12 form-group table-responsive tableFixHead" style="height:400px;overflow-y:auto;font-size:13px;">
                                    <table class="table">
                                        <thead>
                                            <th>Customer's Name</th>
                                            <th>Email Address</th>
                                            <th>Contact No.</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody id="tblcustomer"></tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <p style="float:right;">Total : <button type="button" id="total" class="btn btn-default"></button></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="user" role="tabpanel">
                            <br/>
                            <div class="table-responsive tabFixHead" style="height:500px;overdflow-y:auto;font-size:13px;">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                        <th>Email Address</th>
                                        <th>Complete Name</th>
                                        <th>Employee ID</th>
                                        <th>Designation</th>
                                        <th>Date and Time</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    try
                                    {
                                        $sql = "Select a.*,b.* from tbl_logs b LEFT JOIN tblaccount a ON a.adminID=b.adminID GROUP BY b.logID ORDER BY b.logID DESC";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->execute();
                                        $data = $stmt->fetchAll();
                                        foreach($data as $row)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['EmailAddress'] ?></td>
                                                <td><?php echo $row['Fullname'] ?></td>
                                                <td><?php echo $row['EmployeeID'] ?></td>
                                                <td><?php echo $row['Designation'] ?></td>
                                                <td><?php echo $row['DateTime'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    catch(Exception $e)
                                    {
                                        echo $e->getMessage();
                                    }
                                    ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="time" role="tabpanel">
                            <br>
                            <div class="table-responsive tabFixHead" style="height:500px;overdflow-y:auto;font-size:13px;">
                                <table class="table table-bordered" id="table2">
                                    <thead>
                                        <th>Email Address</th>
                                        <th>Complete Name</th>
                                        <th>Time In/Out</th>
                                        <th>Date & Time</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    try
                                    {
                                        $sql = "Select a.*,b.* from tbltimecheck b LEFT JOIN tblcustomer a ON a.customerID=b.customerID GROUP BY b.timeID ORDER BY b.timeID DESC";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->execute();
                                        $data = $stmt->fetchAll();
                                        foreach($data as $row)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['EmailAddress'] ?></td>
                                                <td><?php echo $row['Fullname'] ?></td>
                                                <td><?php echo $row['timetype'] ?></td>
                                                <td><?php echo $row['time'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    catch(Exception $e)
                                    {
                                        echo $e->getMessage();
                                    }
                                    $dbh=null;
                                    ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Required Jqurey -->
   <script src="assets/plugins/Jquery/dist/jquery.min.js"></script>
   <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- Scrollbar JS-->
   <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="assets/plugins/classie/classie.js"></script>

   <!-- notification -->
   <script src="assets/plugins/notification/js/bootstrap-growl.min.js"></script>

   <!-- Sparkline charts -->
   <script src="assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

   <!-- Counter js  -->
   <script src="assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- Echart js -->
   <script src="assets/plugins/charts/echarts/js/echarts-all.js"></script>

   <!-- custom js -->
   <script type="text/javascript" src="assets/js/main.min.js"></script>
   <script type="text/javascript" src="assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="assets/pages/elements.js"></script>
   <script src="assets/js/menu.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<script>
var $window = $(window);
var nav = $('.fixed-button');
$window.scroll(function(){
    if ($window.scrollTop() >= 200) {
       nav.addClass('active');
    }
    else {
       nav.removeClass('active');
    }
});
$(document).ready(function()
{
    loadCustomer();
});
function loadCustomer()
{
    var action = "customer";
    $('#tblcustomer').html("<tr><td colspan='5'><center>Loading...</center></td></tr>");
    $.ajax({
        url:"resources/logs.php",method:"POST",
        data:{action:action},success:function(data)
        {
            if(data==="")
            {
                $('#tblcustomer').html("<tr><td colspan='5'><center>No Customers</center></td></tr>");
            }
            else
            {
                $('#tblcustomer').html(data);
            }
            var count = $('#tblcustomer').children('tr').length;$('#total').html(count);
        }
    });
}
</script>
<script>
    jQuery(document).ready(function($) {
        $('#table').DataTable();
        $('#table2').DataTable();
    } );
</script>

</body>

</html>
