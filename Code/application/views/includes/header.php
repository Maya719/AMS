<?php
if($this->ion_auth->logged_in() && !$this->ion_auth->in_group(3)){
  $my_plan = get_current_plan();
  if ($my_plan && !is_null($my_plan['end_date']) && $my_plan['end_date'] < date('Y-m-d') && $my_plan['expired'] == 1)
  {
    $users_plans_data = array(
      'expired' => 0,			
    );
    $users_plans_id = $this->plans_model->update_users_plans($this->session->userdata('saas_id'), $users_plans_data);
  }
  if($my_plan && !is_null($my_plan['end_date']) && $my_plan['expired'] == 0 && base_url('plans') != current_url()){ 
    header('Location: '.base_url('plans'));
    exit();
  }
}
?>

<!DOCTYPE html>

<?php
$lang = $this->session->userdata('lang')?$this->session->userdata('lang'):default_language();
$my_current_lang = get_languages('', $lang);
if($my_current_lang){
  if(isset($my_current_lang[0]['active']) && $my_current_lang[0]['active'] == 1){
    $rtl = true;
    echo '<html lang="en" class="w-100 h-100" dir="rtl">';
  }else{
    $rtl = false;
    echo '<html lang="en" class="w-100 h-100">';
  }
}else{
  $rtl = false;
  echo '<html lang="en" class="w-100 h-100">';
}
?>


<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="google-adsense-account" content="ca-pub-8742754912115618">
  <?php
  if(!isset($page_title) && empty($page_title)){ 
    $page_title = company_name();
  }

  if(isset($meta_image) && !empty($meta_image)){ ?>
    <meta property="og:image" itemprop="image" content="<?=htmlspecialchars($meta_image)?>" />
  <?php }else{ ?>
    <meta property="og:image" itemprop="image" content="<?=base_url('assets/uploads/logos/'.full_logo())?>" />
  <?php } ?>
  
  <meta property="og:type" content="website" />
  <meta property="og:description" content="<?=(isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):htmlspecialchars($page_title)?>" />
  <title><?=htmlspecialchars($page_title)?></title>


  <link rel="shortcut icon" href="<?=base_url('assets/uploads/logos/'.favicon())?>">
  <!-- CSS Libraries -->
  <link href="<?=base_url('assets2/vendor/owl-carousel/owl.carousel.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/bootstrap-daterangepicker/daterangepicker.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/datatables/responsive/responsive.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/clockpicker/css/bootstrap-clockpicker.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/jquery-asColorPicker/css/asColorPicker.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/sweetalert2/sweetalert2.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')?>" rel="stylesheet" type="text/css"/>	

<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-timepicker/timepicker.css')?>">

<link href="<?=base_url('assets2/vendor/bootstrap-datepicker-master/css/bootstrap-datepicker.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/pickadate/themes/default.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/toastr/css/toastr.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/pickadate/themes/default.date.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/nouislider/nouislider.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/select2/css/select2.min.css')?>" rel="stylesheet" type="text/css"/>	

<link href="<?=base_url('assets2/vendor/bootstrap-select/css/bootstrap-select.min.css')?>" rel="stylesheet" type="text/css"/>		

<link href="<?=base_url('assets2/css/style.css')?>" rel="stylesheet" type="text/css"/>		
<link href="<?=base_url('assets2/css/custom.css')?>" rel="stylesheet" type="text/css"/>		

  <!-- Template CSS -->
  <?php if($rtl){ ?>
  <link href="assets2/css/style.css" rel="stylesheet" type="text/css"/>
  <?php }else{ ?>
    <link href="assets2/css/style.css" rel="stylesheet" type="text/css"/>
  <?php } ?>
  
  <style>
      :root{--theme-color: <?=theme_color()?>;}
  </style>

<?php $google_analytics = google_analytics(); if($google_analytics){ ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?=htmlspecialchars($google_analytics)?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?=htmlspecialchars($google_analytics)?>');
  </script>
<?php } ?>

<?=get_header_code()?>
