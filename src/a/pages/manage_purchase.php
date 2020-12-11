<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-purchase');?>
<script>$('#page_title').html('Purchase');</script>
<div id="ctn">
    <label onclick="goTo('purchase-low-stock');" class="items btn btn-light">
        <img src="../../img/out_of_stock.png" class="icon" alt="icon"/><br/>
        Low Stock
    </label>
    <label onclick="goTo('purchase-purchased');" class="items btn btn-light">
        <img src="../../img/purchased.png" class="icon" alt="icon"/><br/>
        Purchased
    </label>
    <label onclick="goTo('purchase-supplier');" class="items btn btn-light">
        <img src="../../img/supplier.png" class="icon" alt="icon"/><br/>
        Supplier
    </label>
</div>