<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-admin');?>
<div class="float-left btn-group" role="group">
    <button onclick="showAll();" type="button" class="btn btn-secondary">All</button>
    <button onclick="showAdmin();" type="button" class="btn btn-secondary">Admin</button>
    <button onclick="showSuperUser();" type="button" class="btn btn-secondary">SuperUser</button>
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
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Lock</th>
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
            </td><td></td><td></td>
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
                    <div class="middle">
                        <label id="bt_ph_up" for="file_add_ph" class="text">Upload</label>
                        <input onchange="addDisplayPhoto();" id="file_add_ph" class="d-none" accept="image/jpg,image/jpeg,image/png" type="file"/>
                    </div>
                </div>
                <br/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col">
                        <div id="add_type">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input checked value="a" type="radio" id="add_type_a" name="add_type" class="custom-control-input"/>
                                <label class="custom-control-label" for="add_type_a">Admin</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="s" type="radio" id="add_type_s" name="add_type" class="custom-control-input"/>
                                <label class="custom-control-label" for="add_type_s">SuperUser</label>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
                    </div>
                    <div class="col custom-control custom-switch">
                        <input onchange="addEdtLockSw(this,'add_lb_swlc');" type="checkbox" class="custom-control-input" id="add_swlc">
                        <label id="add_lb_swlc" class="custom-control-label" for="add_swlc">Unlocked</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_first_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col">
                        <input type="text" class="form-control" id="add_first_name" placeholder="First Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_fn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="add_last_name" placeholder="Last Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_ln_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_username" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="add_username" placeholder="Username" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_usn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="add_email" placeholder="Email" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_email_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="add_password" placeholder="Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_psw_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="add_confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="add_confirm_password" placeholder="Confirm Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="add_cfpsw_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col">
                        <div id="add_gd">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="m" type="radio" id="add_gender_m" name="add_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="add_gender_m">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="f" type="radio" id="add_gender_f" name="add_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="add_gender_f">Female</label>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
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
            <div id="edt_edit" class="modal-body">
                <div class="container">
                    <img id="edt_photo" src="../../img/df_user.png" alt="Avatar" class="image">
                    <div class="middle">
                        <label for="file_edt_ph" class="text">Change</label>
                        <input onchange="edtDisplayPhoto();" id="file_edt_ph" class="d-none" accept="image/jpg,image/jpeg,image/png" type="file"/>
                    </div>
                </div>
                <br/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label col-form-label-sm">ID</label>
                    <div class="col-sm-10">
                        <input disabled type="text" class="form-control" id="edt_id" placeholder="ID" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col">
                        <div id="edt_type">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="a" type="radio" id="edt_type_a" name="edt_type" class="custom-control-input"/>
                                <label class="custom-control-label" for="edt_type_a">Admin</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="s" type="radio" id="edt_type_s" name="edt_type" class="custom-control-input"/>
                                <label class="custom-control-label" for="edt_type_s">SuperUser</label>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
                    </div>
                    <div class="col custom-control custom-switch">
                        <input onchange="addEdtLockSw(this,'edt_lb_swlc');" type="checkbox" class="custom-control-input" id="edt_swlc">
                        <label id="edt_lb_swlc" class="custom-control-label" for="edt_swlc">Unlocked</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_first_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col">
                        <input type="text" class="form-control" id="edt_first_name" placeholder="First Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_fn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="edt_last_name" placeholder="Last Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_ln_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_username" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edt_username" placeholder="Username" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_usn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="edt_email" placeholder="Email" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="edt_email_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col">
                        <div id="edt_gd">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="m" type="radio" id="edt_gender_m" name="edt_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="edt_gender_m">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="f" type="radio" id="edt_gender_f" name="edt_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="edt_gender_f">Female</label>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
                    </div>
                </div>
                <button onclick="gotoResetPassword();" type="button" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                <button id="btdelacc" onclick="deleteAdmin();" type="button" class="btn btn-danger btn-lg btn-block">Delete</button>
                <button id="spdelacc" class="hide btn btn-danger btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            <div id="edt_rs_psw" class="hide modal-body">
                <center><h6>Reset Password</h6></center>
                <div class="form-group row">
                    <label for="edt_nwpsw" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="edt_nwpsw" placeholder="New Password">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_edt_nwpsw_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edt_cfpsw" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="edt_cfpsw" placeholder="Confirm Password">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_edt_cfpsw_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <button onclick="gotoEditInfo();" type="button" class="btn btn-primary btn-lg btn-block">Go Back</button>
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
<script src="../js/manage_admin.js" type="text/javascript"></script>
<script>
    minpswlg=<?php echo$xmldata->MinPassLength;?>;
    pswcap=<?php echo$xmldata->PassCap;?>;
</script>