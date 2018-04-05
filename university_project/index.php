<?php
$page_title = 'Timeline';
$page_slug = 'index';
$page_description = 'Timeline';
$page_keyword = 'Timeline, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');
?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
        
            <?php include('template/inc-post.php'); ?>
        </div>

        <div class="col-md-3 box3">
            <?php include('template/inc-most_popular.php'); ?>

            <?php include('template/inc-most_view.php'); ?>
        </div>
    </div>
</div>



<?php 
include('template/footer.php');
?>