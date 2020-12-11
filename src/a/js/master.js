let app = angular.module("myApp", ['ngRoute','routeStyles' ]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "./home.php",
        css : "../css/home.css"
    })
    .when("/system-setting", {
        templateUrl : "../pages/system_setting.php",
        css : "../css/system_setting.css"
    })
    .when("/manage-admin", {
        templateUrl : "../pages/manage_admin.php"
    })
    .when("/manage-user", {
        templateUrl : "../pages/manage_user.php",
        css : "../css/manage_user.css"
    })
    .when("/manage-shipping-method", {
        templateUrl : "../pages/manage_shipping_method.php",
        css : "../css/manage_shipping_method.css"
    })
    .when("/manage-product", {
        templateUrl : "../pages/manage_product.php",
        css : "../css/manage_product.css"
    })
    .when("/product", {
        templateUrl : function(){return"../../ua/pages/product.php"+getAllUrlParameter();},
        css : "../../ua/css/product.css"
    })
    .when("/manage-coupon-type", {
        templateUrl : "../pages/manage_coupon_type.php",
        css : "../css/manage_coupon_type.css"
    })
    .when("/profile-setting",{
        templateUrl : function(){return"../../ua/pages/profile_setting.php?m="+checkFrom();},
        css : "../../ua/css/profile_setting.css"
    })
    .when("/manage-order", {
        templateUrl : "../pages/manage_order.php",
        css : "../css/manage_order.css"
    })
    .when("/manage-purchase", {
        templateUrl : "../pages/manage_purchase.php",
        css : "../css/home.css"
    })
    .when("/purchase-low-stock", {
        templateUrl : "../pages/purchase_low_stock.php",
        css : "../css/purchase.css"
    })
    .when("/purchase-purchased", {
        templateUrl : "../pages/purchase_purchased.php",
        css : "../css/purchase.css"
    })
    .when("/purchase-supplier", {
        templateUrl : "../pages/purchase_supplier.php"
    })
    .otherwise ({
        redirectTo: '/'
    });
});
function goTo(name){
    location.href='#!'+name;
}