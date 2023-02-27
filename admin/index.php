<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// start session
session_start();

// includes REST class
include_once "adm/conexao/conexao.php";
include_once "adm/conexao/function.php";
include_once "../functions/generalFunctions.php";


// defines api url
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('API_URL', "http://127.0.0.1:8000/api/");
} else {
    define('API_URL', "https://api.cicloketo.com.br/api/");
}


// check if logged
if (isset($_SESSION['logged']['token'])) {

    $token = $_SESSION['logged']['token'];
    $meInfoResponse = HTTPRequester::HTTPMeLaravelApi($token, API_URL);
    $meInfoResponseFinais = json_decode((string)$meInfoResponse, true);

    $_SESSION['logged']['info'] = $meInfoResponseFinais;
    //$_SESSION['logged']['info'] = $meInfoResponseFinais;
    header("location: adm/index.php");
    die;
}



// login form
if (isset($_POST['formLogin'])) {

    // faz login
    $loginResponse = LoginLaravelApi(API_URL, $_POST['email'], $_POST['senha']);

    // logado ou não
    if ($loginResponse == 'Unauthorized') {

        // não logou
        header("location: index.php");
        die;
    } else {
        // saves token in session
        $_SESSION['logged'] = array();
        $_SESSION['logged']['token'] = $loginResponse;

        // saves user info in session
        $meInfoResponse = HTTPRequester::HTTPMeLaravelApi($loginResponse, API_URL);
        $meInfoResponseFinais = json_decode((string)$meInfoResponse, true);
        $_SESSION['logged']['info'] = $meInfoResponseFinais;


        /************** LOG ********************************/
        /***************************************************/
        /***************************************************/
        $dataInsert = date('Y-m-d H:i:s');
        $postLog = HTTPRequester::HTTPPost(
            API_URL . "loginLog/store/",
            array(
                "userId" => $meInfoResponseFinais['id'],
                "session" => json_encode($_SESSION),
                "email" => $_POST['email'],
                "data" => $dataInsert,
                "ip" => get_client_ip(),
                "local" => 1
            ),$_SESSION['logged']['token'] 
        );
        
        // envia para home dentro de /adm/
        header("location: adm/index.php");
        die;
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta description -->
    <meta name="description" content="BizBite corporate business template or agency and marketing template helps you easily create websites for your business.">
    <meta name="author" content="ThemeTags">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />

    <!--title-->
    <title>CicloKeto - O único App de emagrecimento que você jamais precisará</title>

    <!--favicon icon-->
    <link rel="icon" href="img/favicon.png" type="image/png" sizes="16x16">

    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&display=swap" rel="stylesheet">

    <!--Bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--Magnific popup css-->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!--Themify icon css-->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!--Fontawesome icon css-->
    <link rel="stylesheet" href="css/all.min.css">
    <!--animated css-->
    <link rel="stylesheet" href="css/animate.min.css">
    <!--ytplayer css-->
    <link rel="stylesheet" href="css/jquery.mb.YTPlayer.min.css">
    <!--Owl carousel css-->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!--custom css-->
    <link rel="stylesheet" href="css/style.css">
    <!--responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body>

    <!--loader start-->
    <div id="preloader">
        <div class="loader1">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!--loader end-->

    <!--header section start-->
    <header class="header">
        <!--start navbar-->

    </header>
    <!--header section end-->

    <!--body content wrap start-->
    <div class="main">

        <!--hero background image with content slider start-->
        <section class="hero-section hero-bg-2 ptb-100 full-screen">
            <div class="container">
                <div class="row align-items-center justify-content-between pt-5 pt-sm-5 pt-md-5 pt-lg-0">
                    <div class="col-md-7 col-lg-6">
                        <div class="hero-content-left text-white">
                            <h1 class="text-white">Seja Bem vindo Admin!</h1>
                            <p class="lead">
                                Você precisa ter autocontrole e foco...
                                <br>Quando atingir seus objetivos, vai perceber que valeu a pena!
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5">
                        <div class="card login-signup-card shadow-lg mb-0">
                            <div class="card-body px-md-5 py-5">
                                <div class="mb-5">
                                    <h5 class="h3">Login</h5>
                                    <p class="text-muted mb-0">Entre com seu email e senha</p>
                                </div>

                                <!--login form-->
                                <form class="login-signup-form" method="POST" action="index.php">
                                    <div class="form-group">
                                        <label class="pb-1">E-mail</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-icon">
                                                <span class="ti-email color-primary"></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Seu email">
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label class="pb-1">Senha</label>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="form-text small text-muted">
                                                    Esqueceu a senha?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <div class="input-icon">
                                                <span class="ti-lock color-primary"></span>
                                            </div>
                                            <input type="password" class="form-control" name="senha" placeholder="Sua senha">
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3">
                                        Entre
                                    </button>
                                    <input type="hidden" name="formLogin" value="formLogin">
                                </form>
                            </div>
                            <!-- <div class="card-footer bg-transparent border-top px-md-5"><small>Not registered?</small>
                            <a href="sign-up.html" class="small"> Create account</a></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero background image with content slider end-->

    </div>
    <!--body content wrap end-->


    <!--bottom to top button start-->
    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="ti-angle-up"></span>
    </button>
    <!--bottom to top button end-->

    <!--jQuery-->
    <script src="js/jquery-3.5.0.min.js"></script>
    <!--Popper js-->
    <script src="js/popper.min.js"></script>
    <!--Bootstrap js-->
    <script src="js/bootstrap.min.js"></script>
    <!--Magnific popup js-->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!--jquery easing js-->
    <script src="js/jquery.easing.min.js"></script>
    <!--jquery ytplayer js-->
    <script src="js/jquery.mb.YTPlayer.min.js"></script>
    <!--Isotope filter js-->
    <script src="js/mixitup.min.js"></script>
    <!--wow js-->
    <script src="js/wow.min.js"></script>
    <!--owl carousel js-->
    <script src="js/owl.carousel.min.js"></script>
    <!--countdown js-->
    <script src="js/jquery.countdown.min.js"></script>
    <!--jquery easypiechart-->
    <script src="js/jquery.easy-pie-chart.js"></script>
    <!--custom js-->
    <script src="js/scripts.js"></script>
</body>

</html>