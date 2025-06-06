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
$stmt = $pdo->prepare("SELECT * FROM crypticusers WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Refresh session with full user details
$_SESSION["user"] = $user;

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Calculator</title>
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
            </li> 
            </li>-->
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
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.177 31.177"
                                        style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve"
                                        width="25px" height="25px">
                                        <g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z"
                                                    fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z"
                                                    fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z"
                                                    fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z"
                                                    fill="#004165" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z"
                                                    fill="#004165" />
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
                    <div class="nice-select budge_noti_wrapper" tabindex="0"> <span class="current"><i
                                class="flaticon-notification"></i></span>
                        <div class="budge_noti">..</div>
                        <ul class="list">
                            <li><a href="#">No New Messages</a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="crm_profile_dropbox_wrapper">
                    <div class="nice-select" tabindex="0"> <span class="current"><img
                                src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/user.png'; ?>"
                                alt="User" width="50" height="50" style="border-radius: 50%;">
                            <?php echo $_SESSION["user"]["username"]; ?> <span class="hidden_xs_content"></span>
                        </span>
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
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <ul class="main_nav_ul">
                        <li>
                            <!--<h3>hi,
                                
                            </h3>-->
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
                        <li class="has-mega gc_main_navigation">
                            <!--<ul class="navi_2_dropdown">
                              
                                
								
								
								<li class="parent">
                                    <a href="tickets.html"><i class="fas fa-caret-right"></i>view tickets</a></li>
                            </ul>-->
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
                                <li> View Plans</li>
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
                        <div class="c-menu__item__inner"><a href="viewprofile"><i
                                    class="flaticon-profile"></i></a>
                            <ul class="crm_hover_menu">
                                <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a> </li>-->
                                <li><a href="viewprofile"><i class="fa fa-circle"></i> profile</a> </li>
                                <li><a href="password"><i class="fa fa-circle"></i>change password</a> </li>
                                <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a></li>
                                <!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a> </li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="viewprofile">
                            <div class="c-menu-item__title"><span>my account</span><i class="no_badge">3</i>
                            </div>
                        </a>
                        <ul>
                            <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a></li>-->
                            <li><a href="viewprofile"><i class="fa fa-circle"></i> profile</a></li>
                            <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                            <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a></li>
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
                        <div class="c-menu__item__inner"><a href="getplan"><i
                                    class="flaticon-settings"></i></a>
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
                        <div class="c-menu__item__inner"><a href="depositupload"><i
                                    class="flaticon-movie-tickets"></i></a>
                            <ul class="crm_hover_menu">
                                <li><a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                                <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a> </li>
                                <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i> earning history</a></li>-->
                                <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                                <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a></li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="depositupload">
                            <div class="c-menu-item__title"><span>finances</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <li> <a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                            <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a> </li>
                            <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i>earning history</a> </li>-->
                            <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                            <!--<li> <a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a></li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="#"><i class="flaticon-file"></i></a>
                        </div>
                    </li>
                    <li class="c-menu__item crm_navi_icon_cont">
                        <a href="#">
                            <div class="c-menu-item__title">view plans</div>
                        </a>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="tickets"><i class="flaticon-help"></i></a>
                            <ul class="crm_hover_menu">
                                <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a>
                                    </li>-->
                                <li><a href="tickets"><i class="fa fa-circle"></i>support</a>
                                </li>

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
                            <li><a href="tickets"><i class="fa fa-circle"></i>support</a>
                            </li>

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
                <h3>
                    <?php echo htmlspecialchars($user["first_name"] . " " . $user["last_name"]); ?>
                </h3>

                <dl class="userdescc">
                    <dt>Registration Date</dt>
                    <dd>: &nbsp;
                        <?php echo $user["created_at"]; ?>
                    </dd>
                    <dt>Last Login</dt>
                    <dd>: &nbsp;
                        <?php echo $user["last_login"]; ?>
                    </dd>
                    <!--<dt>Current Login</dt>
                        <dd>: &nbsp; Jul-06-2019 02:47:23</dd>-->
                    <dt>Last Access IP</dt>
                    <dd>: &nbsp;
                        <?php echo $user["last_ip"]; ?>
                    </dd>
                    <dt>Current IP</dt>
                    <dd>: &nbsp;
                        <?php echo $_SERVER["REMOTE_ADDR"]; ?>
                    </dd>

                </dl>

            </div>

            <div class="userdet user_transcation">
                <h3>Available Balance</h3>
                <dl class="userdescc">
                    <dt>Bitcoin</dt>
                    <dd>:&nbsp;&nbsp;₿
                        <?php echo number_format($user["btc_balance"], 8); ?>
                    </dd>
                    <dt>Ethereum</dt>
                    <dd>:&nbsp;&nbsp;Ξ
                        <?php echo number_format($user["eth_balance"], 8); ?>
                    </dd>
                    <dt>Litecoin</dt>
                    <dd>:&nbsp;&nbsp;Ł
                        <?php echo number_format($user["ltc_balance"], 8); ?>
                    </dd>
                    <dt>Dogecoin</dt>
                    <dd>:&nbsp;&nbsp;Ð
                        <?php echo number_format($user["doge_balance"], 8); ?>
                    </dd>
                </dl>
            </div>
        </div>
        <!--  my account wrapper end -->

        <!--calculator plan wrapper start -->
        <div class="calculator_wrapper float_left">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="sv_heading_wraper heading_wrapper_dark dark_heading">
                            <h4> plans calculator </h4>
                            <h3> Check How Much You Can Make </h3>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 calc">
                        <div class="calculator_portion float_left">
                            <div class="caluclator_text_wrapper">
                                <label for="investmentAmount">Deposit Amount <i class="fas fa-info-circle" title="One-time investment amount in dollars."></i></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                    <input type="number" id="investmentAmount" class="form-control" min="0" placeholder="e.g. 1000" />
                                </div>
                            </div>
                            <div class="caluclator_text_wrapper">
                                <label for="investmentAmountSIP">Monthly Plans <i class="fas fa-info-circle" title="Monthly recurring investment in dollars."></i></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-briefcase"></i></span>
                                    <!--<input type="number" id="investmentAmountSIP" class="form-control" min="0" placeholder="e.g. 500" />-->
                                    <select id="planSelector" class="form-control">
                                        <option value="bronze">Bronze</option>
                                        <option value="silver">Silver</option>
                                        <option value="copper">Copper</option>
                                        <option value="gold">Gold</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group caluclator_text_wrapper">
                                <label for="investmentYears" class="font-weight-bold">
                                    Investment Month
                                    <i class="fas fa-info-circle text-muted ml-1" data-toggle="tooltip" title="Select number of years for your investment."></i>
                                </label>
                                <select class="form-control custom-select" id="investmentYears">
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="4">4 Months</option>
                                    <option value="5">5 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="7">7 Months</option>
                                    <option value="8">8 Months</option>
                                    <option value="9">9 Months</option>
                                    <option value="10">10 Months</option>
                                    <option value="11">11 Months</option>
                                    <option value="12" selected>12 Months</option>
                                </select>
                            </div>

                            <div class="about_btn calc_btn float_left">
                                <ul>
                                    <li><a href="javascript:void(0);">Calculate Profit</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 calc">
                        <div class="mutualfunds-calculator">
                            <div class="calculator">
                                <div class="graph-area">
                                    <span class="mf-yAxis">Investment Value</span>
                                    <svg width="480" height="350" id="graph" xmlns="http://www.w3.org/2000/svg"
                                        version="1.1" viewBox="0 0 480 355" class="mf-chart">

                                        <defs>
                                            <pattern id="grid" x="10" y="10" width="480" height="88" patternUnits="userSpaceOnUse">
                                                <line x1="0" y1="0" x2="100%" y2="0" stroke-width="1"
                                                    shape-rendering="crispEdges" stroke="#bdbdbd"></line>
                                            </pattern>
                                        </defs>

                                        <rect width="480" height="355" style="fill:#111111;"></rect>

                                        <!--  Y-Axis tick labels group -->
                                        <g id="yAxisLabels"></g>

                                        <g>
                                            <path d="M 5,330 C 5,330 300,257.5 475,170"
                                                id="path1" fill="none" stroke="#bdbdbd"
                                                stroke-width="5px" stroke-linecap="round"
                                                class="anim-path"
                                                style="transition: stroke-dashoffset 2s ease-in-out; stroke-dasharray: 522.957, 522.957; stroke-dashoffset: 0px; display: inline;">
                                            </path>
                                            <path d="M 5,330 C 5,330 300,257.5 475,20"
                                                id="path2" fill="none" stroke="#dba622"
                                                stroke-width="5px" stroke-linecap="round"
                                                class="anim-path"
                                                style="transition: stroke-dashoffset 2s ease-in-out; stroke-dasharray: 572.872, 572.872; stroke-dashoffset: 0px; display: inline;">
                                            </path>
                                        </g>

                                        <g class="mf-circles">
                                            <circle cx="472" cy="22" r="8" fill="#dba622" stroke="#dba622" stroke-width="3px"></circle>
                                            <circle cx="472" cy="170" r="8" fill="#bdbdbd" stroke="#bdbdbd" stroke-width="3px"></circle>
                                        </g>
                                    </svg>

                                    <div class="mf-xAxis">
                                        <span class="mf-xAxis-end" id="years_selected">12 Months</span>
                                    </div>

                                    <div class="labels funds_label" style="display: block;">
                                        <div class="chart-label">
                                            <!-- Dollar sign instead of rupee -->
                                            <span class="amt" id="directFund">$</span>
                                            <span class="sub">total returns</span>
                                        </div>
                                        <div class="chart-label label-regular">
                                            <!--  Dollar sign instead of rupee -->
                                            <span class="amt" id="regularFund">$</span>
                                            <span class="sub">investment amount</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="calc-amt calc_ind_1_2">
                            <p class="calc-price" id="returnAmount"></p>
                            <p>total returns on investment</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--calculator plan wrapper end -->

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

    <script>
        function toggleRejectionReason(element) {
            let span = element.previousElementSibling;
            let fullText = element.getAttribute("data-fulltext");

            if (element.innerText === "View More") {
                span.innerText = fullText;
                element.innerText = "View Less";
            } else {
                span.innerText = fullText.substring(0, 50) + "...";
                element.innerText = "View More";
            }
        }
    </script>

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
    
    <!-- 1. Core Libraries First -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>
    
    <!-- 2. Plugin Dependencies (Must Come After jQuery) -->
    <script src="js/dropify.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/jquery.countTo.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/datatables.js"></script>
    <script src="js/jquery.menu-aim.js"></script>

    <!-- 3. Your Custom Scripts (Should Come Last) -->
    <script src="js/plugin.js"></script>         <!-- If it depends on plugins above -->
    <script src="js/depositmodal.js"></script>   <!-- Any modal logic -->
    <script src="js/news.js"></script>           <!-- Your news UI logic -->
    <script src="js/custom.js"></script>         <!-- General custom JS (if it’s not the calculator) -->
    <script src="js/calculator.js"></script>     <!-- ✅ Your main calculator script goes here -->
    <!--main js file end-->
</body>

</html>