<?php 
//Start session
session_start();

//$site_url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$site_url = 'http://localhost/clz/university_project/';

if (isset($_SESSION['user_details'])) {
	if ($page_slug == 'login') {
		header('Location: '.$site_url.'index.php');
		exit();
	}
}else{
	if ($page_slug != 'login') {
		header('Location: '.$site_url.'login.php');
		exit();
	}
	
}

?>