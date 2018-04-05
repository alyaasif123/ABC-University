<?php
$page_title = 'Acadamic Year';
$page_slug = 'acadamic_year';
$page_description = 'Acadamic Year';
$page_keyword = 'Acadamic Year, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$acadamic_year = $db_controller->getAcadamicYear();

?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">Acadamic Year</h3>
                <div class="table-responsive">
                    <table class="table">
                        <!-- <caption>List of users</caption> -->
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Year</th>
                                <th scope="col">Title</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            foreach ($acadamic_year as $key => $value) {?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td><?php echo $value['Year']; ?></td>
                                <td><?php echo $value['Title']; ?></td>
                                <td>
                                    <?php if ($value['Active'] == 1) {
                                        echo '<label class="label label-success">Active</a>';
                                    }else{
                                        echo '<label class="label label-default">Inactive</a>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="edit_acadamic_year.php?id=<?php echo $value['Acadamic_Y_Id']; ?>" class="label label-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
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

