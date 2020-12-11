<?php
require '../../php_framework/function.php';
checkSetup();
if(isset($_REQUEST['mode'])&&$_REQUEST['mode']=='adm'&&isset($_SESSION['aid'])&&isset($_SESSION['type'])){
    header('Location: ../../a/pages/master.php');
}else if(!isset($_REQUEST['mode'])&&isset ($_SESSION['uid'])){
    header('Location: ../../u/pages/index.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/reset_password.css" rel="stylesheet" type="text/css"/>
        <script src="../../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../../js_framework/function.js" type="text/javascript"></script>
        <script src="../../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="ctn">
            <center><h2>Reset Password</h2></center>
            <div id="looking_acc">
                <div class="form-group row">
                    <label for="looking_acc_ip" class="col-sm-3 col-form-label col-form-label-sm">Account</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="looking_acc_ip" placeholder="Username / Email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="accermg" class="invalid-feedback"></div>
                    </div>
                </div>
                <center>
                    <button id="splacc" class="btn btn-primary btn-lg btn-block" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button id="btlacc" onclick="next();" type="button" class="btn btn-primary btn-lg btn-block">Next</button>
                    <button onclick="location.href='../index.php';" type="button" class="btn btn-secondary btn-lg btn-block">Goto Login</button>
                </center>
            </div>
            <div id="email_validation">
                <p>we have sent the validation code to your email.</p>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="reg_val_email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="validation_code" class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="validation_code">
                            <div id="ip_vc" class="input-group-append">
                                <button onclick="resendCode();" class="btn btn-outline-secondary" type="button" id="bt_resend_code">Resend</button>
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="er_vc_mg" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <center>
                    <button id="spvc" class="btn btn-primary btn-lg" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button id="bt_vc" onclick="goto_reset();" type="button" class="btn btn-primary btn-lg">Reset</button>
                    <button onclick="back_looking_acc();" type="button" class="btn btn-secondary btn-lg">Cancel</button>
                </center>
            </div>
            <div id="reset_password">
                <div class="form-group row">
                    <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="new_password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="confirm_password">
                    </div>
                </div>
                <div id="pass_error"></div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="er_pass_mg" class="invalid-feedback"></div>
                <center>
                    <button id="spreset" class="btn btn-primary btn-lg" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button id="btreset" onclick="reset();" type="button" class="btn btn-primary btn-lg">Reset</button>
                    <button onclick="back_looking_acc();" type="button" class="btn btn-secondary btn-lg">Cancel</button>
                </center>
            </div>
        </div>
        <script src="../js/reset_password.js" type="text/javascript"></script>
        <?php
        $xml=loadSystemSettingFile();
        echo"<script>cap='".$xml->PassCap."';pml=".$xml->MinPassLength.";</script>";
        ?>
    </body>
</html>