<?php
$page_title = 'Download Zip';
$page_slug = 'Download_Zip';
$page_description = 'Download Zip';
$page_keyword = 'Download Zip, University';
$site_name = "ABC University";
$project_name = $site_name.' | ';

include('template/header.php');

$result = $db_controller->getIdeaListView();

//print_r($result);

/*if(isset($_POST['download_zip'])){
    if (extension_loaded('zip')) {
        if(count($result)>0){          
            $file_path=$_SERVER["DOCUMENT_ROOT"]."/university_project/upload/";//This should be absolute path of the upload folder where all the images are stored
            $zip = new ZipArchive(); //Call the ZIP constructor
            $zip_file_name=time().".zip"; //create zip filename with current datetime
            if($zip->open($zip_file_name,ZipArchive::CREATE)===true){                
                foreach ($result as $key => $value) {
                    if(file_exists($file_path.$value["Idea_Description"])){
                        $zip->addFile($file_path.stripslashes($value["Idea_Description"]),stripslashes($value["Idea_Description"]));                     
                    }
                }                   
            }else{
                die("There is some error while creating the zip file.");
            }
             
            $zip->close();//close
            if(file_exists($zip_file_name)){            
                //download the zip file
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="'.$zip_file_name.'"');
                readfile($zip_file_name);
                //After download the zip file which is created deleted it
                unlink($zip_file_name);
            }
 
        }
    }else{
        die("Zip extension is not loaded.");    
    }
}*/
if(isset($_POST['download_zip'])){

    $fp = fopen('php://output', 'w'); 
    ob_end_clean(); 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="data_file.csv"'); 
    header('Pragma: no-cache'); 
    header('Expires: 0'); 

    fputcsv($fp, array('ID', 'Topic', 'Description', 'Anonymous (1 = Yes)', 'Date','File','View count','Student','Category')); 

    foreach ($result as $key => $value) {
          fputcsv($fp, $value);
    }

    ob_get_clean();
    fclose($fp);
    die; 
}


?>
<div class="row-fluid home_page">
    <div class="">
        <div class="col-md-3 box1">
            <?php include('template/inc-profile.php'); ?>
        </div>

        <div class="col-md-6 box2">
            <div class="style_box most_popular">
                <h3 class="h3_style">Download Ideas
                </h3>
                <form action="" method="post">
                <div class="table-responsive">
                    <button class="btn btn-default" type="submit" name="download_zip">Download List</button>
                </div>
                </form>
            </div>
        </div>

        <div class="col-md-3 box3">
            <?php include('template/inc-most_popular.php'); ?>

            <?php include('template/inc-most_view.php'); ?>
        </div>
    </div>
</div>


<?php 
include('template/footer.php');
?>

