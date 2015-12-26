<?php
/***********************************************************************************************
 *   apiCOMMON.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function APP_login
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_login($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $usuario   = trim($paramPOST['usuario']);
  $senha     = trim($paramPOST['senha']);
  $app       = trim($paramPOST['app']);

  $msg       = "";
  $code      = 0;

  // Parametro Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - APP_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Valida se tem conteudo
  if( (hasContent($usuario) == 0) || (hasContent($senha) == 0)) {
    auditoriaLog('APP_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);
    returnJson(-1,'Usuário ou Senha devem tem conteúdo');
  }

  if(hasContent($app) == 0) {
    returnJson(-1, "Deve ser informado qual APP está sendo executada.");
  }

  if(hasContent($device) == 0 ) {
    returnJson(-1, "Tentativa de acesso não autorizado.");
  }

  // Pesquisa o usuario e senha
  $sql = "SELECT * ";
  $sql = $sql . "FROM colaborador  ";
  $sql = $sql . "WHERE upper(login) = upper('$usuario')  ";
  $sql = $sql . "AND upper(senha) = upper('$senha')  ";
  $sql = $sql . "AND ativo = 'S'  ";
  $sql = $sql . "LIMIT 1; ";

  $login = query($sql);

  // Valida se o login/senha estao corretos
  if(sizeof($login) == 0) {
    returnJson(-1, "Usuário ou Senha não conferem.");
  }

  /*$sql = "SELECT * ";
  $sql = $sql . "FROM (SELECT ap.id_aplicacao FROM aplicacao ap WHERE upper(ap.aplicacao) LIKE upper('%$app%')) apl, ";
  $sql = $sql . "colaborador_aplicacao ca ";
  $sql = $sql . "LEFT JOIN colaborador co ";
  $sql = $sql . "ON ca.id_colaborador = co.id_colaborador ";
  $sql = $sql . "WHERE upper(ca.id_aplicacao) = upper(apl.id_aplicacao) ";
  $sql = $sql . "AND upper(co.login) = upper('$usuario') ";
  $sql = $sql . "AND upper(co.senha) = upper('$senha'); ";*/
  // alterado por Suzane Machado -> alteracao: coringa(%) app + insercao id_grupo


  $sql = "SELECT *  ";
  $sql = $sql . "FROM (SELECT ap.id_aplicacao FROM aplicacao ap WHERE upper(ap.aplicacao) LIKE upper('$app%')) apl,  ";
  $sql = $sql . "colaborador_aplicacao ";
  $sql = $sql . "LEFT JOIN (colaborador JOIN (concessionaria JOIN grupo ON concessionaria.id_grupo_financeiro=grupo.id_grupo)  ";
  $sql = $sql . "ON colaborador.id_concessionaria=concessionaria.id_concessionaria)  ";
  $sql = $sql . "ON colaborador_aplicacao.id_colaborador = colaborador.id_colaborador  ";
  $sql = $sql . "WHERE upper(colaborador_aplicacao.id_aplicacao) = upper(apl.id_aplicacao)  ";
  $sql = $sql . "AND upper(colaborador.login) = upper('$usuario')  ";
  $sql = $sql . "AND upper(colaborador.senha) = upper('$senha'); ";

  // SELECT *
  // FROM (SELECT ap.id_aplicacao FROM aplicacao ap WHERE upper(ap.aplicacao) LIKE upper('crm%')) apl,
  // colaborador_aplicacao
  // LEFT JOIN (colaborador JOIN (concessionaria JOIN grupo ON concessionaria.id_grupo_financeiro=grupo.id_grupo)
  // ON colaborador.id_concessionaria=concessionaria.id_concessionaria)
  // ON colaborador_aplicacao.id_colaborador = colaborador.id_colaborador
  // WHERE upper(colaborador_aplicacao.id_aplicacao) = upper(apl.id_aplicacao)
  // AND upper(colaborador.login) = upper('waldir')
  // AND upper(colaborador.senha) = upper('con');
  // -- id_cargo = 3 gerente que ve todas as informacoes do grupo

  //returnJson(-1, $sql);

  $login = query($sql);

  // Valida se o usuario tem acesso a APP
  if(sizeof($login) == 0) {
    returnJson(-1, "Usuário não tem autorização para acessar esta aplicação.");
  }

  auditoriaLog('APP_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Valida se retornou 1 usuario encontrado
  if ((isset($login)) && (sizeof($login) == 1)) {

    $dbdevice = trim($login[0]['device']);

    // Valida se ja não esta logado
    if(hasContent($dbdevice) == 0) {

      // Cria a tabela de controle para os deltas dos regitros
      APP_create_table_control($device);

      $msg = "Autenticação efetuada com sucesso.";
    } else {
      if($device == $dbdevice) {
        $msg = "Reautenticação no mesmo iPad realizada com sucesso.";
      } else {
        $msg = "Atenção, seu login está ativo em outro iPad. Solicite seu desbloqueio.";
      }
    }

    // Atualiza informacao que logou na aplicacao
    $sql = "UPDATE colaborador ";
    $sql = $sql . "SET data_hora_login = CURRENT_TIMESTAMP(), ";
    $sql = $sql . "device = '$device', ip_ipad = '$ipAddress' ";
    $sql = $sql . "WHERE login = '$usuario'";

    // returnJson(-1, $sql);
    $update = query($sql);

    if ($update['error']) {
      $code = -1;
      $msg = "Erro ao liberar login.";
    }

    returnJson(0, $msg, $login);

  }

}

/*
 * @function atualizaColaboradorLogin
 * @parameter $_POST, $_REMOTE
 *
 */
function atualizaColaboradorLogin() {
  $sql = "UPDATE colaborador ";
  $sql = $sql . "SET data_hora_login = CURRENT_TIMESTAMP(), ";
  $sql = $sql . "device = '$device', ip_ipad = '$ipAddress' ";
  $sql = $sql . "WHERE login = '$usuario'";

  $update = query($sql);

  if (!$update['error']) {
    returnJson(100,'Autenticado com sucesso.', $login);
  }
}

/*
 * @function APP_logout
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_logout($paramPOST, $paramREMOTE) {

  // Parametros Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - APP_logout()',$sql,$device,$login,$nome_completo,$ipaddress);

  $sql = "SELECT * FROM colaborador WHERE device = '$device' LIMIT 1";

  $logout = query($sql);

  if ((isset($logout)) && (sizeof($logout) == 1)) {
    $sql = "UPDATE colaborador SET device = NULL, ip_ipad = NULL, data_hora_login = NULL, data_hora_logout = CURRENT_TIMESTAMP() WHERE device  = '$device'";
    $logout = query($sql);

    if (!$logout['error']) {
      auditoriaLog('APP_logout() - Deslogado com sucesso.',$sql,$device,$login,$nome_completo,$ipaddress);
      returnJson(0,'Deslogado com sucesso.');
    } else {
      auditoriaLog('APP_logout() - Erro ao efetuar o logout.',$sql,$device,$login,$nome_completo,$ipaddress);
      returnJson(-1,'Erro ao efeturar Logout.');
    }
  } else {
    auditoriaLog('APP_logout() - Usuario não esta logado para efetuar logout.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Usuario já encontra-se deslogado.');
  }

  $_SESSION = array();
  session_destroy();
}


/*
 * @function APP_cargo
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_cargo($paramPOST, $paramREMOTE) {

  $sql  = "SELECT * FROM cargo ORDER BY cargo ASC;";

  auditoriaLog('Begin - APP_cargo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $cargo = query($sql);

  if(!$cargo['error']) {
    returnJson(0,'Sucesso',$cargo);
  }

}

/*
 * @function APP_busca_id
 * @parameter $paramREMOTE, $source
 *
 */
function APP_busca_id($paramREMOTE, $source) {

  $criterio  = $paramREMOTE['criterio'];

  // Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  if ($criterio == "contato") {
    $id  = $paramREMOTE['id_contato'];
    $sql = "SELECT * FROM contato WHERE id_contato = $id;";

  } else {
    $id  = $paramREMOTE['id_cliente'];
    $sql = "SELECT * FROM cliente WHERE id_cliente = $id;";

  }

  auditoriaLog('Begin - APP_busca_id()',$sql,$device,$login,$nome_completo,$ipaddress);

  $search = query($sql);

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    returnJson(0,'Sucesso',$search);
  } else {
    returnJson(-1, "Não encontrado ninguem.", $search);
  }

}

/*
 * @function APP_online
 * @parameter $paramREMOTE, $source
 *
 */
function APP_online($paramREMOTE, $source) {

  $online  = $paramREMOTE['online'];

  // Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - APP_online()',$sql,$device,$login,$nome_completo,$ipaddress);

  // sleep(10000);

  // se retornou 1 usuario encontrado
  returnJson(0, 'Pollo');

}

/*
 * @function APP_grupo
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_grupo($paramPOST, $paramREMOTE) {

  // Parametro Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - APP_grupo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Pesquisa o usuario e senha
  // $sql = "SELECT * ";
  // $sql = $sql . "FROM grupo_financeiro  ";
  // $sql = $sql . "ORDER BY grupo ;  ";

  $sql = "CALL grupo(); ";

  $grupo = query($sql);

  returnJson(0, "Sucesso", $grupo);

}

/*
 * @function APP_lab
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_lab($paramPOST, $paramREMOTE) {

  // Parametro Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - APP_lab()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $sql = "CALL test_proc(1, 2, 3, @sum, @product, @average); ";
  $grupo = query($sql);

  $sql = "SELECT @sum AS soma, @product AS produto, @average AS media; ";
  $media = query($sql);

  returnJson(0, "SOMA: " . $media['soma']);

}

/*
 * @function APP_grava_acao
 * @parameter $tela, $data_ini, $data_fin, $device
 *
 */
// function APP_grava_acao($tela, $data_ini="", $data_fin="", $device) {
function APP_grava_acao($tela, $device) {

  // Parametro Padrao
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $colab = APP_recupera_colaborador($device);
  $id_colaborador = $colab[0]['id_colaborador'];
  $nome_cracha    = $colab[0]['nome_cracha'];

  $sql = "INSERT INTO acao (tela, id_colaborador, device, colaborador) ";
  $sql = $sql . "VALUES ";
  $sql = $sql . "('$tela', $id_colaborador, '$device', '$nome_cracha'); ";

  // returnJson(-1, $sql);

  $acao = query($sql);

  auditoriaLog('Begin - APP_lab()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $acao = query($sql);

}

/*
 * @function APP_recupera_colaborador
 * @parameter $device
 *
 */
function APP_recupera_colaborador($device) {

  // Parametro Padrao
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // $sql = "SELECT id_colaborador, nome_cracha, id_concessionaria FROM colaborador WHERE device = '$device'; ";

  $sql = "SELECT co.id_colaborador, ca.id_cargo, co.nome_cracha, co.id_concessionaria ";
  $sql = $sql . "FROM colaborador_aplicacao ca , colaborador co ";
  $sql = $sql . "WHERE ca.id_colaborador = co.id_colaborador ";
  $sql = $sql . "AND co.device = '$device'; ";


  // returnJson(-1, $sql);

  auditoriaLog('Begin - APP_recupera_colaborador()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  return $colaborador = query($sql);

}

/*
 * @function APP_recupera_colaborador
 * @parameter $device
 *
 */
function APP_recupera_cargo_colaborador($device) {

  // Parametro Padrao
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // $sql = "SELECT id_colaborador, nome_cracha, id_concessionaria FROM colaborador WHERE device = '$device'; ";

  $sql = "SELECT co.id_colaborador, ca.id_cargo, co.nome_cracha, co.id_concessionaria ";
  $sql = $sql . "FROM colaborador_aplicacao ca , colaborador co ";
  $sql = $sql . "WHERE ca.id_colaborador = co.id_colaborador ";
  $sql = $sql . "AND co.device = '$device' ";
  $sql = $sql . "AND ca.id_cargo = 3 ";
  $sql = $sql . "LIMIT 1; ";


  // returnJson(-1, $sql);

  auditoriaLog('Begin - APP_recupera_colaborador()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  return $colaborador = query($sql);

}

/*
 * @function CEP_pesquisa
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_remove_mascara_CPFCNPJ($cpf_cnpj) {

  return ereg_replace("[' '-./ t]",'',$cpf_cnpj);

}

/*
 * @function CEP_pesquisa
 * @parameter $_POST, $_REMOTE
 *
 */
function APP_monetario_to_banco($monetario) {

  return ereg_replace("[' ', t]",'.', ereg_replace("[' '. t]",'' ,$monetario1));

}


function formatarCPF_CNPJ($campo, $formatado = false){

  //retira formato
  $codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);

  // pega o tamanho da string menos os digitos verificadores
  $tamanho = (strlen($codigoLimpo) -2);

  //verifica se o tamanho do código informado é válido
  if ($tamanho != 9 && $tamanho != 12){
    return false;
  }

  if ($formatado){
    // seleciona a máscara para cpf ou cnpj
    $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

    $indice = -1;
    for ($i=0; $i < strlen($mascara); $i++) {
      if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
    }
    //retorna o campo formatado
    $retorno = $mascara;

  }else{
    //se não quer formatado, retorna o campo limpo
    $retorno = $codigoLimpo;
  }

  return $retorno;

}


/*
 * @function APP_create_table_control
 * @parameter $device
 *
 */
function APP_create_table_control($device) {

  $table  = 'TC_' . substr($device,0,8);

  // Insere na tabla controle
  $sql = "INSERT INTO colaborador_delta ";
  $sql = $sql . " (device,tabela) ";
  $sql = $sql . " VALUES ";
  $sql = $sql . " ('$device','$table');";

  // returnJson(-1, $sql);

  $insert = query($sql);

  // TEMPORARY
  $sql = " CREATE TABLE IF NOT EXISTS `volvoapp`.`$table` ( ";
  $sql = $sql . " `id_sequence` BIGINT NOT NULL AUTO_INCREMENT, ";
  $sql = $sql . "   `enviado` CHAR(1) NULL, ";
  $sql = $sql . "   `device` VARCHAR(100) NULL, ";
  $sql = $sql . "   `tabela` VARCHAR(100) NULL, ";
  $sql = $sql . "   `registro` BIGINT NULL, ";
  $sql = $sql . "   PRIMARY KEY (`id_sequence`)) ";
  $sql = $sql . " ENGINE = InnoDB; ";

  $create = query($sql);

}

/*
 * @function APP_insert_table_control
 * @parameter $device,$registroID,$origem
 *
 */
function APP_insert_table_control($device,$registroID,$origem) {

  $sql = "SELECT * FROM colaborador_delta WHERE upper(device) <> upper('$device'); ";
  $search = query($sql);

  if ((isset($search)) && (sizeof($search) >= 1)) {
    for($x=0; $x <= sizeof($search); $x++) {
      $tabela = trim($search[$x]['tabela']);
      $sql = "INSERT INTO $tabela (device, registro, tabela) VALUES ('$device',$registroID,'$origem');";

      // returnJson(-1, $sql);

      $insert = query($sql);
    }
  }

}

/*
 * @function APP_envia_delta
 * @parameter $device, $origem
 *
 */
function APP_envia_delta($paramPOST, $paramREMOTE) {

  $device = $paramPOST['device'];
  $origem = $paramPOST['origem'];

  // localiza a tabela controle do device informado TC_xxxxxx
  $sql = "SELECT * FROM colaborador_delta WHERE upper(device) <> upper('$device'); ";
  $search = query($sql);

  $tabela = $search[0]['tabela'];

  $sql = "SELECT registro FROM $tabela WHERE tabela = '$origem' AND enviado IS NULL; ";

  // returnJson(-1, $sql);

  $delta = query($sql);

  // marca o registro como enviado
  for($x=0; $x <= sizeof($delta); $x++) {
    $sql = "UPDATE $tabela SET enviado = 'S' WHERE registro = " . $delta[$x]['registro'] . "; ";

    // returnJson(-1, $sql);

    $update = query($sql);
  }

  returnJson(0, "Deltas", $delta);

}

/*
 * @function APP_envia_delta
 * @parameter $device, $origem
 *
 */
// function APP_assina($_FILES, $_SERVER) {

//   $fileTmpLoc = $_FILES["file"]["tmp_name"];
//   $fileName   = $_FILES["file"]["name"];

//   // Path and file name - (chmod 777 assinaturas/)
//   $pathAndName = "./assinaturas/".$fileName;

//   // Run the move_uploaded_file() function here
//   if (!move_uploaded_file($fileTmpLoc, $pathAndName)) {
//     echo "Error salvando assinatura. - FILE_NAME: " . $fileName ;
//     exit(-1);
//   }

//   echo "Sucesso - Salvo em: " . $pathAndName;
// }
