<?php
require '../../php_framework/function.php';
$https=false;
if(isset($_SERVER["HTTPS"])){$https=true;}else{$https=false;}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/first_setup.css" rel="stylesheet" type="text/css"/>
        <script src="../../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../js_framework/function.js" type="text/javascript"></script>
        <script src="../../js_framework/CommonCurrency.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="ctn">
            <nav>
                <ul class="pagination pagination-lg">
                    <li onclick="goToS1();" id="st1" class="page-item active" >
                        <a class="page-link">1</a>
                    </li>
                    <li onclick="goToS2();" id="st2" class="page-item ">
                        <a class="page-link">2</a>
                    </li>
                    <li onclick="goToS3();" id="st3" class="page-item">
                        <a class="page-link">3</a>
                    </li>
                </ul>
            </nav>
            <session id="s1"><!--System Setting and DB-->
                <div id="prf">
                    <center><h2>System Configuration</h2></center>
                    <div class="form-group row">
                        <label for="site_title" class="col-sm-2 col-form-label">Site Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="site_title" placeholder="Site Title" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="site_title_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="min_pass" class="col-sm-2 col-form-label">Minimum Password Length</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="min_pass" placeholder="Minimum Password Length" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="pass_lg_invalid_mg" class="invalid-feedback"></div>
                        </div>
                        <label class="col-sm-2 col-form-label">Password capital</label>
                        &nbsp;&nbsp;
                        <div class="custom-control custom-switch">
                            <input onchange="swHPassCap();" type="checkbox" class="custom-control-input" id="pass_cap_sw">
                            <label id="pass_cap_st" class="custom-control-label" for="pass_cap_sw">Disabled</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Site Logo</label>
                        <div class="col-sm-2">
                            <div id="logo_ctn" class="container">
                                <img id="iv_tmp_logo" src="../../img/tmp_img.png" alt="logo" class="image">
                                <div class="middle">
                                    <label for="logo_file" id="sel_img_btn" class="btn btn-primary">Upload</label>
                                    <input onchange="displayLogo();" id="logo_file" accept="image/jpg,image/jpeg,image/png" type="file"/>
                                </div>
                            </div><br/><br/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please upload logo.
                            </div>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="col-sm-3 col-form-label">User Team of condition</label>
                        <div class="col-sm-2">
                            <label for="usr_toc_file" id="sel_toc_btn" class="btn btn-primary">Upload</label>
                            <input onchange="uploadToc();" id="usr_toc_file" accept=".txt" type="file"/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please upload tnc.
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Force HTTPS</label>
                        <div class="col-sm-3">
                            <div class="custom-control custom-switch">
                                <input id="https_sw" onchange="swHTTPS();" <?php if(!$https){echo'disabled';}?> type="checkbox" class="custom-control-input">
                                <label id="swst" class="custom-control-label" for="https_sw">Disabled</label>
                            </div>
                            <?php if(!$https){?>
                            <a href='<?php echo "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];?>'>Goto HTTPS</a>
                            <?php }?>
                        </div>
                        <div class="col-sm-7">
                            <label class="col-sm-3 col-form-label">Currency</label>
                            <select id="sel_currency" class="sel_currency">
                                <option value=''>--</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">Please select.</div>
                        </div>
                    </div>
                </div>
                <div id="db">
                    <center><h2>Database Configuration</h2></center>
                    <div class="form-group row">
                        <label for="db_host" class="col-sm-2 col-form-label">Host / port</label>
                        <div class="col">
                            <input type="text" class="form-control" id="db_host" placeholder="Host" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="db_host_invalid_mg" class="invalid-feedback"></div>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="db_porrt" value="3306" placeholder="Port" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="db_port_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="db_username" placeholder="Username" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="db_usn_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="db_password" placeholder="Password" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="db_pass_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_name" class="col-sm-2 col-form-label">Database Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="db_name" placeholder="Database Name" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="db_name_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <button onclick="goToS2();" type="button" class="btn btn-primary btn-lg btn-block">Next</button>
            </session>
            <session id="s2">
                <div><!--Email Server Setting-->
                    <center><h2>Mail Server Configuration</h2></center>
                    <div class="form-group row">
                        <label for="smtp_host" class="col-sm-2 col-form-label">Host / port</label>
                        <div class="col">
                            <input type="text" class="form-control" id="smtp_host" placeholder="Host" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="smtp_host_invalid_mg" class="invalid-feedback"></div>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="smtp_porrt" placeholder="Port" required/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="smtp_port_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_secure" class="col-sm-2 col-form-label">SMTP Secure</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="smtp_secure" placeholder="SMTP Secure" required/>
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
                                <input disabled checked type="checkbox" class="custom-control-input" id="sw_mail_auth">
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
                <div><!--PayPal payment configuration-->
                    <center><h2>PayPal Payment Configuration</h2></center>
                     <div class="form-group row">
                        <label for="ppapi" class="col-sm-2 col-form-label">Client ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ppapi" placeholder="Client ID"/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ppapi_invalid_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <button onclick="goToS3();" type="button" class="btn btn-primary btn-lg btn-block">Next</button>
                <button onclick="goToS1();" type="button" class="btn btn-secondary btn-lg btn-block">Go Back</button>
            </session>
            <session id="s3"><!--User-->
                <center><h2>Create Super User Account</h2></center>
                <div class="form-group row">
                    <label for="register_first_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col">
                        <input type="text" class="form-control" id="register_first_name" placeholder="First Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="user_fn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="register_last_name" placeholder="Last Name" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="user_ln_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="register_username" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="register_username" placeholder="Username" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="user_usn_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="register_email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="register_email" placeholder="Email" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="register_email_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="register_password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="register_password" placeholder="Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="register_pass_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="register_confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="register_confirm_password" placeholder="Confirm Password" required/>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="register_cfpass_invalid_mg" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-3">
                        <div id="register_gd">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="m" type="radio" id="register_gender_m" name="register_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="register_gender_m">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input value="f" type="radio" id="register_gender_f" name="register_gender" class="custom-control-input"/>
                                <label class="custom-control-label" for="register_gender_f">Female</label>
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
                <button id="sp" class="btn btn-primary btn-lg btn-block" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button onclick="done();" type="button" class="btn btn-primary btn-lg btn-block" id="btn_done">Done</button>
                <button onclick="goToS2();" type="button" class="btn btn-secondary btn-lg btn-block">Go Back</button>
            </session>
            <script src="../js/first_setup.js" type="text/javascript"></script>
        </div>
    </body>
</html>