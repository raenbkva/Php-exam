<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1);
session_start();

require_once('./db/db.php');
require_once('tools.php');
//
//if (!isset($_GET['page']))
//    $_GET['page']='list';
//include_once("./admin/{$_GET['page']}.php");
if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header("Location:/");
    return;
}

if (!isset($_GET['expert_link']) && !isset($_GET['page']) && !isset($_SESSION['admin'])) {
    include_once("./admin/auth.php");
    return;
}

if (isset($_GET['expert_link'])) {
//    if (check_expert_link($_GET['expert_link']))
    include_once("./expert/show.php");
    return;

}

if (isset($_SESSION['admin']) && ( isset($_GET['page']) || !isset($_GET['page']))) {
    if (!isset($_GET['page']))
        $_GET['page']='list';
    include_once("./admin/{$_GET['page']}.php");
    return;
}
?>

