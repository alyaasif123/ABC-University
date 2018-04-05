<?php

$limit = 5;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;

/*Get total number of records */
$res_total = $db_controller->getIdeaListCount();

$total_rows = $res_total['total_rows'];
/*Get the total number of pages.*/
$total_pages = ceil($total_rows / $limit);

if(isset($_GET['page']) && $_GET['page'] != "") {
    $page = $_GET['page'];
    $offset = $limit * ($page-1);
} else {
    $page = 1;
    $offset = 0;
}

$idea_list = $db_controller->getIdeaList($offset, $limit);

if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
} else {
    if(($page - $adjacents) > 1) {                 //Checking if the current page minus adjacent is greateer than one.
        if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
            $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
            $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
        } else {                                   //If current page plus adjacents is greater than total pages.
            $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
            $end   = $total_pages;                         //and the end will be the last page number that is total pages number.
        }
    } else {                                       //If the current page minus adjacent is less than one.
        $start = 1;                                //then start will be start from page number 1
        $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
    }
}

foreach ($idea_list as $key => $value) {
    $students = $db_controller->getStudentDetailsById($value['Student_Id']);

    $user_type = '2';
    if ($_SESSION['user_details']['user_role_id'] == 2) {
        $user_type = '1';
    }

    //check current user like and dislike
    $like_dislike_details = $db_controller->getLikeDislikeIdeaByUser($_SESSION['user_details']['user_id'],$value['Idea_Id'],$user_type);

    $like_active_class = '';
    $dislike_active_class = '';
    if (count($like_dislike_details)>0) {

        if ($like_dislike_details['Status'] == 1) {
            $like_active_class = 'likeactive';
        }else{
            $dislike_active_class = 'likeactive';
        }
        
    }

    //get all comment count 
    $comment_count = $db_controller->getCommentByIdeaByStudentOrAll($value['Idea_Id'],$_SESSION['user_details']['user_role_id']);

    $comment_count = $comment_count['item_count'];
?>
<div class="style_box">
    <div class="post_img">
        <div class="left_side">
            <?php 
            if ($value['Anonymous_Status'] == 0) {
                if ($students['Image'] != '') {
            ?>
                    <img src="images/user/<?php echo $students['Image']; ?>" class="img-circle">
                <?php }else{ ?>
                    <img src="images/user.png" class="img-circle">
                <?php } ?>

            <?php }else{ ?>
                <img src="images/user.png" class="img-circle">
            <?php } ?>
            <div>
                <?php 
                if ($value['Anonymous_Status'] == 0) {
                ?>
                    <h6><?php echo $students['F_Name'].' '.$students['L_Name']; ?></h6>
                <?php }else{ ?>
                    <h6>Anonymous</h6>
                <?php } ?>
            
                <span><?php echo $db_controller->time_elapsed_string($value['Added_Date']); ?></span>
            </div>
        </div>

        <div class="dropdown right_side">
            <span class="glyphicon glyphicon-option-horizontal "  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span> 
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
            </ul>
        </div>
    </div>
    <div class="post_content">
        <h5><strong><?php echo $value['Idea_Topic']; ?></strong></h5>
        <p><?php echo $db_controller->wordLimit($value['Idea_Description'],200,$value['Idea_Id']); ?></p>
    </div>
    <div class="post_bottom">
        <div class="left_side">
            <div class="rating">
                <div data-type="like" id="like_<?php echo $value['Idea_Id']; ?>" class="like grow <?php echo $like_active_class; ?>" onclick="LikePost(<?php echo $value['Idea_Id']; ?>)">
                    <i class="fa fa-thumbs-up fa-2x like" aria-hidden="true"></i>
                    <span><?php echo $db_controller->getCountLikeDislikeById(1,$value['Idea_Id']); ?></span>
                </div>
                <div  data-type="dislike" id="dislike_<?php echo $value['Idea_Id']; ?>" class="dislike grow <?php echo $dislike_active_class; ?>" onclick="DislikePost(<?php echo $value['Idea_Id']; ?>)">
                    <i class="fa fa-thumbs-down fa-2x like" aria-hidden="true"></i>
                    <span><?php echo $db_controller->getCountLikeDislikeById(2,$value['Idea_Id']); ?></span>
                </div>
            </div>
        </div>
        
        <div class="right_side">
            <span class="comment_link"><a onclick="viewPage(<?php echo $value['Idea_Id']; ?>)">Add comment</a></span>
            <?php if ($comment_count != 0) {?> | 
                <span class="comment_link"><a onclick="viewPage(<?php echo $value['Idea_Id']; ?>)">View all comments</a> (<?php echo $comment_count; ?>)</span>
            <?php } ?>
        </div>
        
    </div>
</div>

<?php 
}
?>

<?php if($total_pages > 1) { ?>
<div class="div-pagination">
    <ul class="pagination pagination-sm justify-content-center">
        <!-- Link of the first page -->
        <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
            <a class='page-link' href='?page=1'><i class="fa fa-angle-double-left"></i></a>
        </li>
        <!-- Link of the previous page -->
        <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
            <a class='page-link' href='?page=<?php ($page>1 ? print($page-1) : print 1)?>'><i class="fa fa-angle-left"></i></a>
        </li>
        <!-- Links of the pages with page number -->
        <?php for($i=$start; $i<=$end; $i++) { ?>
        <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
            <a class='page-link' href='?page=<?php echo $i;?>'><?php echo $i;?></a>
        </li>
        <?php } ?>
        <!-- Link of the next page -->
        <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
            <a class='page-link' href='?page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'><i class="fa fa-angle-right"></i></a>
        </li>
        <!-- Link of the last page -->
        <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
            <a class='page-link' href='?page=<?php echo $total_pages;?>'><i class="fa fa-angle-double-right"></i></a>
        </li>
    </ul>
</div>
<?php } ?>