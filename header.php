<?php 
include_once "header.php"; 
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
<!-- Header Start -->
<header class="header">
      <div class="logo-wrap">
        <i class="iconly-Category icli nav-bar"></i>
        <a href="index.php"style="font-size: 23px;font-weight: 600;">Cicloketo </a>
      </div>
      <div class="avatar-wrap">
        <span class="font-sm"  style="color: white;"><i class="iconly-Location icli font-xl" ></i><?php echo $me['nome']; ?> 👋</span>
        <a href="account.php"> <img class="avatar" src="assets/images/avatar/avatar.jpg" alt="avatar" /></a>
      </div>
    </header>
    <!-- Header End -->