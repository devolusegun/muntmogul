<?php
session_start();
require 'config/config.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION["user"]["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];
$successMsg = $errorMsg = "";

// Handle Ticket Submission (When Form is Submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_ticket"])) {
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if (empty($subject) || empty($message)) {
        $errorMsg = "Subject and message cannot be empty.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO support_tickets (user_id, subject, message, status, created_at) VALUES (?, ?, ?, 'Open', NOW())");
        if ($stmt->execute([$user_id, $subject, $message])) {
            $successMsg = "Ticket submitted successfully.";
            // Redirect to refresh the page and prevent duplicate form submissions
            header("Location: tickets.php?success=1");
            exit();
        } else {
            $errorMsg = "Failed to submit ticket.";
        }
    }
}

// Fetch User Tickets
$stmt = $pdo->prepare("SELECT id, subject, status, created_at FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Tickets</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="MuntMogul" />
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
        .modal-backdrop {
            z-index: 1040 !important;
            /* Ensure it's below modal */
        }

        .modal {
            z-index: 1050 !important;
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
            <li>
                <form class="cd-search">
                    <input type="search" placeholder="Search...">
                </form>
            </li>

            <li></li>
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
                    <li><a href="#">tickets</a></li>
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
                            <li><a href="#">No New Messages</a></li>
                        </ul>
                    </div>
                </div>

                <div class="crm_profile_dropbox_wrapper">
                    <div class="nice-select" tabindex="0"> <span class="current"><img
                                src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/avatar.png'; ?>"
                                alt="User" width="50" height="50" style="border-radius: 50%;">
                            <?php echo $_SESSION["user"]["username"]; ?> <span class="hidden_xs_content"></span>
                        </span>
                        <ul class="list">
                            <li><a href="#"><i class="flaticon-profile"></i> Profile</a></li>
                            <li><a href="logout"><i class="flaticon-turn-off"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper dashboard_header">
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <ul class="main_nav_ul">
                        <li><!--<h1></h1>--></li>
                        <li class="has-mega gc_main_navigation"><a class=""> <i class=""></i></a>
                            <!--<li class="has-mega gc_main_navigation"> </li>
                            <li></li>
                            <li></li>
                            <li class="has-mega gc_main_navigation"></li>
                            <li class="has-mega gc_main_navigation"> </li>

                            <li class="has-mega gc_main_navigation"> </li>-->
                        </li>
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
                                <li> <a href="#"> Home </a>&nbsp; / &nbsp; </li>
                                <li> Tickets</li>
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
                        <div class="c-menu__item__inner"><a href="viewprofile"><i
                                    class="flaticon-four-grid-layout-design-interface-symbol"></i></a>
                            <ul class="crm_hover_menu">
                                <li><a href="viewprofile"><i class="fa fa-circle"></i> profile</a></li>
                                <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                                <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="viewprofile">
                            <div class="c-menu-item__title"><span>my account</span><i class="no_badge">5</i>
                            </div>
                        </a>
                        <ul>
                            <li><a href="viewprofile"><i class="fa fa-circle"></i> profile</a> </li>
                            <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                            <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="#"><i class="flaticon-progress-report"></i></a></div>
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
                    <li class="c-menu__item crm_navi_icon_cont">
                        <a href="getplan">
                            <div class="c-menu-item__title">choose a plan </div>
                        </a>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="#"><i class="flaticon-movie-tickets"></i></a>
                            <ul class="crm_hover_menu">
                                <li><a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a> </li>
                                <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a></li>
                                <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i> earning history</a></li>-->
                                <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a></li>
                                <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a> </li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="#">
                            <div class="c-menu-item__title"><span>finances</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <li><a href="depositupload"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                            <li><a href="deposited"> <i class="fa fa-circle"></i> deposit history</a></li>
                            <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i>earning history</a></li>-->
                            <li><a href="transactions"> <i class="fa fa-circle"></i>all transactions</a> </li>
                            <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a></li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="investment"><i class="flaticon-file"></i></a></div>
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
                                <li><a href="#"><i class="fa fa-circle"></i>support</a></li>
                                <!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
								<li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a></li>
								<li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a></li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="tickets">
                            <div class="c-menu-item__title"><span>Help</span><i class="no_badge purple">1</i> </div>
                        </a>
                        <ul>
                            <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a></li>-->
                            <li><a href="#"><i class="fa fa-circle"></i>support</a></li>
                            <!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
							<li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a></li>
							<li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a></li>-->
                        </ul>
                    </li>
                </ul>
                <!--<ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="make_deposit.html"><i class="flaticon-profile"></i></a></div>
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
    <!-- Side menus end -->

    <!-- Main section Start -->
    <div class="l-main">
        <!--  my account wrapper start -->
        <div class="account_top_information">
            <div class="account_overlay"></div>
            <div class="useriimg"><!--<img src="images/user.png" alt="users">--></div>
            <div class="userdet uderid">
                <!--<h3>Benmathew</h3>

                <dl class="userdescc">
                    <dt>Registration Date</dt>
                    <dd>: &nbsp; Sep-10-2014 11:20:37</dd>
                    <dt>Last Login</dt>
                    <dd>: &nbsp; Jul-05-2019 07:06:36</dd>
                    <dt>Current Login</dt>
                    <dd>: &nbsp; Jul-06-2019 02:47:23</dd>
                    <dt>Last Access IP</dt>
                    <dd>: &nbsp; 27.57.18.1 </dd>
                    <dt>Current Access IP</dt>
                    <dd>: &nbsp; 122.175.131.51 </dd>

                </dl>-->

            </div>

            <div class="userdet user_transcation">
                <!--<h3>Available Balance</h3>
                <dl class="userdescc">
                    <dt>Paypal</dt>
                    <dd>:&nbsp;&nbsp;$ 392.79</dd>
                    <dt>Pexpay</dt>
                    <dd>:&nbsp;&nbsp;$ 498.61</dd>
                    <dt>PerfectMoney</dt>
                    <dd>:&nbsp;&nbsp;$ 60.18</dd>
                    <dt>Payza</dt>
                    <dd>:&nbsp;&nbsp;$ 435</dd>
                    <dt>HDMoney</dt>
                    <dd>:&nbsp;&nbsp;$ 0.08</dd>

                </dl>-->
            </div>
            <div class="userdet user_transcation">
                <!--<h3 class="none_headung"> &nbsp;</h3>
                <dl class="userdescc">
                    <dt>EGOpay</dt>
                    <dd>:&nbsp;&nbsp;$ 0</dd>
                    <dt>OKpay</dt>
                    <dd>:&nbsp;&nbsp;$ 0</dd>
                    <dt>Solidtrustpay </dt>
                    <dd>:&nbsp;&nbsp;$ 0</dd>
                    <dt>Webmoney</dt>
                    <dd>:&nbsp;&nbsp;$ 450</dd>
                    <dt>Bankwire</dt>
                    <dd>:&nbsp;&nbsp;$ 799</dd>
                    <dt>Bitcoin</dt>
                    <dd>:&nbsp;&nbsp;$ 33584</dd>

                </dl>-->

            </div>

        </div>
        <!--  my account wrapper end -->
        <!--  profile wrapper start -->
        <div class="last_transaction_wrapper float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">
                        <h4> ticket details</h4>
                    </div>
                </div>
                <div class="crm_customer_table_main_wrapper float_left">
                    <div class="crm_ct_search_wrapper">
                        <div class="about_btn float_left">
                            <ul>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#myModal">new ticket</a>
                                </li>
                            </ul>
                        </div>
                        <div class="modal fade question_modal" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="sv_question_pop float_left">
                                                <h1>Raise a Ticket</h1>
                                                <form method="POST">
                                                    <div class="change_field">
                                                        <input type="text" name="subject" placeholder="Subject" required>
                                                    </div>
                                                    <div class="change_field">
                                                        <textarea name="message" rows="7" cols="35" placeholder="Message" required></textarea>
                                                    </div>
                                                    <div class="question_sec">
                                                        <button type="submit" name="submit_ticket" class="btn btn-primary">Send</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Ticket submitted successfully.</div>
                    <?php endif; ?>

                    <?php if (!empty($errorMsg)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="myTable table datatables cs-table crm_customer_table_inner_Wrapper">
                            <thead>
                                <tr>
                                    <th>Ticket No</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tickets)): ?>
                                    <?php foreach ($tickets as $ticket): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($ticket["id"]); ?></td>
                                            <td><?php echo htmlspecialchars($ticket["subject"]); ?></td>
                                            <td><?php echo htmlspecialchars($ticket["status"]); ?></td>
                                            <td><?php echo htmlspecialchars($ticket["created_at"]); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No tickets found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  profile wrapper end -->
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

    <!--  footer  wrapper end -->
    <!-- main box wrapper End-->
    <script src="js/depositmodal.js"></script>
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
    <script src="js/news.js"></script>
    <!--main js file end-->
</body>

</html>