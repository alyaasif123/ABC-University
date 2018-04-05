<?php
$page_title = 'Add User';
$page_slug = 'add_user';
$page_description = 'Add User';
$page_keyword = 'Add User, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');


//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['submit'])) {
        
    //Sanitize the POST values
    $first_name          = $db_controller->clean($_POST['first_name']);
    $email       = $db_controller->clean($_POST['email']);
    $user_name    = $db_controller->clean($_POST['user_name']);

    //Input Validations
    if($first_name == '') {
        $errmsg_arr['first_name'] = 'Please enter first name';
        $errflag = true;
    }

    if($email == '') {
        $errmsg_arr['email'] = 'Please enter Email';
        $errflag = true;
    }

    $user_id = $_SESSION['user_details']['user_id'];

    //If there are input validations, show errors
    /*if($errflag == true) {
        session_write_close();
    }else{

        $file = '';
        if (isset($_FILES['file'])) {
            $file=$_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'],"upload/".$file);

        }

        $insert_query = $db_controller->insertIdea($topic,$description,$dispaly_name,$file,$user_id,$category,$acadamic_y_id);

        if ($insert_query != '') {
            $msg = "Idea successfully added";
        }
    }*/
}

$user_roles = $db_controller->getUserRoles();

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
                <h3 class="h3_style">Add new user</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                        <?php 
                        if (isset($errmsg_arr['first_name']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['first_name']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required_star">(Required)</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        <?php 
                        if (isset($errmsg_arr['email']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['email']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>

                    <div class="form-group">
                        <label for="user_name">User Name <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name">
                        <?php 
                        if (isset($errmsg_arr['user_name']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['user_name']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="required_star">(Required)</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Passsword">
                        <?php 
                        if (isset($errmsg_arr['password']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['password']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="user_role">User Role <span class="required_star">(Required)</span></label>
                        <select name='user_role' class="form-control">
                            <option value="">--Select One--</option>

                            <?php foreach ($user_roles as $key => $value) {?>
                                <option value="<?php echo $value['User_Role_Id']; ?>"><?php echo $value['Name']; ?></option>
                            <?php } ?>
                            
                        </select>

                        <?php 
                        if (isset($errmsg_arr['user_role']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['user_role']."</div>";
                        } 
                        ?>
                    </div>
                    <?php 
                    $department = $db_controller->getDepartment();
                    ?>
                    <div class="form-group">
                        <label for="departments">Departments <span class="required_star">(Required)</span> </label>
                        <select name='departments' class="form-control">
                            <option value="">--Select One--</option>

                            <?php foreach ($department as $key_1 => $value_1) {?>
                                <option value="<?php echo $value_1['Dep_Id']; ?>"><?php echo $value_1['Name']; ?></option>
                            <?php } ?>
                        </select>
                        <?php 
                        if (isset($errmsg_arr['departments']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['departments']."</div>";
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

