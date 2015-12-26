<?php
/***********************************************************************************************
 *   lib.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function query
 * @parameter $_POST, $_REMOTE
 *
 */
function query($sql) {

  // setup db connection
  // $link = mysqli_connect("127.0.0.1", "projeto", "*senha@", "volvoapp");
  $link = mysqli_connect("127.0.0.1", "root", "root", "volvoapp");
  // $link = mysqli_connect("192.168.25.116", "root", "root", "volvoapp");
  // $link = mysqli_connect("186.202.152.111", "site13785927871", "area37@", "site13785927871");

  if (mysqli_connect_errno()) {
    return array('error'=>'Erro de conexão com o banco de dados %s' . mysqli_connect_error());
    exit();
  }

  //get the sql query
  // $args = func_get_args();
  // $sql = array_shift($args);

  // //secure the input
  // for ($i=0;$i<count($args);$i++) {
  //  $args[$i] = urldecode($args[$i]);
  //  $args[$i] = mysqli_real_escape_string($link, $args[$i]);
  // }

  // //build the final query
  // $sql = vsprintf($sql, $args);

  //execute and fetch the results

  // mysqli_set_charset($link, 'utf8');
  // mysqli_query($link, "SET NAMES 'utf8';");
  // mysqli_query($link, "SET CHARACTER SET 'utf8';");
  // mysqli_query($link, "SET COLLATION_CONNECTION = 'utf8_unicode_ci';");

  $result = mysqli_query($link, $sql);
  $newid  = mysqli_insert_id($link);

  // returnJson(-99,$newid . "SQL:" . $sql);

  if (mysqli_errno($link)==0 && $result) {

    $rows = array();

    if ($result!==true)
    while ($content = mysqli_fetch_assoc($result)) {
      $content = array_map('utf8_encode', $content);
      // $content = htmlentities($content, "UTF-8");
      array_push($rows,$content);
    }

    //return json
    // $ret = array('data'=>$rows);
    if($newid != 0) {
      $rows = array('newid'=>$newid);
    }

    $ret = $rows;

  } else {
    //error
    $ret = array('error'=>'Erro executando Instrução SQL: ' . $result );
  }

  mysqli_close ($link);

  return $ret;

}
//  else {
//   // returnJson(-99, mysqli_errno($link) );

// }

/*
 * @function auditoriaLog
 * @parameter $acao,$comando,$device,$login,$nome_completo,$ipaddress
 *
 */
function auditoriaLog($acao,$comando,$device,$login,$nome_completo,$ipaddress,$tela="") {
  $acao          = toUTF8($acao);
  $nome_completo = addslashes(toUTF8($nome_completo));
  $comando       = addslashes($comando);

  $sql = "SELECT nome FROM colaborador WHERE device = '$device'";
  $pesq = query($sql);

  // if(sizeof($pesq) > 0){
  //   $sql = "INSERT INTO auditoria ";
  //   $sql = $sql . " (acao,comando,device,login,nome_completo,ipaddress,tela,id_colaborador) ";
  //   $sql = $sql . " VALUES ";
  //   $sql = $sql . " ('$acao','$comando','$device','$login','$nome_completo','$ipaddress','$tela',$pesq[0][id_colaborador]); ";
  // }else{
    $sql = "INSERT INTO auditoria ";
    $sql = $sql . " (acao,comando,device,login,nome_completo,ipaddress) ";
    $sql = $sql . " VALUES ";
    $sql = $sql . " ('$acao','$comando','$device','$login','$nome_completo','$ipaddress'); ";
  // }

  $audit = query($sql);
}

/*
 * @function isValidSession
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function isValidSession($paramPOST, $paramREMOTE) {

  $device = $paramPOST["device"];
  $action = $paramPOST["action"];

  if($action <> "APP_login" && $action <> "APP_logout" && substr($action,0,4) <> "DASH" && substr($action,0,2) <> "PM") {

    $sql = "SELECT * FROM colaborador WHERE device = '$device';";

    // returnJson(-1, $sql);

    $sessao = query($sql);

    if((isset($sessao)) && (sizeof($sessao) == 0)) {
      returnJson(-1, "Atenção, sua conexão não é mais válida.", array(array('killall'=>-1)));
    }
  }
}

/*
 * @function acaoLog
 * @parameter $tela, $device, $data_hora_ini, $data_hora_fim, $id_cliente
 *
 */
function acaoLog($tela, $device, $data_hora_ini, $data_hora_fim, $id_cliente) {

  $sql   = "SELECT * FROM colaborador WHERE device = '$device';";

  $colab = query($sql);

  $sql = "INSERT INTO acao ";
  $sql = $sql . "(tela, id_colaborador, colaborador, device, data_hora_ini, data_hora_fim, id_cliente) ";
  $sql = $sql . "VALUES ";
  $sql = $sql . "('$tela', $colab[0][id_colaborador], '$colab[0][colaborador]', '$device', '$data_hora_ini', '$data_hora_fim', $id_cliente) ";

  $acao = query($sql);

  // Atualiza o lap time
  $sql = "UPDATE acao SET lap_time = (data_hora_fim - data_hora_ini) WHERE lap_time IS NULL;";

  $laptime = query($sql);

}
