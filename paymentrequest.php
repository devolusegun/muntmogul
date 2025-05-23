<?php
session_start();
require 'config/config.php';

// Ensure user session is set
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];

// Fetch user details from database
$stmtd = $pdo->prepare("SELECT * FROM crypticusers WHERE id = ?");
$stmtd->execute([$user_id]);
$user = $stmtd->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Refresh session with full user details
//$_SESSION["user"] = $user;

// Fetch Crypto Balance Function
function getUserCryptoBalance($pdo, $user_id, $crypto_type) {
    // Column name dynamically set from crypto type (e.g., btc_balance, eth_balance)
    $column = strtolower($crypto_type) . "_balance";
    
    $stmt = $pdo->prepare("SELECT $column AS balance FROM crypticusers WHERE id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['balance'] ?? 0;
}

// Default Crypto Type (BTC)
$selected_crypto = $_POST['crypto_type'] ?? 'BTC';

// Fetch the Correct Balance for Selected Crypto
$crypto_balance = getUserCryptoBalance($pdo, $user_id, $selected_crypto);


?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Withdrawal</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Muntmogul" />
    <meta name="keywords" content="Muntmogul" />
    <meta name="author" content="7evenspirits" />
    <meta name="MobileOptimized" content="320" />
    <!--Template style -->
    <link rel="stylesheet" type="text/css" href="css/news.css" />
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
    
    <style>
        /* Ensure dropdown closes on selection */
.nice-select .list {
    max-height: 250px; /* Prevents it from becoming too large */
    overflow-y: auto;  /* Enables scrolling for long lists */
}

/* Ensures dropdown closes on selection */
.nice-select .option {
    cursor: pointer;
}
    </style>
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
        <h2><a href="index.html"> muntmogul </a></h2>
        <a href="#0" class="cd-close">Close</a>
        <ul class="cd-dropdown-content">
            <!--<li>
                <form class="cd-search">
                    <input type="search" placeholder="Search...">
                </form>
            </li>
             <li class="has-children">
                <a href="#">index</a>
                
            </li>-->
            <li></li>
            <!--<li><a href="investment.html"> investment plan </a></li>
			<li><a href="faq.html"> FAQ </a></li>-->
            <li class="has-children">
                <a href="#">dashboard</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="#"></a></li>
                    <li><a href="viewprofile">view profile</a></li>
                    <li><a href="password">change password</a></li>
                    <li>
                        <a href="javascript:void(0);" onclick="openDepositModal()">
                            <div class="c-menu-item__title">make deposit</div>
                        </a>
                    </li>
                    <li><a href="depositupload">upload deposit proof</a></li>
                    <li><a href="getplan">choose plan</a></li>
                    <li><a href="paymentrequest">withdraw</a></li>
                    <li><a href="deposited">deposit history</a></li>
                    <li><a href="transactions">all transactions</a></li>
                    <!--<li><a href="pending_history.html">pending history</a> </li> 	
					<li> <a href="referrals.html">referrals</a></li> -->
                    <li><a href="tickets">tickets</a></li>
                </ul>
            </li>
        </ul>
        <!-- .cd-dropdown-content -->
    </nav>
    <!-- nav end  -->

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
                <!--<div class="crm_message_dropbox_wrapper">
                        
                    </div>-->
                <div class="crm_message_dropbox_wrapper crm_notify_dropbox_wrapper">
                    <div class="nice-select budge_noti_wrapper" tabindex="0"> <span class="current"><i class="flaticon-notification"></i></span>
                        <div class="budge_noti">..</div>
                        <ul class="list">
                            <li><a href="#">No New Messages</a> </li>
                            <!--<li>
                                    <div class="crm_mess_all_main_box_wrapper">
                                        <p><a href="#">See All</a>
                                        </p>
                                    </div>
                                </li>-->
                        </ul>
                    </div>
                </div>

                <div class="crm_profile_dropbox_wrapper">
                    <div class="nice-select" tabindex="0"> <span class="current"><img
                                src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/avatar.png'; ?>"
                                alt="User" width="50" height="50" style="border-radius: 50%;"> <?php echo $_SESSION["user"]["username"]; ?><span class="hidden_xs_content"></span></span>
                        <ul class="list">
                            <li><a href="viewprofile"><i class="flaticon-profile"></i> Profile</a> </li>
                            <!--<li><a href="#"><i class="flaticon-purse"></i>Account Balance</a></li>
                                <li><a href="#"><i class="flaticon-envelope"></i> Inbox</a> </li>
                                li><a href="#"><i class="flaticon-settings"></i> Setting</a></li>
                                <li><a href="#"><i class="flaticon-help"></i> Support</a></li>
                                <li><a href="#"><i class="flaticon-padlock"></i> Lock Screen</a> </li>-->
                            <li><a href="logout"><i class="flaticon-turn-off"></i>Logout</a> </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper dashboard_header">
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <ul class="main_nav_ul">
                        <!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation active_class">index <i class="fas fa-caret-down"></i></a> 								
                           
                        </li>  -->
                        <li>
                            <h1></h1>
                        </li>
                        <!--<li><a href="investment.html" class="gc_main_navigation">investment plan</a></li>  
						<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">pages <i class="fas fa-caret-down"></i></a>
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
                            <!--<ul class="navi_2_dropdown">            
                                <li class="parent">
                                    <a href="#"><i class="fas fa-caret-right"></i>my account<span><i class="fas fa-caret-right"></i></span></a>
                                    <ul class="dropdown-menu-right">
                                        <li> <a href="my_account.html"> <i class="fas fa-caret-right"></i>my account</a> </li>
                                        <li> <a href="view_profile.html"> <i class="fas fa-caret-right"></i> my profile</a> </li>
                                        <li> <a href="email_notification.html"><i class="fas fa-caret-right"></i>email notification </a></li>
                                        <li> <a href="change_password.html"><i class="fas fa-caret-right"></i>change password</a></li>
                                        <li> <a href="change_pin.html"><i class="fas fa-caret-right"></i>change pin</a></li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>finance<span> <i class="fas fa-caret-right"></i></span></a>
                                    <ul class="dropdown-menu-right">
                                        <li> <a href="make_deposit.html"> <i class="fas fa-caret-right"></i>make deposit</a></li>
                                        <li><a href="deposit_list.html"> <i class="fas fa-caret-right"></i> deposit lists</a></li>
                                        <li> <a href="payment_request.html"><i class="fas fa-caret-right"></i>payment request</a> </li>
                                        <li> <a href="exchange_money.html"><i class="fas fa-caret-right"></i>exchange money</a></li>
                                        <li> <a href="transfer_fund.html"><i class="fas fa-caret-right"></i>fund transfer</a></li>
                                    </ul>
                                </li>
								<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>reports<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                        <li><a href="all_transactions.html"> <i class="fas fa-caret-right"></i>all transactions</a></li>
                                        <li> <a href="deposit_history.html"> <i class="fas fa-caret-right"></i> deposit history</a></li>
                                        <li><a href="pending_history.html"><i class="fas fa-caret-right"></i>pending history</a> </li>
                                        <li><a href="exchange_history.html"><i class="fas fa-caret-right"></i>exchange history</a> </li>
                                        <li><a href="earnings_history.html"><i class="fas fa-caret-right"></i>earning history</a></li> 
                                    </ul>
                                </li>
								<li class="parent">
                                    <a href="#"> <i class="fas fa-caret-right"></i>referrals<span> <i class="fas fa-caret-right"></i>
									</span></a>
                                    <ul class="dropdown-menu-right">
                                        <li><a href="referrals.html"> <i class="fas fa-caret-right"></i>my referrals</a></li>
                                        <li><a href="banners.html"> <i class="fas fa-caret-right"></i> promotionals banners</a></li>
                                        <li><a href="referral_earnings.html"><i class="fas fa-caret-right"></i>referral earnings</a> </li>
                                    </ul>
                                </li>
								<li class="parent"><a href="tickets.html"><i class="fas fa-caret-right"></i>view tickets</a></li>
                            </ul>-->
                        </li>
                        <!--<li class="has-mega gc_main_navigation"><a href="#" class="gc_main_navigation">blog <i class="fas fa-caret-down"></i></a>
                            <ul class="navi_2_dropdown">
                                <li class="parent"><a href="blog_category.html"><i class="fas fa-caret-right"></i>blog category</a></li>
                                <li class="parent"> <a href="blog_single.html"><i class="fas fa-caret-right"></i> blog single</a></li>                   
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
                        <!-- News Reel section start-->
                        <div class="news-reel-container">
                            <div class="news-reel" id="newsReel">
                                Loading latest news... ⏳
                            </div>
                        </div>
                        <!-- News Reel section end-->
                    </div>
                    <div class="col-xl-3 col-lg-5 col-md-5 col-12 col-sm-5">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="dashboard"> Home </a>&nbsp; / &nbsp; </li>
                                <li> Payout</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- inner header wrapper end -->
    <div class="l-sidebar">
        <div class="l-sidebar__content">
            <nav class="c-menu js-menu" id="mynavi">
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="viewprofile"><i class="flaticon-profile"></i></a>
                            <ul class="crm_hover_menu">
                                <li><a href="viewprofile"><i class="fa fa-circle"></i> profile</a></li>
                                <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i>withdraw</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="viewprofile">
                            <div class="c-menu-item__title"><span>my account</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <li><a href="viewprofile"><i class="fa fa-circle"></i>profile</a> </li>
                            <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                            <li><a href="#"><i class="fa fa-circle"></i>withdraw</a></li>
                            <!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a> </li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="#"><i class="flaticon-progress-report"></i></a> </div>
                    </li>
                    <li class="c-menu__item crm_navi_icon_cont">
                        <a href="javascript:void(0);" onclick="openDepositModal()">
                            <div class="c-menu-item__title">Deposit Funds</div>
                        </a>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="getplan"><i class="flaticon-settings"></i></a>

                        </div>
                    </li>
                    <li class="c-menu__item is-active crm_navi_icon_cont">
                        <a href="getplan">
                            <div class="c-menu-item__title">choose a plan </div>
                        </a>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="depositupload"><i class="flaticon-movie-tickets"></i></a>
                            <ul class="crm_hover_menu">
                                <li><a href="depositupload"><i class="fa fa-circle"></i>upload deposit proof</a> </li>
                                <li><a href="deposited"><i class="fa fa-circle"></i> deposit history</a></li>
                                <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                                <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a></li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="depositupload">
                            <div class="c-menu-item__title"><span>finances</span><i class="no_badge ">3</i></div>
                        </a>
                        <ul>
                            <li><a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                            <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a></li>
                            <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                            <!--<li><a href="transfer_fund.html"><i class="fa fa-circle"></i>fund transfer</a></li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="investments"><i class="flaticon-file"></i></a>
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
                            <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a></li>-->
                            <li><a href="tickets"><i class="fa fa-circle"></i>support</a></li>
                            <!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
									 <li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a> </li>
									 <li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a> </li>-->
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
                    <dd>:&nbsp;&nbsp;₿ <?php echo number_format($user["btc_balance"], 8); ?></dd>
                    <dt>Ethereum</dt>
                    <dd>:&nbsp;&nbsp;Ξ <?php echo number_format($user["eth_balance"], 8); ?></dd>
                    <dt>Litecoin</dt>
                    <dd>:&nbsp;&nbsp;Ł <?php echo number_format($user["ltc_balance"], 8); ?></dd>
                    <dt>Dogecoin</dt>
                    <dd>:&nbsp;&nbsp;Ð <?php echo number_format($user["doge_balance"], 8); ?></dd>
                </dl>
            </div>
        </div>
        <!--  my account wrapper end -->
        <!--  payout section wrapper start -->
        <div class="payment_transfer_Wrapper float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_center">
                        <h4>Account Withdrawal</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-sm-12 col-12">
                    <div class="change_password_wrapper float_left">
                        <form action="processwithdraw.php" method="POST">
                            <div class="change_pass_field float_left">

                                <!-- Payment Mode Dropdown -->
                                <div class="payment_gateway_wrapper payment_select_wrapper">
                                    <label for="cryptoSelect" class="form-label fw-bold">Select Cryptocurrency:</label>
    <select id="cryptoSelect" class="form-select nice-select">
        <option value="" disabled selected>Choose Crypto</option>
        <option value="BTC">Bitcoin (BTC)</option>
        <option value="ETH">Ethereum (ETH)</option>
        <option value="LTC">Litecoin (LTC)</option>
        <option value="DOGE">Dogecoin (DOGE)</option>
    </select>
                                </div>

                                <!-- Available Balance (Readonly) - Updates Based on Selected Crypto -->
                                <div class="change_field">
                                    <label>Available Balance:</label>
                                    <input type="text" id="available_balance" value="<?= number_format($crypto_balance, 8); ?> <?= htmlspecialchars($selected_crypto); ?>" readonly>
                                </div>

                                <!-- Hidden Fields to Store User Balances -->
                                <input type="hidden" id="btcBalance" value="<?= number_format($user['btc_balance'], 8); ?>">
                                <input type="hidden" id="ethBalance" value="<?= number_format($user['eth_balance'], 8); ?>">
                                <input type="hidden" id="ltcBalance" value="<?= number_format($user['ltc_balance'], 8); ?>">
                                <input type="hidden" id="dogeBalance" value="<?= number_format($user['doge_balance'], 8); ?>">

                                <!-- Wallet Address -->
                                <div class="change_field">
                                    <label>Wallet Address:</label>
                                    <input type="text" name="account_id" placeholder="Enter Wallet Address" required>
                                </div>

                                <!-- Withdrawal Amount -->
                                <div class="change_field">
                                    <label>Amount:</label>
                                    <input type="number" name="amount" min="0.00001" step="0.00001" placeholder="Enter Amount" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="about_btn float_left">
                                    <ul>
                                        <li>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--  payout section wrapper end -->
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

    <!-- Deposit Modal Page & Script start-->
    <div id="depositModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDepositModal()">&times;</span>
            <h3>Deposit Crypto</h3>

            <label for="cryptoType" class="form-label fw-bold">Select Cryptocurrency:</label>
            <select id="cryptoType" class="form-select form-select-lg" onchange="updateNetworks()">
                <option value="BTC">Bitcoin (BTC)</option>
                <option value="ETH">Ethereum (ETH)</option>
                <option value="LTC">Litecoin (LTC)</option>
                <option value="DOGE">Dogecoin (DOGE)</option>
            </select>

            <label for="networkType" class="form-label fw-bold">Select Network:</label>
            <select id="networkType" class="form-select form-select-lg" onchange="fetchDepositDetails()">
                <!-- Options will be dynamically populated -->
            </select>

            <div class="sw_heading_wraper">
                <h4>Deposit Address:</h4>
                <input type="text" id="depositAddress" readonly>
                <button onclick="copyAddress()">Copy</button>
            </div>
            <div class="sw_heading_wraper">
                <h4>Scan Code:</h4>
                <img id="qrCodeImage" class="img-fluid qr-code" src="" alt="QR Code">
            </div>
            <p><strong>Note:</strong> Send only selected crypto to this address.</p>
        </div>
    </div>
    
    

    <script src="js/payrequest.js"></script>
    <script src="js/depositmodal.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/dropify.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/jquery.countTo.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/datatables.js"></script>
    <script src="js/jquery.menu-aim.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/news.js"></script>
    <!--main js file end-->
    
    <script>
        $(document).ready(function () {
    setTimeout(() => {
        $('select').niceSelect();
    }, 300); // Small delay ensures it's initialized properly

    // Close dropdown when an option is selected
    $('.nice-select').on('click', '.option', function () {
        let parentDropdown = $(this).closest('.nice-select');
        setTimeout(() => {
            parentDropdown.removeClass('open'); // Forcefully close the dropdown
        }, 100);
    });

    // Close dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.nice-select').length) {
            $('.nice-select').removeClass('open');
        }
    });
});
    </script>
</body>

</html>