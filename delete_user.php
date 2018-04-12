<?php
$page_title = 'Delete User';
$page_slug = 'Delete_user';
$page_description = 'Delete User';
$page_keyword = 'Delete User, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$id = '';
$type = '';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
}

if ($type == 'student') {
    $db_controller->deleteRecord('students','Student_Id',$id);
    header('Location: students.php');
}elseif($type == 'staff'){
    $db_controller->deleteRecord('staff','Staff_Id',$id); 
    header('Location: staff.php');
}

?>

<?php 
include('template/footer.php');
?>

