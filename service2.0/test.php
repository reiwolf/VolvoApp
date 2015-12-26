<?php


$conn = mysqli_connect_db('127.0.0.1', 'projeto', '*senha@', 'configuracao');
mysqli_select_db($conn, 'configuracao');

$sqk = "SELECT * FROM pacote WHERE pacote =  'LC'";

echo $sql;

mysqli_query($sql);


