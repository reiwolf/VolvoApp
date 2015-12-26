<?php
/***********************************************************************************************
 *   apiPM.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function PM_modelo
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_modelo($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_modelo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_modelo, modelo ";
  $sql = $sql . "FROM modelo ORDER BY modelo; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_modelo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de modelos.');
  }

}

/*
 * @function PM_tracao
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_tracao($paramPOST, $paramREMOTE) {

  $id_modelo = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // Lista todos os modelos
  // $sql = "SELECT id_mod_tra id_tracao, tracao ";
  $sql = "SELECT m.id_mod_tra id_tracao, t.tracao  ";
  $sql = $sql . "FROM tracao t ";
  $sql = $sql . "JOIN mod_tra m ";
  $sql = $sql . "ON t.id_tracao = m.id_tracao ";
  $sql = $sql . "WHERE m.id_modelo = $id_modelo ";
  $sql = $sql . "ORDER BY tracao; ";

  auditoriaLog('Begin - PM_tracao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_tracao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de tração.');
  }

}

/*
 * @function PM_motor
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_motor($paramPOST, $paramREMOTE) {

  $id_tracao  = $paramPOST['tracao'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_motor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot id_motor, motor ";
  $sql = $sql ."FROM motor mo  ";
  $sql = $sql ."JOIN mod_tra_mot mt ";
  $sql = $sql ."ON mo.id_motor = mt.id_motor ";
  $sql = $sql ."WHERE id_mod_tra = $id_tracao ";
  $sql = $sql ."ORDER BY motor; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_motor()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de motor.');
  }

}

/*
 * @function PM_caixa_cambio
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_caixa_cambio($paramPOST, $paramREMOTE) {

  $id_motor = $paramPOST['motor'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_caixa_cambio()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT id_mod_tra_mot_cai id_caixa_cambio, caixa_cambio ";
  $sql = $sql . "FROM caixa_cambio cx ";
  $sql = $sql . "JOIN mod_tra_mot_cai mc ";
  $sql = $sql . "ON mc.id_caixa_cambio = cx.id_caixa_cambio ";
  $sql = $sql . "WHERE id_mod_tra_mot = $id_motor ";
  $sql = $sql . "ORDER BY caixa_cambio; ";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_caixa_cambio()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de caixa de cambio.');
  }

}

/*
 * @function PM_eixo_traseiro
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_eixo_traseiro($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_eixo_traseiro()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM eixo_traseiro ORDER BY eixo_traseiro;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_eixo_traseiro()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de eixo traseiro.');
  }

}

/*
 * @function PM_tipo_implemento
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_tipo_implemento($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_tipo_implemento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM tipo_implemento ORDER BY tipo_implemento;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_tipo_implemento()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de tipo de implemento.');
  }

}

/*
 * @function PM_ciclo_transporte
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_ciclo_transporte($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_ciclo_transporte()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM ciclo_transporte ORDER BY ciclo_transporte;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_ciclo_transporte()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de ciclo de transporte.');
  }

}

/*
 * @function PM_classe_servico
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_classe_servico($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_classe_servico()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM classe_servico ORDER BY classe_servico;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_classe_servico()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de classe de serviço.');
  }

}

/*
 * @function PM_condicao_estrada
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_condicao_estrada($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_condicao_estrada()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM condicao_estrada ORDER BY condicao_estrada;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_condicao_estrada()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de condição de estrada.');
  }

}

/*
 * @function PM_topografia
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_topografia($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_topografia()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM topografia ORDER BY topografia;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_topografia()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de topografia.');
  }

}

/*
 * @function PM_pbtc
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_pbtc($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_pbtc()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM pbtc ORDER BY pbtc;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_pbtc()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de pbtc.');
  }

}

/*
 * @function PM_fora_estrada
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_fora_estrada($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_fora_estrada()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM fora_estrada ORDER BY fora_estrada;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_fora_estrada()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de possibilidades fora da estrada.');
  }

}

/*
 * @function PM_duracao_contrato
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_duracao_contrato($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_duracao_contrato()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM duracao_contrato ORDER BY duracao_contrato;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_duracao_contrato()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de duração de contrato.');
  }

}

/*
 * @function PM_km_mensal
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_km_mensal($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_km_mensal()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM km_mensal ORDER BY km_mensal;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_km_mensal()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de km mensais.');
  }

}

/*
 * @function PM_km_inicial
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_km_inicial($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_km_inicial()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM km_inicial ORDER BY km_inicial;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_km_inicial()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de km inicial.');
  }

}

/*
 * @function PM_ano_entrega
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_ano_entrega($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_ano_entrega()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM ano_entrega ORDER BY ano_entrega;";

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_ano_entrega()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (isset($result)) {
      returnJson(0,'Sucesso.', $result);
    }
  } else {
    returnJson(-1,'Erro recuperando lista de ano de entrega.');
  }

}

/*
 * @function PM_cliente_busca
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_cliente_busca($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // nome do campo que sera ordenado

  // Paginacao para pesquisa retornar um volume menor
  $lim_ini   = $paramPOST['lim_ini'];
  $lim_qtd   = $paramPOST['lim_qtd'];

  //
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_cliente_busca()',$sql,$device,$login,$nome_completo,$ipaddress);

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

  // Valida se tem conteudo
  if ($buscaTipo == 'N') {
    $sql = "SELECT cl.id_cliente, cl.nome, cl.cpf_cnpj, cl.endereco, cl.grupo, id_iorder, STATUS, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT JOIN iorder io ";
    $sql = $sql . "ON cl.id_cliente = io.id_cliente ";
    $sql = $sql . "WHERE upper(nome) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "UNION ";
    $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.cpf_cnpj, cl.endereco, cl.grupo, id_iorder, STATUS, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido  ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT JOIN iorder io ";
    $sql = $sql . "ON cl.id_cliente = io.id_cliente ";
    $sql = $sql . "WHERE upper(nome) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "UNION  ";
    $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.cpf_cnpj, cl.endereco, cl.grupo, id_iorder, STATUS, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT JOIN iorder io ";
    $sql = $sql . "ON cl.id_cliente = io.id_cliente ";
    $sql = $sql . "WHERE upper(cl.grupo) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "UNION ";
    $sql = $sql . "SELECT cl.id_cliente, cl.nome, cl.cpf_cnpj, cl.endereco, cl.grupo, id_iorder, STATUS, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido  ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT JOIN iorder io ";
    $sql = $sql . "ON cl.id_cliente = io.id_cliente ";
    $sql = $sql . "WHERE upper(cl.grupo) LIKE upper('%$buscaTexto%') ";
    $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
    // $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";

  } else {
    $cpf_cnpj = APP_remove_mascara_CPFCNPJ($buscaTexto);


    $sql = "SELECT cl.id_cliente, cl.nome, cl.cpf_cnpj, cl.endereco, cl.grupo, id_iorder, STATUS, DATE_FORMAT(data_hora_pedido,'%d/%m/%Y %T') data_hora_pedido  ";
    $sql = $sql . "FROM cliente cl ";
    $sql = $sql . "LEFT JOIN iorder io ";
    $sql = $sql . "ON cl.id_cliente = io.id_cliente ";
    $sql = $sql . "WHERE REPLACE(REPLACE(REPLACE(cpf_cnpj,'.',''),'/',''),'-','') LIKE '$cpf_cnpj%' ";
    $sql = $sql . "ORDER BY $buscaOrdem ASC; ";
    // $sql = $sql . "LIMIT $lim_ini, $lim_qtd; ";

  }

  // returnJson(-1, $sql);

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('PM_cliente_busca() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('PM_cliente_busca() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Atenção, criterio de pesquisa não encontrado.');
  }

}

/*
 * @function PM_combinacao_curva
 * @parameter $_POST, $_REMOTE
 * @return curva
 *
 */
function PM_combinacao_curva($paramPOST, $paramREMOTE) {

  $id_modelo = $paramPOST['id_modelo'];
  // $id_tracao = $paramPOST['id_tracao'];
  $id_mod_tra = $paramPOST['id_tracao'];
  $id_ciclo_transporte = $paramPOST['id_ciclo_transporte'];
  $id_classe_servico   = $paramPOST['id_classe_servico'];

  // recupera o id da tracao
  $sql = "SELECT id_tracao ";
  $sql = $sql . "FROM tracao ";
  $sql = $sql . "WHERE id_tracao IN (SELECT id_tracao FROM mod_tra WHERE id_mod_tra = $id_mod_tra); ";

  // returnJson(-1, $sql);

  $tracao = query($sql);
  $id_tracao = $tracao[0]['id_tracao'];
  //

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  if(hasContent($id_modelo) == 0 || hasContent($id_tracao) == 0 || hasContent($id_ciclo_transporte) == 0 || hasContent($id_classe_servico) == 0 ) {
    returnJson(-1, "Atenção, para prosseguir é necessário informar Modelo, Tração, Ciclo de Transporte e Classe de Serviço");
  }

  auditoriaLog('Begin - PM_combinacao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Combinacao
  $sql = "SELECT * ";
  $sql = $sql ."FROM pm_combinacao ";
  $sql = $sql ."WHERE id_modelo = $id_modelo ";
  $sql = $sql ."AND id_tracao = $id_tracao ";
  $sql = $sql ."AND id_ciclo_transporte = $id_ciclo_transporte ";
  $sql = $sql ."AND id_classe_servico = $id_classe_servico; ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_combinacao()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (curva)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (curva)');
  }

}

/*
 * @function PM_custo_contrato
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_custo_contrato($paramPOST, $paramREMOTE) {

  $km_inicial          = $paramPOST['km_inicial'];
  $id_duracao_contrato = $paramPOST['id_duracao_contrato'];
  $id_km_mensal        = $paramPOST['id_km_mensal'];
  $curva               = $paramPOST['curva'];
  $ano_contratado      = $paramPOST['ano_entrega'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_custo_contrato()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $sql = "SELECT upfactor ano_entrega, a.* ";
  $sql = $sql . "FROM ano_entrega,  ";
  $sql = $sql . "(   ";
  $sql = $sql . "  SELECT TRUNCATE(sum($curva),4) custo_contrato FROM pm_curva where km  ";
  $sql = $sql . "  between ((select km_inicial from km_inicial where km_inicial=$km_inicial))  ";
  $sql = $sql . "  AND ((select km_inicial from km_inicial where km_inicial=$km_inicial) +  ";
  $sql = $sql . "    (select duracao_contrato from duracao_contrato where id_duracao_contrato=$id_duracao_contrato) *  ";
  $sql = $sql . "    (select km_mensal from km_mensal where id_km_mensal=$id_km_mensal)) ";
  $sql = $sql . ") a   ";
  $sql = $sql . "WHERE ano_entrega = $ano_contratado; ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if($result[0]['custo_contrato'] == 0) {
    returnJson(-1,'Custo não disponível. (custo contrato soma = 0)');
  }

  if (!$result['error']) {
    auditoriaLog('PM_custo_contrato()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Verifica se a curva calculada é maior que o limite e retorna custo nao disponivel
    $sql = "SELECT valor_final FROM pm_curva_final WHERE curva = '$curva'; ";

    $curva = query($sql);

    if( $result[0]['custo_contrato'] > $curva[0]['valor_final'] ) {
      returnJson(-1,'Custo não disponível. (custo contrato)');
    }
    //

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (custo contrato)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (custo contrato)');
  }

}

/*
 * @function PM_km_total_contratado
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_km_total_contratado($paramPOST, $paramREMOTE) {

  $id_duracao_contrato = $paramPOST['id_duracao_contrato'];
  $id_km_mensal        = $paramPOST['id_km_mensal'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_km_total_contratado()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT  ";
  $sql = $sql ."((SELECT km_mensal ";
  $sql = $sql ."FROM km_mensal ";
  $sql = $sql ."WHERE id_km_mensal = $id_km_mensal) ";
  $sql = $sql ."* ";
  $sql = $sql ."(SELECT duracao_contrato FROM duracao_contrato ";
  $sql = $sql ."WHERE id_duracao_contrato = $id_duracao_contrato)) km_total_contratada; ";


  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_km_total_contratado()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (km_total_contratado)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (km_total_contratado)');
  }

}

/*
 * @function PM_km_final_contratado
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_km_final_contratado($paramPOST, $paramREMOTE) {

  $id_duracao_contrato = $paramPOST['id_duracao_contrato'];
  $id_km_mensal        = $paramPOST['id_km_mensal'];
  $id_km_inicial       = $paramPOST['id_km_inicial'];


  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_km_final_contratado()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT  ";
  $sql = $sql . "((SELECT km_mensal ";
  $sql = $sql . "FROM km_mensal ";
  $sql = $sql . "WHERE id_km_mensal = $id_km_mensal) ";
  $sql = $sql . "* ";
  $sql = $sql . "(SELECT duracao_contrato FROM duracao_contrato ";
  $sql = $sql . "WHERE id_duracao_contrato = $id_duracao_contrato) ";
  $sql = $sql . "+ ";
  $sql = $sql . "(SELECT km_inicial ";
  $sql = $sql . "FROM km_inicial ";
  $sql = $sql . "WHERE id_km_inicial = $id_km_inicial) ";
  $sql = $sql . ")  km_final; ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_km_final_contratado()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (km_final_contratado)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (km_final_contratado)');
  }

}

/*
 * @function PM_custo_progressivo
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_custo_progressivo($paramPOST, $paramREMOTE) {

  $id_duracao_contrato = $paramPOST['id_duracao_contrato'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_custo_progressivo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT * FROM pm_custo_progressivo ";
  $sql = $sql . "WHERE id_duracao_contrato = $id_duracao_contrato; ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_custo_progressivo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (custo_progressivo)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (custo_progressivo)');
  }

}

/*
 * @function PM_bonus
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_bonus($paramPOST, $paramREMOTE) {

  $id_evento           = $paramPOST['id_evento'];
  $linha               = substr(trim($paramPOST['modelo']),0,1);
  $id_duracao_contrato = $paramPOST['id_duracao_contrato'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_bonus()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // Lista todos os modelos
  $sql = "SELECT pb.limite, pb.bonus, ev.meta_bonus_pm ";
  $sql = $sql . "FROM pm_bonus pb, evento ev ";
  $sql = $sql . "WHERE trim(pb.linha) = '$linha' ";
  $sql = $sql . "AND pb.id_duracao_contrato = $id_duracao_contrato ";
  $sql = $sql . "AND ev.id_evento = $id_evento; ";

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    auditoriaLog('PM_bonus()',$sql,$device,$usuario,$nome_completo,$ipaddress);

    // Valida se retornou conteudo
    if (sizeof($result) > 0) {
      returnJson(0,'Sucesso.', $result);
    } else {
      returnJson(-1,'Custo não disponível. (_bonus)');
    }
  } else {
    returnJson(-1,'Custo não disponível. (_bonus)');
  }

}

/*
 * @function PM_bonus_disponivel
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_calcula_bonus_disponivel($paramPOST, $paramREMOTE) {

  $id_evento            = $paramPOST['id_evento'];
  $linha                = substr(trim($paramPOST['modelo']),0,1);
  $id_duracao_contrato  = $paramPOST['id_duracao_contrato'];
  $valor_bonus          = $paramPOST['valor_bonus'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $bonus_volvo = 0;
  $bonus_conce = 0;

  auditoriaLog('Begin - PM_bonus_disponivel()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // parametros do bonus
  $sql = "SELECT pb.limite, pb.bonus, ev.meta_bonus_pm ";
  $sql = $sql . "FROM pm_bonus pb, evento ev ";
  $sql = $sql . "WHERE trim(pb.linha) = trim('$linha') ";
  $sql = $sql . "AND pb.id_duracao_contrato = $id_duracao_contrato ";
  $sql = $sql . "AND ev.id_evento = $id_evento; ";

  $result = query($sql);
  $result = query($sql);

  $limite        = $result[0]['limite'];
  $bonus         = $result[0]['bonus'];
  $meta_bonus_pm = $result[0]['meta_bonus_pm'];

  // returnJson(-1, $limite . ' - ' . $bonus . ' - ' . $meta_bonus_pm);

  // total bonus ja distribuidos
  $sql = "SELECT ( ";
  $sql = $sql . "( ";
  $sql = $sql . "SELECT ev.meta_bonus_pm ";
  $sql = $sql . "FROM pm_bonus pb, evento ev ";
  $sql = $sql . "WHERE trim(pb.linha) = trim('$linha') ";
  $sql = $sql . "AND pb.id_duracao_contrato = $id_duracao_contrato ";
  $sql = $sql . "AND ev.id_evento = $id_evento ";
  $sql = $sql . ")  ";
  $sql = $sql . "-  ";
  $sql = $sql . "(SELECT sum(pm.bonus_volvo) FROM pm) ) disponivel ";
  $sql = $sql . "FROM DUAL; ";

  $result = query($sql);

  $disponivel = $result[0]['disponivel'];

  // returnJson(-1, $sql ); //'disponivel ' . $disponivel);

  // verifica se ainda tem bonus disponivel
  if ( $disponivel > 0 ) {

    // verifica se o
    if ($valor_bonus > $limite ) {
       $bonus_volvo = $limite;
    } else {
       $bonus_volvo = (($valor_bonus)*($bonus/100));
    }

    $bonus_conce = $valor_bonus - $bonus_volvo;

  } else {
    $disponivel  = 0;
    $bonus_conce = $valor_bonus;
  }

  // verifica se ainda tem bonus disponivel da volvo
  $sql = "SELECT sum(pm.bonus_volvo) disponivel_volvo; ";
  $sql = $sql . "FROM pm; ";

  $result = query($sql);

  $disponivel_volvo = $result[0]['disponivel_volvo'];

  $acumulado_volvo = $meta_bonus_pm - $disponivel_volvo;

  // verifica se o bonus da volvo é mais que o acumulado ja liberado
  if ($bonus_volvo > $acumulado_volvo) {
    $bonus_volvo = 0;
    $bonus_conce = $valor_bonus;
  }

  returnJson(0, 'Sucesso', array(array('volvo'=>$bonus_volvo, 'concessionaria'=>$bonus_conce)));

}

/*
 * @function PM_grupo
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_grupo($paramPOST, $paramREMOTE) {
  APP_grupo($paramPOST, $paramREMOTE);
}

/*
 * @function PM_pm_grava
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function PM_pm_grava($paramPOST, $paramREMOTE) {

  // // Recupera os dados
  // $id_pm                  = $paramPOST['id_pm'];
  // $id_cliente             = (strlen($paramPOST['id_cliente']) == 0 ? 0 : $paramPOST['id_cliente']);
  // $id_iorder              = (hasContent($paramPOST['id_iorder'] == 0 ? NULL : $paramPOST['id_iorder']));
  // $modelo                 = trimupper($paramPOST['modelo']) ;
  // $tracao                 = trimupper($paramPOST['tracao']) ;
  // $motor                  = trimupper($paramPOST['motor']) ;
  // $caixa_cambio           = trimupper($paramPOST['caixa_cambio']) ;
  // $eixo_traseiro          = trimupper($paramPOST['eixo_traseiro']) ;
  // $qtde_veiculo           = trimupper($paramPOST['qtde_veiculo']) ;
  // $num_motorista          = trimupper($paramPOST['num_motorista']) ;
  // $tipo_implemento        = trimupper($paramPOST['tipo_implemento']) ;
  // $ciclo_transporte       = trimupper($paramPOST['ciclo_transporte']) ;
  // $classe_servico         = trimupper($paramPOST['classe_servico']) ;
  // $condicao_estrada       = trimupper($paramPOST['condicao_estrada']) ;
  // $topografia             = trimupper($paramPOST['topografia']) ;
  // $pbtc                   = trimupper($paramPOST['pbtc']) ;
  // $fora_estrada           = trimupper($paramPOST['fora_estrada']) ;
  // $duracao_contrato       = trimupper($paramPOST['duracao_contrato']) ;
  // $km_inicial             = trimupper($paramPOST['km_inicial']) ;
  // $km_mensal              = trimupper($paramPOST['km_mensal']) ;
  // $ano_entrega            = trimupper($paramPOST['ano_entrega']) ;
  // $intervalo_motor        = trimupper($paramPOST['intervalo_motor']) ;
  // $intervalo_caixa        = trimupper($paramPOST['intervalo_caixa']) ;
  // $intervalo_diferencial  = trimupper($paramPOST['intervalo_diferencial']) ;
  // $observacao             = trimupper($paramPOST['observacao']);
  // $km_total_contratada    = trimupper($paramPOST['km_total_contratada']) ;
  // $km_final_contratada    = trimupper($paramPOST['km_final_contratada']) ;
  // $custo_linear           = trimupper($paramPOST['custo_linear']) ;
  // $prestacao_mensal_linear= trimupper($paramPOST['prestacao_mensal_linear']) ;
  // $ano1_custo             = trimupper($paramPOST['ano1_custo']) ;
  // $ano1_prestacao         = trimupper($paramPOST['ano1_prestacao']) ;
  // $ano2_custo             = trimupper($paramPOST['ano2_custo']) ;
  // $ano2_prestacao         = trimupper($paramPOST['ano2_prestacao']) ;
  // $ano3_custo             = trimupper($paramPOST['ano3_custo']) ;
  // $ano3_prestacao         = trimupper($paramPOST['ano3_prestacao']) ;
  // $ano4_custo             = trimupper($paramPOST['ano4_custo']) ;
  // $ano4_prestacao         = trimupper($paramPOST['ano4_prestacao']) ;
  // $ano5_custo             = trimupper($paramPOST['ano5_custo']) ;
  // $ano5_prestacao         = trimupper($paramPOST['ano5_prestacao']) ;
  // $bonus_concessionaria   = trimupper($paramPOST['bonus_concessionaria']) ;
  // $bonus_volvo            = trimupper($paramPOST['bonus_volvo']) ;
  // $custo_linear_bonus     = trimupper($paramPOST['custo_linear_bonus']) ;
  // $prestacao_mensal_linear_bonus = trimupper($paramPOST['prestacao_mensal_linear_bonus']) ;
  // $ano1_custo_bonus       = trimupper($paramPOST['ano1_custo_bonus']) ;
  // $ano1_prestacao_bonus   = trimupper($paramPOST['ano1_prestacao_bonus']) ;
  // $ano2_custo_bonus       = trimupper($paramPOST['ano2_custo_bonus']) ;
  // $ano2_prestacao_bonus   = trimupper($paramPOST['ano2_prestacao_bonus']) ;
  // $ano3_custo_bonus       = trimupper($paramPOST['ano3_custo_bonus']) ;
  // $ano3_prestacao_bonus   = trimupper($paramPOST['ano3_prestacao_bonus']) ;
  // $ano4_custo_bonus       = trimupper($paramPOST['ano4_custo_bonus']) ;
  // $ano4_prestacao_bonus   = trimupper($paramPOST['ano4_prestacao_bonus']) ;
  // $ano5_custo_bonus       = trimupper($paramPOST['ano5_custo_bonus']) ;
  // $ano5_prestacao_bonus   = trimupper($paramPOST['ano5_prestacao_bonus']) ;
  // $assinatura_cliente     = trimupper($paramPOST['assinatura_cliente']) ;
  // $assinatura_gerente     = trimupper($paramPOST['assinatura_gerente']) ;
  // $status                 = trimupper($paramPOST['status']);

  // // campos novos para fazer os calculos
  // $id_modelo               = (strlen($paramPOST['id_modelo']) == 0 ? 0 : $paramPOST['id_modelo']);
  // $id_tracao               = (strlen($paramPOST['id_tracao']) == 0 ? 0 : $paramPOST['id_tracao']);
  // $id_motor                = (strlen($paramPOST['id_motor']) == 0 ? 0 : $paramPOST['id_motor']);trimupper($paramPOST['']);
  // $id_caixa_cambio         = (strlen($paramPOST['id_caixa_cambio']) == 0 ? 0 : $paramPOST['id_caixa_cambio']);
  // $id_eixo_traseiro        = (strlen($paramPOST['id_eixo_traseiro']) == 0 ? 0 : $paramPOST['id_eixo_traseiro']);
  // $id_tipo_implemento      = (strlen($paramPOST['id_tipo_implemento']) == 0 ? 0 : $paramPOST['id_tipo_implemento']);
  // $id_ciclo_transporte     = (strlen($paramPOST['id_ciclo_transporte']) == 0 ? 0 : $paramPOST['id_ciclo_transporte']);
  // $id_classe_servico       = (strlen($paramPOST['id_classe_servico']) == 0 ? 0 : $paramPOST['id_classe_servico']);
  // $id_condicao_estrada     = (strlen($paramPOST['id_condicao_estrada']) == 0 ? 0 : $paramPOST['id_condicao_estrada']);
  // $id_topografia           = (strlen($paramPOST['id_topografia']) == 0 ? 0 : $paramPOST['id_topografia']);
  // $id_pbtc                 = (strlen($paramPOST['id_pbtc']) == 0 ? 0 : $paramPOST['id_pbtc']);
  // $id_duracao_contrato     = (strlen($paramPOST['id_duracao_contrato']) == 0 ? 0 : $paramPOST['id_duracao_contrato']);
  // $id_km_inicial           = (strlen($paramPOST['id_km_inicial']) == 0 ? 0 : $paramPOST['id_km_inicial']);
  // $id_km_mensal            = (strlen($paramPOST['id_km_mensal']) == 0 ? 0 : $paramPOST['id_km_mensal']);
  // $nome                    = (strlen($paramPOST['nome']) == 0 ? 0 : $paramPOST['nome']);
  // $grupo                   = $paramPOST['grupo'];
  // $id_colaborador          = $paramPOST['id_colaborador'];
  // $nome_cracha            = trimupper(currentValue($paramPOST['nome_cracha'])) ;

  // // Padrao
  // // $tela                    = $paramPOST['tela'];
  // $device                  = trim($paramPOST['device']);
  // $ipaddress               = $paramREMOTE['REMOTE_ADDR'];

  // returnJson(-1, ; VJEA;)

  // auditoriaLog('Begin - ((PM_pm_grava))',$sql,$device,$login,$nome_completo,$ipaddress,$tela);

  // // seta para 0
  // $qtde_veiculo            = (hasContent($qtde_veiculo)  == 0 ? 0 : $qtde_veiculo);
  // $num_motorista           = (hasContent($num_motorista)  == 0 ? 0 : $num_motorista);
  // $pbtc                    = (hasContent($pbtc)  == 0 ? 0 : $pbtc);
  // $bonus_concessionaria    = (hasContent($bonus_concessionaria)  == 0 ? 0 : $bonus_concessionaria);
  // $bonus_volvo             = (hasContent($bonus_volvo)  == 0 ? 0 : $bonus_volvo);
  // $duracao_contrato        = (hasContent($duracao_contrato)  == 0 ? 0 : $duracao_contrato);

  // // if(hasContent($id_pm) == 0){
  // //   if(hasContent($nome) == 0) {
  // //     returnJson(-1,"Nome do cliente deve ter conteúdo. Gravação cancelada.");
  // //   }
  // // }

  // // recupera o nome do colaborador para gravar ao pedido
  // $dados_colaborador = APP_recupera_colaborador($device);
  // $id_colaborador    = $dados_colaborador[0]['id_colaborador'];
  // $colaborador       = trimupper($dados_colaborador[0]['nome_cracha']);
  // $id_concessionaria = $dados_colaborador[0]['id_concessionaria'];

  // // recupera o grupo do consultor logado
  // $sql  = "SELECT gr.id_grupo, gr.grupo ";
  // $sql  = $sql . "FROM colaborador co, concessionaria cs, grupo gr ";
  // $sql  = $sql . "WHERE co.device = '$device' ";
  // $sql  = $sql . "AND cs.id_concessionaria = co.id_concessionaria ";
  // $sql  = $sql . "AND cs.id_grupo_financeiro = gr.id_grupo; ";

  // $result = query($sql);

  // $id_grupo_financeiro = $result[0]['id_grupo'];
  // $grupo               = $result[0]['grupo'];
  // //

  // // Valida se tem conteudo para acionar como insert ou update
  // $isInsert = (hasContent($id_pm) == 0);;

  // if ($isInsert) {

  //   $sql = "INSERT INTO pm ";
  //   $sql = $sql . "( ";
  //   $sql = $sql . "id_cliente,";
  //   $sql = $sql . "id_iorder,";
  //   $sql = $sql . "modelo,";
  //   $sql = $sql . "tracao,";
  //   $sql = $sql . "motor,";
  //   $sql = $sql . "caixa_cambio,";
  //   $sql = $sql . "eixo_traseiro,";
  //   $sql = $sql . "qtde_veiculo,";
  //   $sql = $sql . "num_motorista,";
  //   $sql = $sql . "tipo_implemento,";
  //   $sql = $sql . "ciclo_transporte,";
  //   $sql = $sql . "classe_servico,";
  //   $sql = $sql . "condicao_estrada,";
  //   $sql = $sql . "topografia,";
  //   $sql = $sql . "pbtc,";
  //   $sql = $sql . "fora_estrada,";
  //   $sql = $sql . "duracao_contrato,";
  //   $sql = $sql . "km_inicial,";
  //   $sql = $sql . "km_mensal,";
  //   $sql = $sql . "ano_entrega,";
  //   $sql = $sql . "intervalo_motor,";
  //   $sql = $sql . "intervalo_caixa,";
  //   $sql = $sql . "intervalo_diferencial,";
  //   $sql = $sql . "observacao,";
  //   $sql = $sql . "km_total_contratada,";
  //   $sql = $sql . "km_final_contratada,";
  //   $sql = $sql . "custo_linear,";
  //   $sql = $sql . "prestacao_mensal_linear,";
  //   $sql = $sql . "ano1_custo,";
  //   $sql = $sql . "ano1_prestacao,";
  //   $sql = $sql . "ano2_custo,";
  //   $sql = $sql . "ano2_prestacao,";
  //   $sql = $sql . "ano3_custo,";
  //   $sql = $sql . "ano3_prestacao,";
  //   $sql = $sql . "ano4_custo,";
  //   $sql = $sql . "ano4_prestacao,";
  //   $sql = $sql . "ano5_custo,";
  //   $sql = $sql . "ano5_prestacao,";
  //   $sql = $sql . "bonus_concessionaria,";
  //   $sql = $sql . "bonus_volvo,";
  //   $sql = $sql . "custo_linear_bonus,";
  //   $sql = $sql . "prestacao_mensal_linear_bonus,";
  //   $sql = $sql . "ano1_custo_bonus,";
  //   $sql = $sql . "ano1_prestacao_bonus,";
  //   $sql = $sql . "ano2_custo_bonus,";
  //   $sql = $sql . "ano2_prestacao_bonus,";
  //   $sql = $sql . "ano3_custo_bonus,";
  //   $sql = $sql . "ano3_prestacao_bonus,";
  //   $sql = $sql . "ano4_custo_bonus,";
  //   $sql = $sql . "ano4_prestacao_bonus,";
  //   $sql = $sql . "ano5_custo_bonus,";
  //   $sql = $sql . "ano5_prestacao_bonus,";
  //   $sql = $sql . "assinatura_cliente,";
  //   $sql = $sql . "assinatura_gerente,";
  //   $sql = $sql . "status,";
  //   $sql = $sql . "id_modelo,";
  //   $sql = $sql . "id_tracao,";
  //   $sql = $sql . "id_motor,";
  //   $sql = $sql . "id_caixa_cambio,";
  //   $sql = $sql . "id_eixo_traseiro,";
  //   $sql = $sql . "id_tipo_implemento,";
  //   $sql = $sql . "id_ciclo_transporte,";
  //   $sql = $sql . "id_classe_servico,";
  //   $sql = $sql . "id_condicao_estrada,";
  //   $sql = $sql . "id_topografia,";
  //   $sql = $sql . "id_pbtc,";
  //   $sql = $sql . "id_duracao_contrato,";
  //   $sql = $sql . "id_km_inicial,";
  //   $sql = $sql . "id_km_mensal,";
  //   $sql = $sql . "nome,";
  //   $sql = $sql . "id_grupo_financeiro,";
  //   $sql = $sql . "grupo,";
  //   $sql = $sql . "id_concessionaria,";
  //   $sql = $sql . "data_hora_pm,";
  //   $sql = $sql . "id_colaborador,";
  //   $sql = $sql . "nome_cracha";
  //   $sql = $sql . ") ";
  //   $sql = $sql . "VALUES ";
  //   $sql = $sql . "( ";
  //   $sql = $sql . "$id_cliente,";
  //   $sql = $sql . "$id_iorder,";
  //   $sql = $sql . "'$modelo',";
  //   $sql = $sql . "'$tracao',";
  //   $sql = $sql . "'$motor',";
  //   $sql = $sql . "'$caixa_cambio',";
  //   $sql = $sql . "'$eixo_traseiro',";
  //   $sql = $sql . "'$qtde_veiculo',";
  //   $sql = $sql . "'$num_motorista',";
  //   $sql = $sql . "'$tipo_implemento',";
  //   $sql = $sql . "'$ciclo_transporte',";
  //   $sql = $sql . "'$classe_servico',";
  //   $sql = $sql . "'$condicao_estrada',";
  //   $sql = $sql . "'$topografia',";
  //   $sql = $sql . "'$pbtc',";
  //   $sql = $sql . "'$fora_estrada',";
  //   $sql = $sql . "'$duracao_contrato',";
  //   $sql = $sql . "'$km_inicial',";
  //   $sql = $sql . "'$km_mensal',";
  //   $sql = $sql . "'$ano_entrega',";
  //   $sql = $sql . "'$intervalo_motor',";
  //   $sql = $sql . "'$intervalo_caixa',";
  //   $sql = $sql . "'$intervalo_diferencial',";
  //   $sql = $sql . "'$observacao',";
  //   $sql = $sql . "'$km_total_contratada',";
  //   $sql = $sql . "'$km_final_contratada',";
  //   $sql = $sql . "'$custo_linear',";
  //   $sql = $sql . "'$prestacao_mensal_linear',";
  //   $sql = $sql . "'$ano1_custo',";
  //   $sql = $sql . "'$ano1_prestacao',";
  //   $sql = $sql . "'$ano2_custo',";
  //   $sql = $sql . "'$ano2_prestacao',";
  //   $sql = $sql . "'$ano3_custo',";
  //   $sql = $sql . "'$ano3_prestacao',";
  //   $sql = $sql . "'$ano4_custo',";
  //   $sql = $sql . "'$ano4_prestacao',";
  //   $sql = $sql . "'$ano5_custo',";
  //   $sql = $sql . "'$ano5_prestacao',";
  //   $sql = $sql . "'$bonus_concessionaria',";
  //   $sql = $sql . "'$bonus_volvo',";
  //   $sql = $sql . "'$custo_linear_bonus',";
  //   $sql = $sql . "'$prestacao_mensal_linear_bonus',";
  //   $sql = $sql . "'$ano1_custo_bonus',";
  //   $sql = $sql . "'$ano1_prestacao_bonus',";
  //   $sql = $sql . "'$ano2_custo_bonus',";
  //   $sql = $sql . "'$ano2_prestacao_bonus',";
  //   $sql = $sql . "'$ano3_custo_bonus',";
  //   $sql = $sql . "'$ano3_prestacao_bonus',";
  //   $sql = $sql . "'$ano4_custo_bonus',";
  //   $sql = $sql . "'$ano4_prestacao_bonus',";
  //   $sql = $sql . "'$ano5_custo_bonus',";
  //   $sql = $sql . "'$ano5_prestacao_bonus',";
  //   $sql = $sql . "'$assinatura_cliente',";
  //   $sql = $sql . "'$assinatura_gerente',";
  //   $sql = $sql . "'$status',";
  //   $sql = $sql . "$id_modelo,";
  //   $sql = $sql . "$id_tracao,";
  //   $sql = $sql . "$id_motor,";
  //   $sql = $sql . "$id_caixa_cambio,";
  //   $sql = $sql . "$id_eixo_traseiro,";
  //   $sql = $sql . "$id_tipo_implemento,";
  //   $sql = $sql . "$id_ciclo_transporte,";
  //   $sql = $sql . "$id_classe_servico,";
  //   $sql = $sql . "$id_condicao_estrada,";
  //   $sql = $sql . "$id_topografia,";
  //   $sql = $sql . "$id_pbtc,";
  //   $sql = $sql . "$id_duracao_contrato,";
  //   $sql = $sql . "$id_km_inicial,";
  //   $sql = $sql . "$id_km_mensal,";
  //   $sql = $sql . "'$nome',";
  //   $sql = $sql . "'$id_grupo_financeiro',";
  //   $sql = $sql . "'$grupo',";
  //   $sql = $sql . "$id_concessionaria,";
  //   $sql = $sql . "CURRENT_TIMESTAMP(),";
  //   $sql = $sql . "$id_colaborador,";
  //   $sql = $sql . "'$nome_cracha'";
  //   $sql = $sql . ");";
  // } else {
  //   $sql = "UPDATE pm SET ";
  //   $sql = $sql . "id_cliente             = $id_cliente,";
  //   $sql = $sql . "id_iorder              = $id_iorder,";
  //   $sql = $sql . "modelo                 = upper('$modelo'),";
  //   $sql = $sql . "tracao                 = '$tracao',";
  //   $sql = $sql . "motor                  = '$motor',";
  //   $sql = $sql . "caixa_cambio           = '$caixa_cambio',";
  //   $sql = $sql . "eixo_traseiro          = '$eixo_traseiro',";
  //   $sql = $sql . "qtde_veiculo           = '$qtde_veiculo',";
  //   $sql = $sql . "num_motorista          = '$num_motorista',";
  //   $sql = $sql . "tipo_implemento        = '$tipo_implemento',";
  //   $sql = $sql . "ciclo_transporte       = '$ciclo_transporte',";
  //   $sql = $sql . "classe_servico         = '$classe_servico',";
  //   $sql = $sql . "condicao_estrada       = '$condicao_estrada',";
  //   $sql = $sql . "topografia             = '$topografia',";
  //   $sql = $sql . "pbtc                   = '$pbtc',";
  //   $sql = $sql . "fora_estrada           = '$fora_estrada',";
  //   $sql = $sql . "duracao_contrato       = '$duracao_contrato',";
  //   $sql = $sql . "km_inicial             = '$km_inicial',";
  //   $sql = $sql . "km_mensal              = '$km_mensal',";
  //   $sql = $sql . "ano_entrega            = '$ano_entrega',";
  //   $sql = $sql . "intervalo_motor        = '$intervalo_motor',";
  //   $sql = $sql . "intervalo_caixa        = '$intervalo_caixa',";
  //   $sql = $sql . "intervalo_diferencial  = '$intervalo_diferencial',";
  //   $sql = $sql . "observacao             = '$observacao',";
  //   $sql = $sql . "km_total_contratada    = '$km_total_contratada',";
  //   $sql = $sql . "km_final_contratada    = '$km_final_contratada',";
  //   $sql = $sql . "custo_linear           = '$custo_linear',";
  //   $sql = $sql . "prestacao_mensal_linear= '$prestacao_mensal_linear',";
  //   $sql = $sql . "ano1_custo             = '$ano1_custo',";
  //   $sql = $sql . "ano1_prestacao         = '$ano1_prestacao',";
  //   $sql = $sql . "ano2_custo             = '$ano2_custo',";
  //   $sql = $sql . "ano2_prestacao         = '$ano2_prestacao',";
  //   $sql = $sql . "ano3_custo             = '$ano3_custo',";
  //   $sql = $sql . "ano3_prestacao         = '$ano3_prestacao',";
  //   $sql = $sql . "ano4_custo             = '$ano4_custo',";
  //   $sql = $sql . "ano4_prestacao         = '$ano4_prestacao',";
  //   $sql = $sql . "ano5_custo             = '$ano5_custo',";
  //   $sql = $sql . "ano5_prestacao         = '$ano5_prestacao',";
  //   $sql = $sql . "bonus_concessionaria   = '$bonus_concessionaria',";
  //   $sql = $sql . "bonus_volvo            = '$bonus_volvo',";
  //   $sql = $sql . "custo_linear_bonus     = '$custo_linear_bonus',";
  //   $sql = $sql . "prestacao_mensal_linear_bonus = '$prestacao_mensal_linear_bonus',";
  //   $sql = $sql . "ano1_custo_bonus       = '$ano1_custo_bonus',";
  //   $sql = $sql . "ano1_prestacao_bonus   = '$ano1_prestacao_bonus',";
  //   $sql = $sql . "ano2_custo_bonus       = '$ano2_custo_bonus',";
  //   $sql = $sql . "ano2_prestacao_bonus   = '$ano2_prestacao_bonus',";
  //   $sql = $sql . "ano3_custo_bonus       = '$ano3_custo_bonus',";
  //   $sql = $sql . "ano3_prestacao_bonus   = '$ano3_prestacao_bonus',";
  //   $sql = $sql . "ano4_custo_bonus       = '$ano4_custo_bonus',";
  //   $sql = $sql . "ano4_prestacao_bonus   = '$ano4_prestacao_bonus',";
  //   $sql = $sql . "ano5_custo_bonus       = '$ano5_custo_bonus',";
  //   $sql = $sql . "ano5_prestacao_bonus   = '$ano5_prestacao_bonus',";
  //   $sql = $sql . "assinatura_cliente     = '$assinatura_cliente',";
  //   $sql = $sql . "assinatura_gerente     = '$assinatura_gerente',";
  //   $sql = $sql . "status                 = '$status',";
  //   $sql = $sql . "id_modelo               = $id_modelo,";
  //   $sql = $sql . "id_tracao               = $id_tracao,";
  //   $sql = $sql . "id_motor                = $id_motor,";
  //   $sql = $sql . "id_caixa_cambio         = $id_caixa_cambio,";
  //   $sql = $sql . "id_eixo_traseiro        = $id_eixo_traseiro,";
  //   $sql = $sql . "id_tipo_implemento      = $id_tipo_implemento,";
  //   $sql = $sql . "id_ciclo_transporte     = $id_ciclo_transporte,";
  //   $sql = $sql . "id_classe_servico       = $id_classe_servico,";
  //   $sql = $sql . "id_condicao_estrada     = $id_condicao_estrada,";
  //   $sql = $sql . "id_topografia           = $id_topografia,";
  //   $sql = $sql . "id_pbtc                 = $id_pbtc,";
  //   $sql = $sql . "id_duracao_contrato     = $id_duracao_contrato,";
  //   $sql = $sql . "id_km_inicial           = $id_km_inicial,";
  //   $sql = $sql . "id_km_mensal            = $id_km_mensal,";
  //   $sql = $sql . "nome                    = '$nome',";
  //   $sql = $sql . "id_grupo_financeiro     = '$id_grupo_financeiro',";
  //   $sql = $sql . "grupo                   = '$grupo',";
  //   $sql = $sql . "id_concessionaria       = '$id_concessionaria',";
  //   $sql = $sql . "data_hora_pm            = CURRENT_TIMESTAMP(),";
  //   $sql = $sql . "id_colaborador          = $id_colaborador,";
  //   $sql = $sql . "nome_cracha             = '$nome_cracha'";
  //   $sql = $sql . " WHERE id_pm=$id_pm ;";
  // }

  // auditoriaLog('PM_pm_grava() - {AUDITA SQL}',$sql,$device,$login,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  // $save = query($sql);

  // if (!$save['error']) {

  //   auditoriaLog('PM_pm_grava() - PM salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

  //   // recupera o ID do cliente novo
  //   if( $isInsert ) {
  //     $id_pm = $save['newid'];
  //   }

  //   $data = PM_busca_id($id_pm, $paramREMOTE);

  //   // Grava o registro para faze ro delta
  //   APP_insert_table_control($device, $id_pm, 'pm');

  //   returnJson(0,'PM salvo com sucesso.', $data);

  // } else {
  //   auditoriaLog('PM_pm_grava() - Erro ao salvar PM.',$sql,$device,$login,$nome_completo,$ipaddress);
  //   returnJson(-1,'Erro ao salvar PM.');
  // }

}

/*
 * @function PM_busca_id
 * @parameter $id, $paramREMOTE
 *
 */
function PM_busca_id($id, $paramREMOTE) {

  // Recupera os dados
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT * FROM pm WHERE id_pm = $id;";

  auditoriaLog('Begin - PM_busca_id()',$sql,$device,$login,$nome_completo,$ipaddress);

  $search = query($sql);

  // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    return $search;
  }

}

/*
 * @function PM_busca
 * @parameter $_POST, $_REMOTE
 *
 */
function PM_busca($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $buscaTexto= trimupper($paramPOST['buscaTexto']);  // elemento a ser procurado
  $buscaTipo = trimupper($paramPOST['buscaTipo']);   // N - nome  C - cpf_cnpj
  $buscaOrdem= trimupper($paramPOST['buscaOrdem']);  // nome do campo que sera ordenado

  //
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_cliente_busca()',$sql,$device,$login,$nome_completo,$ipaddress);

  // if ( hasContent($buscaTipo) == 0 ) {
  //   returnJson(-1, "Tipo de pesquisa deve ser informado. Pesquisa cancelada.");
  // }

  // if (hasContent($buscaTexto) == 0) {
  //   returnJson(0, "Deve ser informado um critério de pesquisa. Pesquisa cancelada.");
  //   exit();
  // }

  // if (hasContent($buscaOrdem) == 0) {
  //   returnJson(-1, "Ordem de pesquisa deve ser informado. Pesquisa cancelada.");
  // }

  // if (strlen($buscaTexto) < 3) {
  //   returnJson(-1, "Critério de pesquisa deve ter no mínimo 3 letras. Pesquisa cancelada.");
  // }

    // Recupera o ID do colaborador
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador    = $dados_colaborador[0]['id_colaborador'];
  // $nome_cracha      = $dados_colaborador[0]['nome_cracha'];


  // Valida se tem conteudo
  if ($buscaTipo == 'N') {
    if (hasContent($buscaTexto) == 0) {

      $sql = "SELECT id_pm, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T') data_hora_pm, modelo, qtde_veiculo, nome, grupo, upper(STATUS) status, nome_cracha, id_grupo_financeiro ";
      $sql = $sql . "FROM pm ";
      $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
      $sql = $sql . "SELECT cs.id_grupo_financeiro ";
      $sql = $sql . "FROM concessionaria cs, colaborador co ";
      $sql = $sql . "WHERE cs.id_concessionaria = co.id_concessionaria ";
      $sql = $sql . "AND co.id_colaborador = $id_colaborador ); ";

    } else {
      // $sql = "SELECT id_pm, data_hora_pm, modelo, qtde_veiculo, nome, grupo, status, nome_cracha  ";
      // $sql = $sql . "FROM pm ";
      // $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
      // $sql = $sql . "AND upper(nome) LIKE upper('%$buscaTexto%') ";
      // $sql = $sql . "ORDER BY status DESC, data_hora_pm, nome_cracha, nome; ";

      $sql = "SELECT id_pm, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T') data_hora_pm, modelo, qtde_veiculo, nome, grupo, STATUS, nome_cracha, id_grupo_financeiro  ";
      $sql = $sql . "FROM pm  ";
      $sql = $sql . "WHERE id_grupo_financeiro  ";
      $sql = $sql . "IN (  ";
      $sql = $sql . "SELECT id_grupo_financeiro   ";
      $sql = $sql . "FROM colaborador co, concessionaria cs   ";
      $sql = $sql . "WHERE id_colaborador = $id_colaborador   ";
      $sql = $sql . "AND co.id_concessionaria = cs.id_concessionaria )  ";
      $sql = $sql . "AND upper(nome)  ";
      $sql = $sql . "LIKE upper('%$buscaTexto%')  ";
      $sql = $sql . "UNION ";
      $sql = $sql . "SELECT id_pm, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T') data_hora_pm, modelo, qtde_veiculo, nome, grupo, STATUS, nome_cracha, id_grupo_financeiro   ";
      $sql = $sql . "FROM pm  ";
      $sql = $sql . "WHERE id_grupo_financeiro  ";
      $sql = $sql . "IN (  ";
      $sql = $sql . "SELECT id_grupo_financeiro   ";
      $sql = $sql . "FROM colaborador co, concessionaria cs   ";
      $sql = $sql . "WHERE id_colaborador = $id_colaborador   ";
      $sql = $sql . "AND co.id_concessionaria = cs.id_concessionaria )  ";
      $sql = $sql . "AND upper(nome_cracha)  ";
      $sql = $sql . "LIKE upper('%$buscaTexto%')  ";
      $sql = $sql . "ORDER BY STATUS DESC, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T'), nome_cracha, nome; ";

    }

  } else {

    if (hasContent($buscaTexto) == 0) {
      $sql = "SELECT id_pm, DATE_FORMAT(data_hora_pm,'%d/%m/%Y %T') data_hora_pm, modelo, qtde_veiculo, nome, grupo, STATUS, nome_cracha, id_grupo_financeiro  ";
      $sql = $sql . "FROM pm ";
      $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
      $sql = $sql . "SELECT id_grupo_financeiro ";
      $sql = $sql . " FROM colaborador co, concessionaria cs ";
      $sql = $sql . " WHERE id_colaborador = $id_colaborador ";
      $sql = $sql . " AND co.id_concessionaria = cs.id_concessionaria ";
      $sql = $sql . ") ";
      $sql = $sql . "ORDER BY STATUS DESC, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T'), nome_cracha, nome; ";

      // $sql = "SELECT id_pm, data_hora_pm, modelo, qtde_veiculo, nome, grupo, status, nome_cracha  ";
      // $sql = $sql . "FROM pm ";
      // $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
      // $sql = $sql . "ORDER BY status DESC, data_hora_pm, nome_cracha, nome; ";
    } else {
      // $sql = "SELECT id_pm, data_hora_pm, modelo, qtde_veiculo, nome, grupo, status, nome_cracha  ";
      // $sql = $sql . "FROM pm ";
      // $sql = $sql . "WHERE id_colaborador = $id_colaborador ";
      // $sql = $sql . "AND  id_pm = $buscaTexto ";
      // $sql = $sql . "ORDER BY status DESC, data_hora_pm, nome_cracha, nome; ";

      $sql = "SELECT id_pm, DATE_FORMAT(data_hora_pm,'%d/%m/%Y %T') data_hora_pm, modelo, qtde_veiculo, nome, grupo, STATUS, nome_cracha, id_grupo_financeiro  ";
      $sql = $sql . "FROM pm ";
      $sql = $sql . "WHERE id_grupo_financeiro IN ( ";
      $sql = $sql . "SELECT id_grupo_financeiro ";
      $sql = $sql . " FROM colaborador co, concessionaria cs ";
      $sql = $sql . " WHERE id_colaborador = $id_colaborador ";
      $sql = $sql . " AND co.id_concessionaria = cs.id_concessionaria ";
      $sql = $sql . ") ";
      $sql = $sql . "AND  id_pm = $buscaTexto ";
      $sql = $sql . "ORDER BY STATUS DESC, DATE_FORMAT(data_hora_pm,'%d\/%m\/%Y %T'), nome_cracha, nome; ";

    }

  }

  // returnJson(-1, $sql);

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$search['error']);
  }

  // se retornou 1 usuario encontrado
  if (sizeof($search) > 0) {
    auditoriaLog('PM_cliente_busca() - Pesquisa retornou resultado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('PM_cliente_busca() - Criterio de pesquisa não encontrado.',$sql,$device,$login,$nome_completo,$ipaddress);
    if(hasContent($buscaTexto) <> 0) {
      returnJson(-1,'Atenção, criterio de pesquisa não encontrado.');
    } else {
      returnJson(0,'Não existe pedidos para listar.');
      exit();
    }

  }

}

/*
 * @function PM_calculo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
// function PM_calculo($paramPOST, $paramREMOTE) {

//   // recupera o ID da PM para executar os calculos
//   $id_pm = $paramPOST['id_pm'];

//   $sql = "SELECT * FROM pm WHERE id_pm = $id_pm; ";
//   $pm  = query($sql);

//   // Calcula a curva
//   PM_combinacao_curva($paramPOST, $paramREMOTE);

// }

/*
 * @function PM_detalhe
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function PM_detalhe($paramPOST, $paramREMOTE) {

  // recupera o ID da PM para executar os calculos
  $id_pm = $paramPOST['id_pm'];

  auditoriaLog('PM_detalhe().',$sql,$device,$login,$nome_completo,$ipaddress);

  $ret = PM_busca_id($id_pm, $paramREMOTE);

  // Calcula a curva
  returnJson(0, "Sucesso", $ret);

}

/*
 * @function PM_atualiza_status
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function PM_atualiza_status($paramPOST, $paramREMOTE) {

  // recupera o ID do iORDER para detalhar
  $id_pm  = $paramPOST['id_pm'];
  $status = $paramPOST['status'];

  // atualiza o status
  $sql = "UPDATE pm SET `status` = upper('$status') WHERE id_pm = $id_pm; ";

  auditoriaLog('PM_atualiza_status().',$sql,$device,$login,$nome_completo,$ipaddress);

  $result = query( $sql );

  if (!$resul['error']) {
    returnJson(0, "Gravado com sucesso.");
  } else {
    returnJson(-1, "Erro ao atualziar status. Gravação cancelada.");
  }

}

/*
 * @function PM_grava_calculo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function PM_grava_calculo($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $id_pm                  = $paramPOST['id_pm'];
  $curva                  = trimupper($paramPOST['curva']) ;
  $km_total_contratada    = trimupper($paramPOST['km_total_contratada']) ;
  $km_final_contratada    = trimupper($paramPOST['km_final']) ;
  $custo_linear           = trimupper($paramPOST['custo_linear']) ;
  $prestacao_mensal_linear= trimupper($paramPOST['prestacao_mensal_linear']) ;
  $ano1_custo             = trimupper($paramPOST['ano1_custo']) ;
  $ano1_prestacao         = trimupper($paramPOST['ano1_prestacao']) ;
  $ano2_custo             = trimupper($paramPOST['ano2_custo']) ;
  $ano2_prestacao         = trimupper($paramPOST['ano2_prestacao']) ;
  $ano3_custo             = trimupper($paramPOST['ano3_custo']) ;
  $ano3_prestacao         = trimupper($paramPOST['ano3_prestacao']) ;
  $ano4_custo             = trimupper($paramPOST['ano4_custo']) ;
  $ano4_prestacao         = trimupper($paramPOST['ano4_prestacao']) ;
  $ano5_custo             = trimupper($paramPOST['ano5_custo']) ;
  $ano5_prestacao         = trimupper($paramPOST['ano5_prestacao']) ;
  $bonus_concessionaria   = trimupper($paramPOST['bonus_concessionaria']) ;
  $bonus_volvo            = trimupper($paramPOST['bonus_volvo']) ;
  $custo_linear_bonus     = trimupper($paramPOST['custo_linear_bonus']) ;
  $prestacao_mensal_linear_bonus = trimupper($paramPOST['prestacao_mensal_linear_bonus']) ;
  $ano1_custo_bonus       = trimupper($paramPOST['ano1_custo_bonus']) ;
  $ano1_prestacao_bonus   = trimupper($paramPOST['ano1_prestacao_bonus']) ;
  $ano2_custo_bonus       = trimupper($paramPOST['ano2_custo_bonus']) ;
  $ano2_prestacao_bonus   = trimupper($paramPOST['ano2_prestacao_bonus']) ;
  $ano3_custo_bonus       = trimupper($paramPOST['ano3_custo_bonus']) ;
  $ano3_prestacao_bonus   = trimupper($paramPOST['ano3_prestacao_bonus']) ;
  $ano4_custo_bonus       = trimupper($paramPOST['ano4_custo_bonus']) ;
  $ano4_prestacao_bonus   = trimupper($paramPOST['ano4_prestacao_bonus']) ;
  $ano5_custo_bonus       = trimupper($paramPOST['ano5_custo_bonus']) ;
  $ano5_prestacao_bonus   = trimupper($paramPOST['ano5_prestacao_bonus']) ;
  $custo_contrato         = trimupper($paramPOST['custo_contrato']);

  // Padrao
  $tela                    = $paramPOST['tela'];
  $device                  = trim($paramPOST['device']);
  $ipaddress               = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - PM_grava_calculo()',$sql,$device,$login,$nome_completo,$ipaddress,$tela);


  // Recupera o ID do colaborador
  $dados_colaborador = APP_recupera_colaborador($device);
  $id_colaborador    = $dados_colaborador[0]['id_colaborador'];
  $nome_cracha      = utf8_decode($dados_colaborador[0]['nome_cracha']);

  $sql = "UPDATE pm SET ";
  $sql = $sql . "curva                  = '$curva',";
  $sql = $sql . "km_total_contratada    = '$km_total_contratada',";
  $sql = $sql . "km_final_contratada    = '$km_final_contratada',";
  $sql = $sql . "custo_linear           = '$custo_linear',";
  $sql = $sql . "prestacao_mensal_linear= '$prestacao_mensal_linear',";
  $sql = $sql . "ano1_custo             = '$ano1_custo',";
  $sql = $sql . "ano1_prestacao         = '$ano1_prestacao',";
  $sql = $sql . "ano2_custo             = '$ano2_custo',";
  $sql = $sql . "ano2_prestacao         = '$ano2_prestacao',";
  $sql = $sql . "ano3_custo             = '$ano3_custo',";
  $sql = $sql . "ano3_prestacao         = '$ano3_prestacao',";
  $sql = $sql . "ano4_custo             = '$ano4_custo',";
  $sql = $sql . "ano4_prestacao         = '$ano4_prestacao',";
  $sql = $sql . "ano5_custo             = '$ano5_custo',";
  $sql = $sql . "ano5_prestacao         = '$ano5_prestacao',";
  $sql = $sql . "bonus_concessionaria   = '$bonus_concessionaria',";
  $sql = $sql . "bonus_volvo            = '$bonus_volvo',";
  $sql = $sql . "custo_linear_bonus     = '$custo_linear_bonus',";
  $sql = $sql . "prestacao_mensal_linear_bonus = '$prestacao_mensal_linear_bonus',";
  $sql = $sql . "ano1_custo_bonus       = '$ano1_custo_bonus',";
  $sql = $sql . "ano1_prestacao_bonus   = '$ano1_prestacao_bonus',";
  $sql = $sql . "ano2_custo_bonus       = '$ano2_custo_bonus',";
  $sql = $sql . "ano2_prestacao_bonus   = '$ano2_prestacao_bonus',";
  $sql = $sql . "ano3_custo_bonus       = '$ano3_custo_bonus',";
  $sql = $sql . "ano3_prestacao_bonus   = '$ano3_prestacao_bonus',";
  $sql = $sql . "ano4_custo_bonus       = '$ano4_custo_bonus',";
  $sql = $sql . "ano4_prestacao_bonus   = '$ano4_prestacao_bonus',";
  $sql = $sql . "ano5_custo_bonus       = '$ano5_custo_bonus',";
  $sql = $sql . "ano5_prestacao_bonus   = '$ano5_prestacao_bonus', ";
  $sql = $sql . "custo_contrato         = '$custo_contrato' ";
  $sql = $sql . " WHERE id_pm=$id_pm ;";

  auditoriaLog('PM_grava_calculo() - {AUDITA SQL}',$sql,$device,$login,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $save = query($sql);

  if (!$save['error']) {

    auditoriaLog('PM_pm_grava() - PM salvo com sucesso',$sql,$device,$login,$nome_completo,$ipaddress);

    // recupera o ID do cliente novo
    if( $isInsert ) {
      $id_pm = $save['newid'];
    }

    $data = PM_busca_id($id_pm, $paramREMOTE);

    // Grava o registro para faze ro delta
    APP_insert_table_control($device, $id_pm, 'pm');

    returnJson(0,'PM salvo com sucesso.', $data);

  } else {
    auditoriaLog('PM_grava_calculo() - Erro ao salvar PM.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Erro ao salvar PM.');
  }

}

/*
 * @function PM_grava_bonus
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function PM_grava_bonus($paramPOST, $paramREMOTE) {

  // recupera o ID do iORDER para detalhar
  $id_pm                = $paramPOST['id_pm'];
  $bonus_volvo          = $paramPOST['bonus_volvo'];
  $bonus_concessionaria = $paramPOST['bonus_concessionaria'];
  $total_bonus          = $paramPOST['total_bonus'];

  // atualiza o status
  $sql = "UPDATE pm SET ";
  $sql = $sql . "bonus_volvo = $bonus_volvo, ";
  $sql = $sql . "bonus_concessionaria = $bonus_concessionaria, ";
  $sql = $sql . "total_bonus = $total_bonus ";
  $sql = $sql . "WHERE id_pm = $id_pm; ";

  auditoriaLog('PM_grava_bonus().',$sql,$device,$login,$nome_completo,$ipaddress);

  $result = query( $sql );

  if (!$result['error']) {
    returnJson(0, "Gravado com sucesso.");
  } else {
    returnJson(-1, "Erro ao gravar bonus. Gravação cancelada.");
  }

}


