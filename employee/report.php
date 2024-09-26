<?php
    session_start();
    require_once("../resources/dbconfig.php");
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
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="icon" href="../assets/images/logo.png" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="../assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">
    
    <!-- Weather css -->
    <link href="../assets/css/svg-weather.css" rel="stylesheet">


    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
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
         <a href="dashboard.php" class="logo">
             <img src="../assets/images/logo.png" alt="logo" width="50"/>
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
                        <span><img class="img-circle " src="../assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                        <span><?php echo $_SESSION['sess_fullname']; ?> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="../logout.php"><i class="icon-logout"></i> Logout</a></li>

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
                    <a class="waves-effect waves-dark" href="dashboard.php">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="booking.php">
                        <i class="icofont icofont-notebook"></i><span> Booking</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="rooms.php">
                        <i class="icofont icofont-hotel"></i><span> Rooms</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="customer.php">
                        <i class="icofont icofont-people"></i><span> Customer</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="reservation.php">
                        <i class="icofont icofont-address-book"></i><span> Reservation</span>
                    </a>                
                </li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="report.php">
                        <i class="icofont icofont-bars"></i><span> Report</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="account-setting.php">
                        <i class="icofont icofont-user"></i><span> Account</span>
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
                  <h4>Report</h4>
               </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Daily Revenue</div>
                        </div>
                        <div class="card-block">
                            <div id="chartContainer" style="height:400px;">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Feedback/Reports</div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive tableFixHead" style="height:400px;overflow-y:auto;font-size:13px;">
                                <table class="table">
                                    <thead>
                                        <th>&nbsp;</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                    </thead>
                                    <tbody id="tblfeedback">
                                        <tr><td colspan='3'><center>No Feedback(s)</center></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <!-- Main content ends -->
      </div>
   </div>
   
   <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer's Feedback</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="result">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Comments</h6>
                            <div class="form-group" id="response">
                                
                            </div>
                            <h6>Leave a Message</h6>
                            <form class="form-group row" method="post" id="frmComment">
                                <input type="hidden" id="action" name="action" value="new-comment"/>
                                <input type="hidden" id="feed" name="feed"/>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" style="height:100px;overflow-y:auto;" id="message" name="message"></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="button" class="btn btn-primary reply">Reply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

   <!-- Required Jqurey -->
   <script src="../assets/plugins/Jquery/dist/jquery.min.js"></script>
   <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="../assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- Scrollbar JS-->
   <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="../assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="../../assets/plugins/classie/classie.js"></script>

   <!-- notification -->
   <script src="../assets/plugins/notification/js/bootstrap-growl.min.js"></script>

   <!-- Sparkline charts -->
   <script src="../assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

   <!-- Counter js  -->
   <script src="../assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="../assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- Echart js -->
   <script src="../assets/plugins/charts/echarts/js/echarts-all.js"></script>>
   <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <!-- custom js -->
   <script type="text/javascript" src="../assets/js/main.min.js"></script>
   <script type="text/javascript" src="../assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="../assets/pages/elements.js"></script>
   <script src="../assets/js/menu.min.js"></script>
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
            chart();feed();
        });
        $(document).on('click','.reply',function()
        {
           var action = $('#action').val();
           var feed = $('#feed').val();
           var msg = $('#message').val();
           var user = "<?php echo $_SESSION['sess_id'] ?>";
           $.ajax({
               url:"../resources/logs.php",method:"POST",
               data:{action:action,feed:feed,message:msg,user:user},success:function(data)
               {
                   console.log(data);
                   $('#message').val("");
                   load();
               }
           });
        });
        
        function load()
        {
            var feed = $('#feed').val();
            var action ="get";
            $.ajax({
               url:"../resources/logs.php",method:"POST",
               data:{action:action,feed:feed},success:function(data)
               {
                    $('#response').html(data);
               }
           });
        }
        $(document).on('click','.view',function()
            {
               var val = $(this).val();
               var action = "view";
               $.ajax({
                   url:"../resources/logs.php",method:"POST",
                   data:{action:action,value:val},
                   success:function(data)
                   {
                       $('#myModal').modal('show');
                       $('#result').html(data);
                       $('#feed').attr("value",val);
                       load();
                   }
               });
            });
        function feed()
        {
            var action = "feedback";
            $.ajax({
                url:"../resources/logs.php",method:"POST",
                data:{action:action},
                success:function(data)
                {
                    if(data==="")
                    {
                        $('#tblfeedback').html("<tr><td colspan='3'><center>No Data</center></td></tr>");
                    }
                    else
                    {
                        $('#tblfeedback').html(data);
                    }
                }
            });
        }
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
        		type: "splineArea", //change type to bar, line, area, pie, etc  
        		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        	}]
        });
        chart.render();
        }
    </script>

</body>

</html>
