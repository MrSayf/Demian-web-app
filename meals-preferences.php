<?php
session_start();
include_once "head.php";
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";

/*****************************************/
/******se não estiver logado, volta*******/
/*****************************************/
// se não estiver logado, volta
if (!isset($_SESSION['loggedAdmin']['token'])) {
    if (!isset($_COOKIE['uidck']) || $_COOKIE['uidck'] == 0) {
        header("location: login.php");
        die;
    } else {
        $token = json_decode(decryptCookieContent($_COOKIE['uidck']), true);
        $_SESSION['loggedAdmin']['token'] = $token;
        $_SESSION['loggedAdmin']['me']    = HTTPRequester::HTTPMeLaravelApi($token, API_URL);
    }
} else {
    //session exists, check if cookie exists
    if (!isset($_COOKIE['uidck'])) {
        $resuJson = json_encode($_SESSION['loggedAdmin']['token']);
        setcookie('uidck',  encryptCookieContent($resuJson), time() + (60 * 10080), "/");
    }
}

include_once "functions/mealsFunctions.php";


// echo '<pre>';
// print_r($_SESSION['loggedAdmin']);

/*****************************************/
/****** Seta categoria plano alimentar ***/
/*****************************************/

// seta categoria plano alimentar
if(isset($_GET['setaCategoriaPlanoAlimentar'])){
    
    // simples
    if(isset($_GET['categoria']) && ($_GET['categoria'] == 'simples'    || 
                                     $_GET['categoria'] == 'economico'  || 
                                     $_GET['categoria'] == 'moderado'   ||
                                     $_GET['categoria'] == 'avancado'  
                                     ) ){
        $me = json_decode($_SESSION['loggedAdmin']['me'], true);
        $postInUser = HTTPRequester::HTTPPut(
            API_URL . "auth/updateCategoriaPlanoAlimentar/",
            array(
                "categoriaPlanoAlimentar" => $_GET['categoria']
            )
        );
    }

    // recupera dados atualizados
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);


    // seta plano novo
   
}



/*********************************************************/
/**************** Updates naoCome form  ******************/
/*********************************************************/

if (isset($_POST['sendFormMealsPrefs'])) {

    // at least 5 categories, or wont update
    if (count($_POST) <= 5) {
        $messageError = "Escolha pelo menos 5 categorias";
    } else {
        //find out how many ingredients categories are available
        $ingredientsCategoriesCount = HTTPRequester::HTTPGet(API_URL . "categoriasIngredientes/categoriasIngredientesCount/", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
        $ingredientsCategoriesCountArray   = json_decode((string)$ingredientsCategoriesCount, true);


        // turn selectable checkboxes into array, if any
        $listDontEatCategories = array();
        for ($x = 1; $x <= $ingredientsCategoriesCountArray['success'][0]['allcount']; $x++) {
            if (!isset($_POST[$x])) {
                $listDontEatCategories[] .= $x;
            }
        }

        if (count($listDontEatCategories) < 1) {
            // echo 'aquiii..xxx...';
            $listDontEatCategories = '';
        }
        // turn into array
        $me = array();
        $me = json_decode($_SESSION['loggedAdmin']['me'], true);


        // retrieve old 'nao come'
        if (isset($me['naoCome']) && strlen($me['naoCome']) > 1) {
            $meAntigoNaoCome = json_decode($me['naoCome'], true);
        } else {
            $meAntigoNaoCome = '';
        }

        // print_r($listDontEatCategories);
        $updateUser = HTTPRequester::HTTPPut(
            API_URL . "auth/updateDoesntEat/",
            array(
                "naoCome" => $listDontEatCategories
            )
        );


        $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

        // change meal plan with new don't eat inputs
        if (ReCreateMeals30Days($_SESSION)) {
            //echo 'create meals deu true';
            // retrieve and store  users info
            $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);
            $message = 'success';
        } else {
            // se deu errado, volta aozz
            $updateUser = HTTPRequester::HTTPPut(
                API_URL . "auth/updateDoesntEat/",
                array(
                    "naoCome" => $meAntigoNaoCome
                )
            );

            //HTTPRequester::HTTPGet(API_URL . "auth/deleteIngredientInNaoCome/".$me['id']."/".$listDontEatCategories, array("getParam" => "foobar"));
            $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

            // show message
            $messageError = "Erro ao montar menu! Escolha mais categorias";
        }
    }
}



/*********************************************************/
/** Fetchs for ingredients categories ********************/
/*********************************************************/
$ingredientsCategories        = HTTPRequester::HTTPGet(API_URL . "categoriasIngredientes/get/", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$ingredientsCategoriesArray   = json_decode((string)$ingredientsCategories, true);

/*********************************************************/
/** Fetchs for personal info in sessions *****************/
/*********************************************************/
// turn into array
$meArray = array();
$meArray = json_decode($_SESSION['loggedAdmin']['me'], true);

// make naoCome array
$naoComeArray = array();
//
if (!isset($meArray['naoCome']) or strlen($meArray['naoCome']) < 1) {
    $naoComeArray = [""];
} else {
    $naoComeArray = json_decode($meArray['naoCome'], true);
}

// inserts all categories names in array
$allCategoriesArray = array();
for ($x = 0; $x < count($ingredientsCategoriesArray['success']); $x++) {
    $allCategoriesArray[] .= $ingredientsCategoriesArray['success'][$x]['nome'];
}

// up arrays indexes + 1 to make things easyer
$cc = 1;
foreach ($allCategoriesArray as $key => $value) {
    $novaAllCategoriesArray[$cc] = $value;
    $cc++;
}

?>


  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Components</h1>
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
      <?php if (isset($message) && $message == 'success') { ?>

                    <div class="alert alert-success" role="alert">
                        Plano alterado com sucesso!
                    </div>

                <?php } ?>
                <?php
                if (isset($messageError)) {
                ?>
                    <div class="alert alert-danger light alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <strong>Erro! </strong><?php echo $messageError; ?>
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                <?php
                }

                if (isset($messageSuccess)) {
                ?>
                    <div class="alert alert-success light alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        <strong>Pronto!</strong> <?php echo $messageSuccess; ?>
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                <?php
                }
                ?>

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
                                            // print_r($ingredientsCategoriesArray['success']);
                                            // echo '-------------------';
                                            // print_r($naoComeArray);


                                            for ($x = 0; $x < count($ingredientsCategoriesArray['success']); $x++) {


                                            ?>
              <div class="media">
                <div class="icon-wrap bg-theme-blue">
                  <i class="iconly-Discount icli"></i>
                </div>
                <div class="media-body">
                  <h3 class="font-sm title-color"><?php echo $ingredientsCategoriesArray['success'][$x]['nome']; ?></h3>
                  
                </div>
                <span class="badges bg-theme-theme-light font-theme"><?php if (!in_array($ingredientsCategoriesArray['success'][$x]['id'], $naoComeArray)) { echo 'checked';} ?> name="<?php echo $ingredientsCategoriesArray['success'][$x]['id']; ?></span>
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
