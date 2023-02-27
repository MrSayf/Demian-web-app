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
// print_r($me);

?>
<style>
    .welcome-box {
    box-shadow: none;
    padding: 20px;
    background-color: var(--bg-white);
    border-radius: var(--border-radius-base);
    border: 1px solid var(--border-color);
    margin: 0 0 20px 0;
    color: #000;
    display: block;
    position: relative;
}
</style>
<body class="bg-white" style="background:url(bg.png);background-repeat:no-repeat">
    <div class="page-wraper">

        <!-- Header Start -->
  <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Subscription</h1>
      </div>
      <div class="avatar-wrap">
        <a href="index.php">
          <i class="iconly-Home icli"></i>
        </a>
      </div>
    </header>
    <!-- Header End -->

        <!-- Page Content -->
        <div class="page-content bottom-content ">
            <div class="container profile-area">
                <div class="profile">
                <div class="profile">
                    
                    <div class="mb-2" style=" text-align: center; margin-bottom: 25px!important;">
                        <h4 style="color:#CE0125"> <?php echo $me['nome']; ?></h4>
                        <h6 class="detail" style="color:#CE0125">MEMBRO OURO</h6>
                    </div>
                </div>
                <div class="container">
                    <div class="welcome-area">

                        <div class="join-area">
                            <div class="started">
                                <h2>Plano Inscrito - <?php echo $me['tipoPlanoContratado']; ?> meses</h2>
                                <!-- <p>Seu plano</p> -->
                            </div>



<style>
h5{

    color:#CE0125;
}
    </style>

                            <div class="welcome-box h-auto">
                                <div class="d-flex align-items-center">

                                    <div class="ms-2">
                                        <h5  style="    color:#CE0125;">Upgrade</h5>
                                        <p>Próxima data de faturamento: 28 de dezembro de 2022</p>
                                        <p>Você tem 30 dias restantes para pausar sua assinatura</p>



                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-danger w-100">Pausar</button>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-warning w-100">Cancelar</button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            
                            



                            <div class="welcome-box h-auto">
                                <div class="d-flex align-items-center">

                                    <div class="ms-2">
                                        <h5  style="    color:#CE0125;">Renovar</h5>
                                        <p>Próxima data de faturamento: 28 de dezembro de 2022</p>
                                        <p>Você tem 30 dias restantes para pausar sua assinatura</p>



                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-danger w-100">Pausar</button>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-warning w-100">Cancelar</button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>







                            <div class="welcome-box h-auto">
                                <div class="d-flex align-items-center">

                                    <div class="ms-2">
                                        <h5  style="    color:#CE0125;">Pausar ou cancelar</h5>
                                        <p>Próxima data de faturamento: 28 de dezembro de 2022</p>
                                        <p>Você tem 30 dias restantes para pausar sua assinatura</p>



                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-danger w-100">Pausar</button>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-outline-warning w-100">Cancelar</button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>



                    </div>
                </div>
            </div>






        </div>
    </div>
    <!-- Page Content End-->
    <?php
    include_once "footer-start.php";
    ?>
    <?php
    include_once "footer-main.php";
    ?>