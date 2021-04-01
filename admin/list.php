<?php
$list = get_sessions();
//$list = [];
//var_dump($list);
?>
<html>
<head>
    <link rel="stylesheet" href="admin/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Березина Анна 191-321</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg sticky-top justify-content-between navbar-dark mb-3 nav">
        <a class="navbar-brand" href="/">PHP</a>
        <a href="/?logout" class="nav-item" style="color: aliceblue">Выход</a>
    </nav>
</header>
<main>
    <div class="container">
        <div class="row justify-content-center create_new_session">
            <a class="btn btn-info mb-3" href="/?page=edit">Добавить новую сессию</a>
        </div>
        <table class="table">
            <thead class="thead" style="background:rgb(214, 156, 231)">
            <tr>
                <th scope="col">№</th>
                <th scope="col">Название сессии</th>
                <th scope="col">Статус сессии</th>
                <th scope="col">Ссылки</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$item): ?>
                <tr>
                    <td><?php echo($key+1)?></td>
                    <td><?php echo $item['name']?></td>
                    <td><?php echo $item['status_text']?></td>
                    <td>
                        <?php foreach ($item['links'] as $link): ?>
                            <p class="alert alert-info">
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/?expert_link=<?php echo $link['nkey']?>&sid=<?php echo $item['id']?>" target="_blank">http://<?php echo $_SERVER['HTTP_HOST']?>/?expert_link=<?php echo $link['nkey']?>&sid=<?php echo $item['id']?></a>
                            </p>
                            <p class="alert alert-light">
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/?page=answers&elink=<?php echo $link['nkey']?>&sid=<?php echo $item['id']?>" target="_blank">Ответы отдельно по ссылке</a>
                            </p>
                        <?php endforeach;  ?>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm m-2"" href="/?page=edit&sid=<?php echo $item['id']?>">Редактировать</a>
                        <a class="btn btn-outline-info btn-sm m-2"" href="/?page=answers&sid=<?php echo $item['id']?>">Ответы по сессии</a>
                        <button class="btn btn-outline-warning btn-sm generate_link m-2" sid="<?php echo $item['id']?>">Сгенерировать ссылку</button>
                        <button class="btn btn-outline-success btn-sm change_status m-2" sid="<?php echo $item['id']?>" val="<?php echo $item['status'];?>"><?php if($item['status']==0)echo "Открыть сессию"; else echo "Закрыть сессию";?></button>
                        <button class="btn btn-outline-danger btn-sm remove_session m-2" sid="<?php echo $item['id']?>">Удалить</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
</body>
</html>