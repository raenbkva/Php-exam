<?php
$sid = 0;
if(isset($_GET['sid'])) {
    $session = get_sessions($_GET['sid']);
    $sid = $_GET['sid'];
}
//var_dump($session[0]);
$session[0]['questions'] = json_decode($session[0]['questions'], true);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Березина Анна 191-321</title>
    <link rel="stylesheet" href="admin/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg sticky-top justify-content-between navbar-dark mb-3 nav">
        <a class="navbar-brand" href="/">PHP</a>
        <a href="/?logout" class="nav-item" style="color: aliceblue">Выход</a>
    </nav>
</header>
<main>
    <div class="container ">
        <input type="hidden" name="id" id="id" value="<?php echo $sid; ?>">
        <div class="new_q">
            <button class="btn btn-primary" id="add_new_question">Добавить вопрос</button>
        </div>
        <div class="button">
            <button class='save_session btn btn-secondary mt-2'>Сохранить</button>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="row" id="session_form" method="post">
            <div class="name row">
                <label for="name">Название сессии</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
            <div>
                <div class="session_questions form-group ">

                </div>

            </div>
        </div>

    </div>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>
<script src="/static/js/admin.js"></script>
<?php if(isset($_GET['sid'])): ?>
    <script>
        var sessionData = JSON.parse('<?php echo json_encode($session[0],JSON_UNESCAPED_UNICODE); ?>');
        fill_session_form(sessionData);
    </script>
<?php  endif; ?>
</body>
</html>
