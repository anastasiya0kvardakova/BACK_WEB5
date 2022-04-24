<?php session_start();
session_destroy();
$_SESSION['login'] = '';
header('Location: ./');
?>