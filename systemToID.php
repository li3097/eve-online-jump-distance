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

// Assuming a mysql conversion of the Static Data Dump
// in the database evesdd
$dbConnection = new PDO("mysql:dbname={$dbinfo['database']};host={$dbinfo['host']}", $dbinfo['user'], $dbinfo['pass']);

//Load System information
$systems_q = $dbConnection->query("SELECT 
    ss.solarSystemID as id,
    ss.solarSystemName as system,
    ROUND(ss.security, 1)  as sec,
    c.constellationName as constellation,
    r.regionName as region
FROM
    evesdd_crucible_11.mapsolarsystems as ss
        JOIN
    mapconstellations as c ON ss.constellationID = c.constellationID
        JOIN
    mapregions as r ON ss.regionID = r.regionID
WHERE
    ss.security > {$minsec}");

$systems=array();


foreach ($systems_q as $row) {
    $nospace=str_replace(' ', '', $row['system'].'');
    $nodash=str_replace('-', '', $nospace.'');
    $systems[$nodash]=$row['id'];
}
echo json_encode($systems);