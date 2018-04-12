<?php
$page_title = 'Add Category';
$page_slug = 'add_category';
$page_description = 'Add Category';
$page_keyword = 'Add Category, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');


//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['submit'])) {
        
    //Sanitize the POST values
    $name  = $db_controller->clean($_POST['name']);

    //Input Validations
    if($name == '') {
        $errmsg_arr['name'] = 'Please enter name';
        $errflag = true;
    }

    //If there are input validations, show errors
    if($errflag == true) {
        session_write_close();
    }else{

        $insert_query = $db_controller->insertCategoryDetails($name);

        if ($insert_query != '') {
            $msg = "Category successfully added";
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
            if (isset($msg)) {
                echo "<div class='alert alert-success'>".$msg."</div>";
            } 
            ?>
            <div class="style_box most_popular">
                <h3 class="h3_style">Add new category</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first_name">Name <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        <?php 
                        if (isset($errmsg_arr['name']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['name']."</div>";
                        } 
                        ?>
                    </div>
                    <button type="submit" class="btn btn-default" name="submit">Submit</button>
                </form>
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

