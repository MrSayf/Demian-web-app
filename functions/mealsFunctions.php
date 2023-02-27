<?php
//session_start();
include_once "generalFunctions.php";

function createMeals30Days($SESSION)
{
    // user info    
    $me = json_decode($SESSION['loggedAdmin']['me'], true);

    if ($me['naoCome'] != '') {

        // find list of ingredients 'dont eat' from the categories above taken from $me
        $getIngredientes = HTTPRequester::HTTPGet(
            API_URL . "Ingredientes/selectIngredientsDontEat/" . $me['naoCome'],
            array(
                "getParam" => "foo"
            ),
            $_SESSION['loggedAdmin']['token']
        );

        $getIngredientesFinais = json_decode((string)$getIngredientes, true);

        if (isset($getIngredientesFinais['success'])) {
            $var = array();
            foreach ($getIngredientesFinais['success'] as $key => $value) {
                $var[] = $value['id'];
            }

            if (count($var) > 0) {
                $varJson = json_encode($var);
            } else {
                $varJson = "empty";
            }
        } else {
            $varJson = "empty";
        }
    } else {
        //echo 'sou vazio';
        $varJson = "empty";
    }


    $varJson = str_replace('"', '', $varJson);
    $varJson = str_replace(' ', '', $varJson);
    //echo $varJson;
    // query for all recipes that does not contains ingredients above
    $createRecipes = HTTPRequester::HTTPGet(API_URL . "Receitas/selectUserRecipes/" . $varJson, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
    $createRecipesFinais = json_decode((string)$createRecipes, true);

    // generate all 5 periods meals
    // separe meals by periods, 
    $_SESSION['loggedAdmin']['meals'] = array();
    $c = 0;
    foreach ($createRecipesFinais['success'] as $key => $value) {

        // cafe da manha
        if (array_search('cafe_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }

        // lanche da manha
        if (array_search('lanche_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }

        // almoço
        if (array_search('almoco', $value)) {
            $_SESSION['loggedAdmin']['meals']['almoco'][] = $createRecipesFinais['success'][$key]['id'];
        }

        // lanche_da_tarde
        if (array_search('lanche_da_tarde', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][] = $createRecipesFinais['success'][$key]['id'];
        }

        // jantar
        if (array_search('jantar', $value)) {
            $_SESSION['loggedAdmin']['meals']['jantar'][] = $createRecipesFinais['success'][$key]['id'];
        }
        $c++;
    }


    // check if all meals periods were created, if not, return
    if (
        !isset($_SESSION['loggedAdmin']['meals']['cafe_da_manha'])   ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_manha']) ||
        !isset($_SESSION['loggedAdmin']['meals']['almoco'])          ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']) ||
        !isset($_SESSION['loggedAdmin']['meals']['jantar'])
    ) {
        // echo '<pre>';
        // print_r($_SESSION['loggedAdmin']['meals']);
        return false;
    }


    // retrieve length of actual plan in days for the calendar in the top of body, (3m/6m/12m x days of month)
    $sizeOfActualPlanInDays = sizeOfActualPlanInDays();

    // remove arrays/ids que vão alem do numero de dias do pĺano, caso ele seja maior que isso
    array_splice($_SESSION['loggedAdmin']['meals']['cafe_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['almoco'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_tarde'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['jantar'], $sizeOfActualPlanInDays);

    // echo '<pre>';
    // print_r($_SESSION['loggedAdmin']['meals']);
    // die;


    // have to make arrays fill all days from selected plan
    /********************** Breakfast / cafe da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['cafe_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['cafe_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Morning lunch / lanche da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Lunch / almoco *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['almoco']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['almoco'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['almoco'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********** Lanche da tarde *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    // /********** Jantar *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['jantar']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['jantar'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['jantar'][$x] = $arr[$key];
    }


    // find start and finish plan dates
    $tipoPlanoContratado = $me['tipoPlanoContratado'];
    $dataAgora =  date('Y-m-d');
    $dataFutura =  date('Y-m-d', strtotime(date('Y') . "-" . date('m') . "-" . date('d') . " + " . $tipoPlanoContratado . " Months"));

    // update database
    // ** se precisar refazer o plano, alterar a parte das datas pq não pode mudar pela meals-preferences.php **/
    $plano = json_encode($_SESSION['loggedAdmin']['meals']);
    $postInUser = HTTPRequester::HTTPPut(
        API_URL . "auth/updatePlan/",
        array(
            "plano" => $plano,
            // "dataPlanoInicio" => $dataAgora,
            // "dataPlanoFinaliza" => $dataFutura,
        )
    );

    // rewrite session and updates info just recently changed above
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

    return $postInUser;
}







function ReCreateMeals30Days($SESSION)
{
    // user info    
    $me = json_decode($SESSION['loggedAdmin']['me'], true);

    if ($me['naoCome'] != '') {

        // find list of ingredients 'dont eat' from the categories above taken from $me
        $getIngredientes = HTTPRequester::HTTPGet(
            API_URL . "Ingredientes/selectIngredientsDontEat/" . $me['naoCome'],
            array(
                "getParam" => "foo"
            ),
            $_SESSION['loggedAdmin']['token']
        );

        $getIngredientesFinais = json_decode((string)$getIngredientes, true);

        if (isset($getIngredientesFinais['success'])) {
            $var = array();
            foreach ($getIngredientesFinais['success'] as $key => $value) {
                $var[] = $value['id'];
            }

            if (count($var) > 0) {
                $varJson = json_encode($var);
            } else {
                $varJson = "empty";
            }
        } else {
            $varJson = "empty";
        }
    } else {
        //echo 'sou vazio';
        $varJson = "empty";
    }


    $varJson = str_replace('"', '', $varJson);
    $varJson = str_replace(' ', '', $varJson);
    
    
    // query for all recipes that does not contains ingredients above
    $createRecipes = HTTPRequester::HTTPGet(API_URL . "Receitas/selectUserRecipes/" . $varJson, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
    $createRecipesFinais = json_decode((string)$createRecipes, true);

    // generate all 5 periods meals
    // separe meals by periods, 
    $_SESSION['loggedAdmin']['meals'] = array();
    
    // plano de refeição antigo, o mesmo que deve ser atualizado
    $planoAntigo = json_decode($me['plano'],true);
    
    $c = 0;
    foreach ($createRecipesFinais['success'] as $key => $value) {


        // cafe da manha
        if (array_search('cafe_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // lanche da manha
        if (array_search('lanche_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // almoço
        if (array_search('almoco', $value)) {
            $_SESSION['loggedAdmin']['meals']['almoco'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // lanche_da_tarde
        if (array_search('lanche_da_tarde', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // jantar
        if (array_search('jantar', $value)) {
            $_SESSION['loggedAdmin']['meals']['jantar'][] = $createRecipesFinais['success'][$key]['id'];
        }

        $c++;
    }



    // check if all meals periods were created, if not, return
    if (
        !isset($_SESSION['loggedAdmin']['meals']['cafe_da_manha']) ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_manha']) ||
        !isset($_SESSION['loggedAdmin']['meals']['almoco']) ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']) ||
        !isset($_SESSION['loggedAdmin']['meals']['jantar'])
    ) {
        // echo '<pre>';
        // print_r($_SESSION['loggedAdmin']['meals']);
        return false;
    }


    // retrieve length of actual plan in days for the calendar in the top of body, (3m/6m/12m x days of month)
    $sizeOfActualPlanInDays = sizeOfActualPlanInDays();

    // remove arrays/ids que vão alem do numero de dias do pĺano, caso ele seja maior que isso
    array_splice($_SESSION['loggedAdmin']['meals']['cafe_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['almoco'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_tarde'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['jantar'], $sizeOfActualPlanInDays);



    // have to make arrays fill all days from selected plan
    /********************** Breakfast / cafe da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['cafe_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['cafe_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Morning lunch / lanche da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Lunch / almoco *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['almoco']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['almoco'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['almoco'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********** Lanche da tarde *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    // /********** Jantar *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['jantar']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['jantar'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['jantar'][$x] = $arr[$key];
    }



    //echo '<pre>novo ';
    $actualPlanDayNumber = actualPlanDayNumber();
    //$actualPlanDayNumber = 75;
    //print_r($_SESSION['loggedAdmin']['meals']);


    //echo '---------------antigo--------------------------';
    //print_r($planoAntigo);
    $totalLoop = $sizeOfActualPlanInDays - $actualPlanDayNumber;
    
    // change only dates from the actual day, do not change dates previously to today
    // cafe da manha
    $dayMealsGone = mealTimesGone();
    //echo $dayMealsGone;
    for($t=0; $t < $totalLoop; $t++){
        
        // if t=0 or today, check if meal is gone already, this meal should not be touched
        if(!($dayMealsGone > 0 && $t == 0)){
            $planoAntigo['cafe_da_manha'][$actualPlanDayNumber + $t]    = $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][$actualPlanDayNumber   + $t];
        }   
        
        if(!($dayMealsGone > 1 && $t == 0)){
            $planoAntigo['lanche_da_manha'][$actualPlanDayNumber + $t]  = $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][$actualPlanDayNumber + $t];
        }
        
        if(!($dayMealsGone > 2 && $t == 0)){
            $planoAntigo['almoco'][$actualPlanDayNumber + $t]           = $_SESSION['loggedAdmin']['meals']['almoco'][$actualPlanDayNumber          + $t];
        }
        
        if(!($dayMealsGone > 3 && $t == 0)){
            $planoAntigo['lanche_da_tarde'][$actualPlanDayNumber + $t]  = $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][$actualPlanDayNumber + $t];
        }
        
        if(!($dayMealsGone > 4 && $t == 0)){
            $planoAntigo['jantar'][$actualPlanDayNumber + $t]           = $_SESSION['loggedAdmin']['meals']['jantar'][$actualPlanDayNumber          + $t];
        }
    }

    
    // echo '<br>atualizado -----------------<br>';
    // print_r($planoAntigo);
    // die;
    // find start and finish plan dates
    $tipoPlanoContratado = $me['tipoPlanoContratado'];
    $dataAgora =  date('Y-m-d');
    $dataFutura =  date('Y-m-d', strtotime(date('Y') . "-" . date('m') . "-" . date('d') . " + " . $tipoPlanoContratado . " Months"));

    // update database
    // ** se precisar refazer o plano, alterar a parte das datas pq não pode mudar pela meals-preferences.php **/
    //$plano = json_encode($_SESSION['loggedAdmin']['meals']);
    $plano = json_encode($planoAntigo);
    $postInUser = HTTPRequester::HTTPPut(
        API_URL . "auth/updatePlan/",
        array(
            "plano" => $plano,
            // "dataPlanoInicio" => $dataAgora,
            // "dataPlanoFinaliza" => $dataFutura,
        )
    );

    // rewrite session and updates info just recently changed above
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

    return $postInUser;
}








// create meal plan with categories now (simples ...)
function CreateMeals30DaysCategory($SESSION)
{
    // user info    
    $me = json_decode($SESSION['loggedAdmin']['me'], true);

    if ($me['naoCome'] != '') {

        // find list of ingredients 'dont eat' from the categories above taken from $me
        $getIngredientes = HTTPRequester::HTTPGet(
            API_URL . "Ingredientes/selectIngredientsDontEat/" . $me['naoCome'],
            array(
                "getParam" => "foo"
            ),
            $_SESSION['loggedAdmin']['token']
        );

        $getIngredientesFinais = json_decode((string)$getIngredientes, true);

        if (isset($getIngredientesFinais['success'])) {
            $var = array();
            foreach ($getIngredientesFinais['success'] as $key => $value) {
                $var[] = $value['id'];
            }

            if (count($var) > 0) {
                $varJson = json_encode($var);
            } else {
                $varJson = "empty";
            }
        } else {
            $varJson = "empty";
        }
    } else {
        //echo 'sou vazio';
        $varJson = "empty";
    }


    $varJson = str_replace('"', '', $varJson);
    $varJson = str_replace(' ', '', $varJson);
    
    
    // query for all recipes that does not contains ingredients above
    $createRecipes = HTTPRequester::HTTPGet(API_URL . "Receitas/selectUserRecipes/" . $varJson, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
    $createRecipesFinais = json_decode((string)$createRecipes, true);

    // generate all 5 periods meals
    // separe meals by periods, 
    $_SESSION['loggedAdmin']['meals'] = array();
    
    // plano de refeição antigo, o mesmo que deve ser atualizado
    $planoAntigo = json_decode($me['plano'],true);
    
    $c = 0;
    foreach ($createRecipesFinais['success'] as $key => $value) {


        // cafe da manha
        if (array_search('cafe_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // lanche da manha
        if (array_search('lanche_da_manha', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // almoço
        if (array_search('almoco', $value)) {
            $_SESSION['loggedAdmin']['meals']['almoco'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // lanche_da_tarde
        if (array_search('lanche_da_tarde', $value)) {
            $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][] = $createRecipesFinais['success'][$key]['id'];
        }


        // jantar
        if (array_search('jantar', $value)) {
            $_SESSION['loggedAdmin']['meals']['jantar'][] = $createRecipesFinais['success'][$key]['id'];
        }

        $c++;
    }



    // check if all meals periods were created, if not, return
    if (
        !isset($_SESSION['loggedAdmin']['meals']['cafe_da_manha']) ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_manha']) ||
        !isset($_SESSION['loggedAdmin']['meals']['almoco']) ||
        !isset($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']) ||
        !isset($_SESSION['loggedAdmin']['meals']['jantar'])
    ) {
        // echo '<pre>';
        // print_r($_SESSION['loggedAdmin']['meals']);
        return false;
    }


    // retrieve length of actual plan in days for the calendar in the top of body, (3m/6m/12m x days of month)
    $sizeOfActualPlanInDays = sizeOfActualPlanInDays();

    // remove arrays/ids que vão alem do numero de dias do pĺano, caso ele seja maior que isso
    array_splice($_SESSION['loggedAdmin']['meals']['cafe_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_manha'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['almoco'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['lanche_da_tarde'], $sizeOfActualPlanInDays);
    array_splice($_SESSION['loggedAdmin']['meals']['jantar'], $sizeOfActualPlanInDays);



    // have to make arrays fill all days from selected plan
    /********************** Breakfast / cafe da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['cafe_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['cafe_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Morning lunch / lanche da manha *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_manha']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_manha'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********************** Lunch / almoco *****************************/

    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['almoco']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['almoco'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['almoco'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    /********** Lanche da tarde *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['lanche_da_tarde']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][$x] = $arr[$key];
    }


    // have to make arrays fill all days from selected plan
    // /********** Jantar *****************************/
    for ($x = sizeof($_SESSION['loggedAdmin']['meals']['jantar']); $x < $sizeOfActualPlanInDays; $x++) {
        // Declare an associative array
        $arr = $_SESSION['loggedAdmin']['meals']['jantar'];

        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $_SESSION['loggedAdmin']['meals']['jantar'][$x] = $arr[$key];
    }



    //echo '<pre>novo ';
    $actualPlanDayNumber = actualPlanDayNumber();
    //$actualPlanDayNumber = 75;
    //print_r($_SESSION['loggedAdmin']['meals']);


    //echo '---------------antigo--------------------------';
    //print_r($planoAntigo);
    $totalLoop = $sizeOfActualPlanInDays - $actualPlanDayNumber;
    
    // change only dates from the actual day, do not change dates previously to today
    // cafe da manha
    $dayMealsGone = mealTimesGone();
    //echo $dayMealsGone;
    for($t=0; $t < $totalLoop; $t++){
        
        // if t=0 or today, check if meal is gone already, this meal should not be touched
        if(!($dayMealsGone > 0 && $t == 0)){
            $planoAntigo['cafe_da_manha'][$actualPlanDayNumber + $t]    = $_SESSION['loggedAdmin']['meals']['cafe_da_manha'][$actualPlanDayNumber   + $t];
        }   
        
        if(!($dayMealsGone > 1 && $t == 0)){
            $planoAntigo['lanche_da_manha'][$actualPlanDayNumber + $t]  = $_SESSION['loggedAdmin']['meals']['lanche_da_manha'][$actualPlanDayNumber + $t];
        }
        
        if(!($dayMealsGone > 2 && $t == 0)){
            $planoAntigo['almoco'][$actualPlanDayNumber + $t]           = $_SESSION['loggedAdmin']['meals']['almoco'][$actualPlanDayNumber          + $t];
        }
        
        if(!($dayMealsGone > 3 && $t == 0)){
            $planoAntigo['lanche_da_tarde'][$actualPlanDayNumber + $t]  = $_SESSION['loggedAdmin']['meals']['lanche_da_tarde'][$actualPlanDayNumber + $t];
        }
        
        if(!($dayMealsGone > 4 && $t == 0)){
            $planoAntigo['jantar'][$actualPlanDayNumber + $t]           = $_SESSION['loggedAdmin']['meals']['jantar'][$actualPlanDayNumber          + $t];
        }
    }

    
    // echo '<br>atualizado -----------------<br>';
    // print_r($planoAntigo);
    // die;
    // find start and finish plan dates
    $tipoPlanoContratado = $me['tipoPlanoContratado'];
    $dataAgora =  date('Y-m-d');
    $dataFutura =  date('Y-m-d', strtotime(date('Y') . "-" . date('m') . "-" . date('d') . " + " . $tipoPlanoContratado . " Months"));

    // update database
    // ** se precisar refazer o plano, alterar a parte das datas pq não pode mudar pela meals-preferences.php **/
    //$plano = json_encode($_SESSION['loggedAdmin']['meals']);
    $plano = json_encode($planoAntigo);
    $postInUser = HTTPRequester::HTTPPut(
        API_URL . "auth/updatePlan/",
        array(
            "plano" => $plano,
            // "dataPlanoInicio" => $dataAgora,
            // "dataPlanoFinaliza" => $dataFutura,
        )
    );

    // rewrite session and updates info just recently changed above
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

    return $postInUser;
}
















function foodPeriodRename($period)
{
    switch ($period) {
        case 'cafe_da_manha':
            return "Café da manhã";
            break;
        case 'lanche_da_manha':
            return "Lanche da manhã";
            break;
        case 'almoco':
            return "Almoço";
            break;
        case 'lanche_da_tarde':
            return "Lanche da tarde";
            break;
        case 'jantar':
            return "Jantar";
            break;
    }
}



function changeMeal($recipeId, $mealDay, $changeMealPeriod, $changeMealToId)
{

    // convert string into array
    $me = json_decode($_SESSION['loggedAdmin']['me'], true);
    $planMeal = json_decode($me['plano'], true);
    // meal session update
    $planMeal[$changeMealPeriod][$mealDay] = $changeMealToId;
    // back to string
    $planMealString = json_encode($planMeal);

    // update database
    $postInUser = HTTPRequester::HTTPPut(
        API_URL . "auth/updatePlan/",
        array(
            "plano" => $planMealString
        )
    );

    // rewrite session and updates info just recently changed above
    $_SESSION['loggedAdmin']['me'] = HTTPRequester::HTTPMeLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

    // echo '<pre>';
    // print_r($_SESSION['loggedAdmin']);


}
