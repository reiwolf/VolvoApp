<?php
/***********************************************************************************************
 *   apiCRM.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function CRM_login
 * @parameter $_POST, $_REMOTE
 *
 */
// function CRM_login($paramPOST, $paramREMOTE) {

//   // Recupera os dados
//   $usuario   = trimupper($paramPOST['usuario']);
//   $senha     = trimupper($paramPOST['senha']);
//   $device    = trim($paramPOST['device']);
//   $ipaddress = $paramREMOTE['REMOTE_ADDR'];

//   auditoriaLog('Begin - CRM_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//   // Valida se tem conteudo
//   if( (hasContent($usuario) == 0) || (hasContent($senha) == 0)) {
//     auditoriaLog('CRM_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);
//     returnJson(103,'Usuario ou Senha devem tem conteúdo');
//   }

//   // Pesquisa o usuario e senha
//   $sql = "SELECT * FROM colaborador ";
//   $sql = $sql . " WHERE upper(login) = upper('$usuario') ";
//   $sql = $sql . " AND upper(senha) = upper('$senha') ";
//   $sql = $sql . " LIMIT 1;";

//   $login = query($sql);

//   auditoriaLog('CRM_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//   // Valida se retornou 1 usuario encontrado
//   if ((isset($login))  && (sizeof($login) == 1)) {
//     $device     = trim($login[0]['device']);
//     $deviceSize = strlen(trim($login[0]['device']));
//     $nome      = trim($login[0]['nome_completo']);
//     $ipIpad    = trim($login[0]['ip_ipad']);

//     // Verifica se ja esta logado
//     if ($deviceSize == 0) {
//       // seta informacao que o usuario esta logado
//       $sql = "UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipaddress' WHERE login = '$usuario'";
//       $update = query($sql);

//       if (!$update['error']) {
//         // Cria a tabela temporaria para controle de atualizacao de registros
//         create_table_control($device);

//         auditoriaLog('CRM_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//         $sql = "SELECT * FROM colaborador ";
//         $sql = $sql . " WHERE upper(login) = upper('$usuario') ";
//         $sql = $sql . " AND upper(senha) = upper('$senha') LIMIT 1;";

//         $login = query($sql);

//         returnJson(100,'Autenticado com sucesso.', $login);

//       } else {
//         returnJson(-1,'Error ao atualizar login do usuario.');
//       }

//     } else {

//       // Verifica se esta com o mesmo device (mesmo ipad)
//       if($device == $device) {
//         $sql = "UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipaddress' WHERE login = '$usuario'";
//         $update = query($sql);

//         if (!$update['error']) {
//           returnJson(100,'Reautenticado com sucesso.', $login);
//         }

//       } else {
//         returnJson(-1, "Voce já esta logado em outro iPad.", $login);

//         $sql = "UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipaddress' WHERE login = '$usuario'";
//         $update = query($sql);

//         $sql = "SELECT * FROM colaborador ";
//         $sql = $sql . " WHERE upper(login) = upper('$usuario') ";
//         $sql = $sql . " AND upper(senha) = upper('$senha') LIMIT 1;";

//         $login = query($sql);

//         returnJson(104, "Voce já esta logado em outro iPad.", $login);
//       }

//     }
//   } else {
//     auditoriaLog('CRM_login() - Usuário ou senha não conferem',$sql,$device,$usuario,$nome_completo,$ipaddress);
//     returnJson(102,'Usuário ou Senha não Conferem');
//   }
// }

/*
 * @function CRM_logout
 * @parameter $_POST, $_REMOTE
 *
 */
// function CRM_logout($paramPOST, $paramREMOTE) {
//   $device    = trim($paramPOST['device']);
//   $ipaddress = $paramREMOTE['REMOTE_ADDR'];

//   auditoriaLog('Begin - CRM_logout()',$sql,$device,$login,$nome_completo,$ipaddress);

//   $sql = "SELECT * FROM colaborador WHERE device = '$device' LIMIT 1";

//   $logout = query($sql);

//   if ((isset($logout)) && (sizeof($logout) == 1)) {
//     $sql = "UPDATE colaborador SET device = NULL, ip_ipad = NULL, data_hora_login = NULL, data_hora_logout = CURRENT_TIMESTAMP() WHERE device  = '$device'";
//     $logout = query($sql);

//     if (!$logout['error']) {
//       auditoriaLog('CRM_logout() - Deslogado com sucesso.',$sql,$device,$login,$nome_completo,$ipaddress);
//       returnJson(0,'Deslogado com sucesso.');
//     } else {
//       auditoriaLog('CRM_logout() - Erro ao efetuar o logout.',$sql,$device,$login,$nome_completo,$ipaddress);
//       returnJson(-1,'Erro ao efeturar Logout.');
//     }
//   } else {
//     auditoriaLog('CRM_logout() - Usuario não esta logado para efetuar logout.',$sql,$device,$login,$nome_completo,$ipaddress);
//     returnJson(-1,'Usuario não esta logado para efetuar Logout.');
//   }

//   $_SESSION = array();
//   session_destroy();
// }

/*
 * @function CRM_cliente_busca
 * @parameter $_POST, $_REMOTE
 *
 */
function CRM_cliente_busca($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // Qual campo deve ser ordenado

  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $tela      = $paramPOST['tela'];
  $data_ini  = humanToMysql($paramPOST['data_ini']);
  $data_fin  = humanToMysql($paramPOST['data_fin']);

  // Paginacao para pesquisa retornar um volume menor
  $lim_ini   = $paramPOST['lim_ini'];
  $lim_qtd   = $paramPOST['lim_qtd'];

  // APP_grava_acao($tela, $data_ini, $data_fin, $device);

  auditoriaLog('Begin - CRM_pesqcli()',$sql,$device,$login,$nome_completo,$ipaddress);

  if ( hasContent($buscaTipo) == 0 ) {
    returnJson(-1, "Tipo de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  if (hasContent($buscaTexto) == 0) {
    returnJson(-1, "Deve ser informado um critério de pesquisa. Pesquisa cancelada.");
  }

  if (hasContent($buscaOrdem) == 0) {
    returnJson(-1, "Ordem de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  if($buscaTipo == "N"){
    if(strlen($buscaTexto) < 2) {
      returnJson(-1, "Critério de pesquisa deve ter no mínimo 2 letras. Pesquisa cancelada.");
    }
  } else {
    if(strlen($buscaTexto) < 5) {
      returnJson(-1, "Critério de pesquisa deve ter no mínimo 5 dígitos. Pesquisa cancelada.");
    }
  }

  if ($buscaTipo == 'N') {

    $sql = "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT OUTER JOIN contato co ";
    $sql = $sql . "ON cl.numero_cdb = co.contato_nro_cdb ";
    $sql = $sql . "WHERE upper(cl.nome) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "UNION DISTINCT ";
    $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome ";
    $sql = $sql . "FROM contato co ";
    $sql = $sql . "RIGHT OUTER JOIN cliente cl ";
    $sql = $sql . "ON co.contato_nro_cdb = cl.numero_cdb ";
    $sql = $sql . "WHERE upper(co.contato_nome) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "ORDER BY $buscaOrdem ASC ";
    $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";

  } else {

    $cpf_cnpj = APP_remove_mascara_CPFCNPJ($buscaTexto);

    $sql = "SELECT id_cliente, nome, cpf_cnpj, numero_cdb, endereco ";
    $sql = $sql . "FROM cliente ";
    $sql = $sql . "WHERE REPLACE(REPLACE(REPLACE(cpf_cnpj,'.',''),'/',''),'-','') LIKE '$cpf_cnpj%' ";
    $sql = $sql . "ORDER BY $buscaOrdem ASC ";
    $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";
  }

  // returnJson(0, 'SQL= ' . $sql);

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('CRM_pesqcli() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('CRM_pesqcli() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Atenção, criterio de pesquisa não encontrado.');
  }

}

/*
 * @function CRM_contato_busca
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function CRM_contato_busca($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // Elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // C - Crescente
  $numero_cdb= trimupper($paramPOST['numero_cdb']);  // numero CDB

  // Paginacao para pesquisa retornar um volume menor
  // $lim_ini   = $paramPOST['lim_ini'];
  // $lim_qtd   = $paramPOST['lim_qtd'];

  // Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - CRM_contato_busca()',$sql,$device,$login,$nome_completo,$ipaddress);

  if ( hasContent($numero_cdb) == 0 ) {
    returnJson(-1, "Número CDB não informado. Pesquisa cancelada.");
  }

  // if (hasContent($buscaTexto) == 0) {
  //   returnJson(-1, "Critério de pesquisa não informado. Pesquisa cancelada.");
  // }

  if (hasContent($buscaOrdem) == 0) {
    returnJson(-1, "Ordem de pesquisa deve ser informada. Pesquisa cancelada.");
  }

  if (hasContent($buscaTipo) == 0) {
    returnJson(-1, "Tipo de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  // if( strlen($buscaTexto) < 3) {
  //   returnJson(-1, "Critério de pesquisa deve ter no mínimo 3 letras. Pesquisa cancelada.");
  // }

  // // Valida se tem conteudo
  // if(hasContent($buscaTexto) == 0) {
  // } else {
  if($buscaTipo == "N") {
    if(hasContent($buscaTexto) == 0) {
      $sql = "SELECT id_contato, contato_nro_cdb, contato_nome, contato_cpf ";
      $sql = $sql . "FROM contato ";
      $sql = $sql . "WHERE contato_nro_cdb = '$numero_cdb' ";
      $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
      // $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";
    } else {
      $sql = "SELECT id_contato, contato_nro_cdb, contato_nome, contato_cpf ";
      $sql = $sql . "FROM contato ";
      $sql = $sql . "WHERE contato_nro_cdb = '$numero_cdb' ";
      $sql = $sql . "AND upper(contato_nome) ";
      $sql = $sql . "LIKE upper('%$buscaTexto%')  ";
      $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
      // $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";
    }
  } else {

    if(hasContent($buscaTexto) == 0) {
      $sql = "SELECT id_contato, contato_nro_cdb, contato_nome, contato_cpf ";
      $sql = $sql . "FROM contato ";
      $sql = $sql . "WHERE contato_nro_cdb = '$numero_cdb' ";
      $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
      // $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";

    } else {
      $sql = "SELECT id_contato, contato_nro_cdb, contato_nome, contato_cpf ";
      $sql = $sql . "FROM contato ";
      $sql = $sql . "WHERE contato_nro_cdb = '$numero_cdb' ";
      $sql = $sql . "AND contato_cpf = '$buscaTexto')  ";
      $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
      // $sql = $sql . "LIMIT $lim_ini, $lim_qtd;  ";

    }

  }
  // }

  // returnJson(0,"debug", array(array("SQL:" => $sql));
  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('CRM_contato_busca() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('CRM_contato_busca() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Atenção, não foi criterio de pesquisa não encontrado.');
  }

}

// /*
//  * @function recuperaIDLogin
//  * @parameter $param
//  *
//  */
// function recuperaIDLogin($param) {

//   $sql = "SELECT id_colaborador FROM colaborador WHERE device = '$param' LIMIT 1";

//   $getID = query($sql);

//   return $getID[0]['id_colaborador'];

// }

/*
 * @function CRM_busca_id
 * @parameter $id, $paramREMOTE, $source
 *
 */
function CRM_busca_id($id, $paramREMOTE, $source) {

  // Recupera os dados
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  if($source == "CLI") {
    $sql = "SELECT * FROM cliente WHERE id_cliente = $id;";
  } else {
    $sql = "SELECT * FROM contato WHERE id_contato = $id;";
  }

  auditoriaLog('Begin - CRM_busca_id()',$sql,$device,$login,$nome_completo,$ipaddress);

  $search = query($sql);

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    return $search;
  }

}

/*
 * @function CRM_cliente_grava
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function CRM_cliente_grava($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_cliente               = $paramPOST['id_cliente'];
  $grupo                    = trimupper($paramPOST['grupo']);
  $nome                     = trimupper($paramPOST['nome']);
  $numero_cdb               = $paramPOST['numero_cdb'];
  $cpf_cnpj                 = $paramPOST['cpf_cnpj'];
  $telefone                 = $paramPOST['telefone'];
  $email                    = $paramPOST['email'];
  $codigo_grupo_cliente     = $paramPOST['codigo_grupo_cliente'];
  $aplicacao_1              = trimupper($paramPOST['aplicacao_1']);
  $aplicacao_onibus         = trimupper($paramPOST['aplicacao_onibus']);
  $favorito                 = $paramPOST['favorito'];
  $industria_servida_1      = $paramPOST['industria_servida_1'];
  $industria_servida_2      = $paramPOST['industria_servida_2'];
  $participacao_negocio     = $paramPOST['participacao_negocio'];
  $tamanho_frota            = $paramPOST['tamanho_frota'];
  $tamanho_frota_volvo      = $paramPOST['tamanho_frota_volvo'];
  $oficina                  = trimupper($paramPOST['oficina']);
  $programa_manutencao      = trimupper($paramPOST['programa_manutencao']);
  $compra_peca              = trimupper($paramPOST['compra_peca']);
  $tipo_conta               = trimupper($paramPOST['tipo_conta']);
  $endereco                 = trimupper($paramPOST['endereco']);
  $complemento1             = trimupper($paramPOST['complemento1']);
  $complemento2             = trimupper($paramPOST['complemento2']);
  $cep                      = trim($paramPOST['cep']);
  $cidade                   = trimupper($paramPOST['cidade']);
  $municipio                = trimupper($paramPOST['municipio']);
  $estado                   = trimupper($paramPOST['estado']);
  $pais                     = trimupper($paramPOST['pais']);
  $origem                   = $paramPOST['origem'];
  $id_colaborador           = $paramPOST['id_colaborador'];
  $categoria_caminhao       = $paramPOST['categoria_caminhao'];


  $tela                     = $paramPOST['tela'];
  // $data_ini                 = $paramPOST['data_ini'];
  // $data_fin                 = $paramPOST['data_fin'];

  // Padrao
  $device                   = trim($paramPOST['device']);
  $ipaddress                = $paramREMOTE['REMOTE_ADDR'];

  // Grava a informacao de qual tela esta
  APP_grava_acao($tela, $device);

  auditoriaLog('Begin - CRM_cliente_grava()',$sql,$device,$login,$nome_completo,$ipaddress,$tela);

  if(hasContent($id_cliente) == 0){
    if(hasContent($nome) == 0) {
      returnJson(-1,"Nome do cliente deve ter conteúdo. Gravação cancelada.");
    }
  }

  if(hasContent($telefone) == 0){
    returnJson(-1, "Telefone deve ter conteúdo. Gravação cancelada.");
  }

  // Se nao tiver valor seta o valor como ZERO
  $tamanho_frota = (hasContent($tamanho_frota) == 0) ? 0 : $tamanho_frota;
  $tamanho_frota_volvo = (hasContent($tamanho_frota_volvo) == 0) ? 0 : $tamanho_frota_volvo;

  // Recupera o ID do colaborador

  // recupera o nome do colaborador para gravar ao pedido
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador = $dados_colaborador[0]['id_colaborador'];
  // $colaborador    = $dados_colaborador[0]['nome_cracha'];

  // Valida se tem conteudo para acionar como insert ou update
  $isInsert = (hasContent($id_cliente) == 0);

  // returnJson(-1, $isInsert);

  if ($isInsert) {
    // Gera um numero de CBD para amarrar ao contato
    $numero_cdb ="CRM" . uniqid(rand());
    $origem     = "C";
    $grupo      = (hasContent($grupo) == 0 ? "VOLVO" : $grupo);

    $sql = "INSERT INTO cliente ";
    $sql = $sql . "(grupo, nome, numero_cdb, cpf_cnpj, telefone, email, codigo_grupo_cliente, ";
    $sql = $sql . "aplicacao_1, aplicacao_onibus,favorito, industria_servida_1, industria_servida_2, ";
    $sql = $sql . "participacao_negocio, tamanho_frota, tamanho_frota_volvo,oficina,programa_manutencao,compra_peca,";
    $sql = $sql . "tipo_conta, endereco, ";
    $sql = $sql . "complemento1, complemento2, cep, cidade, municipio, estado, pais, origem, id_colaborador,";
    $sql = $sql . "categoria_caminhao)";
    $sql = $sql . " VALUES ";
    $sql = $sql . "('$grupo','$nome','$numero_cdb','$cpf_cnpj','$telefone','$email','$codigo_grupo_cliente',";
    $sql = $sql . "'$aplicacao_1','$aplicacao_onibus','$favorito','$industria_servida_1','$industria_servida_2',";
    $sql = $sql . "'$participacao_negocio','$tamanho_frota','$tamanho_frota_volvo','$oficina','$programa_manutencao','$compra_peca',";
    $sql = $sql . "'$tipo_conta','$endereco',";
    $sql = $sql . "'$complemento1','$complemento2','$cep','$cidade','$municipio','$estado','$pais','$origem','$id_colaborador',";
    $sql = $sql . "'$categoria_caminhao');";
  } else {
    $sql = "UPDATE cliente SET ";
    $sql = $sql . "grupo='$grupo',nome='$nome',numero_cdb='$numero_cdb',cpf_cnpj='$cpf_cnpj',";
    $sql = $sql . "telefone='$telefone',email='$email',codigo_grupo_cliente='$codigo_grupo_cliente',";
    $sql = $sql . "aplicacao_1='$aplicacao_1',aplicacao_onibus='$aplicacao_onibus',favorito='$favorito',";
    $sql = $sql . "industria_servida_1='$industria_servida_1',industria_servida_2='$industria_servida_2',";
    $sql = $sql . "participacao_negocio='$participacao_negocio',tamanho_frota='$tamanho_frota',";
    $sql = $sql . "tamanho_frota_volvo='$tamanho_frota_volvo',tipo_conta='$tipo_conta',endereco='$endereco',";
    $sql = $sql . "complemento1='$complemento1',complemento2='$complemento2',cep='$cep',";
    $sql = $sql . "cidade='$cidade',municipio='$municipio',estado='$estado',pais='$pais',origem='$origem',";
    $sql = $sql . "oficina='$oficina',programa_manutencao='$programa_manutencao',compra_peca='$compra_peca',";
    $sql = $sql . "id_colaborador='$id_colaborador',categoria_caminhao='$categoria_caminhao'";
    $sql = $sql . " WHERE id_cliente=$id_cliente ;";
  }

  auditoriaLog('CRM_cliente_grava() - {AUDITA SQL}',$sql,$device,$login,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $save = query($sql);

  if (!$save['error']) {

    auditoriaLog('CRM_cliente_grava() - Cliente salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

    // recupera o ID do cliente novo
    if( $isInsert ) {
      $id_cliente = $save['newid'];
    }

    $data = CRM_busca_id($id_cliente, $paramREMOTE, 'CLI');

    // Grava o registro para faze ro delta
    APP_insert_table_control($device, $id_cliente, 'cliente');

    returnJson(0,'Cliente salvo com sucesso.', $data);

  } else {
    auditoriaLog('CRM_cliente_grava() - Erro ao salvar cliente.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Erro ao salvar cliente.');
  }

}

/*
 * @function CRM_contato_grava
 * @parameter $_POST, $_REMOTE
 *
 */
function CRM_contato_grava($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_contato             = $paramPOST['id_contato'];
  $contato_grupo          = trimupper($paramPOST['contato_grupo']);
  $contato_nome_empresa   = trimupper($paramPOST['contato_nome_empresa']);
  $contato_nro_cdb        = $paramPOST['contato_nro_cdb'];
  $contato_cargo          = trimupper($paramPOST['contato_cargo']);
  $contato_cod_identif    = $paramPOST['contato_cod_identif'];
  $contato_inativo        = $paramPOST['contato_inativo'];
  $contato_nome           = trimupper($paramPOST['contato_nome']);
  $contato_sobrenome      = trimupper($paramPOST['contato_sobrenome']);
  $contato_telefone       = $paramPOST['contato_telefone'];
  $contato_tip_corresp    = $paramPOST['contato_tip_corresp'];
  $contato_celular        = $paramPOST['contato_celular'];
  $contato_email          = $paramPOST['contato_email'];
  $contato_dat_nasc       = $paramPOST['contato_dat_nasc'];
  $contato_cpf            = $paramPOST['contato_cpf'];
  $contato_env_email      = $paramPOST['contato_env_email'];
  $contato_env_sms        = $paramPOST['contato_env_sms'];
  $id_colaborador         = $paramPOST['id_colaborador'];
  //Pesquisa
  $pesq_tv_cabo           = $paramPOST['pesq_tv_cabo'];
  $pesq_canais_assiste    = $paramPOST['pesq_canais_assiste'];
  $pesq_canias_favorito   = $paramPOST['pesq_canias_favorito'];
  $pesq_le_revista        = $paramPOST['pesq_le_revista'];
  $pesq_revista_qual      = $paramPOST['pesq_revista_qual'];
  $pesq_revista_favorita  = $paramPOST['pesq_revista_favorita'];
  $pesq_viaja_aviao       = $paramPOST['pesq_viaja_aviao'];
  $pesq_aviao_frequencia  = $paramPOST['pesq_aviao_frequencia'];

  // Padrao
  $device                 = trim($paramPOST['device']);
  $ipaddress              = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - CRM_contato_grava() ',$sql,$device,$login,$nome_completo,$ipaddress);

  if(hasContent($contato_nome) == 0) {
    returnJson(-1, 'Nome do contato deve ter conteúdo.');
  }

  // Recupera o ID do colaborador
  // $id_colaborador = recuperaIDLogin($device);
  // recupera o nome do colaborador para gravar ao pedido
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador = $dados_colaborador[0]['id_colaborador'];
  // $colaborador    = $dados_colaborador[0]['nome_cracha'];


  // Seta valores default se for nulo
  $contato_inativo = (hasContent($contato_inativo) == 0) ? 0 : $contato_inativo;
  $contato_env_email = (hasContent($contato_env_email) == 0) ? 1 : $contato_env_email;
  $contato_env_sms = (hasContent($contato_env_sms) == 0) ? 0 : $contato_env_sms;

  $pesq_le_revista = (hasContent($pesq_le_revista) ==0 ) ? 0 : $pesq_le_revista;
  $pesq_viaja_aviao= (hasContent($pesq_viaja_aviao) ==0 ) ? 0 : $pesq_viaja_aviao;
  $pesq_tv_cabo= (hasContent($pesq_tv_cabo) ==0 ) ? 0 : $pesq_tv_cabo;

  // Valida se tem conteudo para acionar como insert ou update
  $isInsert = (hasContent($id_contato) == 0);

  if ($isInsert) {
    $sql = "INSERT INTO contato ";
    $sql = $sql . "(contato_grupo,contato_nome_empresa,contato_nro_cdb,contato_cargo,contato_cod_identif,";
    $sql = $sql . "contato_inativo,contato_nome,contato_sobrenome,contato_telefone,";
    $sql = $sql . "contato_tip_corresp,contato_celular,contato_email,contato_dat_nasc,";
    $sql = $sql . "contato_cpf,contato_env_email,contato_env_sms,id_colaborador,";
    $sql = $sql . "pesq_tv_cabo,pesq_canais_assiste,pesq_canias_favorito,";
    $sql = $sql . "pesq_le_revista,pesq_revista_qual,pesq_revista_favorita,";
    $sql = $sql . "pesq_viaja_aviao,pesq_aviao_frequencia)";
    $sql = $sql . " VALUES ";
    $sql = $sql . "('$contato_grupo','$contato_nome_empresa','$contato_nro_cdb','$contato_cargo','$contato_cod_identif',";
    $sql = $sql . "'$contato_inativo','$contato_nome','$contato_sobrenome','$contato_telefone',";
    $sql = $sql . "'$contato_tip_corresp','$contato_celular','$contato_email','$contato_dat_nasc',";
    $sql = $sql . "'$contato_cpf','$contato_env_email','$contato_env_sms','$id_colaborador',";
    $sql = $sql . "'$pesq_tv_cabo','$pesq_canais_assiste','$pesq_canias_favorito',";
    $sql = $sql . "'$pesq_le_revista','$pesq_revista_qual','$pesq_revista_favorita',";
    $sql = $sql . "'$pesq_viaja_aviao','$pesq_aviao_frequencia');";
  } else {
    $sql = "UPDATE contato SET ";
    $sql = $sql . "contato_grupo='$contato_grupo',contato_nome_empresa='$contato_nome_empresa',";
    $sql = $sql . "contato_nro_cdb='$contato_nro_cdb',contato_cargo='$contato_cargo',";
    $sql = $sql . "contato_cod_identif='$contato_cod_identif',contato_inativo='$contato_inativo',";
    $sql = $sql . "contato_nome='$contato_nome',contato_sobrenome='$contato_sobrenome',";
    $sql = $sql . "contato_telefone='$contato_telefone',contato_tip_corresp='$contato_tip_corresp',";
    $sql = $sql . "contato_celular='$contato_celular',contato_email='$contato_email',";
    $sql = $sql . "contato_dat_nasc='$contato_dat_nasc',contato_cpf='$contato_cpf',";
    $sql = $sql . "contato_env_email='$contato_env_email',contato_env_sms='$contato_env_sms',";
    $sql = $sql . "id_colaborador='$id_colaborador',";
    $sql = $sql . "pesq_tv_cabo='$pesq_tv_cabo',pesq_canais_assiste='$pesq_canais_assiste',";
    $sql = $sql . "pesq_canias_favorito='$pesq_canias_favorito',pesq_le_revista='$pesq_le_revista',";
    $sql = $sql . "pesq_revista_qual='$pesq_revista_qual',pesq_revista_favorita='$pesq_revista_favorita',";
    $sql = $sql . "pesq_viaja_aviao='$pesq_viaja_aviao',pesq_aviao_frequencia='$pesq_aviao_frequencia'";
    $sql = $sql . " WHERE id_contato=$id_contato ";
  }

  // returnJson(0, "SUCESSO", array(array("SQL " => $sql)));

  $save = query($sql);

  if (!$save['error']) {

    auditoriaLog('CRM_contato_grava() - Cliente salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

    // recupera o ID do cliente novo
    if( $isInsert ) {
      $id_contato = $save['newid'];
    }

    $data = CRM_busca_id($id_contato, $paramREMOTE, 'CON');

    // Grava o registro para faze ro delta
    APP_insert_table_control($device, $id_contato, 'contato');

    returnJson(0,'Contato salvo com sucesso.', $data);

  } else {
    auditoriaLog('CRM_contato_grava() - Erro ao salvar cliente.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Erro ao salvar contato.');
  }

}

