<?php
if(isset($_POST)) {
    $file_log	 = "request.json";
    $myfile = fopen($file_log, "w") or die("Unable to open file $file_log !");
    fwrite($myfile, json_encode($_POST));
    fclose($myfile);
}

?>