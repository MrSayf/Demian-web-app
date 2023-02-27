<?php

function idParaMedida($value, $idBuscar){
	$resu = array_search($idBuscar, array_column($value, 'id'));
	return $resu;
}


function idParaIngrediente($value, $idBuscar){
	$resu = array_search($idBuscar, array_column($value, 'id'));
	return $resu;
}

// returns token
function LoginLaravelApi($apiUrl, $email, $senha ){
    $loginResponse  = HTTPRequester::HTTPPostLogin($apiUrl."auth/login/", array(
        "email" => $email,
        "password" => $senha
    ));
    $loginResponseFinais = json_decode((string)$loginResponse, true);

	if(isset($loginResponseFinais['access_token'])){
		return $loginResponseFinais['access_token'];
	}else{
		return $loginResponseFinais['error'];
	}
}





function deleteData($apiUrl, $row, $id, $token){
	$loginResponse  = HTTPRequester::HTTPDelete($apiUrl.$row."/destroy/".$id, array(), $token);
}


function receitaHorario($entrada){

	switch ($entrada) {
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



function logoutTotal(){

	// delete token from laravel api
	// HTTPRequester::HTTPLogoutLaravelApi($_SESSION['loggedAdmin']['token'], API_URL);

	// // remove sessions from user
	// unset($_SESSION);
	// session_destroy();
	// unset($_COOKIE);
	// setcookie('uidck',  '0', -3600, '/');

	// // redirect to login page
	// header("location: login.php");
	//die;
}
