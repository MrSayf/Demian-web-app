<?php
session_start();
include_once "head.php";
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";


// se não estiver logado, volta
if (!isset($_SESSION['loggedAdmin']['token'])) {
    if (!isset($_COOKIE['uidck']) || $_COOKIE['uidck'] == 0) {
        header("location: login.php");
        die;
    } else {
        $token = json_decode(decryptCookieContent($_COOKIE['uidck']), true);
        $_SESSION['loggedAdmin']['token'] = $token;
        $_SESSION['loggedAdmin']['me']       = HTTPRequester::HTTPMeLaravelApi($token, API_URL);
    }
} else {
    //session exists, check if cookie exists
    if (!isset($_COOKIE['uidck'])) {
        $resuJson = json_encode($_SESSION['loggedAdmin']['token']);
        setcookie('uidck',  encryptCookieContent($resuJson), time() + (60 * 10080), "/");
    }
}


// recieves form pass change update
if (isset($_POST['sendPassEdit'])) {

    // turn into array
    $me = array();
    $me = json_decode($_SESSION['loggedAdmin']['me'], true);
    // passwords differs
    if ($_POST['password'] != $_POST['password2']) {
        $message = 'error';
    } else {

        $updateUser = HTTPRequester::HTTPPut(
            API_URL . "auth/updatePassword/",
            array(
                "password" => $_POST['password'],
                "password_confirmation" => $_POST['password2'],
                
            )
        );
        $message = 'success';
        
        // echo '<pre>';
        // print_r($updateUser);
    }
}  

// turns into array and fill the form bellow
$me = array();
$me = json_decode($_SESSION['loggedAdmin']['me'], true);

?>

  <!-- Body Start -->
  <body>
    <!-- Header Start -->
  <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Edit Your Psassword</h1>
      </div>
      <div class="avatar-wrap">
        <a href="index.php">
          <i class="iconly-Home icli"></i>
        </a>
      </div>
    </header>
    <!-- Header End -->
    <div class="bg-pattern-wrap ratio2_1">
      <!-- Background Image -->
      <div class="bg-patter">
        <img src="assets/images/banner/bg-pattern2.png" class="bg-img" alt="pattern" />
      </div>
    </div>

    <!-- Main Start -->
    <main class="main-wrap login-page mb-xxl">
    <div class="mb-2">
                        <h4><?php echo $me['nome']; ?></h4>
                        <h6 class="detail">MEMBRO OURO</h6>
                    </div>
      <!-- Reset Section Start -->
      <section class="login-section p-0">
        <!-- Reset Form Start -->
        <form action="password-change.php" method="POST" class="custom-form">
          <h1 class="font-md title-color fw-600">edit your password</h1>

          <!-- Password Input start -->
          <div class="input-box">
            <input type="password" required="required" class="form-control dz-password" name="password" placeholder="Nova senha" required class="form-control" />
            <i class="iconly-Hide icli showHidePassword"></i>
          </div>
          <!-- Password Input End -->

          <!-- Password Input start -->
          <div class="input-box">
            <input type="password" required="required" class="form-control dz-password" name="password2" placeholder="Confirmar nova senha" required class="form-control" />
            <i class="iconly-Hide icli showHidePassword"></i>
          </div>
          <!-- Password Input End -->

          <button type="submit" class="btn-solid" name="sendPassEdit" value="sendPassEdit">Submit</button>
          
        </form>
        <!-- Reset Form End -->
      </section>
      <!-- Reset Section End -->
    </main>
    <!-- Main End -->
    <?php
    include_once "footer-start.php";
    ?>
    <?php
    include_once "footer-main.php";
    ?>
    </html>
<!-- Html End -->
