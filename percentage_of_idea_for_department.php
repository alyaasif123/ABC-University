<?php
$page_title = 'Percentage of ideas by each Department';
$page_slug = 'Percentage of ideas by each Department';
$page_description = 'Percentage of ideas by each Department';
$page_keyword = 'Percentage of ideas by each Department, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$result = $db_controller->getNumberOfIdeaForDepartment();
$total_idea = $db_controller->getIdeaListCount();

$total_idea = $total_idea['total_rows'];
$pieData[] = array('Department', 'Number');

?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">Percentage of ideas made by each Department</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Percentage of ideas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            
                            foreach ($result as $key => $value) {
                                $pieData[] =  array($value['Name'], round(($value['count']/$total_idea)*100));
                            ?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td scope="row"><?php echo $value['Name']; ?></td>
                                <td scope="row"><?php echo round(($value['count']/$total_idea)*100); ?>%</td>
                            </tr>
                            <?php $a++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="piechart" style="width: 100%; height: 500px;"></div>

        </div>

        <div class="col-md-3 box3">
            <?php include('template/inc-most_popular.php'); ?>

            <?php include('template/inc-most_view.php'); ?>
        </div>
    </div>
</div>

<?php 
$json_table = json_encode($pieData);
include('template/footer.php');
?>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable(
            <?php  echo $json_table; ?>
            );

        var options = {
            title: "Number of ideas made by each Department"
        };

        var chart = new google.visualization.PieChart(document.getElementById("piechart"));

        chart.draw(data, options);
    }
</script>


