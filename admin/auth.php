<?php
$msg = "";
if(isset($_POST['email']) && isset($_POST['pass'])) {
    $status = auth_user($_POST['email'], $_POST['pass']);

    if($status !== true) {
        $msh = $status;
    } else {
        header("Location:/?page=list");
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="admin/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Березина Анна 191-321</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark mb-3 nav">
        <a class="navbar-brand" href="#">PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</header>
<main>
    <div class="container w-50">
        <? if($status !== true): ?>
            <div style="color:red"><?=$msh?></div>
        <? endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="pass">Пароль:</label>
                <input type="password" name="pass" id="pass" class="form-control">
            </div>
            <div class="button_log">
                <!--                <input class="log" type="submit" value="войти">-->
                <button type="submit" class="btn btn-success">Войти</button>
            </div>
        </form>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>