<?php
/***********************************************************************************************
 *   service.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*******************************************************************
*  Debugging Flag
********************************************************************/
$_DEBUG = 0;
if ($_DEBUG == 1){
  ini_set('display_errors', 'On');
  ini_set('log_errors',TRUE);
  ini_set('html_errors',FALSE);
  ini_set('error_log','./phplog/PHP_error_log.txt');
  error_reporting(E_ALL | E_STRICT);
}
/*******************************************************************
*  Cache Control
********************************************************************/
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Pragma: no-cache');

/*******************************************************************
*  Session Control
********************************************************************/
ini_set("session.gc_maxlifetime",60000);
ini_set("session.gc_probability",1);
ini_set("session.gc_divisor",10);
ini_set("session.cookie_lifetime",60000); // 5 min

session_cache_expire( 20 );
session_start();

// the requre lines include the lib and api source files
require("lib.php");
require("common.php");
require("apiCOMMON.php");
require("apiCRM.php");
require("apiIORDER.php");
require("apiCEP.php");
require("apiDASHBOARD.php");
require("apiPM.php");

// this instructs the client that the server will output JSON data
// header("Content-Type: application/json; charset=utf-8");

// Verifica se щ uma sessao valida.
isValidSession($_POST, $_SERVER);

// the functions you call inside the switch are found in the api.php file
switch ($_POST['action']) {

// ------
// ------ COMMON ----------
// ---------------------

  case "APP_assina":
    APP_assina($_FILES, $_SERVER);
    break;

  case "APP_login":
    APP_login($_POST, $_SERVER);
    break;

  case "APP_logout":
    APP_logout($_POST, $_SERVER);
    break;

  case "APP_cargo":
    APP_cargo($_POST, $_SERVER);
    break;

  case "APP_busca_id":
    APP_busca_id($_POST, $_SERVER);
    break;

  case "APP_online":
    APP_online($_POST, $_SERVER);
    break;

  case "APP_grupo":
    APP_grupo($_POST, $_SERVER);
    break;

  case "APP_lab":
    APP_lab($_POST, $_SERVER);
    break;

  case "APP_envia_delta":
    APP_envia_delta($_POST, $_SERVER);
    break;

// ------
// ------ IORDER -------
// ---------------------

  case "IORDER_cliente_busca":
    IORDER_cliente_busca($_POST, $_SERVER);
    break;

  case "IORDER_cliente_grava":
    IORDER_cliente_grava($_POST, $_SERVER);
    break;

  case "IORDER_pedido_grava":
    IORDER_pedido_grava($_POST, $_SERVER);
    break;

  case "IORDER_modelo":
    IORDER_modelo($_POST, $_SERVER);
    break;

  case "IORDER_tracao":
    IORDER_tracao($_POST, $_SERVER);
    break;

  case "IORDER_motor":
    IORDER_motor($_POST, $_SERVER);
    break;

  case "IORDER_caixa_cambio":
    IORDER_caixa_cambio($_POST, $_SERVER);
    break;

  case "IORDER_suspensao_traseira":
    IORDER_suspensao_traseira($_POST, $_SERVER);
    break;

  case "IORDER_relacao_diferencial":
    IORDER_relacao_diferencial($_POST, $_SERVER);
    break;

  case "IORDER_entre_eixos":
    IORDER_entre_eixos($_POST, $_SERVER);
    break;

  case "IORDER_tanque":
    IORDER_tanque($_POST, $_SERVER);
    break;

  case "IORDER_pneu":
    IORDER_pneu($_POST, $_SERVER);
    break;

  case "IORDER_cor":
    IORDER_cor($_POST, $_SERVER);
    break;

  case "IORDER_pacote_acabamento":
    IORDER_pacote_acabamento($_POST, $_SERVER);
    break;

  case "IORDER_cabine":
    IORDER_cabine($_POST, $_SERVER);
    break;

  case "IORDER_segmento":
    IORDER_segmento($_POST, $_SERVER);
    break;

  case "IORDER_lista_pedidos":
    IORDER_lista_pedidos($_POST, $_SERVER);
    break;

  case "IORDER_detalhe_pedido":
    IORDER_detalhe_pedido($_POST, $_SERVER);
    break;

  case "IORDER_busca_pedido":
    IORDER_busca_pedido($_POST, $_SERVER);
    break;

  case "IORDER_detalhe":
    IORDER_detalhe($_POST, $_SERVER);
    break;

  case "IORDER_atualiza_status":
    IORDER_atualiza_status($_POST, $_SERVER);
    break;

  case "IORDER_envia_assinatura":
    IORDER_envia_assinatura($_POST, $_SERVER);
    break;

// ------
// ------ CRM ----------
// ---------------------

 case "CRM_cliente_busca":
    CRM_cliente_busca($_POST, $_SERVER);
    break;

 case "CRM_contato_busca":
    CRM_contato_busca($_POST, $_SERVER);
    break;

 case "CRM_cliente_grava":
    CRM_cliente_grava($_POST, $_SERVER);
    break;

 case "CRM_contato_grava":
    CRM_contato_grava($_POST, $_SERVER);
    break;

// ------
// ------ DASHBOARD ----
// ---------------------

  case "DASH_crm_cadastro_volvo":
    DASH_crm_cadastro_volvo($_POST, $_SERVER);
    break;

  case "DASH_crm_cadastro":
    DASH_crm_cadastro($_POST, $_SERVER);
    break;

  case "DASH_top10_consultora":
    DASH_top10_consultora($_POST, $_SERVER);
    break;

  case "DASH_cadastro_grupofin":
    DASH_cadastro_grupofin($_POST, $_SERVER);
    break;

  case "DASH_etapas":
    DASH_etapas($_POST, $_SERVER);
    break;

  case "DASH_login":
    DASH_login($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_med_volvo":
    DASH_iorder_rank_med_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_unidade_vendida_volvo":
    DASH_iorder_unidade_vendida_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_med":
    DASH_iorder_rank_med($_POST, $_SERVER);
    break;

  case "DASH_iorder_unidade_vendida":
    DASH_iorder_unidade_vendida($_POST, $_SERVER);
    break;

  case "DASH_carrega_parametro":
    DASH_carrega_parametro($_POST, $_SERVER);
    break;

  case "DASH_consultores_top_list_volvo":
    DASH_consultores_top_list_volvo($_POST, $_SERVER);
    break;

  case "DASH_consultores_top_list":
    DASH_consultores_top_list($_POST, $_SERVER);
    break;

  case "DASH_iorder_status_pedido_volvo":
    DASH_iorder_status_pedido_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_status_pedido":
    DASH_iorder_status_pedido($_POST, $_SERVER);
    break;

  case "DASH_iorder_total_seguro_volvo":
    DASH_iorder_total_seguro_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_total_seguro":
    DASH_iorder_total_seguro($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_venda_hora_volvo":
    DASH_iorder_rank_venda_hora_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_venda_hora":
    DASH_iorder_rank_venda_hora($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_venda_mes_volvo":
    DASH_iorder_rank_venda_mes_volvo($_POST, $_SERVER);
    break;

  case "DASH_iorder_rank_venda_mes":
    DASH_iorder_rank_venda_mes($_POST, $_SERVER);
    break;

  case "DASH_pm_status_pedido_volvo":
    DASH_pm_status_pedido_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_contratos_por_linha_volvo":
    DASH_pm_contratos_por_linha_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_consultor_top5_volvo":
    DASH_pm_consultor_top5_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_hora_volvo":
    DASH_pm_rank_venda_hora_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_unidade_vendida_volvo":
    DASH_pm_unidade_vendida_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_dia_volvo":
    DASH_pm_rank_venda_dia_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_bonus_volvo":
    DASH_pm_bonus_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_bonus_conce_volvo":
    DASH_pm_bonus_conce_volvo($_POST, $_SERVER);
    break;

  case "DASH_pm_status_pedido":
    DASH_pm_status_pedido($_POST, $_SERVER);
    break;

  case "DASH_pm_consultor_top5":
    DASH_pm_consultor_top5($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_hora":
    DASH_pm_rank_venda_hora($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_dia":
    DASH_pm_rank_venda_dia($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_conce":
    DASH_pm_rank_venda_conce($_POST, $_SERVER);
    break;

  case "DASH_pm_contratos_aprov":
    DASH_pm_contratos_aprov($_POST, $_SERVER);
    break;

  case "DASH_pm_media_contrato":
    DASH_pm_media_contrato($_POST, $_SERVER);
    break;

  case "DASH_iorder_meta":
    DASH_iorder_meta($_POST, $_SERVER);
    break;

  case "DASH_pm_meta":
    DASH_pm_meta($_POST, $_SERVER);
    break;

  case "DASH_pm_rank_venda_bonus":
    DASH_pm_rank_venda_bonus($_POST, $_SERVER);
    break;

// ------
// ------ PM ----
// ---------------------

  case "PM_grava_bonus":
    PM_grava_bonus($_POST, $_SERVER);
    break;

  case "PM_modelo":
    PM_modelo($_POST, $_SERVER);
    break;

  case "PM_tracao":
    PM_tracao($_POST, $_SERVER);
    break;

   case "PM_motor":
    PM_motor($_POST, $_SERVER);
    break;

  case "PM_caixa_cambio":
    PM_caixa_cambio($_POST, $_SERVER);
    break;

  case "PM_eixo_traseiro":
    PM_eixo_traseiro($_POST, $_SERVER);
    break;

  case "PM_tipo_implemento":
    PM_tipo_implemento($_POST, $_SERVER);
    break;

  case "PM_ciclo_transporte":
    PM_ciclo_transporte($_POST, $_SERVER);
    break;

  case "PM_classe_servico":
    PM_classe_servico($_POST, $_SERVER);
    break;

  case "PM_condicao_estrada":
    PM_condicao_estrada($_POST, $_SERVER);
    break;

  case "PM_topografia":
    PM_topografia($_POST, $_SERVER);
    break;

  case "PM_pbtc":
    PM_pbtc($_POST, $_SERVER);
    break;

  case "PM_fora_estrada":
    PM_fora_estrada($_POST, $_SERVER);
    break;

  case "PM_duracao_contrato":
    PM_duracao_contrato($_POST, $_SERVER);
    break;

  case "PM_km_mensal":
    PM_km_mensal($_POST, $_SERVER);
    break;

  case "PM_km_inicial":
    PM_km_inicial($_POST, $_SERVER);
    break;

  case "PM_ano_entrega":
    PM_ano_entrega($_POST, $_SERVER);
    break;

  case "PM_cliente_busca":
    PM_cliente_busca($_POST, $_SERVER);
    break;

  case "PM_combinacao_curva":
    PM_combinacao_curva($_POST, $_SERVER);
    break;

  case "PM_custo_contrato":
    PM_custo_contrato($_POST, $_SERVER);
    break;

  case "PM_km_total_contratado":
    PM_km_total_contratado($_POST, $_SERVER);
    break;

  case "PM_km_final_contratado":
    PM_km_final_contratado($_POST, $_SERVER);
    break;

  case "PM_custo_progressivo":
    PM_custo_progressivo($_POST, $_SERVER);
    break;

  case "PM_bonus":
    PM_bonus($_POST, $_SERVER);
    break;

  case "PM_calcula_bonus_disponivel":
    PM_calcula_bonus_disponivel($_POST, $_SERVER);
    break;

  case "PM_grupo":
    PM_grupo($_POST, $_SERVER);
    break;

  case "PM_pm_grava":
    PM_pm_grava($_POST, $_SERVER);
    break;

  case "PM_resumo":
    PM_resumo($_POST, $_SERVER);
    break;

  case "PM_busca":
    PM_busca($_POST, $_SERVER);
    break;

  case "PM_calculo":
    PM_calculo($_POST, $_SERVER);
    break;

  case "PM_detalhe":
    PM_detalhe($_POST, $_SERVER);
    break;

  case "PM_atualiza_status":
    PM_atualiza_status($_POST, $_SERVER);
    break;

  case "PM_grava_calculo":
    PM_grava_calculo($_POST, $_SERVER);
    break;

// ------
// ------ CEP ----------
// ---------------------

  case "CEP_pesquisa":
    CEP_pesquisa($_POST, $_SERVER);
    break;

// ------
// ------ DEFAULT ------
// ---------------------

  default:
    returnJson(-1,'Opчуo selecionada nуo existe');
    break;
}

// this line is redundant as the file ends anyway,
// but just making sure no more code gets executed
exit();
// end

