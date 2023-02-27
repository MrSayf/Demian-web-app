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


// echo '<pre>';
// print_r($_SESSION['loggedAdmin']['token']);

// recieves form pass change update
if (isset($_POST['sendWeight'])) {
    
    // turn into array
    $me = array();
    $me = json_decode($_SESSION['loggedAdmin']['me'], true);

    $updateUser = HTTPRequester::HTTPPost(
        API_URL . "RastreadorPeso/store/",
        array(
            "idUsuario" => $me['id'],
            "pesoHoje"  => $_POST['peso'],
            "data"      => date('Y-m-d H:i:s'),
            "ip"        => $_SERVER['REMOTE_ADDR']
        ),
        $_SESSION['loggedAdmin']['token']
    );
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);
    $message = "success";
}

// echo '<pre>';
// print_r( $updateUser );

// turns into array and fill the form bellow
$me = array();
$me = json_decode($_SESSION['loggedAdmin']['me'], true);


// retorna lista de peso
$rastreadorPeso      = HTTPRequester::HTTPGet(API_URL . "RastreadorPeso/get/" . $me['id'] . "/*limitEnd*", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$rastreadorPesoArray = json_decode((string)$rastreadorPeso, true);


// echo '<pre>';
// print_r($rastreadorPesoArray);

?>

<body class="bg-white" style="background:url(bg.png);background-repeat:no-repeat">
    <div class="page-wraper">

        <!-- Header Start -->
  <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Search Recipes</h1>
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

                <?php if (isset($message) && $message == 'success') { ?>

                    <div class="alert alert-success" role="alert">
                        Peso adicionado com sucesso!
                    </div>

                <?php } ?>
                <div class="profile">
                    
                    <div class="mb-2" style=" text-align: center; margin-bottom: 25px!important;">
                        <h4 style="color:#CE0125"> <?php echo $me['nome']; ?></h4>
                        <h6 class="detail" style="color:#CE0125">MEMBRO OURO</h6>
                    </div>
                </div>
                <div class="container">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="title">Marque seu peso hoje</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="weight-add.php" method="POST">




                                            <div class="mb-3 input-group input-radius">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                <input type="number" required="required" class="form-control dz-password" name="peso" placeholder="peso (kg)">
                                                <span class="input-group-text show-pass">
                                                    <i class="fa fa-eye-slash"></i>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>


                                            <input type="hidden" name="sendWeight" value="sendWeight">
                                            <input style="width: 27rem; background-color:#CE0125;color:white" type="submit" class="btn btn-secondary mt-3  btn-block" name="ATUALIZAR" value="ATUALIZAR">

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="title">Histórico do seu peso</h5>
                                    </div>
                                    <div class="card-body">



                                        <?php
                                        for ($x = 0; $x < count($rastreadorPesoArray['success']); $x++) {
                                        ?>
                                            <div class="mb-3 input-group input-radius">
                                                <?php
                                                echo $rastreadorPesoArray['success'][$x]['pesoHoje'] . 'kg em ';
                                                echo $rastreadorPesoArray['success'][$x]['data'];
                                                ?>
                                            </div>
                                        <?php
                                        }
                                        ?>

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
    include_once "footer-main.php";
    ?>