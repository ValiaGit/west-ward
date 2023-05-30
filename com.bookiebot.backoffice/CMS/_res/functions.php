<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
function readd($path) {

    $dir = scandir($path, 0); // 0 for ascending order, in PHP from 5.4 use SCANDIR_SORT_ASCENDING
    foreach ($dir as $files) {
        if ($files == '.' || $files == '..')
            continue;

        if (is_dir($path . '/' . $files)) {
            readd($path . '/' . $files);
        } else {
            $file_path = $path . '/' . $files;
            if (substr(strrchr($files, '.'), 1) == 'js') {
//                echo "<script type=\"text/javascript\" src=\"$file_path\"></script>\n";
            } else if (substr(strrchr($files, '.'), 1) == 'html') {
                echo file_get_contents($file_path) . "\n\n\n";
            }
        }
    }
}