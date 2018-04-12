<?php
$page_title = 'Anonymous Idea';
$page_slug = 'Anonymous Idea';
$page_description = 'Anonymous Idea';
$page_keyword = 'Anonymous Idea, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$limit = 12;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;

/*Get total number of records */
$res_total = $db_controller->getAnonymousIdeaListCount();

$total_rows = $res_total['total_rows'];
/*Get the total number of pages.*/
$total_pages = ceil($total_rows / $limit);

if(isset($_GET['page']) && $_GET['page'] != "") {
    $page = $_GET['page'];
    $offset = $limit * ($page-1);
} else {
    $page = 1;
    $offset = 0;
}

$result = $db_controller->getAnonymousIdeaList($offset, $limit);

if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
} else {
    if(($page - $adjacents) > 1) {                 //Checking if the current page minus adjacent is greateer than one.
        if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
            $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
            $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
        } else {                                   //If current page plus adjacents is greater than total pages.
            $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
            $end   = $total_pages;                         //and the end will be the last page number that is total pages number.
        }
    } else {                                       //If the current page minus adjacent is less than one.
        $start = 1;                                //then start will be start from page number 1
        $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
    }
}


?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">Anonymous ideas
                </h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Idea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            
                            foreach ($result as $key => $value) {
                                //$students = $db_controller->getStudentDetailsById($value['Student_Id']);
                            ?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td>
                                    <div class="post_img">
                                        <a href="view_idea.php?idea=<?php echo $value['Idea_Id'] ?>" class="a_tag">
                                        <div class="left_side">
                                            
                                            <img src="images/user.png" >
                                            
                                            <div>
                                                <h6>Anonymous</h6>
                                                
                                                <span>
                                                <?php 
                                                echo $db_controller->wordLimit($value['Idea_Description'],40,$value['Idea_Id']); ?>
                                                </span>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php $a++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>


        <?php if($total_pages > 1) { ?>
        <div class="div-pagination">
            <ul class="pagination pagination-sm justify-content-center">
                <!-- Link of the first page -->
                <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
                    <a class='page-link' href='?page=1'><i class="fa fa-angle-double-left"></i></a>
                </li>
                <!-- Link of the previous page -->
                <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
                    <a class='page-link' href='?page=<?php ($page>1 ? print($page-1) : print 1)?>'><i class="fa fa-angle-left"></i></a>
                </li>
                <!-- Links of the pages with page number -->
                <?php for($i=$start; $i<=$end; $i++) { ?>
                <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
                    <a class='page-link' href='?page=<?php echo $i;?>'><?php echo $i;?></a>
                </li>
                <?php } ?>
                <!-- Link of the next page -->
                <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
                    <a class='page-link' href='?page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'><i class="fa fa-angle-right"></i></a>
                </li>
                <!-- Link of the last page -->
                <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
                    <a class='page-link' href='?page=<?php echo $total_pages;?>'><i class="fa fa-angle-double-right"></i></a>
                </li>
            </ul>
        </div>
        <?php } ?>
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

