<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
}

$stmt = $pdo->prepare("SELECT first_name, last_name, email, country, created_at, last_login, last_ip, btc_balance FROM crypticusers WHERE id = ?");
$stmt->execute([$_SESSION["user"]["id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
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
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="MuntMogul" />
    <meta name="keywords" content="MuntMogul" />
    <meta name="author" content="" />
    <meta name="MobileOptimized" content="320" />
    <!--Template style -->
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="css/flaticon2.css" />
	<link rel="stylesheet" type="text/css" href="css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="css/nice-select.css" />
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="css/datatables.css" />
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
	 <!--favicon-->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
</head>
<!-- color picker start -->

<body>
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
        <h2><a href="index.html"> welcome </a></h2>
        <a href="#0" class="cd-close">Close</a>
        <ul class="cd-dropdown-content">
            <!--<li>
                <form class="cd-search">
                    <input type="search" placeholder="Search...">
                </form>
            </li>--> 
            <!--<li class="has-children">
                <a href="#">index</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="index.html">index I</a></li>
                    <li><a href="index2.html">index II</a></li>
                    <li><a href="index3.html">index III</a></li>
                </ul>
            </li>-->
            <li><h1>hi, <?php echo $_SESSION["user"]; ?>!</h1></li>
            <!--<li><a href="investment.html"> investment plan </a></li>-->
			<!--<li><a href="faq.html"> FAQ </a></li>-->
			<li class="has-children">
              <a href="#">dashboard</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="#"></a></li>
				   <li> <a href="changepassword">change password</a></li>
					<!--<li><a href="change_pin.html">change pin</a></li>-->
					<li><a href="deposited">deposit history</a></li>
					<!--<li><a href="deposit_list.html">deposit list</a></li>-->
					<li><a href="earnings">earnings history</a></li>
					<!--<li> <a href="email_notification.html">email notification</a></li>   
					<li><a href="exchange_history.html">exchange history</a></li> 
					<li><a href="exchange_money.html">exchange money</a></li> -->
					<li><a href="make_deposit">make deposit</a></li> 	
					<!--<li> <a href="my_account.html">my account</a> </li> 	-->
					<!--<li><a href="payment_request.html">payment request</a></li> 	
					<li><a href="pending_history.html">pending history</a> </li> 	
					<li> <a href="referral_earnings.html">referral earnings</a></li> 	
					<li> <a href="referrals.html">referrals</a></li> -->
					<li><a href="tickets.html">tickets</a> </li> 	
					<!--<li><a href="transfer_fund.html">transfer fund</a> </li>-->
				    <li><a href="view_profile.html">view profile</a></li> 									
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
            <!--<li><a href="contact_us.html"> contact us </a></li>
            <li><a href="login.html"> login </a></li>
            <li><a href="register.html"> register </a></li>-->
        </ul>
        <!-- .cd-dropdown-content -->
    </nav>
    <!-- nav end-->

	<div class="cp_navi_main_wrapper inner_header_wrapper dashboard_header_middle float_left">
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
                       <div class="col-lg-12 col-md-12 col-sm-12 col-12">
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

            <div class="top_header_right_wrapper dashboard_right_Wrapper">
				<div class="crm_message_dropbox_wrapper crm_notify_dropbox_wrapper">
                    <div class="nice-select budge_noti_wrapper" tabindex="0"> <span class="current"><i class="flaticon-notification"></i></span>
                        <div class="budge_noti"></div>
                        <ul class="list">
                            <li><a href="#">2 New Messages</a></li>
                            <li>
                                <div class="crm_mess_main_box_wrapper">
                                    <div class="crm_mess_img_wrapper">
                                        <img src="images/mess1.jpg" alt="img">
                                    </div>
                                    <div class="crm_mess_img_cont_wrapper">
                                        <h4>Mr.Farhan <span>01:30PM</span></h4>
                                        <p>I'm Leaving early</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="crm_mess_main_box_wrapper">
                                    <div class="crm_mess_img_wrapper">
                                        <img src="images/mess1.jpg" alt="img">
                                    </div>
                                    <div class="crm_mess_img_cont_wrapper">
                                        <h4>Mr.ajay <span>01:30PM</span></h4>
                                        <p>I'm Leaving early</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="crm_mess_main_box_wrapper">
                                    <div class="crm_mess_img_wrapper">
                                        <img src="images/mess1.jpg" alt="img">
                                    </div>
                                    <div class="crm_mess_img_cont_wrapper">
                                        <h4>Mr.akshay <span>01:30PM</span></h4>
                                        <p>I'm Leaving early</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="crm_mess_main_box_wrapper">
                                    <div class="crm_mess_img_wrapper">
                                        <img src="images/mess1.jpg" alt="img">
                                    </div>
                                    <div class="crm_mess_img_cont_wrapper">
                                        <h4>Mr.john <span>01:30PM</span></h4>
                                        <p>I'm Leaving early</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="crm_mess_all_main_box_wrapper">
                                    <p><a href="#">See All</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="crm_profile_dropbox_wrapper">
                    <div class="nice-select" tabindex="0"> <span class="current"><img src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/avatar.png'; ?>" 
                            alt="User's Thumbnail" width="50" height="50" style="border-radius: 50%;"><?php echo $_SESSION["user"]["username"]; ?> <span class="hidden_xs_content"></span></span>
                        <ul class="list">
                            <li><a href="viewprofile"><i class="flaticon-profile"></i> Profile</a></li>
                            <!--<li><a href="#"><i class="flaticon-purse"></i>Account Balance</a></li>
                            <li><a href="#"><i class="flaticon-file"></i> My Task</a></li>
                            <li><a href="#"><i class="flaticon-calendar"></i> My Calender</a></li>
                            <li><a href="#"><i class="flaticon-envelope"></i> Inbox</a></li>
                            <li><a href="#"><i class="flaticon-settings"></i> Setting</a></li>
                            <li><a href="#"><i class="flaticon-help"></i> Support</a></li>
                            <li><a href="#"><i class="flaticon-padlock"></i> Lock Screen</a></li>-->
                            <li><a href="logout"><i class="flaticon-turn-off"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper dashboard_header">
                <!-- mainmenu start -->
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
                        <li><!--<h4>hi, </h4>--></li>
                        <!--<li><a href="investment.html" class="gc_main_navigation">investment plan</a></li> -->
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
						<li class="has-mega gc_main_navigation"><a class=""> <i class=""></i></a>
                            <!--
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
                                </li>
                                <li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>finance<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                         <li>
                                            <a href="make_deposit.html"> <i class="fas fa-caret-right"></i>Withdraw</a>
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
                                            <a href="transfer_fund.html"><i class="fas fa-caret-right"></i>Deposit</a>
                                        </li>
                                     
                                    </ul>
                                </li>
								<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>Transactions<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                         <li>
                                            <a href="all_transactions.html"> <i class="fas fa-caret-right"></i>all transactions</a>
                                        </li>
                                        <li>
                                            <a href="deposit_history.html"> <i class="fas fa-caret-right"></i>deposit history</a>
                                        </li>
                                        <li>
                                            <a href="pending_history.html"><i class="fas fa-caret-right"></i>withdrawal history</a>
                                        </li>
                                        <li>
                                            <a href="exchange_history.html"><i class="fas fa-caret-right"></i>exchange history</a>
                                        </li>
                                        <li>
                                            <a href="earnings_history.html"><i class="fas fa-caret-right"></i>earning history</a>
                                        </li>
                                     
                                    </ul>
                                </li>
								<li class="parent">
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
                            -->
                        </li>						
						    						
                        <!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">blog <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                                <li class="parent">
                                    <a href="blog_category.html"><i class="fas fa-caret-right"></i>blog category</a>
                                </li>
                                <li class="parent">
                                    <a href="blog_single.html"><i class="fas fa-caret-right"></i> blog single</a>
                                </li>                   
                            </ul>
                        </li>     
                        <li><a href="contact_us.html" class="gc_main_navigation">contact us</a></li>-->
                    </ul>
                </div>
                <!-- mainmenu end -->
            </div>
        </div>
    </div>

    <!-- navi wrapper End -->
    <!-- inner header wrapper start -->
    <div class="page_title_section dashboard_title">

        <div class="page_header">
            <div class="container">
                <div class="row">

                    <div class="col-xl-9 col-lg-7 col-md-7 col-12 col-sm-7">

                        <h1>My Account </h1>
                    </div>
                    <div class="col-xl-3 col-lg-5 col-md-5 col-12 col-sm-5">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="#"> Home </a>&nbsp; / &nbsp; </li>
                                <li>My Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- inner header wrapper end -->

	    <!-- side menus start -->
        <div class="l-sidebar">
            <div class="l-sidebar__content">
                <nav class="c-menu js-menu" id="mynavi">
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="viewprofile"><i class="flaticon-profile"></i></a>
                                <ul class="crm_hover_menu">
                                    <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a>
                                    </li>-->
                                    <li><a href="viewprofile"><i class="fa fa-circle"></i> my profile</a>
                                    </li>
                                    <li><a href="changepassword"><i class="fa fa-circle"></i>change password</a>
                                    </li>
                                    <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a>
                                    </li>
									<!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a>
                                    </li>-->
                                </ul>
                            </div>
                        </li>
                        <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                            <a href="view_profile.html">
                                <div class="c-menu-item__title"><span>my account</span><i class="no_badge">3</i>
                                </div>
                            </a>
                            <ul>
                                 <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a>
                                 </li>-->
                                 <li><a href="viewprofile"><i class="fa fa-circle"></i> my profile</a>
                                 </li>                      
                                 <li><a href="changepassword"><i class="fa fa-circle"></i>change password</a>
                                 </li>
                                 <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a>
                                 </li>
								<!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a></li>-->
                            </ul>
                        </li>
                    </ul>
                    
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="#"><i class="flaticon-progress-report"></i></a>
                            </div>
                        </li>
                        <li class="c-menu__item crm_navi_icon_cont">
                            <a href="javascript:void(0);" onclick="openDepositModal()">
                                <div class="c-menu-item__title">Deposit Funds</div>
                            </a>
                        </li>
                    </ul>
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="make_deposit.html"><i class="flaticon-settings"></i></a></div>
                        </li>
                        <li class="c-menu__item crm_navi_icon_cont">
                            <a href="make_deposit.html">
                                <div class="c-menu-item__title">choose a plan </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="deposit_upload.php"><i class="flaticon-movie-tickets"></i></a>
                                <ul class="crm_hover_menu">
                                    <li><a href="depositupload.php"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                                    <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a> </li>
                                    <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i> earning history</a></li>-->
                                    <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                                    <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a> </li>-->
                                </ul>
                            </div>
                        </li>
                        <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                            <a href="depositupload">
                                <div class="c-menu-item__title"><span>finances</span><i class="no_badge">3</i>
                                </div>
                            </a>
                            <ul>
                                <li><a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a>
                                </li>
                                <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a>
                                </li>
                                <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i>earning history</a>
                                </li>-->
                                <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a>
                                </li>
                                <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a>
                                </li>-->
                            </ul>
                        </li>
                    </ul>
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="investment.html"><i class="flaticon-file"></i></a>
                            </div>
                        </li>
                        <li class="c-menu__item crm_navi_icon_cont">
                            <a href="investment">
                                <div class="c-menu-item__title">view plans</div>
                            </a>
                        </li>
                    </ul>
                    <ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="tickets"><i class="flaticon-help"></i></a>
                                <ul class="crm_hover_menu">
                                    <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a></li>-->
                                    <li><a href="tickets"><i class="fa fa-circle"></i>support</a></li>
									<!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
									 <li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a></li>
									 <li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a></li>-->
                                </ul>
                            </div>
                        </li>
                        <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                            <a href="tickets">
                                <div class="c-menu-item__title"><span>Help</span><i class="no_badge purple">1</i>
                                </div>
                            </a>
                            <ul>
                              <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a>
                                    </li>-->
                                    <li><a href="tickets"><i class="fa fa-circle"></i>support</a></li>
									 <!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a>
                                    </li>
									 <li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a>
                                    </li>
									 <li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a>
                                    </li>-->
                            </ul>
                        </li>
                    </ul>
					  <!--<ul class="u-list crm_drop_second_ul">
                        <li class="crm_navi_icon">
                            <div class="c-menu__item__inner"><a href="make_deposit.html"><i class="flaticon-profile"></i></a>
                            </div>
                        </li>
                        <li class="c-menu__item crm_navi_icon_cont">
                            <a href="make_deposit.html">
                                <div class="c-menu-item__title">deposit</div>
                            </a>
                        </li>
                    </ul>-->   
                </nav>
            </div>
        </div>
        <!-- side menus end -->

        <!-- Main section Start -->
         <div class="l-main">         
            <!--  my account wrapper start -->
            <div class="account_top_information">
                <div class="account_overlay"></div>
                <div class="useriimg"><img src="images/user.png" alt="users"></div>
                <div class="userdet uderid">
                    <h3><?php echo htmlspecialchars($user["first_name"] . " " . $user["last_name"]); ?></h3>

                    <dl class="userdescc">
                        <dt>Registration Date</dt>
                        <dd>: &nbsp; <?php echo $user["created_at"]; ?></dd>
                        <dt>Last Login</dt>
                        <dd>: &nbsp; <?php echo $user["last_login"]; ?></dd>
                        <!--<dt>Current Login</dt>
                        <dd>: &nbsp; Jul-06-2019 02:47:23</dd>-->
                        <dt>Last Access IP</dt>
                        <dd>: &nbsp; <?php echo $user["last_ip"]; ?> </dd>
                        <dt>Current IP</dt>
                        <dd>: &nbsp; <?php echo $_SERVER["REMOTE_ADDR"]; ?> </dd>

                    </dl>

                </div>

                <div class="userdet user_transcation">
                    <h3>Available Balance</h3>
                    <dl class="userdescc">
                        <dt>Bitcoin</dt>
                        <dd>:&nbsp;&nbsp;₿ <?php echo number_format($user["bitcoin_balance"], 8); ?></dd>
                        <dt>Ethereum</dt>
                        <dd>:&nbsp;&nbsp;Ξ <?php echo number_format($user["ethereum_balance"], 8); ?></dd>
                        <dt>Litecoin</dt>
                        <dd>:&nbsp;&nbsp;Ł <?php echo number_format($user["litecoin_balance"], 8); ?></dd>
                        <dt>Dogecoin</dt>
                        <dd>:&nbsp;&nbsp;Ð <?php echo number_format($user["dogecoin_balance"], 8); ?></dd>
                    </dl>
                </div>
            </div>
            <!--  my account wrapper end -->

            <!--  account wrapper start -->
            <div class="account_wrapper float_left">

                <div class="row">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="sv_heading_wraper">

                            <h3>my account</h3>

                        </div>
                        <!--<div class="payment_gateway_wrapper">
                            <select>
                                <option selected>choose payment gateway</option>
                                <option value="1">paypal</option>
                                <option value="2">bitcoin</option>
                            </select>
                        </div>-->
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <div class="investment_box_wrapper color_1 float_left">
                            <a>
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>deposits</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                        <tbody>
                                            <tr>
                                                <td class="invest_td1">Total Deposit:</td>
                                                <td class="invest_td1"> <span id="totalDeposit">$0.00 USD</span></td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">New Deposit:</td>
                                                <td class="invest_td1"><span id="newDeposit">$0.00 USD</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <div class="investment_box_wrapper color_2 float_left">
                            <a>
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>payouts</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                        <tbody>
                                            <tr>
                                                <td class="invest_td1">total payouts:</td>
                                                <td class="invest_td1"> <span id="totalPayouts">$0.00 USD</span></td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">pending payouts:</td>
                                                <td class="invest_td1"><span id="pendingPayouts">$0.00 USD</span></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <div class="investment_box_wrapper color_3 float_left">
                            <a>
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>earnings</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                    <tbody>
                                        <tr>
                                            <td class="invest_td1">Interest Today</td>
                                            <td class="invest_td1">: <span id="todayInterest">$0.00 USD</span></td>
                                        </tr>
                                        <tr>
                                            <td class="invest_td1">This Week</td>
                                            <td class="invest_td1">: <span id="weekInterest">$0.00 USD</span></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <!--<div class="investment_box_wrapper color_4 float_left">
                            <a href="#">
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>earnings</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                        <tbody>
                                            <tr>
                                                <td class="invest_td1">interest today</td>
                                                <td class="invest_td1"> : $0.00 USD</td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">interest this week</td>
                                                <td class="invest_td1">: $0.00 USD</td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">interest this month</td>
                                                <td class="invest_td1">: $0.00 USD</td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">total earnings</td>
                                                <td class="invest_td1">: $192.00 USD</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>-->
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <!--<div class="investment_box_wrapper color_5 float_left">
                            <a href="#">
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>referral</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                        <tbody>
                                            <tr>
                                                <td class="invest_td1">interest today</td>
                                                <td class="invest_td1"> : 11 nos</td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">interest this week</td>
                                                <td class="invest_td1">: nos</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>-->
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                        <!--<div class="investment_box_wrapper color_6 float_left">
                            <a href="#">
                                <div class="investment_icon_wrapper float_left">
                                    <i class="far fa-money-bill-alt"></i>
                                    <h1>sampal</h1>
                                </div>

                                <div class="invest_details float_left">
                                    <table class="invest_table">
                                        <tbody>
                                            <tr>
                                                <td class="invest_td1">interest today</td>
                                                <td class="invest_td1"> : 11 nos</td>
                                            </tr>
                                            <tr>
                                                <td class="invest_td1">interest this week</td>
                                                <td class="invest_td1">: nos</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>-->
                    </div>
                </div>
            </div>
            <!--  account wrapper end -->
            <!--  transactions wrapper start -->
            <div class="last_transaction_wrapper float_left">

                <div class="row">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="sv_heading_wraper">

                            <h4>LAST 5 TRANSACTIONS</h4>

                        </div>
                    </div>
                    <div class="crm_customer_table_main_wrapper float_left">
                        <div class="crm_ct_search_wrapper">
                            <div class="crm_ct_search_bottom_cont_Wrapper">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="myTable table datatables cs-table crm_customer_table_inner_Wrapper">
                                <thead>
                                    <tr>
                                        <th class="width_table1">transaction ID</th>
                                        <th class="width_table1">amount ($)</th>
                                        <th class="width_table1">description</th>
                                        <th class="width_table1">payment mode</th>
                                        <th class="width_table1">date</th>
                                        <th class="width_table1">options</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>COMM1004411</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">1000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">03/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>MMNT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>UXINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>AWNT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>OWNT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>UINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>YYNT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">payza</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>TQNT1570066</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">22000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Bitcoin</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/07/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>DINT2676563</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">1000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">payza</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">20/08/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>EXCR1004425</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">4000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Interest Earning for investment</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">PerfectMoney</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">28/08/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>EXCS1004424</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">19000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">payza</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">2/09/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>EQCS1004424</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">3000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Fund Received to Paypal</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">OKpay</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">2/09/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>COMM1004411</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">5000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">OKpay</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">04/09/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                    <tr class="background_white">

                                        <td>
                                            <div class="media cs-media">

                                                <div class="media-body">
                                                    <h5>KQM1004411</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">5000.00</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">Deposit made</div>
                                        </td>
                                        <td>
                                            <div class="pretty p-svg p-curve">paypal</div>
                                        </td>

                                        <td class="flag">
                                            <div class="pretty p-svg p-curve">04/09/2019</div>
                                        </td>
                                        <td>
                                            <nav class="navbar navbar-expand">
                                                <ul class="navbar-nav">
                                                    <!-- Dropdown -->
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!--  transactions wrapper end -->
            <!--  footer  wrapper start -->
            <div class="copy_footer_wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="crm_left_footer_cont">
                                <p>2025 Copyright © <a href="#"> muntmogul </a> . All Rights Reserved.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
         </div>
       <!--  footer  wrapper end -->      
    <!-- main box wrapper End-->

    <!-- Deposit Modal -->
    <div id="depositModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDepositModal()">&times;</span>
            <h3>Deposit Crypto</h3>
            
            <label>Select Cryptocurrency:</label>
            <select id="cryptoType" onchange="updateNetworks()">
                <option value="BTC">Bitcoin (BTC)</option>
                <option value="ETH">Ethereum (ETH)</option>
                <option value="LTC">Litecoin (LTC)</option>
                <option value="DOGE">Dogecoin (DOGE)</option>
            </select>

            <label>Select Network:</label>
            <select id="networkType" onchange="fetchDepositDetails()">
                <!-- Options will be dynamically populated -->
            </select>

            <h4>Deposit Address:</h4>
            <input type="text" id="depositAddress" readonly>
            <button onclick="copyAddress()">Copy</button>

            <h4>QR Code:</h4>
            <img id="qrCodeImage" src="" alt="QR Code">

            <p><strong>Note:</strong> Send only selected crypto to this address.</p>
        </div>
    </div>

    <!-- JavaScript for Modal Functionality -->
    <script>

        let cryptoData = {};  // Stores JSON data globally

        // Load JSON Data on Page Load
        fetch("assets/crypto_addresses.json")
            .then(response => response.json())
            .then(data => {
                cryptoData = data;
                updateNetworks();  // Update networks when page loads
            }) .catch(error => console.error("Error loading JSON:", error)); // Debugging
        
        function openDepositModal() {
            document.getElementById("depositModal").style.display = "block";
        }

        function closeDepositModal() {
            document.getElementById("depositModal").style.display = "none";
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById("depositModal");
            if (event.target === modal) {
                closeDepositModal();
            }
        }

        // Update Networks Based on Selected Crypto
        function updateNetworks() {
            let cryptoType = document.getElementById("cryptoType").value;
            let networkDropdown = document.getElementById("networkType");

            // Clear existing options
            networkDropdown.innerHTML = "";

            if (cryptoData[cryptoType]) {
                // Populate networks from JSON
                cryptoData[cryptoType]["networks"].forEach(network => {
                    let option = document.createElement("option");
                    option.value = network;
                    option.text = network;
                    networkDropdown.appendChild(option);
                });

                // Auto-select first network and fetch deposit details
                fetchDepositDetails();
            }
        }

        function fetchDepositDetails() {
            let cryptoType = document.getElementById("cryptoType").value;
            let networkType = document.getElementById("networkType").value;

            if (cryptoData[cryptoType] && cryptoData[cryptoType]["addresses"][networkType]) {
                let depositInfo = cryptoData[cryptoType]["addresses"][networkType];
                document.getElementById("depositAddress").value = depositInfo["address"];
                document.getElementById("qrCodeImage").src = depositInfo["qr_code"];
            } else {
                document.getElementById("depositAddress").value = "Invalid Selection";
                document.getElementById("qrCodeImage").src = "";
            }
        }

        function copyAddress() {
            let copyText = document.getElementById("depositAddress");
            navigator.clipboard.writeText(copyText.value);
            alert("Address copied to clipboard!");
        }
    </script>

    <script src="js/live_crypto_rates.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>
	<script src="js/dropify.min.js"></script>
	<script src="js/owl.carousel.js"></script>
    <script src="js/jquery.countTo.js"></script>
	<script src="js/plugin.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/datatables.js"></script>
    <script src="js/jquery.menu-aim.js"></script>
    <script src="js/custom.js"></script>
    <!--main js file end-->
</body>

</html>