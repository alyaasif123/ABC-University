<?php
session_start();
unset($_SESSION['user_details']);

header("Location: index.php");
?>


