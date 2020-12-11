<?php
require '../../php_framework/function.php';
checkUserLogin(true,true);
?>
<div class="float-left btn-group" role="group">
    <button onclick="showAll();" type="button" class="btn btn-secondary">All</button>
    <button onclick="showAvailable();" type="button" class="btn btn-secondary">Available</button>
    <button onclick="showExpired();" type="button" class="btn btn-secondary">Expired</button>
    <button onclick="showUsed();" type="button" class="btn btn-secondary">Used</button>
</div>
<label id="lbmode" class="float-left"></label>
<div style="clear: both;"></div>
<div id="cps">
    <center><br/><br/>
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
    <br/><br/></center>
</div>
<div id="btnsdiv">
    <div class="float-right">
        <button onclick="previous();" type="button" class="btnp d-inline btn btn-primary btn-sm">Previous</button>
        <button onclick="next();" type="button" class="btnp d-inline btn btn-primary btn-sm">Next</button>
        <div>
            <label>Total of Result:&nbsp;<label id="oprt">0</label></label>
        </div>
    </div>
</div>
<script src="../js/coupon.js"></script>