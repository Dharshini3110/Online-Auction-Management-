<?php
session_start();
include("dbconnect.php");
extract($_REQUEST);
$uname=$_SESSION['uname'];
$rdate=date("d-m-Y");

$q11=mysqli_query($connect,"select * from tt_customer where uname='$uname'");
$r11=mysqli_fetch_array($q11);

if($act=="ok")
{
$q4=mysqli_query($connect,"select * from tt_quote where id=$rid");
$r4=mysqli_fetch_array($q4);
$tailor=$r4['uname'];
$amt=$r4['amount'];

$commission=10;

$com_amt=($commission/100)*$amt;
$net_amt=$amt-$com_amt;

mysqli_query($connect,"update tt_product set post_st=3,bidder='$tailor',amount=$amt,order_date='$rdate',commission=$com_amt,net_amount=$net_amt where id=$pid");
mysqli_query($connect,"update tt_quote set select_order=1 where id=$rid");

$q44=mysqli_query($connect,"select * from tt_bidder where uname='$tailor'");
$r44=mysqli_fetch_array($q44);
$mob=$r44['mobile'];
$name=$r44['name'];

$mesage="Your bid is confirmed";
echo '<iframe src="http://iotcloud.co.in/testsms/sms.php?sms=emr&name='.$name.'&mess='.$mesage.'&mobile='.$mob.'" width="10" height="10" ></iframe>'; 
    $msg = "Bid is Confirmed to " . $name;
    ?>
<script language="javascript">
    setTimeout(function () {
        window.location.href="admin_order.php";
}, 5000);

</script>
<?php
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php include("title.php"); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header_area">
            <div class="main-header">
             <div class="header-bottom header-sticky">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                </div>
                <div class="header-left  d-flex f-right align-items-center">
                    <!-- Main-menu -->
                    <div class="main-menu f-right d-none d-lg-block">
                        <nav> 
                            <ul id="navigation">                                                                                                                                     
                            <li><a href="userhome.php">Home</a></li>
                                <li><a href="view_design.php">Products</a></li>
                                <li><a href="view_bid.php">Bidding</a></li>
								
								<li><a href="logout.php">Logout</a></li>
                                <!--<li><a href="blog.html">Blog</a>
                                    <ul class="submenu">
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="blog_details.html">Blog Details</a></li>
                                        <li><a href="elements.html">Elements</a></li>
                                    </ul>
                                </li>-->
                                
                            </ul>
                        </nav>
                    </div>
                    <!-- left Btn -->
                   <!-- <div class="header-right-btn f-right d-none d-lg-block  ml-30">
                        <a href="login_admin.php" class="header-btn">Admin</a>
                    </div>-->
                </div>          
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>

<!-- slider Area End-->
<!--?  Contact Area start  -->
<section class="contact-section">
    <div class="container">
        
         <h2 class="contact-title">Bidding</h2>
         <br>
         <span style="color:green"><?php echo $msg;?></span>
         <br>
         <div class="row">
            <div class="col-12">
               
            <?php
		  
		  $q2=mysqli_query($connect,"select * from tt_product where id=$pid");
			$r2=mysqli_fetch_array($q2);
			
			echo '<a href="'.$r2['file'].'" target="_blank"><img src="'.$r2['file'].'" width="100" height="100"></a>'; 
			
			$q3=mysqli_query($connect,"select * from tt_quote where post_id=$pid");
			$n3=mysqli_num_rows($q3);
			if($n3>0)
			{
			?>
          		<table class="table">
				<tr>
				<td>#</td>
				<td>Bidder</td>
				<td>Quote Amount</td>
				<td>Date / Time</td>
				<td>Select Order</td>
				</tr>
				<?php
				$i=0;
				while($r3=mysqli_fetch_array($q3))
				{
				$i++;
				?>
				<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $r3['uname']; ?></td>
				<td><?php echo "Rs. ".$r3['amount']; ?></td>
				<td><?php echo $r3['date_time']; ?></td>
				<td><?php 
				if($r3['select_order']=="1")
				{
				echo "Selected";
				}
				else
				{
                    echo "Waiting!..";
				}
				?></td>
				</tr>
				<?php
				}
				?>
				</table>
		  	<?php
			
			}
			else
			{
			echo "No Design";
			}
			?>
              
            </div>
           
			
			
        </div>
           
			
			
        </div>
    </div>
</section>
<!-- Contact Area End -->
</main>
<footer>
    <div class="footer-wrapper section-bg2 pl-100"  data-background="assets/img/gallery/footer-bg.png">
        <!-- Footer Start-->
        
        <!-- footer-bottom area -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="row align-items-center">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-right">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                 <?php include("title.php"); ?><a href="https://colorlib.com" target="_blank"></a>
                                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Footer End-->
          <!-- Map -->
        
    </div>
</footer>
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>
<!-- JS here -->

<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="./assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- Date Picker -->
<script src="./assets/js/gijgo.min.js"></script>
<!-- Nice-select, sticky -->
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="./assets/js/jquery.counterup.min.js"></script>
<script src="./assets/js/waypoints.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/hover-direction-snake.min.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>
</html>
