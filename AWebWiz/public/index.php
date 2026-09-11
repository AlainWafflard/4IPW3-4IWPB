<?php
// ROUTER

session_start();

require_once "../app/config/app.php";
require_once "../app/config/model.php";
require_once "../vendor/AWebWiz/helper.php";
require_once "../vendor/AWebWiz/router.php";

Router::include_mvc_php_files();

// select header type, ie. type of returned data, default is HTML text  "Content-Type: text/html; charset=UTF-8";
$header = @$_REQUEST['returnType'] ?: 'text/html; charset=UTF-8';

// Récupérer la page demandée (par défaut : 'home')
// select page to load, ie. function to call
// making router more universal => using superglobal REQUEST instead of POST or GET
$page = isset($_REQUEST['page']) ? strtolower($_REQUEST['page']) : 'home';
// $page = @$_REQUEST['page'] ?: 'home';
// $main = "main_{$page}";

// OUTPUT
header("Content-Type: $header");
echo Router::route($page, $header);

