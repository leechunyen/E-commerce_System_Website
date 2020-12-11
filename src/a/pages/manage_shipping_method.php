<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-shipping-method');?>
<button onclick="$('#add_modal').modal('show');" type="button" class="float-right btn btn-secondary">Add</button>
<div style="clear: both;"></div>
<div id="divspmd">
    <center><br/><br/>
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
    <br/><br/></center>
</div>
<div id="add_modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="add_title" class="col-sm-4 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_title" placeholder="Title">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_title_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_price" class="col-sm-4 col-form-label">Price: (<?php echo $xmldata->Currency;?>)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_price" placeholder="Price">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_price_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_dd" class="col-sm-4 col-form-label">Delivery days</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_dd" placeholder="Delivery days">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_dd_mg" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btad" onclick="add();" type="button" class="btn btn-primary">Add</button>
                <button id="spad" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>
<div id="edt_modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="edtid" class="hide" disabled/>
                <div class="form-group row">
                    <label for="edt_title" class="col-sm-4 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_title" placeholder="Title">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_title_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_price" class="col-sm-4 col-form-label">Price: (<?php echo $xmldata->Currency;?>)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_price" placeholder="Price">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_price_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_dd" class="col-sm-4 col-form-label">Delivery days</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_dd" placeholder="Delivery days">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_dd_mg" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="bted" onclick="edit();" type="button" class="btn btn-primary">Update</button>
                <button id="sped" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>
<script src="../js/manage_shipping_method.js"></script>