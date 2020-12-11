<?php
require '../../php_framework/function.php';
checkAdminLogin();
$val=$_SESSION["aid"];
$col='ID';
$tb='admin';
$photo=getValByEmUsn($conn,$maxCacheItem,$tb,$col,$val,'Photo');
?>
<html ng-app="myApp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../plug_in/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../plug_in/DateTimePickerBootstrap4/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../plug_in/venobox/venobox.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/master.css" rel="stylesheet" type="text/css"/>
        <script src="../../js_framework/jQuery3.4.1.js" type="text/javascript"></script>
        <script src="../../js_framework/angular-js-1.8.0-min.js" type="text/javascript"></script>
        <script src="../../js_framework/angular-route-1.8.0-min.js" type="text/javascript"></script>
        <script src="../../js_framework/route-styles.js" type="text/javascript"></script>
        <script src="../../js_framework/function.js" type="text/javascript"></script>
        <script src="../../bootstrap_4.4.1_dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../plug_in/DateTimePickerBootstrap4/js/moment_2.21.0.min.js" type="text/javascript"></script>
        <script src="../../plug_in/DateTimePickerBootstrap4/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="../../plug_in/venobox/venobox.min.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <a id="title_bar" class="navbar-brand" href="#!/">
                <img id="logo" src="<?php echo $logo;?>" width="30" height="30" class="d-inline-block align-top" alt="logo" >
                <label id="site_title"><?php echo$title;?></label>
            </a>
            <div id="page_title"></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto form-inline my-2 my-lg-0">
                </div>
                <div class="form-inline">
                    <button onclick="goTo('profile-setting');" type="button" class="btn btn-secondary">
                        <img id="pro_pho" src="../..<?php if($photo==null||$photo==''){echo'/img/df_user.png';}else{echo$photo;}?>" alt="photo"/>
                        Profile
                    </button>
                    <button onclick="logOut(2);" type="button" class="btn btn-secondary">Logout</button>
                </div>
            </div>
        </nav>
        <script src="../js/master.js" type="text/javascript"></script>
        <div id="page_view" ng-view></div>
    </body>
</html>