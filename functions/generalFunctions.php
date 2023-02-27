<?php


function findPosition($arraySearch, $idBuscar)
{
    $resu = array_search($idBuscar, array_column($arraySearch, 'id'));
    return $resu;
}


function mealTimes()
{
    // finds actual time/hour
    $time = date('H');

    switch ($time) {
        case $time >= 7 && $time < 10:
            return  "Café da manhã";
            break;
        case $time >= 10 && $time < 13:
            return "Lanche da manhã";
            break;
        case $time >= 13 && $time < 16:
            return "Almoço";
            break;
        case $time >= 16 && $time < 17:
            return "Lanche da tarde";
            break;
        case $time >= 17 && $time < 21:
            return "Jantar";
            break;
    }
}



function mealTimesGone()
{
    // finds actual time/hour
    $time = date('H');
    //echo $time;
    switch ($time) {
        case $time >= 7 && $time < 10:
            return  "0";
            break;
        case $time >= 10 && $time < 13:
            // passou o cafe da manha
            return "1";
            break;
        case $time >= 13 && $time < 16:
            // passou o lanche da manha
            return "2";
            break;
        case $time >= 16 && $time < 17:
            // passou o almoço
            return "3";
            break;
        case $time >= 17 &&  $time < 21:
            // passou o lanche da tarde
            return "4";
            break;
        case $time >= 21:
            // passou o jantar
            return "5";
            break;
    }
}


function sideBarGreetByTime()
{
    // finds actual time/hour
    $time = date('H');

    if ($time >= 0  && $time < 6) {
        echo 'Boa madrugada';
    }
    if ($time >= 6  && $time < 12) {
        echo 'Bom dia';
    }
    if ($time >= 12 && $time < 18) {
        echo 'Boa tarde';
    }
    if ($time >= 18) {
        echo 'Boa noite';
    }
}


// calculates intakes depending on the actual time
function calcIntakes($now, $planoArrayJson, $actualDay)
{

    // finds actual time/hour

    switch ('Lanche da tarde') {
        case "Café da manhã":

            $periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay];
            $periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
            $periodsArray   = json_decode((string)$periods, true);
            return $periodsArray;
            break;
        case "Lanche da manhã":
            $periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay] . ',' . $planoArrayJson['lanche_da_manha'][$actualDay];
            $periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
            $periodsArray   = json_decode((string)$periods, true);
            return $periodsArray;
            break;
        case "Almoço":
            $periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay] . ',' . $planoArrayJson['lanche_da_manha'][$actualDay] . ',' . $planoArrayJson['almoco'][$actualDay];
            $periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
            $periodsArray   = json_decode((string)$periods, true);
            return $periodsArray;
            break;
        case "Lanche da tarde":
            $periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay] . ',' . $planoArrayJson['lanche_da_manha'][$actualDay] . ',' . $planoArrayJson['almoco'][$actualDay] . ',' . $planoArrayJson['lanche_da_tarde'][$actualDay];
            $periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
            $periodsArray   = json_decode((string)$periods, true);
            return $periodsArray;
            break;
        case "Jantar":
            $periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay] . ',' . $planoArrayJson['lanche_da_manha'][$actualDay] . ',' . $planoArrayJson['almoco'][$actualDay] . ',' . $planoArrayJson['lanche_da_tarde'][$actualDay] . ',' . $planoArrayJson['jantar'][$actualDay];
            $periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
            $periodsArray   = json_decode((string)$periods, true);

            return $periodsArray;
            break;
    }
}

// first day of the actual plan, and calculates for a given date number of days
function numberOfDaysBetweenDates($dateBefore, $dateAfter)
{

    // echo '<pre>';
    // print_r($_SESSION);    

    $originalDateStart  =  $dateBefore;
    $futureDate         =  $dateAfter;

    //echo $originalDateStart;

    $date1 = new DateTime($originalDateStart);
    $date2 = new DateTime($futureDate);

    $days  = $date1->diff($date2)->format('%a');
    return $days;
}


function actualPlanDayNumber()
{

    // echo '<pre>';
    // print_r($_SESSION);

    $me = array();
    $me = $planoArray = json_decode($_SESSION['loggedAdmin']['me'], true);
    $originalDateStart =  $me['dataPlanoInicio'];
    $now =  date('Y-m-d');

    //echo $originalDateStart;

    $date1 = new DateTime($originalDateStart);
    $date2 = new DateTime($now);

    $days  = $date1->diff($date2)->format('%a');
    return $days;
}


function someDateGetPlanDayNumber($date, $date2)
{

    // echo '<pre>';
    // print_r($_SESSION);

    // $me = array();
    // $me = json_decode($_SESSION['loggedAdmin']['me'], true);

    //print_r($me['plano']);

    $originalDateStart =  $date;
    $now = $date2;

    //echo $originalDateStart;

    $date1 = new DateTime($originalDateStart);
    $date2 = new DateTime($now);

    $days  = $date1->diff($date2)->format('%a');
    return $days;
}


function sizeOfActualPlanInDays()
{

    $me = array();
    $me = $planoArray = json_decode($_SESSION['loggedAdmin']['me'], true);
    $originalDateStart =  $me['dataPlanoInicio'];
    $originalDateFinishes =  $me['dataPlanoFinaliza'];

    $date1 = new DateTime($originalDateStart);
    $date2 = new DateTime($originalDateFinishes);

    $days  = $date1->diff($date2)->format('%a');
    return $days;
}


function generateOrderList($ingredientsIds)
{
    //echo $ingredientsIds;
    //$ingredientsIds = "351";

    $periods      = HTTPRequester::HTTPGet(API_URL . "Receitas/indexIngredients/" . $ingredientsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
    $periodsArray = json_decode((string)$periods, true);
    $orderList    = array();
    $salvaMedidas = array();
    $salvaMedidasFinal = array();
    $salvaFormato = array();
    $formato = array();
    $pesoAprox = array();

    // echo '<pre>';
    // print_r($periodsArray['success']);

    for ($x = 0; $x < count($periodsArray['success']); $x++) {
        // inserts all ingredients into an array
        for ($z = 0; $z < count($periodsArray['success'][$x]['ingredientes']); $z++) {
            $orderList[] .= $periodsArray['success'][$x]['ingredientes'][$z][0]['nome'];
            $medidas = json_decode($periodsArray['success'][$x]['medidas'], true);
            $pesoAprox[] .= $periodsArray['success'][$x]['ingredientes'][$z][0]['pesoAprox'];
        }

        // inserts all measures into an array
        for ($v = 0; $v < count($medidas); $v++) {
            $salvaMedidas[] .= $medidas[$v];
        }

//////////////////////////////////////////////////////////////////////////////////
//////////  novo aqui, substituir qnd chegar layout //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

        // salva formato, mas tem que ter o mesmo numero de posições dos demais, caso não, ele ajusta aqui
        if (isset($periodsArray['success'][$x]['formato'])) {
            $formato = json_decode($periodsArray['success'][$x]['formato'], true);
            for ($v = 0; $v < count($medidas); $v++) {
                $salvaFormato[] .= isset($formato[$v])?$formato[$v]:'';
            }
        } else {
            // cria posição falsa para o futuro
            for ($v = 0; $v < count($medidas); $v++) {
                $salvaFormato[] .= "";
            }
        }
    }

    // echo '<pre>';
    //  print_r($orderList);
    //  print_r($salvaMedidas);
    //  print_r($formato);

    // agora vou fazer o formato se transformar em peso(g)
    for ($v = 0; $v < count($salvaMedidas); $v++) {
        if (strlen($salvaFormato[$v]) > 0) {
            $salvaMedidasFinal[] .= formatoCalcs($salvaFormato[$v], $salvaMedidas[$v],$pesoAprox[$v]);
        } else {
            $salvaMedidasFinal[] .= $salvaMedidas[$v];
        }
    }
    
    // usar esa variavel para seguir
    $salvaMedidas =  $salvaMedidasFinal;
    

    // print_r($salvaMedidas);
    // echo 'oioioioi';
    // print_r($pesoAprox);

//////////////////////////////////////////////////////////////////////////////////
//////////  novo termina aqui, substituir qnd chegar layout //////////////////////
//////////////////////////////////////////////////////////////////////////////////    

    // Unique ingredients
    $unique = array_unique($orderList);

    // Duplicates ingredients
    $duplicates = array_diff_assoc($orderList, $unique);

    // add duplicated measures to unique ingredients so no dups are left
    foreach ($unique as $key => $value) {
        foreach ($duplicates as $key2 => $value2) {
            if ($value == $value2) {
                // echo $value.' igual '.$value2;
                // echo ' a id do original e: '.$key;
                // echo 'a medida a ser somada e '.$salvaMedidas[$key2].' key '.$key2.'<br>';
                $salvaMedidas[$key] = (int)$salvaMedidas[$key] + (int)$salvaMedidas[$key2];
            }
        }
    }

    // remove duplicateds from measures array
    foreach ($duplicates as $key => $value) {
        unset($salvaMedidas[$key]);
    }

    // reorder ingredients and measures arrays, ready to use in order/cart modal
    $orderIngredientsFinals = array_values($unique);
    $orderMeasuresFinals = array_values($salvaMedidas);
    $ordersCartCountBadge = count($orderIngredientsFinals);
    $result = array();
    $result[] = $orderIngredientsFinals;
    $result[] = $orderMeasuresFinals;
    $result[] = $ordersCartCountBadge;

    return  $result;
}




function formatoCalcs($operation, $value, $pesoAprox)
{

    switch ($operation) {
        case 'grama(s)':
            return (int)$value;
            break;
        case 'unidade(s)':
            return ((int)$value * (int)$pesoAprox);
            break;
        case '1/2':
            return ((int)$pesoAprox) / 2;
            break;
        case '1/3':
            return ((int)$pesoAprox) / 3;
            break;
        case '1/4':
            return ((int)$pesoAprox) / 4;
            break;
        case '2/4':
            return ((int)$pesoAprox) / 2;
            break;
        case '3/4':
            return (((int)$pesoAprox) * 3) / 4;
            break;
    }
}









// Function to get the client IP address
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}




function categoriasIngredientes($nome)
{
    // finds actual time/hour
    switch ($nome) {
        case 1:
            return  "laticinios";
            break;
        case 2:
            return "carne vermelha";
            break;
        case 3:
            return "frutas";
            break;
        case 4:
            return "legumes/verduras";
            break;
        case 5:
            return "sementes";
            break;
        case 6:
            return "oleaginosos";
            break;
        case 7:
            return "temperos";
            break;
        case 8:
            return "carne branca";
            break;
        case 9:
            return "cogumelos/fungos";
            break;
        case 10:
            return "farinaceos";
            break;
        case 11:
            return "quimicos";
            break;
        case 12:
            return "graos";
            break;
        case 13:
            return "adocantes";
            break;
    }
}
