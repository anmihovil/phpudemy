<?php require_once("includes/header.php");?>

<?php
$session->logout($user);
redirect("login.php");
?>
