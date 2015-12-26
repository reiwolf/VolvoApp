<?php
/*
 * @function VIKING_cliente_grava
 * @parameter $_POST, $_REMOTE
 *
 */

print_r($_POST);
  // Recupera os dados
  $nome                     = $_POST['nome'];
  $telefone                 = $_POST['telefone'];
  $email                    = $_POST['email'];

  // Padrao
  $device                   = trim($_POST['device']);
  $ipaddress                = $_SERVER['REMOTE_ADDR'];

  $origem                   = "V";
  
  //auditoriaLog('Begin - VIKING_cliente_grava()',$sql,$device,$nome,$ipaddress);

  // Valida se o nome esta sem conteudo
  //if(hasContent($nome) == 0) {
    //returnJson(-1,"Nome do cliente deve ter conteúdo. Gravação cancelada.");
  //}

  $sql = "INSERT INTO cliente ";
  $sql = $sql . "(nome, telefone, email, origem)";
  $sql = $sql . " VALUES ";
  $sql = $sql . "('$nome','$telefone','$email','$origem');";
  echo $sql;
  //$save = query($sql);

  if (!$save['error']) {
    //auditoriaLog('VIKING_cliente_grava() - Cliente salvo com sucesso',$sql,$device,$login,$nome,$ipaddress);
    //returnJson(0,'Cliente salvo com sucesso.', $data);
  } else {
    //auditoriaLog('VIKING_cliente_grava() - Erro ao salvar cliente.',$sql,$device,$login,$nome,$ipaddress);
    //returnJson(-1,'Erro ao salvar cliente.');
  }




