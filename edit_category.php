<?php
$page_title = 'Edit Category';
$page_slug = 'edit_category';
$page_description = 'Edit Category';
$page_keyword = 'Edit Category, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$category_details = $db_controller->getCategoryById($id);

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

        $insert_query = $db_controller->updateCategoryDetails($name,$id);

        if ($insert_query != '') {
            $msg = "Category successfully updated";
        }
    }
}
$category_details = $db_controller->getCategoryById($id);

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
                <h3 class="h3_style">Edit Category</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" <?php if (isset($category_details['Name'])) {echo 'value="'.$category_details['Name'].'"';} ?>>
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

<?php 
include('template/footer.php');
?>

