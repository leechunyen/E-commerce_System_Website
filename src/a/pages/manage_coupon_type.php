<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-coupon-type');?>
<button onclick="$('#add_modal').modal('show');" type="button" class="float-right btn btn-secondary">Add</button>
<div style="clear: both;"></div>
<div id="divcpty">
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
                <div class="custom-control custom-switch">
                    <input onclick="swava(this,'add_lbava');" type="checkbox" class="custom-control-input" id="add_ava">
                    <label id="add_lbava" class="custom-control-label" for="add_ava">Unavailable</label>
                </div>
                <div class="form-group row">
                    <label for="add_dsc" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_dsc" placeholder="Description">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_dsc_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_minpay" class="col-sm-4 col-form-label">Minimum Pay (<?php echo$xmldata->Currency;?>)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_minpay" placeholder="Minimum Pay">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_minpay_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_dis" class="col-sm-2 col-form-label">Discount</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="add_dis" placeholder="Discount">
                    </div>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="p" type="radio" id="add_md_p" name="add_mode" class="add_mode custom-control-input"/>
                            <label class="custom-control-label" for="add_md_p">%</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="c" type="radio" id="add_md_c" name="add_mode" class="add_mode custom-control-input"/>
                            <label class="custom-control-label" for="add_md_c"><?php echo$xmldata->Currency;?></label>
                        </div>
                        <div id="add_dis_md"></div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_dis_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_dtexp" class="col-sm-4 col-form-label">Days to Expire</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_dtexp" placeholder="Days to Expire">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                            <div id="er_ad_dtexp_mg" class="invalid-feedback"></div>
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
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" readonly class="hide form-control" id="edt_id">
                <div class="custom-control custom-switch">
                    <input onclick="swava(this,'edt_lbava');" type="checkbox" class="custom-control-input" id="edt_ava">
                    <label id="edt_lbava" class="custom-control-label" for="edt_ava">Unavailable</label>
                </div>
                <div class="form-group row">
                    <label for="edt_dsc" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_dsc" placeholder="Description">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_dsc_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_minpay" class="col-sm-4 col-form-label">Minimum Pay (<?php echo$xmldata->Currency;?>)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_minpay" placeholder="Minimum Pay">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_minpay_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_dis" class="col-sm-2 col-form-label">Discount</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="edt_dis" placeholder="Discount">
                    </div>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="p" type="radio" id="edt_md_p" name="edt_mode" class="edt_mode custom-control-input"/>
                            <label class="custom-control-label" for="edt_md_p">%</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="c" type="radio" id="edt_md_c" name="edt_mode" class="edt_mode custom-control-input"/>
                            <label class="custom-control-label" for="edt_md_c"><?php echo$xmldata->Currency;?></label>
                        </div>
                        <div id="edt_dis_md"></div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_dis_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_dtexp" class="col-sm-4 col-form-label">Days to Expire</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_dtexp" placeholder="Days to Expire">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_dtexp_mg" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="bted" onclick="edit();" type="button" class="btn btn-primary">Save</button>
                <button id="sped" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>
<script src="../js/manage_coupon_type.js"></script>