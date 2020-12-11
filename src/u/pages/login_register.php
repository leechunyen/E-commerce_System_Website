<?php
require '../../php_framework/function.php';
if(checkSetup()){checkUserLogin(true);}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/login_register.css" rel="stylesheet" type="text/css"/>
        <script src="../../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../../js_framework/function.js" type="text/javascript"></script>
        <script src="../../js_framework/variousCountryListFormats.js" type="text/javascript"></script>
        <script src="../../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="div_home_button">
            <button onclick="location.href='../index.php#!';" type="button" class="btn btn-primary">Home</button>
        </div>
        <div id="ctn">
            <div id="div_login">
                <center><h2>Login</h2></center>
                <div class="form-group row">
                    <label for="lg_acc" class="col-sm-2 col-form-label col-form-label-sm">Account</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm lg_input" id="lg_acc" placeholder="Username / Email"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lg_psw" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control lg_input" id="lg_psw" placeholder="Password"/>
                    </div>
                </div>
                <div id="lg_er_disp"></div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="lg_er_mg" class="invalid-feedback"></div>
                <center>
                    <div id="lgbtns">
                        <button onclick="login();" type="button" class="btn btn-primary btn-lg">Login</button>
                        <button onclick="gotoRegister();" type="button" class="btn btn-secondary btn-lg">Register</button>
                        <br/><a style="margin-left: -65px;" href="../../ua/pages/reset_password.php">Reset Password?</a>
                    </div>
                    <button id="lgsp" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </center>
            </div>
            <div id="div_register">
                <center><h2>Register</h2></center>
                <div class="form-group row">
                    <label for="rg_fn" class="col-sm-2 col-form-label">Name</label>
                    <div class="col">
                        <input type="text" class="form-control" id="rg_fn" placeholder="First Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_fn_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="rg_ln" placeholder="Last Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_ln_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_usn" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rg_usn" placeholder="Username" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_usn_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_em" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rg_em" placeholder="Email" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_em_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_psw" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="rg_psw" placeholder="Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_psw_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_cpsw" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="rg_cpsw" placeholder="Confirm Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_cpsw_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Birth Day</label>
                    <div class="col">
                        <label class="col-form-label">Day</label>
                        <select id="dob_day_sel" class="form-control"></select> 
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_dob_d_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <label class="col-form-label">Month</label>
                        <select id="dob_mon_sel" class="form-control"></select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_dob_m_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <label class="col-form-label">Year</label>
                        <select id="dob_yar_sel" class="form-control"></select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="er_dob_y_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-3">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="m" type="radio" id="rg_gender_m" name="rg_gender" class="custom-control-input"/>
                            <label class="custom-control-label" for="rg_gender_m">Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input value="f" type="radio" id="rg_gender_f" name="rg_gender" class="custom-control-input"/>
                            <label class="custom-control-label" for="rg_gender_f">Female</label>
                        </div>
                        <div id="gder"></div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
                    </div>
                    <div class="col">
                        <label class="col-sm-2 col-form-label country_sel">Country</label>&nbsp;&nbsp;
                        <select class="col country_sel form-control" id="rg_country_sel"/>
                            <option value="">--</option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select.
                        </div>
                    </div>                
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="register_agree_toc" required/>
                        <label class="form-check-label">
                            I have read and agree to <a onclick="$('#mdl_tnc').modal('show');" href=#"">terms and conditions</a>
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <button id="spnx" class="btn btn-primary btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="btnx" onclick="regValidation();" type="button" class="btn btn-primary btn-lg btn-block">Next</button>
                <button onclick="gotoLogin();" type="button" class="btn btn-secondary btn-lg btn-block">Back to login</button>
            </div>
            <div id="div_register_validation">
                <center><h2>Email Validation</h2></center>
                <p>we have sent the validation code to your email.</p>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" readonly class="form-control-plaintext" id="reg_val_email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rg_vc" class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="rg_vc">
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
                <center>
                    <button id="sprg" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button id="btrg" onclick="register();" type="button" class="btn btn-primary btn-lg">Register</button>
                    <button onclick="gotoRegister();" type="button" class="btn btn-secondary btn-lg">Go Back</button>
                </center>
            </div>
        </div>
        <div id="mdl_tnc" class="modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">terms and Condition</h5>
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
        <script src="../js/login_register.js" type="text/javascript"></script>
        <script src="../../js_framework/dob_list.js" type="text/javascript"></script>
        <?php
        $cp=$xmldata->PassCap;
        $pl=$xmldata->MinPassLength;
        echo "<script>capPsw=$cp;mlPsw=$pl;</script>";
        ?>
    </body>
</html>