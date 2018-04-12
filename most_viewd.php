<?php
$page_title = 'Most Viewd';
$page_slug = 'Most Viewd';
$page_description = 'Most Viewd';
$page_keyword = 'Most Viewd, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$result = $db_controller->getMostViewdIdeas();
?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
           
            <div class="style_box most_popular">
                <h3 class="h3_style">List of Most Viewd Ideas
                </h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Idea</th>
                                <th scope="col">View Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            foreach ($result as $key => $value) {
                                $students = $db_controller->getStudentDetailsById($value['Student_Id']);
                            ?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td>
                                    <div class="post_img">
                                        <div class="left_side">
                                            <?php 
                                            if ($value['Anonymous_Status'] == 0) {
                                                if ($students['Image'] != '') {
                                            ?>
                                                    <img src="images/user/<?php echo $students['Image']; ?>" >
                                                <?php }else{ ?>
                                                    <img src="images/user.png">
                                                <?php } ?>

                                            <?php }else{ ?>
                                                <img src="images/user.png" >
                                            <?php } ?>
                                            <div>
                                                <?php 
                                                if ($value['Anonymous_Status'] == 0) {
                                                ?>
                                                    <h6><?php echo $students['F_Name'].' '.$students['L_Name']; ?></h6>
                                                <?php }else{ ?>
                                                    <h6>Anonymous</h6>
                                                <?php } ?>
                                                <span>
                                                <?php 
                                                echo $db_controller->wordLimit($value['Idea_Description'],40,$value['Idea_Id']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;    vertical-align: middle;">
                                    <?php echo $value['Idea_View_count']; ?>
                                </td>
                            </tr>
                            <?php $a++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3 box3">
            <?php include('template/inc-most_popular.php'); ?>

            <?php include('template/inc-most_view.php'); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="termsconditions" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php 
include('template/footer.php');
?>

