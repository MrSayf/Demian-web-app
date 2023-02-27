<?php
session_start();
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";
// includes header
include_once "head.php";
include_once "admin/adm/conexao/function.php";
/*******************************************************************************/
/************************    Logout  *******************************************/
/*******************************************************************************/
if(isset($_GET['logout'])){
    HTTPRequester::HTTPLogoutLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

	// remove sessions from user
	unset($_SESSION);
	session_destroy();
	unset($_COOKIE);
	setcookie('uidck',  '0', -3600, '/');

	// redirect to login page
	header("location: login.php");
    die;
}


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



include_once "functions/generalFunctions.php";




/*******************************************************************************/
/************************ Login  ***********************************************/
/*******************************************************************************/

// echo '<pre>antes-----';
// print_r($_SESSION);

// // descobrir porque quando abre search recipes da pau



// echo '<pre>depois-----';
// print_r($_SESSION);




// rest of the site for the main page/index

include_once "body.php";


