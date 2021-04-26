<?php
    require_once("utils/init.php");
    $errors = [];
    $allset = True;

    if($_POST !== []){
        if(isset($_POST['email'])  && $_POST['email'] !== ''){
            $email = $_POST['email'];
        }else{
            $errors[] = "Az e-mail cím megadása kötelező!";
            $allset = False;
        }

        if(isset($_POST['password']) && $_POST['password'] !== ''){
            $password = $_POST['password'];
        }else{
            $errors[] = "A jelszó megadása kötelező!";
            $allset = False;
        }

        if($allset){
            $user = $users_storage -> findOne(['email' => $email]); 
            if(isset($user)){
                if(password_verify($password, $user['password'])){
                    $_SESSION['user'] = $user;
                    if(isset($_GET['id']) && $user['appointment'] === 0){
                        header('Location: description.php?id='.$_GET['id']);
                    }else{
                        header('Location: index.php');
                    }
                }else{
                    $errors[] = "Nem megfelelő a jelszó.";
                }
            }else{
                $errors[] = "Ezzel az e-mail címmel nincs regisztrált felhasználó.";
            }
        }
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
            <div class="row" id="title"><h1>BELÉPÉS</h1></div>
            <form method="POST">
                E-mail cím: <input name="email" type="text" value=<?=isset($email) ? $email : ''?>><br>
                Jelszó: <input name="password" type="password"></br>
                <button type="submit">Belépek</button><br>
            </form>
            <br><a href="index.php"><button>Vissza a főoldalra</button><a>
            <div class="row" id="errors">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li class="redtext"> <?=$error ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>