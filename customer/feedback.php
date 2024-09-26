<?php
    session_start();
    require_once("../resources/dbconfig.php");
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
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
                    <a class="waves-effect waves-dark" href="billing.php">
                        <i class="icofont icofont-pay"></i><span> Billing</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="transaction.php">
                        <i class="icofont icofont-history"></i><span> Transaction History</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="account-setting.php">
                        <i class="icofont icofont-user-alt-1"></i><span> Account</span>
                    </a>                
                </li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="feedback.php">
                        <i class="icofont icofont-mega-phone"></i><span> Feedback</span>
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
                  <h4>Feedback</h4>
               </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Create Feedback/Report</div>
                        </div>
                        <div class="card-block">
                            <form method="post" class="row" id="frmFeedback" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="send"/>
                                <input type="hidden" name="customer" value="<?php echo $_SESSION['sess_id'] ?>"/>
                                <div class="form-group col-md-12">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="subject"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Details</label>
                                    <textarea class="form-control" style="height:120px;overflow-y:auto;" name="details">
                                    </textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Attachment</label>
                                    <input type="file" name="file" class="form-control"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="submit" class="btn btn-primary" id="btnSubmit" value="Submit Message"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">My Feedback</div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="customer" id="customer" value="<?php echo $_SESSION['sess_id'] ?>"/>
                                    <input type="search" class="form-control" id="search"/>
                                </div>
                                <div class="col-md-12 form-group table-responsive tableFixHead" style="height:400px;overflow-y:auto;font-size:13px;">
                                    <table class="table">
                                        <thead>
                                            <th>&nbsp;</th>
                                            <th>Subject</th>
                                            <th>Details</th>
                                        </thead>
                                        <tbody id="tblfeedback"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <!-- Main content ends -->
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
       logs(); 
    });
    function logs()
    {
        $('#tblfeedback').html("<tr><td colspan='3'><center>Loading...</center></td></tr>");
        var action="mylogs";
        var user = $('#customer').val();
        $.ajax({
            url:"../resources/logs.php",method:"POST",
            data:{action:action,user:user},
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
    $('#search').keyup(function()
    {
        $('#tblfeedback').html("<tr><td colspan='3'><center>Loading...</center></td></tr>");
        var action="searchlogs";
        var text = $(this).val();
        var user = $('#customer').val();
        $.ajax({
            url:"../resources/logs.php",method:"POST",
            data:{action:action,user:user,keyword:text},
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
    });
        $('#frmFeedback').on('submit',function(evt)
          {
                evt.preventDefault();
                $.ajax({
                    url:"../resources/logs.php",method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#btnSubmit').attr("disabled","disabled");
                        $('#frmFeedback').css("opacity",".5");
                    },
                    success:function(data)
                    {
                        if(data==="success")
                        {
                            $('#frmFeedback')[0].reset();
                            alert("Successfully added");
                        }
                        else
                        {
                            alert(data);
                        }
                        $('#frmFeedback').css("opacity","");
                        $("#btnSubmit").removeAttr("disabled");
                    }
                });
          });
    </script>

</body>

</html>
