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

// turn into array
$me = array();
$me = $planoArray = json_decode($_SESSION['loggedAdmin']['me'], true);

// echo '<pre>';
// print_r($me['nome']);


// echo $me['dataPlanoInicio'];
// // echo $me['dataPlanoFinaliza'];

// echo '<br>';

$originalDateStart =  $me['dataPlanoInicio'];
//$planBeginsIn = date("d-m-Y", strtotime($originalDateStart));
$originalDateFinishes =  $me['dataPlanoFinaliza'];
//$planEndsIn   = date("d-m-Y", strtotime($originalDateFinishes));



?>
  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Accounts</h1>
      </div>
      <div class="avatar-wrap">
        <a href="index.php">
          <i class="iconly-Home icli"></i>
        </a>
      </div>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main class="main-wrap account-page mb-xxl">
      <div class="account-wrap section-b-t">
        <div class="user-panel">
          <div class="media">
            <a href="account.php"> <img src="assets/images/avatar/avatar.jpg" alt="avatar" /></a>
            <div class="media-body">
              <a href="account.php" class="title-color"><?php echo $me['nome']; ?>
                <span class="content-color font-sm"><?php echo $me['email']; ?></span>
              </a>
            </div>
          </div>
        </div>


        <!-- Navigation Start -->
        <ul class="navigation">
          <li>
            <a href="index.php" class="nav-link title-color font-sm">
              <i class="iconly-Home icli"></i>
              <div class="ms-3">
              <span>Nome :</span>
              <p class="mb-0"><?php if(strlen($me['nome']) > 0){echo $me['nome']; } else {echo 'nd';} ?></p>
            </div>
            </a>
            <a href="index.php" class="arrow"><i data-feather="chevron-right"></i></a>
          </li>

          <li>
            <a href="category-wide.html" class="nav-link title-color font-sm">
              <i class="iconly-Category icli"></i>
              <div class="ms-3">
              <span>E-mail :</span>
              <p class="mb-0"><?php echo $me['email']; ?></p>
                </div>
            </a>
            <a href="category-wide.html" class="arrow"><i data-feather="chevron-right"></i></a>
          </li>
          <li>
            <a href="wishlist.html" class="nav-link title-color font-sm">
              <i class="iconly-Heart icli"></i>
              <div class="ms-3">
              <div class="light-text">Plano contratado:<span style="color:brown;"> <?php echo $me['tipoPlanoContratado']; ?> meses</span></div>
              <p class="mb-0">Inicio:<?php echo $originalDateStart; ?></p>
              <p class="mb-0">Fim:<?php echo $originalDateFinishes; ?> | Clique aqui para renovar ou fazer upgrade</p> 
              </div>
            </a>
            <a href="wishlist.html" class="arrow"><i data-feather="chevron-right"></i></a>
          </li>
        </ul>
        <!-- Navigation End -->
        <a href="index.php?logout">
        <button class="log-out" data-bs-toggle="offcanvas" data-bs-target="#confirmation" aria-controls="confirmation"><i class="iconly-Logout icli"></i>Sign Out</button>
        </a>
      </div>
    </main>
    <!-- Main End -->

    <?php include 'footer-start.php'?>

    <?php include 'footer-main.php'?>
</html>
<!-- Html End -->
