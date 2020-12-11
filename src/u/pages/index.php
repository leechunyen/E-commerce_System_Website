<?php
include '../../php_framework/function.php';
checkSetup();
$login=checkUserLogin(false);
?>
<html ng-app="myApp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../plug_in/venobox/venobox.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/index.css" rel="stylesheet" type="text/css"/>
        <script src="../../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../../js_framework/angular-js-1.8.0-min.js" type="text/javascript"></script>
        <script src="../../js_framework/angular-route-1.8.0-min.js" type="text/javascript"></script>
        <script src="../../js_framework/route-styles.js" type="text/javascript"></script>
        <script src="../../js_framework/function.js" type="text/javascript"></script>
        <script src="../../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../plug_in/venobox/venobox.min.js" type="text/javascript"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=<?php echo$ppapi;?>&currency=<?php echo$xmldata->Currency;?>"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <a id="sitetitle" class="navbar-brand" href="#!/">
                <img src="<?php echo$logo;?>" width="30" height="30" class="d-inline-block align-top" alt="logo" >
                <?php echo$title;?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="mr-auto form-inline my-2 my-lg-0">
                    <input id="seportxip" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button onclick="searchProduct();" class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
                <div class="form-inline">
                    <button onclick="location.href='#!cart';" type="button" class="btn btn-secondary">Cart</button>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          profile
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#!profile-setting">Profile Setting</a>
                          <a class="dropdown-item" href="#!shipping-address">Shipping Address</a>
                          <a class="dropdown-item" href="#!wishlist">Wishlist</a>
                          <a class="dropdown-item" href="#!coupon">Coupon</a>
                          <a class="dropdown-item" href="#!order">Order</a>
                        </div>
                    </div>
                    <?php
                    if(!$login){
                    ?>
                    <button onclick="$('#loginModal').modal('show');" type="button" class="btn btn-secondary">Login/Register</button>
                    <?php
                    }else{
                    ?>
                    <button onclick="logOut(1);" type="button" class="btn btn-secondary">LogOut</button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
        <div id="loginModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Login</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="lg_acc" class="col-sm-2 col-form-label col-form-label-sm">Account</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="lg_acc" placeholder="Username / Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lg_psw" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="lg_psw" placeholder="Password">
                            </div>
                        </div>
                        <div id="lg_er_disp"></div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="lg_er_mg" class="invalid-feedback"></div>
                        <center>
                            <button id="btlg" onclick="login();" type="button" class="btn btn-primary">Login</button>
                            <button id="splg" class="hide btn btn-primary" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button onclick="location.href='./login_register.php?mode=register'" type="button" class="btn btn-secondary">Register</button>
                            <br/><a style="margin-left: -30px;" href="../../ua/pages/reset_password.php">Reset Password?</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div id="page_view" ng-view></div>
        
        <script src="../js/index.js" type="text/javascript"></script>
    </body>
</html>