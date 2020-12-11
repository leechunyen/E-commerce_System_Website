<?php
if(!isset($_REQUEST['m'])){echo 'Page Error.';}
else{
    require '../../php_framework/function.php';
    $m=$_REQUEST['m'];$data;
    if($m=='a'){checkAdminLogin(true,true);}
    elseif($m=='u'){checkUserLogin(true,true);}
?>
<div id="spdiv">
    <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
    </button>
</div>
<div id="ct" class="hide">
    <div id="topcard" class="card mb-3">
        <div class="row no-gutters">
            <div id="pthdiv" class="col-md-4">
                <div class="container">
                    <img id="propth" src="../../img/df_user.png" alt="Photo" class="image card-img">
                    <div class="middle">
                        <button onclick="$('#flphoto').trigger('click');" id="btchimg" class="btn btn-primary text">Change</button>
                    </div>
                </div>
                <input onchange="changePhoto(this);" type="file" class="hide" id="flphoto" accept="image/jpg,image/jpeg,image/png"/>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Current Login Info</h5>
                    <div class="form-group row">
                        <label class="col col-form-label">IP</label>
                        <div class="col-sm-10">
                            <input id="llgip" type="text" readonly class="form-control-plaintext">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col col-form-label">Date Time</label>
                        <div class="col-sm-10">
                            <input id="llgdt" type="text" readonly class="form-control-plaintext">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col col-form-label">Account Created</label>
                        <div class="col-sm-10">
                            <input id="cdt" type="text" readonly class="form-control-plaintext">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="input-group row">
        <label class="col-sm-2">Username</label>
        <input disabled id="ipusn" type="text" class="edtip col-sm-10 form-control" placeholder="Username">
        <div class="input-group-append">
            <button onclick="edit(this,'usn','ipusn');" class="edtbt btn btn-outline-secondary" type="button" id="btusn">Edit</button>
        </div>
    </div>
    <div class="input-group row">
        <label class="col-sm-2">Email</label>
        <input disabled id="ipem" type="text" class="edtip col-sm-10 form-control" placeholder="Email">
        <div class="input-group-append">
            <button onclick="edit(this,'em','ipem');" class="edtbt btn btn-outline-secondary" type="button" id="bten">Edit</button>
        </div>
    </div>
    <div class="input-group row">
        <label class="col-sm-2">Name</label>
        <div class="input-group-prepend">
            <span class="input-group-text">First and Last</span>
        </div>
        <input disabled id="ipfn" type="text" placeholder="First name" class="edtip form-control">
        <input disabled id="ipln" type="text" placeholder="Last name" class="edtip form-control">
        <div class="input-group-append">
            <button onclick="edit(this,'name','ipfn','ipln');" class="edtbt btn btn-outline-secondary" type="button" id="bten">Edit</button>
        </div>
    </div>
    <div class="input-group row">
        <div class="input-group col-sm-6">
            <label class="col-sm-2">Gender</label>
            <div class="col-sm-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input disabled value="m" type="radio" id="gender_m" name="gender" class="edtip custom-control-input">
                    <label class="custom-control-label" for="gender_m">Male</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input disabled value="f" type="radio" id="gender_f" name="gender" class="edtip custom-control-input">
                    <label class="custom-control-label" for="gender_f">Female</label>
                </div>
            </div>
            <div class="input-group-append">
                <button onclick="edit(this,'gd','gender_m','gender_f',null,true);" class="edtbt btn btn-outline-secondary" type="button" id="btusn">Edit</button>
            </div>
        </div>
    <?php if($m=='u'){?>
        <div class="input-group col-sm-5">
            <label class="col-sm-2 col-form-label country_sel">Country</label>&nbsp;&nbsp;
            <select disabled class="edtip col country_sel form-control" id="country_sel"></select>
            <div class="input-group-append">
                <button onclick="edit(this,'cty','country_sel');" class="edtbt btn btn-outline-secondary" type="button" id="btusn">Edit</button>
            </div>
        </div>
    <?php }?>
    </div>
    <?php if($m=='u'){?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Birth Day</label>
        <div class="col">
            <label class="col-form-label">Day</label>
            <select disabled id="dob_day_sel" class="edtip form-control"></select> 
        </div>
        <div class="col">
            <label class="col-form-label">Month</label>
            <select disabled id="dob_mon_sel" class="edtip form-control"></select>
        </div>
        <div class="col">
            <label class="col-form-label">Year</label>
            <select disabled id="dob_yar_sel" class="edtip form-control"></select>
        </div>
        <div class="input-group-append">
            <button onclick="edit(this,'dob','dob_day_sel','dob_mon_sel','dob_yar_sel');" class="edtbt btn btn-outline-secondary" type="button" id="btusn">Edit</button>
        </div>
    </div>
    <button id="btdacc" onclick="$('#delete_acc').modal('show');" type="button" class="btn btn-danger btn-lg btn-block">Delete Account</button><br/>
    <div id="delete_acc" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>after deleting your account you will lost all your data, And you are not longer to login into your account.</p>
                    <div>
                        <div>
                            <input onclick="deleteAgree(this);" id="cbaggdelacc" type="checkbox"/>
                            <label>I have read and agree to the team and condition</label>
                        </div>
                        <center><button disabled onclick="deleteAcc();" id="bt_del_acc" type="button" class="btn btn-danger">Delete</button></center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <button id="btcpsw" onclick="$('#ch_psw').modal('show');" type="button" class="btn btn-primary btn-lg btn-block">Change Password</button>
    <button id="btcedt" onclick="cancelEdit();" type="button" class="hide btn btn-secondary btn-lg btn-block">Cancel Edit</button>
    <?php if($m=='u'){?>
    <label>I have read and agree to the <a onclick="$('#mdl_tnc').modal('show');" href="">Team and Condition</a></label>
    <?php }?>
</div>
<div id="ch_psw" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="chpsw_cr" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="chpsw_cr">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_chpsw_cr" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="chpsw_nw" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="chpsw_nw">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_chpsw_nw" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="chpsw_cf" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="chpsw_cf">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_chpsw_cf" class="invalid-feedback"></div>
                    </div>
                </div>
                <button id="btchpsw" onclick="changePassword();" type="button" class="btn btn-primary btn-lg btn-block">Done</button>
                <button id="spchpsw" class="hide btn btn-primary btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="emvalidate" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Validation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>we have sent the validation code to your email.</p>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" readonly class="form-control-plaintext" id="nw_val_email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_vc" class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="em_vc">
                            <div class="input-group-append">
                                <button onclick="resendVC();" class="btn btn-outline-secondary" type="button" id="bt_resend_code">Resend</button>
                            </div>
                            <div id="div_rsvc"></div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="er_vc_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <button id="btemvl" onclick="validationCodeValidate();" type="button" class="btn btn-primary btn-lg btn-block">Done</button>
                <button id="spemvl" class="hide btn btn-primary btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="mdl_tnc" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Terms and Condition</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="tocctn" class="modal-body">
                <?php
                $tocpth=getFile($xmldata->TncPath);
                $tncfile=fopen($tocpth,"r");
                while(! feof($tncfile)){
                    echo fgets($tncfile)."<br/>";
                }
                fclose($tncfile);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php }?>
<script src="../../js_framework/variousCountryListFormats.js" type="text/javascript"></script>
<script src="../../ua/js/profile_setting.js" type="text/javascript"></script>
<script src="../../js_framework/dob_list.js" type="text/javascript"></script>
<script>
    minpswlg=<?php echo$xmldata->MinPassLength;?>;
    pswcap=<?php echo$xmldata->PassCap;?>;
</script>