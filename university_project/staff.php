<?php
$page_title = 'Staff';
$page_slug = 'staff';
$page_description = 'Staff';
$page_keyword = 'Staff, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$staff = $db_controller->getStaffDetails();

?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">List of staff
                <a href="add_user.php" class="btn btn-default">Add New User</a>
                </h3>
                <div class="table-responsive">
                    <table class="table">
                        <!-- <caption>List of users</caption> -->
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            foreach ($staff as $key => $value) {?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td><?php echo $value['F_Name'].' '.$value['L_Name']; ?></td>
                                <td><?php echo $value['Email']; ?></td>
                                <td>
                                    <?php if ($value['Active'] == 1) {
                                        echo '<label class="label label-success">Active</a>';
                                    }else{
                                        echo '<label class="label label-default">Inactive</a>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="edit_acadamic_year.php?id=<?php echo $value['Staff_Id']; ?>" class="label label-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>&nbsp;

                                    <a href="delete_acadamic_year.php?id=<?php echo $value['Staff_Id']; ?>" class="label label-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
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

