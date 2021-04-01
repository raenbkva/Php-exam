<?php

function calculate_one($data) {
    $results = [];
    foreach ($data as $k=>$q) {
        $question_key = explode("-",$k);
        if ($question_key[0] == 'check' || $question_key[0] == 'radio') {
            if (is_array($q)) {
                foreach ($q as $var) {
                    $results[] = (int)$var;
                }
            } else {
                $results[] = (int)$q;
            }
        }
    }
    return array_sum($results);
}
function calculate_full($data) {
    $res = [];
    foreach ($data as $ans) {
        $answer = json_decode($ans['answer'], true);

        $result = calculate_one($answer);

        $res[] = $result;
    }
    if (count($res) > 0) {
        return array_sum($res) / count($res);
    }
    return 0;
}
function calculate_by_type($data) {
    $results = [];
    $results['check'] = [];
    $results['radio'] = [];
    foreach ($data as $k=>$q) {
        $question_key = explode("-",$k);
        if ($question_key[0] == 'check' || $question_key[0] == 'radio') {
            if (is_array($q)) {
                foreach ($q as $var) {
                    $results['check'][] = (int)$var;
                }
            } else {
                $results['radio'][] = (int)$q;
            }
        }
    }
    if (count($results['check']))
        $results['check']['avg'] = array_sum($results['check']) / count($results['check']);
    if (count($results['radio']))
        $results['radio']['avg'] = array_sum($results['radio']) / count($results['radio']);

    return $results;
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Тишкина Алина Федоровна 191-322</title>
        <script src="../static/js/Chart.min.js"></script>
        <link rel="stylesheet" href="expert/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"

    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark mb-3 nav">
            <a class="navbar-brand" href="/">PHP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </header>
        <?php

        if (isset($_GET['sid']) && !isset($_GET['elink'])) {
            $answers = get_answers($_GET['sid']);
        } else if(isset($_GET['elink'])) {
            $answers = get_answers($_GET['sid'], $_GET['elink']);
        }
            $session = get_sessions($_GET['sid']);
            $questions = json_decode($session[0]['questions'], true);
            $session_avg = calculate_full($answers);
            echo "<div class='container'>";
            echo "<h2>Ответы по сессии</h2>";
            echo "<h3>Средний балл по сессии: {$session_avg}</h3>";
            echo "<table>";
            echo "<tr>";
            echo "<th scope='col'>№</th>";
            echo "<th scope='col'>Дата и время</th>";
            echo "<th scope='col'>IP пользователя</th>";
            echo "<th scope='col'>Результаты</th>";
            echo "<th scope='col'>Диаграмма</th>";
            echo "</tr>";
            foreach ($answers as $key=>$answer) {
                $user = json_decode($answer['browser_info'], true);
                $ans = json_decode($answer['answer'], true);
                $result = calculate_one($ans);
                $diagram = calculate_by_type($ans);
                echo "<tr>";
                echo "<td>".($key+1)."</td>";
                echo "<td>".$answer['modified_at']."</td>";
                echo "<td>".$user['ip']."</td>";
                echo "<td>";
                echo "<div>Общий балл: {$result}</div>";
                echo "<div>";
                foreach ($ans as $k=>$q) {
                    $question_key_arr = explode("-", $k);
                    $qid = end($question_key_arr);
                    if(!is_array($q)) {
                        echo "<p>{$questions[$qid]['name']}:{$q}</p>";
                    } else {
                        foreach ($q as $a) {
                            echo "<p>{$questions[$qid]['name']}:{$a}</p>";
                        }
                    }
                }
                echo "<div>";
                echo "</td>";
                echo "<td>";
                echo '<canvas id="myChart-'.$key.'" width="250" height="250"></canvas>';
                echo "<script>
            var ctx = document.getElementById('myChart-{$key}');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['CheckBox', 'Radio'],
                    datasets: [{
                        label: '# голосов',
                        data: [{$diagram['check']['avg']}, {$diagram['radio']['avg']}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";

        ?>
    </body>
</html>