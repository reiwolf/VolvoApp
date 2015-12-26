<?php
/***********************************************************************************************
 *   api.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

// helper function, which outputs error messages in JSON format
function errorJson($code, $msg='', $data=array()) {
  $msg = toUTF8($msg);

  header("Content-Type: application/json; charset=utf-8");
	print json_encode(array(array('code'=>$code, 'message'=>$msg, 'data'=>$data)));
	exit();
}

function returnJson($code, $msg='', $data=array()) {
  $msg = toUTF8($msg);

  header("Content-Type: application/json; charset=utf-8");
  print json_encode(array(array('code'=>$code, 'message'=>$msg, 'data'=>$data)));
}

// IORDER_login API
function IORDER_login($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $usuario   = trim($paramPOST['usuario']);
  $senha     = trim($paramPOST['senha']);
  $device    = trim($paramPOST['device']);
  $ipAddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('IORDER_login()','mac_address',$ipAddress,'serial_number','sql','device',$usuario,'nome_cracha');

  // Valida se tem conteudo
  if((strlen($usuario) == 0) || (strlen($senha) == 0)) {
    auditoriaLog('IORDER_login() - Usuario ou Senha devem tem conteudo','mac_address',$ipAddress,'serial_number','sql','device',$usuario,'nome_cracha');
    errorJson(-1,'Usuario ou Senha devem tem conteúdo');
  }

  // Pesquisa o usuario e senha
  $login = query("SELECT * FROM colaborador WHERE login='%s' AND senha ='%s' LIMIT 1", $usuario, $senha);

  // // se retornou 1 usuario encontrado
  if ( count($login['result']) > 0 ) {

    $deviceSize = strlen(trim($login['result'][0]['device']));
    $nome      = trim($login['result'][0]['nome_completo']);
    $ipIpad    = trim($login['result'][0]['ip_ipad']);

    auditoriaLog('IORDER_login() - Usuario Apto a Logar.','mac_address',$ipAddress,'serial_number','sql','device',$usuario,'nome_cracha');

    // Verifica se ja esta logado
    if ( $deviceSize == 0 ) {
      // $device = $device; // md5(uniqid(rand(SID), true)) ;

      // retorna os pedidos com status de pendentes
      $totalPedidos = recuperaTotalPedidosPendentes($usuario, $ipAddress);

      // Retorna os dados do colaborador
      // $colaborador = array(
      //   'nome_completo'=>$login['result'][0]['nome_completo'],
      //   'rg'=>$login['result'][0]['rg'],
      //   'cargo'=>$login['result'][0]['cargo'],
      //   'device'=>$device,
      //   'pedido_pendente'=>$totalPedidos,
      //   'pedidos'=>array()
      //   );

      // seta informacao que o usuario esta logado
      $result = query("UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipAddress' WHERE login = '$usuario'");

      if (!$result['error']) {
        auditoriaLog('IORDER_login() - Acesso Liberado.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        returnJson(100,'Autenticado com sucesso.', $login);
      }

    } else {

      if( $ipAddress == $ipIpad ) {
        auditoriaLog('IORDER_login() - Usuário logou no mesmo IPad.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        returnJson(101,'Atenção, voce esta logando novamente no mesmo IPad, seus dados serão atualizados.', $login);

      } else {
        auditoriaLog('IORDER_login() - Usuario Já está logado.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        errorJson(103,'Usurio: ' . $nome . ' já esta logado no Ipad com IP ' . $ipIpad );

      }

    }
  } else {
    auditoriaLog('IORDER_login() - Usuário ou senha não conferem.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
    errorJson(102,'Usuario ou Senha não Conferem.');
  }
}

// CRM_login API
function CRM_login($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $usuario   = trim($paramPOST['usuario']);
  $senha     = trim($paramPOST['senha']);
  $device    = trim($paramPOST['device']);
  $ipAddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('CRM_login()','mac_address',$ipAddress,'mac_address','sql','device',$usuario,'nome_cracha');

  // Valida se tem conteudo
  if((strlen($usuario) == 0) || (strlen($senha) == 0)) {
    auditoriaLog('CRM_login() - Usuario ou Senha devem tem conteudo','mac_address',$ipAddress,'serial_number','sql','device',$usuario,'nome_cracha');
    errorJson(-1,'Usuario ou Senha devem tem conteúdo');
  }

  // Pesquisa o usuario e senha
  $login = query("SELECT nome_completo,nome_cracha,rg,cargo,device FROM colaborador WHERE login='%s' AND senha ='%s' LIMIT 1", $usuario, $senha);

  // // se retornou 1 usuario encontrado
  if (count($login['result']) > 0) {

    $deviceSize = strlen(trim($login['result'][0]['device']));
    $nome      = trim($login['result'][0]['nome_completo']);
    $ipIpad    = trim($login['result'][0]['ip_ipad']);

    auditoriaLog('CRM_login() - Usuario Apto a Logar.','mac_address',$ipAddress,'serial_number','sql','device',$usuario,'nome_cracha');

    // Verifica se ja esta logado
    if ($deviceSize == 0) {
      // $device = $device;

      // retorna os pedidos com status de pendentes
      $totalPedidos = recuperaTotalPedidosPendentes($usuario, $ipAddress);

      // Retorna os dados do colaborador
      $colaborador = $login;

      // $colaborador = array (
      //   'nome'=>$login['result'][0]['nome_completo'],
      //   'cracha'=>$login['result'][0]['nome_cracha'],
      //   'rg'=>$login['result'][0]['rg'],
      //   'cargo'=>$login['result'][0]['cargo']
      //   );

      // seta informacao que o usuario esta logado
      $result = query("UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipAddress' WHERE login = '$usuario'");

      if (!$result['error']) {
        auditoriaLog('CRM_login() - Acesso Liberado.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        returnJson(100,'Autenticado com sucesso.', $login);
      }
    } else {
      if( $ipAddress == $ipIpad ) {
        auditoriaLog('CRM_login() - Usuário logou no mesmo IPad.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        returnJson(101,'Atenção, voce esta logando novamente no mesmo IPad, seus dados serão atualizados.', $login);

      } else {
        auditoriaLog('CRM_login() - Usuario Já está logado.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
        errorJson(103,'Usurio: ' . $nome . ' já esta logado no Ipad com IP ' . $ipIpad, $login );
      }
    }
  } else {
    auditoriaLog('CRM_login() - Usuário ou senha não conferem.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
    errorJson(102,'Usuario ou Senha não Conferem.');
  }
}

// IORDER_logout API
function IORDER_logout($paramPOST, $paramREMOTE) {
  $device     = trim($paramPOST['device']);
  $ipAddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('IORDER_logout() - Solicitado logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
  $logout = query("SELECT * FROM colaborador WHERE device = '%s' LIMIT 1", $device);

  if ( count($logout['result']) > 0 ) {
    $logout = query("UPDATE colaborador SET device = null, ip_ipad = null, data_hora_login = null, data_hora_logout = CURRENT_TIMESTAMP() WHERE device  = '%s'", $device);

    if (!$logout['error']) {
      auditoriaLog('IORDER_logout() - Deslogado com sucesso.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
      returnJson(0,'Deslogado com sucesso.');
    } else {
      auditoriaLog('IORDER_logout() - Erro ao efetuar o logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
      errorJson(-1,'Erro ao efeturar Logout.');
    }
  } else {
      auditoriaLog('IORDER_logout() - Usuario não esta logado para efetuar logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
    errorJson(-1,'Usuario não esta logado para efetuar Logout.');
  }

  $_SESSION = array();
  session_destroy();
}

// CRM_logout API
function CRM_logout($paramPOST, $paramREMOTE) {
  $device     = trim($paramPOST['device']);
  $ipAddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('CRM_logout() - Solicitado logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
  $logout = query("SELECT * FROM colaborador WHERE device = '%s' LIMIT 1", $device);

  if ( count($logout['result']) > 0 ) {
    $logout = query("UPDATE colaborador SET device = null, ip_ipad = null, data_hora_login = null, data_hora_logout = CURRENT_TIMESTAMP() WHERE device  = '%s'", $device);

    if (!$logout['error']) {
      auditoriaLog('CRM_logout() - Deslogado com sucesso.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
      returnJson(0,'Deslogado com sucesso.');
    } else {
      auditoriaLog('CRM_logout() - Erro ao efetuar o logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
      errorJson(-1,'Erro ao efeturar Logout.');
    }
  } else {
      auditoriaLog('CRM_logout() - Usuario não esta logado para efetuar logout.','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
    errorJson(-1,'Usuario não esta logado para efetuar Logout.');
  }

  $_SESSION = array();
  session_destroy();
}

// recuperaTotalPedidosPendentes API
function recuperaTotalPedidosPendentes($usuario, $ipAddress) {
  $iorder = query("SELECT * FROM iorder WHERE login='%s' AND iorder_pendente ='F'", $usuario);
  $totalPedidos = count($iorder['result']);

  if( $totalPedidos == 0) {
    auditoriaLog('recuperaTotalPedidosPendentes() - Validando Pedidos Pendentes [' . $totalPedidos . '] .','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
  }

  return $totalPedidos;
}

// auditoriaLog API
function auditoriaLog($acao,$mac_address,$ip_address,$serial_number,$sql,$device,$login,$nome_cracha) {
  $acao = toUTF8($acao);
  $nome_cracha = toUTF8($nome_cracha);

  $audit = query("INSERT INTO auditoria (data_hora,acao,mac_address,ip_address,serial_number,comando,device,login,nome_cracha) VALUES (CURRENT_TIMESTAMP(),'%s','%s','%s','%s','%s','%s','%s','%s')",$acao,$mac_address,$ip_address,$serial_number,$sql,$device,$login,$nome_cracha);
}

// --------------------------------------------------------------------------------------------------------------

// register API
function register($user, $pass) {
	//check if username exists in the database (inside the "login" table)
	$login = query("SELECT username FROM login WHERE username='%s' limit 1", $user);

	if (count($login['result'])>0) {

		//the username exists, return error to the iPhone app
		errorJson('-1','Username already exists');
	}

	//try to insert a new row in the "login" table with the given username and password
	$result = query("INSERT INTO login(username, pass) VALUES('%s','%s')", $user, $pass);

	if (!$result['error']) {
		//registration is susccessfull, try to also directly login the new user
		login($user, $pass);
	} else {
		//for some database reason the registration is unsuccessfull
		errorJson('-1','Registration failed');
	}

}

//login API
function login2($user, $pass) {
	// try to match a row in the "login" table for the given username and password
	$result = query("SELECT IdUser, username FROM login WHERE username='%s' AND pass='%s' limit 1", $user, $pass);

	if (count($result['result'])>0) {
		// a row was found in the database for username/pass combination
		// save a simple flag in the user session, so the server remembers that the user is authorized
		$_SESSION['IdUser'] = $result['result'][0]['IdUser'];

		// print out the JSON of the user data to the iPhone app; it looks like this:
		// {IdUser:1, username: "Name"}
		print json_encode($result);
	} else {
		// no matching username/password was found in the login table
		errorJson('-1','Authorization failed');
	}

}

//upload API
function upload($id, $photoData, $title) {
	// index.php passes as first parameter to this function $_SESSION['IdUser']
	// $_SESSION['IdUser'] should contain the user id, if the user has already been authorized
	// remember? you store the user id there in the login function
	if (!$id) errorJson('Authorization required');

	// check if there was no error during the file upload
	if ($photoData['error']==0) {

		// insert the details about the photo to the "photos" table
		$result = query("INSERT INTO photos(IdUser,title) VALUES('%d','%s')", $id, $title);
		if (!$result['error']) {

			// fetch the active connection to the database (it's initialized automatically in lib.php)
			global $link;

			// get the last automatically generated ID in the photos table
			$IdPhoto = mysqli_insert_id($link);

			// move the temporarily stored file to a convenient location
			// your photo is automatically saved by PHP in a temp folder
			// you need to move it over yourself to your own "upload" folder
			if (move_uploaded_file($photoData['tmp_name'], "upload/".$IdPhoto.".jpg")) {

				// file moved, all good, generate thumbnail
				thumb("upload/".$IdPhoto.".jpg", 180);

				//just print out confirmation to the iPhone app
				print json_encode(array('successful'=>1));
			} else {
				//print out an error message to the iPhone app
				errorJson(-1,'Upload on server problem');
			};

		} else {
			errorJson(-1,'Upload database problem.'.$result['error']);
		}
	} else {
		errorJson(-1,'Upload malfunction');
	}
}

//stream API
//
// there are 2 ways to use the function:
// 1) don't pass any parameters - then the function will fetch all photos from the database
// 2) pass a photo id as a parameter - then the function will fetch the data of the requested photo
//
// Q: what "$IdPhoto=0" means? A: It's the PHP way to say "first param of the function is $IdPhoto,
// if there's no param sent to the function - initialize $IdPhoto with a default value of 0"
function stream($IdPhoto=0) {

	if ($IdPhoto==0) {
		// load the last 50 photos from the "photos" table, also join the "login" so that you can fetch the
		// usernames of the photos' authors
		$result = query("SELECT IdPhoto, title, l.IdUser, username FROM photos p JOIN login l ON (l.IdUser = p.IdUser) ORDER BY IdPhoto DESC LIMIT 50");

	} else {
		//do the same as above, but just for the photo with the given id
		$result = query("SELECT IdPhoto, title, l.IdUser, username FROM photos p JOIN login l ON (l.IdUser = p.IdUser) WHERE p.IdPhoto='%d' LIMIT 1", $IdPhoto);
	}

	if (!$result['error']) {
		// if no error occured, print out the JSON data of the
		// fetched photo data
		print json_encode($result);
	} else {
		//there was an error, print out to the iPhone app
		errorJson(-1,'Photo stream is broken');
	}
}

/*
//create json format text from posts
$json=array();
while($row=mysql_fetch_array($result)){
  $from=array(‘id’=>$row['user_id'],’name’=>$row['user_name']);
  $post=array(‘post_id’=>$row['post_id'],’from’=>$from,’post’=>$row['post'],’time’=>$row['time']);
  array_push($json,$post);
}

//display it to the user
header(‘Content-type: application/json’);
echo “{\”posts\”:”.json_encode($json).”}”;

*/
// end of xpto API

