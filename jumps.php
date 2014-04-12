<?php
//SEE http://blog.evepanel.net/eve-online/static-data-dump/calculating-the-shortest-route-between-two-systems.html

$dbinfo=array(
    'database'=>'evesdd_crucible_11',
    'user'=>'root',
    'pass'=>'',
    'host'=>'localhost',
);
include 'dbinfo.php';

// We want to travel from Amarr
$origin = 30002187;

// To Jita
$target = 30000142;

//minimum security
$minsec=.5;

// This will hold the result of our calculation
$jumpResult = array(
    'origin' => $origin,
    'destination' => $target,
    'jumps' => 'N/A',
    'distance' => -1
);

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
echo '<br>Calculating Jumps<br>'
. "var jumps='".json_encode($jumps)."';<br>";die;
        

// Start the fun
if (isset($jumps[$origin]) && isset($jumps[$target])) {

    // Target and origin the same, no distance
    if ($target == $origin) {
        $jumpResult['jumps'] = $origin;
        $jumpResult['distance'] = 0;
    }

    // Target is a neigbour system of origin
    elseif (in_array($target, $jumps[$origin])) {
        $jumpResult['jumps'] = $origin . ',' . $target;
        $jumpResult['distance'] = 1;
    }
    
    // Lets start the fun
    else {
        // Will contain the system IDs
        $resultPath = array();
        // Already visited system
        $visitedSystems = array();
        // Limit the number of iterations
        $remainingJumps = 9000;
        // Systems we can reach from here
        $withinReach = array($origin);

        while (count($withinReach) > 0 && $remainingJumps > 0 && count($resultPath) < 1) {
            $remainingJumps--;

            // Jump to the first system within reach
            $currentSystem = array_shift($withinReach);

            // Get the IDs of the systems, connected to the current
            $links = $jumps[$currentSystem];
            $linksCount = count($links);

            // Test all connected systems
            for($i = 0; $i < $linksCount; $i++) {
                $neighborSystem = $links[$i];

                // If neighbour system is the target,
                // Build an array of ordered system IDs we need to
                // visit to get from thhe origin system to the
                // target system
                if ($neighborSystem == $target) {
                    $resultPath[] = $neighborSystem;
                    $resultPath[] = $currentSystem;
                    while ($visitedSystems[$currentSystem] != $origin) {
                        $currentSystem = $visitedSystems[$currentSystem];
                        $resultPath[] = $currentSystem;
                    }
                    $resultPath[] = $origin;
                    $resultPath = array_reverse($resultPath);
                    break;
                }

                // Otherwise, store the current - neighbour
                // Connection in the visited systems and add the
                // neighbour to the systems within reach
                else if (!isset($visitedSystems[$neighborSystem])) {
                    $visitedSystems[$neighborSystem] = $currentSystem;
                    array_push($withinReach, $neighborSystem);
                }
            }
        }

        // If the result path is filled, we have a connection
        if (count($resultPath) > 1) {
            $jumpResult['distance'] = count($resultPath) - 1;
            $jumpResult['jumps'] = implode(',', $resultPath);
        }
    }
}
var_dump($jumpResult);