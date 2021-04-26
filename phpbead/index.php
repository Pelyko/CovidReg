<?php
    require_once('utils/init.php');
    $errors = [];
    $months = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    $monthnames = ["Január","Február","Március","Április","Május","Június","Július","Augusztus","Szeptember","Október","November","December"];
    if(!isset($_SESSION['month'])){
        $_SESSION['month'] = 0;
    }

    if(isset($_GET['month'])){
        $_SESSION['month'] = intval($_GET['month']);
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
            <div class="row" id="description">Ezen az oldalon tud regisztrálni a Covid-19 elleni védőoltásra. A regisztrációt követően jelentkezhet egy időpontra.</div>
            <?php if(!(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']['appointment'] === 0))): ?>
            <?php $date = $date_storage -> findOne(['id' => $_SESSION['user']['appointment']]); ?>
                <div class="row">
                    Önnek már van foglalt időpontja!<br>
                    Az ön időpontjának adatai: <br>
                    Dátum: <?=$date['date']?><br>
                    Időpont: <?=$date['time']?><br>
                    <div class="row">
                        <a href="closeappointment.php"><button>Időpont lemondása</button></a>
                    </div>
                </div>
            <?php endif ?>
            <div class="row" id="list">
                Időpontok ebben a hónapban: <?= $monthnames[$_SESSION['month']] ?><br>
                <?php $found = False ?>
                <ul>
                <?php foreach($date_storage->findAll() as $date):?>
                    <?php if(substr($date['date'],5,2) === $months[$_SESSION['month']]):?>
                    <?php $found = True ?>
                    <?php if(isset($_SESSION['user'])){
                         if($date['max_slots'] === $date['full_slots']){
                            $href = "";
                         }else{
                            $href = "description.php?id={$date['id']}";
                         }
                    }else{
                        $href = "login.php?id={$date['id']}";
                    }?>
                    <li class="date_list_items <?= $date['max_slots'] == $date['full_slots'] ? "red" : "green"?>"><?=$date['date']?> | <?=$date['time']?> | Szabad helyek: <?=$date['full_slots']?>/<?=$date['max_slots'] ?> <a href=<?=$href?>>
                        <?php if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']['appointment'] === 0)): ?>
                            <button id=<?=$date['id']?> class=<?= $date['max_slots'] == $date['full_slots'] ? "red-button" : "green-button"?>>Jelentkezés</button>
                        <?php endif ?>
                    </a></li>
                    <?php endif?>
                <?php endforeach?>
                <?php if(!$found): ?>
                    <li>Ebben a hónapban nincs időpoont.</li>
                <?php endif ?>
                </ul>
                <br>
                <div class="row flex-center">
                    <div class="lg-4 col"><a href="index.php?month=<?=$_SESSION['month']-1?>"><button <?= $_SESSION['month']>0? '' : 'disabled'?>>Előző hónap</button></a></div>
                    <div class="lg-4 col"><a href="index.php?month=<?=$_SESSION['month']+1?>"><button <?= $_SESSION['month']<11? '' : 'disabled'?>>Következő hónap</button></a></div>
                </div>
            </div>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['rank'] === "admin"): ?>
                <div class="row"><a href="newdate.php">Új időpont hozzáadása</a></div>
            <?php endif ?>
            <div class="row">
                <?php if(!isset($_SESSION['user'])):?>
                    <a href="login.php"><button>Belépés</button></a><a href="register.php"><button>Regisztráció</button></a>
                <?php else:?>
                    <div class="row">Üdv, <?= $_SESSION['user']['name'] ?>!</div>
                    <a href="logout.php"><button>Kijelentkezés</button></a>
                <?php endif?>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</body>
</html>