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
class dynObject {
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method dynObject::{$method}()");
        }
    }
}

foreach ($systems_q as $row) {
    $system=new dynObject();
    $system->t=$row['system'];
    
    //{t:'Sarum Prime' , s:' (Domain <span class="s10">1.0</span>)'}
    $system->s=' ('.$row['region'].' <span class="s'.($row['sec']*10).'">'.$row['sec'].'</span>)';
    //echo   $system->s;
    $system->i=$row['id'];
    $systems[]=$system;
}
echo json_encode($systems);