<!doctype html>
<html class="no-js" lang="zxx">

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
                                <a href="<?= base_url() ?>">
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
                                            <li> <a href="#company">Our Company</a></li>
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
                <a href="<?= base_url() ?>">
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
                                                        <h5 class="tp-hero-2-title"><?= $this->lang->line('frontend_home_title') ? htmlspecialchars($this->lang->line('frontend_home_title')) : 'Efficient Solutions for Business Management' ?></h5>
                                                    </div>
                                                    <p><?= $this->lang->line('frontend_home_description') ? htmlspecialchars($this->lang->line('frontend_home_description')) : 'Our premier solution maximizes productivity with streamlined collaboration. Focused on simplicity and efficiency, it empowers success. Utilizing cutting-edge tech and expert support, our platform offers seamless management of operations and relationships.' ?></p>
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
        <section class="tp-brands-2-area pt-75 pb-90 p-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <form id="front_contact_form" method="POST" action="<?= base_url('front/send-mail') ?>">
                            <div class="tp-brands-from p-relative mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s" data-background='<?= base_url("assets/front/four/img/brand/home-2/form-img.jpg") ?>'>
                                <div class="tp-brands-from-overlay"></div>
                                <span class="tp-section__title-pre">CONTACT US</span>
                                <h3 class="tp-brands-title">GET A FREE QUOTE</h3>
                                <div class="tp-brands-from-input">
                                    <input type="text" name="name" placeholder="Full Name:">
                                </div>
                                <div class="tp-brands-from-input">
                                    <input type="email" name="email" placeholder="Email Address:">
                                </div>
                                <div class="tp-brands-from-input">
                                    <textarea name="msg" placeholder="Write Message..."></textarea>
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
                    <img class="service-1" src="<?= base_url('assets/front/four/img/services/shape-wrapper.png') ?>" alt="">
                    <img class="service-2" src="<?= base_url('assets/front/four/img/services/shape-wrapper2.png') ?>" alt="">
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
                </div>
            </section>
            <!-- our service area end -->
        <?php } ?>
        <!-- price area start -->
        <div id="featureItem" class="tp-pricing-area p-relative pt-120">
            <div class="tp-pricing-shape d-none d-lg-block">
                <img class="mousemove__image shape-1" src="<?= base_url('assets/front/four/img/pricing/bublble-1.png') ?>" alt="">
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
                                                <div class="tp-pricing-top p-relative">
                                                    <div class="tp-pricing-plan text-center ">
                                                        <span><?= htmlspecialchars($plan['title']) ?></span>
                                                    </div>
                                                    <div class="tp-pricing-title-wrapper text-center ">
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
                                                    <div class="ms-3 flex justify-content-start mb-2">
                                                        <ul class="text-xl">
                                                            <li style="list-style: none;"><span class="badge bg-secondary mx-3"><?= $plan['storage'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['storage'] . ' GB') ?></span><?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?></li>

                                                            <li style="list-style: none;"><span class="badge bg-secondary mx-3"><?= $plan['projects'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['projects']) ?></span> <?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?></li>

                                                            <li style="list-style: none;"><span class="badge bg-secondary mx-3"><?= $plan['tasks'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['tasks']) ?></span> <?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?></li>

                                                            <li style="list-style: none;"><span class="badge bg-secondary mx-3"><?= $plan['users'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['users']) ?></span> <?= $this->lang->line('users') ? $this->lang->line('users') : 'Users' ?>
                                                        </ul>
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
                                                        <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
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
        <!-- price area end -->
        <!-- about area start -->
        <section class="tp-about-area pt-120 pb-120" id="company">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row tp-gx-20 ">
                            <div class="tp-about-thumb-wrapper wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                                <div class="tp-about-thumb">
                                    <img src="<?= base_url('assets/front/four/img/about/img-1.jpg') ?>" alt="">
                                </div>
                                <div class="tp-about-thumb p-relative">
                                    <img class="mb-20" src="<?= base_url('assets/front/four/img/about/img-2.jpg') ?>" alt="">
                                    <div class="skill__progress-circle mr-30">
                                        <div class="progress-circular">
                                            <input type="text" class="knob" value="0" data-rel="100" data-linecap="round" data-width="140" data-height="140" data-bgcolor="#fff" data-fgcolor="#ffc700" data-thickness=".15" data-readonly="true" disabled>
                                        </div>
                                        <h4>Project Success</h4>
                                    </div>
                                    <img src="<?= base_url('assets/front/four/img/about/img-3.jpg') ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="tp-about-section-title-wrapper wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                            <span class="tp-section__title-pre">
                                about our company
                            </span>
                            <h3 class="tp-section__title mb-25">Efficient Software Solutions by Airnet-Technologies</h3>
                            <p>Airnet-Technologies offers rapid, user-friendly software solutions tailored for streamlined operations. Our expert team ensures efficiency and excellence in every digital experience.</p>
                            <div class="tp-about-inner-wrapper d-flex flex-wrap">
                                <div class="tp-about-inner d-flex">
                                    <div class="tp-about-inner-thumb">
                                        <i class="flaticon-cpu"></i>
                                    </div>
                                    <div class="tp-about-inner-text">
                                        <h4 class="tp-about-inner-title">Mobile Application</h4>
                                        <p>Since the unknown printer took <br> we develop mobile app.</p>
                                    </div>
                                </div>
                                <div class="tp-about-inner d-flex">
                                    <div class="tp-about-inner-thumb">
                                        <i class="flaticon-cpu"></i>
                                    </div>
                                    <div class="tp-about-inner-text">
                                        <h4 class="tp-about-inner-title">Artificial Intelligence</h4>
                                        <p>Transforming operations, <br> decisions, experiences with AI.</p>
                                    </div>
                                </div>
                                <div class="tp-about-inner d-flex">
                                    <div class="tp-about-inner-thumb">
                                        <i class="flaticon-cpu"></i>
                                    </div>
                                    <div class="tp-about-inner-text">
                                        <h4 class="tp-about-inner-title">Website Development</h4>
                                        <p>Revolutionizing web development, <br> innovation, efficiency, excellence.</p>
                                    </div>
                                </div>
                                <div class="tp-about-inner d-flex">
                                    <div class="tp-about-inner-thumb">
                                        <i class="flaticon-cpu"></i>
                                    </div>
                                    <div class="tp-about-inner-text">
                                        <h4 class="tp-about-inner-title">Graphic Designing</h4>
                                        <p>Elevating graphic design, <br> creativity, precision, impact.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tp-about-btn">
                                <a class="tp-btn" href="#">Our Services <i class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about area end -->
        <!-- team area start -->
        <section class="tp-team-area pt-120 pb-80 p-relative">
            <div class="tp-team-bg" data-background="assets/img/team/team-bg.jpg"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tp-team-section-title-wrapper text-center mb-70">
                            <span class="tp-section__title-pre">
                                Our Team
                            </span>
                            <h3 class="tp-section__title">Qualified Team Member</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="tp-team-wrapper p-relative wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="tp-team-thumb">
                                <a href="#"><img src="<?= base_url('assets/front/four/img/team/team-1.png') ?>" alt=""></a>
                            </div>
                            <div class="tp-team-content text-center mt-30">
                                <h4 class="tp-team-title-1"><a href="#">Muhammad Aman</a></h4>
                                <p>Project Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="tp-team-wrapper p-relative wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="tp-team-thumb">
                                <a href="#"><img src="<?= base_url('assets/front/four/img/team/team-2.png') ?>" alt=""></a>
                            </div>
                            <div class="tp-team-content text-center mt-30">
                                <h4 class="tp-team-title-1"><a href="#">Mohsin Ali</a></h4>
                                <p>Graphic Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="tp-team-wrapper p-relative wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="tp-team-thumb">
                                <a href="#"><img src="<?= base_url('assets/front/four/img/team/team-3.png') ?>" alt=""></a>
                            </div>
                            <div class="tp-team-content text-center mt-30">
                                <h4 class="tp-team-title-1"><a href="#">Hurira Abbasi</a></h4>
                                <p>SQA Engineer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="tp-team-wrapper p-relative wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="tp-team-thumb">
                                <a href="#"><img src="<?= base_url('assets/front/four/img/team/team-4.png') ?>" alt=""></a>
                            </div>
                            <div class="tp-team-content text-center mt-30">
                                <h4 class="tp-team-title-1"><a href="#">Muhammad Shoaib</a></h4>
                                <p>Web Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- team area end -->

        <!-- contact input area start -->
        <section class="tp-contact-input pt-100" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="tp-portfolio-2-section-title-wrapper text-center">
                            <span class="tp-section__title-pre-2">
                                CONTACT US
                            </span>
                            <h3 class="tp-section__title">GET IN TOUCH</h3>
                        </div>
                        <div class="tp-contact-from p-relative" data-background="assets/img/brand/home-2/form-input.png">
                            <div class="tp-brands-from-overlay"></div>
                            <form id="contact-form2" method="POST" action="<?= base_url('front/send-mail') ?>">
                                <div class="row tp-gx-20">
                                    <div class="col-12 col-sm-6">
                                        <div class="tp-brands-from-input contact-mb">
                                            <input name="name" type="text" placeholder="Full Name:">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="tp-brands-from-input contact-mb">
                                            <input name="email" type="email" placeholder="Email Address:">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="tp-brands-from-input contact-textarea">
                                            <textarea name="msg" placeholder="Write Message..."></textarea>
                                        </div>
                                    </div>
                                    <p class="ajax-response"></p>
                                </div>
                                <div class="tp-contact-submit text-center mt-20">
                                    <button class="tp-btn savebtn" type="submit">Send Message <i class="fa-regular fa-arrow-right-long"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact input area end -->
        <!-- contact area start -->
        <div class="tp-contact-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="tp-contact-phone d-sm-flex justify-content-xl-end">
                            <div class="tp-contact-icon">
                                <a href="tel:008757845682"><i class="flaticon-telephone-call"></i></a>
                            </div>
                            <div class="contact-inner">
                                <p>Phone:</p>
                                <a href="tel:008757845682">051-6102534</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-contact-mail d-sm-flex justify-content-xl-center">
                            <div class="tp-contact-icon">
                                <a href="mail:info@gmail.com"><i class="flaticon-mail"></i></a>
                            </div>
                            <div class="contact-inner">
                                <p>E-mail:</p>
                                <a href="mail:info@gmail.com">info@mobipixels.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-contact-location d-sm-flex justify-content-xl-start">
                            <div class="tp-contact-icon">
                                <a href="https://www.google.com/maps/@23.8297487,90.3766346,19z"><i class="flaticon-location"></i></a>
                            </div>
                            <div class="contact-inner">
                                <p>Address:</p>
                                <a target="_blank" href="https://www.google.com/maps/place/MobiPixels/@33.5215515,73.0893157,17z/data=!4m16!1m9!3m8!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!2sMobiPixels!8m2!3d33.5215471!4d73.0918906!9m1!1b1!16s%2Fg%2F11kz3p6gj3!3m5!1s0x38dfed84b5ecb5e7:0x5311609efac1bc28!8m2!3d33.5215471!4d73.0918906!16s%2Fg%2F11kz3p6gj3?entry=ttu">Sector F DHA, Islamabad</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact area end -->
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
                                        <li><a href="<?= base_url() ?>">Home</a></li>
                                        <?php if (frontend_permissions('about')) { ?>
                                            <li><a href="<?= base_url('front/about-us') ?>">About</a></li>
                                        <?php } ?>
                                        <li><a href="#featureItem">Pricing</a></li>
                                        <li><a href="#contact">Contact</a></li>
                                        <li><a href="#">Team Members</a></li>
                                        <?php if (frontend_permissions('privacy')) { ?>
                                            <li><a href="<?= base_url('front/privacy-policy') ?>">Privacy & Policy</a></li>
                                        <?php } ?>
                                        <?php if (frontend_permissions('terms')) { ?>
                                            <li><a href="<?= base_url('front/terms-and-conditions') ?>">Terms & Condition</a></li>
                                        <?php } ?>
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
                                <a href="<?= base_url() ?>"><img src='<?= base_url('assets/uploads/logos/' . full_logo()) ?>' height="40" alt=""></a>
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
    <script src='<?= base_url("assets/front/four/js/main.js") ?>'></script>
    <script>
        site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
    </script>
    <?php $recaptcha_site_key = get_google_recaptcha_site_key();
    if ($recaptcha_site_key) { ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?= htmlspecialchars($recaptcha_site_key) ?>"></script>
    <?php } ?>
    <div id="cookie-bar">
        <div class="cookie-bar-body">
            <p><?= $this->lang->line('frontend_cookie_message') ? htmlspecialchars($this->lang->line('frontend_cookie_message')) : 'We use cookies to ensure that we give you the best experience on our website.' ?></p>
            <div class="cookie-bar-action tp-hero-2-btn">
                <button type="button" class="tp-btn cookie-bar-btn"><?= $this->lang->line('i_agree') ? $this->lang->line('i_agree') : 'I Agree!' ?></button>
            </div>
        </div>
    </div>
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