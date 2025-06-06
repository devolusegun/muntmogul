<?php
session_start();
require 'config/config.php'; // Database connection

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        // Fetch user from database
        $stmt = $pdo->prepare("SELECT * FROM crypticusers WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user["is_verified"] == 0) {
                $error = "Please verify your email before logging in.";
            } elseif (password_verify($password, $user["password"])) {
                // Store essential user details in session
                $_SESSION["user"] = [
                    "id" => $user["id"],
                    "username" => $user["username"],
                    "email" => $user["email"],
                    "first_name" => $user["first_name"],
                    "last_name" => $user["last_name"]
                ];

                // Record user's latest login time and IP
                $update = $pdo->prepare("UPDATE crypticusers SET last_login = NOW(), last_ip = ? WHERE id = ?");
                $update->execute([$_SERVER["REMOTE_ADDR"], $user["id"]]);

                header("Location: dashboard"); // Redirect to dashboard
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Savehyip" />
    <meta name="keywords" content="Savehyip" />
    <meta name="author" content="" />
    <meta name="MobileOptimized" content="320" />

    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="css/flaticon.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/nice-select.css" />
    <link rel="stylesheet" type="text/css" href="css/datatables.css" />
	<link rel="stylesheet" type="text/css" href="css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <!--favicon-->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
</head>

<body>

    <!-- preloader Start -->
    <!-- preloader Start -->
    <div id="preloader">
        <div id="status">
            <img src="images/loader.gif" id="preloader_image" alt="loader">
        </div>
    </div>
    <div class="cursor"></div>
    <!-- Top Scroll Start -->
    <a href="javascript:" id="return-to-top"> <i class="fas fa-angle-double-up"></i></a>
    <!-- Top Scroll End -->
     <!-- cp navi wrapper Start -->
     <nav class="cd-dropdown d-block d-sm-block d-md-block d-lg-none d-xl-none">
        <h2><a href="index.html"> MuntMogul </a></h2>
        <a href="#0" class="cd-close">Close</a>
         <ul class="cd-dropdown-content">
            <li>
                <form class="cd-search">
                    <input type="search" placeholder="Search...">
                </form>
            </li> 
            <li class="has-children">
                <a href="#">index</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="index.html">index I</a></li>
                    <li><a href="index2.html">index II</a></li>
                    <li><a href="index3.html">index III</a></li>
                </ul>
            </li>
            <li><a href="about_us.html"> about us </a></li>
            <!--<li><a href="investment.html"> investment plan </a></li>-->
			<li><a href="faq.html"> FAQ </a></li>
			<li class="has-children">
              <a href="#">dashboard</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                      <li>
                      <a href="all_transactions.html">all transactions</a>
					</li>
				   <li>
                      <a href="change_password.html">change password</a>
					</li>
					<li>
                      <a href="deposited">deposit history</a>
                  </li>
					<li>
                      <a href="deposit_list.html">deposit list</a>
                  </li>
					<li>
                      <a href="make_deposit.html">make deposit</a>
                  </li> 	
					<li>
                      <a href="my_account.html">my account</a>
                  </li> 	
					<li>
                      <a href="paymentrequest">payment request</a>
                  </li> 
					<li>
                      <a href="tickets">tickets</a>
                  </li> 
				<li>
                      <a href="viewprofile">view profile</a>
                  </li> 									
              </ul>
             </li>
            <!--<li class="has-children">
                <a href="#">blog</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="blog_category.html">blog category</a></li>
                    <li><a href="blog_single.html">blog single</a></li>
                </ul>
            </li>-->   
            <li><a href="contact_us.html"> contact us </a></li>
            <!--<li><a href="login.html"> login </a></li>-->
            <li><a href="register"> register </a></li>
        </ul>
        <!-- .cd-dropdown-content -->
    </nav>
    <div class="cp_navi_main_wrapper inner_header_wrapper float_left">
        <div class="container-fluid">
            <div class="cp_logo_wrapper">
                <a href="index.html">
                    <img src="images/logo2.png" alt="logo">
                </a>
            </div>
            <!-- mobile menu area start -->
            <header class="mobail_menu d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cd-dropdown-wrapper">
                                <a class="house_toggle inner_toggle" href="#0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.177 31.177" style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve" width="25px" height="25px">
                                        <g>
                                            <g>
                                                <path class="menubar" d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z" fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar" d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z" fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar" d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z" fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar" d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z" fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar" d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z" fill="#004165" />
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                                <!-- .cd-dropdown -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- .cd-dropdown-wrapper -->
            </header>
            <div class="top_header_right_wrapper">
                <!--<p><i class="flaticon-phone-contact"></i> (+91) 123 123 4567</p>-->
                <div class="header_btn">
                    <ul>
                        <li>
                            <a href="register"> register </a> </li>
                        <!--<li>
                            <a href="login.html"> login </a> </li>-->
                    </ul>

                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper">
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                     <ul class="main_nav_ul">             
                        <!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation active_class">index <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                                <li class="parent">
                                    <a href="index.html"><i class="fas fa-caret-right"></i>index I</a>
                                </li>
                                <li class="parent">
                                    <a href="index2.html"><i class="fas fa-caret-right"></i>index II</a>
                                </li>
								<li class="parent">
                                    <a href="index3.html"><i class="fas fa-caret-right"></i>index III</a>
                                </li>							
                            </ul>
                        </li>-->  
                        <!--<li><a href="about_us.html" class="gc_main_navigation">about us</a></li>-->
                        <!--<li><a href="investment.html" class="gc_main_navigation">investment plan</a></li>-->  
						<!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">pages <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                                <li class="parent">
                                    <a href="faq.html"><i class="fas fa-caret-right"></i>FAQ</a>
                                </li>
                                <li class="parent">
                                    <a href="login.html"><i class="fas fa-caret-right"></i>login</a>
                                </li>
								<li class="parent">
                                    <a href="register.html"><i class="fas fa-caret-right"></i>register</a>
                                </li>  								
                            </ul>
                        </li>-->   
						<!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">dashboard <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                              
                                <li class="parent">
                                    <a href="#"><i class="fas fa-caret-right"></i>my account<span><i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                        <li>
                                            <a href="my_account.html"> <i class="fas fa-caret-right"></i>my account  </a>
                                        </li>
                                        <li>
                                            <a href="view_profile.html"> <i class="fas fa-caret-right"></i> my profile</a>
                                        </li>
                                        <li>
                                            <a href="email_notification.html"><i class="fas fa-caret-right"></i>email notification </a>
                                        </li>
                                        <li>
                                            <a href="change_password.html"><i class="fas fa-caret-right"></i>change password</a>
                                        </li>
                                        <li>
                                            <a href="change_pin.html"><i class="fas fa-caret-right"></i>change pin</a>
                                        </li>
                                     
                                    </ul>
                                </li>-->
                                <!--<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>finance<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                         <li>
                                            <a href="make_deposit.html"> <i class="fas fa-caret-right"></i>make deposit</a>
                                        </li>
                                        <li>
                                            <a href="deposit_list.html"> <i class="fas fa-caret-right"></i> deposit lists</a>
                                        </li>
                                        <li>
                                            <a href="payment_request.html"><i class="fas fa-caret-right"></i>payment request</a>
                                        </li>
                                        <li>
                                            <a href="exchange_money.html"><i class="fas fa-caret-right"></i>exchange money</a>
                                        </li>
                                        <li>
                                            <a href="transfer_fund.html"><i class="fas fa-caret-right"></i>fund transfer</a>
                                        </li>
                                     
                                    </ul>
                                </li>-->
								<!--<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>reports<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                         <li>
                                            <a href="all_transactions.html"> <i class="fas fa-caret-right"></i>all transactions</a>
                                        </li>
                                        <li>
                                            <a href="deposit_history.html"> <i class="fas fa-caret-right"></i> deposit history</a>
                                        </li>
                                        <li>
                                            <a href="pending_history.html"><i class="fas fa-caret-right"></i>pending history</a>
                                        </li>
                                        <li>
                                            <a href="exchange_history.html"><i class="fas fa-caret-right"></i>exchange history</a>
                                        </li>
                                        <li>
                                            <a href="earnings_history.html"><i class="fas fa-caret-right"></i>earning history</a>
                                        </li>
                                     
                                    </ul>
                                </li>-->
								<!--<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>referrals<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                         <li>
                                            <a href="referrals.html"> <i class="fas fa-caret-right"></i>my referrals</a>
                                        </li>
                                        <li>
                                            <a href="banners.html"> <i class="fas fa-caret-right"></i> promotionals banners</a>
                                        </li>
                                        <li>
                                            <a href="referral_earnings.html"><i class="fas fa-caret-right"></i>referral earnings</a>
                                        </li>
                                      
                                    </ul>
                                </li>
								<li class="parent">
                                    <a href="tickets.html"><i class="fas fa-caret-right"></i>view tickets</a></li>
                            </ul>
                        </li>-->						
                        <!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">blog <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                                <li class="parent">
                                    <a href="blog_category.html"><i class="fas fa-caret-right"></i>blog category</a>
                                </li>-->
                                <!--<li class="parent">
                                    <a href="blog_single.html"><i class="fas fa-caret-right"></i> blog single</a>
                                </li>   
                            </ul>
                        </li>-->   
                        <li><a  class="gc_main_navigation" href="index.html"><i class="fa fa-home"></i> Home</a></li> 
                    </ul>
                </div>
                <!-- mainmenu end -->
            </div>
        </div>
    </div>

    <!-- navi wrapper End -->
    <!-- inner header wrapper start -->
    <div class="page_title_section">

        <div class="page_header">
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-md-9 col-12 col-sm-8">

                        <h1>login</h1>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-4">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="https://muntmogul.com"> Home </a>&nbsp; / &nbsp; </li>
                                <li>login</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- inner header wrapper end -->

    <!-- Login Wrapper Start -->
    <div class="login_wrapper fixed_portion float_left">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="login_top_box float_left">
                        <div class="login_banner_wrapper">
                            <img src="images/logo2.png" alt="logo">
                            <div class="about_btn  facebook_wrap float_left">

                                <a href="#">login with facebook <i class="fab fa-facebook-f"></i></a>

                            </div>
                            <div class="about_btn google_wrap float_left">

                                <a href="#">login with google <i class="fab fa-google-g"></i></a>

                            </div>
                            <div class="jp_regis_center_tag_wrapper jb_register_red_or">
                                <h1>OR</h1>
                            </div>
                        </div>
                        <div class="login_form_wrapper">
                            <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd"><h3>Login to Enter</h3></div>
                            <?php if (isset($_SESSION['message'])): ?>
                                <div class="alert alert-success text-center">
                                    <?php
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']); // Clear it after showing once
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Display error messages dynamically -->
                            <?php if (!empty($error)): ?>
                                <p style="color:red;"><?php echo $error; ?></p>
                            <?php endif; ?>

                            <form method="POST" action="login">
                                <div class="form-group icon_form">
                                    <input type="email" class="form-control require" name="email" placeholder="Email Address*" required>
                                </div>
                                <div class="form-group icon_form">
                                    <input type="password" class="form-control require" name="password" placeholder="Password *" required>
                                </div>
                                <div class="login_remember_box">
                                    <label class="control control--checkbox">Remember me
                                        <input type="checkbox">
                                        <span class="control__indicator"></span>
                                    </label>
                                    <a href="#" class="forget_password">Forgot Password</a>
                                </div>
                                <div class="about_btn login_btn float_left">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>

                            <div class="dont_have_account float_left">
                                <p>Don't have an account? <a href="register">Sign up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login wrapper end -->

    <!-- payments wrapper start -->
    <!--<div class="payments_wrapper float_left">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="sv_heading_wraper half_section_headign">
                        <h4>Payment Methods</h4>
                        <h3>Accepted Payment Method</h3>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="payment_slider_wrapper">
                        <div class="owl-carousel owl-theme">
                            <div class="item">

                                <div class="partner_img_wrapper float_left">
                                    <img src="images/partner1.png" class="img-responsive" alt="img">
                                </div>

                            </div>
                            <div class="item">

                                <div class="partner_img_wrapper float_left">
                                    <img src="images/partner2.png" class="img-responsive" alt="img">
                                </div>

                            </div>
                            <div class="item">

                                <div class="partner_img_wrapper float_left">
                                    <img src="images/partner3.png" class="img-responsive" alt="img">
                                </div>

                            </div>
                            <div class="item">

                                <div class="partner_img_wrapper float_left">
                                    <img src="images/partner4.png" class="img-responsive" alt="img">
                                </div>

                            </div>
                            <div class="item">

                                <div class="partner_img_wrapper float_left">
                                    <img src="images/partner2.png" class="img-responsive" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!-- payments wrapper end -->

    <!-- footer section start-->
    <div class="footer_main_wrapper float_left">

        <div class="container">

            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                    <div class="wrapper_second_about">
                        <div class="wrapper_first_image">
                            <a href="index.html"><img src="images/logo.png" class="img-responsive" alt="logo" /></a>
                        </div>
                        <p>We are a full financial Digital tool .... need.</p>
                        <div class="counter-section">
                            <div class="ft_about_icon float_left">
                                <i class="flaticon-user"></i>
                                <div class="ft_abt_text_wrapper">
                                    <p class="timer"> 62236</p>
                                    <h4>total member</h4>
                                </div>

                            </div>
                            <div class="ft_about_icon float_left">
                                <i class="flaticon-money-bag"></i>
                                <div class="ft_abt_text_wrapper">
                                    <p class="timer">27236</p>
                                    <h4>total deposited</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-12 col-sm-4">
                    <div class="wrapper_second_useful">
                        <h4>useful links </h4>

                        <ul>
                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>About us</a>
                            </li>-->

                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>contact </a>
                            </li>-->
                            <li><a href="#"><i class="fa fa-angle-right"></i>services</a>
                            </li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>FAQ </a>
                            </li>
                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>news</a> </li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>blog</a> </li>-->
                        </ul>

                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12 col-sm-4">
                    <div class="wrapper_second_useful wrapper_second_links">

                        <ul>
                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>sitemap</a>-->
                            </li>
                            
                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>awards </a>
                            </li>-->
                            <!--<li><a href="#"><i class="fa fa-angle-right"></i>tstimonials</a>
                            </li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>career</a> </li>-->
                        </ul>

                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                    <div class="wrapper_second_useful wrapper_second_useful_2">
                        <h4>contact us</h4>

                        <ul>
                            <!--<li>
                                <h1>+800 568 322</h1></li>-->
                            <li><a href="#"><i class="flaticon-mail"></i>save@muntmogul.com</a>
                            </li>
                            <li><a href="#"><i class="flaticon-language"></i>www.muntmogul.com</a>
                            </li>

                            <li><i class="flaticon-placeholder"></i>110, B Street Kalani Bagh Dewas, Madhya Pradesh, INDIA #455001
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="copyright_wrapper float_left">
                        <div class="copyright">
                            <p>Copyright <i class="far fa-copyright"></i> 2025 <a href="index.html"> MuntMogul</a>. all right reserved - design by <a href="index.html">7evenSpirits</a></p>
                        </div>
                        <div class="social_link_foter">

                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- footer section end-->

    <!-- JS Files -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/jquery.menu-aim.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.countTo.js"></script>
	<script src="js/dropify.min.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
	<script src="js/datatables.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/calculator.js"></script>
    <script src="js/custom.js"></script>
    <!-- custom js-->

</body>

</html>
