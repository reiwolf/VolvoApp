<?php
//
//phpinfo();

@include        ("include/nocache.inc.php");
@require_once   ("include/debug.inc.php");

//$data = file_get_contents("php://input");
//$objData = json_decode($data);

$objData = $_REQUEST[''];

// Action recebe a acao que sera executada
switch($objData->action) {
  case 'login':
    login( $objData );
    break;
  case 'sync_cliente':
    syncCliente();
    break;
  case 'sync_pedidos':
    syncPedidos();
    break;
	case 'save':
		doSave( $objData );
		break;
	case 'search':
		doSearch();
		break;
	case 'find':
		findByCode();
		break;
	case 'delete':
		delete();
		break;

	default:
}

function login( $objData ) {

  @require_once ("include/functions.inc.php");
  @require_once ("include/config.inc.php");

  $usuario = $objData->usuario;
  $senha   = $objData->senha;

  // captura dados do usuario chamador
  $ip   = $_SERVER['REMOTE_ADDR'];
  $data =   date('Y-m-d');
  $hora =   date('H:i:s');

  $sql = "SELECT * FROM colaborador WHERE login = '$usuario' AND senha = '$senha'";

  $DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
  mysql_select_db($DBname, $DBconn);
  $result = mysql_query($sql, $DBconn);

  if(mysql_affected_rows() == 1) {
      echo json_encode(array('status' => 1));
  } else {
      echo json_encode(array('status' => 0, 'msg' => 'Usuário ou Senha inexistentes.'));
  }

}

function gravaAuditoria() {

}

function syncPedidos() {

}

function syncCliente() {

}

function doSave($objData){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$nome 	= $objData->nome;
	$cpf 		= $objData->cpf;
	$id 		= $objData->id;

  // captura dados do usuario chamador
	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data	= 	date('Y-m-d');
	$hora	= 	date('H:i:s');

//	if($id == null) {
		$sql  = "INSERT INTO `tablepoc` (vendedor_id, nome, cpf_cnpj) VALUES ('$id', '$nome', '$cpf') ";
//	}else {
// 		$sql  = "UPDATE `tablepoc` SET nome = '$nome', cpf = '$cpf', percent = '$percent' WHERE id = '$id'";
//	}

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);

	if(mysql_affected_rows() == 1) {
		echo json_encode(
			array('status' => 100)
		);
	} else {
		echo json_encode(array(
			'status' => 110,
			utf8_encode('msg')	=> 'Erro ao gravar no banco e dados.'
		));
		exit;
	}
}


function delete(){

/*
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$nome 	= $_REQUEST['nome'];
	$cpf 		= $_REQUEST['cpf'];
	$id 		= $_REQUEST['id'];

	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data		= 	date('Y-m-d');
	$hora		= 	date('H:i:s');

	$sql  = "SELECT atendente FROM `serviceorder` WHERE motorista = '$id'";

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);

	if(mysql_affected_rows() >= 1) {
		echo json_encode(array('status' => 300));
	} else {
		$sql  = "DELETE FROM `motorista` WHERE id = '$id'";

		// open connection to MySQL-server
		$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
		// select active database
		mysql_select_db($DBname, $DBconn);
		// use SQL query
		$result = mysql_query($sql, $DBconn);

		if(mysql_affected_rows() == 1) {
			echo json_encode(array('status' => 0));
		} else {
			echo json_encode(array(
				'status' => 200,
				utf8_encode('msg')	=> 'ERRO: ao apagar registro do MOTORISTA.'
			));
			exit;
		}

	}
*/
}

function getAll(){
/*
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');

	// validate Login
	$sql  = "SELECT * FROM `motorista` ";

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);

	// select active database
	mysql_select_db($DBname, $DBconn);

	// use SQL query
	$result = mysql_query($sql, $DBconn);

	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}

	echo json_encode($return);
*/
}

function doSearch(){
/*
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');

	// recover parameter
	$nome = $_REQUEST['nome'];

	if(isset($nome)){
		$sql  = "SELECT * FROM `motorista` WHERE LOWER(nome) LIKE LOWER('%$nome%')";
	} else {
		$sql  = "SELECT * FROM `motorista`";
	}

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);

	// select active database
	mysql_select_db($DBname, $DBconn);

	// use SQL query
	$result = mysql_query($sql, $DBconn);

	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}

	echo json_encode($return);

}

function findByCode(){
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');

	// recover parameter
	$id = $_REQUEST['id'];

	$sql  = "SELECT * FROM `motorista` WHERE id = '$id'";

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);

	// select active database
	mysql_select_db($DBname, $DBconn);

	// use SQL query
	$result = mysql_query($sql, $DBconn);

	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}

	echo json_encode($return);
*/
}

