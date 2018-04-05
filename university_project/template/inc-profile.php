
<div class="profile_header">
    <div class="profile_img">
        <?PHP if ($_SESSION['user_details']['image'] != '') {?>
            <img src="images/user/<?php echo $_SESSION['user_details']['image']; ?>" class="img-circle">
        <?php }else{ ?>
            <img src="images/user.png" class="img-circle">
        <?php } ?>
        
    </div>
</div>
<div class="style_box">
    <h5><?php echo $_SESSION['user_details']['f_name'].' '.$_SESSION['user_details']['l_name']; ?></h5>

    <div class="profile_body">

        <div class="row">
            <div class="col-md-4">User Role</div>
            <div class="col-md-8"><?php echo $_SESSION['user_details']['user_role']; ?></div>
        </div>

        <div class="row">
            <div class="col-md-4">User name</div>
            <div class="col-md-8"><?php echo $_SESSION['user_details']['username']; ?></div>
        </div>

        <div class="row">
            <div class="col-md-4">Email</div>
            <div class="col-md-8"><?php echo $_SESSION['user_details']['email']; ?></div>
        </div>

        <div class="row">
            <div class="col-md-4">Department</div>
            <div class="col-md-8">
            <?php 
            $department = $db_controller->getDepartmentDetailsById($_SESSION['user_details']['department']);
            echo $department['Name'];
            ?>
                
            </div>
        </div>
        
    </div>
</div>