<?php
    require_once("utils/init.php");
    $errors = [];
    $allset = True;
    
    if($_POST !== []){
        if(isset($_POST['date']) && $_POST['date'] !== ''){
            if(preg_match("/([01]?[0-9]|2[0-3]):[0-5][0-9]/",$_POST['time'])){
                $time = $_POST['time'];
            }else{
                $allset = False;
                $errors[] = "Az idő formátumat nem megfelelő. Helyes formátum: HH:MM";
            }
        }else{
            $allset = False;
            $errors[] = "Az időpontot kötelező megadni!";
        }

        if(isset($_POST['date']) && $_POST['date'] !== ''){
            if(preg_match("`[0-9]{4}/(0[1-9]|1[0-2])/(0[1-9]|[1-2][0-9]|3[0-1])`",$_POST['date'])){
                $date = $_POST['date'];
            }else{
                $allset = False;
                $errors[] = "A dátum formátuma nem megfelelő. Helyes formátum: YYYY/MM/DD";
            }
        }else{
            $allset = False;
            $errors[] = "A dátumot kötelező megadni!";
        }

        if(isset($_POST['maxslots']) && $_POST['maxslots'] !== ''){
            $max_slots = $_POST['maxslots'];
        }else{
            $allset = False;
            $errors[] = "A férőhelyek számát kötelező megadni!";
        }

        if($allset){
            $new_date = [
                "date" => $date,
                "time" => $time,
                "max_slots" => intval($max_slots),
                "full_slots" => 0,
                "users" => []
            ];
            $date_storage -> add($new_date);
            header('Location: index.php');
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
            <div class="row" id="title"><h1>ÚJ IDŐPONT MEGADÁSA</h1></div>
            <form method="POST">
                Dátum: <input name="date" type="text"></input><br>
                Időpont: <input name="time" type="text"></input><br>
                Helyek száma: <input name="maxslots" type="number"></input><br>
                <button type="submit">Időpont megerősítése</button><br>
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