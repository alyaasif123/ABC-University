<?php
$page_title = 'Delete User';
$page_slug = 'Delete_user';
$page_description = 'Delete User';
$page_keyword = 'Delete User, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if ($id != '') {
    $del = $db_controller->deleteRecord('categories','Category_Id',$id);

    if ($del != '') {
    	header('Location: category.php');
    }else{
    	header('Location: category.php?msg=1');
    }
    
}

?>

<?php 
include('template/footer.php');
?>

