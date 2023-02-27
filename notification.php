<?php 
session_start();
include_once "head.php"; 
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";


// se não estiver logado, volta
if(!isset($_SESSION['loggedAdmin']['token'])){
	if (!isset($_COOKIE['uidck']) || $_COOKIE['uidck'] == 0) {
        header("location: login.php");
        die;
    } else {
		$token = json_decode(decryptCookieContent($_COOKIE['uidck']), true);
        $_SESSION['loggedAdmin']['token'] = $token;
        $_SESSION['loggedAdmin']['me'] 	  = HTTPRequester::HTTPMeLaravelApi($token, API_URL);
    }
}else{
    //session exists, check if cookie exists
    if (!isset($_COOKIE['uidck'])) {
        $resuJson = json_encode($_SESSION['loggedAdmin']['token']);
        setcookie('uidck',  encryptCookieContent($resuJson), time() + (60 * 10080), "/");
    }
}


// query db
$nots        = HTTPRequester::HTTPGet(API_URL . "Notificacoes/get/0,20", array("getParam" => "foobar"),$_SESSION['loggedAdmin']['token']);
$notsArray   = json_decode((string)$nots, true);


?>


  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Notification</h1>
      </div>
      <div class="avatar-wrap">
        <a href="index.php">
          <i class="iconly-Home icli"></i>
        </a>
      </div>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main class="main-wrap notification-page mb-xxl">
      

      <!-- Tab Content Start -->
      <section class="tab-content ratio2_1" id="pills-tabContent">
        

        <!-- Offer Content Start -->
        <div class="tab-pane fade show active" id="offer1" role="tabpanel" aria-labelledby="offer1-tab">
          <!-- Yesterday Start -->
          <div class="offer-wrap">
            
            <!-- Offer Box Start -->
            <div class="offer-box">
            <?php
                // echo '<pre>';
                // print_r($notsArray);
                for($x=0; $x<count($notsArray);$x++){
            ?>
              <div class="media">
                <div class="icon-wrap bg-theme-blue">
                  <i class="iconly-Discount icli"></i>
                </div>
                <div class="media-body">
                  <h3 class="font-sm title-color"><?php echo $notsArray['success'][$x]['titulo']; ?></h3>
                  
                </div>
                <span class="badges bg-theme-theme-light font-theme"><?php echo $notsArray['success'][$x]['data']; ?></span>
              </div>
              <?php 
            }
            ?>
            </div>
            <!-- Offer Box End -->
          </div>
          <!-- Yesterday End -->

          
        </div>
        <!-- Offer Content End -->
      </section>
      <!-- Tab Content End -->
    </main>
    <!-- Main End -->
    <?php include "footer-main.php"?>
    <?php include "footer-start.php"?>
</html>
<!-- Html End -->
