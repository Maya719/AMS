<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('front/meta'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/front/one/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/front/one/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">
    <style>
        :root {
            --theme-color: <?= theme_color() ?>;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/front/one/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/front/comman.css') ?>">
    <?php $google_analytics = google_analytics(); if ($google_analytics) { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($google_analytics) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '<?= htmlspecialchars($google_analytics) ?>');
        </script>
    <?php } ?>
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="sk-spinner sk-spinner-rotating-plane"></div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top timwork-nav" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>
            <a href="<?= base_url() ?>" class="navbar-brand">
                <img class="navbar-logo" alt="<?= company_name() ?>" src="<?= base_url('assets/uploads/logos/' . full_logo()) ?>">
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right text-uppercase">
                <?php if (frontend_permissions('home')) { ?>
                    <li><a href="#home" class="home-menu"><?= $this->lang->line('home') ? $this->lang->line('home') : 'Home' ?></a></li>
                <?php } ?>
                <?php if (frontend_permissions('features') && $features) { ?>
                    <li><a href="#divider" class="home-menu"><?= $this->lang->line('features') ? $this->lang->line('features') : 'Features' ?></a></li>
                <?php } ?>
                <?php if (frontend_permissions('subscription_plans')) { ?>
                    <li><a href="#pricing" class="home-menu"><?= $this->lang->line('pricing') ? htmlspecialchars($this->lang->line('pricing')) : 'Pricing' ?></a></li>
                <?php } ?>
                <?php if (frontend_permissions('contact')) { ?>
                    <li><a href="#contact" class="home-menu"><?= $this->lang->line('contact') ? $this->lang->line('contact') : 'Contact' ?></a></li>
                <?php } ?>
                <li><a href="<?= base_url('auth') ?>" class="home-menu" target="_blank"><button type="button"
                                                                                                    class="text-uppercase btn"><?= $this->lang->line('login') ? $this->lang->line('login') : 'Login' ?></button></a>
                </li>
                <li><a href="<?= base_url('auth/register') ?>" class="home-menu" target="_blank"><button type="button"
                                                                                                          class="text-uppercase btn btn-primary"><?= $this->lang->line('get_start') ? $this->lang->line('get_start') : 'Get Start' ?></button></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php if (frontend_permissions('home')) { ?>
    <!-- Home Section -->
    <section id="home">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
                        <h1 class="text-upper"><?= $this->lang->line('frontend_home_title') ? htmlspecialchars($this->lang->line('frontend_home_title')) : 'Professional Project Management tool and CRM' ?></h1>
                        <p class="tm-white"><?= $this->lang->line('frontend_home_description') ? htmlspecialchars($this->lang->line('frontend_home_description')) : 'TimeWork pms.mobipixels.com is a perfect, robust, lightweight, superfast web application to fulfill all your Team Collaboration, Project Management and CRM needs.' ?></p>
                        <a href="<?= base_url('auth/register') ?>" target="_blank"
                           class="btn btn-primary text-uppercase mt-25"><?= $this->lang->line('get_start') ? $this->lang->line('get_start') : 'Get Start' ?></a>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Home Section -->
<?php } ?>
<?php if (frontend_permissions('features') && $features) { ?>
    <!-- Features Section -->
    <section id="divider">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow bounceIn features">
                    <h2 class="text-uppercase"><?= $this->lang->line('features') ? $this->lang->line('features') : 'Features' ?></h2>
                </div>
                <?php foreach ($features as $feature) { ?>
                    <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                        <?php if (isset($feature['icon'])) { ?>
                            <i class="front-feature-icon <?= $feature['icon'] ?>"></i>
                        <?php } ?>
                        <h3 class="text-uppercase"><?= htmlspecialchars($feature['title']) ?></h3>
                        <p><?= htmlspecialchars($feature['description']) ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- End Features Section -->
<?php } ?>
<?php if (frontend_permissions('subscription_plans')) { ?>
    <!-- Pricing Section -->
    <section id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow bounceIn">
                    <h2 class="text-uppercase"><?= $this->lang->line('pricing') ? htmlspecialchars($this->lang->line('pricing')) : 'Pricing' ?></h2>
                </div>
                <?php foreach ($plans as $plan) { ?>
                    <div class="col-md-4 wow fadeIn" data-wow-delay="0.6s">
                        <div class="pricing text-uppercase">
                            <div class="pricing-title">
                                <h4><?= htmlspecialchars($plan['title']) ?></h4>
                                <p><?= get_saas_currency('currency_symbol') . htmlspecialchars($plan['price']) ?></p>
                                <small class="text-lowercase">
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
                                </small>
                            </div>
                            <ul>
                                <li><?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?>
                                    <div
                                            class="badge badge-primary"><?= $plan['storage'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['storage'] . 'GB') ?></div>
                                </li>
                                <li><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?>
                                    <div
                                            class="badge badge-primary"><?= $plan['projects'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['projects']) ?></div>
                                </li>
                                <li><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?>
                                    <div
                                            class="badge badge-primary"><?= $plan['tasks'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['tasks']) ?></div>
                                </li>
                                <li><?= $this->lang->line('users') ? $this->lang->line('users') : 'Users' ?> <i
                                            class="fa fa-question-circle"
                                            data-toggle="tooltip"
                                            data-placement="right"
                                            title="<?= $this->lang->line('including_admins_clients_and_users') ? $this->lang->line('including_admins_clients_and_users') : 'Including Admins, Clients and Users.' ?>"></i>
                                    <div
                                            class="badge badge-primary"><?= $plan['users'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['users']) ?></div>
                                </li>
                                <?php
                                $modules = '';
                                if ($plan["modules"] != '') {
                                    echo '<hr style="margin: 4px;"><li>' . ($this->lang->line('modules') ? $this->lang->line('modules') : 'Modules') . '</li>';
                                    foreach (json_decode($plan["modules"]) as $mod_key => $mod) {
                                        $mod_name = '';
                                        if ($mod_key == 'projects') {
                                            $mod_name = $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects';
                                        } elseif ($mod_key == 'tasks') {
                                            $mod_name = $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks';
                                        } elseif ($mod_key == 'gantt') {
                                            $mod_name = $this->lang->line('gantt') ? $this->lang->line('gantt') : 'Gantt';
                                        } elseif ($mod_key == 'timesheet') {
                                            $mod_name = $this->lang->line('timesheet') ? $this->lang->line('timesheet') : 'Timesheet';
                                        } elseif ($mod_key == 'team_members') {
                                            $mod_name = $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Team Members';
                                        } elseif ($mod_key == 'invoices') {
                                            $mod_name = $this->lang->line('invoices') ? $this->lang->line('invoices') : 'Invoices';
                                        } elseif ($mod_key == 'estimates') {
                                            $mod_name = $this->lang->line('estimates') ? $this->lang->line('estimates') : 'Estimates';
                                        } elseif ($mod_key == 'expenses') {
                                            $mod_name = $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses';
                                        } elseif ($mod_key == 'payments') {
                                            $mod_name = $this->lang->line('payments') ? $this->lang->line('payments') : 'Payments';
                                        } elseif ($mod_key == 'contracts') {
                                            $mod_name = $this->lang->line('contracts') ? $this->lang->line('contracts') : 'Contracts';
                                        } elseif ($mod_key == 'leads') {
                                            $mod_name = $this->lang->line('leads') ? $this->lang->line('leads') : 'Leads';
                                        } elseif ($mod_key == 'customers') {
                                            $mod_name = $this->lang->line('customers') ? $this->lang->line('customers') : 'Customers';
                                        } elseif ($mod_key == 'events') {
                                            $mod_name = $this->lang->line('events') ? $this->lang->line('events') : 'Events';
                                        } elseif ($mod_key == 'items') {
                                            $mod_name = $this->lang->line('items') ? $this->lang->line('items') : 'Items';
                                        } elseif ($mod_key == 'expenses') {
                                            $mod_name = $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses';
                                        } elseif ($mod_key == 'contracts') {
                                            $mod_name = $this->lang->line('contracts') ? $this->lang->line('contracts') : 'Contracts';
                                        } elseif ($mod_key == 'leads') {
                                            $mod_name = $this->lang->line('leads') ? $this->lang->line('leads') : 'Leads';
                                        } elseif ($mod_key == 'customers') {
                                            $mod_name = $this->lang->line('customers') ? $this->lang->line('customers') : 'Customers';
                                        } elseif ($mod_key == 'events') {
                                            $mod_name = $this->lang->line('events') ? $this->lang->line('events') : 'Events';
                                        } elseif ($mod_key == 'items') {
                                            $mod_name = $this->lang->line('items') ? $this->lang->line('items') : 'Items';
                                        } elseif ($mod_key == 'inventory') {
                                            $mod_name = $this->lang->line('inventory') ? $this->lang->line('inventory') : 'Inventory';
                                        }
                                        $modules .= '<div class="badge badge-primary">' . htmlspecialchars($mod_name) . '</div>';
                                    }
                                    echo '<div class="templatemo-price text-center">' . $modules . '</div>';
                                }
                                ?>
                            </ul>
                            <a href="<?= base_url('auth/register/' . $plan['id']) ?>" target="_blank"
                               class="btn btn-primary text-uppercase"><?= $this->lang->line('buy_now') ? $this->lang->line('buy_now') : 'Buy Now' ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- End Pricing Section -->
<?php } ?>
<?php if (frontend_permissions('contact')) { ?>
    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow bounceIn">
                    <h2 class="text-uppercase"><?= $this->lang->line('contact') ? $this->lang->line('contact') : 'Contact' ?></h2>
                </div>
                <div class="col-md-4 col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                    <h3><?= $this->lang->line('get_in_touch') ? $this->lang->line('get_in_touch') : 'Get in Touch' ?></h3>
                    <address>
                        <p><?= $this->lang->line('address') ? htmlspecialchars($this->lang->line('address')) : 'Address' ?></p>
                        <p><?= $this->lang->line('phone') ? htmlspecialchars($this->lang->line('phone')) : 'Phone' ?></p>
                        <p><?= $this->lang->line('email') ? htmlspecialchars($this->lang->line('email')) : 'Email' ?></p>
                    </address>
                </div>
                <div class="col-md-8 col-sm-8 wow fadeIn" data-wow-delay="0.6s">
                    <form id="contact-form" action="<?= base_url('frontend/send_contact_message') ?>" method="post">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name"
                                   placeholder="<?= $this->lang->line('name') ? htmlspecialchars($this->lang->line('name')) : 'Name' ?>"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email"
                                   placeholder="<?= $this->lang->line('email') ? htmlspecialchars($this->lang->line('email')) : 'Email' ?>"
                                   required>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="5" name="message"
                                      placeholder="<?= $this->lang->line('message') ? htmlspecialchars($this->lang->line('message')) : 'Message' ?>"
                                      required></textarea>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase"><?= $this->lang->line('send_message') ? $this->lang->line('send_message') : 'Send Message' ?></button>
                        </div>
                    </form>
                    <div id="success" class="col-md-12">
                        <div class="alert alert-success text-center"><?= $this->lang->line('thank_you_message') ? $this->lang->line('thank_you_message') : 'Thank you for your message. We will get back to you as soon as possible.' ?></div>
                    </div>
                    <div id="error" class="col-md-12">
                        <div class="alert alert-danger text-center"><?= $this->lang->line('error_message') ? $this->lang->line('error_message') : 'Sorry, there was an error sending your message. Please try again later.' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->
<?php } ?>
<!-- Footer Section -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-logo">
                    <img src="<?= base_url('assets/uploads/logos/' . full_logo()) ?>" alt="<?= company_name() ?>"
                         class="footer-logo">
                </div>
                <div class="social-icons">
                    <?php $social_links = social_links();
                    if ($social_links && is_array($social_links) && count($social_links) > 0) {
                        foreach ($social_links as $key => $link) { ?>
                            <a href="<?= htmlspecialchars($link) ?>" target="_blank"><i class="fab <?= htmlspecialchars($key) ?>"></i></a>
                        <?php }
                    } ?>
                </div>
                <div class="footer-text">
                    <p><?= $this->lang->line('all_rights_reserved') ? $this->lang->line('all_rights_reserved') : 'All rights reserved' ?> &copy; <?= date('Y') ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer Section -->

<!-- Back to Top -->
<a href="#" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- JavaScript Libraries -->
<script src="<?= base_url('assets/front/one/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/front/one/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/front/one/js/wow.min.js') ?>"></script>

<!-- Main Script -->
<script src="<?= base_url('assets/front/one/js/custom.js') ?>"></script>

<!-- Contact Form JavaScript File -->
<script src="<?= base_url('assets/front/one/contactform/contactform.js') ?>"></script>

</body>
</html>
