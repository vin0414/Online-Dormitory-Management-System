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
                <li class="active treeview">
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
                <li class="treeview">
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
                  <h4>Dashboard</h4>
               </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Reserve a Room</div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Search Room</label>
                                    <input type="search" class="form-control" id="search"/>
                                </div>
                                <div class="col-md-12 form-group table-responsive tableFixHead" style="height:400px;overflow-y:auto;font-size:13px;">
                                    <table class="table" id="table1">
                                        <thead>
                                            <th>Room Name</th>
                                            <th>Room No.</th>
                                            <th>Description</th>
                                            <th>Rates</th>
                                            <th>Available Bed</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody id="tblrooms"></tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <p style="float:right;">Total : <button type="button" id="total" class="btn btn-default"></button></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Details</div>
                        </div>
                        <div class="card-block">
                            <?php
                            try
                            {
                                $user = $_SESSION['sess_id'];
                                $stmt = $dbh->prepare('Select a.*,b.File from tblcustomer a LEFT JOIN tblprofile b ON b.customerID=a.customerID WHERE a.customerID=:user');
                                $stmt->bindParam(':user',$user);
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach($data as $row)
                                {
                                    $imgUrl = "../resources/pictures/".$row['File'];
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <form method="post" class="row" id="frmUpload">
                                                <input type="hidden" id="customer" name="customer" value="<?php echo $_SESSION['sess_id'] ?>"/>
                                                <input type="hidden" name="action" value="upload"/>
                                                <div class="col-md-12 form-group">
                                                    <label>Upload Profile</label>
                                                    <input type="file" class="form-control" name="profile" id="profile" required/>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <input type="submit" class="btn btn-primary" name="btnUpload" id="btnUpload" value="Upload"/>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Email Address</label>
                                                    <input type="email" class="form-control" value="<?php echo $row['EmailAddress'] ?>" readonly/>
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="<?php echo $imgUrl; ?>" height="100" width="100" style="border:1px solid #000000;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Contact No.</label>
                                                    <input type="phone" class="form-control" value="<?php echo $row['Contact'] ?>" readonly/>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Gender</label>
                                                    <input type="text" class="form-control" value="<?php echo $row['Gender'] ?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Verification</label>
                                            <input type="text" class="form-control" value="<?php echo $row['verification'] ?>" readonly/>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Status</label>
                                            <button type="button" class="form-control btn btn-outline-success">Active</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            catch(Exception $e)
                            {
                                echo $e->getMessage();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <!-- Main content ends -->
      </div>
   </div>
   <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Details</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="row" id="frmTransaction">
                                <input type="hidden" name="action" value="addtransaction"/>
                                <input type="hidden" id="roomID" name="roomID"/>
                                <input type="hidden" id="customer" name="customer" value="<?php echo $_SESSION['sess_id'] ?>"/>
                                <div class="col-md-12 form-group">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="fdate" id="fdate"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="tdate" id="tdate"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>No. of Months</label>
                                            <input type="text" class="form-control" name="days" id="days" style="text-align:right;"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label>No. of Bed</label>
                                            <input type="number" class="form-control" name="bed"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Amount To Be Paid</label>
                                    <input type="text" class="form-control" name="total" id="net" style="text-align:right;"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="submit" class="form-control btn btn-primary btn-sm" id="btnSave"/>
                                </div>
                        </form>
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
    $('#frmUpload').on('submit',function(evt)
          {
                evt.preventDefault();
                $.ajax({
                    url:"../resources/customerModule.php",method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#btnUpload').attr("disabled","disabled");
                        $('#frmUpload').css("opacity",".5");
                    },
                    success:function(data)
                    {
                        if(data==="success")
                        {
                            window.location.href="dashboard.php";
                        }
                        else
                        {
                            alert(data);
                        }
                        $('#frmUpload').css("opacity","");
                        $("#btnUpload").removeAttr("disabled");
                    }
                });
          });
    $(document).ready(function()
    {
        loadRooms();
        $(document).on('click','.reserve',function()
        {
            var confirmation = confirm("Do you want to reserve this room?");
            if(confirmation)
            {
                var id = $(this).val();
                $('#roomID').attr("value",id);
                $('#myModal').modal('show');
            }
        });
    });
    function loadRooms()
    {
        $('#tblrooms').html("<tr><td colspan='6'><center>Loading rooms...</center></td></tr>");
        var action = "rooms";
        $.ajax({
            url:"../resources/customerModule.php",method:"POST",
            data:{action:action},
            success:function(data)
            {
                if(data==="")
                {
                    $('#tblrooms').html("<tr><td colspan='6'><center>No Room(s) added</center></td></tr>");
                }
                else
                {
                    $('#tblrooms').html(data);
                }
                var count = $('#tblrooms').children('tr').length;$('#total').html(count);
            }
        });
    }
    $('#search').keyup(function()
    {
        $('#tblrooms').html("<tr><td colspan='6'><center>Searching rooms...</center></td></tr>");
        var action = "search-rooms";
        var text = $(this).val();
        $.ajax({
            url:"../resources/customerModule.php",method:"POST",
            data:{action:action,keyword:text},
            success:function(data)
            {
                if(data==="")
                {
                    $('#tblrooms').html("<tr><td colspan='6'><center>No Room(s) added</center></td></tr>");
                }
                else
                {
                    $('#tblrooms').html(data);
                }
                var count = $('#tblrooms').children('tr').length;$('#total').html(count);
            }
        });
    });
    $('#tdate').change(function()
    {
          var dt1 = new Date($('#fdate').val());
          var dt2 = new Date($('#tdate').val());
          var diff =(dt2.getTime() - dt1.getTime()) / 1000;
          diff /= (60 * 60 * 24 * 7 * 4);
          $('#days').attr("value",Math.abs(Math.round(diff)));
          var action = "total";
          var days = $('#days').val();
          var id = $('#roomID').val();
          $.ajax({
              url:"../resources/customerModule.php",method:"POST",
              data:{action:action,days:days,id:id},
              success:function(data)
              {
                 $('#net').attr("value",data); 
              }
          });
    });
    $('#btnSave').on('click',function(evt)
    {
        evt.preventDefault();
        var data = $('#frmTransaction').serialize();
        $.ajax({
              url:"../resources/customerModule.php",method:"POST",
              data:data,
              success:function(data)
              {
                 if(data==="success")
                 {
                     window.location.href="dashboard.php";
                     document.getElementById("trxn").style="display:none";
                 }
                 else
                 {
                     alert(data);
                 }
              }
          });
    });
    </script>

</body>

</html>
