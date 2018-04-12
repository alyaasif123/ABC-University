<?php
$page_title = 'Timeline';
$page_slug = 'add_idea';
$page_description = 'Timeline';
$page_keyword = 'Timeline, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');



$categories = $db_controller->getCatgeoryDetails();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

if (isset($_POST['submit'])) {
        
    //Sanitize the POST values
    $topic          = $db_controller->clean($_POST['topic']);
    $category       = $db_controller->clean($_POST['category']);
    $description    = $db_controller->clean($_POST['description']);

    //Input Validations
    if($category == '') {
        $errmsg_arr['category'] = 'Please select Category';
        $errflag = true;
    }

    if($description == '') {
        $errmsg_arr['description'] = 'Please enter Description';
        $errflag = true;
    }

    if (!isset($_POST['terms'])) {
        $errmsg_arr['terms'] = 'please select terms and condition. You must agree with terms and condition';
        $errflag = true;
    }

    $dispaly_name = 0;
    if (isset($_POST['dispaly_name'])) {
        $dispaly_name = 1;
    }

    $file = '';
    if (isset($_FILES['file'])) {
        $file=$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],"upload/".$file);

    }
    $user_id = $_SESSION['user_details']['user_id'];

    $department = $db_controller->getDepartmentDetailsById($_SESSION['user_details']['department']);
    $acadamic_y_id = $department['Acadamic_Y_Id'];

    //If there are input validations, show errors
    if($errflag == true) {
        session_write_close();
    }else{

        $insert_query = $db_controller->insertIdea($topic,$description,$dispaly_name,$file,$user_id,$category,$acadamic_y_id);

        if ($insert_query != '') {
            $msg = "Idea successfully added";

            $subject = 'New Idea notification';

            $headers = "From: shashikaedirisingha@gmail.com"."\r\n";
            $headers .= "Reply-To: shashikaedirisingha@gmail.com"."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $message = '<html><body>';
            $message .= '<p>New Idea Notification</p>';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Student Name:</strong> </td><td>".$_SESSION['user_details']['f_name'].' '.$_SESSION['user_details']['l_name']. "</td></tr>";
             $message .= "<tr><td><strong>Idea Title:</strong> </td><td>".$topic."</td></tr>";
            $message .= "<tr><td><strong>Idea:</strong> </td><td><a href='".$site_url."view_idea.php?idea=".$insert_query."'>View idea</a></td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";

            $qauser = $db_controller->getQACoordinatorByDepartment($_SESSION['user_details']['department']);

            foreach ($qauser as $key => $value) {
                //echo $value['Email'];
                try {
                   mail($value['Email'],$subject,$message,$headers);
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
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
            if (isset($msg)) {
                echo "<div class='alert alert-success'>".$msg."</div>";
            } 
            ?>
            <div class="style_box most_popular">
                <h3 class="h3_style">Add new idea</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="topic">Topic</label>
                        <input type="text" class="form-control" id="topic" name="topic" placeholder="Topic">
                    </div>

                    <div class="form-group">
                        <label for="category">Select Category <span class="required_star">(Required)</span></label>
                        <select class="form-control" id="category" name="category">
                            <option value="">--Select--</option>
                            <?php foreach ($categories as $key => $value) {?>
                                <option value="<?php echo $value['Category_Id']; ?>"><?php echo $value['Name']; ?></option>
                            <?php } ?>
                            
                        </select>
                        <?php 
                        if (isset($errmsg_arr['category']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['category']."</div>";
                        } 
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="required_star">(Required)</span></label>
                        <textarea class="form-control" rows="10" style="resize:none" id="description" name="description"> </textarea>
                        <?php 
                        if (isset($errmsg_arr['description']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['description']."</div>";
                        } 
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="file" class="form-control" id="file">
                    </div>

                    <div class="checkbox">
                        <label>
                          <input type="checkbox" name="dispaly_name" id="dispaly_name"> Don't show my name
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                          <input type="checkbox"  name="terms" id="terms"> Agree with <a href="#" data-toggle="modal" data-target="#termsconditions"> terms and conditions </a>
                        </label>
                        <?php 
                        if (isset($errmsg_arr['terms']) && count($errmsg_arr)>0) {
                            echo "<div class='alert alert-danger'>".$errmsg_arr['terms']."</div>";
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
        <h4 class="modal-title">Terms and conditions</h4>
      </div>
      <div class="modal-body">

 <p>By submitting an application you are not automatically guaranteed an offer of accommodation in University Halls of Residence. This is dependent upon your eligibility or the type of student you are applying as, for example a first year Undergraduate or an International Postgraduate. In addition it also depends on the date of submission of the application. You can check your eligibility here: https://www.southampton.ac.uk/uni-life/accommodation/guarantee.page</p>
 <p>Although the information provided on your application form will act as a guide in the allocation of accommodation, it may not always be possible or recommended to allocate according to your preferences. All information contained in the application will be dealt with and stored in confidence and will only be used to facilitate the allocation of accommodation. Once you have accepted an offer of accommodation, we may use the email address you provide to contact you about halls life for example: about events and opportunities in halls during the year. </p>
 <p>Upon submitting the application form for accommodation your student status will be checked against our student records system for outstanding conditions, e.g. confirmation of A-level results, degree awards etc. Offers of accommodation are dependent upon all conditions of offer to study being met by you.</p>


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

