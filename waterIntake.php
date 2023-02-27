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
include_once "functions/mainFunctions.php";


// recieves form pass change update
if (isset($_POST['sendWeight'])) {

    // turn into array
    $me = array();
    $me = json_decode($_SESSION['loggedAdmin']['me'], true);

    $updateUser = HTTPRequester::HTTPPost(
        API_URL . "aguaConsumo/store/",
        array(
            "idUsuario" => $me['id'],
            "quantidade"  => $_POST['peso'],
            "data"      => date('Y-m-d H:i:s')
        ),
        $_SESSION['loggedAdmin']['token']
    );
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);
    //print_r($updateUser);
    $message = "success";
}

// turns into array and fill the form bellow
$me = array();
$me = json_decode($_SESSION['loggedAdmin']['me'], true);

// retorna lista de peso sempre
$rastreadorPeso      = HTTPRequester::HTTPGet(API_URL . "aguaConsumo/get/" . $me['id'] . "/*limitEnd*", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$rastreadorPesoArray = json_decode((string)$rastreadorPeso, true);

// consumo SÒ de hoje
$aguaHoje      = HTTPRequester::HTTPGet(API_URL . "aguaConsumo/getByToday/" . $me['id'] . "/*limitEnd*", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$aguaHojeArray = json_decode((string)$aguaHoje, true);


// echo '<pre>';
// print_r($aguaHojeArray['success']);

?>

<body class="bg-white" style="background:url(bg.png);background-repeat:no-repeat">
    <div class="page-wraper">

        <!-- Preloader -->
        <div id="preloader">
            <div class="spinner"></div>
        </div>
        <!-- Preloader end-->

        <!-- Header Start -->
  <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Water Intake</h1>
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

                    <?php if (isset($message) && $message == 'success') { ?>

                        <div class="alert alert-success" role="alert">
                            Consumo de água atualizado com sucesso!
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
                                        <h5 class="title">Registre a sua água, hoje você já registrou: <?= $aguaHojeArray['success']; ?> ml</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="waterIntake.php" method="POST">

                                            <div class="mb-3 input-group input-radius">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                <input type="number" required="required" class="form-control dz-password" name="peso" placeholder="peso (ml)">
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
                                        <h5 class="title">Histórico do consumo de água</h5>
                                    </div>
                                    <div class="card-body">



                                        <?php
                                        for ($x = 0; $x < count($rastreadorPesoArray['success']); $x++) {
                                        ?>
                                            <div class="mb-3 input-group input-radius">
                                                <?php
                                                echo $rastreadorPesoArray['success'][$x]['quantidade'] . 'ml em ';


                                                $data = date('D d M Y h m s', strtotime(@str_replace('/', '-', $rastreadorPesoArray['success'][$x]['data'])));
                                                $dataFinal = explode(" ", $data);
                                                //print_r($dataFinal);
                                                echo weekDayTruncateConverterToPortuguese($dataFinal[0]) . ", "
                                                    . $dataFinal[1] . " "
                                                    . monthTruncateConverterToPortuguese($dataFinal[2]) . ' de '
                                                    . $dataFinal[3] . ' as '
                                                    . $dataFinal[4] . ':'
                                                    . $dataFinal[5] . ':'
                                                    . $dataFinal[6]
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
    include_once "footer-start.php";
    ?>
    <?php
    include_once "footer-main.php";
    ?>