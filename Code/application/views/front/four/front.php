<!doctype html>
<html class="no-js" lang="zxx">

<!-- Mirrored from html.hixstudio.net/kleaso-prv/kleaso/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Apr 2024 04:35:27 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php $this->load->view('front/meta'); ?>
    <style>
        :root {
            --theme-color: <?= theme_color() ?>;
        }
    </style>
    <?php $google_analytics = google_analytics();
    if ($google_analytics) { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($google_analytics) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?= htmlspecialchars($google_analytics) ?>');
        </script>
    <?php } ?>




    <!-- CSS here -->
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/bootstrap.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/animate.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/swiper-bundle.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/splide.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/slick.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/nouislider.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/datepicker.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/magnific-popup.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/font-awesome-pro.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/flaticon_kleaso.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/circularProgressBar.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/spacing.css") ?>'>
    <link rel="stylesheet" href='<?= base_url("assets/front/four/css/main.css") ?>'>
    <link rel="stylesheet" href="<?= base_url('assets/front/comman.css') ?>">

</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->


    <!-- pre loader area start -->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <!-- loading content here -->
            </div>
        </div>
    </div>
    <!-- pre loader area end -->

    <!-- back to top start -->
    <div class="back-to-top-wrapper">
        <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <!-- back to top end -->


    <!-- header area start -->
    <header class="tp-header-2-area tp-header-height">
        <div class="tp-header-2-top d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="tp-header-2-top-info">
                            <ul>
                                <li class="tp-header-2-top-ml-60">
                                    <a href="tel:008757845682">
                                        <span><i class="flaticon-telephone-call"></i></span>051-6102534
                                    </a>
                                </li>
                                <li class="tp-header-2-top-ml-80">
                                    <a href="mailto:hr@mobipixels.com">
                                        <span><i class="flaticon-mail"></i></span>hr@mobipixels.com
                                    </a>
                                </li>
                                <li class="tp-header-2-top-ml-80">
                                    <a href="https://www.google.com/maps/place/MobiPixels/@33.5215515,73.0893157,17z/data=!4m16!1m9!3m8!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!2sMobiPixels!8m2!3d33.5215471!4d73.0918906!9m1!1b1!16s%2Fg%2F11kz3p6gj3!3m5!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!8m2!3d33.5215471!4d73.0918906!16s%2Fg%2F11kz3p6gj3?entry=ttu" target="_blank">
                                        <span>
                                            <i class="flaticon-location"></i>
                                        </span>Sector F DHA, Islamabad Capital Territory</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-sticky" class="tp-header-2-bottom header__sticky">
            <div class="container">
                <div class="header-wrapper p-relative z-index-1">
                    <div class="header-bg-shape"></div>
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-6 col-xl-2">
                            <div class="tp-header-logo tp-header-logo-border">
                                <a href="index.html">
                                    <img src='<?= base_url('assets/uploads/logos/' . full_logo()) ?>' height="50" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6 col-xl-10">
                            <div class="tp-main-menu-2-area d-flex align-items-center justify-content-end justify-content-xl-center justify-content-xxl-end">
                                <div class="tp-main-menu home-2">
                                    <nav id="tp-mobile-menu">
                                        <ul>
                                            <li><a href="#feature">Features</a></li>
                                            <li><a href="#featureItem">Pricing</a></li>
                                            <li> <a href="#contact">Contact</a></li>
                                            <li> <a href="<?= base_url('auth') ?>">Login</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="tp-header-2-right d-flex align-items-center">
                                    <div class="tp-header-btn d-none d-xl-block">
                                        <a class="tp-btn" href="<?= base_url('auth/register') ?>">
                                            Register</a>
                                    </div>
                                    <div class="mobile-menu d-block d-xl-none text-end">
                                        <button class="tp-side-action tp-toogle hamburger-btn">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header area end -->

    <!-- mobile menu style start -->
    <div class="tp-offcanvas-area fix">
        <div class="tp-side-info">
            <div class="tp-side-logo">
                <a href="index.html">
                    <img src='<?= base_url('assets/uploads/logos/' . full_logo()) ?>' height="30" alt="logo">
                </a>
            </div>
            <div class="tp-side-close">
                <button> <i class="fa-thin fa-xmark"></i></button>
            </div>
            <div class="tp-mobile-menu-pos"></div>
            <div class="tp-side-content p-relative">
                <div class="tp-sidebar__contact">
                    <h4 class="tp-sidebar-title">Contact Info</h4>
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="tp-sidebar__contact-text">
                                <a target="_blank" href="https://www.google.com/maps/place/MobiPixels/@33.5215515,73.0893157,17z/data=!4m16!1m9!3m8!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!2sMobiPixels!8m2!3d33.5215471!4d73.0918906!9m1!1b1!16s%2Fg%2F11kz3p6gj3!3m5!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!8m2!3d33.5215471!4d73.0918906!16s%2Fg%2F11kz3p6gj3?entry=ttu"><i class="fal fa-map-marker-alt"></i> Sector F DHA, Islamabad Capital Territory</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="tp-sidebar__contact-text">
                                <a href="telto:051-6102534"><i class="far fa-phone"></i> 051-6102534</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="tp-sidebar__contact-text">
                                <a href="mailto:hr@mobipixels.com"><i class="fal fa-envelope"></i> hr@mobipixels.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tp-sidebar-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-skype"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="offcanvas-overlay"></div>
    </div>
    <!-- mobile menu style end -->

    <main>
        <!-- hero area start -->
        <section class="tp-hero-2-area p-relative">
            <div class="hero-2-active splide">
                <div class="splide__arrows splide__arrows--ltr">
                    <button class="splide__arrow splide__arrow--prev">
                        <i class="fa-regular fa-arrow-left"></i>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <i class="fa-regular fa-arrow-right"></i>
                    </button>
                </div>
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide slider-item">
                            <div class="tp-hero-2-bg tp-hero-2-overlay">
                                <div class="bubbles"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="tp-hero-wrapper d-flex align-items-center">
                                                <div class="tp-hero-2-content">
                                                    <div class="tp-hero-title-wrapper">
                                                        <h5 class="tp-hero-2-title"><?= $this->lang->line('frontend_home_title') ? htmlspecialchars($this->lang->line('frontend_home_title')) : 'Professional Project Management tool and CRM' ?></h5>
                                                    </div>
                                                    <p><?= $this->lang->line('frontend_home_description') ? htmlspecialchars($this->lang->line('frontend_home_description')) : 'TimeWork pms.mobipixels.com is a perfect, robust, lightweight, superfast web application to fulfill all your Team Collaboration, Project Management and CRM needs.' ?></p>
                                                    <div class="tp-hero-2-btn d-flex flex-wrap align-items-center">
                                                        <a class="tp-btn" href="<?= base_url('auth/register') ?>" target="_blank">Get Started <i class="fa-regular fa-arrow-right-long"></i></a>
                                                        <span>Happy <br> Members</span>
                                                        <img src='<?= base_url("assets/front/four/img/hero/home-2/img-4.png") ?>' alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="tp-hero-2-thumb">
                                                <img src='<?= base_url("assets/front/four/img/hero/home-2/img-3.png") ?>' alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero area end -->

        <!-- brands area start -->
        <section class="tp-brands-2-area pt-75 pb-90 p-relative" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <form id="front_contact_form" method="POST" action="<?= base_url('front/send-mail') ?>">
                            <div class="tp-brands-from p-relative mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s" data-background='<?= base_url("assets/front/four/img/brand/home-2/form-img.jpg") ?>'>
                                <div class="tp-brands-from-overlay"></div>
                                <span class="tp-section__title-pre">CONTACT US</span>
                                <h3 class="tp-brands-title">GET A FREE QUOTE</h3>
                                <div class="tp-brands-from-input">
                                    <input type="text" placeholder="Full Name:">
                                </div>
                                <div class="tp-brands-from-input">
                                    <input type="email" placeholder="Email Address:">
                                </div>
                                <div class="tp-brands-from-input">
                                    <textarea name="message" placeholder="Write Message..."></textarea>
                                </div>
                                <button class="tp-btn">Submit Now <i class="fa-regular fa-arrow-right-long"></i></button>
                                <div class="w-full px-4 py-2 mt-1 text-left font-semibold text-white bg-red-500 rounded shadow-sm hidden result"></div>
                            </div>
                        </form>

                    </div>
                    <div class="col-lg-7 mb-30">
                        <div class="tp-brands-2-wrapper text-center mb-80">
                            <span class="tp-section__title-pre-2">
                                trusted partner’s
                            </span>
                            <h3 class="tp-section__title">Tursted By These Brands</h3>
                        </div>
                        <div class="tp-brands-2-top d-flex">
                            <div class="tp-brands-2-top-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-1.png") ?>' alt=""></a>
                            </div>
                            <div class="tp-brands-2-top-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-2.png") ?>' alt=""></a>
                            </div>
                            <div class="tp-brands-2-top-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-3.png") ?>' alt=""></a>
                            </div>
                            <div class="tp-brands-2-top-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-4.png") ?>' alt=""></a>
                            </div>
                        </div>
                        <div class="tp-brands-2-bottom d-flex">
                            <div class="tp-brands-2-bottom-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-5.png") ?>' alt=""></a>
                            </div>
                            <div class="tp-brands-2-bottom-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-6.png") ?>' alt=""></a>
                            </div>
                            <div class="tp-brands-2-bottom-img">
                                <a href="#"><img src='<?= base_url("assets/front/four/img/brand/home-2/img-7.png") ?>' alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- brands area end -->

        <?php if (frontend_permissions('features') && $features) {
        ?>
            <!-- our service area start -->
            <section class="tp-service-area fix tp-service-overlay pt-120 pb-110 p-relative" id="feature">
                <div class="tp-service-shape">
                    <img class="service-1" src="assets/img/services/shape-wrapper.png" alt="">
                    <img class="service-2" src="assets/img/services/shape-wrapper2.png" alt="">
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="tp-section-title-wrapper text-center mb-80">
                                <span class="tp-section__title-pre">
                                    Features
                                </span>
                                <h3 class="tp-section__title">What We are Offering</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="service-active splide wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                                <div class="splide__track">
                                    <div class="splide__list">
                                        <?php if ($features) {
                                            foreach ($features as $key => $feature) {
                                        ?>
                                                <div class="splide__slide">
                                                    <div class="tp-service-item p-relative" style="height: 400px;">
                                                        <div class="item-shape">
                                                            <img src="<?= base_url('assets/front/four/img/services/shape-item.png') ?>" alt="">
                                                        </div>
                                                        <div class="tp-service-thumb">
                                                            <i style="margin-top: 25px;" class="<?= isset($feature['icon']) ? htmlspecialchars($feature['icon']) : 'fa fa-fire' ?>"></i>
                                                        </div>
                                                        <h4 class="tp-service-title"><a href="service-details.html"><?= isset($feature['title']) ? htmlspecialchars($feature['title']) : '' ?></a></h4>
                                                        <p>
                                                            <?= isset($feature['description']) ? htmlspecialchars(substr($feature['description'], 0, 80)) . '...' : '' ?>
                                                        </p>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="tp-service-all-btn text-center mt-60">
                                <a class="tp-btn" href="service.html">All Services <i class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- our service area end -->
        <?php } ?>
        <!-- price area start -->
        <div id="featureItem" class="tp-pricing-area p-relative pt-120">
            <div class="tp-pricing-shape d-none d-lg-block">
                <img class="mousemove__image shape-1" src="assets/img/pricing/bublble-1.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-pricing-title-wrapper mb-50 text-center">
                            <div class="tp-inner-pre">
                                <span><i class="flaticon-mop"></i></span>
                            </div>
                            <h3 class="tp-section__title">price and planning</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="tab-content wow fadeInUp" id="nav-tabContent" data-wow-delay=".3s" data-wow-duration="1s">
                            <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel" aria-labelledby="nav-monthly-tab">
                                <div class="row">
                                    <?php foreach ($plans as $key => $plan) {
                                    ?>
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <div class="tp-pricing-item mb-30">
                                                <div class="tp-pricing-top text-center p-relative">
                                                    <div class="tp-pricing-plan">
                                                        <span><?= htmlspecialchars($plan['title']) ?></span>
                                                    </div>
                                                    <div class="tp-pricing-title-wrapper">
                                                        <h3 class="tp-price-title"><?= get_saas_currency('currency_symbol') ?><?= htmlspecialchars($plan['price']) ?></h3>
                                                        <p style="margin-top: -30px;" class="lowercase text-gray-500 text-xs">/
                                                            <?php
                                                            if ($plan['billing_type'] == 'One Time') {
                                                                echo $this->lang->line('one_time') ? htmlspecialchars($this->lang->line('one_time')) : 'One Time';
                                                            } elseif ($plan['billing_type'] == 'Monthly') {
                                                                echo $this->lang->line('monthly') ? htmlspecialchars($this->lang->line('monthly')) : 'Monthly';
                                                            } elseif ($plan["billing_type"] == 'three_days_trial_plan') {
                                                                echo $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'seven_days_trial_plan') {
                                                                echo $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'fifteen_days_trial_plan') {
                                                                echo $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'thirty_days_trial_plan') {
                                                                echo $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan';
                                                            } else {
                                                                echo $this->lang->line('yearly') ? htmlspecialchars($this->lang->line('yearly')) : 'Yearly';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <div class="tp-pricing-thumb">
                                                        <div class="tp-pricing-border">
                                                            <svg width="294" height="204" viewBox="0 0 294 204" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect class="line-dash-path" x="0.5" y="0.499878" width="293" height="203" stroke="#2144D8" stroke-opacity="0.25" stroke-dasharray="6 6" />
                                                            </svg>
                                                        </div>
                                                        <!-- <img src="<?= base_url("assets/front/four/img/pricing/img-1.png") ?>" alt=""> -->

                                                        <div class="tp-pricing-box">
                                                            <span class="box-shape top-left"></span>
                                                            <span class="box-shape top-right"></span>
                                                            <span class="box-shape bottom-left"></span>
                                                            <span class="box-shape bottom-right"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tp-pricing-content">
                                                    <div class="tp-pricing-content-feature">
                                                        <ul>
                                                            <!-- <li><i class="fa-light fa-circle-check"></i> Roof Cleaning</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Kitchen Cleaning</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Fully Profetional Cleaner</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Living Room Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Bed Room Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Windows & Door Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Bathroom Cleaning</li> -->
                                                            <?php $modules = '';
                                                            if ($plan["modules"] != '') {
                                                                foreach (json_decode($plan["modules"]) as $mod_key => $mod) {
                                                                    $mod_name = '';

                                                                    if ($mod_key == 'projects') {
                                                                        $mod_name = $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects';
                                                                    } elseif ($mod_key == 'tasks') {
                                                                        $mod_name = $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks';
                                                                    } elseif ($mod_key == 'kanban') {
                                                                        $mod_name = $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban';
                                                                    } elseif ($mod_key == 'agile') {
                                                                        $mod_name = $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile';
                                                                    } elseif ($mod_key == 'team_members') {
                                                                        $mod_name = $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Team Members';
                                                                    } elseif ($mod_key == 'clients') {
                                                                        $mod_name = $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients';
                                                                    } elseif ($mod_key == 'user_roles') {
                                                                        $mod_name = $this->lang->line('user_roles') ? $this->lang->line('user_roles') : 'Employee Roles';
                                                                    } elseif ($mod_key == 'departments') {
                                                                        $mod_name = $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments';
                                                                    } elseif ($mod_key == 'expenses') {
                                                                        $mod_name = $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses';
                                                                    } elseif ($mod_key == 'calendar') {
                                                                        $mod_name = $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar';
                                                                    } elseif ($mod_key == 'leaves') {
                                                                        $mod_name = $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves';
                                                                    } elseif ($mod_key == 'leave_hierarchy') {
                                                                        $mod_name = $this->lang->line('leave_hierarchy') ? $this->lang->line('leave_hierarchy') : 'Leave Hierarchy';
                                                                    } elseif ($mod_key == 'leaves_types') {
                                                                        $mod_name = $this->lang->line('leaves_types') ? $this->lang->line('leaves_types') : 'Leaves Types';
                                                                    } elseif ($mod_key == 'biometric_missing') {
                                                                        $mod_name = $this->lang->line('biometric_missing') ? $this->lang->line('biometric_missing') : 'Biometric Missing';
                                                                    } elseif ($mod_key == 'todo') {
                                                                        $mod_name = $this->lang->line('todo') ? $this->lang->line('todo') : 'Todo';
                                                                    } elseif ($mod_key == 'notes') {
                                                                        $mod_name = $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes';
                                                                    } elseif ($mod_key == 'chat') {
                                                                        $mod_name = $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat';
                                                                    } elseif ($mod_key == 'biometric_machine') {
                                                                        $mod_name = $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'biometric Machines';
                                                                    } elseif ($mod_key == 'payment_gateway') {
                                                                        $mod_name = $this->lang->line('payment_gateway') ? $this->lang->line('payment_gateway') : 'Payment Gateway';
                                                                    } elseif ($mod_key == 'taxes') {
                                                                        $mod_name = $this->lang->line('taxes') ? $this->lang->line('taxes') : 'Taxes';
                                                                    } elseif ($mod_key == 'custom_currency') {
                                                                        $mod_name = $this->lang->line('custom_currency') ? $this->lang->line('custom_currency') : 'Custom Currency';
                                                                    } elseif ($mod_key == 'user_permissions') {
                                                                        $mod_name = $this->lang->line('user_permissions') ? $this->lang->line('user_permissions') : 'User Permissions';
                                                                    } elseif ($mod_key == 'notifications') {
                                                                        $mod_name = $this->lang->line('notifications') ? $this->lang->line('notifications') : 'Notifications';
                                                                    } elseif ($mod_key == 'languages') {
                                                                        $mod_name = $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages';
                                                                    } elseif ($mod_key == 'meetings') {
                                                                        $mod_name = $this->lang->line('video_meetings') ? $this->lang->line('video_meetings') : 'Video Meetings';
                                                                    } elseif ($mod_key == 'estimates') {
                                                                        $mod_name = $this->lang->line('estimates') ? $this->lang->line('estimates') : 'Estimates';
                                                                    } elseif ($mod_key == 'reports') {
                                                                        $mod_name = $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports';
                                                                    } elseif ($mod_key == 'attendance') {
                                                                        $mod_name = $this->lang->line('attendance') ? htmlspecialchars($this->lang->line('attendance')) : 'Attendance';
                                                                    } elseif ($mod_key == 'support') {
                                                                        $mod_name = $this->lang->line('support') ? htmlspecialchars($this->lang->line('support')) : 'Support';
                                                                    }
                                                                    if ($mod_name && $mod == 1) {
                                                                        echo '<li><i class="fa-light fa-circle-check"></i>' . $mod_name . '</li>';
                                                                    } elseif ($mod_name) {
                                                                        echo '<li class="has-denied"><i class="fa-light fa-circle-xmark"></i>' . $mod_name . '</li>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="tp-pricing-content-btn text-center">
                                                        <a href="contact.html" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- price area end -->

        <!-- about area start -->
        <!-- <section id="mousemove" class="tp-about-2-area tp-about-2-bg p-relative pt-120 pb-85 fix">
            <div class="tp-about-2-shape">
                <div class="shape-1 d-none d-lg-block">
                    <img src='<?= base_url("assets/front/four/img/about/home-2/effect-1.png") ?>' alt="">
                </div>
                <div class="shape-2">
                    <img src='<?= base_url("assets/front/four/img/about/home-2/effect-2.png") ?>' alt="">
                </div>
                <div class="shape-3 d-none d-md-block">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/about/home-2/bubbles-1.png") ?>' alt="">
                </div>
                <div class="shape-4 d-none d-md-block">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/about/home-2/bubbles-2.png") ?>' alt="">
                </div>
                <div class="shape-5 d-none d-md-block">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/about/home-2/bubbles-3.png") ?>' alt="">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="tp-about-2-wrapper p-relative mb-30  wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                            <span class="tp-section__title-pre-2">about our company</span>
                            <h3 class="tp-section__title">quickly and easy to <br> clean your office and house.</h3>
                            <p>Standard dummy text ever since the unknown printer took <br> galley of scramble make a type specimen book printer took <br> type specimen book.</p>
                            <div class="tp-about-2-inner d-flex">
                                <div class="tp-about-inner-thumb">
                                    <i class="flaticon-medal"></i>
                                </div>
                                <div class="tp-about-inner-text">
                                    <h4 class="tp-about-title">Award Winning</h4>
                                    <p>Standard dummy text ever since the unknown <br> printer took Standard dummy text ever since the <br> unknown printer took.</p>
                                </div>
                            </div>
                            <div class="tp-about-2-btn">
                                <a class="tp-btn" href="service.html">Our Services <i class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="tp-about-2-thumb p-relative mb-30 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="tp-about-2-thumb-shape">
                                <div class="shape-1 d-none d-sm-block">
                                    <img src='<?= base_url("assets/front/four/img/about/home-2/img-4.png") ?>' alt="">
                                </div>
                                <div class="shape-3">
                                    <img src='<?= base_url("assets/front/four/img/about/home-2/effect-3.png") ?>' alt="">
                                </div>
                            </div>
                            <div class="row tp-gx-30">
                                <div class="col-6">
                                    <div class="tp-about-2-thumb-1">
                                        <img src='<?= base_url("assets/front/four/img/about/home-2/img-1.jpg") ?>' alt="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tp-about-2-thumb-2">
                                        <img src='<?= base_url("assets/front/four/img/about/home-2/img-2.jpg") ?>' alt="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="tp-about-2-thumb-3">
                                        <img src='<?= base_url("assets/front/four/img/about/home-2/img-3.jpg") ?>' alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- about area end -->



        <!-- team area start -->
        <!-- <section id="teamBubble" class="tp-team-2-area tp-team-2-bg pt-120 pb-90 p-relative">
            <div class="tp-team-2-shape">
                <img class="shape-1 d-none d-lg-block" src='<?= base_url("assets/front/four/img/team/home-2/shape-1.png") ?>' alt="">
                <img class="shape-2" src='<?= base_url("assets/front/four/img/team/home-2/shape-2.png") ?>' alt="">
                <img class="shape-3" src='<?= base_url("assets/front/four/img/team/home-2/shape-3.png") ?>' alt="">
                <img class="mousemove__image shape-4 d-none d-lg-block" src='<?= base_url("assets/front/four/img/team/home-2/bubble-1.png") ?>' alt="">
                <img class="shape-5 d-none d-lg-block" src='<?= base_url("assets/front/four/img/team/home-2/bubble-2.png") ?>' alt="">
                <img class="mousemove__image shape-6 d-none d-lg-block" src='<?= base_url("assets/front/four/img/team/home-2/bubble-3.png") ?>' alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="tp-team-2-wrapper p-relative">
                            <span class="tp-section__title-pre-2">meet our team</span>
                            <h3 class="tp-section__title">Qualified and <br> expert Members <br> of kleaso.</h3>
                            <p>Standard dummy text ever since the unknown printer took <br> galley of scramble make a type specimen book printer took <br> type specimen book.</p>
                            <div class="tp-team-2-btn">
                                <a class="tp-btn" href="contact.html">Join With Us <i class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row tp-gx-30">
                            <div class="col-md-6">
                                <div class="tp-team-2-thumb mb-30">
                                    <a href="team-details.html"><img src='<?= base_url("assets/front/four/img/team/home-2/img-1.jpg") ?>' alt=""></a>
                                    <div class="tp-team-2-social d-flex justify-content-center tp-btn-effect">
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-twitter"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-skype"></i></a>
                                    </div>
                                    <div class="tp-team-2-inner text-center">
                                        <h4 class="tp-team-title"><a href="team-details.html">James Asila</a></h4>
                                        <span>kitchen cleaner</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="tp-team-2-thumb mb-30">
                                    <a href="team-details.html"><img src='<?= base_url("assets/front/four/img/team/home-2/img-2.jpg") ?>' alt=""></a>
                                    <div class="tp-team-2-social d-flex justify-content-center tp-btn-effect">
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-twitter"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-skype"></i></a>
                                    </div>
                                    <div class="tp-team-2-inner text-center">
                                        <h4 class="tp-team-title"><a href="team-details.html">Edward Hillo</a></h4>
                                        <span>kitchen cleaner</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="tp-team-2-thumb mb-30">
                                    <a href="team-details.html"><img src='<?= base_url("assets/front/four/img/team/home-2/img-3.jpg") ?>' alt=""></a>
                                    <div class="tp-team-2-social d-flex justify-content-center tp-btn-effect">
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-twitter"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-skype"></i></a>
                                    </div>
                                    <div class="tp-team-2-inner text-center">
                                        <h4 class="tp-team-title"><a href="team-details.html">Mikaela Sheridan</a></h4>
                                        <span>kitchen cleaner</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="tp-team-2-thumb mb-30">
                                    <a href="team-details.html"><img src='<?= base_url("assets/front/four/img/team/home-2/img-4.jpg") ?>' alt=""></a>
                                    <div class="tp-team-2-social d-flex justify-content-center tp-btn-effect">
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-twitter"></i></a>
                                        <a class="tp-e-networks-link" href="#"><i class="fa-brands fa-skype"></i></a>
                                    </div>
                                    <div class="tp-team-2-inner text-center">
                                        <h4 class="tp-team-title"><a href="team-details.html">Stephen Wiwi</a></h4>
                                        <span>kitchen cleaner</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- team area end -->

        <!-- portfolio area start -->
        <!-- <section class="tp-portfolio-2-area pt-120 pb-200 fix">
            <div class="container">
                <div class="row align-items-center justify-content-center mb-25">
                    <div class="col-lg-12">
                        <div class="tp-portfolio-2-section-title-wrapper text-center">
                            <span class="tp-section__title-pre-2">
                                Our portfolio
                            </span>
                            <h3 class="tp-section__title">Recent Work Showcase</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="portfolio-active-2 splide wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="splide__arrows splide__arrows--ltr tp-btn-effect-blue">
                                <button class="splide__arrow splide__arrow--prev"><i class="fa-regular fa-arrow-left"></i>
                                </button>
                                <button class="splide__arrow splide__arrow--next"><i class="fa-regular fa-arrow-right"></i>
                                </button>
                            </div>
                            <div class="splide__track pt-35">
                                <div class="splide__list">
                                    <div class="splide__slide">
                                        <div class="tp-portfolio-thumb w-img p-relative">
                                            <a href="project-details.html"><img src='<?= base_url("assets/front/four/img/portfolio/portfolio-2.jpg") ?>' alt=""></a>
                                            <div class="tp-portfolio-info p-relative">
                                                <div class="tp-portfolio-content">
                                                    <div class="tp-portfolio-title">
                                                        <h4 class="tp-portfolio-content-title"><a href="project-details.html">Vehicle Cleaining</a></h4>
                                                        <p>clmmercial cleaner</p>
                                                    </div>
                                                    <div class="tp-portfolio-content-btn">
                                                        <a href="project-details.html"><i class="fa-regular fa-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-portfolio-thumb w-img">
                                            <a href="project-details.html"><img src='<?= base_url("assets/front/four/img/portfolio/Frame-1.jpg") ?>' alt=""></a>
                                            <div class="tp-portfolio-info p-relative">
                                                <div class="tp-portfolio-content">
                                                    <div class="tp-portfolio-title">
                                                        <h4 class="tp-portfolio-content-title"><a href="project-details.html">Home Cleaining</a></h4>
                                                        <p>clmmercial cleaner</p>
                                                    </div>
                                                    <div class="tp-portfolio-content-btn">
                                                        <a href="project-details.html"><i class="fa-regular fa-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-portfolio-thumb w-img">
                                            <a href="project-details.html"><img src='<?= base_url("assets/front/four/img/portfolio/Frame-2.jpg") ?>' alt=""></a>
                                            <div class="tp-portfolio-info p-relative">
                                                <div class="tp-portfolio-content">
                                                    <div class="tp-portfolio-title">
                                                        <h4 class="tp-portfolio-content-title"><a href="project-details.html">Dishes Cleaining</a></h4>
                                                        <p>clmmercial cleaner</p>
                                                    </div>
                                                    <div class="tp-portfolio-content-btn">
                                                        <a href="project-details.html"><i class="fa-regular fa-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-portfolio-thumb w-img">
                                            <a href="project-details.html"><img src='<?= base_url("assets/front/four/img/portfolio/Frame-3.jpg") ?>' alt=""></a>
                                            <div class="tp-portfolio-info p-relative">
                                                <div class="tp-portfolio-content">
                                                    <div class="tp-portfolio-title">
                                                        <h4 class="tp-portfolio-content-title"><a href="project-details.html">Office Cleaining</a></h4>
                                                        <p>clmmercial cleaner</p>
                                                    </div>
                                                    <div class="tp-portfolio-content-btn">
                                                        <a href="project-details.html"><i class="fa-regular fa-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-portfolio-thumb w-img">
                                            <a href="portfolio-details.html"><img src='<?= base_url("assets/front/four/img/portfolio/Frame-4.jpg") ?>' alt=""></a>
                                            <div class="tp-portfolio-info p-relative">
                                                <div class="tp-portfolio-content">
                                                    <div class="tp-portfolio-title">
                                                        <h4 class="tp-portfolio-content-title"><a href="project-details.html">Kicthen Cleaining</a></h4>
                                                        <p>clmmercial cleaner</p>
                                                    </div>
                                                    <div class="tp-portfolio-content-btn">
                                                        <a href="project-details.html"><i class="fa-regular fa-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- portfolio area end -->

        <!-- fun fact area start -->
        <!-- <section class="tp-counter-2-area p-relative">
            <div class="container">
                <div class="tp-counter-2-wrapper p-relative wow fadeInDown" data-wow-duration="1s" data-wow-delay=".3s">
                    <div class="tp-counter-2-shape">
                        <div class="shape-1 d-none d-lg-block">
                            <img src='<?= base_url("assets/front/four/img/counter/bubble-1.png") ?>' alt="">
                        </div>
                        <div class="shape-2 d-none d-lg-block">
                            <img src='<?= base_url("assets/front/four/img/counter/bubble-2.png") ?>' alt="">
                        </div>
                        <div class="shape-3 d-none d-lg-block">
                            <img src='<?= base_url("assets/front/four/img/counter/bubble-3.png") ?>' alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="tp-counter-2-inner p-relative mb-30">
                                <div class="tp-counter-thumb">
                                    <i class="flaticon-clean"></i>
                                </div>
                                <div class="tp-counter-content">
                                    <h4 data-purecounter-duration="1" data-purecounter-end="876" class="purecounter tp-counter-title">0</h4>
                                    <p>Happy Customer</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="tp-counter-2-inner-1 p-relative mb-30">
                                <div class="tp-counter-thumb">
                                    <i class="flaticon-cleaning-lady"></i>
                                </div>
                                <div class="tp-counter-content">
                                    <h4 data-purecounter-duration="1" data-purecounter-end="223" class="purecounter tp-counter-title">0</h4>
                                    <p>Team Mamber</p>
                                </div>
                                <div class="tp-counter-2-shape-2">
                                    <img src='<?= base_url("assets/front/four/img/counter/shape-3.png") ?>' alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="tp-counter-2-inner-2 p-relative mb-30">
                                <div class="tp-counter-thumb">
                                    <i class="flaticon-medal"></i>
                                </div>
                                <div class="tp-counter-content">
                                    <h4 data-purecounter-duration="1" data-purecounter-end="96" class="purecounter tp-counter-title">0</h4>
                                    <p>Award Winning</p>
                                </div>
                                <div class="tp-counter-2-shape-3 d-none d-lg-block">
                                    <img src='<?= base_url("assets/front/four/img/counter/shape-3.png") ?>' alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="tp-counter-2-inner-3 p-relative mb-30">
                                <div class="tp-counter-thumb">
                                    <i class="flaticon-thumbs-up"></i>
                                </div>
                                <div class="tp-counter-content">
                                    <h4 data-purecounter-duration="1.5" data-purecounter-end="7862" class="purecounter tp-counter-title">0</h4>
                                    <p>Project Complete</p>
                                </div>
                                <div class="tp-counter-2-shape-4">
                                    <img src='<?= base_url("assets/front/four/img/counter/shape-3.png") ?>' alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- fun fact area end -->

        <!-- testimonial area start -->
        <!-- <section id="testimonialBubble" class="tp-testimonial-2-area p-relative pt-120 pb-245 fix" data-background='<?= base_url("assets/front/four/img/testimonial/home-2/img.jpg") ?>'>
            <div class="tp-testimonial-2-overlay"></div>
            <div class="tp-testimonial-2-shapeimg d-none d-lg-block">
                <span>
                    <svg width="224" height="173" viewBox="0 0 224 173" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.8293 134.635C31.992 135.524 31.0012 134.335 29.7678 134.539L25.7144 136.879C25.1144 136.717 24.5543 136.566 23.8743 136.383C22.0009 137.058 20.0408 137.817 18.7422 139.956C21.3557 139.802 23.8132 139.671 26.296 139.525C25.9801 141.435 24.1053 141.23 23.3706 142.298C22.4252 142.064 21.6145 141.889 20.8038 141.713L17.9664 143.351L14.8062 142.499C14.7954 141.252 14.7847 140.005 14.782 138.889C12.0244 137.974 11.6272 139.626 11.1979 141.398C10.4672 141.244 9.71114 141.105 8.9551 140.965C8.81246 141.42 8.63381 141.93 8.43384 142.52C7.50324 144.243 5.4098 144.537 3.9458 145.687C4.57 148.172 3.23947 151.075 5.5384 153.067C5.32244 154.039 5.14916 154.85 4.95053 155.676L8.26576 161.419C7.96315 162.474 7.67519 163.555 7.34059 164.731L4.60456 166.31C4.34059 167.14 4.07262 167.905 3.78733 168.815C3.17271 169.915 0.551192 169.294 0.96606 172.002C3.99549 170.93 6.37017 169.017 9.22356 167.641C9.94232 168.242 10.7051 168.92 11.4931 169.583C15.0573 169.321 15.4731 165.828 17.3317 163.84L11.5081 153.754C12.3173 151.762 12.1878 149.431 13.7265 147.357C14.7838 147.492 15.8159 147.642 16.928 147.813L21.1081 145.399L25.5084 146.585C27.4963 144.353 31.0287 146.142 33.6766 143.766C34.9368 144.428 36.4156 145.234 37.2276 145.646L42.3197 142.706C44.8572 143.24 47.2427 143.861 49.6629 144.192C50.9056 144.355 52.7404 144.549 53.3937 143.867C55.563 141.598 59.1608 144.67 60.5913 141.473C61.722 141.735 62.5074 141.925 63.3582 142.112L66.2209 140.459C68.061 140.955 69.9132 141.647 71.8319 141.928C73.34 142.141 74.9214 141.838 77.1576 141.733L80.5016 139.802C82.8871 139.78 84.9605 139.802 87.4113 139.776L89.9194 138.328L94.1997 139.482L98.2277 137.156C99.1145 137.288 99.9065 137.373 100.979 137.533L104.804 135.325C106.912 135.7 108.708 135.476 110.386 134.169C110.607 133.499 110.875 132.734 111.149 131.864L118.192 127.798C118.367 127.223 118.545 126.713 118.741 126.058C119.672 124.335 121.765 124.041 123.28 122.862C123.392 121.476 124.215 120.561 125.229 119.568C125.912 118.937 126.425 117.252 126.051 116.486C125.349 115.095 125.473 113.906 125.942 112.788L122.847 107.427C121.058 106.258 119.76 105.415 118.437 104.586C116.911 103.639 115.008 102.975 113.944 101.659C112.865 100.317 110.627 100.829 110.257 98.8416C108.483 98.5781 107.283 97.6111 106.656 95.9403C104.793 97.219 104.62 94.8123 103.5 94.5104C101.365 93.9136 99.2235 93.4223 97.1581 92.8871C96.806 92.2773 96.5286 91.3872 96.2672 91.4026C94.4191 91.4194 93.7203 89.2144 92.2309 89.0919C89.096 88.8692 87.349 85.6093 84.1902 85.6376C82.6407 83.8898 79.7098 83.7864 78.907 81.1672C78.1083 81.8315 77.3442 81.5612 76.8575 80.8937C76.1987 79.9867 75.808 78.9589 77.2493 78.2961L76.0318 76.1872C75.2424 75.9316 74.5077 75.7121 73.7436 75.4418C74.0423 74.9645 74.2902 74.5165 74.5782 74.0792C76.1342 71.8596 78.8118 74.0402 80.5571 72.5582C82.1093 73.4915 83.6466 72.4684 85.1974 72.5216C86.4721 72.5648 87.7495 72.4371 89.0562 72.3602C89.8403 72.314 90.599 72.2825 91.3497 72.1201C95.9219 70.9709 97.0072 70.9202 100.604 71.8251C101.669 72.0908 102.702 72.4766 101.873 72.2101C106.347 72.2358 108.905 71.4022 111.492 72.3139C113.824 73.1356 116.163 73.2081 118.537 72.9896C120.362 72.8165 122.103 72.5564 124.013 73.1139C125.657 73.6214 127.785 73.68 129.361 73.075C131.195 72.3891 132.568 73.1884 134.084 73.5326C135.971 73.9339 137.808 74.6007 139.493 75.119C141.611 73.5231 143.345 75.063 145.525 75.3288C146.198 74.9739 147.14 74.4982 148.349 73.9016C150.429 73.8186 152.571 74.9536 155.128 74.5272C157.348 74.1601 159.88 75.6793 162.327 76.2315C163.033 76.4001 163.837 76.0376 164.61 76.0315C166.403 75.9785 168.318 75.5505 169.973 76.018C171.868 76.5501 173.853 75.7765 175.407 76.3024C178.568 77.3905 181.926 75.8925 184.953 77.5665C187.127 75.5995 189.987 76.6922 192.441 75.8516C194.95 77.2145 197.713 76.5002 200.265 76.4157C202.465 76.365 204.99 76.4661 207.047 74.9395C207.322 74.7132 208.083 75.1544 208.778 75.3631C209.024 74.6786 209.286 74.0196 209.543 73.2951C210.502 73.3175 211.691 73.681 212.426 73.2568C213.186 72.8181 213.531 71.6024 214.027 70.7063C214.718 70.8495 215.528 71.0251 216.459 71.233C217.367 69.9974 218.078 68.537 219.242 67.6278C220.355 66.7479 220.856 65.5099 221.668 64.6346C223.552 62.6322 224.374 60.8368 223.269 58.2222C223.1 57.8118 223.547 57.1813 223.631 56.6246C223.648 56.4791 223.44 56.2943 223.312 56.1311L221.712 55.6999C221.782 54.7105 221.853 53.7212 221.944 52.4155C220.921 51.9896 219.978 51.5854 218.875 51.138L216.484 46.9965C215.669 46.7555 214.88 46.4998 214.131 46.255C213.306 43.0721 209.282 42.8886 208.299 39.899C208.251 39.7574 207.743 39.8135 207.525 39.6688C204.944 38.0079 202.349 36.3217 199.78 34.6208C199.561 34.476 199.504 33.9671 199.358 33.9494C194.406 33.3871 191.495 28.4618 186.532 27.9395C185.345 26.1178 183.21 25.521 181.613 24.2752C180.223 23.2142 178.227 23.3842 176.675 21.8073C175.375 20.4915 172.78 20.7361 171.075 19.0107C169.898 17.7926 167.75 18.0504 166.115 16.6229C164.426 15.1592 161.56 15.052 159.331 14.4082L157.732 11.6387C155.212 10.9595 152.345 9.97232 149.401 9.43627C146.416 8.88944 144.508 5.99371 141.368 6.11284C140.537 4.9664 139.75 3.89618 138.993 2.87678C137.861 3.02222 136.845 3.13456 135.858 3.29771C133.754 3.63171 132.871 0.347247 131.126 1.18555C128.895 2.23632 127.471 0.179052 125.456 0.901855C125.57 2.97059 125.732 5.41734 125.922 8.72947C124.082 8.23354 122.576 7.84926 121.122 7.43572C121.571 8.5652 122.131 10.0034 122.875 11.8774C120.079 11.1882 117.763 10.6283 115.312 10.0107C114.818 10.4995 114.262 11.0577 113.074 12.2178C115.347 12.2942 116.952 12.3836 117.911 12.406L119.217 14.6673C121.377 15.2495 123.537 15.8317 125.817 16.4462L127.431 19.241C129.834 19.717 132.236 20.193 134.349 20.6335C134.867 22.4682 135.857 22.7778 136.93 23.1743C137.844 23.5278 138.502 24.4348 139.236 25.0615C139.873 24.7613 140.369 24.5088 141.007 24.2086C141.965 24.8746 143.019 25.5876 144.032 26.2898L145.578 25.3976C146.631 26.1106 147.638 26.9183 148.799 27.4673C149.786 27.9478 151.386 27.7354 151.902 28.4538C152.817 29.6872 153.905 30.1092 155.24 30.4904C158.309 31.3606 161.634 31.6772 164.102 34.0803C166.515 33.8725 167.813 36.003 169.728 36.8623C171.129 37.476 171.952 39.1352 173.789 39.1584C175.271 39.15 176.018 40.8531 177.058 41.1334C183.323 42.8007 187.481 47.9547 193.196 50.4819C194.815 53.5785 199.061 54.3795 199.921 58.7949C199.829 59.2207 199.592 60.2724 199.359 61.3895C198.956 61.4526 198.522 61.6358 198.136 61.5534C195.272 61.0389 192.504 62.7387 189.648 61.7114C188.302 63.3012 186.52 61.3832 185.079 62.2824C183.679 63.1923 182.385 62.1783 181.181 61.7894C179.562 61.2673 178.118 62.7446 176.479 61.8953C175.598 61.4218 174.241 61.1206 173.397 61.4724C171.583 62.2491 170.183 61.2282 168.667 60.8839C167.31 60.5828 166.293 61.7461 164.78 61.2309C163.441 60.7843 161.73 61.9752 160.193 61.0674C158.874 60.3043 157.63 61.1919 156.345 61.1887C153.708 61.1863 151.323 58.6339 148.489 60.3375C146.129 59.7014 143.769 59.0653 141.689 58.5047L138.598 60.2891C135.967 59.3011 132.882 58.1692 130.56 57.3075C129.083 58.0249 128.436 58.6016 128.177 58.446C126.575 57.5421 124.903 59.151 123.533 58.4172C121.198 57.1229 118.692 58.8072 116.463 57.7562C114.155 56.6836 111.741 58.5858 109.347 57.1898C108.422 56.6401 106.842 57.1797 105.549 57.282C101.064 57.7036 96.589 58.0852 92.5074 56.1055C92.026 56.3834 91.7913 56.6205 91.53 56.6359C80.6948 57.2341 69.9249 57.8285 58.4763 58.476L54.8536 60.5676C54.0029 60.3812 53.2068 60.2311 52.3307 60.0593L43.7933 64.9884C43.0267 67.4636 41.8935 69.9472 42.7737 72.759C42.8738 73.1077 41.7631 73.8167 41.1818 74.3895C40.9832 76.5029 42.7514 77.7518 43.4476 79.4841C44.237 79.7398 45.0117 79.97 45.8264 80.211L47.44 83.0059C48.2694 83.2723 49.0588 83.528 49.7682 83.7621C50.2229 84.5497 50.4684 85.5599 51.0951 85.9433C52.8766 86.9813 54.2234 88.8461 56.4289 89.0972C58.173 89.3098 59.1185 90.8304 60.5119 91.3132C62.3201 91.9293 63.2309 93.7409 65.3097 94.0652C67.0178 94.3325 68.5287 95.6622 70.1782 96.4715C72.301 97.5156 74.4599 98.5051 76.6147 99.4291C78.8095 100.364 80.5191 102.155 83.0446 102.492C84.2473 102.645 84.6835 104.629 86.3022 104.507C87.6104 106.598 89.9199 106.619 92.0587 107.282L93.6723 110.076C95.2618 110.548 96.8512 111.019 97.466 111.206C99.0301 112.336 99.8795 112.929 99.3328 112.567C101.092 113.449 101.448 113.481 101.565 113.684C102.691 115.575 103.791 117.48 104.803 119.234C104.462 120.515 104.199 121.581 103.896 122.636C103.086 122.461 102.3 122.271 101.515 122.08C99.9176 123.409 97.9508 122.986 96.2867 123.439C94.5066 123.925 92.6918 122.77 90.8518 124.205C89.6518 125.169 87.2997 125.308 85.6742 124.891C83.7581 124.439 81.9554 126.056 80.1979 124.767L75.1565 127.677C75.8086 128.046 76.4606 128.415 77.102 128.824C77.5247 129.088 77.8861 129.421 78.0955 129.843L81.8449 127.678C85.7678 128.564 85.7465 128.644 85.6667 131.84C83.597 128.665 80.5197 131.526 78.1208 129.828C77.8421 129.989 77.3315 130.216 76.9048 130.53C76.0914 131.169 75.3567 130.95 74.83 130.271C74.1712 129.364 73.7805 128.336 75.2072 127.648C74.059 126.245 72.5189 126.151 70.9148 126.298C69.1548 126.468 67.296 127.168 65.6853 126.777C63.7945 126.31 62.0465 127.963 60.289 126.674C58.873 128.609 56.5514 125.817 55.0114 127.655C54.8274 127.862 53.578 127.161 53.0686 126.981L47.7992 130.023C48.2112 130.327 48.8033 131.002 48.9806 130.899C50.8233 129.937 52.4861 130.535 54.445 131.471C52.6983 133.36 50.3356 134.182 48.6969 135.264C46.0288 135.381 43.7673 135.501 41.4659 135.611L42.6834 137.719C44.7115 137.429 46.7476 137.27 48.6918 138.18C48.4905 139.821 46.8905 140.677 45.9424 140.614C43.2836 140.456 40.3049 142.142 37.9699 139.56C35.8673 141.418 33.2377 140.022 30.9283 140.644C30.863 140.648 30.6789 140.212 30.8082 139.968C29.7642 140.266 28.7082 141.011 28.9627 139.171C29.5121 139.362 30.0762 139.578 30.8082 139.968C31.6762 139.366 32.7909 138.722 33.9309 138.064C35.363 138.321 36.9418 138.189 37.9846 139.585L39.8086 138.532C40.4486 137.417 40.9445 136.521 41.4552 135.651L39.4308 132.144C37.1974 132.079 36.3318 129.292 34.0157 129.376C32.3423 129.462 30.6835 129.572 29.0354 129.643C28.5089 132.183 30.6824 131.91 31.9785 132.517C32.2439 133.211 32.6399 133.897 32.8293 134.635C33.8734 134.337 34.9294 133.591 34.6748 135.432C34.1108 135.216 33.5614 135.025 32.8293 134.635ZM70.4742 76.4486C72.4276 76.4388 72.4276 76.4388 72.9091 78.7354C71.0557 79.0941 71.2703 77.2425 70.9822 76.3925C69.6768 76.7057 68.6355 77.4763 68.8647 75.6502C69.4141 75.8411 69.9635 76.0321 70.4742 76.4486ZM58.0517 129.761C60.5319 130.43 63.1721 131.141 65.8269 131.878C65.907 131.9 65.891 132.282 65.9297 132.7L62.8389 134.484C60.8321 134.051 58.956 133.609 57.0292 133.197C56.7811 132.358 56.5918 131.62 56.421 130.974C57.0104 130.532 57.437 130.218 58.0517 129.761ZM71.2966 132.108C72.7394 132.969 73.4728 134.239 73.5063 136.286C72.7236 136.569 71.8649 136.895 70.7489 137.302C71.0288 136.091 71.2315 135.33 71.4194 134.544C70.7873 133.215 70.7873 133.215 71.2966 132.108ZM92.9081 126.948C94.9496 127.734 95.7857 129.182 95.4312 131.318C93.379 130.572 92.5429 129.124 92.9081 126.948ZM82.0895 137.463C80.5321 136.871 79.1787 137.043 78.2759 136.006C78.6905 134.852 79.4865 134.358 81.068 134.699C81.348 135.418 81.6908 136.304 82.0895 137.463ZM129.168 12.4791C129.166 12.8864 129.191 13.279 129.204 13.7117C128.964 13.647 128.517 13.6339 128.469 13.4923C128.354 13.1181 128.381 12.6962 128.368 12.2635L129.168 12.4791ZM166.51 32.2835C166.19 32.1972 165.95 32.1325 165.71 32.0678C165.951 31.7253 166.123 31.3211 166.408 31.0547C166.52 30.9562 166.874 31.1587 167.154 31.2341C166.912 31.5767 166.711 31.9301 166.51 32.2835ZM64.7365 136.776C64.6512 137.096 64.5872 137.337 64.5232 137.577C64.1806 137.334 63.7765 137.161 63.5098 136.875C63.4111 136.762 63.6125 136.409 63.6871 136.129C64.0298 136.371 64.3978 136.599 64.7365 136.776Z" fill="currentColor" />
                    </svg>
                </span>
            </div>
            <div class="tp-testimonial-2-bubble d-none d-xl-block">
                <div class="shape-1">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/testimonial/home-2/bubble-1.png") ?>' alt="">
                </div>
                <div class="shape-2">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/testimonial/home-2/bubble-2.png") ?>' alt="">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-testimonial-2-section-title-wrapper text-center">
                            <span class="tp-section__title-pre-2">HAPPY CUSTOMER</span>
                            <h3 class="tp-section__title mb-70">OUR LOVELY CUSTOMER</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="testimonial-active-2 splide wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="splide__arrows splide__arrows--ltr">
                                <button class="splide__arrow splide__arrow--prev">
                                    <i class="fa-regular fa-arrow-left"></i>
                                </button>
                                <button class="splide__arrow splide__arrow--next">
                                    <i class="fa-regular fa-arrow-right"></i>
                                </button>
                            </div>
                            <div class="splide__track">
                                <div class="splide__list">
                                    <div class="splide__slide">
                                        <div class="tp-testimonial-2-wrapper">
                                            <div class="tp-testimonial-2-shape">
                                                <img src='<?= base_url("assets/front/four/img/testimonial/home-2/shape.png") ?>' alt="">
                                            </div>
                                            <p>“Galley of type and scrambled it to make type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting chunks first true generator on the Internet.</p>
                                            <h3 class="tp-testimonial-title">Remedios Linared</h3>
                                            <span>Web Developer</span>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-testimonial-2-wrapper">
                                            <div class="tp-testimonial-2-shape">
                                                <img src='<?= base_url("assets/front/four/img/testimonial/home-2/shape.png") ?>' alt="">
                                            </div>
                                            <p>“Galley of type and scrambled it to make type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting chunks first true generator on the Internet.</p>
                                            <h3 class="tp-testimonial-title">Nadine Hansen</h3>
                                            <span>Graphic Designer</span>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-testimonial-2-wrapper">
                                            <div class="tp-testimonial-2-shape">
                                                <img src='<?= base_url("assets/front/four/img/testimonial/home-2/shape.png") ?>' alt="">
                                            </div>
                                            <p>“Galley of type and scrambled it to make type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting chunks first true generator on the Internet.</p>
                                            <h3 class="tp-testimonial-title">Remedios Linared</h3>
                                            <span>Web Developer</span>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-testimonial-2-wrapper">
                                            <div class="tp-testimonial-2-shape">
                                                <img src='<?= base_url("assets/front/four/img/testimonial/home-2/shape.png") ?>' alt="">
                                            </div>
                                            <p>“Galley of type and scrambled it to make type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting chunks first true generator on the Internet.</p>
                                            <h3 class="tp-testimonial-title">Nadine Hansen</h3>
                                            <span>Graphic Designer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- testimonial area end -->

        <!-- blog area start -->
        <!-- <section id="blogBubble" class="tp-blog-2-area p-relative pt-120 pb-90">
            <div class="tp-blog-2-shape d-none d-md-block">
                <div class="shape-1">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/blog/home-2/bubble-1.png") ?>' alt="">
                </div>
                <div class="shape-2">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/blog/home-2/bubble-2.png") ?>' alt="">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-blog-2-section-title-wrapper text-center mb-80">
                            <span class="tp-section__title-pre-2">
                                latest news
                            </span>
                            <h3 class="tp-section__title">latest blog and article</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="tp-blog-start home-2 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="tp-blog-inner home-2" data-background='<?= base_url("assets/front/four/img/blog/blog-3.jpg") ?>'>
                                <h3 class="tp-blog-title">Get Started <br> With Your Free <br> Estimate.</h3>
                                <div class="tp-blog-start-btn">
                                    <a class="tp-btn" href="contact.html">Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="blog-active-2 splide  wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="splide__track">
                                <div class="splide__list">
                                    <div class="splide__slide">
                                        <div class="tp-blog-2-wrapper mb-30">
                                            <div class="tp-blog-2-thumb p-relative">
                                                <a href="blog-details.html"><img src='<?= base_url("assets/front/four/img/blog/home-2/img-1.jpg") ?>' alt=""></a>
                                            </div>
                                            <div class="tp-blog-2-content p-relative">
                                                <span class="date">28 <br> <i>AUGUST</i></span>
                                                <h3 class="tp-blog-title"><a href="blog-details.html">predefined chunk necessary the Internet.</a></h3>
                                                <div class="tp-blog-btn">
                                                    <a class="tp-btn" href="blog-details.html">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-blog-2-wrapper mb-30">
                                            <div class="tp-blog-2-thumb p-relative">
                                                <a href="blog-details.html"><img src='<?= base_url("assets/front/four/img/blog/home-2/img-2.jpg") ?>' alt=""></a>
                                            </div>
                                            <div class="tp-blog-2-content p-relative">
                                                <span class="date">16 <br> <i>february</i></span>
                                                <h3 class="tp-blog-title"><a href="blog-details.html">the Internet is a With chunk .</a></h3>
                                                <div class="tp-blog-btn">
                                                    <a class="tp-btn" href="blog-details.html">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-blog-2-wrapper mb-30">
                                            <div class="tp-blog-2-thumb p-relative">
                                                <a href="blog-details.html"><img src='<?= base_url("assets/front/four/img/blog/home-2/img-1.jpg") ?>' alt=""></a>
                                            </div>
                                            <div class="tp-blog-2-content p-relative">
                                                <span class="date">28 <br> <i>AUGUST</i></span>
                                                <h3 class="tp-blog-title"><a href="blog-details.html">Determine what topics you’ll cover.</a></h3>
                                                <div class="tp-blog-btn">
                                                    <a class="tp-btn" href="blog-details.html">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide__slide">
                                        <div class="tp-blog-2-wrapper mb-30">
                                            <div class="tp-blog-2-thumb p-relative">
                                                <a href="blog-details.html"><img src='<?= base_url("assets/front/four/img/blog/home-2/img-2.jpg") ?>' alt=""></a>
                                            </div>
                                            <div class="tp-blog-2-content p-relative">
                                                <span class="date">16 <br> <i>february</i></span>
                                                <h3 class="tp-blog-title"><a href="blog-details.html">Create your blog domain name.</a></h3>
                                                <div class="tp-blog-btn">
                                                    <a class="tp-btn" href="blog-details.html">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-slider-progress">
                                <div class="blog-slider-progress-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- blog area end -->
    </main>

    <!-- footer area start -->
    <footer id="footerTwo" class="tp-footer-2-area p-relative">
        <div class="tp-footer-2-wrapper" data-background='<?= base_url("assets/front/four/img/footer/home-2/footer-img.jpg") ?>'>
            <div class="tp-footer-2-overlay"></div>
            <div class="tp-footer-2-shape d-none d-md-block">
                <div class="shape-1">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/footer/home-2/bubble.png") ?>' alt="">
                </div>
                <div class="shape-2">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/footer/home-2/bubble-2.png") ?>' alt="">
                </div>
                <div class="shape-4">
                    <img class="mousemove__image" src='<?= base_url("assets/front/four/img/footer/home-2/bubble-4.png") ?>' alt="">
                </div>
            </div>
            <div class="tp-footer-inner-content pt-80">
                <div class="tp-footer-2-widget-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="tp-footer-2-widget mb-30">
                                    <span class="mb-30">Contact Us</span>
                                    <div class="tp-footer-2-widget-contact d-flex align-items-center mb-30">
                                        <a class="icon" href="#"><i class="flaticon-telephone-call"></i></a>
                                        <div class="contact-inner">
                                            <p>Phone:</p>
                                            <a href="tel:">051-6102534</a>
                                        </div>
                                    </div>
                                    <div class="tp-footer-2-widget-contact d-flex align-items-center">
                                        <a class="icon" href="#"><i class="flaticon-mail"></i></a>
                                        <div class="contact-inner">
                                            <p>E-mail:</p>
                                            <a href="mailto:">info@gmail.com</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-8 col-xl-5 order-3 order-lg-2 tp-footer-2-widget-space">
                                <div class="tp-footer-2-widget-1">
                                    <span class="mb-30 ">Quick Links</span>
                                    <ul class="tp-footer-list-float">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Pricing</a></li>
                                        <li><a href="#">Contact</a></li>
                                        <li><a href="#">Team Members</a></li>
                                        <li><a href="#">Support</a></li>
                                        <li><a href="#">Cookie & Policy</a></li>
                                        <li><a href="#">Privacy & Policy</a></li>
                                        <li><a href="#">Terms & Condition</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-footer-2-copyright">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6 col-lg-4">
                            <div class="tp-footer-2-logo">
                                <a href="index.html"><img src='<?= base_url('assets/uploads/logos/' . full_logo()) ?>' height="40" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="tp-btn-effect">
                                <div class="tp-footer-2-social text-md-center d-flex align-items-center">
                                    <span>Follow Us:</span>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-skype"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="tp-footer-2-copyright-text">
                                <p class="text-xl-end"><?= htmlspecialchars(footer_text()) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->



    <!-- JS here -->
    <script src="<?= base_url('assets/front/four/js/vendor/jquery.js') ?>"></script>
    <!-- <script src='<?= base_url("assets/front/four/js/vendor/jquery.js") ?>'></script> -->
    <script src='<?= base_url("assets/front/four/js/vendor/waypoints.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/bootstrap-bundle.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/meanmenu.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/swiper-bundle.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/splide.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/slick.min.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/nouislider.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/magnific-popup.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/nice-select.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/wow.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/datepicker.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/isotope-pkgd.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/imagesloaded-pkgd.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/jquery.appear.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/jquery.knob.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/circularProgressBar.min.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/purecounter.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/ajax-form.js") ?>'></script>
    <script src='<?= base_url("assets/front/four/js/main.js") ?>'></script>
    <script>
        site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
    </script>
    <?php $recaptcha_site_key = get_google_recaptcha_site_key();
    if ($recaptcha_site_key) { ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?= htmlspecialchars($recaptcha_site_key) ?>"></script>
    <?php } ?>
    <script src="<?= base_url('assets/front/comman.js') ?>"></script>
    <script>
        function showDropdownOptions() {
            document.getElementById("options").classList.toggle("hidden");
            document.getElementById("arrow-up").classList.toggle("hidden");
            document.getElementById("arrow-down").classList.toggle("hidden");
        }
    </script>
</body>

</html>