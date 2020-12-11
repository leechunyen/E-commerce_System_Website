<?php require '../../php_framework/function.php';
checkAdminLogin(true,'system-setting');
$fhttps-false;$passcap=false;$https=false;
if(isset($_SERVER["HTTPS"])){$https=true;}
if($xmldata->ForceHTTPS=='true'){$fhttps=true;}
if($xmldata->PassCap=='true'){$passcap=true;}
?>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>Logo</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <img id="logo_pv" class="img" src="<?php echo$logo;?>"/>
            </div>
            <div class="h-auto nele nele2">
                <button onclick='$("#logo_file").trigger("click");' class="btn btn-primary">Change</button>
                <button id="sp_save_logo" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="btn_logo_save" disabled onclick="saveLogo();" class="btn btn-primary">Save</button>
                <input class="hide" onchange="displayLogo();" id="logo_file" accept="image/jpg,image/jpeg,image/png" type="file"/>
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>Title</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <label id="lb_title"><?php echo$title;?></label>
            </div>
            <div class="h-auto nele nele2">
                <div class="input-group mb-3">
                    <input oninput="checkNewTitleInput();" id="ip_nw_title" type="text" class="form-control" placeholder="New Title">
                    <div class="input-group-append">
                        <button disabled onclick="saveNewTitle();" id="btn_nwtitle_save" class="btn btn-outline-secondary" type="button">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>Minimum Password Length</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <label id="lb_pswlg"><?php echo$xmldata->MinPassLength;?></label>
            </div>
            <div class="h-auto nele nele2">
                <div class="input-group mb-3">
                    <input oninput="checkNewPswLgInput();" id="ip_nw_pswlg" type="text" class="form-control" placeholder="New Length">
                    <div class="input-group-append">
                        <button disabled onclick="saveNewPswLg();" id="btn_nwpswlg_save" class="btn btn-outline-secondary" type="button">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>terms and Condition</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <button onclick="$('#mdl_toc').modal('show')" class="btn btn-primary">Show</button>
            </div>
            <div class="h-auto nele nele2">
                <button onclick='$("#toc_file").trigger("click");' class="btn btn-primary">Change</button>
                <button id="sp_save_toc" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="bt_toc_save" disabled onclick="saveToc();" class="btn btn-primary">Save</button>
                <input class="hide" onchange="loadToc();" id="toc_file" accept=".txt" type="file"/>
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="ele2">
            <div class="col title_div h-auto">
                <h5>Force HTTPS</h5>
            </div>
            <div class="col ctn_div h-auto">
                <div class="custom-control custom-switch">
                    <input onchange="forceHTTPS_PswCap_change(this,1);" <?php if(!$https){echo'disabled';}if($fhttps){echo'checked';}?> type="checkbox" class="custom-control-input" id="sw_fhttps">
                    <label class="custom-control-label" for="sw_fhttps">Disable</label>
                </div>&nbsp;
                <?php if(!$https){?>
                <a href="" onclick="gotoHTTPS();">Goto HTTPS</a> to enable.
                <?php }?>
            </div>
            <div class="col">
                while enable user will force redirect to HTTPS to improve browsing security.
            </div>
        </div>
        <div class="ele2">
            <div class="col title_div h-auto">
                <h5>Password Capital</h5>
            </div>
            <div class="col ctn_div h-auto">
                <div class="custom-control custom-switch">
                    <input onchange="forceHTTPS_PswCap_change(this,2)" <?php if($passcap){echo'checked';}?> type="checkbox" class="custom-control-input" id="sw_pswcap">
                    <label class="custom-control-label" for="sw_pswcap">Disable</label>
                </div>
                &nbsp;
            </div>
            <div class="col">
                while enable all the password in this web site will require at less 1 capital letter.
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>Mail Server</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <button onclick="viewMailServer(this);" type="button" class="btn btn-primary">
                Edit
            </button>
            <button id="spstem" class="hide btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
            <button id="btstem" onclick="mailTest();" type="button" class="btn btn-primary">
                Send a test email
            </button>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>PayPal Client ID</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <button onclick="viewPPClientID();" class="btn btn-primary">Show</button>
            </div>
        </div>
    </div>
</div>
<div class="card w-100">
    <div class="card-body">
        <div class="title_div h-auto ele">
            <h5>Cache Size</h5>
        </div>
        <div class="ctn_div h-auto ele">
            <div class="h-auto nele cr_pv">
                <label id="lb_cc"><?php echo human_filesize(filesize('../../others/cached'));?></label>
            </div>
            <div class="h-auto nele nele2">
                <button id="btcc" onclick="clearCache();" type="button" class="btn btn-primary">Clear Cache</button>
                <button id="spcc" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>
<div id="mdl_mail" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Mail Server</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="smtp_host" class="col-sm-2 col-form-label">Host / port</label>
                    <div class="col">
                        <input type="text" class="form-control" id="smtp_host" placeholder="Host"/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="smtp_host_invalid_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="smtp_porrt" placeholder="Port"/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="smtp_port_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="smtp_secure" class="col-sm-2 col-form-label">SMTP Secure</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="smtp_secure" placeholder="SMTP Secure"/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="smtp_secure_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">SMTP authentication</label>
                    <div class="col">
                        <div class="custom-control custom-switch">
                            <input disabled type="checkbox" class="custom-control-input" id="sw_mail_auth">
                            <label id="lb_mail_auth" class="custom-control-label" for=sw_mail_auth>Enabled</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="smtp_username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="smtp_username" placeholder="Username"/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="smtp_usn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="smtp_password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="smtp_password" placeholder="Password"/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="smtp_pass_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="sp_upem" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="bt_upem" onclick="updateMailServer();" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="mdl_toc" class="modal" tabindex="-1">
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
<div id="mdl_pp" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">PayPal Client ID</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="tocctn" class="modal-body">
                <div class="input-group mb-3">
                    <input oninput="checkNewTitleInput();" id="ip_ppcid" type="text" class="form-control" placeholder="PayPal Client ID">
                    <div class="input-group-append">
                        <button onclick="updatePPClicntID();" id="btn_nwtitle_save" class="btn btn-outline-secondary" type="button">Save</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="../js/system-setting.js" type="text/javascript"></script>