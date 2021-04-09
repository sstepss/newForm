<?php require_once "form.php" ?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DZ</title>
</head>
<body>
<div class="reg-form">
    <form action="./" method="post">
        <input type="text" name="name" /><br>
        <input type="text" name="email" /><br>
        <input type="text" name="age" /><br>

        <button type="submit">
            Отправить
        </button>
    </form>

    <div>
        <?php q($_POST)?>
        <?php $validate = valid($_POST)?>
        <?php if (!empty($validate['error']) and $validate['error']): ?>
            <?php foreach ($validate['messages'] as $message): ?>
                <p style="color: red">
                    <?= $message ?>
                </p>
            <?php endforeach;  ?>
        <?php endif;?>
        <?php if (!empty($validate['success']) and $validate['success']):?>
            <?php foreach (getUsers() as $user):?>
                <div>
                    <?= $user ['name']?>    <?= $user ['email']?>   <?= $user ['age']?>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

</div>

</body>
</html>
