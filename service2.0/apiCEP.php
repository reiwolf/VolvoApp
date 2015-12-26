<?php
/***********************************************************************************************
 *   apiCEP.php --
 *   Version: 1.0.0
 * Copyright 2013 Waldir Borba Junior
 ************************************************************************************************/

/*
 * @function CEP_pesquisa
 * @parameter $_POST, $_REMOTE
 *
 */
function CEP_pesquisa($paramPOST, $paramREMOTE) {

  // Recupera os dados
  $q         = trim($paramPOST['q']);
  $device    = trim($paramPOST['device']);
  $ipaddress = $paramREMOTE['REMOTE_ADDR'];

  auditoriaLog('Begin - CEP_pesquisa()',$sql,$device,$login,$nome_completo,$ipaddress);

  // Verifica se o CEP esta vindo com hifen e ponto

  // if(strpos($q,".") > 0) {
  //   $cep  = explode(".",$q);
  //   $q = $cep[0].$cep[1];
  // }

  // if(strpos($q,"-") > 0) {
  //   $cep  = explode("-",$q);
  //   $q    = $cep[0].$cep[1];
  // }

  $q = ereg_replace( "[' '-. t]",'', $q );

  // Valida se tem conteudo
  if(hasContent($q) == 0) {
    returnJson(-1,'Favor informar o CEP a ser pesquisado.');
  } else {
    $sql = "SELECT ";
    $sql = $sql . " CONCAT(SUBSTRING(cep,1,2),'.',SUBSTRING(cep,3,3), '-', SUBSTRING(cep,6,8)) AS cep, logradouro, bairro, cidade, estado ";
    $sql = $sql . " FROM cep2012 ";
    $sql = $sql . " WHERE cep = trim('$q') LIMIT 1";
  }

  $search = query($sql);

  if($search['error']) {
    returnJson(-1,"Erro executando pesquisa.",$cep['error']);
  }

  // // se retornou 1 usuario encontrado
  if ((isset($search)) && (sizeof($search) > 0)) {
    auditoriaLog('CEP_pesquisa() - CEP localizado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(0,'Sucesso.', $search);

  } else {
    auditoriaLog('CEP_pesquisa() - CEP não localizado.',$sql,$device,$login,$nome_completo,$ipaddress);
    returnJson(-1,'Atenção, CEP não localizado.');
  }
}

/*
SELECT
    logradouro.logradouro, bairro.bairro, cidade.cidade, uf.uf
FROM logradouro logradouro
LEFT JOIN bairro bairro
    ON bairro.id = logradouro.idBairro
LEFT JOIN cidade cidade
    ON cidade.id = bairro.idCidade
LEFT JOIN uf uf
    ON uf.id = cidade.idUf
WHERE logradouro.cep = '".$this->cep."'
*/


