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
            #document {
            
            }
            @page { size:  auto; margin: 10mm 10mm 10mm 10mm; } 
            @media print {
              #search,
              .printPage {
                display: none !important;
              }
            }

    </style>
</head>

<body>
   <div class="loader-bg">
      <div class="loader-bar">
      </div>
   </div>
         <!-- Container-fluid starts -->
         <!-- Main content starts -->
         <div>
            <?php
            $trxn = $_GET['print'];
            ?>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="card" id="document">
                        <div class="card-block">
                            <h5><center>JM Dormitory Online Reservation</center></h5>
                            <p><center>Sample Complete Address, Zip Code</center></p>
                            <p><center>Contact No. : 098757362141</center></p>
                            <p><center>Email Address : jmdormitory@gmail.com</center></p>
                            <?php
                            try
                            {
                                $sql = "Select a.*,b.Fullname,b.Contact,b.EmailAddress,c.QRCode,FORMAT(f.Rate,2)Rate,FORMAT(c.TotalCharge,2)total,FORMAT(c.Pay_Amount,2)pay,
                                FORMAT((c.TotalCharge-c.Pay_Amount),2)remain,d.RoomNumber,e.Date,c.Month,e.Reference from tbltransaction a LEFT JOIN tblcustomer b ON b.customerID=a.customerID LEFT JOIN tblpayment c ON c.trxnID=a.trxnID LEFT JOIN tblavailableroom d ON a.aID=d.aID LEFT JOIN tbl_bill e ON e.QRCode=c.QRCode LEFT JOIN tblrooms f ON f.roomID=d.roomID WHERE a.trxnID=:id GROUP BY a.trxnID";
                                $stmt = $dbh->prepare($sql);
                                $stmt->bindParam(':id',$trxn);
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach($data as $row)
                                {
                                    ?>
                                    <br/>
                                    <div class="form-group">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th colspan='2'>Customer's Information</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan='2'>Control No. : <?php echo $row['Reference'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Date : <?php echo $row['Date'] ?></td>
                                                    <td>Check In : <?php echo $row['FromDate'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Guest Name : <?php echo $row['Fullname'] ?></td>
                                                    <td>Check Out : <?php echo $row['ToDate'] ?></td>
                                                </tr>
                                                <tr><td>Contact No. : <?php echo $row['Contact'] ?></td><td>Room No. : <?php echo $row['RoomNumber'] ?></td></tr>
                                                <tr><td colspan='2'>Email Address : <?php echo $row['EmailAddress'] ?></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th colspan='3'>Billing Records</th>
                                            </thead>
                                            <thead>
                                                <th>Rates</th>
                                                <th>Months</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                                                    <td style="text-align:center;"><?php echo $row['Month'] ?></td>
                                                    <td style="text-align:right;">PHP <?php echo $row['total'] ?></td>
                                                </tr>
                                                <tr><td colspan='2'>Amount Pay</td><td style="text-align:right;">PHP <?php echo $row['pay'] ?></td></tr>
                                                <tr><td colspan='2'>Balance</td><td style="text-align:right;">PHP <?php echo $row['remain'] ?></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p>Scan here : </p>
                                    <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $row['QRCode'] ?>"/>
                                    <?php
                                }
                            }
                            catch(Exception $e)
                            {
                                echo $e->getMessage();
                            }
                            $dbh=null;
                            ?>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary printPage"> Print </button>
                    <button type="button" class="btn btn-outline-primary" onclick="CreatePDFfromHTML()"> Download </button>
                </div>
            </div>
         </div>
         <!-- Main content ends -->

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
   <script src="../assets/plugins/charts/echarts/js/echarts-all.js"></script>

   <!-- custom js -->
   <script type="text/javascript" src="../assets/js/main.min.js"></script>
   <script type="text/javascript" src="../assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="../assets/pages/elements.js"></script>
   <script src="../assets/js/menu.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
   <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
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

    $('.printPage').click(function(){
          $('#document').show();
             window.print();
             return false;
  });
  
  function CreatePDFfromHTML() {
    var HTML_Width = $("#document").width();
    var HTML_Height = $("#document").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#document")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('pt', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("receipt.pdf");
    });
}

    </script>
</body>

</html>
