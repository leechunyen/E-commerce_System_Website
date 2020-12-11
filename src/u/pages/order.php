<?php require '../../php_framework/function.php';checkUserLogin(true,true);?>
<div class="float-left btn-group" role="group">
    <button onclick="showAll();" type="button" class="btn btn-secondary">All</button>
    <button onclick="showOrder();" type="button" class="btn btn-secondary">Order</button>
    <button onclick="showShippedOut();" type="button" class="btn btn-secondary">ShippedOut</button>
</div>
<label id="lbmode" class="float-left"></label>
<div class="float-right btn-group" role="group">
    <button onclick="reset();" type="button" class="btn btn-secondary">Reset</button>
</div>
<div id="divse" class="float-right input-group mb-3 col-sm-3">
    <input id="ipse" type="text" class="form-control" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
        <button onclick="search();" class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>
</div>
<div style="clear: both;"></div>
<div id="odls">
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
<script src="../js/order.js"></script>