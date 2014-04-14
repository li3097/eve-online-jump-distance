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
function db_systems($minsec=null){
    global $dbinfo;
    $dbConnection = new PDO("mysql:dbname={$dbinfo['database']};host={$dbinfo['host']}", $dbinfo['user'], $dbinfo['pass']);
    $sql="SELECT ss.solarSystemID-30000000 as id, ss.solarSystemName as system, ROUND(ss.security,1) as sec,c.constellationName as constellation, r.regionName as region
    FROM evesdd_crucible_11.mapsolarsystems as ss
    JOIN mapconstellations as c ON ss.constellationID = c.constellationID
    JOIN mapregions as r ON ss.regionID = r.regionID";    
    if (!is_null($minsec)){
        $sql.=" WHERE ss.security >= {$minsec} OR ss.solarSystemName = 'A3-RQ3'";
    }        
    return $dbConnection->query($sql);
}
/*
 * Database query for jumps
 */
function db_jumps($minsec=null){
    global $dbinfo;
    $dbConnection = new PDO("mysql:dbname={$dbinfo['database']};host={$dbinfo['host']}", $dbinfo['user'], $dbinfo['pass']);
    $sql="SELECT msj.fromSolarSystemID-30000000 as fromSolarSystemID, msj.toSolarSystemID-30000000 as toSolarSystemID #, s1.security as fromSec, s2.security as toSec
    FROM mapsolarsystemjumps as msj
    JOIN mapsolarsystems as s1 on msj.fromSolarSystemID=s1.solarSystemID
    JOIN mapsolarsystems as s2 on msj.toSolarSystemID=s2.solarSystemID";    
    if (!is_null($minsec)){
        $sql.=" WHERE s1.security >= ".(float)$minsec." AND s2.security >= ".(float)$minsec;
    }
    return $dbConnection->query($sql);
}
function jump_nodes($minsec){
    $result=db_jumps($minsec);
    $jumps=array();
    foreach ($result as $row) {
        $from = (int) $row['fromSolarSystemID'];
        $to   = (int) $row['toSolarSystemID'];
        if (!isset($jumps[$from])) {
            $jumps[$from] = array();
        }
        $jumps[$from][] = $to;
    }
    return $jumps;
}
/*
 * Generates autocomplete data
 */
function systems_ac($minsec)
{
    $systems=array();
    $db_systems= db_systems($minsec);
    foreach ($db_systems as $row) {
        $system=new dynObject();
        $system->t=$row['system'];
        $row['sec']=round($row['sec'],1);
        if ($row['sec']==1){
            $row['sec']='1.0';
        }
        $system->s=' ('.$row['region']." <span class='s".str_replace('.', '', $row['sec'].'')."'>".$row['sec'].'</span>)';
        $system->i=$row['id'];
        $systems[]=$system;
    }
    return($systems);
}

/* 
 * Generates systemName to ID lookup table
 */
function systems_by_name($minsec){       
    $systems=array();
    $db_systems=db_systems($minsec);    
    foreach ($db_systems as $row) {
        $nospace=str_replace(' ', '', $row['system'].'');
        $nodash=str_replace('-', '', $nospace.'');
        $systems[$nodash]=$row['id'];
    }
    return($systems);
}
/* 
 * Generates systemName to ID lookup table
 */
function systems_by_name_json($minsec){       
    $strip1=str_replace(':"',':',json_encode(systems_by_name($minsec)));
    $strip2=str_replace('",',',',$strip1);
    $strip3=str_replace('"}','}',$strip2);
    return $strip3;//check json parsing rules to make ints
}

/*
 * Create array of system info
 */
function systems_by_id($minsec){    
    $systems=new dynObject();
    $db_systems=db_systems($minsec);    
    foreach ($db_systems as $row) {
        $systems->$row['id']=new dynObject();
        $systems->$row['id']->system=$row['system'];
        $systems->$row['id']->sec=$row['sec'];
        $systems->$row['id']->region=$row['region'];
    }
    return($systems);
}

function generate_evedata_js(){
    $minsec=0.45;
    return 'var SS_ID_INFO='.json_encode(systems_by_id($minsec))
        .';var SS_AC='.str_replace('<\/span>','</span>',json_encode(systems_ac($minsec)))
        .';var SS_NAME_TO_ID='.systems_by_name_json($minsec)
        .';var JUMP_NODES_ALL='.str_replace('"','',json_encode(jump_nodes(null)))
        .';var JUMP_NODES_HISEC='.str_replace('"','',json_encode(jump_nodes($minsec)));
}
