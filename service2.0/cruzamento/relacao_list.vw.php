<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
session_start();
// ############# INICIO SELECT DADOS #############	
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra_mot_cai_sus_rel, relacao_diferencial FROM mod_tra_mot_cai_sus_rel JOIN relacao_diferencial ON mod_tra_mot_cai_sus_rel.id_relacao_diferencial=relacao_diferencial.id_relacao_diferencial
				WHERE id_mod_tra_mot_cai_sus=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{	
	$M_newMatrix = $P_BO->search("relacao_diferencial", NULL, "*", "relacao_diferencial");
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);
// ############# FIM SELECT DADOS #############