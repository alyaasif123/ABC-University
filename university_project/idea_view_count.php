<?php
session_start();
//Include database connection details
require_once('db.php');
$db_controller = new DbController();
$result = '';
if (isset($_POST['id'])) {
    $idea_id = $_POST['id'];
    $db_controller->addViewCountToIdea($idea_id);
}
echo json_encode($result);
?>


