//functions used in index
function getFee(jumps) {
    return (.5 + (.5 * jumps)) + ' mill ISK';
};
function showFee() {
    var fee = getFee(document.getElementById('jumps').value);
    document.getElementById('fee').value = fee;
    document.getElementById('quote').innerHTML = ' (' + fee + ')';
};
function renderPath() {
    var origin = $('#s').val();
    var target = $('#d').val();
    console.log(origin,target);

    try {
        if ('A3-RQ3'==origin||'A3-RQ3'==target){
            var path = getJumpPath(origin, target,jump_path_all);            
        } else {            
            var path = getJumpPath(origin, target,jump_path_hisec);
        }
        //console.log(path);
        var jumps = path.length - 1;
        document.getElementById('jumps').value = jumps;
        var link = IGBrouteLink(path[0], path[path.length - 1]);
        //document.getElementById('ccproute').innerHTML= link;
        //console.log(path, link);
        showFee();
    } catch (e) {
        console.log(e.message, e.stack);
        document.getElementById('jumps').value = '';
        document.getElementById('fee').value = '';
        document.getElementById('quote').innerHTML = '';
        //document.getElementById('ccproute').innerHTML= '';
    }

};


//----------- IGB stuff

function IGBrouteLink(from, to) {
    //return '<a onClick="CCPEVE.clearAllWaypoints();setTimeout(function(){CCPEVE.showRouteTo('+"'"+from+"::"+to+"');},4000);"+'">Show Route</a>';
    return '<a onClick="CCPEVE.showRouteTo(' + "'" + from + "::" + to + "');" + '">Show Route</a>';
};

function inputFocus(i) {
    if (i.value === i.defaultValue) {
        i.value = "";
        i.style.color = "white";
    }
}
function inputBlur(i) {
    if (i.value === "") {
        i.value = i.defaultValue;
        i.style.color = "white";
    }
}
$(document).ready(function()
{
    
    //---shims
    if (typeof CCPEVE !== 'undefined') {
        CCPEVE.requestTrust('http://really.ruok.org');
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
    $("#d").autocomplete(systems_ac, systemAutocompleteOpts);
    $("#s").autocomplete(systems_ac, systemAutocompleteOpts);
    $("#details").hide();
    $("#showdetails").text("Show details");
    $("#showdetails").click(function() {
        $(this).fadeOut('fast', function() {
            $(this).text($(this).text() === 'Show details' ? 'Hide details' : 'Show details');
        });
        $('#details').animate({
            opacity: 'toggle',
            height: 'toggle'
        }, 800, function() {
            // Animation complete.
        });
        $(this).fadeIn('slow');
        // Save preference in session
        if ($(this).text() === 'Hide details')
        {
            $.ajax({url: 'ajax/prefs.php?prefs=hide'});
            return false;
        }
        if ($(this).text() === 'Show details')
        {
            $.ajax({url: 'ajax/prefs.php?prefs=show'});
            return false;
        }
    });
    $("body").delegate('#jumps', 'keyup', function() {
        showFee();
    });
    $("body").delegate('#jumps', 'change', function() {
        showFee();
    });


    $("body").delegate('#d', 'change', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#s', 'change', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#d', 'keyup', function() {
        setTimeout(renderPath, 250);
    });
    $("body").delegate('#s', 'keyup', function() {
        setTimeout(renderPath, 250);
    });

    setTimeout(renderPath, 100);
});