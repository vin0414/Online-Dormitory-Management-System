<?php
    session_start();
    require_once("resources/dbconfig.php");
    if(empty($_SESSION['sess_fullname']) || $_SESSION['sess_fullname'] == ''){
    header("Location: https://jmdormitory.000webhostapp.com/");
    die();
}
?>
<?php
$dataPoints = array();
try
{
    $handle = $dbh->prepare('Select Date, SUM(Pay_Amount)Amount from tbl_bill GROUP BY Date'); 
    $handle->execute(); 
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
		
    foreach($result as $row){
        array_push($dataPoints, array("label"=> $row->Date, "y"=> $row->Amount));
    }
}
catch(Exception $e)
{
    echo $e->getMessage();
}
$dbh=null;
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
    
    <!-- Weather css -->
    <link href="assets/css/svg-weather.css" rel="stylesheet">


    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link href="https://cdn.syncfusion.com/ej2/ej2-base/styles/material.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.syncfusion.com/ej2/ej2-buttons/styles/material.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.syncfusion.com/ej2/ej2-calendars/styles/material.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.syncfusion.com/ej2/ej2-base/dist/global/ej2-base.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/ej2-inputs/dist/global/ej2-inputs.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/ej2-buttons/dist/global/ej2-buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/ej2-lists/dist/global/ej2-lists.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/ej2-popups/dist/global/ej2-popups.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/ej2-calendars/dist/global/ej2-calendars.min.js" type="text/javascript"></script>
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
                <li class="active treeview">
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
                <li class="treeview">
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
                  <h4>Dashboard</h4>
               </div>
            </div>
            <!-- 4-blocks row start -->
            <div class="row">
                <div class="col-lg-9">
                    <div class="row dashboard-header">
                       <div class="col-lg-4 col-md-6">
                          <div class="card dashboard-product">
                             <span>Rooms</span>
                             <h2 class="dashboard-total-products" id="rooms">0</h2>
                             <span class="label label-warning">Available</span>
                          </div>
                       </div>
                       <div class="col-lg-4 col-md-6">
                          <div class="card dashboard-product">
                             <span>Reservation</span>
                             <h2 class="dashboard-total-products" id="customer">0</h2>
                             <span class="label label-primary">New Customers</span>
                          </div>
                       </div>
                       <div class="col-lg-4 col-md-6">
                          <div class="card dashboard-product">
                             <span>Revenue</span>
                             <h2 class="dashboard-total-products" id="income">0</h2>
                             <span class="label label-success">Sales</span>
                          </div>
                       </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Daily Revenue</div>
                        </div>
                        <div class="card-block">
                            <div id="chartContainer" style="height:300px;">
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="element"></div>
                </div>
            </div>
            <!-- 4-blocks row end -->
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
   <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <!-- custom js -->
   <script type="text/javascript" src="assets/js/main.min.js"></script>
   <script type="text/javascript" src="assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="assets/pages/elements.js"></script>
   <script src="assets/js/menu.min.js"></script>
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
            reservation();chart();
        });
        function chart()
        {
            var chart = new CanvasJS.Chart("chartContainer", {
        	animationEnabled: true,
        	exportEnabled: true,
        	theme: "light1", // "light1", "light2", "dark1", "dark2"
        	title:{
        		text: ""
        	},
        	data: [{
        		type: "column", //change type to bar, line, area, pie, etc  
        		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        	}]
        });
        chart.render();
        }
        function reservation()
        {
            var action = "number_of_reserve";
            $.ajax({
                url:"../resources/connection.php",method:"POST",
                data:{action:action},success:function(data)
                {
                    $('#customer').html(data);
                }
            });
            
            var action = "income";
            $.ajax({
                url:"../resources/connection.php",method:"POST",
                data:{action:action},success:function(data)
                {
                    $('#income').html(data);
                }
            });
            
            var action = "room";
            $.ajax({
                url:"../resources/connection.php",method:"POST",
                data:{action:action},success:function(data)
                {
                    $('#rooms').html(data);
                }
            });
        }
    </script>
    <script>
        // initialize the Calendar component
        var calendar = new ej.calendars.Calendar();
 
        // Render the initialized button.
        calendar.appendTo('#element')
    </script>

</body>

</html>
