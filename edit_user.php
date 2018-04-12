<?php
$page_title = 'Add User';
$page_slug = 'add_user';
$page_description = 'Add User';
$page_keyword = 'Add User, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$id = '';
$type = '';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
}

if ($type == 'student') {
    $user_details = $db_controller->getStudentDetailsById($id);
}elseif($type == 'staff'){
    $user_details = $db_controller->getStaffDetailsById($id);   
}

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['submit'])) {
        
    //Sanitize the POST values
    $first_name  = $db_controller->clean($_POST['first_name']);
    $last_name  = $db_controller->clean($_POST['last_name']);
    $password    = $db_controller->clean($_POST['password']);
    $departments    = $db_controller->clean($_POST['departments']);

    //Input Validations
    if($first_name == '') {
        $errmsg_arr['first_name'] = 'Please enter first name';
        $errflag = true;
    }

    if($password == '') {
      
    }
    else{
        if(strlen($password)<6){
            $errmsg_arr['password'] = 'Please lenght must be more than 6 digits';
            $errflag = true;
        }
    }

    if (isset($user_details['User_Role_Id'])) {
        $user_role = $user_details['User_Role_Id'];
    }else{
        $user_role = 2;
    }
    

    $user_id = $_SESSION['user_details']['user_id'];

    //If there are input validations, show errors
    if($errflag == true) {
        session_write_close();
    }else{

        $file = '';
        if (isset($_FILES['file'])) {
            $file=$_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'],"images/user/".$file);
        }

        if ($user_role == 2) {
            $insert_query = $db_controller->updateStudentDetails($first_name,$last_name,$password,$departments,$file,$id);

            print_r($insert_query);
        }
        else{
            $insert_query = $db_controller->updateStaffDetails($first_name,$last_name,$password,$departments,$file,$id);
        }

        if ($insert_query != '') {
            $msg = "User successfully updated";
        }
    }
}
if ($type == 'student') {
    $user_details = $db_controller->getStudentDetailsById($id);
}elseif($type == 'staff'){
    $user_details = $db_controller->getStaffDetailsById($id);   
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
                <h3 class="h3_style">Edit user</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required_star">(Required)</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" <?php if (isset($user_details['F_Name'])) {echo 'value="'.$user_details['F_Name'].'"';} ?>>
                        <?php 
                        if (isset($errmsg_arr['first_name']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['first_name']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" <?php if (isset($user_details['L_Name'])) {echo 'value="'.$user_details['L_Name'].'"';} ?> placeholder="Last Name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <p><?php
                        echo $user_details['Email'];
                        ?></p>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="file" class="form-control" id="image">
                        <?php 
                        if (isset($user_details['Image'])) {
                            echo "<a href='images/user/".$user_details['Image']."' target='_blank'>View Image</a>";
                        } ?>
                    </div>

                    <div class="form-group">
                        <label for="user_name">User Name</label>
                        <p><?php
                        echo $user_details['User_Name'];
                        ?></p>
                    </div>

                    <div class="form-group">
                        <label for="password">Password </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Passsword">
                        <?php 
                        if (isset($errmsg_arr['password']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['password']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="user_role">User Role</label>
                        <P>
                            <?php foreach ($user_roles as $key => $value) {?>
                                <?php 
                                if (isset($user_details['User_Role_Id']) && 
                                    $user_details['User_Role_Id'] == $value['User_Role_Id']) {
                                    echo $value['Name'];
                                }elseif ($value['User_Role_Id'] == 2) {
                                    echo $value['Name'];
                                }?>
                            <?php } ?>
                            
                        </p>

                    </div>
                    <?php 
                    $department = $db_controller->getDepartment();
                    ?>
                    <div class="form-group">
                        <label for="departments">Departments <span class="required_star">(Required)</span> </label>
                        <select name='departments' class="form-control">
                            <option value="">--Select One--</option>

                            <?php foreach ($department as $key_1 => $value_1) {?>
                                <option value="<?php echo $value_1['Dep_Id']; ?>" <?php if (isset($user_details['Dep_Id']) && $user_details['Dep_Id'] == $value_1['Dep_Id']) {echo 'selected';}?>>
                                <?php echo $value_1['Name']; ?>
                                    
                                </option>
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

