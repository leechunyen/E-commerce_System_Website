<?php require '../../php_framework/function.php';?>
<div id="cpdiv"></div>
<div id="pv">
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
<script src="../js/home.js"></script>