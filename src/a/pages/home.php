<?php require '../../php_framework/function.php';
checkAdminLogin(true,'/');?>
<script>$('#page_title').html('Home');</script>
<div id="ctn">
    <label onclick="goTo('manage-order');" class="items btn btn-light">
        <img src="../../img/order.png" class="icon" alt="icon"/><br/>
        Order
    </label>
    <label onclick="goTo('manage-user');" class="items btn btn-light">
        <img src="../../img/user.png" class="icon" alt="icon"/><br/>
        User
    </label>
    <label onclick="goTo('manage-coupon-type');" class="items btn btn-light">
        <img src="../../img/coupon.png" class="icon" alt="icon"/><br/>
        Coupon type
    </label>
    <label onclick="goTo('manage-product');" class="items btn btn-light">
        <img src="../../img/product.png" class="icon" alt="icon"/><br/>
        Product
    </label>
    <label onclick="goTo('manage-shipping-method')" class="items btn btn-light">
        <img src="../../img/shipping.png" class="icon" alt="icon"/><br/>
        Shipping Method
    </label>
    <label onclick="goTo('manage-purchase');" class="items btn btn-light">
        <img src="../../img/purchase.png" class="icon" alt="icon"/><br/>
        Purchase
    </label>
    <?php if($_SESSION["type"]=='s'){?>
    <label onclick="goTo('manage-admin');" class="items btn btn-light">
        <img src="../../img/admin.png" class="icon" alt="icon"/><br/>
        Admin
    </label>
    <label onclick="goTo('system-setting');" class="items btn btn-light">
        <img src="../../img/settings.png" class="icon" alt="icon"/><br/>
        System Setting
    </label>
    <?php }?>
</div>