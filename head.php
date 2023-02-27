<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>  
<!DOCTYPE html>
<html lang="en">
  <!-- Head Start -->
  
<!-- Mirrored from themes.pixelstrap.com/fastkart-app/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 18 Feb 2023 10:52:38 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Fastkart" />
    <meta name="keywords" content="Fastkart" />
    <meta name="author" content="Fastkart" />
    <link rel="manifest" href="manifest.json" />
    <title>Cicloketo</title>
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/favicon.png" />
    <meta name="theme-color" content="#0baf9a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="Fastkart" />
    <meta name="msapplication-TileImage" content="assets/images/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.css" />

    <!-- Iconly Icon css -->
    <link rel="stylesheet" type="text/css" href="assets/css/iconly.css" />

    <!-- Slick css -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css" />

    <!-- Style css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
    <style     background-color: #ff2146;></style>

    <!-- includes function.php -->
	<?php include_once "functions/functions.php"; ?>
  </head>
  <!-- Head End -->

  <?php
include_once "admin/adm/conexao/conexao.php";

// defines api url
if($_SERVER['HTTP_HOST'] == 'localhost'){
    define('API_URL', "https://api.cicloketo.com.br/api/");
}else{
    define('API_URL', "https://api.cicloketo.com.br/api/");
}
  
?>