<?php
require_once('utils/init.php');

unset($_SESSION['user']);
header('Location: index.php');
exit(0);
?>