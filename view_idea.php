<?php
error_reporting(0);
$page_title = 'View Idea';
$page_slug = 'view';
$page_description = 'View Idea';
$page_keyword = 'View Idea';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');
$idea_id = 0;
if (isset($_GET['idea'])) {
    $idea_id = $_GET['idea'];
}

$value = $db_controller->getIdeaById($idea_id);

if (isset($_POST['comment'])) {
    $comment = $db_controller->clean($_POST['comment']);
    $anonymous_status = 0;

    if (isset($_POST['dispaly_name'])) {
        $anonymous_status = 1;
    }

    if ($comment != '') {
        $db_controller->saveComment($_SESSION['user_details']['user_id'],$value['Idea_Id'],$_SESSION['user_details']['user_role_id'],$comment,$anonymous_status);

        if ($anonymous_status == 1) {
            $st_name = 'Anonymous';
        }else{
            $st_name = $_SESSION['user_details']['f_name'].' '.$_SESSION['user_details']['l_name'];
        }

        $subject = 'New Comment notification';

        $headers = "From: shashikaedirisingha@gmail.com"."\r\n";
        $headers .= "Reply-To: shashikaedirisingha@gmail.com"."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';
        $message .= '<p>You have a new Comment Notification</p>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>From:</strong> </td><td>".$st_name. "</td></tr>";
        $message .= "<tr><td><strong>Comment:</strong> </td><td>".$comment."</td></tr>";
        $message .= "<tr><td><strong>Idea:</strong> </td><td><a href='".$site_url."view_idea.php?idea=".$idea_id."'>View idea</a></td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

        $students = $db_controller->getStudentDetailsById($value['Student_Id']);
        if ($_SESSION['user_details']['user_role_id'] == 2) {
            try {
                mail($students['Email'],$subject,$message,$headers);
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        

    }
}

?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
        <?php 
        if(!empty($value)){ 
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
            $comments = $db_controller->getCommentsById($value['Idea_Id']);
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

                    <!--<div class="dropdown right_side">
                        <span class="glyphicon glyphicon-option-horizontal "  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span> 
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>-->
                </div>

                <div class="post_content">
                    <h5><strong><?php echo $value['Idea_Topic']; ?></strong></h5>
                    <p><?php echo $value['Idea_Description']; ?></p>
                    <?php if ($value['Upload_File'] != '') {?>
                        <p><a href='upload/<?php echo $value['Upload_File']; ?>' target="_blank">View File</a></p>
                    <?php } ?>
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
                    <?php 
                    if ($final_closure_date > date('Y-m-d')) {
                    ?>
                        <span class="comment_link"><a href="#" data-toggle="modal" data-target="#add_comment">Add comment</a></span>

                    <?php } ?>
                    </div>

                </div>

                <?php if (count($comments)>0) {?>
                <div class="post_bottom">

                    <?php 
                    foreach ($comments as $key_comment => $value_comment) {

                        $image_comment = '';
                        $name_comment = '';

                        if ($value_comment['Student_Id'] != '' && $value_comment['Student_Id'] != 0) {
                            $students = $db_controller->getStudentDetailsById($value_comment['Student_Id']);
                            $image_comment = $students['Image'];
                            $name_comment = $students['F_Name'].' '.$students['L_Name'];
                        }
                        else{
                            $staff = $db_controller->getStaffDetailsById($value_comment['Staff_Id']);
                            $image_comment = $staff['Image'];
                            $name_comment = $staff['F_Name'].' '.$staff['L_Name'];
                        }
                        
                    if ($value_comment['Staff_Id'] == '' && $_SESSION['user_details']['user_role_id'] == 2) { 
                    ?>
                    
                        <div class="comments_style">
                            <?php 
                            if ($value_comment['Anonymous_Status'] == 0) {
                                if ($image_comment != '') {
                                    ?>
                                    <img src="images/user/<?php echo $image_comment; ?>" class="img-circle">
                                <?php }else{ ?>
                                    <img src="images/user.png" class="img-circle">
                                <?php } ?>

                            <?php }else{ ?>
                                <img src="images/user.png" class="img-circle">
                            <?php } ?>

                            <div class="comment_content">
                                <?php 
                                if ($value_comment['Anonymous_Status'] == 0) {
                                ?>
                                    <b><?php echo $name_comment; ?></b>
                                <?php }else{ ?>
                                    <b>Anonymous</b>
                                <?php } ?>

                                <p><?php echo $value_comment['Comment_Description']; ?></p>
                            </div>
                        </div>
                    <?php }else{ 
                        if ($_SESSION['user_details']['user_role_id'] != 2) {
                    ?>
                        <div class="comments_style">
                            <?php 
                            if ($value_comment['Anonymous_Status'] == 0) {
                                if ($image_comment != '') {
                                    ?>
                                    <img src="images/user/<?php echo $image_comment; ?>" class="img-circle">
                                <?php }else{ ?>
                                    <img src="images/user.png" class="img-circle">
                                <?php } ?>

                            <?php }else{ ?>
                                <img src="images/user.png" class="img-circle">
                            <?php } ?>

                            <div class="comment_content">
                                <?php 
                                if ($value_comment['Anonymous_Status'] == 0) {
                                ?>
                                    <b><?php echo $name_comment; ?></b>
                                <?php }else{ ?>
                                    <b>Anonymous</b>
                                <?php } 
                                if ($value_comment['Student_Id'] == '' && $value_comment['Student_Id'] == 0) {
                                ?>
                                <span class="required_star">(Staff)</span>
                                <?php } ?>

                                <p><?php echo $value_comment['Comment_Description']; ?></p>
                            </div>
                        </div>
                    <?php } } ?>

                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
        </div>

        <div class="col-md-3 box3">
            <?php include('template/inc-most_popular.php'); ?>

            <?php include('template/inc-most_view.php'); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="add_comment" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add comment</h4>
      </div>
      <form method="POST" enctype="multipart/form-data"> 
      <div class="modal-body">
        <div class="form-group">
            <label for="description">Add your comment here </label>
            <textarea class="form-control" rows="10" style="resize:none" id="comment" name="comment"> </textarea>
        </div>

        <div class="checkbox">
            <label>
              <input type="checkbox" name="dispaly_name" id="dispaly_name"> Don't show my name
            </label>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="submit">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

<?php 
include('template/footer.php');
?>

