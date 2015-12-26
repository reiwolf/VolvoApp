<?php

  $fileTmpLoc = $_FILES["file"]["tmp_name"];
  $fileName   = $_FILES["file"]["name"];

  // Path and file name - (chmod 777 assinaturas)
  $pathAndName = "./assinaturas/".$fileName;

  // Run the move_uploaded_file() function here
  if (!move_uploaded_file($fileTmpLoc, $pathAndName)) {
    echo "Error salvando assinatura. - FILE_NAME: " . $fileName ;
    exit(-1);
  }

  echo "Sucesso - Salvo em: " . $pathAndName;

/*

ini_set('max_upload_filesize', 8388608);
if ($_FILES["file"]["error"] > 0) {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
} else {
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

  if (file_exists("assinaturas/" . $_FILES["file"]["name"])) {
    echo $_FILES["file"]["name"] . " already exists. ";
  } else {
    move_uploaded_file($_FILES["file"]["tmp_name"],
    "assinaturas/" . $_FILES["file"]["name"]);
    echo "Stored in: " . "assinaturas/" . $_FILES["file"]["name"];
  }
}

*/