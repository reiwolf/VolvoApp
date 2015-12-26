<?php
/***********************************************************************************************
 *   apiIORDER.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function IORDER_login
 * @parameter $_POST, $_REMOTE
 *
 */
// function IORDER_login($paramPOST, $paramREMOTE) {

// /*
// SELECT
//   co.*, ca.*, cc.*
// FROM colaborador co
// LEFT JOIN cargo ca
//   ON ca.id_cargo = co.id_cargo
// LEFT JOIN concessionaria cc
//   ON cc.id_concessionaria = co.id_concessionaria
// WHERE co.device = '164326B8-DDAC-4E10-8393-F11B61E50079';
// */

//   // Recupera os dados
//   $usuario   = trimupper($paramPOST['usuario']);
//   $senha     = trimupper($paramPOST['senha']);
//   $device    = trim($paramPOST['device']);
//   $ipaddress = $paramREMOTE['REMOTE_ADDR'];

//   auditoriaLog('Begin - IORDER_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//   // Valida se tem conteudo
//   if( (hasContent($usuario) == 0) || (hasContent($senha) == 0)) {
//     auditoriaLog('IORDER_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);
//     returnJson(103,'Usuario ou Senha devem tem conteúdo');
//   }

//   // Pesquisa o usuario e senha
//   $sql = "SELECT * FROM colaborador ";
//   $sql = $sql . " WHERE login = '$usuario' ";
//   $sql = $sql . " AND senha = '$senha' LIMIT 1;";

//   $login = query($sql);

//   auditoriaLog('IORDER_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//   // Valida se retornou 1 usuario encontrado
//   if ((isset($login)) && (sizeof($login) == 1)) {

//     $deviceSize = strlen(trim($login[0]['device']));
//     $nome      = trim($login[0]['nome_completo']);
//     $ipIpad    = trim($login[0]['ip_ipad']);

//     // Verifica se ja esta logado
//     if ($deviceSize == 0) {
//       // seta informacao que o usuario esta logado
//       $sql = "UPDATE colaborador SET data_hora_login = CURRENT_TIMESTAMP(), device = '$device', ip_ipad = '$ipAddress' WHERE login = '$usuario'";
//       $update = query($sql);

//       if (!$update['error']) {
//         // Cria a tabela temporaria para controle de atualizacao de registros
//         create_table_control($device);

//         auditoriaLog('IORDER_login()',$sql,$device,$usuario,$nome_completo,$ipaddress);

//         returnJson(100,'Autenticado com sucesso.', $login);

//       } else {
//         returnJson(-1,'Error ao atualizar login do usuario.');
//       }
//     } else {
//       if( $ipAddress == $ipIpad ) {
//         auditoriaLog('IORDER_login() - logando novamente no mesmo IPad',$sql,$device,$usuario,$nome_completo,$ipaddress);
//         returnJson(101,'Atenção, voce esta logando novamente no mesmo IPad, seus dados serão atualizados.', $login);

//       } else {
//         auditoriaLog('IORDER_login() - Usuario Já está logado',$sql,$device,$usuario,$nome_completo,$ipaddress);
//         returnJson(104,'Usuário: ' . $nome . ' já esta logado no iPad com IP ' . $ipIpad, $login );
//       }
//     }
//   } else {
//     auditoriaLog('IORDER_login() - Usuário ou senha não conferem',$sql,$device,$usuario,$nome_completo,$ipaddress);
//     returnJson(102,'Usuário ou Senha não Conferem.');
//   }

// }

/*
 * @function IORDER_logout
 * @parameter $_POST, $_REMOTE
 *
 */
// function IORDER_logout($paramPOST, $paramREMOTE) {

//   $device    = trim($paramPOST['device']);
//   $ipaddress = $paramREMOTE['REMOTE_ADDR'];

//   auditoriaLog('Begin - IORDER_logout()',$sql,$device,$login,$nome_completo,$ipaddress);

//   $sql = "SELECT * FROM colaborador WHERE device = '$device' LIMIT 1";

//   $logout = query($sql);

//   if ((isset($logout)) && (sizeof($logout) == 1)) {
//     $sql = "UPDATE colaborador SET device = null, ip_ipad = null, data_hora_login = null, data_hora_logout = CURRENT_TIMESTAMP() WHERE device  = '$device'";
//     $logout = query($sql);

//     if (!$logout['error']) {
//       auditoriaLog('IORDER_logout() - Deslogado com sucesso.',$sql,$device,$login,$nome_completo,$ipaddress);
//       returnJson(0,'Deslogado com sucesso.');
//     } else {
//       auditoriaLog('IORDER_logout() - Erro ao efetuar o logout.',$sql,$device,$login,$nome_completo,$ipaddress);
//       returnJson(-1,'Erro ao efeturar Logout.');
//     }
//   } else {
//     auditoriaLog('IORDER_logout() - Usuario não esta logado para efetuar logout.',$sql,$device,$login,$nome_completo,$ipaddress);
//     returnJson(-1,'Usuario não esta logado para efetuar Logout.');
//   }

//   $_SESSION = array();
//   session_destroy();
// }

/*
 * @function recuperaTotalPedidosPendentes
 * @parameter $usuario, $ipAddress
 *
 */
function recuperaTotalPedidosPendentes($usuario, $ipAddress) {
  $iorder = query("SELECT * FROM iorder WHERE login='$usuario' AND iorder_pendente ='F'");
  $totalPedidos = count($iorder['result']);

  if( $totalPedidos == 0) {
    auditoriaLog('recuperaTotalPedidosPendentes() - Validando Pedidos Pendentes [' . $totalPedidos . '] .','mac_address',$ipAddress,'serial_number','sql',$device,$usuario,'nome_cracha');
  }

  return $totalPedidos;
}

/*
 * @function IORDER_cliente_busca
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_cliente_busca($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // nome do campo que sera ordenado

  $id_grupo_financeiro= trimupper($paramPOST['id_grupo']);  // nome do campo que sera ordenado

  $id_cargo   = $paramPOST['cargo'];

  // Paginacao para pesquisa retornar um volume menor
  $lim_ini   = $paramPOST['lim_ini'];
  $lim_qtd   = $paramPOST['lim_qtd'];

  //
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_cliente_busca()',$sql,$device,$login,$nome_completo,$ipaddress);

  if ( hasContent($buscaTipo) == 0 ) {
    returnJson(-1, "Tipo de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  if (hasContent($buscaTexto) == 0) {
    returnJson(-1, "Deve ser informado um critério de pesquisa. Pesquisa cancelada.");
  }

  if (hasContent($buscaOrdem) == 0) {
    returnJson(-1, "Ordem de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  if (strlen($buscaTexto) < 2) {
    returnJson(-1, "Critério de pesquisa deve ter no mínimo 2 letras. Pesquisa cancelada.");
  }

  // Valida o status do colaborado para saber se ele é um código 3 - Dirigente Concessionarias
  $colaborador = APP_recupera_cargo_colaborador($device);
  if(sizeof($colaborador) == 1) {
    $id_cargo = $colaborador[0]['id_cargo'];
  }
  //

  // Valida se tem conteudo
  if ($buscaTipo == 'N') {

    if ( $id_cargo == 3 ) {
      $sql = "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo ";
      $sql = $sql . "FROM cliente cl ";
      $sql = $sql . "LEFT JOIN contato co ";
      $sql = $sql . "ON cl.numero_cdb = co.contato_nro_cdb ";
      $sql = $sql . "WHERE upper(cl.nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND ( upper(cl.grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = $id_grupo_financeiro) OR upper(grupo) = upper('volvo') ) ";
      $sql = $sql . "union ";
      $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo  ";
      $sql = $sql . "FROM contato co ";
      $sql = $sql . "LEFT JOIN cliente cl ";
      $sql = $sql . "ON co.contato_nro_cdb = cl.numero_cdb ";
      $sql = $sql . "WHERE upper(co.contato_nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND ( upper(co.contato_grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = $id_grupo_financeiro) OR upper(contato_grupo) = upper('volvo') ) ";
      $sql = $sql . "LIMIT $lim_ini, $lim_qtd;  ";

    } else {
      $sql = "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo ";
      $sql = $sql . "FROM cliente cl ";
      $sql = $sql . "LEFT JOIN contato co ";
      $sql = $sql . "ON cl.numero_cdb = co.contato_nro_cdb ";
      $sql = $sql . "WHERE upper(cl.nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND ( upper(cl.grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = $id_grupo_financeiro) OR upper(grupo) = upper('volvo') ) ";
      $sql = $sql . "union ";
      $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo  ";
      $sql = $sql . "FROM contato co ";
      $sql = $sql . "LEFT JOIN cliente cl ";
      $sql = $sql . "ON co.contato_nro_cdb = cl.numero_cdb ";
      $sql = $sql . "WHERE upper(co.contato_nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND ( upper(co.contato_grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = $id_grupo_financeiro) OR upper(contato_grupo) = upper('volvo') ) ";
      $sql = $sql . "LIMIT $lim_ini, $lim_qtd;  ";

    }

  } else {
    $cpf_cnpj = APP_remove_mascara_CPFCNPJ($buscaTexto);

    if ( $id_cargo == 3 ) {
      $sql = "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo ";
      $sql = $sql . "FROM cliente cl ";
      $sql = $sql . "LEFT JOIN contato co ";
      $sql = $sql . "ON cl.numero_cdb = co.contato_nro_cdb ";
      $sql = $sql . "WHERE REPLACE(REPLACE(REPLACE(cpf_cnpj,'.',''),'\/',''),'-','') LIKE '$cpf_cnpj%'  ";
      $sql = $sql . "AND ( upper(cl.grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = 3) OR upper(grupo) = upper('volvo') ) ";
      $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";
      $sql  = $id_cargo;

    } else {
      $sql = "SELECT cl.id_cliente, cl.nome, cl.numero_cdb, cl.cpf_cnpj, cl.endereco, co.id_contato, co.contato_nome, cl.grupo ";
      $sql = $sql . "FROM cliente cl ";
      $sql = $sql . "LEFT JOIN contato co ";
      $sql = $sql . "ON cl.numero_cdb = co.contato_nro_cdb ";
      $sql = $sql . "WHERE REPLACE(REPLACE(REPLACE(cpf_cnpj,'.',''),'\/',''),'-','') LIKE '$cpf_cnpj%'  ";
      $sql = $sql . "AND ( upper(cl.grupo) IN (SELECT DISTINCT upper(concessionaria) FROM `concessionaria` WHERE id_grupo_financeiro = 3) OR upper(grupo) = upper('volvo') ) ";
      $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";
      $sql  = $id_cargo;

    }

  }

  // returnJson(-1, $sql);

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('IORDER_cliente_busca() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('IORDER_cliente_busca() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Atenção, critério de pesquisa não localizado.');
  }

}

/*
 * @function IORDER_cliente_grava
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_cliente_grava($paramPOST, $paramREMOTE) {

  // Recupera os dados
  // $id_cliente               = $paramPOST['id_cliente'];
  $nome                     = trimupper($paramPOST['nome']);
  $telefone                 = $paramPOST['telefone'];

  // Padrao
  $device                   = trim($paramPOST['device']);
  $ipaddress                = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_cliente_grava()',$sql,$device,$login,$nome_completo,$ipaddress);

  // Valida se o nome esta sem conteudo
  if(hasContent($nome) == 0) {
    returnJson(-1,"Nome do cliente deve ter conteúdo. Gravação cancelada.");
  }

  // Se nao tiver valor seta o valor como ZERO
  $tamanho_frota = (hasContent($tamanho_frota) == 0) ? 0 : $tamanho_frota;
  $tamanho_frota_volvo = (hasContent($tamanho_frota_volvo) == 0) ? 0 : $tamanho_frota_volvo;

  // Recupera o ID do colaborador
  // $id_colaborador = recuperaIDLogin($device);

  // recupera o nome do colaborador para gravar ao pedido
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador = $dados_colaborador[0]['id_colaborador'];
  // $colaborador    = $dados_colaborador[0]['nome_cracha'];

  // Valida se tem conteudo para acionar como insert ou update
  $isInsert = (hasContent($id_cliente) == 0);

  $origem     = "I";

  $sql = "INSERT INTO cliente ";
  $sql = $sql . "(nome, telefone, origem)";
  $sql = $sql . " VALUES ";
  $sql = $sql . "('$nome','$telefone','$origem');";

  $save = query($sql);

  if (!$save['error']) {

    auditoriaLog('IORDER_cliente_grava() - Cliente salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

    // recupera o ID do cliente novo
    if( $isInsert ) {
      $id_cliente = $save['newid'];
    }

    $data = CRM_busca_id($id_cliente, $paramREMOTE, 'CLI');

    // insereControle($device, $id_cliente);

    // Grava o registro para faze ro delta
    APP_insert_table_control($device, $id_cliente, 'cliente');

    returnJson(0,'Cliente salvo com sucesso.', $data);

  } else {
    auditoriaLog('IORDER_cliente_grava() - Erro ao salvar cliente.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Erro ao salvar cliente.');
  }

}

/*
 * @function IORDER_pedido_grava
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_pedido_grava($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_iorder           = $paramPOST['id_iorder'];
  $seq_dashb           = $paramPOST['seq_dashb'];
  $id_cliente          = $paramPOST['id_cliente'];
  $cliente_nome        = trimupper($paramPOST['cliente_nome']);
  $id_contato          = $paramPOST['id_contato'];
  $contato_nome        = trimupper($paramPOST['contato_nome']);
  $endereco            = trimupper($paramPOST['endereco']);
  $telefone            = $paramPOST['telefone'];
  $modelo              = trimupper($paramPOST['modelo']);
  $tracao              = trimupper($paramPOST['tracao']);
  $motor               = trimupper($paramPOST['motor']);
  $caixa_cambio        = trimupper($paramPOST['caixa_cambio']);
  $suspensao_traseira  = trimupper($paramPOST['suspensao_traseira']);
  $relacao_diferencial = $paramPOST['relacao_diferencial'];
  $entre_eixos         = $paramPOST['entre_eixos'];
  $tanque              = $paramPOST['tanque'];
  $pneus               = $paramPOST['pneus'];
  $pacote_acabamento   = trimupper($paramPOST['pacote_acabamento']);
  $cabine              = $paramPOST['cabine'];
  $cor                 = trimupper($paramPOST['cor']);
  $segmento            = trimupper($paramPOST['segmento']);
  $opcionais           = trimupper($paramPOST['opcionais']);
  $valor_unitario      = $paramPOST['valor_unitario'];
  $quantidade          = $paramPOST['quantidade'];
  $total               = $paramPOST['total'];
  $entrega_prevista    = trimupper($paramPOST['entrega_prevista']);
  $a_confirmar         = $paramPOST['a_confirmar'];
  $forma_pagamento     = trimupper($paramPOST['forma_pagamento']);
  $observacao          = trimupper($paramPOST['observacao']);
  $pm_ouro             = $paramPOST['pm_ouro'];
  $pm_azul             = $paramPOST['pm_azul'];
  $dynafleet           = $paramPOST['dynafleet'];
  $pecas               = trimupper($paramPOST['pecas']);
  $assinatura_cliente  = $paramPOST['assinatura_cliente'];
  $assinatura_concessionaria = $paramPOST['assinatura_concessionaria'];
  $assinatura_gerente        = $paramPOST['assinatura_gerente'];
  $status                    = $paramPOST['status'];
  $data_hora_pedido          = $paramPOST['data_hora_pedido'];
  $seguro                    = $paramPOST['seguro'];
  $cor_nscabcol              = trimupper($paramPOST['cor_nscabcol']);
  $gerente_nome              = trimupper($paramPOST['gerente_nome']);

  // Padrao
  $device                   = trim($paramPOST['device']);
  $ipaddress                = $paramREMOTE['REMOTE_ADDR'];

  // capos novos para referencia da montagem
  $id_modelo               = $paramPOST['id_modelo'];
  $id_tracao               = $paramPOST['id_tracao'];
  $id_motor                = $paramPOST['id_motor'];
  $id_caixa_cambio         = $paramPOST['id_caixa_cambio'];
  $id_suspensao_traseira   = $paramPOST['id_suspensao_traseira'];
  $id_relacao_diferencial  = $paramPOST['id_relacao_diferencial'];
  $id_entre_eixos          = $paramPOST['id_entre_eixos'];
  $id_tanque               = $paramPOST['id_tanque'];
  $id_pneu                 = $paramPOST['id_pneu'];
  $id_pacote_acabameto     = $paramPOST['id_pacote_acabameto'];
  $id_cabine               = $paramPOST['id_cabine'];
  //

  $id_modelo               = (hasContent($id_modelo) == 0 ? 0 : $id_modelo);
  $id_tracao               = (hasContent($id_tracao) == 0 ? 0 : $id_tracao);
  $id_motor                = (hasContent($id_motor) == 0 ? 0 : $id_motor);
  $id_caixa_cambio         = (hasContent($id_caixa_cambio) == 0 ? 0 : $id_caixa_cambio);
  $id_suspensao_traseira   = (hasContent($id_suspensao_traseira) == 0 ? 0 : $id_suspensao_traseira);
  $id_relacao_diferencial  = (hasContent($id_relacao_diferencial) == 0 ? 0 : $id_relacao_diferencial);
  $id_entre_eixos          = (hasContent($id_entre_eixos) == 0 ? 0 : $id_entre_eixos);
  $id_tanque               = (hasContent($id_tanque) == 0 ? 0 : $id_tanque);
  $id_pneu                 = (hasContent($id_pneu) == 0 ? 0 : $id_pneu);
  $id_pacote_acabameto     = (hasContent($id_pacote_acabameto) == 0 ? 0 : $id_pacote_acabameto);
  $id_cabine               = (hasContent($id_cabine) == 0 ? 0 : $id_cabine);
  $id_cor                  = (hasContent($id_cor) == 0 ? 0 : $id_cor);
  //

  auditoriaLog('Begin - IORDER_pedido_grava()',$sql,$device,$login,$nome_completo,$ipaddress);

  if(hasContent($cliente_nome) == 0) {
    returnJson(-1,"Nome do cliente deve ter conteúdo. Gravação cancelada.");
  }

  // Compos inteiros valor default ZERO
  $seq_dashb  = (hasContent($seq_dashb)  == 0 ? 0 : $seq_dashb);
  $id_contato = (hasContent($id_contato) == 0 ? 0 : $id_contato);
  $id_cliente = (hasContent($id_cliente) == 0 ? 0 : $id_cliente);

  $pm_ouro             = (hasContent($pm_ouro)  == 0 ? 0 : $pm_ouro);
  $pm_azul             = (hasContent($pm_azul)  == 0 ? 0 : $pm_azul);
  $dynafleet           = (hasContent($dynafleet)  == 0 ? 0 : $dynafleet);
  $seguro              = (hasContent($seguro)  == 0 ? 0 : $seguro);
  $quantidade          = (hasContent($quantidade)  == 0 ? 0 : $quantidade);

  $valor_unitario      = (hasContent($valor_unitario)  == 0 ? 0 : $valor_unitario);
  $total               = (hasContent($total)  == 0 ? 0 : $total);

  // $valor_unitario      = (hasContent($valor_unitario)  == 0 ? 0 : APP_monetario_to_banco($valor_unitario));
  // $total               = (hasContent($total)  == 0 ? 0 : APP_monetario_to_banco($total));

  // recupera o nome do colaborador para gravar ao pedido
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador    = $dados_colaborador[0]['id_colaborador'];
  $colaborador       = trimupper($dados_colaborador[0]['nome_cracha']);
  $id_concessionaria = $dados_colaborador[0]['id_concessionaria'];

  // Valida se tem conteudo para acionar como insert ou update
  $isInsert = (hasContent($id_iorder) == 0);


  // converte texto em data
  if(($entrega_prevista != 'À CONFIRMAR') && hasContent($entrega_prevista) != 0) {
    $ent_prev = retornaMes($entrega_prevista);
  } else {
    $ent_prev = "01/01/2999";
  }
  //

  // recupera o grupo do consultor logado
  $sql  = "SELECT gr.id_grupo, gr.grupo ";
  $sql  = $sql . "FROM colaborador co, concessionaria cs, grupo gr ";
  $sql  = $sql . "WHERE co.device = '$device' ";
  $sql  = $sql . "AND cs.id_concessionaria = co.id_concessionaria ";
  $sql  = $sql . "AND cs.id_grupo_financeiro = gr.id_grupo; ";

  $result = query($sql);

  $id_grupo_financeiro = $result[0]['id_grupo'];
  $grupo               = $result[0]['grupo'];
  //

  if ($isInsert) {

    // Gera um numero de CBD para amarrar ao contato
    // $numero_cdb ="CRM" . uniqid(rand());
    // $origem     = "C";
    // $grupo      = "VOLVO";

    // $status  = "Pendente";

    $sql = "INSERT INTO iorder ";
    $sql = $sql . "(seq_dashb, endereco, telefone, modelo, tracao, motor, ";
    $sql = $sql . "caixa_cambio, suspensao_traseira, relacao_diferencial, entre_eixos, ";
    $sql = $sql . "tanque, pneus, pacote_acabamento, cabine, cor, segmento, opcionais, valor_unitario, ";
    $sql = $sql . "quantidade, total, entrega_prevista, a_confirmar, forma_pagamento, observacao, pm_ouro, pm_azul, ";
    $sql = $sql . "dynafleet, pecas, assinatura_cliente, assinatura_concessionaria, ";
    $sql = $sql . "assinatura_gerente, status, id_cliente, cliente_nome, id_contato, ";
    $sql = $sql . "contato_nome, seguro, id_colaborador, colaborador, id_concessionaria, id_grupo_financeiro, grupo, ";
    $sql = $sql . "cor_nscabcol, ent_prev, ";
// gerente_nome
    $sql = $sql . "id_modelo,id_tracao,id_motor,id_caixa_cambio,id_suspensao_traseira, ";
    $sql = $sql . "id_relacao_diferencial,id_entre_eixos,id_tanque,id_pneu,id_pacote_acabameto,  ";
    $sql = $sql . "id_cabine )";


    $sql = $sql . " VALUES ";
    $sql = $sql . "('$seq_dashb', '$endereco', '$telefone', '$modelo', '$tracao', '$motor', ";
    $sql = $sql . "'$caixa_cambio', '$suspensao_traseira', '$relacao_diferencial', '$entre_eixos', ";
    $sql = $sql . "'$tanque', '$pneus', '$pacote_acabamento', '$cabine', '$cor', '$segmento', '$opcionais', '$valor_unitario', ";
    $sql = $sql . "'$quantidade', '$total', '$entrega_prevista', '$a_confirmar', '$forma_pagamento', '$observacao', '$pm_ouro', ";
    $sql = $sql . "'$pm_azul', '$dynafleet', '$pecas', '$assinatura_cliente', '$assinatura_concessionaria', ";
    $sql = $sql . "'$assinatura_gerente', upper('$status'), '$id_cliente', '$cliente_nome', ";
    $sql = $sql . "'$id_contato', '$contato_nome', '$seguro', $id_colaborador, '$colaborador', $id_concessionaria, $id_grupo_financeiro, '$grupo', ";
    $sql = $sql . "'$cor_nscabcol', '$ent_prev', ";
// '$gerente_nome'
    $sql = $sql . "$id_modelo,$id_tracao,$id_motor,$id_caixa_cambio,$id_suspensao_traseira, ";
    $sql = $sql . "$id_relacao_diferencial,$id_entre_eixos,$id_tanque,$id_pneu,$id_pacote_acabameto,  ";
    $sql = $sql . "$id_cabine )";
  } else {
    $sql = "UPDATE iorder SET ";
    $sql = $sql . "seq_dashb           = '$seq_dashb', ";
    $sql = $sql . "id_cliente          = '$id_cliente', ";
    $sql = $sql . "cliente_nome        = '$cliente_nome', ";
    $sql = $sql . "id_contato          = '$id_contato', ";
    $sql = $sql . "contato_nome        = '$contato_nome', ";
    $sql = $sql . "endereco            = '$endereco', ";
    $sql = $sql . "telefone            = '$telefone', ";
    $sql = $sql . "modelo              = '$modelo', ";
    $sql = $sql . "tracao              = '$tracao', ";
    $sql = $sql . "motor               = '$motor', ";
    $sql = $sql . "caixa_cambio        = '$caixa_cambio', ";
    $sql = $sql . "suspensao_traseira  = '$suspensao_traseira', ";
    $sql = $sql . "relacao_diferencial = '$relacao_diferencial', ";
    $sql = $sql . "entre_eixos         = '$entre_eixos', ";
    $sql = $sql . "tanque              = '$tanque', ";
    $sql = $sql . "pneus               = '$pneus', ";
    $sql = $sql . "pacote_acabamento   = '$pacote_acabamento', ";
    $sql = $sql . "cabine              = '$cabine', ";
    $sql = $sql . "cor                 = '$cor', ";
    $sql = $sql . "segmento            = '$segmento', ";
    $sql = $sql . "opcionais           = '$opcionais', ";
    $sql = $sql . "valor_unitario      = '$valor_unitario', ";
    $sql = $sql . "quantidade          = '$quantidade', ";
    $sql = $sql . "total               = '$total', ";
    $sql = $sql . "entrega_prevista    = '$entrega_prevista', ";
    $sql = $sql . "a_confirmar         = '$a_confirmar', ";
    $sql = $sql . "forma_pagamento     = '$forma_pagamento', ";
    $sql = $sql . "observacao          = '$observacao', ";
    $sql = $sql . "pm_ouro             = '$pm_ouro', ";
    $sql = $sql . "pm_azul             = '$pm_azul', ";
    $sql = $sql . "dynafleet           = '$dynafleet', ";
    $sql = $sql . "pecas               = '$pecas', ";
    $sql = $sql . "assinatura_cliente  = '$assinatura_cliente', ";
    $sql = $sql . "assinatura_concessionaria = '$assinatura_concessionaria', ";
    $sql = $sql . "assinatura_gerente        = '$assinatura_gerente', ";
    $sql = $sql . "status                    = upper('$status'), ";
    $sql = $sql . "seguro                    = '$seguro', ";
    $sql = $sql . "cor_nscabcol              = '$cor_nscabcol', ";
    $sql = $sql . "id_colaborador            = $id_colaborador, ";
    $sql = $sql . "colaborador               = '$colaborador', ";
    $sql = $sql . "id_concessionaria         = $id_concessionaria, ";
    $sql = $sql . "id_grupo_financeiro       = $id_grupo_financeiro, ";
    $sql = $sql . "ent_prev                  = '$ent_prev', ";
    $sql = $sql . "grupo                     = '$grupo', ";
    $sql = $sql . "id_modelo               = $id_modelo, "; // --------
    $sql = $sql . "id_tracao               = $id_tracao, ";
    $sql = $sql . "id_motor                = $id_motor, ";
    $sql = $sql . "id_caixa_cambio         = $id_caixa_cambio, ";
    $sql = $sql . "id_suspensao_traseira   = $id_suspensao_traseira, ";
    $sql = $sql . "id_relacao_diferencial  = $id_relacao_diferencial, ";
    $sql = $sql . "id_entre_eixos          = $id_entre_eixos, ";
    $sql = $sql . "id_tanque               = $id_tanque, ";
    $sql = $sql . "id_pneu                 = $id_pneu, ";
    $sql = $sql . "id_pacote_acabameto     = $id_pacote_acabameto, ";
    $sql = $sql . "id_cabine               = $id_cabine, ";
    $sql = $sql . "id_cor                  = $id_cor ";
    $sql = $sql . "WHERE id_iorder=$id_iorder ;";
  }

  // returnJson(-1, $sql);

  $save = query($sql);

  if (!$save['error']) {

    auditoriaLog('IORDER_pedido_grava() - Pedido salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

    // recupera o ID do cliente novo
    if( $isInsert ) {
      $id_iorder = $save['newid'];
    }

    $data = IORDER_busca_id($id_iorder, $paramREMOTE, 'xpto');

    // Grava o registro para faze ro delta
    APP_insert_table_control($device, $id_iorder, 'iorder');

    returnJson(0,'Pedido salvo com sucesso.', $data);

  } else {
    auditoriaLog('IORDER_pedido_grava() - Erro ao salvar pedido.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Erro ao salvar pedido (iOrder).');
  }

}

/*
 * @function IORDER_busca_id
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_busca_id($id_iorder, $paramREMOTE, $source="") {

  // Recupera os dados
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // if($source == "CLI") {
    $sql = "SELECT i.*, c.concessionaria ";
    $sql = $sql . "FROM iorder i, concessionaria c ";
    $sql = $sql . "WHERE i.id_concessionaria = c.id_concessionaria ";
    $sql = $sql . "AND i.id_iorder = $id_iorder; ";

  // } else {
  //   $sql = "SELECT * FROM contato WHERE id_contato = $id;";
  // }

  // returnJson(-1, $sql);

  auditoriaLog('Begin - IORDER_busca_id()',$sql,$device,$login,$nome_completo,$ipaddress);

  $search = query($sql);

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    return $search;
  }

}

/*
 * @function IORDER_modelo
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_modelo($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_modelo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM modelo ORDER BY modelo; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_modelo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_tracao
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_tracao($paramPOST, $paramREMOTE) {

  $id_modelo = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_tracao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra id_tracao, tracao FROM mod_tra JOIN tracao ON mod_tra.id_tracao=tracao.id_tracao WHERE id_modelo=$id_modelo ORDER BY tracao; ";

  // $sql  = "SELECT * FROM tracao ORDER BY tracao; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_tracao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_motor
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_motor($paramPOST, $paramREMOTE) {

  $id_tracao  = $paramPOST['tracao'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_motor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot id_motor, motor FROM mod_tra_mot JOIN motor ON mod_tra_mot.id_motor=motor.id_motor WHERE id_mod_tra=$id_tracao ORDER BY motor; ";

  // $sql  = "SELECT * FROM motor ORDER BY motor;  ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_motor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_caixa_cambio
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_caixa_cambio($paramPOST, $paramREMOTE) {

  $id_caixa_cambio = $paramPOST['motor'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_caixa_cambio()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai id_caixa_cambio, caixa_cambio FROM mod_tra_mot_cai JOIN caixa_cambio ON mod_tra_mot_cai.id_caixa_cambio=caixa_cambio.id_caixa_cambio WHERE id_mod_tra_mot=$id_caixa_cambio ORDER BY caixa_cambio; ";

  // $sql  = "SELECT * FROM caixa_cambio ORDER BY caixa_cambio; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_caixa_cambio()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_suspensao_traseira
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_suspensao_traseira($paramPOST, $paramREMOTE) {

  $id_suspensao = $paramPOST['caixa_cambio'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_suspensao_traseira()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus id_suspensao_traseira, suspensao_traseira ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus JOIN suspensao_traseira ON mod_tra_mot_cai_sus.id_suspensao_traseira=suspensao_traseira.id_suspensao_traseira ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai=$id_suspensao ORDER BY suspensao_traseira; ";

  // $sql = "SELECT * FROM suspensao_traseira ORDER BY suspensao_traseira; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_suspensao_traseira()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_relacao_diferencial
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_relacao_diferencial($paramPOST, $paramREMOTE) {

  $id_diferencial = $paramPOST['suspensao_traseira'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_relacao_diferencial()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel id_relacao_diferencial, relacao_diferencial FROM mod_tra_mot_cai_sus_rel JOIN relacao_diferencial ON mod_tra_mot_cai_sus_rel.id_relacao_diferencial=relacao_diferencial.id_relacao_diferencial WHERE id_mod_tra_mot_cai_sus=$id_diferencial ORDER BY relacao_diferencial; ";

  // $sql  = "SELECT * FROM relacao_diferencial ORDER BY relacao_diferencial; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_relacao_diferencial()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_entre_eixos
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_entre_eixos($paramPOST, $paramREMOTE) {

  $id_eixo = $paramPOST['relacao_diferencial'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_entre_eixos()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent id_entre_eixos, entre_eixos ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus_rel_ent JOIN entre_eixos ON mod_tra_mot_cai_sus_rel_ent.id_entre_eixos=entre_eixos.id_entre_eixos ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai_sus_rel= $id_eixo ORDER BY entre_eixos;";

  // $sql = "SELECT * FROM entre_eixos ORDER BY entre_eixos; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_entre_eixos()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_tanque
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_tanque($paramPOST, $paramREMOTE) {

  $id_tanque = $paramPOST['entre_eixos'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_tanque()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent_tan id_tanque, tanque ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus_rel_ent_tan JOIN tanque ON mod_tra_mot_cai_sus_rel_ent_tan.id_tanque=tanque.id_tanque ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai_sus_rel_ent= $id_tanque ORDER BY tanque; ";

  // $sql = "SELECT * FROM tanque ORDER BY tanque; ";


  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_tanque()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_pneu
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_pneu($paramPOST, $paramREMOTE) {

  $id_pneu = $paramPOST['tanque'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_pneu()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent_tan_pne id_pneu, pneu ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus_rel_ent_tan_pne JOIN pneu ON mod_tra_mot_cai_sus_rel_ent_tan_pne.id_pneu=pneu.id_pneu ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai_sus_rel_ent_tan=$id_pneu ORDER BY pneu; ";

  // $sql = "SELECT * FROM pneu ORDER BY pneu; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_pneu()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_pacote_acabamento
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_pacote_acabamento($paramPOST, $paramREMOTE) {

  $id_pacote = $paramPOST['pneu'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_pacote_acabamento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent_tan_pne_pac id_pacote_acabamento, pacote pacote_acabamento ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus_rel_ent_tan_pne_pac JOIN pacote_acabamento ON mod_tra_mot_cai_sus_rel_ent_tan_pne_pac.id_pacote=pacote_acabamento.id_pacote ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai_sus_rel_ent_tan_pne=$id_pacote ORDER BY pacote; ";

  // $sql = "SELECT id_pacote id_pacote_acabamento, pacote pacote_acabamento FROM pacote_acabamento ORDER BY pacote;; ";


  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_pacote_acabamento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_cabine
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_cabine($paramPOST, $paramREMOTE) {

  $id_cabine = $paramPOST['pacote_acabamento'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_cabine()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab id_cabine, cabine ";
  $sql = $sql . "FROM mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab JOIN cabine ON mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab.id_cabine=cabine.id_cabine ";
  $sql = $sql . "WHERE id_mod_tra_mot_cai_sus_rel_ent_tan_pne_pac=$id_cabine ORDER BY cabine; ";

  // $sql  = "SELECT * FROM cabine ORDER BY cabine; ";


  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_cabine()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_segmento
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_segmento($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_segmento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM segmento ORDER BY segmento; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_segmento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Selecione novamente o item para buscar as opções da lista.');
  }

}

/*
 * @function IORDER_lista_pedidos
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_lista_pedidos($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  P - pedido
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // nome do campo que sera ordenado
  $id_colaborador= trimupper($paramPOST['id_colaborador']);

  // Paginacao para pesquisa retornar um volume menor
  // $lim_ini   = $paramPOST['lim_ini'];
  // $lim_qtd   = $paramPOST['lim_qtd'];

  // Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_lista_pedidos()',$sql,$device,$login,$nome_completo,$ipaddress);

  // if ( hasContent($id_colaborador) == 0 ) {
  //   returnJson(-1, "Colaborador não informado. Pesquisa cancelada.");
  // }

  // Valida o status do colaborado para saber se ele é um código 3 - Dirigente Concessionarias
  $colaborador = APP_recupera_cargo_colaborador($device);
  if(sizeof($colaborador) == 1) {
    $id_colaborador = $colaborador[0]['id_colaborador'];
    $id_cargo       = $colaborador[0]['id_cargo'];
  }

  // if($id_cargo == 3) {
  //   $sql = "SELECT id_concessionaria FROM colaborador WHERE id_colaborador = $id_colaborador; ";
  //   $res = query($sql);
  //   $id_concessionaria = $res[0]['id_concessionaria'];
  // }

  // Pesquisa
  if ($buscaTipo == 'N') { // pesquisa por NOME
    if (hasContent($buscaTexto) == 0) { // Sem conteudo a procurar lista tudo
      if($id_cargo == 3) {
        // $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        // $sql = $sql . "FROM iorder  ";
        // $sql = $sql . "WHERE grupo = $id_colaborador ";
        // $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder ";
        $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "SELECT id_grupo_financeiro FROM concessionaria WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "SELECT id_grupo_financeiro  ";
        $sql = $sql . "FROM concessionaria ";
        $sql = $sql . "WHERE id_concessionaria = ( ";
        $sql = $sql . "SELECT cl.id_concessionaria  ";
        $sql = $sql . "FROM colaborador cl  ";
        $sql = $sql . "WHERE id_colaborador = $id_colaborador) ";
        $sql = $sql . ") ";
        $sql = $sql . ") ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

      } else {
        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder  ";
        $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";
      }
    } else {
      if($id_cargo == 3) {
        // $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        // $sql = $sql ."FROM iorder ";
        // $sql = $sql ."WHERE AND upper(cliente_nome) LIKE upper('%$buscaTexto%') ";
        // $sql = $sql ."UNION ";
        // $sql = $sql ."SELECT id_iorder, data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        // $sql = $sql ."FROM iorder   ";
        // $sql = $sql ."WHERE upper(contato_nome) LIKE upper('%$buscaTexto%') ";
        // $sql = $sql ."ORDER BY STATUS DESC, data_hora_pedido DESC;  ";

        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d\/%m\/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql ."FROM iorder  ";
        $sql = $sql ."WHERE id_grupo_financeiro IN (  ";
        $sql = $sql ."   SELECT id_grupo_financeiro  ";
        $sql = $sql ."   FROM concessionaria  ";
        $sql = $sql ."   WHERE id_grupo_financeiro IN (  ";
        $sql = $sql ."      SELECT id_grupo_financeiro   ";
        $sql = $sql ."      FROM concessionaria  ";
        $sql = $sql ."      WHERE id_concessionaria = (  ";
        $sql = $sql ."         SELECT cl.id_concessionaria  ";
        $sql = $sql ."         FROM colaborador cl   ";
        $sql = $sql ."         WHERE id_colaborador = $id_colaborador ";
        $sql = $sql ."      )  ";
        $sql = $sql ."   )  ";
        $sql = $sql .")  ";
        $sql = $sql ."AND upper(cliente_nome) LIKE upper('%$buscaTexto%') ";
        $sql = $sql ."UNION ";
        $sql = $sql ."SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d\/%m\/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status`  ";
        $sql = $sql ."FROM iorder  ";
        $sql = $sql ."WHERE id_grupo_financeiro IN (  ";
        $sql = $sql ."   SELECT id_grupo_financeiro  ";
        $sql = $sql ."   FROM concessionaria  ";
        $sql = $sql ."   WHERE id_grupo_financeiro IN (  ";
        $sql = $sql ."      SELECT id_grupo_financeiro   ";
        $sql = $sql ."      FROM concessionaria  ";
        $sql = $sql ."      WHERE id_concessionaria = (  ";
        $sql = $sql ."         SELECT cl.id_concessionaria  ";
        $sql = $sql ."         FROM colaborador cl   ";
        $sql = $sql ."         WHERE id_colaborador = $id_colaborador ";
        $sql = $sql ."      )  ";
        $sql = $sql ."   )  ";
        $sql = $sql .")  ";
        $sql = $sql ."AND upper(contato_nome) LIKE upper('%$buscaTexto%') ";
        $sql = $sql ."ORDER BY STATUS DESC, data_hora_pedido DESC; ";

      } else {
        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql ."FROM iorder ";
        $sql = $sql ."WHERE id_colaborador = $id_colaborador ";
        $sql = $sql ."AND upper(cliente_nome) LIKE upper('%$buscaTexto%') ";
        $sql = $sql ."UNION ";
        $sql = $sql ."SELECT id_iorder, data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql ."FROM iorder   ";
        $sql = $sql ."WHERE id_colaborador = $id_colaborador ";
        $sql = $sql ."AND upper(contato_nome) LIKE upper('%$buscaTexto%') ";
        $sql = $sql ."ORDER BY STATUS DESC, data_hora_pedido DESC;  ";

    }

    }
  } else { // Pesquisa por numero do pedido
    if(hasContent($buscaTexto) == 0) {
      if($id_cargo == 3) {
        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder ";
        $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "SELECT id_grupo_financeiro FROM concessionaria WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "SELECT id_grupo_financeiro  ";
        $sql = $sql . "FROM concessionaria ";
        $sql = $sql . "WHERE id_concessionaria = ( ";
        $sql = $sql . "SELECT cl.id_concessionaria  ";
        $sql = $sql . "FROM colaborador cl  ";
        $sql = $sql . "WHERE id_colaborador = $id_colaborador) ";
        $sql = $sql . ") ";
        $sql = $sql . ") ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

      } else {
        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder  ";
        $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";
      }

    } else { // Pedido digitado
      if($id_cargo == 3) {
        $sql  = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d\/%m\/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder ";
        $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "   SELECT id_grupo_financeiro ";
        $sql = $sql . "   FROM concessionaria ";
        $sql = $sql . "   WHERE id_grupo_financeiro IN ( ";
        $sql = $sql . "      SELECT id_grupo_financeiro ";
        $sql = $sql . "      FROM concessionaria ";
        $sql = $sql . "      WHERE id_concessionaria = ( ";
        $sql = $sql . "         SELECT cl.id_concessionaria ";
        $sql = $sql . "         FROM colaborador cl ";
        $sql = $sql . "         WHERE id_colaborador = $id_colaborador ";
        $sql = $sql . "      ) ";
        $sql = $sql . "   ) ";
        $sql = $sql . ") ";
        $sql = $sql . "AND id_iorder = $buscaTexto ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

      } else {
        $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, contato_nome, `status` ";
        $sql = $sql . "FROM iorder  ";
        $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
        $sql = $sql . "AND id_iorder = $buscaTexto ";
        $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";
      }
    }

  }

  // returnJson(-1, $sql);

  // returnJson(0,"debug", array(array("SQL:" => $sql));
  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('IORDER_lista_pedidos() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('IORDER_lista_pedidos() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Atenção, não foi criterio de pesquisa não encontrado.');
  }

}

/*
 * @function IORDER_detalhe_pedido
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_detalhe_pedido($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_iorder= trimupper($paramPOST['id_iorder']);

  // Padrao
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_detalhe_pedido()',$sql,$device,$login,$nome_completo,$ipaddress);

  if ( hasContent($id_iorder) == 0 ) {
    returnJson(-1, "Numero do Pedido não informado. Pesquisa cancelada.");
  }

  $sql = "SELECT * ";
  $sql = $sql . "FROM iorder i, concessionaria c, grupo g ";
  $sql = $sql . "WHERE i.id_concessionaria = c.id_concessionaria ";
  $sql = $sql . "AND g.id_grupo = c.id_grupo_financeiro ";
  $sql = $sql . "AND id_iorder = $id_iorder; ";

  // returnJson(0,"debug", array(array("SQL:" => $sql));
  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('IORDER_detalhe_pedido() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('IORDER_detalhe_pedido() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Atenção, não foi criterio de pesquisa não encontrado.');
  }

}

/*
 * @function IORDER_cor
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_cor($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_cor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM cor; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('IORDER_cor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de cor.');
  }

}

/*
 * @function IORDER_cliente_busca
 * @parameter $_POST, $_REMOTE
 *
 */
function IORDER_busca_pedido($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_concessionaria = $paramPOST['id_concessionaria'];

  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // nome do campo que sera ordenado

  //
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - IORDER_cliente_busca()',$sql,$device,$login,$nome_completo,$ipaddress);

  if ( hasContent($buscaTipo) == 0 ) {
    returnJson(-1, "Tipo de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  // if (hasContent($buscaTexto) == 0) {
  //   returnJson(-1, "Deve ser informado um critério de pesquisa. Pesquisa cancelada.");
  // }

  if (hasContent($buscaOrdem) == 0) {
    returnJson(-1, "Ordem de pesquisa deve ser informado. Pesquisa cancelada.");
  }

  // if (strlen($buscaTexto) < 3) {
  //   returnJson(-1, "Critério de pesquisa deve ter no mínimo 3 letras. Pesquisa cancelada.");
  // }

  // recupera o nome do colaborador para gravar ao pedido
  // $dados_colaborador = APP_recupera_colaborador($device);
  // $id_colaborador = $dados_colaborador[0]['id_colaborador'];
  // $colaborador    = $dados_colaborador[0]['nome_cracha'];

  // Valida se tem conteudo
  if ($buscaTipo == 'N') {

    if(hasContent($buscaTexto) <> 0) {
      $sql = "SELECT cl.id_iorder, DATE_FORMAT(cl.data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, cl.modelo, cl.quantidade, cl.cliente_nome, cl.colaborador, cl.status ";
      $sql = $sql . "FROM iorder cl ";
      $sql = $sql . "WHERE upper(cl.cliente_nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND cl.id_concessionaria = $id_concessionaria ";
      $sql = $sql . "UNION DISTINCT ";
      $sql = $sql . "SELECT co.id_iorder, DATE_FORMAT(co.data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, co.modelo, co.quantidade, co.cliente_nome, co.colaborador, co.status ";
      $sql = $sql . "FROM iorder co ";
      $sql = $sql . "WHERE upper(co.contato_nome) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND co.id_concessionaria = $id_concessionaria ";
      $sql = $sql . "UNION DISTINCT ";
      $sql = $sql . "SELECT co.id_iorder, DATE_FORMAT(co.data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, co.modelo, co.quantidade, co.cliente_nome, co.colaborador, co.status ";
      $sql = $sql . "FROM iorder co ";
      $sql = $sql . "WHERE upper(co.colaborador) LIKE upper('%$buscaTexto%') ";
      $sql = $sql . "AND co.id_concessionaria = $id_concessionaria ";
      $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";
    } else {
      $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, colaborador, status ";
      $sql = $sql . "FROM iorder ";
      $sql = $sql . "WHERE id_concessionaria = $id_concessionaria ";
      $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

    }

  } else {

    if(hasContent($buscaTexto) <> 0) {
      $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, colaborador, status  ";
      $sql = $sql . "FROM iorder ";
      $sql = $sql . "WHERE id_iorder = $buscaTexto ";
      $sql = $sql . "AND id_concessionaria = $id_concessionaria ";
      $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

    } else {
      $sql = "SELECT id_iorder, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido, modelo, quantidade, cliente_nome, colaborador, status  ";
      $sql = $sql . "FROM iorder ";
      $sql = $sql . "WHERE id_concessionaria = $id_concessionaria ";
      $sql = $sql . "ORDER BY STATUS DESC, data_hora_pedido DESC; ";

    }

  }

  // returnJson(-1, $sql);

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('IORDER_cliente_busca() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('IORDER_cliente_busca() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Atenção, não foi criterio de pesquisa não encontrado.');
  }

}

/*
 * @function IORDER_detalhe
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function IORDER_detalhe($paramPOST, $paramREMOTE) {

  // recupera o ID do iORDER para detalhar
  $id_iorder = $paramPOST['id_iorder'];

  auditoriaLog('IORDER_detalhe().',$sql,$device,$login,$nome_completo,$ipaddress);

  $ret = IORDER_busca_id($id_iorder, $paramREMOTE);

  returnJson(0, "Sucesso", $ret);

}

/*
 * @function IORDER_atualiza_status
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function IORDER_atualiza_status($paramPOST, $paramREMOTE) {

  // recupera o ID do iORDER para detalhar
  $id_iorder = $paramPOST['id_iorder'];
  $status    = $paramPOST['status'];

  // atualiza o status
  $sql = "UPDATE iorder SET `status` = upper('$status') WHERE id_iorder = $id_iorder; ";

  auditoriaLog('IORDER_atualiza_status().',$sql,$device,$login,$nome_completo,$ipaddress);

  $result = query( $sql );

  if (!$resul['error']) {
    returnJson(0, "Gravado com sucesso.");
  } else {
    returnJson(-1, "Erro ao atualziar status. Gravação cancelada.");
  }

}

// /*
//  * @function assinatura_nome
//  * @parameter $paramPOST, $paramREMOTE
//  *
//  */
// function assinatura_nome() {
//    $length = 5;
//    $characters = 'abcdefghijklmnopqrstuvwxyz';
//    $string = '';
//    for ($p = 0; $p < $length; $p++) {
//       $string .= $characters[mt_rand(0, strlen($characters))];
//    }
//    return $string . '.jpg';
// }

/*
 * @function IORDER_envia_assinatura
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function IORDER_envia_assinatura($paramPOST, $paramREMOTE) {

  $id_iorder   = $paramPOST['id_iorder'];
  $campo       = $paramPOST['campo'];
  $status      = $paramPOST['status'];
  $gerente_nome= $paramPOST['gerente_nome'];

  // if($campo  == 'assinatura_gerente') {
  //   $sql  = "UPDATE iorder SET " . $campo . " = '$status', gerente_nome = '$gerente_nome' WHERE id_iorder = $id_iorder; ";
  // } else {
    $sql  = "UPDATE iorder SET " . $campo . " = '$status' WHERE id_iorder = $id_iorder; ";
  // }

  auditoriaLog('Begin - IORDER_envia_assinatura()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $grava = query($sql);

  if($grava['error']) {
    returnJson(-1,"Parabéns por efetuar mais uma venda.",$search['error']);
    // Erro gravando status assinatura
  }

  returnJson(0, "Sucesso");
}

/*
 * @function IORDER_envia_assinatura
 * @parameter $paramPOST, $paramREMOTE
 *
 */
// function IORDER_envia_assinatura($paramPOST, $paramREMOTE) {

//   // recupera o ID do iORDER para detalhar
//   $id_iorder = $paramPOST['id_iorder'];
//   $status    = $paramPOST['status'];

//   // atualiza o status
//   $sql = "UPDATE iorder SET `status` = upper('$status') WHERE id_iorder = $id_iorder; ";

//   auditoriaLog('IORDER_envia_assinatura().',$sql,$device,$login,$nome_completo,$ipaddress);

//   $result = query( $sql );

//   if (!$resul['error']) {
//     returnJson(0, "Gravado com sucesso.");
//   } else {
//     returnJson(-1, "Erro ao atualziar status. Gravação cancelada.");
//   }

// }

// // Array ( [photo] => Array ( [name] => [type] => [tmp_name] => [error] => 4 [size] => 0 ) )
// // Array ( [photo] => Array ( [name] => pyper.png [type] => image/png [tmp_name] => \xampp\tmp\php17.tmp [error] => 0 [size] => 199457 ) )

// if ( $_FILES['photo'][size] > 0 ) {

//         // Prepara a variável caso o formulário tenha sido postado
//         $arquivo = isset($_FILES["photo"]) ? $_FILES["photo"] : FALSE;

//         $config = array();
//         // Tamano máximo da imagem, em bytes
//         $config["tamanho"] = 506883;
//         // Largura Máxima, em pixels
//         $config["largura"] = 160;
//         // Altura Máxima, em pixels
//         $config["altura"] = 200;
//         // Diretório onde a imagem será salva
//         $config["diretorio"] = "customer_pic/";

//         if($arquivo) {
//             $erro = array();

//             // Verifica o mime-type do arquivo para ver se é de imagem.
//             // Caso fosse verificar a extensão do nome de arquivo, o código deveria ser:
//             //
//             // if(!eregi("\.(jpg|jpeg|bmp|gif|png){1}$", $arquivo["name"])) {
//             //      $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo"; }
//             //
//             // Mas, o que ocorre é que alguns usuários mal-intencionados, podem pegar um vírus .exe e simplesmente mudar a extensão
//             // para alguma das imagens e enviar. Então, não adiantaria em nada verificar a extensão do nome do arquivo.
//            if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
//                 $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, gif ou png. Envie outro arquivo";
//             } else {
//                 // Verifica tamanho do arquivo
//                 if($arquivo["size"] > $config["tamanho"]) {
//                     $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
//                 }

//                 // Para verificar as dimensões da imagem
//                 $tamanhos = getimagesize($arquivo["tmp_name"]);

//                 // Verifica largura
//                 if($tamanhos[0] > $config["largura"]) {
//                     $erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
//                 }

//                 // Verifica altura
//                 if($tamanhos[1] > $config["altura"]) {
//                     $erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
//                 }
//             }

//             if(!sizeof($erro)) {
//                 // Pega extensão do arquivo, o indice 1 do array conterá a extensão
//                 preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

//                 // Gera nome único para a imagem
//                 $imagem_nome = nome($ext[1]);

//                 // Caminho de onde a imagem ficará
//                 $imagem_dir = $config["diretorio"] . $imagem_nome;

//                 // Faz o upload da imagem
//                 move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

//                         $caminho_foto = $imagem_nome;
//             }else{
//                         echo "<h1>" . $erro[0] . "</h1>";
//                         exit;
//                 }
//         }
// }

// Gera um nome para a imagem e verifica se já não existe, caso exista, gera outro nome e assim sucessivamente..
// Função Recursiva
// function nome($extensao) {
//     global $config;

//     // Gera um nome único para a imagem
//     $temp = substr(md5(uniqid(time())), 0, 10);
//     $imagem_nome = $temp . "." . $extensao;

//     // Verifica se o arquivo já existe, caso positivo, chama essa função novamente
//     if(file_exists($config["diretorio"] . $imagem_nome)) {
//         $imagem_nome = nome($extensao);
//     }

//     return $imagem_nome;
// }



// https://github.com/wborbajr/Leal/blob/f1f13b2f7c4ff62d0508544ec1926861bc368683/customer.php


