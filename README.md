# eve-online-jump-distance
A Nifty little JavaScript single page app to calculate the shortest path between Star System nodes using a breadth-first-search. It includes a PHP generator script that builds a JSON formatted adjacency map from an SQL dump of the EVE Online universe, which is client side cached to enable real time lookups.

This single page app consists of a small webpage and javascript to find the shortest amount of jumps between two star systems in the game EVE Online. Feel free to change the demo page and use your own pricing calculations.

If you wish to re-generate the star system database you should obtain a copy of the EVE online universe SQL dump, load it into a MySQL database running on the same host as the php code, and rename `/ws/dbinfo.php.txt` to `/ws/dbinfo.php` (substituting your database credentials in the process). 
Once you have done this you should navigate to `/ws/gen_evedata.js.php` and the adjacency map will be built in `/js/evedata.js`, 
