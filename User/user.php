<?php
  session_start();

  if(!isset($_SESSION['username'])){
    header('location:../index.html');
  }
  include '../Database/dbcon.php';

  //$query = "Select * from freelancer";
  //$query_run = mysqli_query($con, $query);
  
  if(isset($_POST['search-button'])){
    $valueToSearch = $_POST['valueToSearch'];
    $query = "Select * from freelancer where gtitle like '%$valueToSearch%' OR username like '%$valueToSearch%'";
    $query_run = mysqli_query($con, $query);
  }else{
    $query = "Select * from freelancer";
    $query_run = mysqli_query($con, $query);
  }

  $check_gig = mysqli_num_rows($query_run);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Executives</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/userstyle.css" rel="stylesheet">

  <!-- Font Awesome CDN --> 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

  <script>
    $(document).ready(function(){
      $(".profile .profile_icon").click(function(){
			  $(this).parent().toggleClass("active");
			});
    });
  </script>

</head>

<body>
    
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
    <div class="container-fluid">
      <div class="row justify-content-center navgation">
        <div class="col-xl-10 d-flex align-items-center">
          <h1 class="logo"><a href="user.php">Execu<span>tives.</span></a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="search mr-auto" method="POST">
              <i class="fas fa-search"></i><input type="text" name="valueToSearch" id="user-gig" placeholder="Find Services" value="<?php if(isset($valueToSearch)){ echo $valueToSearch; } ?>">
              <input type="submit" name="search-button" value="Search" class="button"> 
              <div id="user-gig-list"></div> 
          </form> 
          <nav class="  nav-menu d-none d-lg-block">
            <ul>
              <li><a href="order.php">ORDERS</a></li>
              <div class="profile">
                <div class="profile_icon">
                  <?php 
                    $sql = "SELECT * FROM register WHERE email='".$_SESSION['email']."'";
                    $res = mysqli_query($con,$sql);

                    if(mysqli_num_rows($res)>0){
                      while($result = mysqli_fetch_array($res)){
                        if($result['img'] == NULL OR $result['img'] == '' OR $result['img'] == ' '){       
                          echo "<img src='../assets/img/default_profile_picture.jpg' alt=''>";
                        }
                        else{
                          echo "<img src='../assets/uploads/".$result['img']."'/>";
                        }
                      }
                    }
                  ?>
                </div>
                <div class="profile_dd">
                  <ul class="profile_ul">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="fredirect.php">Become a Seller</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                  </ul>
                </div>
              </div>
            </ul>
          </nav><!-- .nav-menu -->
        </div>
      </div>
    </div>
  </header><!-- End Header -->

  <div id="opt" class="fixed-top">
    <div class="container-fluid">
      <div class="row justify-content-center navgation">
        <div class="col-xl-10 d-flex align-items-center">  
          <div class="opt">
            <nav class="nav-menu">
                <ul>
                    <li><a href="#WorkDone">Graphics & Design</a></li>
                    <li><a href="freelancer.html">Digital Marketing</a></li>
                    <li><a href="gig.php">Writing & Translation</a></li>
                    <li><a href="freelancer.html">Video & Animation</a></li>
                    <li><a href="gig.php">Music & Audio</a></li>
                    <li><a href="gig.php">Programming & Tech</a></li>
                </ul>    
            </nav>
        </div>
        </div>
      </div>
    </div>        
</div>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container-fluid" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center navgation">
        <div class="col-xl-10">
          <div class="row">
            <?php
            if($check_gig){ 
              while($row = mysqli_fetch_array($query_run)){
                $gig_price = $row['gprice'];
                $gprice = number_format($gig_price);
            ?>
            <div class="col-md-3 mt-5">
              <div class="card">
                <div class="card-body">
                  <div class="profile-img1">
                    <?php echo "<a href='gigdescription.php?id=".$row['gid']."'><img src='../assets/uploads/".$row['gimg']."' class='card-img-top'/></a>";?> 
                  </div>
                  <div class="profile2">
                    <?php 
                      if($row['img'] == NULL OR $row['img'] == '' OR $row['img'] == ' '){ 
                        echo "<img src='../assets/img/default_profile_picture.jpg' alt=''/><a href='#'>".$row['username']."</a>"; 
                      }else{ 
                        echo "<img src='../assets/uploads/".$row['img']."'/><a href='' data-toggle='modal' data-target='#exampleModal?id=4'>".$row['username']."</a>"; 
                      } 
                    ?>
                  <!--<img src="assets/img/default_profile_picture.jpg" alt=""/><a href="">Prashant</a>-->  
                  </div>
                  <?php 
                    echo "<a href='gigdescription.php?id=".$row['gid']."'><p class='card-title'> ".$row['gtitle']." </p></a>";
                  ?>
                </div>
                <div class="card-body">
                <?php 
                    echo "<a href='gigdescription.php?id=".$row['gid']."'><h3 class='card-text'> ".$row['gdelivery']." </h3></a>";
                  ?>
                </div>
                <div class="card-footer text-right py-2">
                  <?php 
                    echo "<a href='gigdescription.php?id=".$row['gid']."'>Price: &nbsp; <i class='fas fa-rupee-sign'></i>".$gprice."</a>";
                  ?>
                </div>
              </div>
            </div>
            <?php   
                }
              }else{
                ?>
                  <h1>NO RECORDS FOUND</h1>
                <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php 
            if(isset($_GET['id'])){
              $id = $_GET['id'];

              echo $id;
            }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    <!-- ======= Footer ======= -->
    <footer id="footer">
      <div class="footer-top">
        <div class="container-fluid">
          <div class="row">
          <div class="col-md-3 col-sm-12 footer-links">
              <h4>Categories</h4>
              <ul>
                <li>
                  <a href="#">Graphics & Design</a>
                </li>
                <li>
                  <a href="#">Digital Marketing</a>
                </li>
                <li>
                  <a href="#">Writing & Translation</a>
                </li>
                <li>
                  <a href="#">Video & Animation</a>
                </li>
                <li>
                  <a href="#">Music & Audio</a>
                </li>
                <li>
                  <a href="#">Programming & Tech</a>
                </li>
              </ul>
            </div>

            <div class="col-md-3 col-sm-12 footer-links">
              <h4>Useful Links</h4>
              <ul>
                <li>
                  <a href="#">Home</a>
                </li>
                <li>
                  <a href="#">About us</a>
                </li>
                <li>
                  <a href="#">Services</a>
                </li>
                <li>
                  <a href="#">Terms of service</a>
                </li>
                <li>
                  <a href="#">Privacy policy</a>
                </li>
              </ul>
            </div>

            <div class="col-md-3 col-sm-12 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li>
                  <a href="#">Web Design</a>
                </li>
                <li>
                  <a href="#">Web Development</a>
                </li>
                <li>
                  <a href="#">Product Management</a>
                </li>
                <li>
                  <a href="#">Marketing</a>
                </li>
                <li>
                  <a href="#">Graphic Design</a>
                </li>
              </ul>
            </div>

            <div class="col-md-3 col-sm-12 footer-links">
              <h4>Community</h4>
              <ul>
                <li>
                  <a href="#">Events</a>
                </li>
                <li>
                  <a href="#">Blog</a>
                </li>
                <li>
                  <a href="#">Forum</a>
                </li>
                <li>
                  <a href="#">Community Standards</a>
                </li>
                <li>
                  <a href="#">Affiliates</a>
                </li>
              </ul>
            </div>

            <div class="col-md-3 col-sm-12 footer-links">
              <h4>About</h4>
              <ul>
                <li>
                  <a href="#">Careers</a>
                </li>
                <li>
                  <a href="#">Press & News</a>
                </li>
                <li>
                  <a href="#">Partnerships</a>
                </li>
                <li>
                  <a href="#">Privacy Policy</a>
                </li>
                <li>
                  <a href="#">Terms of Service</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom container-fluid d-flex pt-3">
        <div class="mr-md-auto text-center text-md-left">
          <div class="copyright">
            <h1 class="footer-logo">Executives.</h1>
            <p class="mr-auto">&copy; Executives. International Ltd. 2020</p>
          </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>
    </footer>
    <!-- End Footer -->

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="../assets/vendor/counterup/counterup.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/venobox/venobox.min.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>
<!--
<script>
  $(document).ready(function(){
    $('#user-gig').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
        $.ajax({
          url:"search.php",
          method:"POST",
          data:{query:query},
          success:function(data)
          {
            $('#user-gig-list').fadeIn();
            $('#user-gig-list').html(data);
          }
        });
      }else{
        $('#user-gig-list').fadeOut();
        $('#user-gig-list').html("");
      }
    });
    $(document).on('click','li',function(){
      $('#user-gig').val($(this).text());
      $('#user-gig-list').fadeOut();
    });
  });
</script>-->
