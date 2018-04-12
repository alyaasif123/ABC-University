<?php
$page_title = 'Timeline';
$page_slug = 'add_idea';
$page_description = 'Timeline';
$page_keyword = 'Timeline, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['submit'])) {
        
    //Sanitize the POST values
    $year          = $db_controller->clean($_POST['year']);
    $title       = $db_controller->clean($_POST['title']);
    $closure_date    = $db_controller->clean($_POST['closure_date']);
    $final_closure_date = $db_controller->clean($_POST['final_closure_date']);
    $status = $db_controller->clean($_POST['status']);

    //Input Validations
    if($year == '') {
        $errmsg_arr['year'] = 'Please enter year';
        $errflag = true;
    }

    if($title == '') {
        $errmsg_arr['title'] = 'Please enter title';
        $errflag = true;
    }

    if($closure_date == '') {
        $errmsg_arr['closure_date'] = 'Please enter closure date';
        $errflag = true;
    }

    if($final_closure_date == '') {
        $errmsg_arr['final_closure_date'] = 'Please enter final closure date';
        $errflag = true;
    }

    //If there are input validations, show errors
    if($errflag == true) {
        session_write_close();
    }else{

        $insert_query = $db_controller->updateAcadamicYear($id,$year,$title,$closure_date,$final_closure_date,$status);

        $msg = "Data successfully updated";
    }
}

$acadamic_year = $db_controller->getAcadamicYearById($id);

?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <?php 
            if (count($acadamic_year)>0) {
                if (isset($msg)) {
                    echo "<div class='alert alert-success'>".$msg."</div>";
                } 
            ?>
            <div class="style_box most_popular">
                <h3 class="h3_style">Acadamic Year</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="year">Year <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="year" name="year" placeholder="Year" value="<?php echo $acadamic_year['Year'];?>">

                        <?php 
                        if (isset($errmsg_arr['year']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['year']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="title">Title <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $acadamic_year['Title'];?>">

                        <?php 
                        if (isset($errmsg_arr['title']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['title']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="closure_date">Closure Date <span class="required_star">(Required)</span></label>
                        <input type="date" class="form-control" id="closure_date" name="closure_date" placeholder="Closure Date" value="<?php echo $acadamic_year['Closure_Date'];?>">

                        <?php 
                        if (isset($errmsg_arr['closure_date']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['closure_date']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="final_closure_date">Final Closure Date <span class="required_star">(Required)</span></label>
                        <input type="date" class="form-control" id="final_closure_date" name="final_closure_date" placeholder="Final Closure Date" value="<?php echo $acadamic_year['Final_Closure_Date'];?>">

                        <?php 
                        if (isset($errmsg_arr['final_closure_date']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['final_closure_date']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="title">Status</label>
                        <select name='status' class="form-control">
                            <option value="1" <?php if ($acadamic_year['Active'] == 1) {echo 'selected';};?>>Active</option>
                            <option value="0" <?php if ($acadamic_year['Active'] == 0) {echo 'selected';};?>>Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-default" name="submit">Submit</button>
                </form>
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

