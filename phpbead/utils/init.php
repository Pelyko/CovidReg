<?php
require_once('storage.php');

session_start();

$date_storage = new Storage(new JsonIO('storage/dates.json'));
$users_storage = new Storage(new JsonIO('storage/users.json'));
