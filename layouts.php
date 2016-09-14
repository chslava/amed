<?php
//minimal security
if (!in_array($_SERVER['REMOTE_ADDR'], ['46.109.44.8','195.244.135.220','87.110.109.53','127.0.0.1'])) {
    die('no access '.$_SERVER['REMOTE_ADDR']);
}

$theme_name ="dswp";
$current_dir = getcwd();
$host = $_SERVER['HTTP_HOST'];

$project_path =$current_dir."/wp-content/themes/".$theme_name."/html";
$project_url = str_replace($current_dir,$host, $project_path);


$files = scandir($project_path);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Layouts</title>
    <link rel="stylesheet" href="http://<?php print($project_url."/../css/style.css"); ?>">
    
</head>
<body>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper="">
            <div class="off-canvas-content" data-off-canvas-content="">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="colmns small-12">
                            <h1>HTML layouts</h1>
                            <?php foreach($files as $file): ?>
                                <?php if ($file=="." || $file==".." || is_dir($project_path."/".$file) ) continue; ?>
                                <p>
                                    <a target="_blank" href="http://<?php print($project_url."/".$file); ?>"><?php print($file); ?></a> <br/>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>



