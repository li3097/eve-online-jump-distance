//javascript implementation of http://blog.evepanel.net/eve-online/static-data-dump/calculating-the-shortest-route-between-two-systems.html
function systemToID(system) {
    if (typeof system !== 'string') {
        throw new Error("systemToID(system): system must be a string");
    }
    var s = system.replace(' ', '').replace('-', '');
    return SS_NAME_TO_ID[s];
}
function getJumpPath(origin, target, nodes) {
    var path = [];
    var maxPath = 100;
    var maxHops = 4000;
    if (nodes === undefined) {
        nodes = JUMP_NODES_HISEC;
    }

    function checkSystemID(system) {
        if (typeof system === 'string') {
            //if a string is entered, translate to the systemID equivalent
            var id = parseInt(systemToID(system));
            if (id >0) {
                system = id;
            } else {
                throw new Error("getJumpPath(): [" + system + "] could not be matched to a systemID");
            }
        }

        if (typeof system === 'number') {
            if (nodes[system] === undefined) {
                throw new Error("getJumpPath(): [" + system + "] not found in nodes");
            } else {
                return system;
            }
        } else {
            throw new Error("getJumpPath(): [" + system + "] invalid object type");
        }
    }
    origin = checkSystemID(origin);
    target = checkSystemID(target);

    // Target and origin the same, no distance
    if (origin === target) {
        path.push(origin);
        return path;
    } else if (nodes[origin].indexOf(target)!==-1) {
        // Target is a neigbour of origin
        path.push(origin);
        path.push(target);
        return path;
    } else {
        var visited = {}, traverseQ = [];
        //Enqueues the origin node to be traversed
        traverseQ.push(origin);     

        while (traverseQ.length > 0) {
            maxHops--;//timeout at 9k jumps
            if (maxHops<1){
                            window.err=[];
                            err['visited']=visited;
                            console.log('visited:',visited);
                            throw new Error("getJumpPath(): exceeded maxjumps pathing from:"+origin+" to:"+target+".");                    
            }
            // traverse to the node at the front of the queue       
            var parent = traverseQ.shift();

            // Enqueue all connected nodes
            var children = nodes[parent];
            for (var i = 0; i < children.length; i++) {
                //check each child node until the destination is found.
                var child = children[i];
                if (child === target) {
                    // If a child node is the target, build a the shortest path
                    // back to the origin by traversing parents of visited nodes.
                    path.push(child); //Start with the child (target)
                    path.push(parent); //Add the current (parent) node.
                    //follow the chain of parent pointers until the origin is found.
                    while (visited[parent] !== origin) {
                        parent = visited[parent];
                        path.push(parent);
                        maxPath--;
                        if (maxPath < 1) {                            
                            window.err=[];
                            err['visited']=visited;
                            err['path']=path;
                            console.log('visited:',visited);
                            console.log('path:',path);
                            throw new Error("getJumpPath(): path exceeds 100 from:"+origin+" to:"+target+" path:"+path);                            
                        }
                    }
                    path.push(origin); //Add in the original origin
                    path.reverse();// flip target->origin other way around.
                    return path;
                }
                
                //store the current node in the visited object with a reference 
                //to the parent (which can be traversed later to find the 
                //shortest path to the origin once the target is found
                if (visited[child] === undefined) {
                    visited[child] = parent;
                    traverseQ.push(child); //Enqueue the child for traversal
                }
            }
        }
        //console.log(visited);
        throw new Error("getJumpPath(): no path from:"+origin+" to:"+target);  
    }
}