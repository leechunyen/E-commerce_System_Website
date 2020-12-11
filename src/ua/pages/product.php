<?php require '../../php_framework/function.php';
$id=$_REQUEST['id'];$mode='v';$edt=false;
$adm=checkAdminLogin(false);
$usr=checkUserLogin(false);
if(isset($_REQUEST['edt'])){$edt=true;}
if($adm&&$edt){?>
<div id="bt_top">
    <button onclick="location.href='#!manage-product';" type="button" class="float-left btn btn-primary">Go Back</button>
    <label id="lb_pid" class="float-left">Product ID: <?php echo$id;?></label>
    <div class="float-right btn-group" role="group" aria-label="Basic example">
        <button id="spsvedt" class="hide btn btn-secondary" type="button" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button id="edtsav" onclick="save();" type="button" class="hide btn btn-secondary">Save</button>
        <button id="edtbtn" onclick="edit();" type="button" class="btn btn-secondary">Edit</button>
    </div>
    <div style="clear: both;"></div>
</div>
<?php }?>
<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-3">
            <a id="ln_df_pth" class="venobox" data-gall="photos"><img id="df_pth" class="card-img" alt="default photo"></a>
            <?php if(!$edt){?>
            <div class="img_view_arr_div">
                <div class="img_view_arr_img_div"></div>
            </div>
            <?php }else{?>
            <div id="ch_dfpth" class="hide">
                <img id="nwdfpth"/>
                <button onclick="$('#ipchdfpth').trigger('click');" type="button" class="btn btn-primary">Change</button>
            </div>            
            <input onchange="chdfpth(this);" id="ipchdfpth" type="file" class="hide" accept="image/jpg,image/jpeg,image/png"/>
            <?php }?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <?php if($adm&&$edt){//admin?>
                <div class="form-group row">
                    <label for="edt_title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_title">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="ermg_title" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_model" class="col-sm-2 col-form-label">Model</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_model">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="ermg_model" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group row">
                        <label for="edt_stock" class="col-sm-2 col-form-label">Stock</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edt_stock">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_stock" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edt_reop" class="col-sm-2 col-form-label">Reorder point</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edt_reop">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_reop" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edt_price" class="col-sm-2 col-form-label">Price <?php echo$xmldata->Currency;?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edt_price">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_price" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>         
                <div class="custom-control custom-switch">
                    <input onchange="avasw(this);" type="checkbox" class="custom-control-input" id="avasw">
                    <label id="lbavasw" class="custom-control-label" for="avasw">Unavailable</label>
                </div>
                <div id="atavaunavadt">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Auto available</label>
                        <div style="width: 100px;" class="custom-control custom-switch">
                            <input onclick="atavaatunava(this,'swlbdtatava','ipdtautoava');" type="checkbox" class="custom-control-input" id="swdtatava">
                            <label id="swlbdtatava" class="custom-control-label" for="swdtatava">Disabled</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" onkeydown="return false;" class="datepicker form-control" id="ipdtautoava">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_atava" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Auto unavailable</label>
                        <div style="width: 100px;" class="custom-control custom-switch">
                            <input onclick="atavaatunava(this,'swlbdtatunava','ipdtautounava');" type="checkbox" class="custom-control-input" id="swdtatunava">
                            <label id="swlbdtatunava" class="custom-control-label" for="swdtatunava">Disabled</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" onkeydown="return false;" class="datepicker form-control" id="ipdtautounava">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_atunava" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <?php }else{//user?>
                <h2 id="lb_title" class="card-title"></h2>
                <h5>Model: <label id="lb_model"></label></h5>
                <div>Stock: <label id="lb_stock"></label></div>
                <div>Price: <?php echo$xmldata->Currency;?>&nbsp;<label id="lb_price"></label></div>
                <div id="divqty" class="col row">
                    <label for="ip_qty" class="col-form-label">Quantity:</label>
                    <div class="col-sm-10">
                        <div class="col-sm-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <button onclick="incDecQty(1);" class="btn btn-outline-secondary" type="button">-</button>
                            </div>
                            <input id="ip_qty" oninput="inputQty(this);" type="text" class="form-control" value="1">
                            <div class="input-group-prepend">
                                <button onclick="incDecQty(2);" class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button onclick="addToCart();" type="button" class="btn btn-primary">Add to Cart</button>
                <button onclick="buyNow();" type="button" class="btn btn-primary">Buy Now</button>
                <button onclick="addRemoveWishList();" id="btaddwl" type="button" class="btn btn-primary">Add to Wish List</button>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php if($adm&&$edt){//admin add and remove more photo?>
<div class="card mb-3">
    <div class="row no-gutters">
        <div id="addmrphdiv" class="hide col-sm-1">
            <img onclick="$('#addmorephoto').trigger('click');" id="add_icn" src="../../img/add_icon.png"/>
        </div>
        <div id="edtmrpth">
            <div class="card-body img_view_arr_div">
                <div class="img_view_arr_img_div"></div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <input id="addmorephoto" onchange="uploadMorePhoto(this);" type="file" class="hide" accept="image/jpg,image/jpeg,image/png" multiple/>
</div>
<?php }?>
<h4>Details:</h4>
<div id="divdetail"></div>
<textarea id="edtProDtl" class="hide"></textarea>
<script src="../../ua/js/product.js"></script>
<script>
</script>