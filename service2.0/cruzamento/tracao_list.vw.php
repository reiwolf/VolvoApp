<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra, tracao.id_tracao, tracao FROM mod_tra JOIN tracao ON mod_tra.id_tracao=tracao.id_tracao WHERE id_modelo=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{
	$M_newMatrix = $P_BO->search("tracao", NULL, "*", "tracao");
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);