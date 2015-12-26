<?php
/***********************************************************************************************
 *   apiDASHBOARD.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

// ----------------------------------------------------------------------------------------------
// --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM --- CRM ---
// ----------------------------------------------------------------------------------------------

/*
 * @function DASH_crm_cadastro
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_crm_cadastro($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(1) total, substr(date_format(data_atual, '%T'),1,2) hora ";
  $sql = $sql . "FROM cliente ";
  $sql = $sql . "WHERE data_atual BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "GROUP BY substr(date_format(data_atual, '%T'),1,2) ";
  $sql = $sql . "ORDER BY substr(date_format(data_atual, '%T'),1,2); ";

  auditoriaLog('Begin - DASH_crm_cadastro()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_crm_cadastro
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_crm_cadastro_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(1) total, substr(date_format(data_atual, '%T'),1,2) hora ";
  $sql = $sql . "FROM cliente ";
  $sql = $sql . "WHERE data_atual BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "GROUP BY substr(date_format(data_atual, '%T'),1,2) ";
  $sql = $sql . "ORDER BY substr(date_format(data_atual, '%T'),1,2); ";

  auditoriaLog('Begin - DASH_crm_cadastro()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_top10_consultora
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_top10_consultora($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  // $sql = "SELECT count(1) total, substring(co.nome_cracha,1,16) nome_cracha ";
  // $sql  = $sql . "FROM cliente cl, colaborador co ";
  // $sql  = $sql . "WHERE cl.data_atual BETWEEN '$data_inicial' AND '$data_final' ";
  // $sql  = $sql . "AND cl.id_colaborador = co.id_colaborador ";
  // $sql  = $sql . "GROUP BY co.nome_cracha ";
  // $sql  = $sql . "ORDER BY total DESC; ";

  $sql = "SELECT substring(co.nome_cracha,1,16) nome_cracha , count(1) total ";
  $sql = $sql ."FROM cliente cl, colaborador co ";
  $sql = $sql ."WHERE cl.id_colaborador IN ( ";
  $sql = $sql ."SELECT id_colaborador  ";
  $sql = $sql ." FROM colaborador  ";
  $sql = $sql ." WHERE nome_cracha LIKE 'VDB%' ";
  $sql = $sql .") ";
  $sql = $sql ."AND cl.id_colaborador = co.id_colaborador ";
  $sql = $sql ."AND cl.data_atual BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql ."GROUP BY co.nome_cracha ";
  $sql = $sql ."ORDER BY total DESC;   ";

  auditoriaLog('Begin - DASH_top10_consultora()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_cadastro_grupofin
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_cadastro_grupofin($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(1) as total, grupo ";
  $sql = $sql . "FROM cliente ";
  $sql = $sql . "WHERE data_atual IS NOT NULL ";
  $sql = $sql . "AND data_atual BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "GROUP BY grupo ";
  $sql = $sql . "ORDER BY grupo; ";

  auditoriaLog('Begin - DASH_cadastro_grupofin()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_etapas
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_etapas($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(tela) total, tela ";
  $sql = $sql . "FROM acao ";
  $sql = $sql . "GROUP BY tela; ";

  auditoriaLog('Begin - DASH_etapas()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}


// ----------------------------------------------------------------------------------------------
// --- iORDER --- iORDER --- iORDER --- iORDER --- iORDER --- iORDER --- iORDER --- iORDER ---
// ----------------------------------------------------------------------------------------------

/*
 * @function DASH_iorder_meta
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_iorder_meta($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo       = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  if($id_grupo_financeiro == 0){
    // -- volvo
    $sql = "SELECT sum(quantidade) quantidade,  ";
    $sql = $sql . "(SELECT meta_iorder FROM grupo WHERE id_grupo = 13) meta  ";
    $sql = $sql . "FROM iorder io, concessionaria co  ";
    $sql = $sql . "WHERE upper(io.status) = upper('aprovado')  ";
    $sql = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final'  ";
    $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;  ";

  } else {
    // -- por grupo
    $sql = "SELECT sum(quantidade) quantidade,  ";
    $sql = $sql . "(SELECT meta_iorder FROM grupo WHERE id_grupo = $id_grupo_financeiro) meta   ";
    $sql = $sql . "FROM iorder io, concessionaria co    ";
    $sql = $sql . "WHERE io.id_concessionaria IN (    ";
    $sql = $sql . "SELECT id_concessionaria    ";
    $sql = $sql . "FROM concessionaria     ";
    $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro    ";
    $sql = $sql . ")    ";
    $sql = $sql . "AND upper(io.status) = upper('aprovado')    ";
    $sql = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final'    ";
    $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;   ";

  }

  //returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_iorder_meta()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}


/*
 * @function DASH_iorder_rank_med_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_iorder_rank_med_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $modelo       = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, SUBSTRING(modelo,1,1) linha, grupo, ";
  $sql = $sql . "sum(total) valor_unitario, ( sum(total) / sum(quantidade) ) valor_medio ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado') ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND SUBSTRING(modelo,1,1) = '$modelo' ";
  $sql = $sql . "GROUP BY SUBSTRING(modelo,1,1), grupo ";
  $sql = $sql . "ORDER BY grupo; ";

  auditoriaLog('Begin - DASH_iorder_rank_med_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_iorder_unidade_vendida_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_iorder_unidade_vendida_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $modelo       = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, SUBSTRING(modelo,1,1) linha, grupo,  ";
  $sql  = $sql . "sum(total) valor_unitario, ( sum(total) / sum(quantidade) ) valor_medio ";
  $sql  = $sql . "FROM iorder ";
  $sql  = $sql . "WHERE upper(`status`) = upper('aprovado') ";
  $sql  = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql  = $sql . "AND SUBSTRING(modelo,1,1) = '$modelo' ";
  $sql  = $sql . "ORDER BY grupo; ";
  //returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_iorder_unidade_vendida_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_iorder_rank_med
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_iorder_rank_med($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo       = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, SUBSTRING(io.modelo,1,1) linha, co.unidade, ";
  $sql = $sql . "sum(io.total) valor_unitario, ( sum(io.total) / sum(quantidade) ) valor_medio ";
  $sql = $sql . "FROM iorder io, concessionaria co ";
  $sql = $sql . "WHERE io.id_concessionaria IN ( ";
  $sql = $sql . "SELECT id_concessionaria ";
  $sql = $sql . "FROM concessionaria  ";
  $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . ") ";
  $sql = $sql . "AND upper(io.STATUS) = upper('aprovado') ";
  $sql = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND upper(SUBSTRING(io.modelo,1,1)) = upper('$modelo') ";
  $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria ";
  $sql = $sql . "GROUP BY co.unidade; ";
  //returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_iorder_rank_med()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}

/*
 * @function DASH_iorder_unidade_vendida
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_iorder_unidade_vendida($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $modelo       = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, SUBSTRING(io.modelo,1,1) linha, ";
  $sql = $sql ."sum(io.total) valor_unitario, ( sum(io.total) / sum(quantidade) ) valor_medio ";
  $sql = $sql ."FROM iorder io, concessionaria co ";
  $sql = $sql ."WHERE io.id_concessionaria IN ( ";
  $sql = $sql ."SELECT id_concessionaria ";
  $sql = $sql ."FROM concessionaria  ";
  $sql = $sql ."WHERE id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql .") ";
  $sql = $sql ."AND upper(io.status) = upper('aprovado') ";
  $sql = $sql ."AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql ."AND upper(SUBSTRING(io.modelo,1,1)) = upper('$modelo') ";
  $sql = $sql ."AND io.id_concessionaria = co.id_concessionaria; ";

  //returnJson(-1,$sql);
  auditoriaLog('Begin - DASH_iorder_unidade_vendida()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}

/*
 * @function DASH_consultores_top_list_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_consultores_top_list_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, substring(co.nome_cracha,1,10) nome_cracha ";
  $sql  = $sql . "FROM iorder io, colaborador co ";
  $sql  = $sql . "WHERE upper(io.STATUS) = upper('aprovado') ";
  $sql  = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql  = $sql . "AND io.id_colaborador = co.id_colaborador ";
  $sql  = $sql . "GROUP BY co.nome_cracha  ";
  $sql  = $sql . "ORDER BY 1 DESC ";
  $sql  = $sql . "LIMIT 5; ";

  auditoriaLog('Begin - DASH_consultores_top_list_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1,$sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_consultores_top_list_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_consultores_top_list($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro   = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, substring(co.nome_cracha,1,10) nome_cracha ";
  $sql  = $sql . "FROM iorder io, colaborador co ";
  $sql  = $sql . "WHERE upper(io.STATUS) = upper('aprovado') ";
  $sql  = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql  = $sql . "AND io.id_colaborador = co.id_colaborador ";
  $sql = $sql . "AND io.id_concessionaria IN ( ";
  $sql = $sql . "   SELECT id_concessionaria  ";
  $sql = $sql . "   FROM concessionaria   ";
  $sql = $sql . "   WHERE id_grupo_financeiro = $id_grupo_financeiro  ";
  $sql = $sql . ") ";
  $sql  = $sql . "GROUP BY co.nome_cracha  ";
  $sql  = $sql . "ORDER BY 1 DESC ";
  $sql  = $sql . "LIMIT 5; ";

  auditoriaLog('Begin - DASH_consultores_top_list_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1,$sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_iorder_status_pedido_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_status_pedido_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT count(quantidade) total, status ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE date_format(data_hora_pedido,'%Y-%c-%d')  ";
  // $sql = $sql . "   BETWEEN date_format('$data_inicial','%Y-%c-%d')  ";
  $sql = $sql . "   BETWEEN '$data_inicial' ";
  // $sql = $sql . "       AND date_format('$data_final','%Y-%c-%d') ";
  $sql = $sql . "       AND '$data_final' ";
  $sql = $sql . "GROUP BY status;  ";

  auditoriaLog('Begin - DASH_iorder_status_pedido_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_status_pedido
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_status_pedido($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro   = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT count(quantidade) total, STATUS ";
  $sql =  $sql . "FROM iorder  ";
  $sql =  $sql . "WHERE date_format(data_hora_pedido,'%Y-%c-%d') BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql =  $sql . "AND id_concessionaria IN (  ";
  $sql =  $sql . "   SELECT id_concessionaria  ";
  $sql =  $sql . "   FROM concessionaria   ";
  $sql =  $sql . "   WHERE id_grupo_financeiro = $id_grupo_financeiro ";
  $sql =  $sql . ") ";
  $sql =  $sql . "GROUP BY STATUS;   ";

  auditoriaLog('Begin - DASH_iorder_status_pedido()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}


/*
 * @function DASH_iorder_total_seguro_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_total_seguro_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT (sum(pm_ouro)+sum(pm_azul)) pm, sum(dynafleet) dynafleet, sum(seguro) seguro ";
  $sql = $sql . "FROM iorder  ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final';  ";

  auditoriaLog('Begin - DASH_iorder_total_seguro_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_total_seguro_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_total_seguro($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT (sum(pm_ouro)+sum(pm_azul)) pm, sum(dynafleet) dynafleet, sum(seguro) seguro ";
  $sql = $sql . "FROM iorder  ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro;  ";

  auditoriaLog('Begin - DASH_iorder_total_seguro_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_rank_venda_hora_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_rank_venda_hora_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  //$id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT sum(quantidade) quantidade, substr(date_format(data_hora_pedido, '%T'),1,2) data_hora_pedido ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "GROUP BY substr(date_format(data_hora_pedido, '%T'),1,2) ";
  $sql = $sql . "ORDER BY substr(date_format(data_hora_pedido, '%T'),1,2); ";

  auditoriaLog('Begin - DASH_iorder_rank_venda_hora_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_rank_venda_hora
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_rank_venda_hora($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT sum(quantidade) quantidade, substr(date_format(data_hora_pedido, '%T'),1,2) data_hora_pedido ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "GROUP BY substr(date_format(data_hora_pedido, '%T'),1,2) ";
  $sql = $sql . "ORDER BY substr(date_format(data_hora_pedido, '%T'),1,2); ";

  auditoriaLog('Begin - DASH_iorder_rank_venda_hora()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_rank_venda_mes_volvo
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_rank_venda_mes_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // $sql = "SELECT entrega_prevista, substr(modelo,1,1) modelo, sum(quantidade) quantidade ";
  // $sql = $sql . "FROM iorder ";
  // $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  // $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  // $sql = $sql . "GROUP BY entrega_prevista, substr(modelo,1,1); ";

  $sql = "SELECT ent_prev, substr(modelo,1,1) modelo, sum(quantidade) quantidade ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  // $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "AND substr(modelo,1,1) = '$modelo' ";
  $sql = $sql . "GROUP BY STR_TO_DATE(ent_prev, '%d/%m/%Y'), substr(modelo,1,1); ";


  auditoriaLog('Begin - DASH_iorder_rank_venda_mes_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);
  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

/*
 * @function DASH_iorder_rank_venda_mes
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_iorder_rank_venda_mes($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo              = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql = "SELECT ent_prev, substr(modelo,1,1) modelo, sum(quantidade) quantidade ";
  $sql = $sql . "FROM iorder ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "AND substr(modelo,1,1) = '$modelo' ";
  $sql = $sql . "GROUP BY STR_TO_DATE(ent_prev, '%d/%m/%Y'), substr(modelo,1,1); ";

  auditoriaLog('Begin - DASH_iorder_rank_venda_mes()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  } else {
    returnJson(-1, "Erro ao executar pesquisa.");
  }

}

// ----------------------------------------------------------------------------------------------
// --- PARAM --- PARAM --- PARAM --- PARAM --- PARAM --- PARAM --- PARAM --- PARAM ---
// ----------------------------------------------------------------------------------------------

/*
 * @function DASH_login
 * @parameter $_POST, $_REMOTE
 *
 */
  function DASH_login($paramPOST, $paramREMOTE)
  {

      // Recupera os dados
      $usuario   = trim($paramPOST['usuario']);
      $senha     = trim($paramPOST['senha']);
      $id_app    = trim($paramPOST['id_app']);
      $msg       = "";
      $code      = 0;

      // Parametro Padrao
      $device    = trim($paramPOST['device']);
      $ipaddress = $paramREMOTE['REMOTE_ADDR'];

      auditoriaLog('Begin - DASH_login()',$sql,$device,$usuario,$ipaddress);

      // Valida se tem conteudo
      if( (hasContent($usuario) == 0) || (hasContent($senha) == 0)) {
        returnJson(-1,'Usuário ou Senha devem tem conteúdo');
      }

      if(hasContent($id_app) == 0) {
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
      $sql = $sql . "LIMIT 1; ";
      //echo $sql;
      $login = query($sql);

      // Valida se o login/senha estao corretos
      if(sizeof($login) == 0) {
        returnJson(-1, "Usuário ou Senha não conferem.");
      }

      $sql = "SELECT * FROM ";
      $sql  = $sql . "((colaborador JOIN (concessionaria JOIN grupo  ";
      $sql  = $sql . "ON concessionaria.id_grupo_financeiro=grupo.id_grupo)  ";
      $sql  = $sql . "ON colaborador.id_concessionaria=concessionaria.id_concessionaria)  ";
      $sql  = $sql . "JOIN (colaborador_aplicacao JOIN aplicacao ON  ";
      $sql  = $sql . "colaborador_aplicacao.id_aplicacao=aplicacao.id_aplicacao)  ";
      $sql  = $sql . "ON colaborador.id_colaborador=colaborador_aplicacao.id_colaborador)  ";
      $sql  = $sql . "WHERE ativo='S' AND upper(colaborador.login) = upper('$usuario')  ";
      $sql  = $sql . "AND upper(colaborador.senha) = upper('$senha')  ";
      $sql  = $sql . "AND upper(aplicacao.aplicacao) LIKE upper('%$id_app%');";

      //returnJson(-1, $sql);
      $login = query($sql);

      // Valida se o usuario tem acesso a APP
      if(sizeof($login) == 0) {
        returnJson(-1, "Usuário não tem autorização para acessar esta aplicação.");
      }

      auditoriaLog('DASH_login()',$sql,$device,$usuario,$ipaddress);

      // Valida se encontrar pelo menos 1 app permitido
      if ((isset($login)) && (sizeof($login) > 0))
      {
        $dbdevice = trim($login[0]['device']);
        // Valida se ja não esta logado
        if(hasContent($dbdevice) == 0)
        {
          // Cria a tabela de controle para os deltas dos regitros
          APP_create_table_control($device);
          $msg = "Autenticação efetuada com sucesso.";
        }else{
            if($device == $dbdevice)
            {
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

        if ($update['error'])
        {
            $code = -1;
            $msg = "Erro ao liberar login.";
        }

        // coloca na sessao para controle dos apps
        session_start();
        $_SESSION['volvo']['apps'] = $login;

        returnJson(0, $msg, $login);
      }
  }


/*
 * @function DASH_carrega_parametro
 * @parameter $_POST, $_REMOTE
 *
 */
function DASH_carrega_parametro($paramPOST, $paramREMOTE) {

  $evento    = $paramPOST['evento'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT evento, meta_crm, meta_iorder, DATE_FORMAT(data_inicio,'%d/%m/%Y') data_inicio, ";
  $sql = $sql . "DATE_FORMAT(data_fim,'%d/%m/%Y') data_fim, hora_inicio, hora_fim ";
  $sql = $sql . "FROM evento ";
  $sql = $sql . "WHERE id_evento = $evento; ";

  auditoriaLog('Begin - DASH_carrega_parametro()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

// ----------------------------------------------------------------------------------------------
// --- PM --- PM --- PM --- PM --- PM --- PM --- PM --- PM ---
// ----------------------------------------------------------------------------------------------

/*
 * @function DASH_pm_status_pedido_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_status_pedido_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  //$modelo              = $paramPOST['modelo'];
  //$id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(1) total, STATUS ";
  $sql  = $sql . "FROM pm ";
  $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql  = $sql . "GROUP BY status; ";

  auditoriaLog('Begin - DASH_pm_status_pedido_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_contratos_por_linha_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_contratos_por_linha_volvo($paramPOST, $paramREMOTE)
{

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT  count(STATUS) total, STATUS, substr(modelo,1,1) linha ";
  $sql = $sql . "FROM pm ";
  $sql = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "AND substr(modelo,1,1) = '$modelo' ";
  $sql = $sql . "GROUP BY STATUS, substr(modelo,1,1) ";
  $sql = $sql . "ORDER BY substr(modelo,1,1); ";

  auditoriaLog('Begin - DASH_pm_contratos_por_linha_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_consultor_top5_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_consultor_top5_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(id_colaborador) total, substring(nome_cracha,1,10) nome_cracha ";
  $sql = $sql . "FROM pm ";
  $sql = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "AND upper(`status`) = upper('aprovado')   ";
  $sql = $sql . "GROUP BY id_colaborador ";
  $sql = $sql . "ORDER BY 1 DESC  ";
  $sql = $sql . "LIMIT 5; ";

  auditoriaLog('Begin - DASH_pm_consultor_top5_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_unidade_vendida_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_unidade_vendida_volvo($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, SUBSTRING(modelo,1,1) linha, ";
  $sql = $sql . "sum(custo_contrato) custo_contrato ";
  $sql = $sql . "FROM pm  ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')  ";
  $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "GROUP BY upper(SUBSTRING(modelo,1,1)); ";

  //returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_pm_unidade_vendida_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_rank_venda_hora_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_rank_venda_hora_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, substr(date_format(data_hora_pm, '%T'),1,2) data_hora_pm ";
  $sql = $sql . "FROM pm  ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')   ";
  $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "GROUP BY substr(date_format(data_hora_pm, '%T'),1,2)  ";
  $sql = $sql . "ORDER BY substr(date_format(data_hora_pm, '%T'),1,2);  ";

  auditoriaLog('Begin - DASH_pm_rank_venda_hora_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_rank_venda_dia_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_rank_venda_dia_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, date_format(data_hora_pm, '%d') dia, SUBSTRING(modelo,1,1) linha  ";
  $sql = $sql . "FROM pm    ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')   ";
  $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "GROUP BY date_format(data_hora_pm, '%d'), SUBSTRING(modelo,1,1)   ";
  $sql = $sql . "ORDER BY date_format(data_hora_pm, '%d');  ";

  auditoriaLog('Begin - DASH_pm_rank_venda_dia_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_bonus_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_bonus_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT sum(bonus_volvo) bonus_volvo FROM pm ";
  $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
  $sql  = $sql . "AND upper(STATUS) = upper('APROVADO') ";

  auditoriaLog('Begin - DASH_pm_bonus_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_bonus_conce_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_bonus_conce_volvo($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, grupo, sum(bonus_concessionaria) bonus_concessionaria ";
  $sql  = $sql . "FROM pm ";
  $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
  $sql  = $sql . "AND upper(STATUS) = upper('APROVADO') ";
  $sql  = $sql . "AND id_grupo_financeiro  = $id_grupo_financeiro ";
  $sql  = $sql . "GROUP BY id_grupo_financeiro ";
  $sql  = $sql . "ORDER BY bonus_concessionaria DESC; ";
  //

  auditoriaLog('Begin - DASH_pm_bonus_conce_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

//------------------------------------------------------------------------------------------------

/*
 * @function DASH_pm_status_pedido
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_status_pedido($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT count(STATUS) total, STATUS ";
  $sql = $sql . "FROM pm ";
  $sql = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "GROUP BY STATUS; ";

  auditoriaLog('Begin - DASH_pm_status_pedido()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_consultor_top5
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_consultor_top5($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT count(id_colaborador) total, substring(nome_cracha,1,10) nome_cracha ";
  $sql = $sql . "FROM pm ";
  $sql = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "AND upper(`status`) = upper('aprovado')   ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "GROUP BY id_colaborador ";
  $sql = $sql . "ORDER BY 1 DESC  ";
  $sql = $sql . "LIMIT 5; ";

  auditoriaLog('Begin - DASH_pm_consultor_top5_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_rank_venda_hora_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_rank_venda_hora($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, substr(date_format(data_hora_pm, '%T'),1,2) data_hora_pm ";
  $sql = $sql . "FROM pm  ";
  $sql = $sql . "WHERE upper(`status`) = upper('aprovado')   ";
  $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
  $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . "GROUP BY substr(date_format(data_hora_pm, '%T'),1,2)  ";
  $sql = $sql . "ORDER BY substr(date_format(data_hora_pm, '%T'),1,2);  ";

  auditoriaLog('Begin - DASH_pm_rank_venda_hora_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_rank_venda_dia_volvo
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_rank_venda_dia($paramPOST, $paramREMOTE) {

  $data_inicial        = humanToMysql($paramPOST['data_inicial']);
  $data_final          = humanToMysql($paramPOST['data_final']);
  $modelo              = $paramPOST['modelo'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  if( $id_grupo_financeiro == 13)
  {
    $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, date_format(data_hora_pm, '%d') dia ";
    $sql = $sql . "FROM pm    ";
    $sql = $sql . "WHERE upper(`status`) = upper('aprovado')   ";
    $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
    //$sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
    $sql = $sql . "GROUP BY date_format(data_hora_pm, '%d')   ";
    $sql = $sql . "ORDER BY date_format(data_hora_pm, '%d');  ";

  }else{
    $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, date_format(data_hora_pm, '%d') dia  ";
    $sql = $sql . "FROM pm    ";
    $sql = $sql . "WHERE upper(`status`) = upper('aprovado')   ";
    $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
    $sql = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro ";
    $sql = $sql . "GROUP BY date_format(data_hora_pm, '%d') ";
    $sql = $sql . "ORDER BY date_format(data_hora_pm, '%d');  ";
}
  auditoriaLog('Begin - DASH_pm_rank_venda_dia_volvo()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  //returnJson(-1, $sql);

  $result = query($sql);

  if (!$result['error']) {
    returnJson(0,'Sucesso', $result);
  }

}

/*
 * @function DASH_pm_rank_venda_conce
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_rank_venda_conce($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo              = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  $sql = "SELECT sum(quantidade) quantidade, SUBSTRING(io.modelo,1,1) linha, co.unidade, ";
  $sql = $sql . "sum(io.custo_contrato) valor_unitario, ( sum(io.custo_contrato) / sum(quantidade) ) valor_medio ";
  $sql = $sql . "FROM iorder io, concessionaria co ";
  $sql = $sql . "WHERE io.id_concessionaria IN ( ";
  $sql = $sql . "SELECT id_concessionaria ";
  $sql = $sql . "FROM concessionaria  ";
  $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro ";
  $sql = $sql . ") ";
  $sql = $sql . "AND upper(io.STATUS) = upper('aprovado') ";
  $sql = $sql . "AND io.data_hora_pedido BETWEEN '$data_inicial' AND '$data_final' ";
  $sql = $sql . "AND upper(SUBSTRING(io.modelo,1,1)) = upper('$modelo') ";
  $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria ";
  $sql = $sql . "GROUP BY co.unidade; ";

  // returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_pm_rank_venda_conce()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  // $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}

function DASH_pm_meta($paramPOST, $paramREMOTE)
{
  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo       = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  if($id_grupo_financeiro == 13){
    // -- volvo
    $sql = "SELECT sum(qtde_veiculo) quantidade,  ";
    $sql = $sql . "(SELECT meta_pm FROM grupo WHERE id_grupo = 13) meta  ";
    $sql = $sql . "FROM pm io, concessionaria co  ";
    $sql = $sql . "WHERE upper(io.status) = upper('aprovado')  ";
    $sql = $sql . "AND io.data_hora_pm BETWEEN '$data_inicial' AND '$data_final'  ";
    $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;  ";

  } else {
    // -- por grupo
    $sql = "SELECT sum(qtde_veiculo) quantidade,  ";
    $sql = $sql . "(SELECT meta_pm FROM grupo WHERE id_grupo = $id_grupo_financeiro) meta   ";
    $sql = $sql . "FROM pm io, concessionaria co    ";
    $sql = $sql . "WHERE io.id_concessionaria IN (    ";
    $sql = $sql . "SELECT id_concessionaria    ";
    $sql = $sql . "FROM concessionaria     ";
    $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro    ";
    $sql = $sql . ")    ";
    $sql = $sql . "AND upper(io.status) = upper('aprovado')    ";
    $sql = $sql . "AND io.data_hora_pm BETWEEN '$data_inicial' AND '$data_final'    ";
    $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;   ";

  }

  //returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_iorder_meta()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }
}

/*
 * @function DASH_pm_contratos_aprov
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_contratos_aprov($paramPOST, $paramREMOTE) {

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo              = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  // se grupo VOLVO
  if($id_grupo_financeiro == 13)
  {
    $sql = "SELECT count(1) total, sum(bonus_concessionaria) bonus ";
    $sql  = $sql . "FROM pm ";
    $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
    $sql  = $sql . "AND upper(STATUS) = upper('APROVADO') ";
    //$sql  = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro; ";
  }else{

    $sql = "SELECT count(1) total, sum(bonus_concessionaria) bonus ";
    $sql  = $sql . "FROM pm ";
    $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
    $sql  = $sql . "AND upper(STATUS) = upper('APROVADO') ";
    $sql  = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro; ";

  }

  auditoriaLog('Begin - DASH_pm_contratos_aprov()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}

/*
 * @function DASH_pm_media_contrato
 * @parameter $paramPOST, $paramREMOTE
 *
 */
function DASH_pm_media_contrato($paramPOST, $paramREMOTE)
{

  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $id_grupo_financeiro = $paramPOST['grupo'];
  $modelo              = $paramPOST['modelo'];

  // Recupera os dados
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  //
  if(id_grupo_financeiro == 13) {
    $sql = "SELECT sum(duracao_contrato) / count(1) media, sum(custo_contrato) / count(1) AS media_contrato, count(1) quantidade ";
    $sql  = $sql . "FROM pm ";
    $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
    $sql  = $sql . "AND upper(STATUS) = upper('APROVADO'); ";

  } else {
    $sql = "SELECT sum(duracao_contrato) / count(1) media, sum(custo_contrato) / count(1) AS media_contrato, count(1) quantidade ";
    $sql  = $sql . "FROM pm ";
    $sql  = $sql . "WHERE data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
    $sql  = $sql . "AND upper(STATUS) = upper('APROVADO') ";
    $sql  = $sql . "AND id_grupo_financeiro = $id_grupo_financeiro; ";
  }


  auditoriaLog('Begin - DASH_pm_media_contrato()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {

    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}

/*
 * @function DASH_pm_rank_venda_bonus
 * @parameter $paramPOST, $paramREMOTE
 *
 */

function DASH_pm_rank_venda_bonus($paramPOST, $paramREMOTE)
{
  $data_inicial = humanToMysql($paramPOST['data_inicial']);
  $data_final   = humanToMysql($paramPOST['data_final']);
  $visao        = $paramPOST['visao'];
  $id_grupo_financeiro = $paramPOST['grupo'];

  // Recupera os dados
  $device    = $paramPOST['device'];
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  if ($id_grupo_financeiro == 13) {
    if ($visao == 'APR') {

      // -- volvo
      $sql = "SELECT sum(qtde_veiculo) total, grupo, sum(bonus_volvo) bonus ";
      $sql  = $sql . "FROM pm ";
      $sql  = $sql . "WHERE upper(STATUS) = upper('aprovado') ";
      $sql  = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
      $sql  = $sql . "GROUP BY grupo; ";

    } else {
      $sql = "SELECT sum(qtde_veiculo) total, grupo, sum(bonus_volvo) bonus ";
      $sql = $sql . "FROM pm ";
      $sql = $sql . "WHERE upper(STATUS) = upper('declinado') ";
      $sql = $sql . "AND data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
      $sql = $sql . "GROUP BY grupo; ";
    }

  } else {

    if($visao == 'APR') {
      // -- por grupo
      $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, co.unidade, ";
      $sql = $sql . "(SELECT meta_iorder FROM grupo WHERE id_grupo = $id_grupo_financeiro) meta   ";
      $sql = $sql . "FROM pm io, concessionaria co    ";
      $sql = $sql . "WHERE io.id_concessionaria IN (    ";
      $sql = $sql . "SELECT id_concessionaria    ";
      $sql = $sql . "FROM concessionaria     ";
      $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro   ";
      $sql = $sql . ")    ";
      $sql = $sql . "AND upper(io.status) = upper('aprovado')    ";
      $sql = $sql . "AND io.data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
      $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;   ";
    } else {
      $sql  = "SELECT sum(qtde_veiculo) qtde_veiculo, co.unidade, ";
      $sql = $sql . "(SELECT meta_iorder FROM grupo WHERE id_grupo = $id_grupo_financeiro) meta   ";
      $sql = $sql . "FROM pm io, concessionaria co    ";
      $sql = $sql . "WHERE io.id_concessionaria IN (    ";
      $sql = $sql . "SELECT id_concessionaria    ";
      $sql = $sql . "FROM concessionaria     ";
      $sql = $sql . "WHERE id_grupo_financeiro = $id_grupo_financeiro  ";
      $sql = $sql . ")    ";
      $sql = $sql . "AND upper(io.status) = upper('declinado')    ";
      $sql = $sql . "AND io.data_hora_pm BETWEEN '$data_inicial' AND '$data_final' ";
      $sql = $sql . "AND io.id_concessionaria = co.id_concessionaria;   ";

    }

  }


  // returnJson(-1, $sql);

  auditoriaLog('Begin - DASH_pm_rank_venda_bonus()',$sql,$device,$usuario,$nome_completo,$ipaddress);

  $result = query($sql);

  if (!$result['error']) {
    if( sizeof($result) >0) {
      returnJson(0,'Sucesso', $result);
    } else {
      returnJson(0,"Sem dados no momento.");
    }
  }

}



