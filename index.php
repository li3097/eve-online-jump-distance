<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>UPS- Courier Contracting</title>
        <link rel="stylesheet" type="text/css" href="css/eve_dark.css">
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.pack.js"></script>
        <script type="text/javascript" src="js/evedata.js"></script>
        <script type="text/javascript" src="js/jumps.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
        <style>        
            div.infobox {
                border: solid white;
                float: right;
                margin: 15px;
                padding: 15px;
            }
            div.infobox h2 {
            }
            #quote {
                font-weight: bold;
            }
        </style>       

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
                <b>Long haul available in hi-sec only</b><br>
                Jump Freighter service <b>now available to A3-RQ3!</b>
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
                    <td> <input type="text" name="s" id="s" class="text" value="Jita" tabindex="1"> <span style="font-size: 10pt;">(accepts partial solar system names)</span>
                    </td>
                </tr>
                <tr>
                    <td>Destination&nbsp;</td>
                    <td><input type="text" name="d" id="d" class="text" value="Josameto" tabindex="2"> <span id="ccproute"></span></td>
                </tr>

                <tr>
                    <td>Jumps</td>
                    <td><input type="text" name="jumps" id="jumps" class="text" onClick="clearIfRed(this);" onSelect="clearIfRed(this);" onFocus="clearIfRed(this);" tabindex="3"></td>
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
                (s) as "<b>private</b>" to <a onclick="CCPEVE.showInfo(2, 98247483);" target="_blank">Under Powered Shrubberies</a> 
            </li>
            <li>Set reward with the price<span id="quote"></span> from the quote</li>
            <li>Make sure your load is less than 900,000 m3.</li>
            <li>Collateral less than or equal to 1b isk. BE REALISTIC OR FACE REFUSAL, COLLATERAL SHOULD MATCH THE VALUE OF YOUR GOODS</li>
            <li>Set the contract to 3 days expiration with 1 days to complete (or 2 days completion for long haul)</li>
        </ol>
        <u>Note</u>: We no longer offer discounts as 10% of all contracts are paid back to RvB to benefit the members.
        <hr/>
        <h2>Useful Links</h2>
        <ul>
            <li><a href="http://rvbeve.com/forums/index.php/topic/6363-hauling-service-ups-now-available/#entry98505">RvB Forum Post<a/></li>
            <li><a onClick="CCPEVE.joinChannel('R-V-B')">RvB Recruitment - Join the forever war!<a/></li>
            <li><a onClick="CCPEVE.joinChannel('RvB Ganked')">RvB Ganked - Come and gank null-sec'ers! (no membership required)<a/></li>
        </ul>
    </body>
</html>