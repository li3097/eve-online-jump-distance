<?php
include 'models.php';
$evedata =generate_evedata_js();
file_put_contents('../js/evedata.js',$evedata);
echo 'Generated EVE Data in /js/evedata.js<br>'.$evedata;

