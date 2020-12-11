<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-product');?>
<div class="float-left btn-group" role="group">
    <button onclick="showAll();" type="button" class="btn btn-secondary">All</button>
    <button onclick="showAvailable();" type="button" class="btn btn-secondary">Available</button>
    <button onclick="showUnavailable();" type="button" class="btn btn-secondary">Unavailable</button>
</div>
<label id="lbmode" class="float-left"></label>
<div class="float-right btn-group" role="group">
    <button onclick="reset();" type="button" class="btn btn-secondary">Reset</button>
    <button onclick="$('#add_modal').modal('show');" type="button" class="btn btn-secondary">Add</button>
</div>
<div id="divse" class="float-right input-group mb-3">
    <input id="ipse" type="text" class="form-control" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
        <button onclick="search();" class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>
</div>
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>Photo</th>
            <th>ID</th>
            <th>Name</th>
            <th>Modal</th>
            <th>Price</th>
            <th>Available</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb_ls">
        <tr>
            <td></td><td></td><td></td><td>
                <center><br/><br/>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                <br/><br/></center>
            </td><td></td><td></td><td></td>
        </tr>
    </tbody>
</table>
<div>
    <button onclick="previous();" type="button" class="btnp d-inline btn btn-primary btn-sm">Previous</button>
    <button onclick="next();" type="button" class="btnp d-inline btn btn-primary btn-sm">Next</button>
    <div class="d-inline">
        <label  class="d-inline">Total of Result:&nbsp;<label id="oprt">0</label></label>
        &nbsp;&nbsp;&nbsp;
        <div  class="d-inline">
            <label>Number of rows:&nbsp;
                <select onchange="changeNumOfRow();" id="sel_nor">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="200">200</option>
                </select>
            </label>
        </div>
    </div>
</div>
<div id="add_modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <img id="add_photo" src="../../img/tmp_img.png" alt="Avatar" class="image">
                    <div id="add_dfphoto_er" class="middle">
                        <label id="bt_ph_up" for="file_add_ph" class="text">Upload</label>
                        <input onchange="addDisplayPhoto();" id="file_add_ph" class="d-none" accept="image/jpg,image/jpeg,image/png" type="file"/>
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please upload.
                    </div>
                </div>
                <br/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">More photo</label>
                    <button onclick='$("#add_imgarr").trigger("click");' for="add_imgarr" type="button" class="col-sm-2 btn btn-primary">Add</button>
                    &nbsp;
                    <div class="col-sm-7 img_view_arr_img_div">
                        <input id="add_imgarr" onchange="imgArrDisplay(this);" multiple type="file" class="hide" accept="image/jpg,image/jpeg,image/png"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Name" id="add_name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_name_ermg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_model" class="col-sm-2 col-form-label">Model</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Model" id="add_model">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_model_ermg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="add_price">Price (<?php echo$xmldata->Currency;?>)</label>
                        <input type="text" class="form-control" placeholder="Price" id="add_price">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_price_ermg" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="add_stock">Stock</label>
                        <input type="text" class="form-control" placeholder="Stock" id="add_stock">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_stock_ermg" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="add_reordrtpoint">Reorder Point</label>
                        <input type="text" class="form-control" placeholder="Reorder Point" id="add_reordrtpoint">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_reorderpoint_ermg" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-sm-1">
                        <label>Available</label>
                        <div class="custom-control custom-switch">
                            <input onchange="availableSw(this,'add_lbswava')" type="checkbox" class="custom-control-input" id="add_swava">
                            <label class="custom-control-label" id="add_lbswava" for="add_swava">Unavailable</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 sm-5">
                        <label for="add_dateautoava">Date auto available</label>
                        <div class="custom-control custom-switch">
                            <input onchange="autoAvaUnavaSw(this,'add_lbswatava');" type="checkbox" class="custom-control-input add_atavasw" id="add_swatava">
                            <label class="custom-control-label add_swatavalb" id="add_lbswatava" for="add_swatava">Disabled</label>
                        </div>
                        <input disabled onkeydown="return false" type="text" class="form-control datepicker" id="add_dateautoava">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_dateautoava_ermg" class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="add_dateautounava">Date auto unavailable</label>
                        <div class="custom-control custom-switch">
                            <input onchange="autoAvaUnavaSw(this,'add_lbswatunava');" type="checkbox" class="custom-control-input add_atavasw" id="add_swatunava">
                            <label class="custom-control-label add_swatavalb" id="add_lbswatunava" for="add_swatunava">Disabled</label>
                        </div>
                        <input disabled onkeydown="return false" type="text" class="form-control datepicker" id="add_dateautounava">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_dateautounava_ermg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="add_detail">Detail</label>
                    <textarea class="form-control" id="add_detail" placeholder="Detail" required></textarea>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="add_detailermg" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="add();" id="btad" type="button" class="btn btn-primary">Add</button>
                <button id="spad" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>
<script src="../js/manage_product.js" type="text/javascript"></script>