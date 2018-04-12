<?php
$page_title = 'Category';
$page_slug = 'category';
$page_description = 'Category';
$page_keyword = 'Category, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$categories = $db_controller->getCatgeoryDetails();


?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <?php
            if (isset($_GET['msg']) && $_GET['msg'] = 1) {
                echo "<div class='alert alert-danger'>You can not delete this category</div>";
            }
            ?>
            <div class="style_box most_popular">
                <h3 class="h3_style">List of Categories
                <a href="add_category.php" class="btn btn-default">Add New Category</a>
                </h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            foreach ($categories as $key => $value) {?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td><?php echo $value['Name']; ?></td>
                                <td style="text-align:center">
                                    <a href="edit_category.php?id=<?php echo $value['Category_Id']; ?>" class="btn label-warning action_icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>&nbsp;

                                    <a href="delete_category.php?id=<?php echo $value['Category_Id']; ?>" class="btn label-danger action_icon" data-toggle="tooltip" data-placement="top" title="Delete">
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

