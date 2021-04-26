<?php
    require_once("utils/init.php");

    $errors = [];
    $allset = True;

    if($_POST !== []){
        if(isset($_POST['name']) && $_POST['name'] !== ''){
            $name = $_POST['name'];
        }else{
            $errors[] = "Név megadása kötelező!";
            $allset = False;
        }

        if(isset($_POST['TAJ'])  && $_POST['TAJ'] !== ''){
            if(preg_match('/[0-9]{9}/',$_POST['TAJ'])){
                $TAJ = $_POST['TAJ'];
            }else{
                $errors[] = "Nem megfelelő a TAJ szám formátuma (9 db szám)";
                $allset = False;
            }
        }else{
            $errors[] = "Tajszám megadása kötelező!";
            $allset = False;
        }

        if(isset($_POST['address'])  && $_POST['address'] !== ''){
            $address = $_POST['address'];
        }else{
            $errors[] = "A cím megadása kötelező!";
            $allset = False;
        }

        if(isset($_POST['email'])  && $_POST['email'] !== ''){
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = $_POST['email'];
            }else{
                $allset = False;
                $errors[] = "Az e-mail cím formátuma nem megfelelő";
            }
        }else{
            $errors[] = "Az e-mail cím megadása kötelező!";
            $allset = False;
        }

        if(isset($_POST['password']) && $_POST['password'] !== ''){
            if(isset($_POST['password_again']) && $_POST['password_again'] === $_POST['password']){
                $password = $_POST['password'];
            }else{
                $errors[] = "A két jelszó nem egyezik meg!";
                $allset = False;
            }
        }else{
            $errors[] = "A jelszó megadása kötelező!";
            $allset = False;
        }

        if($allset){
            if(!$users_storage -> findOne(['TAJ' => $TAJ])){
                $new_user = [
                    "name" => $name,
                    "TAJ" => $TAJ,
                    "address" => $address,
                    "email" => $email,
                    "password" => password_hash($password, PASSWORD_DEFAULT),
                    "appointment" => 0,
                    "rank" => "user"
                ];
                $users_storage -> add($new_user);
                $_SESSION['user'] = $new_user;
                header('Location: login.php');
            }else{
                $errors[] = "Ezzel a TAJ számmal már regisztráltak!";
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
            <div class="row" id="title"><h1>REGISZTRÁCIÓ</h1></div>
            <form method="POST">
                Név: <input name="name" type="text" value=<?=isset($name) ? $name : ''?>><br>
                TAJ szám: <input name="TAJ" type="text" value=<?=isset($TAJ) ? $TAJ : ''?>><br>
                Értesítési cím: <input name="address" type="text" value=<?=isset($address) ? $address : ''?>><br>
                E-mail cím: <input name="email" type="text" value=<?=isset($email) ? $email : ''?>><br>
                Jelszó: <input name="password" type="password"></br>
                Jelszó újra: <input name="password_again" type="password"><br>
                <button type="submit">Regisztrálok</button><br>
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
