<?php

//Header('Content-Type: application/javascript');
readd('.');

function readd($path)
{
    if ($handle = opendir($path)) {
        while (false != ($entry = readdir($handle))) {

            if ($entry != "." && $entry != ".." & $entry != 'app.php') {

                //Get Extension
                if (substr(strrchr($entry, '.'), 1) == 'js') {
                    $file_path = ltrim(trim($path, './') . '/' . $entry, '/');
//                    echo "$file_path\n";
//                    echo file_get_contents($file_path)."\n\n\n";
                    echo "<script type=\"text-javascript\" src=\"/app/templates/default/view/_media/js/BetStock/App/$file_path\"></script>\n";
                } //read sub directory
                else {
                    readd($path . '/' . $entry);
                }
                //end read sub
            }
            //end if

        }
        //end while

    }
    //end if

}

//end readd
