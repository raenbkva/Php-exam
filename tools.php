<?php

function _get_rand_str()  {
    $alphas = range('A', 'z');
    $nums = range(0, 9);
    $main_arr = array_merge($nums, $alphas, $nums);
    shuffle($main_arr);
    $main_arr = array_values($main_arr);

    $ret = '';
    for($i = 0;$i < 10; $i++) {
        $ret .= $main_arr[$i];
    }
    return $ret;
}
// admin functions
function auth_user($email, $pass) {
    global $dbh;

    $query = $dbh -> query("select * from admin where email='{$email}' and password='{$pass}'")->fetchAll(PDO::FETCH_ASSOC);

    if(!isset($query[0]['id']))
        return "Неверная связка email/пароль!";

    $_SESSION['admin'] = $query[0];

    return true;
}
function get_sessions($session_id = 0) {
    global $dbh;
    if($session_id == 0) {
        $sessions = $dbh->query("SELECT * FROM sessions")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($sessions as $key=>$session) {
            if($session['status'] == 0)
                $sessions[$key]['status_text'] = "Закрытая сессия";
            else if ($session['status'] == 1)
                $sessions[$key]['status_text'] = "Открытая сессия";
            $sessions[$key]['links'] = $dbh->query("SELECT * FROM links WHERE session_id={$session['id']}")->fetchAll(PDO::FETCH_ASSOC);

        }
    }
    else {
        $sessions = $dbh->query("SELECT * FROM sessions WHERE id={$session_id}")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($sessions as $key=>$session) {
            if($session['status'] == 0)
                $sessions[$key]['status_text'] = "Закрытая сессия";
            else if ($session['status'] == 1)
                $sessions[$key]['status_text'] = "Открытая сессия";
        }
    }
    return $sessions;
}
function get_questions($session_id) {
    global $dbh;
    $session = $dbh->query("SELECT * FROM sessions WHERE id={$session_id}")->fetchAll(PDO::FETCH_ASSOC);
//    $session[0]['questions'] = '[
//        {"name":"ujy","description":"jytju","type":"1","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]},
//        {"name":"ujy","description":"jytju","type":"2","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]},
//        {"name":"ujy","description":"jytju","type":"3","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]},
//        {"name":"ujy","description":"jytju","type":"4","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]},
//        {"name":"ujy","description":"jytju","type":"5","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]},
//        {"name":"ujy","description":"jytju","type":"6","vars":[{"name":"hy","score":"6"},{"name":"bb","score":"7"},{"name":"jkk","score":"9"}]}]';
    return json_decode($session[0]['questions'], true);
}
function generate_link($session_id) {
    global $dbh;

    $nkey = _get_rand_str();

    $dbh->query("INSERT INTO links (session_id, nkey, seed) VALUES ({$session_id},'{$nkey}','1')");

    return ['errno'=>0, 'sql'=>"INERT INTO links (session_id, nkey, seed) VALUES ({$session_id},'{$nkey}','1')"];
}
function save_session($data) {
    global $dbh;
    if(isset($data['id'])) {
        $session_id = $data['id'];
        $update_string = "UPDATE sessions SET";
        $update = [];
        if (isset($data['name']))
            $update[] .= " name='{$data['name']}' ";
        if (isset($data['questions'])) {
            $questions = json_encode($data['questions'],JSON_UNESCAPED_UNICODE);
            $update[] .= "questions='{$questions}'";
        }
        if(isset($data['status'])) {
            $status = $data['status'] == 0 ? 1 : 0;
            $update[] .= " status={$status}";
        }

        $upd_str = implode(",", $update);
        $update_string .= " ".$upd_str;

        $update_string .= " WHERE id = {$session_id}";
        $query = $dbh->query($update_string);
    } else {
        $questions = "";
        if (isset($data['questions'])) {
            $questions = json_encode($data['questions'],JSON_UNESCAPED_UNICODE);
        }
        $insert_string = "INSERT INTO sessions (name, status, created_id, questions) VALUES ('{$data['name']}', 0, now(), '{$questions}')";

        $query = $dbh->query($insert_string);
        $session_id = $dbh->lastInsertId();
    }
    if($query)
        return ['errno'=>0];

    return [$query, 'sql'=>$insert_string, 'sql_u'=>$update_string];
}
function get_answers ($session_id, $elink = null) {
    global $dbh;

    if($elink == null)
        $answers = $dbh->query("select * from protocol where session_id={$session_id}")->fetchAll(PDO::FETCH_ASSOC);
    else
        $answers = $dbh->query("select * from protocol where session_id={$session_id} and link = '{$elink}'")->fetchAll(PDO::FETCH_ASSOC);

//    $answers = [['id'=>1]];

    return $answers;
}

// expert function
function check_expert_link($expert_link) {
    global $dbh;

    return true;
}
function save_answers($data, $get) {
    global $dbh;
    $session_id = $data['sid'];
    unset($data['sid']);
    $link = $get['expert_link'];
    $answers = json_encode($data, JSON_UNESCAPED_UNICODE);
    $browser_info = json_encode(['ip'=>$_SERVER['REMOTE_ADDR']],JSON_UNESCAPED_UNICODE);
//    var_dump("INSERT INTO protocol (answer,link,modified_at,session_id, browser_info)
//values ('{$answers}', '{$link}',now(), {$session_id},'{$browser_info}')");
    $err = $dbh -> query("INSERT INTO protocol (answer,link,modified_at,session_id, browser_info)
values ('{$answers}', '{$link}',now(), {$session_id},'{$browser_info}')");
    return $err;
}
