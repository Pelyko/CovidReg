<?php
    require_once('utils/init.php');
    $errors = [];


    if(!isset($_SESSION['user'])){
        header('Location: login.php');
    }else{
        $user = $_SESSION['user'];
        $date = $date_storage -> findOne(['id' => $_GET['id']]);
        var_dump($date);
    }

    if(isset($_POST['accept']) && $_POST['accept'] === "on"){
        $user['appointment'] = $date['id'];
        $_SESSION['user']['appointment'] = $date['id'];
        $users_storage -> update($user['id'],$user);
        $date['full_slots'] = $date['full_slots'] + 1;
        $date['users'][] = $user['id'];
        $date_storage -> update($date['id'],$date);
        header('Location: index.php');
    }else{
        $errors[] = "A jelentkezés feltételeit kötelező elfogadni!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paper.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Covid-19</title>
</head>
<body>
    <div id="body" class="row flex-center">
        <div class="sm-6 col" id="list-cont">
            <div class="row" id="title"><h1>COVID-19</h1></div>
            <div class="row flex-center" id="list">
                <div class="sm-4 col box">
                    Az ön adatai: <br>
                    Neve: <?= $user['name'] ?><br>
                    Lakcíme: <?= $user['address'] ?><br>
                    TAJ száma: <?= $user['TAJ'] ?> <br>
                </div>
                <div class="sm-4 col box">
                    Az időpont adatai: <br>
                    Dátum: <?= $date['date'] ?><br>
                    Időpont: <?= $date['time'] ?><br>
                </div>
            </div>
            <form method="POST">
            <fieldset class="form-group">
                    <label for="paperChecks1" class="paper-check">
                <input type="checkbox" name="accept" id="paperChecks1"> <span>Elfogadom a jelentkezés feltételeit</span>
            </label>
            </fieldset>
                    <button type="submit">Jelentkezés megerősítése</button>
            </form>
            <div class="row" id="errors">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li class="redtext"> <?=$error ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php if($_SESSION['user']['rank'] === "admin"): ?>
                Erre az időpontra jelentkezett felhasználok: <br>
                <ul>
                    <?php foreach($date['users'] as $id): ?>
                        <?php $u = $users_storage -> findOne(['id' => $id])?>
                        <li>
                            Név: <?=$u['name']?><br>
                            e-mail cím: <?=$u['email']?><br>
                            TAJ szám: <?=$u['TAJ']?><br>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <div class="row">
                <a href="index.php"><button>Vissza a főoldalra</button><a>
            </div>
        </div>
    </div>
</body>
</html>