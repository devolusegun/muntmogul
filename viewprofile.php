<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
}

// Fetch User Data
$stmt = $pdo->prepare("SELECT * FROM crypticusers WHERE id = ?");
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
    <title>Dashboard | Profile</title>
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
            </li>-->
            <!--<li class="has-children">
                <a href="#">index</a>
                
            </li>-->
            <li><!--<h1>hi, </h1>--></li>
            <!--<li><a href="investment.html"> investment plan </a></li>-->
            <!--<li><a href="faq.html"> FAQ </a></li>-->
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
    <!-- nav end -->

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
                        <div class="budge_noti">..</div>
                        <ul class="list">
                            <li><a href="#">No New Messages</a></li>

                        </ul>
                    </div>
                </div>
                <div class="crm_profile_dropbox_wrapper">
                    <div class="nice-select" tabindex="0"> <span class="current"><img
                                src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/avatar.png'; ?>"
                                alt="User" width="50" height="50" style="border-radius: 50%;"><?php echo $_SESSION["user"]["username"]; ?> <span class="hidden_xs_content"></span></span>
                        <ul class="list">
                            <li><a href="#"><i class="flaticon-profile"></i> Profile</a></li>

                            <li><a href="logout"><i class="flaticon-turn-off"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper dashboard_header">
                <!-- mainmenu start -->
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <ul class="main_nav_ul">

                        <li><!--<h1></h1>--></li>
                        <!--<li><a href="investment.html" class="gc_main_navigation">investment plan</a></li> -->

                        <li class="has-mega gc_main_navigation"><a class=""> <i class=""></i></a>
                            <!--<ul class="navi_2_dropdown">
								<li class="parent">
                                    <a href="tickets.html"><i class="fas fa-caret-right"></i>view tickets</a></li>
                            </ul>-->
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
                                <li>Profile</li>
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
                                <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a></li>-->
                                <li><a href="#"><i class="fa fa-circle"></i> profile</a> </li>
                                <li><a href="password"><i class="fa fa-circle"></i>change password</a></li>
                                <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a></li>
                                <!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a></li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="viewprofile">
                            <div class="c-menu-item__title"><span>profile</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a> </li>-->
                            <li><a href="#"><i class="fa fa-circle"></i> profile</a></li>
                            <li><a href="password"><i class="fa fa-circle"></i>change password</a> </li>
                            <li><a href="paymentrequest"><i class="fa fa-circle"></i>withdraw</a> </li>
                            <!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a></li>-->
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
                        <div class="c-menu__item__inner"><a href="depositupload"><i class="flaticon-movie-tickets"></i></a>
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
                        <a href="depositupload">
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
                                <li><a href="tickets"><i class="fa fa-circle"></i>support</a></li>
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
                            <li><a href="tickets"><i class="fa fa-circle"></i>support</a></li>
                            <!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
							<li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a></li>
							<li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a></li>-->
                        </ul>
                    </li>
                </ul>

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

        <!-- Profile Section Start -->
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12">
                    <div class="sv_heading_wraper">
                        <h4>Profile</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="view_profile_wrapper float_left">
                        <div class="row">
                            <!-- Profile Image Upload Section -->
                            <div class="col-md-12">
                                <div class="profile_view_img">
                                    <!-- <?= var_dump($user['profile_picture']); ?> -->
                                    <img id="profileImage" src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'uploads/profile_pictures/default.png'; ?>" alt="Profile Picture">
                                </div>
                                <div class="profile_width_cntnt">
                                    <h4>JPEG or PNG (500x500px)</h4>
                                    <form id="profilePicForm" enctype="multipart/form-data">
                                        <input type="file" id="profilePicInput" name="profile_picture" accept="image/jpeg, image/png" required>
                                        <a href="#" class="upload-btn" onclick="uploadProfilePicture()">Upload</a>
                                    </form>
                                </div>
                            </div>

                            <!-- Editable Profile Info Section -->
                            <div class="col-md-6">
                                <form id="profileForm">
                                    <ul class="profile_list">
                                        <li><span class="detail_left_part">First Name</span> <span class="detail_right_part"><?= htmlspecialchars($user["first_name"]); ?></span></li>
                                        <li><span class="detail_left_part">Last Name</span> <span class="detail_right_part"><?= htmlspecialchars($user["last_name"]); ?></span></li>
                                        <li><span class="detail_left_part">Email Address</span> <span class="detail_right_part"><?= htmlspecialchars($user["email"]); ?></span></li>
                                        <li><span class="detail_left_part">Address</span> <input type="text" id="address" value="<?= htmlspecialchars($user["address"]); ?>" required></li>
                                        <li><span class="detail_left_part">City</span> <input type="text" id="city" value="<?= htmlspecialchars($user["city"]); ?>" required></li>
                                        <li><span class="detail_left_part">State</span> <input type="text" id="state" value="<?= htmlspecialchars($user["state"]); ?>" required></li>
                                        <li><span class="detail_left_part">Country</span> <input type="text" id="country" value="<?= htmlspecialchars($user["country"]); ?>" required></li>
                                    </ul>
                                </form>
                            </div>

                            <!-- Save Changes Button -->
                            <div class="about_btn float_left">
                                <ul>
                                    <li><a href="#" id="saveChangesBtn">Save Changes</a></li>
                                </ul>
                            </div>
                        </div>



                    </div> <!-- view_profile_wrapper -->
                </div> <!-- col-md-12 -->
            </div> <!-- row -->
        </div> <!-- view_profile_wrapper_top -->
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
    <!--  footer  wrapper end -->
    <!-- main box wrapper End-->

    <!-- Transaction PIN Modal -->
    <div class="modal fade" id="transactionPinModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="sv_question_pop float_left">
                    <h1>User Security</h1>
                    <p>Enter your Transaction PIN to confirm changes</p>
                    <div class="change_field">
                        <input type="password" id="transactionPin" placeholder="Enter Transaction PIN" required>
                    </div>
                    <div class="question_sec float_left">
                        <div class="about_btn ques_Btn">
                            <ul>
                            <li><a href="#" id="confirmPinBtn">Confirm</a></li>
                            </ul>
                        </div>
                        <div class="cancel_wrapper">
                            <a href="#" onclick="document.getElementById('transactionPinModal').style.display = 'none';">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function showTransactionPinModal() {
            document.getElementById('transactionPinModal').style.display = 'block';
        }

        /*function saveProfileChanges() {
            var formData = new FormData();
            formData.append("transaction_pin", document.getElementById("transactionPin").value);
            formData.append("address", document.getElementById("address").value);
            formData.append("city", document.getElementById("city").value);
            formData.append("state", document.getElementById("state").value);
            formData.append("country", document.getElementById("country").value);

            // Check if a new profile picture is selected
            var profileImage = document.getElementById("profileImageInput").files[0];
            if (profileImage) {
                formData.append("profile_picture", profileImage);
            }

            fetch("update_profile.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);

                    if (data.success) {
                        // Close Transaction PIN Modal on success
                        document.getElementById("transactionPinModal").style.display = "none";

                        // Update profile image if changed
                        if (data.image_path) {
                            document.getElementById("profileImagePreview").src = data.image_path;
                        }
                    }
                })
                .catch(error => console.error("Error:", error));
        }*/

        function uploadProfilePicture() {
            var fileInput = document.getElementById("profilePicInput");
            if (!fileInput.files.length) {
                alert("Please select an image to upload.");
                return;
            }

            var formData = new FormData();
            formData.append("profile_picture", fileInput.files[0]);

            fetch("upload_profile_picture.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("profileImage").src = data.image_path;
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>

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
    <script src="js/profile_update.js"></script>
    <!--main js file end-->
    <!-- Deposit Modal -->



</body>

</html>