<?php
include 'dbinfo.php';
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

/* 
 * Database query for solar system info
 */
function systems_q($minsec=0.5){
    global $dbinfo;
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
        ss.security > {$minsec} OR ss.solarSystemName = 'A3-RQ3'");
        
    return $systems_q;
}

/*
 * Generates autocomplete data
 */
function systems_ac($minsec)
{
    $systems=array();
    $systems_q= systems_q($minsec);
    foreach ($systems_q as $row) {
        $system=new dynObject();
        $system->t=$row['system'];
        $system->s=' ('.$row['region']." <span class='s".str_replace('.', '', $row['sec'].'')."'>".$row['sec'].'</span>)';
        $system->i=$row['id'];
        $systems[]=$system;
    }
    return($systems);
}

/* 
 * Generates systemName to ID lookup table
 */
function systemsByName($minsec){       
    $systems=array();
    $systems_q=systems_q($minsec);    
    foreach ($systems_q as $row) {
        $nospace=str_replace(' ', '', $row['system'].'');
        $nodash=str_replace('-', '', $nospace.'');
        $systems[$nodash]=$row['id'];
    }
    return($systems);
}
/* 
 * Generates systemName to ID lookup table
 */
function systemsByName_json($minsec){       
    $strip1=str_replace(':"',':',json_encode(systemsByName($minsec)));
    $strip2=str_replace('",',',',$strip1);
    $strip3=str_replace('"}','}',$strip2);
    return $strip3;//check json parsing rules to make ints
}

function systemsByID($minsec){    
    $systems=new dynObject();
    $systems_q=systems_q($minsec);    
    foreach ($systems_q as $row) {
        $systems->$row['id']=new dynObject();
        $systems->$row['id']->system=$row['system'];
        $systems->$row['id']->sec=$row['sec'];
        $systems->$row['id']->region=$row['region'];
    }
    return($systems);
}