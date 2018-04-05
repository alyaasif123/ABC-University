<html>
<head>
    <?php include('template/header-include.php');?>
</head>

<body>
<?php include('template/check_access.php'); ?>
<?php if ($page_slug != 'login') {?>
<header>
    <div class="">
        <?php include('template/menu.php');?>
    </div>
</header>
<?php } 

//Include database connection details
require_once('db.php');
$db_controller = new DbController();
?>


