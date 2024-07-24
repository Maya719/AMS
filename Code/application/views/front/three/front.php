<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php $this->load->view('front/meta'); ?>

    <link rel="stylesheet" href="<?=base_url('assets/modules/fontawesome/css/all.min.css')?>">
    
    <style>
      :root{--theme-color: <?=theme_color()?>;}
  	</style>
    <link rel="stylesheet" href="<?=base_url('assets/front/three/css/main.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/front/three/css/custom.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/front/comman.css')?>">
	<?php $google_analytics = google_analytics(); if($google_analytics){ ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?=htmlspecialchars($google_analytics)?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?=htmlspecialchars($google_analytics)?>');
	</script>
	<?php } ?>
    
</head>
<?php
$theme_color = theme_color();
?>
<body class="overflow-x-hidden antialiased">
    <!-- Header Section -->
    <header class="relative z-50 w-full h-24">
        <div
            class="container flex items-center justify-center h-full max-w-6xl px-8 mx-auto sm:justify-between xl:px-0">

            <a href="<?=base_url()?>" class="relative flex items-center inline-block h-5 h-full font-black leading-none">
                <img class="h-12 w-auto" alt="<?=company_name()?>" src="<?=base_url('assets/uploads/logos/'.full_logo())?>">
            </a>

            <nav id="nav" class="absolute top-0 left-0 z-50 flex flex-col items-center justify-between hidden w-full h-64 pt-5 mt-24 text-sm text-gray-800 bg-white border-t border-gray-200 md:w-auto md:flex-row md:h-24 lg:text-base md:bg-transparent md:mt-0 md:border-none md:py-0 md:flex md:relative">

                <?php if(frontend_permissions('features') && $features){ ?>
                <a href="#features" class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-500"><?=$this->lang->line('features')?htmlspecialchars($this->lang->line('features')):'Features'?></a>
                <?php } ?>

                <?php if(frontend_permissions('subscription_plans')){ ?>
                <a href="#pricing"  class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-500"><?=$this->lang->line('pricing')?htmlspecialchars($this->lang->line('pricing')):'Pricing'?></a>
                <?php } ?>

                <?php if(frontend_permissions('contact')){ ?>
                <a href="#contact" class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-500"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></a>
                <?php } ?>

                <?php $languages = get_languages('', '', 1);
                if($languages){ ?>
                <span class="relative">
                <button onclick="showDropdownOptions()" class="flex flex-row justify-between px-2 py-2 text-gray-700 bg-white border-2 border-white rounded-md shadow focus:outline-none focus:border-blue-600">
                    <span class="select-none"><i class="relative fa fa-language mr-2"></i></span>
                    <svg id="arrow-down" class="hidden w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    <svg id="arrow-up" class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                </button>
                <div id="options" class="hidden py-2 bg-white rounded-lg shadow-xl absolute">
                <?php foreach($languages as $language){ ?>
                    <a href="<?=base_url('languages/change/'.$language['language'])?>" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white <?=$language['language']==$this->session->userdata('lang') || ($language['language']==default_language() && !$this->session->userdata('lang'))?'bg-indigo-500 text-white':''?>"><?=ucfirst($language['language'])?></a>
                <?php } ?>
                </div>
                </span>
                <?php } ?>

                <div class="flex flex-col block w-full font-medium border-t border-gray-200 md:hidden">
                    <a href="<?=base_url('auth')?>" target="_blank" class="w-full py-2 font-bold text-center text-indigo-500"><?=$this->lang->line('login')?htmlspecialchars($this->lang->line('login')):'Login'?></a>
                    <a href="<?=base_url('auth/register')?>" target="_blank" class="w-full py-2 font-bold text-center text-white bg-indigo-500"><?=$this->lang->line('get_start')?htmlspecialchars($this->lang->line('get_start')):'Get Started'?></a>
                </div>

            </nav>

            <div class="absolute left-0 flex-col items-center justify-center hidden w-full pb-8 mt-48 border-b border-gray-200 md:relative md:w-auto md:bg-transparent md:border-none md:mt-0 md:flex-row md:p-0 md:items-end md:flex md:justify-between">

                <a href="<?=base_url('auth')?>" target="_blank" class="relative z-40 px-3 py-2 mr-0 text-sm font-bold text-pink-500 md:px-5 lg:text-white sm:mr-3 md:mt-0"><?=$this->lang->line('login')?htmlspecialchars($this->lang->line('login')):'Login'?></a>

                <a href="<?=base_url('auth/register')?>" target="_blank" class="relative z-40 inline-block w-auto h-full px-5 py-3 text-sm font-bold leading-none text-white transition-all transition duration-100 duration-300 bg-indigo-500 rounded shadow-md fold-bold sm:w-full lg:shadow-none hover:shadow-xl"><?=$this->lang->line('get_start')?htmlspecialchars($this->lang->line('get_start')):'Get Started'?></a>

                <svg class="absolute top-0 left-0 hidden w-screen max-w-3xl -mt-64 -ml-12 lg:block"
                    viewBox="0 0 818 815" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <linearGradient x1="0%" y1="0%" x2="100%" y2="100%" id="c">
                            <stop stop-color="<?=$theme_color?>" offset="0%" />
                            <stop stop-color="<?=$theme_color?>" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="0%" y1="0%" x2="100%" y2="100%" id="f">
                            <stop stop-color="#1a202c" offset="0%" />
                            <stop stop-color="#1a202c" offset="100%" />
                        </linearGradient>
                        <filter x="-4.7%" y="-3.3%" width="109.3%" height="109.3%" filterUnits="objectBoundingBox"
                            id="a">
                            <feOffset dy="8" in="SourceAlpha" result="shadowOffsetOuter1" />
                            <feGaussianBlur stdDeviation="8" in="shadowOffsetOuter1" result="shadowBlurOuter1" />
                            <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" in="shadowBlurOuter1" />
                        </filter>
                        <filter x="-4.7%" y="-3.3%" width="109.3%" height="109.3%" filterUnits="objectBoundingBox"
                            id="d">
                            <feOffset dy="8" in="SourceAlpha" result="shadowOffsetOuter1" />
                            <feGaussianBlur stdDeviation="8" in="shadowOffsetOuter1" result="shadowBlurOuter1" />
                            <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0" in="shadowBlurOuter1" />
                        </filter>
                        <path
                            d="M160.52 108.243h497.445c17.83 0 24.296 1.856 30.814 5.342 6.519 3.486 11.635 8.602 15.12 15.12 3.487 6.52 5.344 12.985 5.344 30.815v497.445c0 17.83-1.857 24.296-5.343 30.814-3.486 6.519-8.602 11.635-15.12 15.12-6.52 3.487-12.985 5.344-30.815 5.344H160.52c-17.83 0-24.296-1.857-30.814-5.343-6.519-3.486-11.635-8.602-15.12-15.12-3.487-6.52-5.343-12.985-5.343-30.815V159.52c0-17.83 1.856-24.296 5.342-30.814 3.486-6.519 8.602-11.635 15.12-15.12 6.52-3.487 12.985-5.343 30.815-5.343z"
                            id="b" />
                        <path
                            d="M159.107 107.829H656.55c17.83 0 24.296 1.856 30.815 5.342 6.518 3.487 11.634 8.602 15.12 15.12 3.486 6.52 5.343 12.985 5.343 30.816V656.55c0 17.83-1.857 24.296-5.343 30.815-3.486 6.518-8.602 11.634-15.12 15.12-6.519 3.486-12.985 5.343-30.815 5.343H159.107c-17.83 0-24.297-1.857-30.815-5.343-6.519-3.486-11.634-8.602-15.12-15.12-3.487-6.519-5.343-12.985-5.343-30.815V159.107c0-17.83 1.856-24.297 5.342-30.815 3.487-6.519 8.602-11.634 15.12-15.12 6.52-3.487 12.985-5.343 30.816-5.343z"
                            id="e" />
                    </defs>
                    <g fill="none" fill-rule="evenodd" opacity=".9">
                        <g transform="rotate(65 416.452 409.167)">
                            <use fill="#000" filter="url(#a)" xlink:href="#b" />
                            <use fill="url(#c)" xlink:href="#b" />
                        </g>
                        <g transform="rotate(29 421.929 414.496)">
                            <use fill="#000" filter="url(#d)" xlink:href="#e" />
                            <use fill="url(#f)" xlink:href="#e" />
                        </g>
                    </g>
                </svg>
            </div>

            <div id="nav-mobile-btn"
                class="absolute top-0 right-0 z-50 block w-6 mt-8 mr-10 cursor-pointer select-none md:hidden sm:mt-10">
                <span class="block w-full h-1 mt-2 duration-200 transform bg-gray-800 rounded-full sm:mt-1"></span>
                <span class="block w-full h-1 mt-1 duration-200 transform bg-gray-800 rounded-full"></span>
            </div>

        </div>
    </header>
    <!-- End Header Section-->

    <?php if(frontend_permissions('home')){ ?>
    <!-- BEGIN HERO SECTION -->
    <div class="relative items-center justify-center w-full overflow-x-hidden lg:pt-40 lg:pb-40 xl:pt-40 xl:pb-64">
        <div
            class="container flex flex-col items-center justify-between h-full max-w-6xl px-8 mx-auto -mt-32 lg:flex-row xl:px-0">
            <div
                class="z-30 flex flex-col items-center w-full max-w-xl pt-48 text-center lg:items-start lg:w-1/2 lg:pt-20 xl:pt-40 lg:text-left">
                <h1 class="relative mb-4 text-3xl font-black leading-tight text-gray-900 sm:text-6xl xl:mb-8"><?=$this->lang->line('frontend_home_title')?htmlspecialchars($this->lang->line('frontend_home_title')):'Professional Project Management tool and CRM'?></h1>
                <p class="pr-0 mb-8 text-base text-gray-600 sm:text-lg xl:text-xl lg:pr-20"><?=$this->lang->line('frontend_home_description')?htmlspecialchars($this->lang->line('frontend_home_description')):'TimeWork pms.mobipixels.com is a perfect, robust, lightweight, superfast web application to fulfill all your Team Collaboration, Project Management and CRM needs.'?></p>
                <a href="<?=base_url('auth/register')?>" target="_blank" class="relative self-start inline-block w-auto px-8 py-4 mx-auto mt-0 text-base font-bold text-white bg-indigo-500 border-t border-gray-200 rounded-md shadow-xl sm:mt-1 fold-bold lg:mx-0"><?=$this->lang->line('get_start')?$this->lang->line('get_start'):'Get Start'?></a>
                <svg class="absolute left-0 max-w-md mt-24 -ml-64 left-svg" viewBox="0 0 423 423"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <linearGradient x1="100%" y1="0%" x2="4.48%" y2="0%" id="linearGradient-1">
                            <stop stop-color="#5C54DB" offset="0%" />
                            <stop stop-color="#6A82E7" offset="100%" />
                        </linearGradient>
                        <filter x="-9.3%" y="-6.7%" width="118.7%" height="118.7%" filterUnits="objectBoundingBox"
                            id="filter-3">
                            <feOffset dy="8" in="SourceAlpha" result="shadowOffsetOuter1" />
                            <feGaussianBlur stdDeviation="8" in="shadowOffsetOuter1" result="shadowBlurOuter1" />
                            <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" in="shadowBlurOuter1" />
                        </filter>
                        <rect id="path-2" x="63" y="504" width="300" height="300" rx="40" />
                    </defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" opacity=".9">
                        <g id="Desktop-HD" transform="translate(-39 -531)">
                            <g id="Hero" transform="translate(43 83)">
                                <g id="Rectangle-6" transform="rotate(45 213 654)">
                                    <use fill="#000" filter="url(#filter-3)" xlink:href="#path-2" />
                                    <use fill="url(#linearGradient-1)" xlink:href="#path-2" />
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>
    <!-- HERO SECTION END -->
    <?php } ?>

    <?php if(frontend_permissions('features') && $features){ 
    ?>
    <!-- BEGIN FEATURES SECTION -->
    <div id="features" class="relative w-full px-8 py-10 text-center border-t border-gray-200 md:py-16 lg:py-24 xl:py-40 xl:px-0">
        <div class="container flex flex-col items-center justify-between h-full mx-auto">
            
            <h3 class="max-w-2xl px-5 mt-2 text-3xl font-black leading-tight text-center text-gray-900 sm:mt-0 sm:px-0 sm:text-6xl"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></h3>
            
            <?php if($features){ foreach($features as $key => $feature){ 
                if(($key % 3) == 0){
                    if($key != 0 && ($key % 3) == 0){
                        echo '</div>
                        </div>
                    </div>';
                    }

                    echo '<div class="w-full mx-auto md:max-w-6xl sm:p-8">
                    <div class="relative flex flex-col items-center block sm:flex-row">
                        <div class="lg:grid lg:grid-cols-3 lg:gap-8">';
                    
                }
            ?>
                <div class="p-6 my-2 transition-all duration-150 bg-white rounded-lg shadow-xl ease hover:shadow-2xl sm:p-16 sm:my-0">
                    <div class="relative inline-flex items-center justify-center w-16 h-16 overflow-hidden text-white rounded-full">
                    <i class="relative text-5xl text-indigo-500 <?=isset($feature['icon'])?htmlspecialchars($feature['icon']):'fa fa-fire'?>"></i>
                    </div>
                    <div class="mt-3 mb-6">
                        <h5 class="pb-2 text-xl font-bold leading-6 text-gray-600"><?=isset($feature['title'])?htmlspecialchars($feature['title']):''?></h5>
                        <p class="mt-1 text-base leading-6 text-gray-500">
                        <?=isset($feature['description'])?htmlspecialchars($feature['description']):''?>
                        </p>
                    </div>
                </div>

                <?php 
                    if((count($features) - 1) == $key){
                            echo '</div>
                            </div>
                        </div>';
                    }
                ?>
            <?php } } ?>
        </div>
    </div>
    <!-- END FEATURES SECTION -->
    <?php } ?>

    <?php if(frontend_permissions('subscription_plans')){ ?>
    <!-- Pricing Section -->
    <div class="relative px-8 py-10 bg-white border-t border-gray-200 md:py-16 lg:py-24 xl:py-40 xl:px-0">

        <div id="pricing" class="container flex flex-col items-center h-full max-w-6xl mx-auto">
            <h3 class="w-full max-w-2xl px-5 px-8 mt-2 text-2xl font-black leading-tight text-center text-gray-900 sm:mt-0 sm:px-0 sm:text-6xl md:px-0"><?=$this->lang->line('pricing')?htmlspecialchars($this->lang->line('pricing')):'Pricing'?></h3>

            <div class="w-full mx-auto md:max-w-6xl sm:px-8">
                
                <?php foreach($plans as $key => $plan){ 
                    if(($key % 3) == 0){
                        if($key != 0 && ($key % 3) == 0){
                            echo '</div>';
                        }
                        echo '<div class="relative flex flex-col items-center block sm:flex-row">';
                    }
                ?>
                    
                    <div class="relative z-10 w-full max-w-md my-2 mx-5 bg-white rounded-lg shadow-lg sm:w-2/3 lg:w-1/3 sm:my-5">
                        <div class="py-4 px-8 font-bold text-white uppercase bg-indigo-500 rounded-t text-2xl"><?=htmlspecialchars($plan['title'])?></div>
                        <div class="block max-w-sm px-8 mx-auto mt-5 text-sm text-left text-black sm:text-md">
                            <h3 class="pt-3 pb-6 text-lg font-bold tracking-wide text-5xl uppercase">
                                <?=get_saas_currency('currency_symbol')?><?=htmlspecialchars($plan['price'])?>
                                <span class="lowercase text-gray-500 text-xs">/
                                    <?php
                                    if($plan['billing_type'] == 'One Time'){
                                        echo $this->lang->line('one_time')?htmlspecialchars($this->lang->line('one_time')):'One Time';
                                    }elseif($plan['billing_type'] == 'Monthly'){
                                        echo $this->lang->line('monthly')?htmlspecialchars($this->lang->line('monthly')):'Monthly';
                                    }elseif($plan["billing_type"] == 'three_days_trial_plan'){
                                        echo $this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan';
                                    }elseif($plan["billing_type"] == 'seven_days_trial_plan'){
                                        echo $this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan';
                                    }elseif($plan["billing_type"] == 'fifteen_days_trial_plan'){
                                        echo $this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan';
                                    }elseif($plan["billing_type"] == 'thirty_days_trial_plan'){
                                        echo $this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan';
                                    }else{
                                        echo $this->lang->line('yearly')?htmlspecialchars($this->lang->line('yearly')):'Yearly';
                                    }
                                    ?>
                                </span>
                            </h3>
                        </div>

                        <div class="flex justify-start px-8 pb-6 sm:justify-start">
                            <ul class="text-xl">
                                <li><span class="text-xs text-white bg-indigo-500 p-1 mr-1 rounded font-bold"><?=$plan['storage']<0?$this->lang->line('unlimited')?$this->lang->line('unlimited'):'Unlimited':htmlspecialchars($plan['storage'].' GB')?></span><?=$this->lang->line('storage')?$this->lang->line('storage'):'Storage'?></li>

                                <li><span class="text-xs text-white bg-indigo-500 p-1 mr-1 rounded font-bold"><?=$plan['projects']<0?$this->lang->line('unlimited')?$this->lang->line('unlimited'):'Unlimited':htmlspecialchars($plan['projects'])?></span> <?=$this->lang->line('projects')?$this->lang->line('projects'):'Projects'?></li>

                                <li><span class="text-xs text-white bg-indigo-500 p-1 mr-1 rounded font-bold"><?=$plan['tasks']<0?$this->lang->line('unlimited')?$this->lang->line('unlimited'):'Unlimited':htmlspecialchars($plan['tasks'])?></span> <?=$this->lang->line('tasks')?$this->lang->line('tasks'):'Tasks'?></li>

                                <li><span class="text-xs text-white bg-indigo-500 p-1 mr-1 rounded font-bold"><?=$plan['users']<0?$this->lang->line('unlimited')?$this->lang->line('unlimited'):'Unlimited':htmlspecialchars($plan['users'])?></span> <?=$this->lang->line('users')?$this->lang->line('users'):'Users'?>
                                <i class="relative items-center tool-tip-custom">
                                    <i class="fa fa-question-circle"></i>
                                    <div class="absolute bottom-0 flex flex-col items-center hidden mb-6 tool-tip-custom:flex">
                                        <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-black shadow-lg rounded"><?=$this->lang->line('including_admins_clients_and_users')?$this->lang->line('including_admins_clients_and_users'):'Including Admins, Clients and Users.'?></span>
                                    </div>
                                </i></i>

                            </ul>
                        </div>

                        <div class="flex justify-start px-8 sm:justify-start">
                            <ul>
                            <?php $modules = '';
                                if($plan["modules"] != ''){
                                    foreach(json_decode($plan["modules"]) as $mod_key => $mod){
                                        $mod_name = '';
                                        if($mod_key == 'projects'){
                                        $mod_name = $this->lang->line('projects')?$this->lang->line('projects'):'Projects';
                                        }elseif($mod_key == 'tasks'){
                                        $mod_name = $this->lang->line('tasks')?$this->lang->line('tasks'):'Tasks';
                                        }elseif($mod_key == 'gantt'){
                                        $mod_name = $this->lang->line('gantt')?$this->lang->line('gantt'):'Gantt';
                                        }elseif($mod_key == 'timesheet'){
                                        $mod_name = $this->lang->line('timesheet')?$this->lang->line('timesheet'):'Timesheet';
                                        }elseif($mod_key == 'team_members'){
                                        $mod_name = $this->lang->line('team_members')?$this->lang->line('team_members'):'Team Members';
                                        }elseif($mod_key == 'clients'){
                                        $mod_name = $this->lang->line('clients')?$this->lang->line('clients'):'Clients';
                                        }elseif($mod_key == 'invoices'){
                                        $mod_name = $this->lang->line('invoices')?$this->lang->line('invoices'):'Invoices';
                                        }elseif($mod_key == 'payments'){
                                        $mod_name = $this->lang->line('payments')?$this->lang->line('payments'):'Payments';
                                        }elseif($mod_key == 'expenses'){
                                        $mod_name = $this->lang->line('expenses')?$this->lang->line('expenses'):'Expenses';
                                        }elseif($mod_key == 'calendar'){
                                        $mod_name = $this->lang->line('calendar')?$this->lang->line('calendar'):'Calendar';
                                        }elseif($mod_key == 'leaves'){
                                        $mod_name = $this->lang->line('leaves')?$this->lang->line('leaves'):'Leaves';
                                        }elseif($mod_key == 'todo'){
                                        $mod_name = $this->lang->line('todo')?$this->lang->line('todo'):'Todo';
                                        }elseif($mod_key == 'notes'){
                                        $mod_name = $this->lang->line('notes')?$this->lang->line('notes'):'Notes';
                                        }elseif($mod_key == 'chat'){
                                        $mod_name = $this->lang->line('chat')?$this->lang->line('chat'):'Chat';
                                        }elseif($mod_key == 'leads'){
                                        $mod_name = $this->lang->line('leads')?$this->lang->line('leads'):'Leads';
                                        }elseif($mod_key == 'payment_gateway'){
                                        $mod_name = $this->lang->line('payment_gateway')?$this->lang->line('payment_gateway'):'Payment Gateway';
                                        }elseif($mod_key == 'taxes'){
                                        $mod_name = $this->lang->line('taxes')?$this->lang->line('taxes'):'Taxes';
                                        }elseif($mod_key == 'custom_currency'){
                                        $mod_name = $this->lang->line('custom_currency')?$this->lang->line('custom_currency'):'Custom Currency';
                                        }elseif($mod_key == 'user_permissions'){
                                        $mod_name = $this->lang->line('user_permissions')?$this->lang->line('user_permissions'):'User Permissions';
                                        }elseif($mod_key == 'notifications'){
                                        $mod_name = $this->lang->line('notifications')?$this->lang->line('notifications'):'Notifications';
                                        }elseif($mod_key == 'languages'){
                                        $mod_name = $this->lang->line('languages')?$this->lang->line('languages'):'Languages';
                                        }elseif($mod_key == 'meetings'){
                                            $mod_name = $this->lang->line('video_meetings')?$this->lang->line('video_meetings'):'Video Meetings';
                                        }elseif($mod_key == 'estimates'){
                                            $mod_name = $this->lang->line('estimates')?$this->lang->line('estimates'):'Estimates';
                                        }elseif($mod_key == 'reports'){
                                            $mod_name = $this->lang->line('reports')?$this->lang->line('reports'):'Reports';
                                        }elseif($mod_key == 'attendance'){
                                            $mod_name = $this->lang->line('attendance')?htmlspecialchars($this->lang->line('attendance')):'Attendance';
                                        }elseif($mod_key == 'support'){
                                            $mod_name = $this->lang->line('support')?htmlspecialchars($this->lang->line('support')):'Support';
                                        }
                                        
                                        if($mod_name && $mod == 1){
                                            echo '<li class="flex items-center">
                                                <div class="text-green-500 rounded-full fill-current">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                    </svg>
                                                </div>
                                                <span class="ml-3 text-lg text-gray-700">'.$mod_name.'</span>
                                            </li>';
                                        }elseif($mod_name){
                                            echo '<li class="flex items-center">
                                                <div class="text-red-500 rounded-full fill-current">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <span class="ml-3 text-lg text-gray-700">'.$mod_name.'</span>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                            </ul>
                        </div>

                        <div class="flex items-center block p-8 uppercase">
                            <a href="<?=base_url('auth/register')?>" target="_blank" class="block w-full px-6 py-4 mt-3 text-lg font-semibold text-center text-white bg-gray-900 rounded shadow-sm hover:bg-indigo-500"><?=$this->lang->line('get_start')?$this->lang->line('get_start'):'Get Start'?></a>
                        </div>
                    </div>
                
                <?php if((count($plans) - 1) == $key){
                        echo '</div>';
                } } ?>
            </div>

        </div>

    </div>
    <!-- End Pricing Section -->
    <?php } ?>



    <?php if(frontend_permissions('contact')){ ?>
    <div id="contact" class="grid w-full grid-cols-1 gap-8 px-8 md:grid-cols-2 lg:px-16 xl:px-32 py-10 bg-white border-t border-gray-200 md:py-16 lg:py-24 xl:py-40">
        <div class="flex flex-col justify-between">
            <div>
                <h2 class="text-4xl font-bold leading-tight lg:text-5xl"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></h2>
                <p class="mt-1 text-xl text-gray-700 text-semibold">
                <?=$this->lang->line('we_love_to_hear_from_you')?htmlspecialchars($this->lang->line('we_love_to_hear_from_you')):"We'd love to hear from you."?>
                </p>
            </div>
            <div class="mt-8 text-center">
                <svg class="w-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    id="ae37f038-3a9e-4b82-ad68-fc94ba16af2a" data-name="Layer 1" viewBox="0 0 1096 574.74">
                    <defs>
                        <linearGradient id="eb6c86d6-45fa-49e0-9a60-1b0612516196" x1="819.07" y1="732.58" x2="819.07"
                            y2="560.46" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="gray" stop-opacity="0.25" />
                            <stop offset="0.54" stop-color="gray" stop-opacity="0.12" />
                            <stop offset="1" stop-color="gray" stop-opacity="0.1" />
                        </linearGradient>
                        <pattern id="ad310e25-2b04-44c8-bb7b-982389166780" data-name="New Pattern 3" width="36.88"
                            height="49.48" patternUnits="userSpaceOnUse" viewBox="0 0 36.88 49.48">
                            <rect width="36.88" height="49.48" fill="none" />
                            <path d="M4.33,13.19c4.5,0,4.51-7,0-7s-4.52,7,0,7Z" />
                            <path d="M4.51,17.16c4.51,0,4.52-7,0-7s-4.51,7,0,7Z" />
                            <path d="M4.51,20.94c4.51,0,4.52-7,0-7s-4.51,7,0,7Z" />
                            <path d="M3.38,24.72c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path
                                d="M1.09,28.29l.2.38a3.52,3.52,0,0,0,4.78,1.25,3.58,3.58,0,0,0,1.26-4.79l-.19-.37A3.52,3.52,0,0,0,2.35,23.5a3.59,3.59,0,0,0-1.26,4.79Z" />
                            <path
                                d="M1.49,30.1l.18.57a3.73,3.73,0,0,0,1.61,2.09,3.59,3.59,0,0,0,2.7.35A3.54,3.54,0,0,0,8.42,28.8l-.18-.56a3.68,3.68,0,0,0-1.61-2.1,3.61,3.61,0,0,0-2.69-.35A3.56,3.56,0,0,0,1.49,30.1Z" />
                            <path
                                d="M1.58,33.88v.38a3.54,3.54,0,0,0,3.5,3.5,3.56,3.56,0,0,0,3.5-3.5v-.38a3.54,3.54,0,0,0-3.5-3.5,3.57,3.57,0,0,0-3.5,3.5Z" />
                            <path d="M4.89,42.3c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path
                                d="M1.77,42v.19a3.54,3.54,0,0,0,3.5,3.5,3.56,3.56,0,0,0,3.5-3.5V42a3.54,3.54,0,0,0-3.5-3.5A3.56,3.56,0,0,0,1.77,42Z" />
                            <path d="M6,49.29c4.5,0,4.51-7,0-7s-4.52,7,0,7Z" />
                            <path d="M10,14.14c4.5,0,4.51-7,0-7s-4.52,7,0,7Z" />
                            <path d="M6.59,20.94c4.51,0,4.52-7,0-7s-4.51,7,0,7Z" />
                            <path d="M8.48,27c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path d="M8.48,29.26c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path d="M14.91,33.79c4.5,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path d="M9.81,38.52c4.5,0,4.51-7,0-7s-4.52,7,0,7Z" />
                            <path d="M10.56,45.13c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path d="M10.56,49.48c4.51,0,4.51-7,0-7s-4.51,7,0,7Z" />
                            <path d="M12.83,18.12c2.57,0,2.58-4,0-4s-2.58,4,0,4Z" />
                            <path d="M13,20.39c2.57,0,2.58-4,0-4s-2.58,4,0,4Z" />
                            <path d="M13.1,21v.19a2,2,0,0,0,4,0V21a2,2,0,0,0-4,0Z" />
                            <path d="M15.1,25.87c2.57,0,2.58-4,0-4s-2.58,4,0,4Z" />
                            <path d="M16.61,11.07a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M21.71,16.55a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M16.85,8.94V8.56a1,1,0,0,0-2,0v.38a1,1,0,0,0,2,0Z" />
                            <path d="M16.48,4.78V4.59a1,1,0,0,0-2,0v.19a1,1,0,0,0,2,0Z" />
                            <path d="M15.48,2a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M10.56,2a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M10.37,4.65a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M7.35,6.16a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M11.88,7.1h.38a1,1,0,0,0,0-2h-.38a1,1,0,0,0,0,2Z" />
                            <path
                                d="M13.28,11l.57,1.32a1,1,0,0,0,1.37.36,1,1,0,0,0,.36-1.37L15,10a1,1,0,0,0-1.37-.36A1,1,0,0,0,13.28,11Z" />
                            <path d="M18.44,19.33v.19a1,1,0,0,0,2,0v-.19a1,1,0,0,0-2,0Z" />
                            <path d="M20.68,24.93l.19.38c.57,1.15,2.3.14,1.72-1l-.19-.38c-.57-1.15-2.3-.14-1.72,1Z" />
                            <path
                                d="M22.13,29.38a2.48,2.48,0,0,0-.84,1.86,1,1,0,0,0,2,0,.56.56,0,0,1,.25-.44,1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0Z" />
                            <path
                                d="M20.32,33.41l-.54,1.71c-.38,1.23,1.55,1.76,1.93.53l.54-1.71c.38-1.23-1.55-1.76-1.93-.53Z" />
                            <path d="M19.44,37h-.19a1,1,0,0,0,0,2h.19a1,1,0,0,0,0-2Z" />
                            <path
                                d="M17.64,41.5l-.19.38c-.58,1.15,1.15,2.16,1.72,1l.19-.38c.58-1.15-1.15-2.16-1.72-1Z" />
                            <path d="M15.8,47.87v.56a1,1,0,0,0,2,0v-.56a1,1,0,0,0-2,0Z" />
                            <path d="M14.34,49.43a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M14.34,41.31a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path
                                d="M17.13,36.47a2,2,0,0,0,1-1.64,1,1,0,0,0-2,0c0-.13.19-.2,0-.08-1.15.58-.14,2.3,1,1.72Z" />
                            <path d="M17.37,31.29a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M18.12,28.46a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M19,24.94l.19-.38c.58-1.15-1.15-2.16-1.72-1l-.19.38c-.58,1.15,1.15,2.16,1.72,1Z" />
                            <path d="M17.93,16a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M24.64,16.05l.57.94a1,1,0,0,0,1.72-1L26.37,15a1,1,0,0,0-1.73,1Z" />
                            <path d="M34.88,29.72v.19a1,1,0,0,0,2,0v-.19a1,1,0,0,0-2,0Z" />
                            <path d="M24,39.23a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M22.85,29a1,1,0,0,0,0-2,1,1,0,0,0,0,2Z" />
                            <path d="M18.24,21.9l.57-.56c.93-.89-.48-2.3-1.41-1.41l-.58.56c-.93.89.49,2.3,1.42,1.41Z" />
                        </pattern>
                        <linearGradient id="a964f849-fa65-4178-8cc4-fb8fb10b3617" x1="462.91" y1="660.68" x2="462.91"
                            y2="559.69" xlink:href="#eb6c86d6-45fa-49e0-9a60-1b0612516196" />
                    </defs>
                    <title><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></title>
                    <g opacity="0.1">
                        <ellipse cx="479.42" cy="362.12" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M540.43,461a18,18,0,0,0,2.38-9.11c0-8.23-5.1-14.9-11.39-14.9S520,443.68,520,451.91a18,18,0,0,0,2.38,9.11,18.61,18.61,0,0,0,0,18.21,18.61,18.61,0,0,0,0,18.21,17.94,17.94,0,0,0-2.38,9.11c0,8.22,5.1,14.9,11.38,14.9s11.39-6.68,11.39-14.9a17.94,17.94,0,0,0-2.38-9.11,18.61,18.61,0,0,0,0-18.21,18.61,18.61,0,0,0,0-18.21Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="479.42" cy="271.07" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <ellipse cx="479.42" cy="252.86" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M488.82,290.86a53.08,53.08,0,0,1-4.24-6.24l29.9-4.91-32.34.24a54.62,54.62,0,0,1-1-43.2l43.39,22.51-40-29.42a54.53,54.53,0,1,1,90,61,54.54,54.54,0,0,1,6.22,9.94L541.92,321l41.39-13.89a54.53,54.53,0,0,1-8.79,51.2,54.52,54.52,0,1,1-85.7,0,54.52,54.52,0,0,1,0-67.42Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M586.19,324.57a54.27,54.27,0,0,1-11.67,33.71,54.52,54.52,0,1,1-85.7,0C481.51,349,586.19,318.45,586.19,324.57Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <g opacity="0.1">
                        <ellipse cx="612.28" cy="330.26" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M671,445.26a13.43,13.43,0,0,0,1.77-6.8c0-6.15-3.81-11.14-8.5-11.14s-8.51,5-8.51,11.14a13.33,13.33,0,0,0,1.78,6.8,13.9,13.9,0,0,0,0,13.61,13.9,13.9,0,0,0,0,13.61,13.33,13.33,0,0,0-1.78,6.8c0,6.15,3.81,11.14,8.51,11.14s8.5-5,8.5-11.14a13.43,13.43,0,0,0-1.77-6.8,14,14,0,0,0,0-13.61,14,14,0,0,0,0-13.61Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="612.28" cy="262.22" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <ellipse cx="612.28" cy="248.61" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M632.44,318.11a39,39,0,0,1-3.17-4.66l22.35-3.67-24.17.18a40.84,40.84,0,0,1-.78-32.29L659.1,294.5l-29.91-22a40.75,40.75,0,1,1,67.29,45.6,41.2,41.2,0,0,1,4.65,7.43l-29,15.07,30.93-10.38a40.76,40.76,0,0,1-6.57,38.26,40.74,40.74,0,1,1-64,0,40.74,40.74,0,0,1,0-50.38Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M705.2,343.3a40.57,40.57,0,0,1-8.72,25.19,40.74,40.74,0,1,1-64,0C627,361.56,705.2,338.73,705.2,343.3Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <g opacity="0.1">
                        <ellipse cx="1038.58" cy="322.12" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M1081.57,421a18,18,0,0,1-2.38-9.11c0-8.23,5.1-14.9,11.39-14.9s11.38,6.67,11.38,14.9a18,18,0,0,1-2.38,9.11,18.61,18.61,0,0,1,0,18.21,18.61,18.61,0,0,1,0,18.21,17.94,17.94,0,0,1,2.38,9.11c0,8.22-5.1,14.9-11.38,14.9s-11.39-6.68-11.39-14.9a17.94,17.94,0,0,1,2.38-9.11,18.61,18.61,0,0,1,0-18.21,18.61,18.61,0,0,1,0-18.21Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="1038.58" cy="231.07" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <ellipse cx="1038.58" cy="212.86" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M1133.18,250.86a53.08,53.08,0,0,0,4.24-6.24l-29.9-4.91,32.34.24a54.62,54.62,0,0,0,1-43.2l-43.39,22.51,40-29.42a54.53,54.53,0,1,0-90,61,54.54,54.54,0,0,0-6.22,9.94L1080.08,281l-41.39-13.89a54.53,54.53,0,0,0,8.79,51.2,54.52,54.52,0,1,0,85.7,0,54.52,54.52,0,0,0,0-67.42Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M1035.81,284.57a54.27,54.27,0,0,0,11.67,33.71,54.52,54.52,0,1,0,85.7,0C1140.49,309,1035.81,278.45,1035.81,284.57Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <g opacity="0.1">
                        <ellipse cx="928.72" cy="324.26" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M974,439.26a13.43,13.43,0,0,1-1.77-6.8c0-6.15,3.81-11.14,8.5-11.14s8.51,5,8.51,11.14a13.33,13.33,0,0,1-1.78,6.8,13.9,13.9,0,0,1,0,13.61,13.9,13.9,0,0,1,0,13.61,13.33,13.33,0,0,1,1.78,6.8c0,6.15-3.81,11.14-8.51,11.14s-8.5-5-8.5-11.14a13.43,13.43,0,0,1,1.77-6.8,14,14,0,0,1,0-13.61,14,14,0,0,1,0-13.61Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="928.72" cy="256.22" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <ellipse cx="928.72" cy="242.61" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M1012.56,312.11a39,39,0,0,0,3.17-4.66l-22.35-3.67,24.17.18a40.84,40.84,0,0,0,.78-32.29L985.9,288.5l29.91-22a40.75,40.75,0,1,0-67.29,45.6,41.2,41.2,0,0,0-4.65,7.43l29,15.07L942,324.23a40.76,40.76,0,0,0,6.57,38.26,40.74,40.74,0,1,0,64,0,40.74,40.74,0,0,0,0-50.38Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M939.8,337.3a40.57,40.57,0,0,0,8.72,25.19,40.74,40.74,0,1,0,64,0C1018,355.56,939.8,332.73,939.8,337.3Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <g opacity="0.1">
                        <ellipse cx="61.59" cy="322.12" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M122.59,421a18,18,0,0,0,2.38-9.11c0-8.23-5.1-14.9-11.38-14.9s-11.38,6.67-11.38,14.9a18,18,0,0,0,2.37,9.11,18.67,18.67,0,0,0,0,18.21,18.67,18.67,0,0,0,0,18.21,17.93,17.93,0,0,0-2.37,9.11c0,8.22,5.09,14.9,11.38,14.9S125,474.77,125,466.55a17.94,17.94,0,0,0-2.38-9.11,18.61,18.61,0,0,0,0-18.21,18.61,18.61,0,0,0,0-18.21Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="61.59" cy="231.07" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <ellipse cx="61.59" cy="212.86" rx="11.38" ry="14.9" fill="#3f3d56" />
                        <path
                            d="M71,250.86a54.33,54.33,0,0,1-4.24-6.24l29.91-4.91L64.3,240a54.62,54.62,0,0,1-1-43.2l43.4,22.51-40-29.42a54.52,54.52,0,1,1,90,61,54.54,54.54,0,0,1,6.22,9.94L124.08,281l41.4-13.89a54.59,54.59,0,0,1-8.8,51.2,54.52,54.52,0,1,1-85.7,0,54.52,54.52,0,0,1,0-67.42Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M168.35,284.57a54.27,54.27,0,0,1-11.67,33.71,54.52,54.52,0,1,1-85.7,0C63.67,309,168.35,278.45,168.35,284.57Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <g opacity="0.1">
                        <ellipse cx="171.44" cy="324.26" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M230.17,439.26a13.43,13.43,0,0,0,1.77-6.8c0-6.15-3.8-11.14-8.5-11.14s-8.51,5-8.51,11.14a13.43,13.43,0,0,0,1.78,6.8,13.9,13.9,0,0,0,0,13.61,13.9,13.9,0,0,0,0,13.61,13.43,13.43,0,0,0-1.78,6.8c0,6.15,3.81,11.14,8.51,11.14s8.5-5,8.5-11.14a13.43,13.43,0,0,0-1.77-6.8,14,14,0,0,0,0-13.61,14,14,0,0,0,0-13.61Z"
                            transform="translate(-52 -162.63)" fill="#3f3d56" />
                        <ellipse cx="171.44" cy="256.22" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <ellipse cx="171.44" cy="242.61" rx="8.51" ry="11.13" fill="#3f3d56" />
                        <path
                            d="M191.6,312.11a40.21,40.21,0,0,1-3.17-4.66l22.35-3.67-24.17.18a40.84,40.84,0,0,1-.78-32.29l32.43,16.83-29.91-22a40.75,40.75,0,1,1,67.29,45.6,40.12,40.12,0,0,1,4.65,7.43l-29,15.07,30.93-10.38a40.76,40.76,0,0,1-6.57,38.26,40.74,40.74,0,1,1-64,0,40.74,40.74,0,0,1,0-50.38Z"
                            transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                        <path
                            d="M264.36,337.3a40.57,40.57,0,0,1-8.72,25.19,40.74,40.74,0,1,1-64,0C186.14,355.56,264.36,332.73,264.36,337.3Z"
                            transform="translate(-52 -162.63)" opacity="0.1" />
                    </g>
                    <ellipse cx="548" cy="493.13" rx="548" ry="8.86" fill="<?=$theme_color?>" opacity="0.1" />
                    <ellipse cx="548" cy="565.88" rx="548" ry="8.86" fill="<?=$theme_color?>" opacity="0.1" />
                    <ellipse cx="548" cy="341.3" rx="548" ry="8.86" fill="<?=$theme_color?>" opacity="0.1" />
                    <ellipse cx="548" cy="417.21" rx="548" ry="8.86" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M860.79,273a18.3,18.3,0,0,0-10.6,1.16,15.65,15.65,0,0,1-12.74,0,17.88,17.88,0,0,0-15,.29,9.24,9.24,0,0,1-4.31,1.08c-6.08,0-11.13-6.12-12.18-14.19a11.88,11.88,0,0,0,3-3.27c3.56-5.74,9.07-9.43,15.27-9.43s11.64,3.64,15.2,9.32a11.68,11.68,0,0,0,10.09,5.54h.16C854.57,263.45,858.76,267.33,860.79,273Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M879.3,247.65l-9.82,6.22,6-10.84a9.7,9.7,0,0,0-5.94-2.11h-.16a11.35,11.35,0,0,1-2-.15L864,242.88l1.43-2.6a11.79,11.79,0,0,1-5.83-4.42l-6,3.78,3.76-6.84c-3.48-4.18-8.18-6.74-13.34-6.74-6.2,0-11.71,3.68-15.28,9.42a11.41,11.41,0,0,1-10.09,5.44h-.33c-6.84,0-12.38,7.75-12.38,17.31s5.54,17.32,12.38,17.32a9.39,9.39,0,0,0,4.31-1.08,17.86,17.86,0,0,1,15-.3,15.55,15.55,0,0,0,12.74,0,17.92,17.92,0,0,1,14.86.29,9.3,9.3,0,0,0,4.26,1.06c6.84,0,12.38-7.76,12.38-17.32A21.93,21.93,0,0,0,879.3,247.65Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M443.26,267.59a12.84,12.84,0,0,0-7.43.81,10.92,10.92,0,0,1-8.91,0,12.48,12.48,0,0,0-10.49.21,6.62,6.62,0,0,1-3,.75c-4.25,0-7.79-4.28-8.53-9.93a8.32,8.32,0,0,0,2.13-2.29c2.49-4,6.35-6.6,10.69-6.6s8.15,2.55,10.64,6.52a8.19,8.19,0,0,0,7.07,3.88h.11C438.9,260.92,441.83,263.64,443.26,267.59Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M456.21,249.86l-6.87,4.36,4.17-7.59a6.75,6.75,0,0,0-4.15-1.48h-.12a7.49,7.49,0,0,1-1.42-.11l-2.33,1.48,1-1.82a8.3,8.3,0,0,1-4.08-3.09l-4.17,2.64,2.64-4.78a12.21,12.21,0,0,0-9.34-4.73c-4.34,0-8.2,2.58-10.69,6.6a8,8,0,0,1-7.07,3.81h-.23c-4.79,0-8.67,5.42-8.67,12.12s3.88,12.12,8.67,12.12a6.5,6.5,0,0,0,3-.76,12.5,12.5,0,0,1,10.48-.2,11.1,11.1,0,0,0,4.49,1,11,11,0,0,0,4.43-.94,12.54,12.54,0,0,1,10.4.2,6.48,6.48,0,0,0,3,.74c4.78,0,8.66-5.43,8.66-12.12A15.33,15.33,0,0,0,456.21,249.86Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M321.59,346a12.82,12.82,0,0,1,7.42.81,10.94,10.94,0,0,0,8.92,0,12.52,12.52,0,0,1,10.49.2,6.47,6.47,0,0,0,3,.76c4.25,0,7.79-4.29,8.52-9.94a8.15,8.15,0,0,1-2.12-2.29c-2.5-4-6.36-6.59-10.69-6.59s-8.15,2.54-10.65,6.52a8.19,8.19,0,0,1-7.06,3.88h-.11C325.94,339.37,323,342.08,321.59,346Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M308.63,328.3l6.88,4.36-4.18-7.58a6.79,6.79,0,0,1,4.16-1.49h.11a8.52,8.52,0,0,0,1.43-.1l2.33,1.47-1-1.81a8.29,8.29,0,0,0,4.07-3.09l4.17,2.64L324,317.91a12.2,12.2,0,0,1,9.34-4.72c4.33,0,8.2,2.58,10.69,6.6a8,8,0,0,0,7.06,3.81h.24c4.78,0,8.66,5.43,8.66,12.12s-3.88,12.12-8.66,12.12a6.49,6.49,0,0,1-3-.75,12.48,12.48,0,0,0-10.49-.21,10.86,10.86,0,0,1-4.48,1,11,11,0,0,1-4.44-.94,12.52,12.52,0,0,0-10.39.2,6.48,6.48,0,0,1-3,.74c-4.79,0-8.67-5.42-8.67-12.12A15.44,15.44,0,0,1,308.63,328.3Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" opacity="0.1" />
                    <path
                        d="M716.31,652.89c2.61-4.84-.35-10.76-3.75-15.07s-7.56-8.8-7.47-14.29c.13-7.89,8.51-12.56,15.2-16.74a74.3,74.3,0,0,0,13.65-11,20.13,20.13,0,0,0,4.19-5.62c1.39-3.08,1.35-6.6,1.26-10q-.43-16.89-1.67-33.76"
                        transform="translate(-52 -162.63)" fill="none" stroke="#3f3d56" stroke-miterlimit="10"
                        stroke-width="4" />
                    <path
                        d="M750.45,545.85a12.31,12.31,0,0,0-6.15-10.09l-2.76,5.45.09-6.6a12.31,12.31,0,1,0,8.82,11.24Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M728.49,629.17a12.31,12.31,0,0,1-23.24-5,12,12,0,0,1,.8-5,12.32,12.32,0,0,1,23,.13l-7.69,6.26,8.46-2A12.24,12.24,0,0,1,728.49,629.17Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M722.41,605.27a12.31,12.31,0,0,1-3.9-24.15l-.07,5.07,2.79-5.52h0a12.31,12.31,0,1,1,1.15,24.6Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path d="M752.3,585.38a12.31,12.31,0,1,1,5.44-23l-2.17,6L760,564a12.31,12.31,0,0,1-7.74,21.37Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M748.79,549.13c-2.84.31-5.6,1.19-8.46,1.37s-6-.51-7.78-2.72a39.48,39.48,0,0,1-2.28-4,8.76,8.76,0,0,0-3.1-2.92,12.31,12.31,0,1,0,23,8.18C749.72,549.05,749.25,549.08,748.79,549.13Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M752.3,585.38a12.31,12.31,0,0,1-11.71-17.56,9.11,9.11,0,0,1,2.47,2.48,41.72,41.72,0,0,0,2.44,4.07c1.92,2.25,5.2,3,8.17,2.85s5.84-1,8.8-1.25c.41,0,.82-.06,1.24-.07A12.31,12.31,0,0,1,752.3,585.38Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M722.41,605.27a12.31,12.31,0,0,1-11.81-17.33,10,10,0,0,1,2.61,2.5,41.23,41.23,0,0,0,2.67,4.15c2.07,2.31,5.57,3.13,8.71,3s6-.81,9-1A12.33,12.33,0,0,1,722.41,605.27Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M728.49,629.17a12.31,12.31,0,0,1-23.24-5,12,12,0,0,1,.8-5,12.29,12.29,0,0,1,2.7,2.41c1.17,1.42,1.94,3,3.3,4.37,2.51,2.47,6.58,3.49,10.19,3.58A51.7,51.7,0,0,0,728.49,629.17Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M106.31,580.89c2.61-4.84-.35-10.76-3.75-15.07S95,557,95.09,551.53c.13-7.89,8.51-12.56,15.2-16.74a74.3,74.3,0,0,0,13.65-11,20.13,20.13,0,0,0,4.19-5.62c1.39-3.08,1.35-6.6,1.26-10q-.44-16.89-1.67-33.76"
                        transform="translate(-52 -162.63)" fill="none" stroke="#3f3d56" stroke-miterlimit="10"
                        stroke-width="4" />
                    <path
                        d="M140.45,473.85a12.31,12.31,0,0,0-6.15-10.09l-2.76,5.45.09-6.6a12.31,12.31,0,1,0,8.82,11.24Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M118.49,557.17a12.31,12.31,0,0,1-23.24-5,12,12,0,0,1,.8-5,12.32,12.32,0,0,1,23,.13l-7.69,6.26,8.46-2A12.24,12.24,0,0,1,118.49,557.17Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M112.41,533.27a12.31,12.31,0,0,1-3.9-24.15l-.07,5.07,2.79-5.52h0a12.31,12.31,0,1,1,1.15,24.6Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path d="M142.3,513.38a12.31,12.31,0,1,1,5.44-23l-2.17,6L150,492a12.31,12.31,0,0,1-7.74,21.37Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M138.79,477.13c-2.84.31-5.6,1.19-8.46,1.37s-6-.51-7.78-2.72a39.48,39.48,0,0,1-2.28-4,8.76,8.76,0,0,0-3.1-2.92,12.31,12.31,0,1,0,23,8.18C139.72,477.05,139.25,477.08,138.79,477.13Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M142.3,513.38a12.31,12.31,0,0,1-11.71-17.56,9.11,9.11,0,0,1,2.47,2.48,41.72,41.72,0,0,0,2.44,4.07c1.92,2.25,5.2,3,8.17,2.85s5.84-1,8.8-1.25c.41,0,.82-.06,1.24-.07A12.31,12.31,0,0,1,142.3,513.38Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M112.41,533.27a12.31,12.31,0,0,1-11.81-17.33,10,10,0,0,1,2.61,2.5,41.23,41.23,0,0,0,2.67,4.15c2.07,2.31,5.57,3.13,8.71,3s6-.81,9-1A12.33,12.33,0,0,1,112.41,533.27Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M118.49,557.17a12.31,12.31,0,0,1-23.24-5,12,12,0,0,1,.8-5,12.29,12.29,0,0,1,2.7,2.41c1.17,1.42,1.94,3,3.3,4.37,2.51,2.47,6.58,3.49,10.19,3.58A51.7,51.7,0,0,0,118.49,557.17Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M512.52,498.52c-2.61-4.83.35-10.75,3.76-15.06s7.55-8.8,7.46-14.29c-.12-7.9-8.5-12.56-15.2-16.74a74,74,0,0,1-13.64-11,19.78,19.78,0,0,1-4.2-5.61c-1.38-3.09-1.34-6.6-1.26-10q.45-16.89,1.67-33.76"
                        transform="translate(-52 -162.63)" fill="none" stroke="#3f3d56" stroke-miterlimit="10"
                        stroke-width="4" />
                    <path
                        d="M478.39,391.49a12.3,12.3,0,0,1,6.14-10.09l2.76,5.45-.08-6.6a12.62,12.62,0,0,1,4.05-.49,12.31,12.31,0,1,1-12.87,11.73Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M500.34,474.81a12.31,12.31,0,1,0-.59-9.91l7.69,6.26-8.46-2A12.24,12.24,0,0,0,500.34,474.81Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M506.42,450.91a12.31,12.31,0,0,0,3.91-24.15l.06,5.07-2.79-5.52h0A12.31,12.31,0,0,0,494.7,438a12.16,12.16,0,0,0,.53,4.2A12.3,12.3,0,0,0,506.42,450.91Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M476.54,431a12.31,12.31,0,1,0-5.45-23l2.18,6-4.48-4.29a12.21,12.21,0,0,0-4,8.5,11.91,11.91,0,0,0,.31,3.39A12.3,12.3,0,0,0,476.54,431Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M480.05,394.77c2.84.31,5.6,1.19,8.45,1.37s6-.51,7.79-2.72a39.4,39.4,0,0,0,2.27-4,8.79,8.79,0,0,1,3.11-2.92,12.31,12.31,0,1,1-23,8.17C479.12,394.68,479.58,394.72,480.05,394.77Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M476.54,431a12.32,12.32,0,0,0,11.71-17.56,9.15,9.15,0,0,0-2.48,2.48,41.72,41.72,0,0,1-2.44,4.07c-1.91,2.25-5.19,3-8.16,2.85s-5.84-1-8.8-1.25c-.41,0-.83-.06-1.24-.07A12.3,12.3,0,0,0,476.54,431Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M506.42,450.91a12.3,12.3,0,0,0,11.81-17.33,9.83,9.83,0,0,0-2.6,2.5,41.23,41.23,0,0,1-2.67,4.15c-2.08,2.31-5.57,3.13-8.72,3s-6-.81-9-1A12.3,12.3,0,0,0,506.42,450.91Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M500.34,474.81a12.31,12.31,0,0,0,22.45-10,11.82,11.82,0,0,0-2.7,2.41c-1.17,1.42-2,3-3.3,4.37-2.52,2.47-6.58,3.49-10.2,3.58A53.94,53.94,0,0,1,500.34,474.81Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <circle cx="779.73" cy="238.18" r="99.96" fill="#3f3d56" />
                    <path
                        d="M874.64,426.59c-3.48-3.48-11.85-8.73-16-10.69-4.79-2.3-6.55-2.26-9.94.19-2.82,2-4.65,3.93-7.89,3.22s-9.66-5.55-15.87-11.74S813.91,395,813.22,391.71s1.21-5.08,3.23-7.9c2.44-3.39,2.51-5.15.19-9.94-2-4.15-7.19-12.5-10.7-16s-4.27-2.73-6.19-2a35.8,35.8,0,0,0-5.67,3c-3.48,2.33-5.43,4.27-6.8,7.19s-2.92,8.34,5.05,22.53a125.69,125.69,0,0,0,22.1,29.47l0,0,0,0A125.88,125.88,0,0,0,844,440.2c14.18,8,19.61,6.41,22.53,5.05s4.86-3.29,7.18-6.8a35.33,35.33,0,0,0,3-5.67C877.37,430.86,878.15,430.08,874.64,426.59Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M831.73,300.86a100,100,0,1,0,99.95,99.95A100,100,0,0,0,831.73,300.86Zm0,186.62a86.67,86.67,0,1,1,86.67-86.67A86.67,86.67,0,0,1,831.73,487.48Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <circle cx="550.08" cy="390.01" r="99.96" fill="#3f3d56" />
                    <path
                        d="M658.93,522.44,629,552.89a.54.54,0,0,0,0,.78L650,576a3.62,3.62,0,0,1-2.55,6.17,3.64,3.64,0,0,1-2.56-1.06L624,558.86a.57.57,0,0,0-.8,0L618.11,564a22.37,22.37,0,0,1-16,6.73,22.86,22.86,0,0,1-16.28-6.92l-4.89-5a.57.57,0,0,0-.8,0l-20.84,22.2a3.61,3.61,0,0,1-5.11,0,3.6,3.6,0,0,1,0-5.11l20.92-22.28a.6.6,0,0,0,0-.78l-29.93-30.45a.55.55,0,0,0-.94.39v60.93a8.92,8.92,0,0,0,8.89,8.89H651a8.92,8.92,0,0,0,8.89-8.89V522.83A.55.55,0,0,0,658.93,522.44Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M602.08,563.5A15.14,15.14,0,0,0,613,559l43.59-44.37a8.7,8.7,0,0,0-5.5-2H553.15a8.64,8.64,0,0,0-5.5,2L591.25,559A15.08,15.08,0,0,0,602.08,563.5Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M600.82,452.69a100,100,0,1,0,99.95,99.95A100,100,0,0,0,600.82,452.69Zm0,186.62a86.67,86.67,0,1,1,86.67-86.67A86.67,86.67,0,0,1,600.82,639.31Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <circle cx="312.85" cy="315.36" r="99.96" fill="#3f3d56" />
                    <path d="M364.85,430.16,325,522.1l3.72,3.72,36.14-15.94L401,525.82l3.72-3.72Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M364.85,378A100,100,0,1,0,464.8,478,100,100,0,0,0,364.85,378Zm0,186.62A86.67,86.67,0,1,1,451.52,478,86.67,86.67,0,0,1,364.85,564.66Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M840.93,603.88q-1.36-3.32-2.79-6.62a19.65,19.65,0,0,0-3.41-5.89,6.24,6.24,0,0,0-2-1.5,8.53,8.53,0,0,0-2.61-.52,20.83,20.83,0,0,0-4.1-.11c-.53-.16-1.13-.37-1.72-.61a14.28,14.28,0,0,0,10.64-13.25c0-.2,0-.41,0-.61a14.25,14.25,0,0,0-14.19-14.31,14,14,0,0,0-7.45,2.13,13.37,13.37,0,0,0-15,7.23,16.53,16.53,0,0,0-5.1,12.3c0,.21,0,.43,0,.63.26,7.77,5.28,14,11.62,14.63a6.66,6.66,0,0,0-1.84,1.23c-1.94,1.87-2.26,4.84-2.47,7.54l-.15,2L797,609.35a.62.62,0,0,0-.15,1.09l3.21,2.29c0,.19,0,.38,0,.57s0,.43.06.65a4.59,4.59,0,0,0-1.24,1.77,8.18,8.18,0,0,0-.29,3.24l.12,2.79a21.91,21.91,0,0,0,.85,6.21c.42,1.24,2.24,4.23,3.55,4.25-1.21,5.5-1.53,17.1-1.53,17.1-.15.15.27.29,1,.41.72,5.52,3.07,21,7.24,27.81a58.64,58.64,0,0,1,1.57,6.76s1.19,14.71,2.76,19.08c1.34,3.72,2.4,12.9,2.69,15.56a1.53,1.53,0,0,0-1.11,1.14c-.79,2.38-5.91,6-5.91,6a24.76,24.76,0,0,0-4.42,2.83c-1.61,1.45-1.55,2.76,5.6,1.94,13.8-1.59,16.16-6,16.16-6s-.22-.74-.55-1.7a18.46,18.46,0,0,0-1.81-4.27c-.2-.19-.4.13-.64.63a85.63,85.63,0,0,1-.94-19.31s.39-6.76-1.58-11.53a21.83,21.83,0,0,1,0-7.55c.79-3.18-3.15-18.69-3.15-18.69L816.23,651a3.28,3.28,0,0,1,.63,1.33l.06.23.06.33a.62.62,0,0,0,.16.31c1.54,6.4,5.76,24.13,5.76,26.73,0,3.18,3.94,11.13,3.94,11.13s1.57,13.12,4.33,18.28c2.1,3.93,2.15,9.69,2.05,12.23h0s-.47,3.27-1.26,4.06a9.66,9.66,0,0,0-1.49,2.59l-.09.19s-1.18,2.39-.39,2.79a19.37,19.37,0,0,0,9.46,1.19s1.58-2,1.58-2.78a12.52,12.52,0,0,0-.18-1.42c-.29-1.88-.83-4.84-.84-4.87.33-1.28-1-4.84-1-4.84l-.4-11.13a51.38,51.38,0,0,0-2.76-22.27s-2-7.15-1.57-9.14-.79-23.06-.79-23.06l-.12-.3a22.78,22.78,0,0,1,.12-4.47c.39-4.77-1.18-14.71-1.58-15.1a13.1,13.1,0,0,1-.56-3.29c.09-.83.36-3.26.73-6.28a112.91,112.91,0,0,0,11.62-1,1.45,1.45,0,0,0,1-.4,1.4,1.4,0,0,0,.23-.81C845.39,615.24,843.2,609.42,840.93,603.88ZM833,616.49c.41-2.85.85-5.61,1.29-7.66l.06.18a55.65,55.65,0,0,1,1.9,6.3A21.43,21.43,0,0,1,833,616.49Z"
                        transform="translate(-52 -162.63)" fill="url(#eb6c86d6-45fa-49e0-9a60-1b0612516196)" />
                    <path
                        d="M802.37,648.68s2.36,21.23,7.47,29.48a57.21,57.21,0,0,1,1.57,6.68s1.18,14.54,2.75,18.86,2.75,16.12,2.75,16.12,5.5,6.28,7.47,1.18a82.82,82.82,0,0,1-1.18-20.44s.39-6.68-1.57-11.4a21.32,21.32,0,0,1,0-7.46c.78-3.15-3.15-18.47-3.15-18.47l-3.14-15.33Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <path
                        d="M827.13,724.93s-2.36,4.32-16.11,5.89c-7.14.81-7.19-.48-5.58-1.92a24.9,24.9,0,0,1,4.4-2.8s5.11-3.53,5.89-5.89,3.54-.39,3.54-.39c3.93,5.89,4.72-1.58,5.5-.79a17.73,17.73,0,0,1,1.81,4.21C826.91,724.19,827.13,724.93,827.13,724.93Z"
                        transform="translate(-52 -162.63)" fill="#ff6f61" />
                    <path
                        d="M827.13,724.93s-2.36,4.32-16.11,5.89c-7.14.81-7.19-.48-5.58-1.92,1.12.71,3.38,1,7.93-.83,6.55-2.68,11.3-4.23,13.21-4.83C826.91,724.19,827.13,724.93,827.13,724.93Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M823.2,700.56s.39-6.68-1.57-11.4a21.32,21.32,0,0,1,0-7.46c.78-3.15-3.15-18.47-3.15-18.47l-3.14-15.33-2.72.16,3.11,15.17s3.93,15.32,3.15,18.47a21.32,21.32,0,0,0,0,7.46c2,4.72,1.57,11.4,1.57,11.4A82.82,82.82,0,0,0,821.63,721a3.44,3.44,0,0,1-1.14,1.62c1.46.66,3,.63,3.89-1.62A82.82,82.82,0,0,1,823.2,700.56Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M820.64,562.42a14,14,0,0,0-7.42,2.11,13.35,13.35,0,0,0-15,7.15,16.28,16.28,0,0,0-5.09,12.16c0,8.36,5.63,15.13,12.57,15.13,5,0,9.38-3.56,11.39-8.71a13.8,13.8,0,0,0,3.54.46,14.15,14.15,0,0,0,0-28.3Z"
                        transform="translate(-52 -162.63)" fill="#3f3d56" />
                    <path
                        d="M832.24,650.65l1.18,3.14s1.18,20.83.78,22.8,1.58,9,1.58,9a50.31,50.31,0,0,1,2.75,22l.39,11s1.57,4.32.79,5.11S833,723,833,723s.79-8.25-2-13.36-4.32-18.08-4.32-18.08-3.93-7.86-3.93-11-6.29-28.69-6.29-28.69Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <path
                        d="M801.58,650.26s.4-14.15,2-18.47a29.33,29.33,0,0,0,1.75-6.27s23.79,4.3,25.76,2.73c0,0,.39,5.5.79,5.89s2,10.22,1.57,14.94,0,4.71,0,4.71-16.12,2.36-16.51,0-1.57-2.35-1.57-2.35S800.8,651,801.58,650.26Z"
                        transform="translate(-52 -162.63)" fill="#3f3d56" />
                    <g opacity="0.1">
                        <path
                            d="M814.55,650.26s-9.94-.27-12.94-.81c0,.51,0,.81,0,.81-.78.78,13.76,1.18,13.76,1.18a1,1,0,0,1,.54.22C815.38,650.26,814.55,650.26,814.55,650.26Z"
                            transform="translate(-52 -162.63)" />
                        <path
                            d="M831.85,634.14c-.4-.39-.79-5.89-.79-5.89a1.69,1.69,0,0,1-.67.24c.14,1.66.41,4.21.67,4.47s2,10.22,1.57,14.94,0,4.71,0,4.71-12.75,1.87-15.84.62c0,.17.09.36.12.56.39,2.36,16.51,0,16.51,0s-.4,0,0-4.71S832.24,634.54,831.85,634.14Z"
                            transform="translate(-52 -162.63)" />
                        <path
                            d="M814.55,650.26s-9.94-.27-12.94-.81c0,.51,0,.81,0,.81-.78.78,13.76,1.18,13.76,1.18a1,1,0,0,1,.54.22C815.38,650.26,814.55,650.26,814.55,650.26Z"
                            transform="translate(-52 -162.63)" fill="url(#ad310e25-2b04-44c8-bb7b-982389166780)" />
                        <path
                            d="M831.85,634.14c-.4-.39-.79-5.89-.79-5.89a1.69,1.69,0,0,1-.67.24c.14,1.66.41,4.21.67,4.47s2,10.22,1.57,14.94,0,4.71,0,4.71-12.75,1.87-15.84.62c0,.17.09.36.12.56.39,2.36,16.51,0,16.51,0s-.4,0,0-4.71S832.24,634.54,831.85,634.14Z"
                            transform="translate(-52 -162.63)" fill="url(#ad310e25-2b04-44c8-bb7b-982389166780)" />
                    </g>
                    <path
                        d="M818.9,587.18a5.21,5.21,0,0,0,1.5,1.94,3.36,3.36,0,0,0,1.41.61c-.88.51-1.84.89-2.72,1.4a48.36,48.36,0,0,0-4,3,8.14,8.14,0,0,1-4.59,1.78,5.62,5.62,0,0,0,.64-5.59,5.22,5.22,0,0,1-.7-1.94c0-1.13,1-2,1.93-2.6.75-.51,1.52-1,2.3-1.49.61-.38,1.53-1.18,2.3-1.15s.86.71,1,1.41A11.09,11.09,0,0,0,818.9,587.18Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <path
                        d="M818.9,587.18a5.21,5.21,0,0,0,1.5,1.94,3.36,3.36,0,0,0,1.41.61c-.88.51-1.84.89-2.72,1.4a48.36,48.36,0,0,0-4,3,8.14,8.14,0,0,1-4.59,1.78,5.62,5.62,0,0,0,.64-5.59,5.22,5.22,0,0,1-.7-1.94c0-1.13,1-2,1.93-2.6.75-.51,1.52-1,2.3-1.49.61-.38,1.53-1.18,2.3-1.15s.86.71,1,1.41A11.09,11.09,0,0,0,818.9,587.18Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <circle cx="776.11" cy="438.7" r="9.04" fill="#be6f72" />
                    <path
                        d="M840.88,729.64c0,.79-1.57,2.75-1.57,2.75a19.46,19.46,0,0,1-9.43-1.18c-.79-.39.39-2.75.39-2.75l.09-.19a9.54,9.54,0,0,1,1.49-2.56c.78-.78,1.25-4,1.25-4,2.44-4,6.77,1.73,6.77,1.73s.55,3,.84,4.82C840.81,728.91,840.88,729.44,840.88,729.64Z"
                        transform="translate(-52 -162.63)" fill="#ff6f61" />
                    <path
                        d="M840.88,729.64c0,.79-1.57,2.75-1.57,2.75a19.46,19.46,0,0,1-9.43-1.18c-.79-.39.39-2.75.39-2.75l.09-.19a19,19,0,0,0,8.56,1.76l1.79-1.79C840.81,728.91,840.88,729.44,840.88,729.64Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <circle cx="758.03" cy="419.83" r="8.84" fill="#be6f72" />
                    <path
                        d="M802.9,600.14c-1.94,1.85-2.26,4.78-2.46,7.45l-.3,3.91a19.72,19.72,0,0,0-.07,3.17c0,.65.16,1.31.22,2s.08,1.56.09,2.35l0,5.78a6.82,6.82,0,0,0,.64,3.47,2.36,2.36,0,0,0,3,1.08,3.42,3.42,0,0,0,1.24-1.92,29.85,29.85,0,0,0,2-7.32c.08-.87.09-1.74.17-2.61s.23-1.78.36-2.66c.56-3.68.81-7.4,1.06-11.11.07-1.1,1.06-5.43-.38-5.91-.7-.23-2.15.49-2.82.73A7.94,7.94,0,0,0,802.9,600.14Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <path
                        d="M802.9,600.14c-1.94,1.85-2.26,4.78-2.46,7.45l-.3,3.91a19.72,19.72,0,0,0-.07,3.17c0,.65.16,1.31.22,2s.08,1.56.09,2.35l0,5.78a6.82,6.82,0,0,0,.64,3.47,2.36,2.36,0,0,0,3,1.08,3.42,3.42,0,0,0,1.24-1.92,29.85,29.85,0,0,0,2-7.32c.08-.87.09-1.74.17-2.61s.23-1.78.36-2.66c.56-3.68.81-7.4,1.06-11.11.07-1.1,1.06-5.43-.38-5.91-.7-.23-2.15.49-2.82.73A7.94,7.94,0,0,0,802.9,600.14Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M821.23,588.16s-6.68,5.11-10.61,6.29c0,0-2.33,2.66-2.73,3.3s-1.2,7.7-2,9.28-2.75,5.11,0,8.64c0,0,.78,3.54.39,4.72s-1.82,5.5-.52,5.7,5.24,2.94,8.77,2.16,16.71,3,16.71,3S833.42,611,835,607.42l-3.54-1.18s-9.82-5.89-3.93-14.93C827.52,591.31,822,590.13,821.23,588.16Z"
                        transform="translate(-52 -162.63)" fill="#ff6f61" />
                    <path
                        d="M796.84,611.83l8.12,5.75a.6.6,0,0,0,.71,0l2.2-1.65a.62.62,0,0,0,0-.94l-6.25-5.55a.6.6,0,0,0-.61-.12L797,610.76A.61.61,0,0,0,796.84,611.83Z"
                        transform="translate(-52 -162.63)" fill="#3f3d56" />
                    <path
                        d="M799.57,629.15a21.76,21.76,0,0,1-.85-6.13l-.12-2.77a8,8,0,0,1,.29-3.2,5.23,5.23,0,0,1,3.37-2.95,11.64,11.64,0,0,1,4.59-.33,1.18,1.18,0,0,1,.59.16,1.1,1.1,0,0,1,.32.54,3.62,3.62,0,0,1,.18,2.89,3,3,0,0,1-.92.95c-1.09.78-2.36,1.3-3.39,2.15a1.23,1.23,0,0,0-.46.58,1.35,1.35,0,0,0,0,.63,10.08,10.08,0,0,0,.52,1.61,1.59,1.59,0,0,0,.45.68c.19.16.44.22.64.37.43.35,1.33.81,1.28,1.36-.15,2-1.35,4.24-1.82,6.22C803.34,635.78,800.15,630.84,799.57,629.15Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <g opacity="0.1">
                        <path d="M812.2,628.25l-.22,0a6.73,6.73,0,0,0,2.57,0l.25,0A9,9,0,0,0,812.2,628.25Z"
                            transform="translate(-52 -162.63)" />
                        <path
                            d="M832.83,606.83c-1.41,3.17-3.49,20.34-3.86,23.75,1.38.36,2.29.62,2.29.62S833.42,611,835,607.42Z"
                            transform="translate(-52 -162.63)" />
                    </g>
                    <path
                        d="M828.42,601.61a3,3,0,0,0,1.29,1.95,17.31,17.31,0,0,1,2.29,2.32,16.43,16.43,0,0,1,2.27,4.55,55.75,55.75,0,0,1,1.89,6.22c-5,2.32-10.68,2.21-16,3.74a12.77,12.77,0,0,0-6,3.55,8.27,8.27,0,0,0-2.21,6.51.85.85,0,0,0,.12.39.84.84,0,0,0,.7.28,6,6,0,0,0,3.67-1.26,17.46,17.46,0,0,0,2.81-2.76,4.52,4.52,0,0,1,2-1.48c2.89-.88,6-.83,9-.88a113.42,113.42,0,0,0,13.41-1.06,1.08,1.08,0,0,0,1.2-1.2c.44-5.9-1.75-11.66-4-17.13q-1.35-3.29-2.78-6.55a19.4,19.4,0,0,0-3.4-5.82,6,6,0,0,0-2-1.48A8.46,8.46,0,0,0,830,591a19,19,0,0,0-4.39-.08,9.36,9.36,0,0,0-.42,2.27c.08,2.7,1.26,5.23,2.42,7.67C827.76,601.23,828.19,601.25,828.42,601.61Z"
                        transform="translate(-52 -162.63)" fill="#be6f72" />
                    <path d="M812.41,606.67a7.33,7.33,0,0,0-1,3.82,5.14,5.14,0,0,0,.25,1.56,5.06,5.06,0,0,0,3.19,3"
                        transform="translate(-52 -162.63)" fill="none" stroke="#000" stroke-miterlimit="10"
                        opacity="0.1" />
                    <path
                        d="M817.5,573.82a4.59,4.59,0,0,0-1.45.23c-1.31-2-4.39-3.38-8-3.38-4.78,0-8.65,2.47-8.65,5.51s3.87,5.5,8.65,5.5a12.17,12.17,0,0,0,5.19-1.1,4.71,4.71,0,1,0,4.24-6.76Z"
                        transform="translate(-52 -162.63)" fill="#3f3d56" />
                    <path
                        d="M817.89,582.07a4.7,4.7,0,0,1-4.24-2.67,12.17,12.17,0,0,1-5.19,1.1c-4.77,0-8.64-2.46-8.64-5.5a3.31,3.31,0,0,1,0-.55,3.73,3.73,0,0,0-.44,1.73c0,3,3.87,5.5,8.65,5.5a12.17,12.17,0,0,0,5.19-1.1,4.71,4.71,0,0,0,8.87-1.17A4.69,4.69,0,0,1,817.89,582.07Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M798.23,574a13.35,13.35,0,0,1,15-7.15,14.14,14.14,0,0,1,21.52,10.86c0-.39,0-.78,0-1.18a14.14,14.14,0,0,0-21.57-12,13.35,13.35,0,0,0-15,7.15,16.28,16.28,0,0,0-5.09,12.16c0,.4,0,.79,0,1.18A16,16,0,0,1,798.23,574Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M888.39,577c2.61-4.83-.35-10.76-3.76-15.07s-7.55-8.79-7.46-14.29c.12-7.89,8.5-12.55,15.2-16.74a73.9,73.9,0,0,0,13.64-11,19.93,19.93,0,0,0,4.2-5.61c1.38-3.09,1.34-6.6,1.26-10q-.44-16.9-1.67-33.76"
                        transform="translate(-52 -162.63)" fill="none" stroke="#3f3d56" stroke-miterlimit="10"
                        stroke-width="4" />
                    <path
                        d="M922.52,469.93a12.29,12.29,0,0,0-6.14-10.08l-2.76,5.45.08-6.6a12.08,12.08,0,0,0-4.05-.49,12.31,12.31,0,1,0,12.87,11.72Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M900.57,553.26a12.31,12.31,0,1,1,.59-9.92l-7.69,6.26,8.46-2A12.24,12.24,0,0,1,900.57,553.26Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M894.49,529.35a12.31,12.31,0,0,1-3.91-24.15l-.06,5.07,2.79-5.51h0a12.32,12.32,0,0,1,12.87,11.73,12.3,12.3,0,0,1-11.72,12.87Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M924.37,509.47a12.31,12.31,0,1,1,5.45-23l-2.18,6,4.48-4.3a12.24,12.24,0,0,1,4,8.5,11.88,11.88,0,0,1-.31,3.39A12.31,12.31,0,0,1,924.37,509.47Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M920.87,473.21c-2.84.32-5.61,1.2-8.46,1.38s-6-.51-7.79-2.73a38.2,38.2,0,0,1-2.27-4,8.85,8.85,0,0,0-3.1-2.92,12.31,12.31,0,1,0,23,8.17C921.79,473.13,921.33,473.16,920.87,473.21Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M924.37,509.47a12.32,12.32,0,0,1-11.71-17.56,9.11,9.11,0,0,1,2.48,2.47,39.47,39.47,0,0,0,2.44,4.07c1.91,2.26,5.19,3,8.16,2.86s5.84-1,8.8-1.25c.41,0,.83-.07,1.24-.08A12.31,12.31,0,0,1,924.37,509.47Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M894.49,529.35A12.3,12.3,0,0,1,882.68,512a10.15,10.15,0,0,1,2.6,2.5c1,1.35,1.55,2.91,2.67,4.15,2.08,2.32,5.57,3.13,8.72,3.06s6-.82,9-1.05A12.31,12.31,0,0,1,894.49,529.35Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M900.57,553.26a12.32,12.32,0,0,1-22.45-10,12.06,12.06,0,0,1,2.7,2.41c1.18,1.43,1.95,3,3.3,4.38,2.52,2.47,6.58,3.48,10.2,3.58A53.94,53.94,0,0,0,900.57,553.26Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M1047.39,729c2.61-4.83-.35-10.76-3.76-15.07s-7.55-8.79-7.46-14.29c.12-7.89,8.5-12.55,15.2-16.74a73.9,73.9,0,0,0,13.64-11,19.93,19.93,0,0,0,4.2-5.61c1.38-3.09,1.34-6.6,1.26-10q-.43-16.9-1.67-33.76"
                        transform="translate(-52 -162.63)" fill="none" stroke="#3f3d56" stroke-miterlimit="10"
                        stroke-width="4" />
                    <path
                        d="M1081.52,621.93a12.29,12.29,0,0,0-6.14-10.08l-2.76,5.45.08-6.6a12.08,12.08,0,0,0-4-.49,12.31,12.31,0,1,0,12.87,11.72Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M1059.57,705.26a12.31,12.31,0,1,1,.59-9.92l-7.69,6.26,8.46-2A12.24,12.24,0,0,1,1059.57,705.26Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M1053.49,681.35a12.31,12.31,0,0,1-3.91-24.15l-.06,5.07,2.79-5.51h0a12.32,12.32,0,0,1,12.87,11.73,12.3,12.3,0,0,1-11.72,12.87Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M1083.37,661.47a12.31,12.31,0,1,1,5.45-23l-2.18,6,4.48-4.3a12.24,12.24,0,0,1,4,8.5,11.88,11.88,0,0,1-.31,3.39A12.31,12.31,0,0,1,1083.37,661.47Z"
                        transform="translate(-52 -162.63)" fill="<?=$theme_color?>" />
                    <path
                        d="M1079.87,625.21c-2.84.32-5.61,1.2-8.46,1.38s-6-.51-7.79-2.73a38.2,38.2,0,0,1-2.27-4,8.85,8.85,0,0,0-3.1-2.92,12.31,12.31,0,1,0,23,8.17C1080.79,625.13,1080.33,625.16,1079.87,625.21Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M1083.37,661.47a12.32,12.32,0,0,1-11.71-17.56,9.11,9.11,0,0,1,2.48,2.47,39.47,39.47,0,0,0,2.44,4.07c1.91,2.26,5.19,3,8.16,2.86s5.84-1,8.8-1.25c.41,0,.83-.07,1.24-.08A12.31,12.31,0,0,1,1083.37,661.47Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M1053.49,681.35A12.3,12.3,0,0,1,1041.68,664a10.15,10.15,0,0,1,2.6,2.5c1,1.35,1.55,2.91,2.67,4.15,2.08,2.32,5.57,3.13,8.72,3.06s6-.82,9-1.05A12.31,12.31,0,0,1,1053.49,681.35Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M1059.57,705.26a12.32,12.32,0,0,1-22.45-10,12.06,12.06,0,0,1,2.7,2.41c1.18,1.43,2,3,3.3,4.38,2.52,2.47,6.58,3.48,10.2,3.58A53.94,53.94,0,0,0,1059.57,705.26Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M530,587.91a9.81,9.81,0,0,0-3.91-7.92,11.5,11.5,0,0,0-9.61-11.28,11.48,11.48,0,0,0-7.65-8.55h0a9.76,9.76,0,0,0-1.42-.33l-.14,0-.25,0-.2,0-.22,0-.27,0h-.61a11.26,11.26,0,0,0-10.88,9.62c-3.51-.81-6.72.24-7.31,2.46a3,3,0,0,0,.1,1.78c.6,1.72,2.55,3.37,5.16,4.18l.34.1.51.13.11,0h0a8.84,8.84,0,0,0-.84,3.79,8.74,8.74,0,0,0,4.71,7.8l-.23.14a3.12,3.12,0,0,0-.76,1.06,15.86,15.86,0,0,0-1.47,3.54c-.25,1.06-.29,2.16-.6,3.21-.58,1.93-2.06,3.56-2.23,5.57-.08.9.07,2-.57,2.58a3.11,3.11,0,0,1-.51.36,4.13,4.13,0,0,0-1.11,1.17,3.88,3.88,0,0,1-.78,1.12c-.58.43-1.53.39-1.81,1.06s.45,1.46.28,2.19-.79.87-1.24,1.28a4.45,4.45,0,0,0-1.07,2,6.56,6.56,0,0,1-5.4-1.38,10.09,10.09,0,0,1,.56,2,8.76,8.76,0,0,0-2.91-1.46,9.19,9.19,0,0,1-3.1-2.3l1.66-.23L469,600.41l-2.17-.45,1.94,3.73a1.19,1.19,0,0,0-.66.79,3.39,3.39,0,0,0-.07,1.27,22.73,22.73,0,0,0,.5,3l.56,2.62c.05.24.11.49.18.73a6.89,6.89,0,0,0-2.17.24,18.88,18.88,0,0,0-4.51-1.07,2.5,2.5,0,0,0-1,0,2.59,2.59,0,0,0-.95.77,30.76,30.76,0,0,0-3.35,4.72c-4,6.86-9.21,12.85-14.14,19.05-3.4,1.38-6.83,2.69-10.26,4l-7.38,2.82a11.19,11.19,0,0,1-4.58,1c-.7,0-1.57-.15-2,.45a4.21,4.21,0,0,0-.45,1l-.76.08h0a8.74,8.74,0,0,0-1.77-3.26,1.12,1.12,0,0,0-.83.64c-.18.33-.29.69-.5,1-.39.58-1.08.86-1.57,1.35s-.8,1.25-1.34,1.75a5.3,5.3,0,0,1-2.51,1,15.84,15.84,0,0,0-3.93,1.49,6.33,6.33,0,0,1-1.45.67,5.45,5.45,0,0,1-1.71.06l-3.9-.29a3.08,3.08,0,0,0-1.05.05,2,2,0,0,0-1.24,2,3.15,3.15,0,0,0,1.24,2.15,7.94,7.94,0,0,0,2.22,1.15A65.15,65.15,0,0,0,409.79,658v.79a17.75,17.75,0,0,0,8,1.9,1.24,1.24,0,0,0,.6-.11,1.32,1.32,0,0,0,.5-.78,32.17,32.17,0,0,0,1.56-7.66h0a4,4,0,0,0,1.41-.36c1.34-.37,2.68.55,4.07.7,1.71.19,3.29-.81,4.91-1.42l.7-.23a7.68,7.68,0,0,1-1.62,1.55c-.67.48-1.42.84-2.07,1.34a14.26,14.26,0,0,1-1.76,1.36,11.05,11.05,0,0,1-1.35.52,8.91,8.91,0,0,0-1.93,1,3.91,3.91,0,0,0-1.31,1.28,1.92,1.92,0,0,0-.11,1.8,1.9,1.9,0,0,0,1.29.9,5.29,5.29,0,0,0,1.59,0c2.12-.16,4.23-.35,6.34-.54a16.92,16.92,0,0,0,2.65-.38c.46-.11.92-.26,1.38-.39a12.31,12.31,0,0,1,2.41-.36,2,2,0,0,1,.7.07c.49.16.84.66,1.34.76a2,2,0,0,0,1-.13,22.3,22.3,0,0,1,4.69-.5c.69,0,1.5-.17,1.82-.81s-.26-1.67-.52-2.52a7.71,7.71,0,0,1-.22-1.66,10.39,10.39,0,0,0-1.16-3.94,10.29,10.29,0,0,1-.87-1.8,45.47,45.47,0,0,0,8.63-4.38,15.43,15.43,0,0,1,4.92-2.37,13.38,13.38,0,0,1,6.18.72,140.61,140.61,0,0,1,14.17,4.94c2.21.91,4.41,1.87,6.69,2.56a10.43,10.43,0,0,0,2.38,2.31,11,11,0,0,0,5.15,1.41,67.48,67.48,0,0,0,7.25.27,12.23,12.23,0,0,0,5.4-1,5.55,5.55,0,0,0,1.13-.75,4.48,4.48,0,0,0,3.56-1.31A8.63,8.63,0,0,0,512,646.5c.59-2.28.14-5,1.54-6.82.37-.5.86-.9,1.23-1.4a3.94,3.94,0,0,0,.64-2.31.47.47,0,0,1,.06-.09,8.47,8.47,0,0,0,.6-2.3,13.14,13.14,0,0,1,.65-1.82,56.19,56.19,0,0,0,1.86-5.39,31.49,31.49,0,0,0,.86-3.7c.15-1,.24-2,.32-3a18.63,18.63,0,0,1,.91-4.63,37.68,37.68,0,0,0,2.1-11.08v-.22a7.43,7.43,0,0,0,6.58-7.56,7.89,7.89,0,0,0-.69-3.23A10,10,0,0,0,530,587.91Zm-35.78,43.47c.11.39.24.77.37,1.15-.59-.57-1.16-1.16-1.75-1.74.23.08.47.15.69.24A3.73,3.73,0,0,1,494.19,631.38Zm-2.83-1.92c-3.46-3-7.46-5.33-11-8.24,1.93.95,3.81,2.06,5.67,3.12q3.31,1.89,6.71,3.63A5.49,5.49,0,0,1,491.36,629.46Zm1.47-7.56.17-.17c0,.43,0,.82,0,1.19l-.93-.32A8.28,8.28,0,0,0,492.83,621.9ZM462.43,630a28.63,28.63,0,0,0,3.68-5.25c1.37,2.39,3.6,4.12,5.49,6.13C468.55,630.49,465.49,630.16,462.43,630Z"
                        transform="translate(-52 -162.63)" fill="url(#a964f849-fa65-4178-8cc4-fb8fb10b3617)" />
                    <polygon points="415.35 438.25 417.53 438.69 424.96 449.68 421.69 450.12 415.35 438.25"
                        fill="#2f2e41" />
                    <path
                        d="M414.49,645.46a42.78,42.78,0,0,0,2.18,5.67,54,54,0,0,0,7.25-2.07,22.86,22.86,0,0,0-1.51-2,7.46,7.46,0,0,0-2.05-1.57,5.64,5.64,0,0,0-2.49,0C416.75,645.46,415.62,645.48,414.49,645.46Z"
                        transform="translate(-52 -162.63)" fill="#fbbebe" />
                    <path
                        d="M420.37,648.39a4.52,4.52,0,0,1-2.48-2.82A9.08,9.08,0,0,0,416,642.2a1.08,1.08,0,0,0-.84.63c-.18.32-.29.68-.49,1-.4.57-1.1.85-1.6,1.33s-.8,1.23-1.34,1.72a5.32,5.32,0,0,1-2.53,1,16.41,16.41,0,0,0-4,1.47,6.9,6.9,0,0,1-1.47.66,5.82,5.82,0,0,1-1.72,0l-3.94-.28a3.08,3.08,0,0,0-1,0,1.91,1.91,0,0,0-1.25,2,3,3,0,0,0,1.25,2.12,8.3,8.3,0,0,0,2.24,1.14,65.9,65.9,0,0,0,10.56,3v.78a18.28,18.28,0,0,0,8.05,1.87,1.36,1.36,0,0,0,.6-.1,1.32,1.32,0,0,0,.5-.78,31.2,31.2,0,0,0,1.65-8.56,6.82,6.82,0,0,0-.17-2.21c-.22-.71.52-.41-.16-.69"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M495.93,633.54c-11.68.7-23.22-2.72-34.92-3.08a17.05,17.05,0,0,0-4.34.27,21.87,21.87,0,0,0-4.3,1.67c-6.27,2.92-12.76,5.34-19.24,7.75l-7.45,2.77a11.28,11.28,0,0,1-4.61,1c-.71,0-1.58-.15-2,.44-1.21,1.8-.64,4.43.16,6.45.26.65.7,1.36,1.4,1.43a4.07,4.07,0,0,0,1.42-.36c1.35-.36,2.7.55,4.1.7,1.72.18,3.32-.8,4.95-1.4,2.7-1,5.64-1,8.48-1.44,4.75-.79,9.16-3,13.28-5.51a15.5,15.5,0,0,1,4.95-2.34,13.7,13.7,0,0,1,6.23.71,143,143,0,0,1,14.29,4.86,66.61,66.61,0,0,0,7.46,2.73,27,27,0,0,0,16.73-1c1.87-.74,3.9-2,4-4.06.07-1.15-.83-2.16-1.42-3.15-.38-.63-.77-1.26-1.18-1.87C501.92,637.21,499.48,633.33,495.93,633.54Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M495.93,633.54c-11.68.7-23.22-2.72-34.92-3.08a17.05,17.05,0,0,0-4.34.27,21.87,21.87,0,0,0-4.3,1.67c-6.27,2.92-12.76,5.34-19.24,7.75l-7.45,2.77a11.28,11.28,0,0,1-4.61,1c-.71,0-1.58-.15-2,.44-1.21,1.8-.64,4.43.16,6.45.26.65.7,1.36,1.4,1.43a4.07,4.07,0,0,0,1.42-.36c1.35-.36,2.7.55,4.1.7,1.72.18,3.32-.8,4.95-1.4,2.7-1,5.64-1,8.48-1.44,4.75-.79,9.16-3,13.28-5.51a15.5,15.5,0,0,1,4.95-2.34,13.7,13.7,0,0,1,6.23.71,143,143,0,0,1,14.29,4.86,66.61,66.61,0,0,0,7.46,2.73,27,27,0,0,0,16.73-1c1.87-.74,3.9-2,4-4.06.07-1.15-.83-2.16-1.42-3.15-.38-.63-.77-1.26-1.18-1.87C501.92,637.21,499.48,633.33,495.93,633.54Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M436.92,646q2.74.93,5.53,1.72c1-1.71,3-2.9,3.43-4.86a.46.46,0,0,0,0-.26.48.48,0,0,0-.21-.19,10.48,10.48,0,0,0-4.34-1.27c-1.2-.07-1.75,1.18-2.29,2.06C438.83,643.59,437.41,646.19,436.92,646Z"
                        transform="translate(-52 -162.63)" fill="#fbbebe" />
                    <path
                        d="M439.48,644.78a4,4,0,0,1-2.69-1.77c-.25-.45-.53-1.06-1.05-1s-.69.6-.8,1.07a30,30,0,0,1-1.51,5.19,9.74,9.74,0,0,1-3.23,4.25c-.68.47-1.43.82-2.1,1.32a14.43,14.43,0,0,1-1.77,1.34,10.51,10.51,0,0,1-1.36.5,9.43,9.43,0,0,0-1.94,1,3.85,3.85,0,0,0-1.33,1.27,1.83,1.83,0,0,0-.1,1.77,1.89,1.89,0,0,0,1.29.88,5.44,5.44,0,0,0,1.61,0c2.13-.15,4.26-.34,6.39-.53a18.44,18.44,0,0,0,2.67-.37l1.39-.38a11.06,11.06,0,0,1,2.43-.36,1.89,1.89,0,0,1,.71.07c.49.16.84.65,1.35.75a2.26,2.26,0,0,0,1-.13,22.08,22.08,0,0,1,4.73-.49c.7,0,1.52-.18,1.84-.8.4-.78-.26-1.65-.53-2.49a8,8,0,0,1-.22-1.63,9.94,9.94,0,0,0-1.17-3.88c-.54-1-1.28-2.1-.9-3.16a3,3,0,0,0,.36-1.09C444.4,644.39,440.46,645,439.48,644.78Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M478.42,614.8a9.12,9.12,0,0,1-4.66-4.62c-.19-.44-.35-.91-.54-1.35a10.26,10.26,0,0,0-2.78-3.87,1.37,1.37,0,0,0-1-.43,1.09,1.09,0,0,0-.75.81,3.09,3.09,0,0,0-.08,1.25,22.27,22.27,0,0,0,.5,2.92l.57,2.58a5.66,5.66,0,0,0,.35,1.15,4,4,0,0,0,.95,1.13c.52.48,1.05.94,1.58,1.4a5.43,5.43,0,0,0,1,.69,5.81,5.81,0,0,0,1.77.52,15.06,15.06,0,0,1,6.64,2.56s0-1.73,0-1.92a2.54,2.54,0,0,0-.5-1.39A8.87,8.87,0,0,0,478.42,614.8Z"
                        transform="translate(-52 -162.63)" fill="#fbbebe" />
                    <path
                        d="M478.42,614.8a9.12,9.12,0,0,1-4.66-4.62c-.19-.44-.35-.91-.54-1.35a10.26,10.26,0,0,0-2.78-3.87,1.37,1.37,0,0,0-1-.43,1.09,1.09,0,0,0-.75.81,3.09,3.09,0,0,0-.08,1.25,22.27,22.27,0,0,0,.5,2.92l.57,2.58a5.66,5.66,0,0,0,.35,1.15,4,4,0,0,0,.95,1.13c.52.48,1.05.94,1.58,1.4a5.43,5.43,0,0,0,1,.69,5.81,5.81,0,0,0,1.77.52,15.06,15.06,0,0,1,6.64,2.56s0-1.73,0-1.92a2.54,2.54,0,0,0-.5-1.39A8.87,8.87,0,0,0,478.42,614.8Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <ellipse cx="450.2" cy="429.57" rx="2.84" ry="2.86" fill="#2f2e41" />
                    <path
                        d="M500.44,590.48a3.07,3.07,0,0,0-2.24.32,3.11,3.11,0,0,0-.77,1.05,15.25,15.25,0,0,0-1.48,3.48c-.25,1-.29,2.13-.61,3.16-.58,1.9-2.07,3.51-2.24,5.49-.08.89.07,1.93-.58,2.53a3.68,3.68,0,0,1-.51.37,3.84,3.84,0,0,0-1.12,1.15,3.77,3.77,0,0,1-.79,1.09c-.58.43-1.54.39-1.82,1s.45,1.44.28,2.16-.8.86-1.25,1.26a4.37,4.37,0,0,0-1.08,2,6.67,6.67,0,0,1-5.44-1.35,17.32,17.32,0,0,1,.85,6.22,2.54,2.54,0,0,1-.5,1.92,34.64,34.64,0,0,1,6.67,1.16,4.6,4.6,0,0,0,2.91,0,4.86,4.86,0,0,0,1.34-1.06c1.2-1.22,2.46-2.55,2.75-4.24a24.91,24.91,0,0,0,.05-2.87,16.18,16.18,0,0,1,.73-3.49,41.53,41.53,0,0,0,1.27-7.18c.13-1.5,1.43-2.7,2.11-4,1.28-2.53,2.6-5.16,2.69-8C501.7,591.73,501.38,590.58,500.44,590.48Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M500.44,590.48a3.07,3.07,0,0,0-2.24.32,3.11,3.11,0,0,0-.77,1.05,15.25,15.25,0,0,0-1.48,3.48c-.25,1-.29,2.13-.61,3.16-.58,1.9-2.07,3.51-2.24,5.49-.08.89.07,1.93-.58,2.53a3.68,3.68,0,0,1-.51.37,3.84,3.84,0,0,0-1.12,1.15,3.77,3.77,0,0,1-.79,1.09c-.58.43-1.54.39-1.82,1s.45,1.44.28,2.16-.8.86-1.25,1.26a4.37,4.37,0,0,0-1.08,2,6.67,6.67,0,0,1-5.44-1.35,17.32,17.32,0,0,1,.85,6.22,2.54,2.54,0,0,1-.5,1.92,34.64,34.64,0,0,1,6.67,1.16,4.6,4.6,0,0,0,2.91,0,4.86,4.86,0,0,0,1.34-1.06c1.2-1.22,2.46-2.55,2.75-4.24a24.91,24.91,0,0,0,.05-2.87,16.18,16.18,0,0,1,.73-3.49,41.53,41.53,0,0,0,1.27-7.18c.13-1.5,1.43-2.7,2.11-4,1.28-2.53,2.6-5.16,2.69-8C501.7,591.73,501.38,590.58,500.44,590.48Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M497.78,636c-2.43-1.16-4.21-3.31-6.18-5.16-3.75-3.53-8.34-6-12.29-9.33-2.62-2.19-5-4.74-7.83-6.58a19.57,19.57,0,0,0-8.39-2.93,2.23,2.23,0,0,0-1,0,2.3,2.3,0,0,0-.95.75,30.22,30.22,0,0,0-3.39,4.65c-5,8.5-12.11,15.64-18,23.54a1.5,1.5,0,0,0-.29.56,1.39,1.39,0,0,0,.22.87l1.2,2.34c.67,1.32,1.75,2.85,3.19,2.59a3.49,3.49,0,0,0,1.67-1.07l5.38-5.15,5.64-5.39c3.3-3.15,6.66-6.38,8.82-10.42,1.68,2.92,4.67,4.83,6.71,7.5.78,1,1.42,2.13,2.12,3.21,1.11,1.72,2.38,3.34,3.64,5l6.47,8.25a12.38,12.38,0,0,0,3,3,11.45,11.45,0,0,0,5.19,1.39,68.59,68.59,0,0,0,7.31.26,12.6,12.6,0,0,0,5.45-1,4.94,4.94,0,0,0,2.95-4.39,6.44,6.44,0,0,0-.93-2.73C505.15,641.59,502.13,638.07,497.78,636Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <ellipse cx="451.95" cy="431.55" rx="2.19" ry="2.2" fill="#e8e8f0" />
                    <path
                        d="M503.47,592.53a4.21,4.21,0,0,1,.24,3.16,12.82,12.82,0,0,1-1.41,2.91,13.85,13.85,0,0,1-1.83,2.6c3.38.16,6.65-1.16,9.62-2.76,2.4-1.29,4.79-2.88,6.07-5.29a2.8,2.8,0,0,1-2.24-.42,8,8,0,0,1-1.71-1.59l-1.69-1.9a7.61,7.61,0,0,1-1-1.37,3.78,3.78,0,0,1-.45-2.21,12.87,12.87,0,0,1-2.24,1.86c-1.21.79-2.54,1.36-3.76,2.14-.42.28-1.38.72-1.13,1.28S503.13,591.93,503.47,592.53Z"
                        transform="translate(-52 -162.63)" fill="#fbbebe" />
                    <path
                        d="M503.47,592.53a4.21,4.21,0,0,1,.24,3.16,12.82,12.82,0,0,1-1.41,2.91,13.85,13.85,0,0,1-1.83,2.6c3.38.16,6.65-1.16,9.62-2.76,2.4-1.29,4.79-2.88,6.07-5.29a2.8,2.8,0,0,1-2.24-.42,8,8,0,0,1-1.71-1.59l-1.69-1.9a7.61,7.61,0,0,1-1-1.37,3.78,3.78,0,0,1-.45-2.21,12.87,12.87,0,0,1-2.24,1.86c-1.21.79-2.54,1.36-3.76,2.14-.42.28-1.38.72-1.13,1.28S503.13,591.93,503.47,592.53Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M503.51,592.86a2.85,2.85,0,0,0,0,3.3c.1.12.46.87.61.88a.55.55,0,0,0,.38-.2,25.1,25.1,0,0,0,2.14-2.55,4.76,4.76,0,0,1,2.72-1.78,5.88,5.88,0,0,1,3.75,1.17,3.56,3.56,0,0,1,1.29,1,3.49,3.49,0,0,1,.42,1.43,68.9,68.9,0,0,1,.38,9.09,35.82,35.82,0,0,1-.43,6.55c-.22,1.11-.54,2.2-.69,3.33a21.24,21.24,0,0,0-.14,3v4.18a11,11,0,0,0,.16,2.29c.2.91.63,1.76.92,2.65a17.33,17.33,0,0,1,.61,3.13l.57,4.32c.18,1.36.32,2.85-.51,4-.37.49-.86.89-1.24,1.38-1.41,1.84-1,4.47-1.55,6.72a8.38,8.38,0,0,1-2.74,4.2,4.53,4.53,0,0,1-3.61,1.29c-1.76-.33-2.81-2.16-3.29-3.89s-.65-3.61-1.69-5.07a13.45,13.45,0,0,0-3.34-2.79,5.77,5.77,0,0,1-2.61-3.39c-.11-.63,0-1.28-.11-1.92a4.53,4.53,0,0,0-2.79-3.67c-.9-.35-2-.48-2.52-1.3a6.07,6.07,0,0,0,2.63-3.53,18.13,18.13,0,0,0,.64-4.46l.3-5c.14-2.25.2-4.47,1.19-6.49.44-.9,1-1.75,1.45-2.64a28.66,28.66,0,0,0,1.55-3.87c.72-2.06,1.44-4.12,2.08-6.2a11.68,11.68,0,0,1,1.14-2.89C501.72,594.19,502.5,593.06,503.51,592.86Z"
                        transform="translate(-52 -162.63)" fill="#e8e8f0" />
                    <path
                        d="M492.36,625.5l1.33,0,.28-2a4.17,4.17,0,0,1,.28-1.17,7,7,0,0,1,.77-1.12c1.3-1.85,1.21-4.3,1.53-6.55a33.33,33.33,0,0,1,2.92-8.56l2.58-5.75a7.94,7.94,0,0,0,.56-1.47,8.82,8.82,0,0,0,.16-1.7c0-.89.28-4.13.31-5,0-.33-.73-.15-.88-.44-.32-.64-.76,1.09-1.37,1.47a3.36,3.36,0,0,0-1.19,1.74c-.56,1.44-.9,3-1.42,4.43a9.05,9.05,0,0,1-2.41,3.92c-.53.46-1.14.83-1.64,1.33-1.6,1.58-1.76,4.09-1.81,6.35C492.32,612.36,492.06,625.5,492.36,625.5Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M511.5,590.47a4.54,4.54,0,0,0-2.37,3.25,16.44,16.44,0,0,1-1.2,4c-1.62,2.82-5.75,3.64-6.9,6.69a12.3,12.3,0,0,0-.46,3.15c-.2,2.19-.92,4.3-1.14,6.48a28.87,28.87,0,0,0,.12,5.09L501,636.35a23,23,0,0,1-.43,7.58,7.3,7.3,0,0,0,4.34-.72c1.35-.62,2.59-1.47,3.9-2.19,2.24-1.24,4.72-2.11,6.69-3.76a4.09,4.09,0,0,0,.9-1A8.65,8.65,0,0,0,517,634a12.2,12.2,0,0,1,.65-1.78,52.45,52.45,0,0,0,1.88-5.32,30.53,30.53,0,0,0,.86-3.64c.16-1,.25-2,.33-3a17.6,17.6,0,0,1,.92-4.55,36.65,36.65,0,0,0,2.11-10.92,5.71,5.71,0,0,0-.11-1.6,8.56,8.56,0,0,0-.88-1.83c-.6-1.13-1-2.37-1.52-3.52a17.31,17.31,0,0,0-5.91-6.21C514.17,590.84,512.81,590,511.5,590.47Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M481.29,618.57a10.43,10.43,0,0,1-2.75-2.09c-.36-.42-.66-.89-1-1.31a6.81,6.81,0,0,0-3.46-2,16.9,16.9,0,0,0-4-.39,7.26,7.26,0,0,0-2.67.32,2.72,2.72,0,0,0-1.77,1.9,3.15,3.15,0,0,0,1.35,2.8,6.36,6.36,0,0,0,2.69,1.3,21.5,21.5,0,0,0,2.43.29c4.78.5,9.05,3.1,13.24,5.47q5.52,3.14,11.26,5.84a23.4,23.4,0,0,0,.19-3.45c0-.86-.07-2.18-.88-2.69a17.66,17.66,0,0,0-3.58-1.07,56.34,56.34,0,0,1-7.21-2.92C483.81,620,482.54,619.3,481.29,618.57Z"
                        transform="translate(-52 -162.63)" fill="#fbbebe" />
                    <ellipse cx="450.2" cy="420.35" rx="8.52" ry="8.57" fill="#fbbebe" />
                    <path
                        d="M513.93,600.18a13.66,13.66,0,0,0-1.65,3.09c-1,2.16-2.7,4-3.53,6.29s-.84,5.23-2.55,7.1a2.49,2.49,0,0,0-.75,1.08,5.16,5.16,0,0,1-.08.78c-.25.68-1.36.71-1.57,1.41-.06.2,0,.42-.1.62-.17.45-.77.52-1.16.79-.83.56-.66,1.86-1.25,2.67a2.25,2.25,0,0,1-2.13.75,7.5,7.5,0,0,1-2.21-.83,2.13,2.13,0,0,0-.8-.25,1.65,1.65,0,0,0-.92.32,5.67,5.67,0,0,0-2.3,4.85,15.84,15.84,0,0,0,1.32,5.43,2.18,2.18,0,0,0,.43.81,1.91,1.91,0,0,0,2.12.16,10,10,0,0,1,2.07-.93c1.32-.24,2.61.67,3.95.59a5.49,5.49,0,0,0,2.66-1.17,14.7,14.7,0,0,0,3.58-3c.58-.77,1-1.64,1.52-2.46a31.54,31.54,0,0,1,2.15-2.87l4.92-6a13.83,13.83,0,0,0,1.32-1.82,12.83,12.83,0,0,0,1-2.75,21.07,21.07,0,0,0,1-4.89,18.79,18.79,0,0,0-.36-4.1,14.49,14.49,0,0,0-1-3.91C518.54,599.68,515.94,597.84,513.93,600.18Z"
                        transform="translate(-52 -162.63)" fill="#2f2e41" />
                    <path
                        d="M531.05,589a9.6,9.6,0,0,0-3.94-7.8,11.41,11.41,0,0,0-9.69-11.11,11.07,11.07,0,0,0-21.81.59c-3.54-.8-6.78.24-7.37,2.42s1.91,5,5.64,6a10.51,10.51,0,0,0,3.62.36,11.08,11.08,0,0,0,7.62,4.75,11.37,11.37,0,0,0,8.32,8.58,9.55,9.55,0,0,0,2.57,3.55c0,.27,0,.55,0,.83a7.21,7.21,0,1,0,14.42,0,7.7,7.7,0,0,0-.69-3.19A9.64,9.64,0,0,0,531.05,589Z"
                        transform="translate(-52 -162.63)" fill="#f86d70" />
                    <path
                        d="M490.64,573.56c.59-2.18,3.83-3.22,7.37-2.42a11.26,11.26,0,0,1,11-9.48l.73,0a10.84,10.84,0,0,0-3.14-.47,11.26,11.26,0,0,0-11,9.48c-3.54-.8-6.78.24-7.37,2.42s1.91,5,5.64,6a11,11,0,0,0,2.14.37C492.44,578.39,490.05,575.79,490.64,573.56Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <path
                        d="M518.37,597.59a7.52,7.52,0,0,1,0-.82,9.34,9.34,0,0,1-2.57-3.55,11.34,11.34,0,0,1-8.32-8.59,11.05,11.05,0,0,1-7.63-4.74,9.6,9.6,0,0,1-2.13-.06,11.11,11.11,0,0,0,7.35,4.37,11.37,11.37,0,0,0,8.32,8.58,9.55,9.55,0,0,0,2.57,3.55c0,.27,0,.55,0,.83a7.34,7.34,0,0,0,7.17,7.46A7.46,7.46,0,0,1,518.37,597.59Z"
                        transform="translate(-52 -162.63)" opacity="0.1" />
                    <ellipse cx="505.04" cy="584.74" rx="1.31" ry="1.75"
                        transform="translate(-302.82 261.95) rotate(-37.22)" fill="#fbbebe" />
                </svg>
            </div>
        </div>
        <div>
            <form id="front_contact_form" method="POST" action="<?=base_url('front/send-mail')?>">
                <div>
                    <span class="text-sm font-bold text-gray-600 uppercase"><?=$this->lang->line('name')?htmlspecialchars($this->lang->line('name')):'Name'?></span>
                    <input name="name" class="w-full p-3 mt-2 text-gray-900 bg-gray-300 rounded-lg focus:outline-none focus:shadow-outline"
                        type="text">
                </div>
                <div class="mt-8">
                    <span class="text-sm font-bold text-gray-600 uppercase"><?=$this->lang->line('email')?htmlspecialchars($this->lang->line('email')):'Email'?></span>
                    <input name="email" class="w-full p-3 mt-2 text-gray-900 bg-gray-300 rounded-lg focus:outline-none focus:shadow-outline"
                        type="text">
                </div>
                <div class="mt-8">
                    <span class="text-sm font-bold text-gray-600 uppercase"><?=$this->lang->line('type_your_message')?$this->lang->line('type_your_message'):'Type your message'?></span>
                    <textarea name="msg" class="w-full h-32 p-3 mt-2 text-gray-900 bg-gray-300 rounded-lg focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mt-8">
                    <button class="savebtn w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-indigo-500 rounded-lg focus:outline-none focus:shadow-outline">
                    <?=$this->lang->line('send_message')?htmlspecialchars($this->lang->line('send_message')):'Send Message'?>
                    </button>

                    <div class="w-full px-4 py-2 mt-1 text-left font-semibold text-white bg-red-500 rounded shadow-sm hidden result"></div>
                    
                </div>
                
            </form>
        </div>
    </div>
    <?php } ?>


    <footer class="px-4 pt-12 pb-8 text-white bg-white border-t border-gray-200">
        <div class="container flex flex-col justify-between max-w-6xl px-4 mx-auto overflow-hidden lg:flex-row">
            <div class="w-full pl-10 mt-6 text-sm lg:w-3/3 sm:flex lg:mt-0">
                <ul class="flex flex-col w-full p-0 font-medium text-left text-gray-700 list-none">
                    <li class="inline-block px-3 py-2 mt-5 font-bold tracking-wide text-gray-800 uppercase md:mt-0">
                    <?=$this->lang->line('account')?htmlspecialchars($this->lang->line('account')):'Account'?></li>
                    <li><a href="<?=base_url('auth')?>" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('login')?htmlspecialchars($this->lang->line('login')):'Login'?></a>
                    </li>
                    <li><a href="<?=base_url('auth/register')?>" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('register')?htmlspecialchars($this->lang->line('register')):'Register'?></a>
                    </li>
                </ul>
                <?php if(frontend_permissions('about') || frontend_permissions('privacy') || frontend_permissions('terms')){ ?>
                <ul class="flex flex-col w-full p-0 font-medium text-left text-gray-700 list-none">
                    <li class="inline-block px-3 py-2 mt-5 font-bold tracking-wide text-gray-800 uppercase md:mt-0">
                    <?=$this->lang->line('useful_links')?htmlspecialchars($this->lang->line('useful_links')):'Useful Links'?></li>
                    <?php if(frontend_permissions('about')){ ?>
                    <li><a href="<?=base_url('front/about-us')?>" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('about')?$this->lang->line('about'):'About Us'?></a>
                    </li>
                    <?php } ?>

                    <?php if(frontend_permissions('privacy')){ ?>
                    <li><a href="<?=base_url('front/privacy-policy')?>" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('privacy_policy')?$this->lang->line('privacy_policy'):'Privacy Policy'?></a>
                    </li>
                    <?php } ?>

                    <?php if(frontend_permissions('terms')){ ?>
                    <li><a href="<?=base_url('front/terms-and-conditions')?>" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('terms_and_conditions')?$this->lang->line('terms_and_conditions'):'Terms and Conditions'?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>

                <?php if(frontend_permissions('features') || frontend_permissions('subscription_plans') || frontend_permissions('contact')){ ?>
                <ul class="flex flex-col w-full p-0 font-medium text-left text-gray-700 list-none">
                    <li class="inline-block px-3 py-2 mt-5 font-bold tracking-wide text-gray-800 uppercase md:mt-0">
                        <?=$this->lang->line('getting_started')?htmlspecialchars($this->lang->line('getting_started')):'Getting Started'?>
                    </li>

                    <?php if(frontend_permissions('features') && $features){ ?>
                    <li><a href="#features" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('features')?htmlspecialchars($this->lang->line('features')):'Features'?></a></li>
                    <?php } ?>

                    <?php if(frontend_permissions('subscription_plans')){ ?>
                    <li><a href="#pricing" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('pricing')?htmlspecialchars($this->lang->line('pricing')):'Pricing'?></a></li>
                    <?php } ?>

                    <?php if(frontend_permissions('contact')){ ?>
                    <li><a href="#contact" class="inline-block px-3 py-2 text-gray-500 no-underline hover:text-gray-600"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></a></li>
                    <?php } ?>

                </ul>
                <?php } ?>
            </div>
        </div>
        <div class="pt-4 pt-6 mt-10 text-center text-gray-400 border-t border-gray-100"><a href="<?=base_url()?>" target="_blank"><?=htmlspecialchars(footer_text())?></a></div>
    </footer>

    <script src="<?=base_url('assets/modules/jquery.min.js')?>"></script>

    <script src="<?=base_url('assets/front/three/js/custom.js')?>"></script>

    <script>
    site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
    </script>

    <?php $recaptcha_site_key = get_google_recaptcha_site_key(); if($recaptcha_site_key){ ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?=htmlspecialchars($recaptcha_site_key)?>"></script>
    <?php } ?>

    
    <div id="cookie-bar">
        <div class="cookie-bar-body">
            <p><?=$this->lang->line('frontend_cookie_message')?htmlspecialchars($this->lang->line('frontend_cookie_message')):'We use cookies to ensure that we give you the best experience on our website.'?></p>
            <div class="cookie-bar-action">
                <button type="button" class="text-uppercase btn btn-primary text-white cookie-bar-btn"><?=$this->lang->line('i_agree')?$this->lang->line('i_agree'):'I Agree!'?></button>
            </div>
        </div>
    </div>

    <script src="<?=base_url('assets/front/comman.js')?>"></script>
    <script>
    function showDropdownOptions() {
        document.getElementById("options").classList.toggle("hidden");
        document.getElementById("arrow-up").classList.toggle("hidden");
        document.getElementById("arrow-down").classList.toggle("hidden");
    }
</script>

</body>
</html>