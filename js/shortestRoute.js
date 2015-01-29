Array.prototype._push=function(o){
    this.push(o);
    console.log(this.name+':['+this.toString()+']');
};
Array.prototype._shift=function(o){
    var ret=this.shift(o);
    console.log(this.name+':['+this.toString()+']');
};
function getShortestRoute(origin, target, nodes) {
    if (nodes==='undefined'){
        nodes=jumps;
    }
    if (typeof origin !== 'number' || typeof target !== 'number') {
        //invalid inputs
        console.log('nan');
        return false;
    }
    else if (origin === target) {
        // Target and origin the same, no distance
        console.log('o=t');
        return false;//no distance
    } else if (nodes[origin][target]) {
        // Target is a neigbour system of origin
        return 1;
    } else {
        //target more than 1 jump from origin
        //breadth-first search
        var visited=[],path=[],q=[],currNode=origin,maxI=nodes.length;
        for (var i=0;i<maxI&&currNode!==target;i++) {
            q._push(currNode);
            visited._push(currNode);
            
        }
        
    }
}
//console.log(getShortestRoute(30002187,30000142));