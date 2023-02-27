<?php
session_start();

include_once "functions/cookies.php";
include_once "admin/adm/conexao/conexao.php";
include_once "admin/adm/conexao/function.php";
include_once "functions/mealsFunctions.php";
include_once "functions/generalFunctions.php";

// defines API url
if ($_SERVER['HTTP_HOST'] == 'localhost') {
  define('API_URL', "https://api.cicloketo.com.br/api/");
} else {
  define('API_URL', "https://api.cicloketo.com.br/api/");
}

// login or out
if (isset($_SESSION['loggedAdmin']) || isset($_COOKIE['uidck'])) {
  if ($_COOKIE['uidck'] != 0) {
    header("location: index.php");
    die('');
  }
} else {
  unset($_SESSION);
  unset($_COOKIE);
}

// login form
if (isset($_POST['formLogin'])) {

  // login
  $loginResponse = LoginLaravelApi(API_URL, $_POST['email'], $_POST['senha']);

  // logged or not
  if ($loginResponse == 'Unauthorized') {

    // not logged
    $message = 'error';
  } else {
    //echo 'ccc';
    $_SESSION['loggedAdmin'] = array();
    $_SESSION['loggedAdmin']['token'] = $loginResponse;
    // retrieve and store  users info
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($loginResponse, API_URL);

    // check if has a meal plan already
    $hasPlano = json_decode($_SESSION['loggedAdmin']['me'], true);

    /***************************************************/
    /************** LOG ********************************/
    /***************************************************/
    $dataInsert = date('Y-m-d H:i:s');
    $postLog = HTTPRequester::HTTPPost(
      API_URL . "loginLog/store/",
      array(
        "userId" => $hasPlano['id'],
        "session" => json_encode($_SESSION),
        "email" => $_POST['email'],
        "data" => $dataInsert,
        "ip" => get_client_ip(),
        "local" => 0
      ),
      $_SESSION['loggedAdmin']['token']
    );


    // if has a plan
    if (isset($hasPlano['plano']) && strlen($hasPlano['plano']) > 1) {
      $hasPlanoFinals = json_decode($hasPlano['plano']);
    } else {
      // create plan
      if (!createMeals30Days($_SESSION)) {
        die('falhou aqui em criar plano, não tem plano completo');
      }
    }


    $resuJson = json_encode($_SESSION['loggedAdmin']['token']);
    setcookie('uidck',  encryptCookieContent($resuJson), time() + (60 * 10080), "/");
    header("location: onboard.php");
    die;
  }
}
include 'head.php';

?>


  <!-- Body Start -->
  <body>
<div class="bg-pattern-wrap ratio2_1">
      <!-- Background Image -->
      <div class="bg-patter">
        <img style="height:100px" src="bg-pattern2.png" class="bg-img" alt="pattern" />
      </div>
    </div>

    <!-- Main Start -->
    <main class="main-wrap login-page mb-xxl">
      <img class="logo" src="logo.png" alt="logo" />
      <img class="logo logo-w" src="assets/images/logo/logo.png" alt="logo" />
      <p class="font-sm content-color">Online Supermarket for all your daily needs. you are just One Click away from your all needs at your door step.</p>

      <!-- Login Section Start -->
      <section class="login-section p-0">
        <?php
          if (isset($message)) {
          ?>
            <div class="alert alert-danger" role="alert">
              Login não autorizado, tente novamente!
            </div>
          <?php
          }
          ?>
          

          <h3>Login</h3><br>
          <form action="login.php" method="post" class="custom-form">
            <div class="d-flex flex-column">
              <label for="nome" style="margin-left:-500px">Email</label>
              <input type="email" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="E-mail" id="email" name="email" />
            </div>
            <div class="d-flex flex-column my-4">
              <label for="email" style="margin-left:-500px">Senha</label>
              <input type="password" required="required" placeholder="Senha" id="senha" name="senha" />
            </div>
            <div class="button">
              <button class="btn-solid" type="submit">Entrar</button>
            </div>
            <input type="hidden" name="formLogin" value="formLogin">
          </form>
          <div class="box-singup">
            <p>Esqueceu a senha? <a href="../resetPassword/index.php?p=1"> Criar nova</a></p>
            <p>Novo ao cicloketo? <a href="../step1/">Registrar</a> </p>
          </div>
        </div>
       
      </div>
    </div>
  </main>
</body>
<?php include "footer-main.php"?>

</html>
<!-- Html End -->
