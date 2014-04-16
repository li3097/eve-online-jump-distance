//Global variables
isJumpFreight=false;
JFdest={"Jita":true, "Poinen":true, "Josameto":true, "Liekuri":true,"Otela":true,"Vasala":true};
JFarr=["Jita", "Poinen", "Josameto", "Liekuri","Otela","Vasala"];
//functions used in index
function showJumpFee() {
    var fee,jumps=document.getElementById('jumps').value;    
    if (jumps==0){
        fee=0;
    } else {
        fee = (jumps*.5+.5);
    }
    if (fee>0){
        document.getElementById('jumps_fee').value = fee+' mill ISK';    
    } else {
        document.getElementById('jumps_fee').value = '';
    }
    return fee;
}
function showFee(){
    var fee=showJumpFee();
    
    if (isJumpFreight){
        var cargoEl=document.getElementById('cargo');
        var cargo=cargoEl.value.replace(/\D/g,'');//strip non-numeric characters
        cargoEl.value=cargo;
        var cargoFee=parseFloat(cargo)/10;
        if (cargo>9000){
            document.getElementById('cargo_fee').value = 'Cargo over 9,000 Km3';             
            document.getElementById('cargo_fee').style.color = 'yellow';
            fee=0;            
        }
        else if (cargo>.1) {
            cargoFee=Math.ceil(2*cargoFee)/2;
            document.getElementById('cargo_fee').value = cargoFee+' mill ISK';          
            document.getElementById('cargo_fee').style.color = 'white';
            fee+=cargoFee;
        } else {
            document.getElementById('cargo_fee').value = 'Cargo must be a number';             
            document.getElementById('cargo_fee').style.color = 'red';
            fee=0;
        }
    }
    
    if (fee>0){
        fee +=' mill ISK'; 
        document.getElementById('fee').value = fee;
        document.getElementById('quote').innerHTML = ' ( ' + fee + ' )';        
    } else {
        document.getElementById('fee').value = '';
        document.getElementById('quote').innerHTML = '';        
    }
     
};
function renderPath() {
    var origin = $('#s').val();
    var target = $('#d').val();
    //console.log(origin,target);
    
    //calculate jumps to intermediate system
    
    if ('A3-RQ3'===origin){
        //flip a3 to destination
        origin=target;
        target='A3-RQ3';         
    } 
    
    
    $('#dest_err').html('');
    isJumpFreight=false;  
    $(".nullsec").hide();   
    
    try {
        
    
        if ('A3-RQ3'===target) {        
            target='Vasala';
            if (JFdest[origin]){
                isJumpFreight=true;        
                $(".nullsec").show();            
            } else {                        
                throw Error('JF_DEST');
            }
        }
        
        var path = getJumpPath(origin, target,JUMP_NODES_HISEC);
        //console.log(path);
        var jumps = path.length - 1;
        document.getElementById('jumps').value = jumps;
        document.getElementById('jumps').style.color = 'white';
        var link = IGBrouteLink(path[0], path[path.length - 1]);
        //document.getElementById('ccproute').innerHTML= link;
        //console.log(path, link);        
        showFee();
    } catch (e) {
        document.getElementById('jumps').value = '';
        document.getElementById('jumps_fee').value = '';
        document.getElementById('fee').value = '';
        document.getElementById('quote').value = '';
        if (e.message=='JF_DEST'){            
                $('#dest_err').html('JF service only available between '+JFarr+' and A3-RQ3.');
        } else {
            console.log(e.message, e.stack, e);        
            document.getElementById('jumps').value = 'No path through Hi-sec';
            document.getElementById('jumps').style.color = 'red';
        }
    }
};


//----------- IGB stuff

function IGBrouteLink(from, to) {
    //return '<a onClick="CCPEVE.clearAllWaypoints();setTimeout(function(){CCPEVE.showRouteTo('+"'"+from+"::"+to+"');},4000);"+'">Show Route</a>';
    return '<a onClick="CCPEVE.showRouteTo(' + "'" + from + "::" + to + "');" + '">Show Route</a>';
};

function wipeDefaultFocus(i) {
    if (i.value === i.defaultValue) {
        i.value = "";
        i.style.color = "white";
    } 
}
function restoreDefaultBlur(i) {
    if (i.value === "") {
        i.value = i.defaultValue;
        i.style.color = "grey";
    }
}
function clearIfRed(i) {
    if (i.style.color === 'red') {
        i.value = "";
        i.style.color = "white";
    } 
}
$(document).ready(function()
{
    
    //---shims
    if (typeof CCPEVE !== 'undefined') {
        CCPEVE.requestTrust('http://ups.leet.la');
        isIGB = true;
    } else {
        isIGB = false;
        CCPEVE = {
            showInfo: function() {
                var win = window.open('http://rvbeve.com/forums/index.php/topic/6363-hauling-service-ups-now-available/#entry98505', '_blank');
                win.focus();
            },
            joinChannel: function() {
                alert('please use in game browser to join channel');
            },
            createContract: function() {
                alert('please use in game browser to create contract');
            },
            showRouteTo: function() {
                alert('please use in game browser to show routes');
            },
            clearAllWaypoints: function() {
                alert('please use in game browser to show routes');
            }
        };
    }
    var systemAutocompleteOpts = {
        width: 300,
        formatItem: function(item)
        {
            return item.t + item.s;
        },
        formatResult: function(item)
        {
            return item.t;
        }
    };
    $("#d").autocomplete(SS_AC, systemAutocompleteOpts);
    $("#s").autocomplete(SS_AC, systemAutocompleteOpts);
    
    
    $("body").delegate('#s', 'keyup', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#s', 'change', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#d', 'change', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#d', 'keyup', function() {
        setTimeout(renderPath, 250);
    });
    
    
    $("body").delegate('#jumps', 'keyup', function() {
        showFee();
        $('#d').val('');
    });
    $("body").delegate('#jumps', 'change', function() {
        showFee();
        $('#d').val('');
    });
    
    $("body").delegate('#cargo', 'keyup', function() {
        showFee();
    });
    $("body").delegate('#cargo', 'change', function() {
        showFee();
    });

    setTimeout(renderPath, 100);
});