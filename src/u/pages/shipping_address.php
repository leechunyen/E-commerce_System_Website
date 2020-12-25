<?php
require '../../php_framework/function.php';
checkUserLogin(true,true);
?>
<button onclick="$('#add_modal').modal('show');" type="button" class="float-right btn btn-secondary">Add</button>
<div style="clear: both;"></div>
<div id="divaddrs">
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
                    <label for="add_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_name" placeholder="Name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_ph" class="col-sm-4 col-form-label">Phone</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_ph" placeholder="Phone">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_ph" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_em" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_em" placeholder="Email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_em" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_addr" class="col-sm-4 col-form-label">Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_addr" placeholder="Address">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_addr" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_city" class="col-sm-4 col-form-label">City</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_city" placeholder="City">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_city" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_zc" class="col-sm-4 col-form-label">Zip Code</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_zc" placeholder="Zip Code">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_zc" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_st" class="col-sm-4 col-form-label">State</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_st" placeholder="State">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_st" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_cty" class="col-sm-4 col-form-label">Country</label>
                    <div class="col-sm-8">
                        <select class="country_sel form-control" id="add_cty">
                            <option value="">--</option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_cty" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_tag" class="col-sm-4 col-form-label">Tag</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="add_tag" placeholder="Tag">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ad_tag" class="invalid-feedback"></div>
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
                <input id="edtid" class="hide" readonly type="text"/>
                <div class="form-group row">
                    <label for="edt_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_name" placeholder="Name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_ph" class="col-sm-4 col-form-label">Phone</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_ph" placeholder="Phone">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_ph" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_em" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_em" placeholder="Email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_em" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_addr" class="col-sm-4 col-form-label">Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_addr" placeholder="Address">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_addr" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_city" class="col-sm-4 col-form-label">City</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_city" placeholder="City">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_city" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_zc" class="col-sm-4 col-form-label">Zip Code</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_zc" placeholder="Zip Code">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_zc" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_st" class="col-sm-4 col-form-label">State</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_st" placeholder="State">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_st" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_cty" class="col-sm-4 col-form-label">Country</label>
                    <div class="col-sm-8">
                        <select class="country_sel form-control" id="edt_cty">
                            <option value="">--</option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_cty" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_tag" class="col-sm-4 col-form-label">Tag</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edt_tag" placeholder="Tag">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ed_tag" class="invalid-feedback"></div>
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
<script src="../../js_framework/variousCountryListFormats.js" type="text/javascript"></script>
<script src="../js/shipping_address.js"></script>