<?php
    session_start();
    require_once("resources/dbconfig.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>J-M Dormitory</title>
  <meta content="JM Dormitory Reservation System" name="description">
  <meta content="jm dormitory, dormitory, J-M Dormitory" name="keywords">

  <!-- Favicons -->
  <link href="assets/images/logo.png" rel="icon">
  <link href="assets/images/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Vendor CSS Files -->
  <link href="others/vendor/aos/aos.css" rel="stylesheet">
  <link href="others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="others/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="others/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="others/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="others/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="others/css/style.css" rel="stylesheet">
    <style>
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
            .img
            {
                object-fit:cover;
                width:  170px;
                height: 200px;
                float:center;
            }
            .top-left {
                  position: absolute;
                  top: 8px;
                  left: 16px;
                  color:#000000;
                }
            .bottom-left {
                  position: absolute;
                  bottom: 8px;
                  left: 16px;
                  color:#000000;
                }
    </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="/"><img src="assets/images/logo.png" width="50"/> JM Dormitory</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="/">Home</a></li>
          <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="nav-link scrollto" href="login.php">Login</a></li>
          <li><a class="getstarted scrollto" href="register.php">Create Account</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <div>
            <h1>JM Dormitory Online Reservation System</h1>
            <h2>For a more convenient approach to manage your dorm finances, Register Now! Experience the JM Dormitory Lifestyle. Everything you need, all right here.</h2>
            <a href="customer-login.php" class="download-btn"><i class="bx bxs-right-arrow-alt"></i> Customer Portal</a>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="others/img/building.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
          <h2>Features</h2>
          <p>We have many features that will cater to your needs! Provided with bookings, room reservations, billings and a transaction history to monitor all that is necessary.</p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>List of Available Rooms</h4>
                  <p>Multiple options of reserving one of the many different rooms to your liking. </p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Role Based Access System</h4>
                  <p>Utilizing a Role Based Access System for a well structured program, and preserve customer confidentiality and increase system efficiency.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-images"></i>
                  <h4>Room Gallery</h4>
                  <p>A gallery of room photos to showcase the beautiful rooms we offer!</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-shield"></i>
                  <h4>Security</h4>
                  <p>An email verification during your registration to ensure safety, along with a QR code to enhance security measures while entering and exiting the dorm!</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-atom"></i>
                  <h4>Transactions</h4>
                  <p>A network of transactions managed efficiently, and a transaction history to keep track of your payments!</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-id-card"></i>
                  <h4>Receipts</h4>
                  <p>For your safety, we have made online receipts possible to download or print to view your payments along with your QR code! </p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="others/img/Feature.PNG" class="img-fluid" alt="Sample Room" style="border:10px solid #0275d8;border-radius:20px 20px;">
          </div>
        </div>

      </div>
    </section><!-- End App Features Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Gallery</h2>
        </div>

      </div>

      <div class="container-fluid" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="text-center">Deluxe</h6>
                    <div class="gallery-slider swiper">
                        <div class="swiper-wrapper">
                            <?php
                            try
                            {
                                $sql = "Select a.Filename,a.Features,a.File,b.* from tblfiles a LEFT JOIN tblcategory b ON b.catID=a.catID WHERE b.Description='Deluxe'";
                                $stmt = $dbh->prepare($sql);
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach($data as $row)
                                {
                                    $imgUrl = "resources/files/".$row['File'];
                                    ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo $imgUrl ?>" class="gallery-lightbox" data-gall="gallery-carousel">
                                            <img src="<?php echo $imgUrl ?>" class="img" alt="">
                                            <div class="top-left"><?php echo $row['Filename'] ?></div>
                                            <div class="bottom-left"><small><?php echo $row['Features'] ?></small></div>
                                        </a>
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
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h6 class="text-center">Supreme</h6>
                    <div class="gallery-slider swiper">
                        <div class="swiper-wrapper">
                            <?php
                            try
                            {
                                $sql = "Select a.Filename,a.Features,a.File,b.* from tblfiles a LEFT JOIN tblcategory b ON b.catID=a.catID WHERE b.Description='Supreme'";
                                $stmt = $dbh->prepare($sql);
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach($data as $row)
                                {
                                    $imgUrl = "resources/files/".$row['File'];
                                    ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo $imgUrl ?>" class="gallery-lightbox" data-gall="gallery-carousel">
                                            <img src="<?php echo $imgUrl ?>" class="img" alt="">
                                            <div class="top-left"><?php echo $row['Filename'] ?></div>
                                            <div class="bottom-left"><small><?php echo $row['Features'] ?></small></div>
                                        </a>
                                    </div>
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
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
      </div>
    </section><!-- End Gallery Section -->
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>For further inquiries and concerns, do not hesitate to contact us. We will respond as soon as possible to attend to your needs</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 info">
                <i class="bx bx-map"></i>
                <h4>Address</h4>
                <p>Davao City,<br>Philippines, 8000</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-phone"></i>
                <h4>Call Us</h4>
                <p>+9331895735<br>+9127847567</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-envelope"></i>
                <h4>Email Us</h4>
                <p>jmdormitory2022@gmail.com</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-time-five"></i>
                <h4>Working Hours</h4>
                <p>Mon - Fri: 9AM to 5PM<br>Sunday: 9AM to 1PM</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form method="post" role="form" class="php-email-form" data-aos="fade-up" id="frmContact">
                <input type="hidden" name="action" value="inquire"/>
              <div class="form-group">
                <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
              </div>
              <div class="text-center"><button type="submit" id="btnSend">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="others/vendor/aos/aos.js"></script>
  <script src="others/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="others/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="others/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="others/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="others/js/main.js"></script>
  <script>
      $('#btnSend').on('click',function(evt)
      {
          evt.preventDefault();
          var data = $('#frmContact').serialize();
          $.ajax({
              url:"resources/connection.php",method:"POST",
              data:data,
              success:function(data)
              {
                  if(data==="success")
                  {
                      alert("Great! Successfully sent");
                      $('#frmContact')[0].reset();
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