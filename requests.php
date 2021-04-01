<?php
require_once("./db/db.php");
require_once("tools.php");

if(isset($_POST['save_question'])) {
    die(json_encode(save_session($_POST),JSON_UNESCAPED_UNICODE));
}

if(isset($_GET['type']) && $_GET['type'] == 'changeStatus') {
    die(json_encode(save_session($_POST),JSON_UNESCAPED_UNICODE));
}
if(isset($_GET['type']) && $_GET['type'] == 'removeSession') {
    $dbh->query("DELETE FROM sessions WHERE id={$_POST['id']};");
    die(json_encode(['errno'=>0]));
}
if(isset($_GET['type']) && $_GET['type'] == 'generateLink') {
    die(json_encode(generate_link($_POST['id'])));
}
if(isset($_GET['expert_questions'])) {
    die(json_encode(['questions'=>get_questions($_GET['session_id'])],JSON_UNESCAPED_UNICODE));
}