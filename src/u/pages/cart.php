<?php
require '../../php_framework/function.php';
checkUserLogin(true,true);
$uid=$_SESSION['uid'];
?>
<div id="plld" class="hide">
    <button id="sppyld" class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
    </button>
</div>
<div id="container">
    <div id="list">
        <center><br/><br/>
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
        <br/><br/></center>
    </div>
    <hr/>
    <div id="action">
        <div class="float-left">
            <div>Shipping method: <label class="selop" id="spmdch" onclick="$('#spmd').modal('show');">------</label></div>
            <div>Shipping Address: <label class="selop" id="spaddrch" onclick="$('#spaddr').modal('show');">------</label></div>
            <div>Coupon: <label class="selop" id="cpselch" onclick="$('#uscp').modal('show');">------</label></div>
        </div>
        <div class="float-right">
            <table>
                <tr>
                    <td><h5>Total:&nbsp;</h5></td>
                    <td><h5><?php echo$xmldata->Currency;?>&nbsp;</h5></td>
                    <td><h5 id="price">0.00</h5></td>
                </tr>
                <tr>
                    <td><h5>Shipping:&nbsp;</h5></td>
                    <td><h5><?php echo$xmldata->Currency;?>&nbsp;</h5></td>
                    <td><h5 id="smpr">0.00</h5></td>
                </tr>
                <tr>
                    <td><h5>Coupon:&nbsp;</h5></td>
                    <td><h5><?php echo$xmldata->Currency;?>&nbsp;</h5></td>
                    <td><h5 id="cpdsc">0.00</h5></td>
                </tr>
                <tr>
                    <td><h5>Total Payment:&nbsp;</h5></td>
                    <td><h5><?php echo$xmldata->Currency;?>&nbsp;</h5></td>
                    <td><h5 id="ttprc">0.00</h5></td>
                </tr>
            </table>
            <button id="btpo" disabled onclick="placeOrder();" type="button" class="btn btn-primary">Place Order</button>
            <button id="sppo" class="hide btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
        </div>
        
    </div>
</div>
<div id="spmd" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Shipping Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $sql='select * from `shipping_method`;';
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0) {
                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                <div class="input-group spmdseldiv">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="rbspmd" onclick="shippingMethodSel('<?php echo$row['Title'];?>',<?php echo$row['Price'];?>,<?php echo$row['ID'];?>);">
                        </div>
                    </div>
                    <div class="col spmdsel">
                        <label class="float-left"><?php echo$row['Title'];?></label>
                        <spam class="float-left spmdsel_span">receive in <?php echo$row['DeliveryDays'];?></spam>
                        <label class="float-right"><?php echo$xmldata->Currency.'&nbsp;'.$row['Price'];?></label>
                    </div>
                </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="uscp" class="modal" tabindex="-1"><!--coupon-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="cps" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="spaddr" class="modal" tabindex="-1"><!--shipping address-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="spa" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="checkout" class="modal" tabindex="-1"><!--Checkout-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="cps" class="modal-body">
                <p>Total products: <label id="co_top">0</label></p>
                <p>Price: <?php echo$xmldata->Currency;?>&nbsp;<label id="co_pdp">0.00</label></p>
                <p>Shipping Fee: <?php echo$xmldata->Currency;?>&nbsp;<label id="co_spf">0.00</label></p>
                <p>Coupon: <?php echo$xmldata->Currency;?>&nbsp;<label id="co_cp">0.00</label></p>
                <p>Total payment: <?php echo$xmldata->Currency;?>&nbsp;<label id="co_tpay">0.00</label></p>
                <div id="paypal-button-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="../js/cart.js" type="text/javascript"></script>
<?php
mysqli_close($conn);
?>