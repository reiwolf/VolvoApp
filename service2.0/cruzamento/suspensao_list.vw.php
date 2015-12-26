<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
session_start();
// ############# INICIO SELECT DADOS #############	
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra_mot_cai_sus, suspensao_traseira
				FROM mod_tra_mot_cai_sus JOIN suspensao_traseira ON mod_tra_mot_cai_sus.id_suspensao_traseira=suspensao_traseira.id_suspensao_traseira
				WHERE id_mod_tra_mot_cai=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{	
	$M_newMatrix = $P_BO->search("suspensao_traseira", NULL, "*", "suspensao_traseira");
}
//print_r($M_newMatrix);
for($i=0; $i<count($M_newMatrix); $i++)
{
	$M_newMatrix[$i]['suspensao_traseira'] = ($M_newMatrix[$i]['suspensao_traseira']);
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);
// ############# FIM SELECT DADOS #############