<?php
// PRINCIPAIS CLASSES CORE
require_once('../../dashboard/core/modules/utils/autoload.php');
session_start();
// ############# INICIO SELECT DADOS #############	
$P_BO = new mod_tra_BO();
if(isset($_GET) && !empty($_GET))
{
	$_id = $_GET['id'];
	$_sql = "SELECT id_mod_tra_mot, motor FROM mod_tra_mot JOIN motor ON mod_tra_mot.id_motor=motor.id_motor WHERE id_mod_tra=".$_id;
	$M_newMatrix = $P_BO->execQueryMy($_sql);
}else{
	$M_newMatrix = $P_BO->search("motor", NULL, "*", "motor");
}
$M_newMatrix = json_encode($M_newMatrix);
print_r($M_newMatrix);
// ############# FIM SELECT DADOS #############