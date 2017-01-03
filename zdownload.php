<?php

include('LinkHeader.php');
$local_files = explode($l_filehomepath.'/',$_GET['file']);
$arr_files=explode('/',$local_files[1]);
$count=count($arr_files)-1;
 $local_file =ltrim($local_files[1]);
 $download_file=$arr_files[$count];
//$download_file = $local_files[1];
// set the download rate limit (=> 20,5 kb/s)
$download_rate = 1000;
if(file_exists($local_file) && is_file($local_file))
{
    header('Cache-control: private');
    header('Content-Type: application/octet-stream');
    header('Content-Length: '.filesize($local_file));
    header('Content-Disposition: filename='.$download_file);

    flush();
    $file = fopen($local_file, "r");
    while(!feof($file))
    {
        // send the current file part to the browser
        print fread($file, round($download_rate * 1024));
        // flush the content to the browser
        flush();
        // sleep one second
        sleep(1);
    }
    fclose($file);}
else {
    die('Error: The file '.$local_file.' does not exist!');
}
?>