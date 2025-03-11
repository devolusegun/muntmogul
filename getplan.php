

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>Profile Details</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Savehyip" />
    <meta name="keywords" content="Savehyip" />
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

    <script>
        let selectedPlan = null;
        let minDeposit = 0;
        let selectedCrypto = null;
        let userBalances = <?= json_encode($usdBalances); ?>; // USD Equivalent of Crypto Balances

        // ✅ Function to Select a Plan
        function selectPlan(plan, minAmount) {
            selectedPlan = plan;
            minDeposit = minAmount;

            // ✅ Highlight selected plan
            document.querySelectorAll(".investment_content_wrapper").forEach(box => box.classList.remove("selected"));
            document.getElementById(plan).classList.add("selected");

            document.getElementById("selectedPlan").innerText = plan.charAt(0).toUpperCase() + plan.slice(1);
        }

        // ✅ Update Account Balance Based on Selected Crypto
        function updateBalance(crypto) {
            selectedCrypto = crypto;
            document.getElementById("accountBalance").innerText = "$" + userBalances[crypto].toLocaleString();
        }

        // ✅ Function to Submit Subscription
        function submitSubscription() {
            if (!selectedPlan) {
                alert("Please choose a plan first.");
                return;
            }
            if (!selectedCrypto) {
                alert("Please choose a payment mode.");
                return;
            }
            if (userBalances[selectedCrypto] < minDeposit) {
                alert("Insufficient balance for this plan.");
                return;
            }

            fetch("process_subscription.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ plan: selectedPlan, crypto: selectedCrypto })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    userBalances[selectedCrypto] -= minDeposit; // Deduct balance in UI
                    updateBalance(selectedCrypto);
                    document.getElementById("selectedPlan").innerText = selectedPlan.charAt(0).toUpperCase() + selectedPlan.slice(1);
                }
            });
        }
    </script>
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
                      <li>
                      <a href="#"></a>
					</li>
				   <li>
                      <a href="change_password.html">change password</a>
					</li>
					<li>
                      <a href="change_pin.html">change pin</a>
					</li>
					<li>
                      <a href="deposit_history.html">deposit history</a>
                  </li>
					<!--<li>
                      <a href="deposit_list.html">deposit list</a>
                  </li>-->
					<li>
                      <a href="earnings_history.html">earnings history</a>
                  </li>
					<!--<li>
                      <a href="email_notification.html">email notification</a>
                  </li>   
					<li>
                      <a href="exchange_history.html">exchange history</a>
                  </li> 
					<li>
						<a href="exchange_money.html">exchange money</a>
                  </li> -->
					<li>
                      <a href="make_deposit.html">make deposit</a>
                  </li> 	
					<li>
                      <a href="my_account.html">my account</a>
                  </li> 	
					<!--<li>
                      <a href="payment_request.html">payment request</a>
                  </li> 	
					<li>
                      <a href="pending_history.html">pending history</a>
                  </li> 	
					<li>
                      <a href="referral_earnings.html">referral earnings</a>
                  </li> 	
					<li>
                      <a href="referrals.html">referrals</a>
                  </li> -->
					<li>
                      <a href="tickets.html">tickets</a>
                  </li> 	
					<!--<li>
                      <a href="transfer_fund.html">transfer fund</a>
                  </li>-->
				<li>
                      <a href="view_profile.html">view profile</a>
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
            <!--<li><a href="contact_us.html"> contact us </a></li>
            <li><a href="login.html"> login </a></li>
            <li><a href="register.html"> register </a></li>-->
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
                    <div class="nice-select" tabindex="0"> <span class="current"><img src="images/avatar.png" alt="img"><?php echo $_SESSION["user"]; ?> <span class="hidden_xs_content"></span></span>
                        <ul class="list">
                            <li><a href="#"><i class="flaticon-profile"></i> Profile</a></li>
                            <li><a href="#"><i class="flaticon-purse"></i>Account Balance</a></li>
                            <!--<li><a href="#"><i class="flaticon-file"></i> My Task</a></li>
                            <li><a href="#"><i class="flaticon-calendar"></i> My Calender</a></li>
                            <li><a href="#"><i class="flaticon-envelope"></i> Inbox</a></li>
                            <li><a href="#"><i class="flaticon-settings"></i> Setting</a>--></li>
                            <li><a href="#"><i class="flaticon-help"></i> Support</a></li>
                            <!--<li><a href="#"><i class="flaticon-padlock"></i> Lock Screen</a></li>-->
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
                        <li><h1>hi, <?php echo $_SESSION["user"]; ?>!</h1></li>
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

                        <h4> savings plans</h4>
                    </div>
                    <div class="col-xl-3 col-lg-5 col-md-5 col-12 col-sm-5">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="#"> Home </a>&nbsp; / &nbsp; </li>
                                <li>choose a plan</li>
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
                        <div class="c-menu__item__inner"><a href="view_profile.html"><i class="flaticon-profile"></i></a>
                            <ul class="crm_hover_menu">
                                <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a>
                                    </li>-->
                                <li><a href="view_profile.html"><i class="fa fa-circle"></i> my profile</a>
                                    </li>
                                <li><a href="change_password.html"><i class="fa fa-circle"></i>change password</a>
                                    </li>
                                <li><a href="email_notification.html"><i class="fa fa-circle"></i>withdraw</a>
                                    </li>
								<!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a>
                                    </li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="view_profile.html">
                            <div class="c-menu-item__title"><span>my account</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <!--<li><a href="my_account.html"><i class="fa fa-circle"></i> my account</a>
                                 </li>-->
                            <li><a href="view_profile.html"><i class="fa fa-circle"></i> my profile</a>
                                 </li>                      
                            <li><a href="change_password.html"><i class="fa fa-circle"></i>change password</a>
                                 </li>
                            <li><a href="payment_request.html"><i class="fa fa-circle"></i>withdraw</a>
                                 </li>
							<!--<li><a href="change_pin.html"><i class="fa fa-circle"></i>change pin</a>
                                 </li>-->
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
                        <div class="c-menu__item__inner"><a href="make_deposit.html"><i class="flaticon-settings"></i></a>
                        </div>
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
                                <li><a href="deposit_upload.php"> <i class="fa fa-circle"></i>upload deposit proof</a> </li>
                                <li><a href="deposit_history.html"> <i class="fa fa-circle"></i> deposit history</a></li>
                                <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i> earning history</a></li>-->
                                <li><a href="all_transactions.html"> <i class="fa fa-circle"></i>all transactions</a></li>
                                <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a> </li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="deposit_upload.php">
                            <div class="c-menu-item__title"><span>finances</span><i class="no_badge">3</i></div>
                        </a>
                        <ul>
                            <li><a href="deposit_upload.php"> <i class="fa fa-circle"></i>upload deposit proof</a></li>
                            <li><a href="deposit_history.html"> <i class="fa fa-circle"></i> deposit history</a></li>
                            <!--<li><a href="earnings_history.html"> <i class="fa fa-circle"></i>earning history</a></li>-->
                            <li><a href="all_transactions.html"> <i class="fa fa-circle"></i>all transactions</a> </li>
                            <!--<li><a href="transfer_fund.html"> <i class="fa fa-circle"></i>fund transfer</a></li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="investment.html"><i class="flaticon-file"></i></a></div>
                    </li>
                    <li class="c-menu__item crm_navi_icon_cont">
                        <a href="investment.html">
                            <div class="c-menu-item__title">view plans</div>
                        </a>
                    </li>
                </ul>
                <ul class="u-list crm_drop_second_ul">
                    <li class="crm_navi_icon">
                        <div class="c-menu__item__inner"><a href="tickets.html"><i class="flaticon-help"></i></a>
                            <ul class="crm_hover_menu">
                                <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a></li>-->
                                <li><a href="tickets.html"><i class="fa fa-circle"></i>support</a></li>
								<!--<li><a href="pending_history.html"><i class="fa fa-circle"></i>pending history</a></li>
								<li><a href="exchange_history.html"><i class="fa fa-circle"></i>exchange history</a></li>
								<li><a href="earnings_history.html"><i class="fa fa-circle"></i>earning history</a></li>-->
                            </ul>
                        </div>
                    </li>
                    <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                        <a href="tickets.html">
                            <div class="c-menu-item__title"><span>Help</span><i class="no_badge purple">1</i> </div>
                        </a>
                        <ul>
                            <!--<li><a href="all_transactions.html"><i class="fa fa-circle"></i> help articles</a></li>-->
                            <li><a href="tickets.html"><i class="fa fa-circle"></i>support</a></li>
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
                    <dt>Last Login</dt>
                    <dd>: &nbsp; <?php echo $user["last_login"]; ?></dd>
                    <dt>Last Access IP</dt>
                    <dd>: &nbsp; <?php echo $user["last_ip"]; ?> </dd>
                    <dt>Current IP</dt>
                    <dd>: &nbsp; <?php echo $_SERVER["REMOTE_ADDR"]; ?> </dd>

                </dl>

            </div>

            <div class="userdet user_transcation">
                <h3> Currently Subscribed Plan</h3>
                <dl class="userdescc">
                    <!-- Display Subscribed Plan -->
                    <dt><p>Active: </p></dt>
                    <dd><p><span id="selectedPlan"><?= $_SESSION['subscribed_plan']; ?></span></p></dd>
                </dl>
            </div>
        </div>
        <!--  my account wrapper end -->

        <!--  plan sub section start -->
            <div class="plan_investment_wrapper float_left">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="sv_heading_wraper">
                            <h4>Plan Details</h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                        <div class="investment_box_wrapper sv_pricing_border float_left">
                            <div class="investment_icon_circle">
                                <i class="flaticon-movie-tickets"></i>
                            </div>
                            <div class="investment_border_wrapper"></div>
                            <div id="gold" class="investment_content_wrapper" onclick="selectPlan('gold', 50000)">
                                <h1>Gold Plan</h1>
                                <p>Min Deposit: $50,000.00</p>
                                <p>Max Deposit: $100,000.00</p>
                                <p>Up to 52% for 30 Days</p>
                                <p>Compound Available</p>
                                <div class="about_btn plans_btn">
                                    <ul>
                                        <li>
                                        <a href="#">Choose Plan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>      
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                        <div class="investment_box_wrapper sv_pricing_border float_left">
                            <div class="investment_icon_circle red_info_circle">
                                <i class="flaticon-invoice"></i>
                            </div>
                            <div class="investment_border_wrapper red_border_wrapper"></div>
                            <div id="copper" class="investment_content_wrapper red_content_wrapper" onclick="selectPlan('copper', 15000)">
                                <h1>Copper Plan</h1>
                                <p>Min Deposit: $15,000</p>
                                <p>Max Deposit: $50,100</p>
                                <p>Up to 37% for 30 Days</p>
                                <p>Compound Available</p>
                                <!--<button>Select Plan</button>-->
                                <div class="about_btn plans_btn red_btn_plans">
                                    <ul>
                                        <li>
                                            <a href="#">choose plan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                        <div class="investment_box_wrapper sv_pricing_border float_left">
                            <div class="investment_icon_circle blue_icon_circle">
                                <i class="flaticon-progress-report"></i>
                            </div>
                            <div class="investment_border_wrapper blue_border_wrapper"></div>
                            <div id="bronze" class="investment_content_wrapper blue_content_wrapper" onclick="selectPlan('bronze', 5000)">
                                <h1>Bronze Plan</h1>
                                <p>Min Deposit: $5,000</p>
                                <p>Max Deposit: $15,100</p>
                                <p>Up to 28% for 30 Days</p>
                                <p>Compound Available</p>
                                <div class="about_btn plans_btn blue_btn_plans">
                                    <ul>
                                        <li>
                                            <a href="#">choose plan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                        <div class="investment_box_wrapper sv_pricing_border float_left">
                            <div class="investment_icon_circle green_info_circle">
                                <i class="flaticon-file"></i>
                            </div>
                            <div class="investment_border_wrapper green_border_wrapper"></div>
                            <div id="silver" class="investment_content_wrapper green_content_wrapper" onclick="selectPlan('silver', 2000)">
                                <h1>Silver Plan</h1>
                                <p>Min Deposit: $2,000</p>
                                <p>Max Deposit: $5,100</p>
                                <p>Up to 20% for 30 Days</p>
                                <p>Compound Available</p>
                                <div class="about_btn plans_btn green_plan_btn">
                                    <ul>
                                        <li>
                                            <a href="#">choose plan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
            <!--  plan sub section end -->
            <!--  payment mode wrapper start -->
            <div class="payment_mode_wrapper float_left">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="sv_heading_wraper">

                            <h3>choose payment mode</h3>

                        </div>

                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="payment_radio_btn_wrapper float_left">
                            <div class="radio">
                                <input type="radio" name="crypto" id="litecoin" value="LTC" onclick="updateBalance('LTC')">
                                <label for="litecoin"><img src="images/litecoin.png" alt="Litecoin"> Litecoin</label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="crypto" id="dogecoin" value="DOGE" onclick="updateBalance('DOGE')">
                                <label for="dogecoin"><img src="images/dogecoin.png" alt="Dogecoin"> Dogecoin</label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="crypto" id="ethereum" value="ETH" onclick="updateBalance('ETH')">
                                <label for="ethereum"><img src="images/ethereum.png" alt="Ethereum"> Ethereum</label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="crypto" id="bitcoin" value="BTC" onclick="updateBalance('BTC')">
                                <label for="bitcoin"><img src="images/bitcoin.png" alt="Bitcoin"> Bitcoin</label>
                            </div>
                            <div class="about_btn acc_balance_btn float_left">
                                <p>YOUR ACCOUNT BALANCE :</p>
                                <ul>
                                    <li>
                                        <p><span id="accountBalance"><a>$0.00</a></span></p>
                                    </li>
                                </ul>
                            </div>
                            <div class="about_btn float_left">
                                <ul>
                                    <li>
                                        <a href="#" onclick="submitSubscription()">submit</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  payment mode wrapper end -->
            <!--  footer  wrapper start -->
            <div class="copy_footer_wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="crm_left_footer_cont">
                                <p>2025 Copyright © <a href="#"> MuntMogul </a> . All Rights Reserved.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
         </div>
       <!--  footer  wrapper end -->      
    <!-- main box wrapper End-->
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