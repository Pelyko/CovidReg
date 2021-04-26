<?php
    require_once('utils/init.php');
    $date = $date_storage -> findOne(['id' => $_SESSION['user']['appointment']]);
    $newusers = [];
    foreach($date['users'] as $d){
        if($d !== $_SESSION['user']['id']){
            $newusers[] = $d;
        }
    }
    $date['users'] = $newusers;
    $date['full_slots'] = $date['full_slots'] - 1;
    $date_storage -> update($date['id'],$date);
    $_SESSION['user']['appointment'] = 0;
    $user = $users_storage -> findOne(['id' => $_SESSION['user']['id']]);
    $user['appointment'] = 0;
    $users_storage -> update($user['id'],$user);
    header('Location: index.php');
?>