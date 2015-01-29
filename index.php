<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>UPS- Courier Contracting</title>
        <link rel="stylesheet" type="text/css" href="css/eve_dark.css">
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.pack.js"></script>
        <script type="text/javascript" src="js/evedata.js"></script>
        <script type="text/javascript" src="js/jumps.js"></script>
        <script type="text/javascript" src="js/index.js"></script>

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
                <h2>Size limitations</h2>                
                <ul>
                    <li>Loads are accepted up to 900,000&nbsp;m3.</li>
                    <li>For loads up to 100,000&nbsp;m3 please break into 2&nbsp;x&nbsp;50,000&nbsp;m3 for faster delivery.</li>
                </ul>
                
                <h2>Jump Freighter service to A3-RQ3</h2>         
                <ul>
                    <li>Max JF load is 324,000 m3 per contract.</li>
                    <li>Cost is 125 ISK / m3</li>
                    <li>JF contracts must be between Vasala IV - Nurtura Food Packaging and A3-RQ3</li>
                    <li>JF Contracts should be made with 3 days expiration and 3 days completion (ie. courier contract default value).</li>
                    <li>No assembled containers in the contracts, please</li>

                </ul>
            </p>
        </div>

        <h1>Welcome to <a onclick="CCPEVE.showInfo(2, 98247483);" target="_blank">Under Powered Shrubberies</a></h1>
        <p>-== We <3 Hauling ==- <a onClick="CCPEVE.joinChannel('UPS Agents')">Click to join us in channel <strong>[UPS Agents]</a></strong> if you have any questions
        </p>

        <hr/>
        <form>
            <table style="margin-left: 20px;">
                <tr>
                    <td>Package Location&nbsp;</td>
                    <td> <input type="text" name="s" id="s" class="text" value="Jita" tabindex="1" id="originsystem"> <span style="font-size: 10pt;">(Type to select from auto-complete)</span>
                    </td>
                </tr>
                <tr>
                    <td>Ship To&nbsp;</td>
                    <td><input type="text" name="d" id="d" class="text" value="Josameto" id="destsystem" tabindex="2"> <span id="dest_err"></span></td>
                </tr>

                <tr>
                    <td>Hi-sec Jumps</td>
                    <td><input type="text" name="jumps" id="jumps" class="text" onClick="clearIfRed(this);" onSelect="clearIfRed(this);" onFocus="clearIfRed(this);" disabled></td>
                </tr>
                
                
                <tr>
                    <td>Haulage</td>
                    <td><input type="text" id="jumps_fee" class="text" value="" disabled></td>
                </tr>
                <tr class="nullsec">
                    <td colspan="2"><hr></td>
                </tr>  
                <tr class="nullsec">
                    <td>Cargo (Km^3)</td>
                    <td><input type="text" id="cargo" class="text" value=""></td>
                </tr>                
                
                <tr class="nullsec">
                    <td>+JF Service</td>
                    <td><input type="text" id="cargo_fee" class="text" value="" disabled></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>  
                <tr>
                    <td>Contract Reward</td>
                    <td><input type="text" id="fee" class="text" value="" disabled></td>
                </tr>
                <tr class="highlight">
                    <td>Copy & Paste --&gt;</td>
                    <td><input type="text" id="fee_cp" class="text" value="" ></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>  
                
            </table>
        </form>
        <hr/>
        <h2>How to use UPS</h2>
        <ol>
            <li>Use the calculator to get the quote.</li>
            <li>DO NOT include cargo containers.</li>
            <li>Assign the <a onClick="CCPEVE.createContract(3);">courier contract</a>
                (s) as "<b>private</b>" to <a onclick="CCPEVE.showInfo(2, 98247483);" target="_blank">Under Powered Shrubberies</a> 
            </li>
            <li>Set reward with the price<span id="quote"></span> from the quote.</li>
            <li>Make sure your load is less than 900,000 m3 (or 324,000 m3 for JF service).</li>
            <li>Collateral less than or equal to 1b isk. BE REALISTIC OR FACE REFUSAL, COLLATERAL SHOULD MATCH THE VALUE OF YOUR GOODS.</li>
            <li>Set the contract to 3 days expiration with 1 days to complete (or 2 days completion for long haul).</li>
        </ol>
        <u>Note</u>: We no longer offer discounts as 10% of all contracts are paid back to RvB to benefit the members.
        <hr/>        
        
        <h2>Useful Links</h2>        
        <ul>
            <li><a href="http://rvbeve.com/forums/index.php/topic/6363-hauling-service-ups-now-available/#entry98505">RvB Forum Post<a/></li>
            <li><a onClick="CCPEVE.joinChannel('R-V-B')">RvB Recruitment - Join the forever war!<a/></li>
            <li><a onClick="CCPEVE.joinChannel('RvB Ganked')">RvB Ganked - Come and gank null-sec'ers! (no membership required)<a/></li>
        </ul>
        
        <p style="float:right; color:white; font-size: 10px">Developed by <a href="http://au.linkedin.com/in/nathanstephendunn/">Nathan Dunn</a></p>
    </body>
</html>