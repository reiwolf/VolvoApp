<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
session_start();
// ############# INICIO SELECT DADOS #############	
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab, cabine
				FROM mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab JOIN cabine ON mod_tra_mot_cai_sus_rel_ent_tan_pne_pac_cab.id_cabine=cabine.id_cabine
				WHERE id_mod_tra_mot_cai_sus_rel_ent_tan_pne_pac=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{
	$M_newMatrix = $P_BO->search("cabine", NULL, "*", "cabine");
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);
// ############# FIM SELECT DADOS #############