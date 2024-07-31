<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $google_client_id = get_google_client_id();
    if ($google_client_id) { ?>
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="<?= $google_client_id ?>">
        <meta name="google-signin-plugin_name" content="auth2">
    <?php } ?>

    <?php $this->load->view('front/meta'); ?>
    <style>
        :root {
            --theme-color:
                <?= theme_color() ?>
            ;
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
    <link rel="stylesheet" href="<?= base_url('assets/front/four/css/page_styling.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/front/four/css/authentication_modal.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet" />

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
                <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <!-- back to top end -->


    <!-- header area start -->
    <header class="tp-header-2-area tp-header-height">

        <div id="header-sticky" class="tp-header-2-bottom header__sticky">
            <div class="container">
                <div class="header-wrapper p-relative z-index-1">
                    <div class="header-bg-shape"></div>
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-6 col-xl-2">
                            <div class="tp-header-logo tp-header-logo-border">
                                <a href="<?= base_url() ?>">
                                    <img src='<?= base_url('assets2/images/logos/' . full_logo()) ?>' height="50"
                                        width="150" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6 col-xl-10">
                            <div
                                class="tp-main-menu-2-area d-flex align-items-center justify-content-end justify-content-xl-center justify-content-xxl-end">
                                <div class="tp-main-menu home-2">
                                    <nav id="tp-mobile-menu">
                                        <ul>
                                            <li><a href="#feature">Features</a></li>
                                            <li><a href="#featureItem">Pricing</a></li>
                                            <li> <a href="#contact">Contact</a></li>
                                            <li><a href="<?= base_url('front/guide') ?>">Guide</a></li>

                                            <li>
                                                <a href="<?= base_url('auth') ?>" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#authenticationModal">
                                                    Login
                                                </a>
                                            </li>
                                            <li>
                                            <li>
                                            </li>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="tp-header-2-right d-flex align-items-center">
                                    <div class="tp-header-btn d-none d-xl-block">
                                        <!-- <a class="tp-btn" href="<?= base_url('auth/register') ?>">
                                            Get it free</a> -->
                                        <a class="tp-btn x8oe2yx" type="button" data-bs-toggle="modal"
                                            data-bs-target="#authenticationModal">
                                            Get it free</a>
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
                                <a target="_blank" href="#"><i class="fal fa-map-marker-alt"></i> Dubai</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="tp-sidebar__contact-text">
                                <a href="telto:051-6102534"><i class="far fa-phone"></i> 051-6102534</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="tp-sidebar__contact-text">
                                <a href="mailto:ag.rana@airnet-technologies.com"><i class="fal fa-envelope"></i>
                                    ag.rana@airnet-technologies.com</a>
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
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide slider-item">

                            <div class="tp-hero-2-bg tp-hero-2-overlay">

                                <div class="">
                                    <div class="bubbles"></div>
                                    <div class="">

                                        <img src='<?= base_url("assets/front/four/img/hero/home-2/img-34.png") ?>'
                                            alt="" class="background-image">

                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="tp-hero-wrapper d-flex align-items-center">
                                                    <div class="tp-hero-2-content">
                                                        <div class="tp-hero-title-wrapper">
                                                            <h5 class="tp-hero-2-title">
                                                                <?= $this->lang->line('frontend_home_title') ? htmlspecialchars($this->lang->line('frontend_home_title')) : 'Agile your work' ?>
                                                            </h5>
                                                        </div>
                                                        <p>
                                                            <?= $this->lang->line('frontend_home_description') ? htmlspecialchars($this->lang->line('frontend_home_description')) : 'Our solution fosters your work productivity through simplicity, collaboration and agile methodologies. Our one stop solution helps to organize and improve efficiency of your work management.' ?>
                                                        </p>
                                                        <div class="tp-hero-2-btn d-flex flex-wrap align-items-center">
                                                            <a class="tp-btn" href="<?= base_url('auth/register') ?>"
                                                                target="_blank">Get Started <i
                                                                    class="fa-regular fa-arrow-right-long"></i></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="tp-hero-2-thumb">
                                                    <img src='<?= base_url("assets/front/four/img/hero/home-2/img-3.png") ?>'
                                                        alt="">
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
                    <div class="col-lg-12 mb-30">
                        <div class="tp-brands-2-wrapper text-center mb-80">
                            <span class="tp-section__title-pre-2">
                                TRUSTED PARTNERS
                            </span>
                            <h3 class="tp-section__title">Tursted By These Brands</h3>
                        </div>
                        <div class="tp-brands-2-top d-flex justify-content-center align-items-center">
                            <div class="tp-brands-2-top-img">
                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/mobipixels.png") ?>'
                                        alt="mobipixels"></a>

                            </div>
                            <div class="tp-brands-2-top-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-2.png") ?>'
                                        alt="img-2"></a>

                            </div>
                            <div class="tp-brands-2-top-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-5.png") ?>'
                                        alt="img-3"></a>

                            </div>
                            <div class="tp-brands-2-top-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-11.png") ?>'
                                        alt="img-4"></a>

                            </div>

                        </div>

                        <!-- <div class="tp-brands-2-bottom d-flex d-flex justify-content-center align-items-center">
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-5.png") ?>' alt="img-5"></a>

                            </div>
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-6.png") ?>' alt="img-6"></a>

                            </div>
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-7.png") ?>' alt="img-7"></a>

                            </div>
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-8.png") ?>' alt="img-7"></a>

                            </div>
                        </div> -->
                        <br>
                        <!-- <div class="tp-brands-2-bottom d-flex d-flex justify-content-center align-items-center">
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-9.png") ?>' alt="img-7"></a>

                            </div>
                            <div class="tp-brands-2-bottom-img">

                                <a href="#"><img src='<?= base_url("assets2/images/trusted_partners/img-10.png") ?>' alt="img-7"></a>

                            </div>
                        </div> -->

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
                    <img class="service-2" src="<?= base_url('assets/front/four/img/services/shape-wrapper2.png') ?>"
                        alt="">
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="tp-section-title-wrapper text-center mb-80">
                                <span class="tp-section__title-pre">
                                    FEATURES
                                </span>
                                <h3 class="tp-section__title">What We are Offering</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="service-active splide wow fadeInUp slider-active splide mt-75"
                                data-wow-duration="1s" data-wow-delay="0.7s">
                                <div class="splide__track">
                                    <div class="splide__list">
                                        <?php if ($features) {
                                            foreach ($features as $key => $feature) {
                                                ?>
                                                <div class="splide__slide">
                                                    <div class="tp-service-item p-relative" style="height: 400px;">
                                                        <div class="item-shape">
                                                            <img src="<?= base_url('assets/front/four/img/services/shape-item.png') ?>"
                                                                alt="">
                                                        </div>
                                                        <div class="tp-service-thumb">
                                                            <i style="margin-top: 25px;"
                                                                class="<?= isset($feature['icon']) ? htmlspecialchars($feature['icon']) : 'fa fa-fire' ?>"></i>
                                                        </div>
                                                        <h4 class="tp-service-title"><a
                                                                href="service-details.html"><?= isset($feature['title']) ? htmlspecialchars($feature['title']) : '' ?></a>
                                                        </h4>
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


        <!-- multiple dashboards sections start -->
        <section class="tp-portfolio-3-area pt-120 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-portfolio-3-wrapper text-center">
                            <div class="tp-inner-pre">
                                <span><i class="flaticon-mop"></i></span>
                            </div>
                            <h3 id="multiple_dashboards" class="tp-section__title">Combine Info with Multiple Dashboards
                            </h3>

                            <div class="tp-portfolio-tab-button d-flex align-items-center justify-content-center">
                                <ul class="nav" id="pills-tab" role="tablist">
                                    <!-- <li class="nav-item" role="presentation">
                                        <button class=" active" id="kitchen-tab" data-bs-toggle="pill" data-bs-target="#kitchen" type="button" role="tab" aria-controls="kitchen" aria-selected="true">Admin Dashboard</button>
                                    </li> -->
                                    <li class="nav-item" role="presentation">
                                        <button class="active" id="OFFICE-tab" data-bs-toggle="pill"
                                            data-bs-target="#OFFICE" type="button" role="tab" aria-controls="OFFICE"
                                            aria-selected="false">HR Dashboard</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="" id="HOME-tab" data-bs-toggle="pill" data-bs-target="#HOME"
                                            type="button" role="tab" aria-controls="HOME" aria-selected="false">PMS
                                            Dashboard</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="" id="WINDOW-tab" data-bs-toggle="pill" data-bs-target="#WINDOW"
                                            type="button" role="tab" aria-controls="WINDOW" aria-selected="false">AMS
                                            Dashboard</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content p-relative wow fadeInDown" data-wow-duration="1s" data-wow-delay=".3s"
                            id="pills-tabContent">

                            <!-- <div class="tab-pane fade show " id="kitchen" role="tabpanel" aria-labelledby="kitchen-tab" tabindex="0">
                                <div class="">
                                    <div class="tp-portfolio-slider-3">
                                        <div class="tp-portfolio-3-inner grid-item item-2 item-1">
                                            <div class="tp-portfolio-3-thumb ">
                                                <img src="<?= base_url('assets2/images/landing_page_images/admin_dashboard.png') ?>" alt="Admin Dashboard">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="tab-pane fade show active" id="OFFICE" role="tabpanel"
                                aria-labelledby="OFFICE-tab" tabindex="0">
                                <div class="">
                                    <div class="tp-portfolio-slider-3">
                                        <div class="tp-portfolio-3-inner grid-item item-1 item-3">
                                            <div class="tp-portfolio-3-thumb">
                                                <img src="<?= base_url('assets2/images/landing_page_images/hr_dashboard.png') ?>"
                                                    alt="HR Dashboard">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="HOME" role="tabpanel" aria-labelledby="HOME-tab"
                                tabindex="0">
                                <div class="">
                                    <div class="tp-portfolio-slider-3">
                                        <div class="tp-portfolio-3-inner grid-item item-3 item-2">
                                            <div class="tp-portfolio-3-thumb ">
                                                <img src="<?= base_url('assets2/images/landing_page_images/pms_dashboard.png') ?>"
                                                    alt="PMS">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="WINDOW" role="tabpanel" aria-labelledby="WINDOW-tab"
                                tabindex="0">
                                <div class="">
                                    <div class="tp-portfolio-slider-3">
                                        <div class="tp-portfolio-3-inner grid-item item-2 item-1">
                                            <div class="tp-portfolio-3-thumb">
                                                <img src="<?= base_url('assets2/images/landing_page_images/ams_dashboard.png') ?>"
                                                    alt="AMS">
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
        <!-- multiple dashboards sections end -->


        <!-- price area start -->
        <div id="featureItem" class="tp-pricing-area p-relative pt-120">
            <div class="tp-pricing-shape d-none d-lg-block">
                <img class="mousemove__image shape-1"
                    src="<?= base_url('assets/front/four/img/pricing/bublble-1.png') ?>" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-pricing-title-wrapper mb-50 text-center">
                            <div class="tp-inner-pre">
                                <span><i class="flaticon-mop"></i></span>
                            </div>
                            <h3 class="tp-section__title">Pricing</h3>
                        </div>
                    </div>


                    <?php $this->load->view('setting-forms/pricing_features'); ?>


                </div>
            </div>
        </div>
        <!-- price area end -->
        <br>


        <!-- start -->
        <section class="my-5">
            <div class="container">
                <div class="row first my-5">
                    <div class="tp-pricing-title-wrapper mb-50 text-center">
                        <div class="tp-inner-pre">
                            <span><i class="flaticon-mop"></i></span>
                        </div>
                        <h3 class="tp-section__title">Centralize Operations for Seamless Efficiency</h3>
                    </div>

                    <div class="col-md-4 wow flipInX flipInX_img" data-wow-delay="0.3s">
                        <img src="<?= base_url('assets2/images/landing_page_images/img_3.png') ?>" alt=""
                            class="first img-fluid">
                    </div>
                    <div class="col-md-6 m-auto wow fadeInRight" data-wow-delay="0.6s">
                        <div class="app-about-cont my-1">
                            <i class="fas fa-address-card"></i>
                            <h3>Access everything you need in one convenient place</h3>
                            <p>
                                <br>
                            <ul class="list_style container">
                                <li>
                                    Empower your teams with streamlined workflows, enabling faster decision-making and
                                    smoother project execution.
                                </li>
                                <li>
                                    Break down silos and foster collaboration across teams by bringing together all
                                    project-related details within PERI's unified platform.
                                </li>
                                <li>
                                    Maximize productivity and minimize delays by having immediate access to relevant
                                    context, facilitating quicker problem-solving and decision-making.
                                </li>
                                <li>
                                    Ensure transparency and accountability across your projects with PERI's
                                    comprehensive visibility into every aspect of your workflow.
                                </li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>


                <div class="row second  tp-service-overlay_2 pt-120 pb-110">
                    <div class="col-md-6 m-auto wow fadeInRight" data-wow-delay="0.3s">
                        <div class="app-about-cont right my-1">
                            <i class="fas fa-exchange-alt"></i>
                            <h3>Customization & Flexibility</h3>

                            <br>
                            <ul class="list_style container">
                                <li>
                                    Tailor PERI to align precisely with your team's processes, workflows, and
                                    terminology. </li>
                                <li>
                                    Enjoy the flexibility of PERI's customizable features, adapting the platform to your
                                    team's unique requirements. </li>
                                <li>
                                    Streamline operations by customizing PERI to match your preferred roles, permissions
                                    enhancing communication and collaboration. </li>
                                <li>
                                    Empower your team with a tailored workspace that meets their needs, boosting
                                    efficiency.
                                </li>
                            </ul>


                        </div>
                    </div>
                    <div class="col-md-4 wow flipInX flipInX_img" data-wow-delay="0.6s">
                        <img src="<?= base_url('assets2/images/landing_page_images/img_4.png') ?>" alt=""
                            class="third img-fluid">
                    </div>
                </div>
                <br>
                <br>
                <br>


                <div class="row first my-5">
                    <div class="col-md-4 wow flipInX flipInX_img" data-wow-delay="0.3s">
                        <img src="<?= base_url('assets2/images/landing_page_images/img_5.png') ?>" alt=""
                            class="first img-fluid">
                    </div>
                    <div class="col-md-6 m-auto wow fadeInRight" data-wow-delay="0.6s">
                        <div class="app-about-cont my-1">
                            <i class="fas fa-battery-three-quarters"></i>
                            <h3>Streamline Your Workflow</h3>
                            <p>


                            <ul class="list_style container">
                                <li>
                                    PERI streamlines your daily operations by automating repetitive tasks, saving time
                                    and reducing manual workload.
                                </li>
                                <li>
                                    Use PERI with your organization for a seamless workflow, ensuring data consistency
                                    and efficiency.
                                <li>
                                    PERI offers a complete suite of HR management features, including performance
                                    management, and attendance tracking.
                                <li>
                                    PERI provides valuable insights into your operations through comprehensive analytics
                                    and reporting tools, empowering data-driven decision-making.
                                </li>
                                <li>
                                    With PERI, employees experience a smoother onboarding process, streamlined
                                    performance evaluations, and simplified leave management, resulting in higher
                                    satisfaction.
                                </li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row second  tp-service-overlay_2 pt-120 pb-110">
                    <div class="col-md-6 m-auto wow fadeInRight" data-wow-delay="0.3s">
                        <div class="app-about-cont right my-1">
                            <i class="fas fa-braille"></i>
                            <h3>Empowering Your Organization for Success</h3>
                            <p>


                            <ul class="list_style container">
                                <li>
                                    Provide tailored solutions and support to empower your organization to achieve its
                                    goals.
                                </li>
                                <li>
                                    Offer resources, designed to meet the unique needs of your organization.
                                <li>
                                    Work closely with your organization to develop and implement strategies that align
                                    with its vision and values.
                                <li>
                                    Establish clear metrics and goals to track progress and measure the success of
                                    initiatives implemented to support organizational success.
                                </li>

                                <li>
                                    Foster a culture of innovation and continuous improvement by encouraging feedback,
                                    experimentation, and collaboration among team members, driving sustainable growth
                                    and competitive advantage.
                                </li>
                            </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 wow flipInX flipInX_img" data-wow-delay="0.6s">
                        <img src="<?= base_url('assets2/images/landing_page_images/img_6.png') ?>" alt=""
                            class="third img-fluid">
                    </div>
                </div>
            </div>
        </section>
        <!-- end -->



        <!-- start -->
        <section id="mousemove" class="tp-about-3-area p-relative pt-120 pb-85">
            <div class="tp-pricing-shape d-none d-lg-block">
                <img class="mousemove__image shape-1"
                    src="<?= base_url('assets/front/four/img/pricing/bublble-1.png') ?>" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xl-7">
                        <div class="tp-about-3-thumb p-relative mb-30">
                            <div class="row tp-gx-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">

                                <div class="col-sm-12 col-md-7">
                                    <div class="tp-about-3-thumb-3 style_1">
                                        <img src="<?= base_url('assets2/images/landing_page_images/img_2.png') ?>"
                                            alt="">
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-5">
                                    <div class="tp-about-3-thumb-1 mb-30">
                                        <img src="<?= base_url('assets2/images/landing_page_images/img_1.png') ?>"
                                            alt="">
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="tp-about-3-thumb-2 p-relative progress_bar">
                                        <div class="skill__progress-circle">
                                            <div class="progress-circular">
                                                <input type="text" class="knob" value="0" data-rel="90"
                                                    data-linecap="round" data-width="140" data-height="140"
                                                    data-bgcolor="#fff" data-fgcolor="#63ED7A" data-thickness=".15"
                                                    data-readonly="true" disabled>
                                            </div>
                                            <h4>Market Fit</h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-5">
                        <div class="tp-about-3-wrapper mb-30 wow fadeInRight" data-wow-duration="1s"
                            data-wow-delay=".3s">
                            <div class="tp-inner-pre">
                                <span><i class="flaticon-mop"></i></span>
                            </div>
                            <h3 class="tp-section__title">Everything your<br> team is looking for</h3>
                            <p>
                                PERI's remarkable adaptability makes it capable of managing various types of tasks
                                efficiently. <br>
                                Moreover, our commitment to continuous innovation ensures that we're always enhancing
                                our platform to meet evolving needs and challenges.
                            </p>
                            <div class="tp-about-3-inner d-flex">
                                <div class="tp-about-inner-thumb">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="tp-about-inner-text">
                                    <h4>PERI's Excellence</h4>
                                    <p>
                                        "<em>PERI excels, setting industry standards. We continually refine our approach
                                            to meet your team's evolving needs.</em>"
                                    </p>
                                </div>
                            </div>
                            <div class="tp-about-2-btn">
                                <a class="tp-btn" href="<?= base_url('auth/register') ?>"> Get free demo <i
                                        class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end -->



        <!-- start -->

        <div class="tp-testimonial-area p-relative pb-120">
            <div class="tp-testimonial-overlay"></div>
            <div class="tp-testimonial-shape">
                <img class="shape-1" src="<?= base_url('assets2/images/dashboards/shpe-1.png') ?>" alt="">
                <img class="shape-2" src="<?= base_url('assets2/images/dashboards/shpe-2.png') ?>" alt="">
                <img class="shape-3 d-none d-xl-block" src="<?= base_url('assets2/images/dashboards/shpe-3.png') ?>"
                    alt="">
                <img class="shape-4 d-none d-xl-block" src="<?= base_url('assets2/images/dashboards/shpe-4.png') ?>"
                    alt="">
            </div>
            <div class="container">
                <div class="tp-testimonial-wrapper">
                    <div class="row">
                        <div class="col-lg-5 order-2 order-lg-1 wow fadeInLeft" data-wow-duration="1s"
                            data-wow-delay=".3s">
                            <div class="tp-testimonial-thumb style_2">
                                <img src="<?= base_url('assets2/images/landing_page_images/img_7.png') ?>" alt="">
                            </div>
                        </div>
                        <div class="col-lg-7 order-1 order-lg-2 wow fadeInRight" data-wow-duration="1s"
                            data-wow-delay=".3s">
                            <div class="tp-testimonial-content">
                                <div class="tp-nav-wrap">
                                    <div class="testimonial-navigation-active splide">
                                        <div class="splide__track">
                                            <div class="splide__list">
                                                <div class="splide__slide">
                                                    <div class="tp-testimonial-user text-center">
                                                        <img src="<?= base_url('assets2/images/dashboards/project_system.png') ?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="splide__slide">
                                                    <div class="tp-testimonial-user text-center">
                                                        <img src="<?= base_url('assets2/images/dashboards/attendance_system.png') ?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="splide__slide">
                                                    <div class="tp-testimonial-user text-center">
                                                        <img src="<?= base_url('assets2/images/dashboards/client_system.png') ?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-main-active splide">
                                    <div class="splide__track">
                                        <div class="splide__list">
                                            <div class="splide__slide">
                                                <p class="text-left">
                                                    “Our PMS streamlines tasks, collaboration, and boosts efficiency.
                                                    With intuitive features, teams seamlessly plan, execute, and monitor
                                                    projects, ensuring timely goals.
                                                </p>
                                                <span class="text-center">Project Managment System</span>
                                                <p class="tp-testimonial-designation text-center">
                                                    <a class="" href="#multiple_dashboards">View <i
                                                            class="fa-regular fa-arrow-right-long"></i></a>
                                                </p>
                                            </div>
                                            <div class="splide__slide">
                                                <p class="text-left">
                                                    “With our AMS, attendance management becomes streamlined,
                                                    collaboration is enhanced, and efficiency is ensured. Teams
                                                    effortlessly handle records and reporting with intuitive features.
                                                </p>
                                                <span class="text-center">Attendance Managment System</span>
                                                <p class="tp-testimonial-designation text-center">
                                                    <a class="" href="#multiple_dashboards">View <i
                                                            class="fa-regular fa-arrow-right-long"></i></a>
                                                </p>
                                            </div>
                                            <div class="splide__slide">
                                                <p class="text-left">
                                                    “Our CRM optimizes client relations, fosters collaboration, and
                                                    ensures efficiency. With intuitive features, teams manage
                                                    relationships and communications seamlessly.
                                                </p>
                                                <span class="text-center">Client Relationship Managment</span>
                                                <p class="tp-testimonial-designation text-center">
                                                    <a class="" href="#multiple_dashboards">View <i
                                                            class="fa-regular fa-arrow-right-long"></i></a>
                                                </p>
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

        <!-- end -->



        <!-- contact input area start -->
        <section class="tp-contact-input pt-100" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="tp-portfolio-2-section-title-wrapper text-center">
                            <span class="tp-section__title-pre-2">
                                CONTACT US
                            </span>
                            <h3 class="tp-section__title">Get in Touch</h3>
                        </div>
                        <div class="tp-contact-from p-relative"
                            data-background="assets/img/brand/home-2/form-input.png">
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
                                    <button class="tp-btn savebtn" type="submit">Send Message <i
                                            class="fa-regular fa-arrow-right-long"></i></button>
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
            <!-- <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="tp-contact-phone d-sm-flex justify-content-xl-end">
                            <div class="tp-contact-icon">
                                <a href="tel:051-6102534"><i class="flaticon-telephone-call"></i></a>
                            </div>
                            <div class="contact-inner">
                                <p>Phone:</p>
                                <a href="tel:051-6102534" style="font-size: 18px;">051-6102534</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-contact-mail d-sm-flex justify-content-xl-center">
                            <div class="tp-contact-icon">
                                <a href="mail:ag.rana@airnet-technologies.com"><i class="flaticon-mail"></i></a>
                            </div>
                            <div class="contact-inner">
                                <p>E-mail:</p>
                                <a href="mailto:ag.rana@airnet-technologies.com" style="font-size: 18px;">Click to send Mail</a>
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
                                <a target="_blank" style="font-size: 18px;" href="https://www.google.com/maps/place/Dubai+-+United+Arab+Emirates/@25.0756569,54.8971529,10z/data=!3m1!4b1!4m6!3m5!1s0x3e5f43496ad9c645:0xbde66e5084295162!8m2!3d25.2048493!4d55.2707828!16zL20vMDFmMDhy?entry=ttu" target="_blank">Dubai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- contact area end -->
    </main>


    <!-- authentication modal starts here  -->
    <!-- authenticationModal -->

    <div class="modal fade" id="authenticationModal" tabindex="-1" aria-labelledby="authenticationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="row " style="height: 100% !important; ">
                    <div class="col-6 d-none d-md-block" style="padding: 0px; margin: 0px;">
                        <div class="auth-modal-imgae">
                            <img src="https://images.unsplash.com/photo-1721804980240-4b8adc442fc4?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="">
                        </div>
                    </div>
                    <div class="col-sm-12  col-md-6"
                        style="overflow: hidden !important;position: relative;left: -13px;">
                        <div class="wrapper">
                            <!-- <div class="title-text">
                                <div class="title login">Login Form</div>
                                <div class="title signup">Signup Form</div>
                            </div> -->
                            <div class="form-container" style="position:relative;">
                                <div class="slide-controls">
                                    <input type="radio" name="slide" id="login" checked>
                                    <input type="radio" name="slide" id="signup">
                                    <label for="login" class="slide login">Login</label>
                                    <label for="signup" class="slide signup">Signup</label>
                                    <div class="slider-tab"></div>
                                </div>
                                <div class="login login-form">
                                    <div class="modal-body-login authentication-modal-single-side-content">

                                        <form id="authenticationModalLogin" method="POST"
                                            action="<?= base_url('auth/login') ?>" class="needs-validation"
                                            novalidate="">

                                            <div class="form-group" style="position: relative;">
                                                <label
                                                    for="identity"><?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?></label>
                                                <input id="identity" type="email" class="form-control" name="identity"
                                                    tabindex="1" required autofocus>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="password"
                                                        class="control-label"><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?></label>
                                                    <div class="float-right">
                                                        <a href="#" id="modal-forgot-password" class="text-small">
                                                            <?= $this->lang->line('forgot_password') ? $this->lang->line('forgot_password') : 'Forgot Password' ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="password-wrapper" style="position: relative;">
                                                    <input id="password" type="password" class="form-control"
                                                        name="password" tabindex="2" required>
                                                    <i class="fa fa-eye password-toggle"
                                                        style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="remember" class="custom-control-input"
                                                        tabindex="3" id="remember-me">
                                                    <label class="custom-control-label"
                                                        for="remember-me"><?= $this->lang->line('remember_me') ? $this->lang->line('remember_me') : 'Remember Me' ?></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="savebtn btn btn-primary btn-lg btn-block"
                                                    tabindex="4">
                                                    <?= $this->lang->line('login') ? $this->lang->line('login') : 'Login' ?>
                                                </button>
                                            </div>



                                            <?php if (!turn_off_new_user_registration()) { ?>
                                                <div class="text-muted text-center ">
                                                    <?= $this->lang->line('dont_have_an_account') ? $this->lang->line('dont_have_an_account') : "Don't have an account?" ?>
                                                    <a style="cursor: pointer;"
                                                        class="x8oe2yx"><?= $this->lang->line('create_one') ? $this->lang->line('create_one') : 'Create One' ?></a>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <div class="result">
                                                    <?= isset($message) ? htmlspecialchars($message) : ''; ?>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                                <div class="signup signup-form">
                                    <div class="modal-body-signup authentication-modal-single-side-content">
                                        <form id="register" method="POST" action="<?= base_url('auth/create_user') ?>"
                                            class="needs-validation" novalidate="">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label
                                                        for="frist_name"><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?></label>
                                                    <input type="hidden" name="groups" value="1">
                                                    <input type="hidden" name="new_register" value="1">
                                                    <input type="hidden" name="employee_id" id="employee_id">
                                                    <input id="frist_name" type="text" class="form-control"
                                                        name="first_name" tabindex="1" required autofocus>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label
                                                        for="last_name"><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?></label>
                                                    <input id="last_name" type="text" class="form-control"
                                                        name="last_name" tabindex="2" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="email"><?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?></label>
                                                <input id="email" type="email" class="form-control" name="email"
                                                    tabindex="3" required>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-12" style="position: relative;">
                                                    <label for="password"
                                                        class="d-block"><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?></label>
                                                    <input id="password" type="password" class="form-control pwstrength"
                                                        data-indicator="pwindicator" name="password" tabindex="4"
                                                        required>
                                                    <i class="fa fa-eye password-toggle2"
                                                        style="position: absolute; right: 30px; top: 68%; transform: translateY(-60%); cursor: pointer;"></i>
                                                    <div id="pwindicator" class="pwindicator">
                                                        <div class="bar"></div>
                                                        <div class="label"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12" style="position: relative;">
                                                    <label for="password2"
                                                        class="d-block"><?= $this->lang->line('password_confirmation') ? $this->lang->line('password_confirmation') : 'Confirm' ?></label>
                                                    <input id="password2" type="password" class="form-control"
                                                        name="password_confirm" tabindex="5" required>
                                                    <i class="fa fa-eye password-toggle"
                                                        style="position: absolute; right: 30px; top: 68%; transform: translateY(-60%); cursor: pointer;"></i>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <button type="submit" class="savebtn btn btn-primary btn-lg btn-block"
                                                    tabindex="6">
                                                    <?= $this->lang->line('register') ? $this->lang->line('register') : 'Register' ?>
                                                </button>
                                            </div>

                                            <div class="form-group">
                                                <div class="result">
                                                    <?= isset($message) ? htmlspecialchars($message) : ''; ?>
                                                </div>
                                            </div>

                                            <?php if ($google_client_id) { ?>
                                                <div class="form-group my-2 row d-flex justify-content-center"
                                                    style="width: 100%;">
                                                    <div class="g-signin2 " data-width="300" data-height="43.59"
                                                        data-onsuccess="onSignIn" data-theme="dark"></div>
                                                </div>
                                            <?php } ?>

                                            <div class="text-muted text-center">
                                                <?= $this->lang->line('already_have_an_account') ? $this->lang->line('already_have_an_account') : 'Already have an account?' ?>
                                                <a class="x8oe2yx2"
                                                    href="#"><?= $this->lang->line('login_here') ? $this->lang->line('login_here') : 'Login Here' ?></a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // include ('../components/authentication_modal.php');
    ?>
    <!-- authentication modal ends here  -->

    <!-- footer area start -->
    <footer id="footerTwo" class="tp-footer-2-area p-relative">
        <div class="tp-footer-2-wrapper"
            data-background='<?= base_url("assets2/images/landing_page_images/footer_bg_img.png") ?>'>
            <div class="tp-footer-2-overlay"></div>
            <div class="tp-footer-2-shape d-none d-md-block">
                <div class="shape-1">
                    <img class="mousemove__image"
                        src='<?= base_url("assets/front/four/img/footer/home-2/bubble.png") ?>' alt="">
                </div>
                <div class="shape-2">
                    <img class="mousemove__image"
                        src='<?= base_url("assets/front/four/img/footer/home-2/bubble-2.png") ?>' alt="">
                </div>
                <div class="shape-4">
                    <img class="mousemove__image"
                        src='<?= base_url("assets/front/four/img/footer/home-2/bubble-4.png") ?>' alt="">
                </div>
            </div>
            <div class="tp-footer-inner-content pt-80">
                <div class="tp-footer-2-widget-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="tp-footer-2-widget mb-30">
                                    <span class="mb-30">Contact Us</span>
                                    <div class="tp-footer-2-widget-contact d-flex align-items-center mb-30">
                                        <a class="icon" href="tel:051-6102534"><i
                                                class="flaticon-telephone-call"></i></a>
                                        <div class="contact-inner">
                                            <p>Phone:</p>
                                            <a href="tel:051-6102534" style="font-size: 18px;">051-6102534</a>
                                        </div>
                                    </div>
                                    <div class="tp-footer-2-widget-contact d-flex align-items-center">
                                        <a class="icon" href="mailto:ag.rana@airnet-technologies.com"><i
                                                class="flaticon-mail"></i></a>
                                        <div class="contact-inner">
                                            <p>E-mail:</p>
                                            <a href="mailto:ag.rana@airnet-technologies.com"
                                                style="font-size: 18px;">ag.rana@airnet-technologies.com</a>
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
                                            <li><a href="<?= base_url('front/terms-and-conditions') ?>">Terms &
                                                    Condition</a></li>
                                        <?php } ?>
                                        <?php if (frontend_permissions('terms')) { ?>
                                            <li><a href="<?= base_url('front/guide') ?>">Guide</a></li>
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
                                <a href="<?= base_url() ?>"><img
                                        src='<?= base_url('assets/uploads/logos/' . full_logo()) ?>' height="40"
                                        alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="tp-btn-effect">
                                <div class="tp-footer-2-social text-md-center d-flex align-items-center">
                                    <span>Follow Us:</span>
                                    <a href="https://www.facebook.com/MobiPixels" target="_blank"><i
                                            class="fa-brands fa-facebook-f"></i></a>
                                    <a href="https://www.linkedin.com/company/mobipixels" target="_blank"><i
                                            class="fa-brands fa-linkedin"></i></a>
                                    <a href="https://www.youtube.com/@mobipixels4547" target="_blank"><i
                                            class="fa-brands fa-youtube"></i></a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

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
    <script src='<?= base_url("assets/front/four/js/authentication_modal.js") ?>'></script>

    <script>
        site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
    </script>
    <?php $recaptcha_site_key = get_google_recaptcha_site_key();
    if ($recaptcha_site_key) { ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?= htmlspecialchars($recaptcha_site_key) ?>"></script>
    <?php } ?>
    <div id="cookie-bar">
        <div class="cookie-bar-body">
            <p><?= $this->lang->line('frontend_cookie_message') ? htmlspecialchars($this->lang->line('frontend_cookie_message')) : 'We use cookies to ensure that we give you the best experience on our website.' ?>
            </p>
            <div class="cookie-bar-action tp-hero-2-btn">
                <button type="button"
                    class="tp-btn cookie-bar-btn"><?= $this->lang->line('i_agree') ? $this->lang->line('i_agree') : 'I Agree!' ?></button>
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

    <?php if ($google_client_id) { ?>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script>
            function onSignIn(googleUser) {
                gapi.load('auth2', function () {
                    gapi.auth2.init().then(() => {
                        var auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut().then(function () {
                            auth2.disconnect().then(function () {
                                // do nothing
                            });
                        });
                    });
                });
                var profile = googleUser.getBasicProfile();
                if (profile && profile.getEmail() && profile.getGivenName() && profile.getFamilyName()) {
                    if (site_key) {
                        grecaptcha.ready(function () {
                            grecaptcha.execute(site_key, {
                                action: 'register_form'
                            }).then(function (token) {
                                $.ajax({
                                    type: "POST",
                                    url: base_url + 'auth/social_auth',
                                    data: "email=" + profile.getEmail() + "&first_name=" + profile.getGivenName() + "&last_name=" + profile.getFamilyName() + "&token=" + token + "&action=register_form",
                                    dataType: "json",
                                    success: function (result) {
                                        if (result['error'] == false) {
                                            location.reload();
                                        } else {
                                            iziToast.error({
                                                title: result['message'],
                                                message: "",
                                                position: 'topRight'
                                            });
                                        }
                                    }
                                });
                            });
                        });
                    } else {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'auth/social_auth',
                            data: "email=" + profile.getEmail() + "&first_name=" + profile.getGivenName() + "&last_name=" + profile.getFamilyName(),
                            dataType: "json",
                            success: function (result) {
                                if (result['error'] == false) {
                                    location.reload();
                                } else {
                                    iziToast.error({
                                        title: result['message'],
                                        message: "",
                                        position: 'topRight'
                                    });
                                }
                            }
                        });
                    }
                } else {
                    iziToast.error({
                        title: something_wrong_try_again,
                        message: "",
                        position: 'topRight'
                    });
                }
            }
        </script>
    <?php } ?>

    <script>
        $("#authenticationModalLogin").submit(function (e) {
            e.preventDefault();
            let save_button = $(this).find('.savebtn');
            let output_status = $(this).find('.result')
            save_button.addClass('btn-progress');
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (result) {
                    console.log(result);
                    if (result['error'] == false) {
                        // window.location.replace(<?php echo base_url('/'); ?>);
                        location.reload();
                    } else {
                        output_status.prepend('<div class="alert alert-danger">' + result['message'] + '</div>');
                    }
                    // card_progress.dismiss(function () {
                    //     output_status.find('.alert').delay(4000).fadeOut();
                    //     save_button.removeClass('btn-progress');
                    //     $('html, body').animate({
                    //         scrollTop: output_status.offset().top
                    //     }, 1000);
                    // });
                }
            });

            return false;
        });
    </script>

</body>

</html>