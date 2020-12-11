<?php
require '../php_framework/function.php';
if(checkSetup()){checkAdminLogin();}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="./css/index-login.css" rel="stylesheet" type="text/css"/>
        <script src="../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js_framework/function.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="ctn">
            <div id="div_login">
                <center><h2>Login</h2></center>
                <div class="form-group row">
                    <label for="login_account" class="col-sm-2 col-form-label col-form-label-sm">Account</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="login_account" placeholder="Username / Email"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="login_password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="login_password" placeholder="Password"/>
                    </div>
                </div>
                <div id="pass_div"></div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="login_invalid_mg" class="invalid-feedback"></div>
                <center>
                    <button id="lg_sp" class="btn btn-primary btn-lg" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button onclick="login();" id="btn_login" type="button" class="btn btn-primary btn-lg">Login</button>
                    <br/><a href="../ua/pages/reset_password.php?mode=sysadm">Reset Password?</a>
                </center>
            </div>
        </div>
        <script src="./js/index-login.js" type="text/javascript"></script>
    </body>
</html>