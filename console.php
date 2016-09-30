<?php
//error_reporting(E_ERROR | E_PARSE);
include "vendor/autoload.php";
$config = include 'config/autoload/dev.local.php';
\Ainias\Core\Connections\MyConnection::setDefaults($config["dbDefault"]);

include "public/index.php";