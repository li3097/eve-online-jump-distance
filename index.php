<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Under Powered Shrubberies</title>
        <style>

            body
            {
                font-family: Arial Narrow, Arial, Helvetica;
                background-color: black;
                background-repeat:no-repeat;
                background-position: center top;
                color: #DDD;
                /*font-size: 120%;*/
            }
            a, a:link, a:visited
            {
                color: orange;
            }
            form
            {
                margin: 0;
            }
            input.text, textarea.text, select.text
            {
                background-color: #333;
                color: #DDD;
                border: solid 1px #DDD;
            }
            input.button
            {
                background-color: #333;
                color: #FFF;
                border: 2px solid #999;
            }
            .contracthistory td, .contracthistory th
            {
                padding: 0 8px;
                margin: 0;
                vertical-align: bottom;
                border-bottom: solid 1px #666;
            }
            .contracthistory tr.rush
            {
                background-color: #3E0058;
            }
            .contracthistory tr.rush td
            {
                border-top: solid 2px #8715B6;
                border-bottom: solid 2px #8715B6;
            }
            .mediumtable td, .contracthistory th
            {
                font-size: 90% !important;
            }

            .ac_results {
                padding: 0px;
                border: 1px solid black;
                background-color: white;
                overflow: hidden;
                z-index: 99999;
                width: 200px;
            }

            .ac_results ul {
                list-style-position: outside;
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .ac_results li {
                margin: 0px;
                padding: 2px 5px;
                cursor: default;
                display: block;
                line-height: 16px;
                overflow: hidden;
                background-color: #333;
                font-size: 0.8em;
            }
            .ac_loading {
                background: white url('../img/indicator.gif') right center no-repeat;
            }
            .ac_odd {
                /* none */
            }
            .ac_over {
                background-color: #555 !important;
                color: white;
            }
            #nav 
            {
                border: solid 1px #777;
                padding: 4px;
                width: 140px; 
                margin-right: 10px;
                float: left; 
                margin-top: 20px;
            }
            #nav ul
            {
                margin-top: 5px;
                margin-bottom: 5px;
                margin-left: 20px;
                padding-left: 0px;
            }
            #nav ul li
            {
                margin-left: 0px;
                padding-left: 0px;
            }
            .routeDot
            {
                width: 5px; 
                height: 5px;
                margin-left: 2px;
                display: inline;
                float: left;
                font-size: 1pt;
            }
            .s10 {
                color: #2FEFEF;
            }
            .s09 {
                color: #47EFBF;
            }
            .s08 {
                color: #00F048;
            }
            .s07 {
                color: #00EF00;
            }
            .s06 {
                color: #90F030;
            }
            .s05 {
                color: #F0F000;
            }
            .s04 {
                color: red;
            }
            .s03 {
                color: red;
            }
            .s02 {
                color: red;
            }
            .s01 {
                color: red;
            }
            .s00 {
                color: red;
            }
            .error
            {
                color: #DD0000;
                font-weight: bold;
            }
            .medical li
            {
                list-style-image: url(/img/medical_32.png);
            }
            .dot
            {
                background-color: #F0F000; 
                color: black; 
                font-size: 9pt;
                width: 15px;
                text-align: center;
                margin-left: 3px;
                display: inline-block;
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
            }
            .n
            {
                background-color: #F0F000; 
            }
            .u
            {
                background-color: #E4C210; 
            }
            .p
            {
                background-color: #D1B310; 
            }
            div.box
            {
                border: solid 1px #999;
                padding: 5px 15px;
                -webkit-border-radius: 15px;
                -moz-border-radius: 15px;
                border-radius: 15px;
            }
            span.addwaypoint
            {
                background-color: #A0A000;
                margin-left: 5px;
            }
            span.addwaypoint a
            {
                color: black !important;
            }
        </style>
        <style>
            div.infobox {
                border: solid white;
                float: right;
                margin: 15px;
                padding: 15px;
            }
            div.infobox h2 {
            }
        </style>
        <script type="text/javascript">
            
            <?php include 'jq.js' ?>
            <?php include 'jumps.js' ?>
                
            getFee = function(jumps) {
                return (.5 + (.5 * jumps)) + ' mill ISK';
            };
            showFee = function() {
                var fee = getFee(document.getElementById('jumps').value);
                document.getElementById('fee').value = fee;
                document.getElementById('quote').innerHTML = ' (' + fee + ')';
            };
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
                    }
                };
            }
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
                $("#d").autocomplete(systems,
                        {
                            width: 300,
                            formatItem: function(item)
                            {
                                return item.t + item.s;
                            },
                            formatResult: function(item)
                            {
                                return item.t;
                            }
                        });
                $("#s").autocomplete(systems,
                        {
                            width: 300,
                            formatItem: function(item)
                            {
                                return item.t + item.s;
                            },
                            formatResult: function(item)
                            {
                                return item.t;
                            }
                        });
                $("#details").hide();
                $("#showdetails").text("Show details");
                $("#showdetails").click(function() {
                    $(this).fadeOut('fast', function() {
                        $(this).text($(this).text() == 'Show details' ? 'Hide details' : 'Show details');
                    });
                    $('#details').animate({
                        opacity: 'toggle',
                        height: 'toggle'
                    }, 800, function() {
                        // Animation complete.
                    });
                    $(this).fadeIn('slow');
                    // Save preference in session
                    if ($(this).text() == 'Hide details')
                    {
                        $.ajax({url: 'ajax/prefs.php?prefs=hide'});
                        return false;
                    }
                    if ($(this).text() == 'Show details')
                    {
                        $.ajax({url: 'ajax/prefs.php?prefs=show'});
                        return false;
                    }
                });
                $("body").delegate('#jumps','keyup',function(){
                    showFee();
                });
                $("body").delegate('#jumps','change',function(){
                    showFee();
                });
                
            });

        </script>
    </head>
    <body>

        <div class="infobox">
            <h2>Pricing</h2>
            <p>500k + 500k per jump.
            <ul>
                <li>Jita - Liekuri: <i>2 mill isk</i></li>
                <li>Jita - Otela: <i>2 mill isk</i></li>
                <li>Jita - Josameto: <i>1.5 mill isk</i></li>
                <li>Jita - Poinen: <i>2 mill isk</i></li>
            </ul>
            <b>*Long haul available in hi-sec only</b><br>
            *JF service available to A3-RQ3
            <h2>Size limitations</h2>
            Loads are accepted up to 900,000 m3.<br/>
            For loads up to 100,000 Please break
            into 2x50,000 <br/> for faster delivery
        </p>
    </div>

    <h1>Welcome to <a onclick="CCPEVE.showInfo(2, 98247483);" target="_blank">Under Powered Shrubberies</a></h1>
    <p>
        <a onClick="CCPEVE.joinChannel('UPS Agents')">Click to join us in channel <strong>UPS Agents</a></strong> if you have any questions
</p>

<hr/>
<form>
    <table style="margin-left: 20px;">
        <tr>
        <td>Start System&nbsp;</td>
        <td> <input type="text" name="s" id="s" class="text" value="Aldrat" tabindex="1"> <span style="font-size: 10pt;">(accepts partial solar system names)</span>
        </td>
        </tr>
        <tr>
        <td>Destination&nbsp;</td>
        <td><input type="text" name="d" id="d" class="text" value="Jita" tabindex="2"></td>
        </tr>
        
        
        <tr>
            <td>Jumps</td>
            <td><input type="text" name="jumps" id="jumps" class="text" style="color:#888;" 
                       value="-Enter number of Jumps-" onfocus="inputFocus(this)" onblur="inputBlur(this)" tabindex="1"></td>
        </tr>
        <tr>
            <td>Fee</td>
            <td><input style="color:white" type="text" id="fee" class="text" value="" disabled></td>
        </tr>
    </table>
</form>
<hr/>
<h2>How to use UPS</h2>
<ol>
    <li>Use the calculator to get the quote</li>
    <li>Assign the <a onClick="CCPEVE.createContract(3);">courier contract</a>
        (s) as "private" to <a onclick="CCPEVE.showInfo(2, 98247483);" target="_blank">Under Powered Shrubberies</a> 
    </li>
    <li>Set reward with the price<span id="quote"></span> from the quote</li>
    <li>Make sure your load is less than 900,000 m3.</li>
    <li>Collateral less than or equal to 1b isk. BE REALISTIC OR FACE REFUSAL, COLLATERAL SHOULD MATCH THE VALUE OF YOUR GOODS</li>
    <li>Set the contract to 3 days expiration with 1 days to complete (or 2 days completion for long haul)</li>
</ol>
<u>Note</u> : We no longer offer discounts as 10% of all contracts are paid back to RvB to benefit the members.
<hr/>
<h2>Useful Links</h2>
<ul>
    <li><a href="http://rvbeve.com/forums/index.php/topic/6363-hauling-service-ups-now-available/#entry98505">RvB Forum Post<a/></li>
</ul>
</body>
</html>