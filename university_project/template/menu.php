<nav class="navbar navbar-default">
    <div class="navbar-header">
        <div class=" col-md-2 hidden-lg mobile_logo "><a href="index.php"> <img src="images/logo2.png"> </a> </div>

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <div class="logo col-md-2"><a href="index.php"> <img src="images/logo2.png"> </a> </div>
        <div class="col-md-10 menu_style">
            <ul class="nav navbar-nav menuM">
                <li <?php if($page_slug == 'index'){ ?>class="active"<?php }?>><a href="index.php">Timeline</a></li>

                <?php if ($_SESSION['user_details']['user_role_id'] == 2) {?>
                    <li <?php if($page_slug == 'add_idea'){ ?>class="active"<?php }?>>
                        <a href="add_idea.php">Idea</a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['user_details']['user_role_id'] == 1) {?>
                    <li <?php if($page_slug == 'acadamic_year'){ ?>class="active"<?php }?>>
                        <a href="acadamic_year.php">Acadamic Year</a>
                    </li>

                    <li <?php if($page_slug == 'students'){ ?>class="active"<?php }?>>
                        <a href="students.php">Students</a>
                    </li>

                    <li <?php if($page_slug == 'staff'){ ?>class="active"<?php }?>>
                        <a href="staff.php">Staff</a>
                    </li>
                <?php } ?>
            </ul>

            
            <div class="logout my-2 my-lg-0">
                <span class="glyphicon glyphicon-lock"></span>
                <a href='logout.php'>Logout</a>
            </div>
        </div>
    </div><!--/.nav-collapse -->
</nav>