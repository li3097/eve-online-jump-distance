<?php
//SEE http://blog.evepanel.net/eve-online/static-data-dump/calculating-the-shortest-route-between-two-systems.html
header('Content-Type: application/json');
$dbinfo=array(
    'database'=>'evesdd_crucible_11',
    'user'=>'root',
    'pass'=>'',
    'host'=>'localhost',
);
include 'dbinfo.php';

//minimum security
$minsec=.5;


// Load the jumps, by fetching the SolarSystemIDs from the Static Data Dump
// Results in an array like
// $jumps = array(
//     'SystemID' => array('ID of neighbour system 1', 'ID of neighbour system 2', '...'),
//     '...'
// );

$jumps = array();

// Assuming a mysql conversion of the Static Data Dump
// in the database evesdd
$dbConnection = new PDO("mysql:dbname={$dbinfo['database']};host={$dbinfo['host']}", $dbinfo['user'], $dbinfo['pass']);
$result = $dbConnection->query("SELECT msj.fromSolarSystemID ,msj.toSolarSystemID#, s1.security as fromSec, s2.security as toSec
FROM mapsolarsystemjumps as msj
JOIN mapsolarsystems as s1 on msj.fromSolarSystemID=s1.solarSystemID
JOIN mapsolarsystems as s2 on msj.fromSolarSystemID=s2.solarSystemID

WHERE s1.security >= {$minsec}
AND s2.security >= {$minsec}");

foreach ($result as $row) {
    $from = (int) $row['fromSolarSystemID'];
    $to   = (int) $row['toSolarSystemID'];

    if (!isset($jumps[$from])) {
        $jumps[$from] = array();
    }
    $jumps[$from][] = $to;
}
//echo json_encode($jumps,JSON_NUMERIC_CHECK);
echo json_encode($jumps);//
