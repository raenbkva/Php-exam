<?php
$sid = 0;
$msg = "";
if(count($_POST) > 0) {
    $err = save_answers($_POST, $_GET);
    //var_dump($err);
    if ($err) {
        $msg = "Ответы сохранены.";
    } else {
        $msg = "Ошибка сохранения.";
    }
}
if(isset($_GET['sid'])) {
    $questions = get_questions($_GET['sid']);
    $sid = $_GET['sid'];
}
//var_dump($session[0]);
//var_dump($questions);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Березина Анна 191-321</title>
    <link rel="stylesheet" href="expert/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script><?php if(strlen($msg)) echo "alert('$msg');"; ?></script>
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
<main>
    <div class="container ">
        <form method="post">
            <div>
            <?php foreach ($questions as $qk=>$question) {?>
<div class="w-50">
<h1><?php echo $question['name'];?></h1>
<p><?php echo $question['description'];?></p>
<?php switch ($question['type']) {?>
<?php case "1": {?>
<div>
<input type="number" class="form-control" id="input-num-<?php echo $qk?>" name="input-num-<?php echo $qk?>"/>
</div>
<?php break; }?>
<?php case "2": {?>
<div>
<input type="number" class="form-control" id="input-num-positive-<?php echo $qk?>" min="0" name="input-num-positive-<?php echo $qk?>"/>
</div>
<?php break; }?>
<?php case "3": {?>
<div>
<input type="text" class="form-control" id="input-text-<?php echo $qk?>" name="input-text-<?php echo $qk?>"/>
</div>
<?php break; }?>
<?php case "4": {?>
<div>
<textarea cols="50" class="form-control" id="textarea-<?php echo $qk?>" rows="5" name="textarea-<?php echo $qk?>"></textarea>
</div>
<?php break; }?>
<?php case "5": {?>
<?php foreach ($question['vars'] as $k=>$var) {?>
<div>
<input type="radio" class="form-check-input" id="radio-<?php echo $k?>" value="<?php echo $var['score'];?>" name="radio-question-<?php echo $qk?>"/>
<label for="radio-<?php echo $k?>"><?php echo $var['name'];?></label>
</div>
<?php }?>
<?php break; }?>
<?php case "6": {?>
<?php foreach ($question['vars'] as $k=>$var) {?>
<div>
<input type="checkbox" class="form-check-input" id="check-<?php echo $k?>" value="<?php echo $var['score'];?>" name="check-question-<?php echo $qk?>[]"/>
<label for="check-<?php echo $k?>"><?php echo $var['name'];?></label>
</div>
<?php }?>
<?php break; }?>
<?php }?>
</div>
            <?php } ?>
            </div>
            <input type="hidden" value="<?php echo $_GET['sid']?>" name="sid">
            <div>
                <input type="submit" class="btn btn-primary" value="Отправить"/>
            </div>
        </form>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
    crossorigin="anonymous"></script>
<script src="expert/expert.js"></script>
</body>
</html>
