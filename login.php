<?php
session_start();
$page_title = 'Login';
$page_slug = 'login';
$page_description = 'Login';
$page_keyword = 'Login, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');
 
//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['login'])) {
        
    //Sanitize the POST values
    $username = $db_controller->clean($_POST['user_name']);
    $password = $db_controller->clean($_POST['password']);

    //Input Validations
    if($username == '') {
        $errmsg_arr['user_name'] = 'Please enter Username';
        $errflag = true;
    }else{
        $check_username = $db_controller->checkUsernameOrPassword('User_Name',$username);

        if ($check_username == 0) {
            $errmsg_arr['user_name'] = 'Invalid Username';
            $errflag = true;
        }
    }

    if($password == '') {
        $errmsg_arr['password'] = 'Please enter Password';
        $errflag = true;
    }else{
        $check_password = $db_controller->checkUsernameOrPassword('Password',md5($password));

        if ($check_password == 0) {
            $errmsg_arr['password'] = 'Invalid Password';
            $errflag = true;
        } 
    }

    //If there are input validations, redirect back to the login form
    if($errflag == true) {
        session_write_close();
    }else{
        $get_user_details = $db_controller->getUserDetails(md5($password),$username);
    
        $_SESSION['user_details']['user_id'] = $get_user_details['Id'];
        $_SESSION['user_details']['user_role_id'] = $get_user_details['User_Role_Id'];
        $_SESSION['user_details']['user_role'] = $get_user_details['User_role_name'];

        $_SESSION['user_details']['f_name'] = $get_user_details['F_Name'];
        $_SESSION['user_details']['l_name'] = $get_user_details['L_Name'];
        $_SESSION['user_details']['email'] = $get_user_details['Email'];
        $_SESSION['user_details']['username'] = $get_user_details['User_Name'];
        $_SESSION['user_details']['department'] = $get_user_details['Dep_Id'];
        $_SESSION['user_details']['image'] = $get_user_details['Image'];

        //$_SESSION['user_details']['user_id'] = 
        //header("Location: index.php");
        ?>
        <script>window.location.href = "<?php echo $site_url.'index.php';?>";</script>
        <?php
    }

}

?>

<div class="row-fluid login_body modal-fullscreen">
    <div class="container login_style">

        <div class="col-md-5">
            <div class="panel login_box">
                <div class="panel-heading"><h3 class="panel-title ">Sign In</h3>
                </div>
                <div class="panel-body">

                    <form method="post" action="" class="form1">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>Username</label>

                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" name="user_name"
                                        placeholder="Username">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <?php 
                                        if (isset($errmsg_arr['user_name']) && count($errmsg_arr)>0) {
                                            echo "<div class='alert alert-danger'>".$errmsg_arr['user_name']."</div>";
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Password</label>

                                    <div class="form-group has-feedback">
                                        <input type="password" class="form-control" name="password"
                                        placeholder="Password">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                    <?php 
                                        if (isset($errmsg_arr['password']) && count($errmsg_arr)>0) {
                                            echo "<div class='alert alert-danger'>".$errmsg_arr['password']."</div>";
                                        } 
                                    ?>

                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>User Type</label>

                                    <div class="form-group has-feedback">
                                        <select class="form-control" name="user_type">
                                            <option value="1" selected>Student</option>
                                            <option value="2">Staff</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div> -->

                        <div class="form-group" style="margin-top:10px;">
                            <div class="">
                                <button type="submit" name="login" class="btn btn-success btn-block btn-lg">
                                    Sign in
                                </button>
                            </div>
                        </div>
                            <!-- /.social-auth-links -->
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-7 login_box_2"> 
            <div>
                <img src="images/logo2.png">
            </div>
            <h1>Welcome to <?php echo $site_name; ?> Improvement System</h1>
            <p>Secure web-enabled role-based system for collecting ideas for improvement from students  in a ABC University.</p>
            <br>
            <div class="line1">--- <?php echo $site_name; ?> ---</div>
        </div>
    </div>
</div>


<?php 
include('template/footer.php');
?>