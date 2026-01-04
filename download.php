<?php

 /* Template Name: Download */


$file = $_GET['file'];



header('Content-Description: File Transfer');

header('Content-Type: application/octet-stream');

header('Content-Disposition: attachment; filename='.basename($file));

header('Content-Transfer-Encoding: binary');

header('Expires: 0');

header('Cache-Control: public'); //for i.e.

header('Pragma: public');



ob_clean();

flush();

readfile($file);

exit;

?>