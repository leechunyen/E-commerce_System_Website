<?php
include './php_framework/function.php';
checkSetup()
?>
<html ng-app="myApp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./bootstrap_4.4.1_dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <style>
            body{
                margin-top: 15%;
                text-align: center;
            }
            .btn{
                font-size: 50px;
                margin: 0 10px;
                width: 200px;
                height: 200px;
            }
        </style>
    </head>
    <body>
        
        
        
        
        
        <h1>Welcome to developer mode</h1>
        <h2>select to continue</h2>
        <div class="btn-group" role="group" aria-label="Welcome">
            <button onclick='location.href="./u/index.php";' type="button" class="btn btn-secondary">User</button>
            <button onclick='location.href="./a/index.php";' type="button" class="btn btn-secondary">Admin</button>
        </div>
    </body>
</html>