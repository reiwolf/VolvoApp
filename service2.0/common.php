<?php
/***********************************************************************************************
 *   apiCRM.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function thumb
 * @parameter $_POST, $_REMOTE
 *
 */
function thumb($srcFile, $sideInPx) {

  $image = imagecreatefromjpeg($srcFile);
  $width = imagesx($image);
  $height = imagesy($image);

  $thumb = imagecreatetruecolor($sideInPx, $sideInPx);

  imagecopyresized($thumb,$image,0,0,0,0,$sideInPx,$sideInPx,$width,$height);

  imagejpeg($thumb, str_replace(".jpg","-thumb.jpg",$srcFile), 85);

  imagedestroy($thumb);
  imagedestroy($image);
}

/*
 * @function removeAcento
 * @parameter $param
 *
 */
function removeAcento($param){
    $acentos = array(
        'À','Á','Ã','Â', 'à','á','ã','â',
        'Ê', 'É',
        'Í', 'í',
        'Ó','Õ','Ô', 'ó', 'õ', 'ô',
        'Ú','Ü',
        'Ç', 'ç',
        'é','ê',
        'ú','ü',
        );
    $remove_acentos = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e',
        'i', 'i',
        'o', 'o','o', 'o', 'o','o',
        'u', 'u',
        'c', 'c',
        'e', 'e',
        'u', 'u',
        );
    return str_replace($acentos, $remove_acentos, urldecode($param));
}

/*
 * @function humanToMysql
 * @parameter $param
 *
 */
function humanToMysql($param) {
  if (strlen(trim($param)) > 10) {
    $ret = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $param)));
  } else{
    $ret = date('Y-m-d', strtotime(str_replace('/', '-', $param)));
  }

  return $ret;
}

/*
 * @function mysqlToHuman
 * @parameter $param
 *
 */
function mysqlToHuman($param, $withtime=true) {
  if($withtime) {
    $ret = date('d/m/Y H:i:s', strtotime(str_replace('-', '/', $param)));
  } else {
    $ret = date('d/m/Y', strtotime(str_replace('-', '/', $param)));
  }

  return $ret;
}

/*
 * @function toUTF8
 * @parameter $_POST, $_REMOTE
 *
 */
function trimupper($param) {
  // return strlen($param) == 0 ? $param : strtoupper(addslashes(trim(removeAcento($param))));
  return strlen($param) == 0 ? $param : utf8_decode(addslashes(trim($param)));
}

/*
 * @function toUTF8
 * @parameter $_POST, $_REMOTE
 *
 */
function toUTF8($param) {
  return strlen($param) == 0 ? $param : trim(utf8_encode($param));
}

/*
 * @function trimUTF8
 * @parameter $_POST, $_REMOTE
 *
 */
function trimUTF8($param) {
  return strlen($param) == 0 ? $param : utf8_decode(trim($param));
}

/*
 * @function hasContent
 * @parameter $_POST, $_REMOTE
 *
 */
function hasContent($param) {
  return strlen($param);
}

/*
 * @function formataCEP
 * @parameter $param
 *
 */
function formataCEP($param) {
  return strlen($param);
}

/*
 * @function errorJson
 * @parameter $_POST, $_REMOTE
 *
 */
// function errorJson($code, $msg='', $data='') {
//   $msg = toUTF8($msg);

//   $json = array();
//   $result = array(array('code'=>$code, 'message'=>$msg, 'data'=>$data));
//   array_push($json, $result);

//   header("Content-Type: application/json; charset=utf-8",true);
//   print json_encode($result);

//   // print json_encode(array(array('code'=>$code, 'message'=>$msg, 'result'=>$data)));
//   exit();
// }

/*
 * @function returnJson
 * @parameter $_POST, $_REMOTE
 *
 */
function returnJson($code, $msg='', $data=array(array())) {
// function returnJson($code, $msg='', $data="") {
  $msg = toUTF8($msg);

  $json = array();
  $result = array(array('code'=>$code, 'message'=>$msg, 'data'=>$data));
  array_push($json, $result);

  // header("Content-Type: application/json; charset=utf-8",true);
  print json_encode($result);

  if($code == -1) exit();
}

/*
 * @function currentValue
 * @parameter $_POST, $_REMOTE
 *
 */
function currentValue($param) {
  return (hasContent($param) == 0 ? 'NULL' : $param);
}

/*
 * @function retornaMes
 * @parameter $param
 *
 */
function retornaMes($param) {

  $meses = array(
    'JANEIRO'=>'01/01',
    'FEVEREIRO'=>'01/02',
    'MARÇO'=>'01/03',
    'ABRIL'=>'01/04',
    'MAIO'=>'01/05',
    'JUNHO'=>'01/06',
    'JULHO'=>'01/07',
    'AGOSTO'=>'01/08',
    'SETEMBRO'=>'01/9',
    'OUTUBRO'=>'01/10',
    'NOVEMBRO'=>'01/11',
    'DEZEMBRO'=>'01/12'
  );

  $mes = explode('/',$param);

  $v1 = $meses[strtoupper($mes[0])];
  $v2 = $mes[1];

  return "$v1/$v2";
}

