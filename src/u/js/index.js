var app = angular.module("myApp", ['ngRoute','routeStyles' ]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/",{
        templateUrl : "./home.php",
        css : "../css/home.css"
    })
    .when("/cart",{
        templateUrl : "./cart.php",
        css : "../css/cart.css"
    })
    .when("/wishlist",{
        templateUrl : "./wishlist.php",
        css : "../css/wishlist.css"
    })
    .when("/product",{
        templateUrl : function(){return"../../ua/pages/product.php"+getAllUrlParameter();},
        css : "../../ua/css/product.css"
    })
    .when("/profile-setting",{
        templateUrl : function(){return"../../ua/pages/profile_setting.php?m="+checkFrom();},
        css : "../../ua/css/profile_setting.css"
    })
    .when("/shipping-address",{
        templateUrl : "./shipping_address.php",
        css : "../css/shipping_address.css"
    })
    .when("/order",{
        templateUrl : "./order.php",
        css : "../css/order.css"
    })
    .when("/search",{
        templateUrl : "./search.php",
        css : "../css/search.css"
    })
    .when("/coupon",{
        templateUrl : "./coupon.php",
        css : "../css/coupon.css"
    })
    .otherwise ({
        redirectTo: '/'
    });
});
$('.modal').on('hide.bs.modal', function () {
    $('.modal .form-control').removeClass('is-valid').removeClass('is-invalid');
    $('.modal .form-control').val('');
});
function login(){
   let acc=$('#lg_acc').val();
   let psw=$('#lg_psw').val();
   var pass=true;
   if(acc===null||acc===''){
       pass=false;
       $('#lg_acc').removeClass('is-valid');
       $('#lg_acc').addClass('is-invalid');
   }else if(acc.length>100){
       pass=false;
       $('#lg_acc').removeClass('is-valid');
       $('#lg_acc').addClass('is-invalid');
   }else if(isSpecialCharacter(acc)){
       pass=false;
       $('#lg_acc').removeClass('is-valid');
       $('#lg_acc').addClass('is-invalid');
   }else{
       $('#lg_acc').removeClass('is-invalid');
       $('#lg_acc').addClass('is-valid');
   }
   if(psw===null||psw===''){
       pass=false;
       $('#lg_psw').removeClass('is-valid');
       $('#lg_psw').addClass('is-invalid');
   }else if(psw.length>80){
       pass=false;
       $('#lg_psw').removeClass('is-valid');
       $('#lg_psw').addClass('is-invalid');
   }else{
       $('#lg_psw').removeClass('is-invalid');
       $('#lg_psw').addClass('is-valid');
   }
   if(pass){
       $('#btlg').hide();
       $('#splg').show();
        $.post('../php_files/login_user.php',
        {acc:acc,psw:psw},
        function(data){
            let js=$.parseJSON(data);
            if(js[0]===1){location.reload();}
            else if(js[0]===3){location.href='./activate_account.php?uid='+js[1];}
            else if(js[0]===0||js[0]===2){
                if(js[0]===0){$('#lg_er_mg').html('Login fail please try again.');}
                else if(js[0]===2){$('#lg_er_mg').html('Account Locked.');}
                $('#lg_acc').removeClass('is-valid');
                $('#lg_acc').addClass('is-invalid');
                $('#lg_psw').removeClass('is-valid');
                $('#lg_psw').addClass('is-invalid');
                $('#lg_er_disp').removeClass('is-valid');
                $('#lg_er_disp').addClass('is-invalid');
                $('#splg').hide();
                $('#btlg').show();
            }
        });
   }
}
$('#loginModal').on('keydown','.form-control',function(e){
    if(e.which === 13){login();}
});
function gotoPorduct(id){
    location.href="#!product?id="+id;
}
function searchProduct(){
    let se=$('#seportxip').val();
    if(se===null||se===''){
        $('#seportxip').addClass('is-invalid');
    }else{
        $('#seportxip').removeClass('is-invalid');
        location.href="#!search?sec="+se;
        $('#seportxip').val('');
    }
}