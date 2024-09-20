<?php

session_start();

unset($_SESSION['user']);
$_SESSION['done'] = ['Logged out!'];

header('Location: login.php');
exit;
