<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
session_start();
// ############# INICIO SELECT DADOS #############	
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra_mot_cai, caixa_cambio FROM mod_tra_mot_cai JOIN caixa_cambio ON mod_tra_mot_cai.id_caixa_cambio=caixa_cambio.id_caixa_cambio 
				WHERE id_mod_tra_mot=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{	
	$M_newMatrix = $P_BO->search("caixa_cambio", NULL, "*", "caixa_cambio");
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);
// ############# FIM SELECT DADOS #############