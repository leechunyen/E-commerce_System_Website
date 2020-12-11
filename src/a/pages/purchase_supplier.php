<?php require '../../php_framework/function.php';
checkAdminLogin(true,'purchase-supplier');?>
<div class="float-left btn-group" role="group">
    <button onclick="goTo('manage-purchase');" type="button" class="btn btn-secondary">Go Back</button>
</div>
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
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb_adm">
        <tr>
            <td></td><td></td><td>
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
                <div class="form-group row">
                    <label for="add_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="add_name" placeholder="Name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_er_name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="add_email" placeholder="Email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_er_email" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="add_phone" placeholder="Phone">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_er_phone" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="add_address" placeholder="Address">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_er_address" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="spad" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="btad" onclick="add();" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>
<div id="edt_modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="edt_id" class="hide"/>
                <div class="form-group row">
                    <label for="edt_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                            <input type="text" class="form-control" id="edt_name" placeholder="Name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_er_name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_email" placeholder="Email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_er_email" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_phone" placeholder="Phone">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_er_phone" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_address" placeholder="Address">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_er_address" class="invalid-feedback"></div>
                    </div>
                </div>
                <button id="bt_del_sup" onclick="deleteSuplier();" type="button" class="btn btn-danger btn-lg btn-block">Delete</button>
                <button id="sp_del_sup" class="hide btn btn-danger btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="spedt" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="btedt" onclick="update();" type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
<script src="../js/purchase_supplier.js" type="text/javascript"></script>