<?php
$page_title = 'Number of ideas made by each Department';
$page_slug = 'Number of ideas made by each Department';
$page_description = 'Number of ideas made by each Department';
$page_keyword = 'Number of ideas made by each Department, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$result = $db_controller->getNumberOfIdeaForDepartment();
$pieData[] = array('Department', 'Percentage');

?>  

<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">Number of ideas made by each Department
                </h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Number of ideas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $a=1;
                            
                            foreach ($result as $key => $value) {   

                                $pieData[] =  array($value['Name'], $value['count']);
                            ?>
                            <tr>
                                <th scope="row"><?php echo $a; ?></th>
                                <td scope="row"><?php echo $value['Name']; ?></td>
                                <td scope="row"><?php echo $value['count']; ?></td>
                            </tr>
                            <?php $a++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="top_x_div" style="width:100%; height: 500px;"></div>
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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = google.visualization.arrayToDataTable(
            <?php  echo $json_table; ?>
            );
        var options = {
            title: 'Number of ideas made by each Department',
            legend: { position: 'none' },
            chart: { title: ''},
            bars: 'verticle', // Required for Material Bar Charts.
            axes: {
                x: {
            0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
            },
            bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
    };
</script>

