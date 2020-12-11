function login(){
    let acc=$('#login_account').val();
    let pass=$('#login_password').val();
    if((acc===null||acc==='')||(pass===null||pass==='')){
        $('#login_invalid_mg').html('Please fill.');
        $('#login_account').removeClass('is-valid');
        $('#login_password').removeClass('is-valid');
        $('#pass_div').removeClass('is-valid');
        $('#login_account').addClass('is-invalid');
        $('#login_password').addClass('is-invalid');
        $('#pass_div').addClass('is-invalid');
    }else if(acc.length>100||pass.length>80){
        $('#login_invalid_mg').html('Invalid login info.');
        $('#login_account').removeClass('is-valid');
        $('#login_password').removeClass('is-valid');
        $('#pass_div').removeClass('is-valid');
        $('#login_account').addClass('is-invalid');
        $('#login_password').addClass('is-invalid');
        $('#pass_div').addClass('is-invalid');
    }else if(isSpecialCharacter(acc)){
        $('#login_invalid_mg').html('Please use standard alphanumerics for the Account.');
        $('#login_account').removeClass('is-valid');
        $('#login_password').removeClass('is-valid');
        $('#pass_div').removeClass('is-valid');
        $('#login_account').addClass('is-invalid');
        $('#login_password').addClass('is-invalid');
        $('#pass_div').addClass('is-invalid');
    }else{
        $('#login_account').removeClass('is-invalid');
        $('#login_password').removeClass('is-invalid');
        $('#pass_div').removeClass('is-invalid');
        $('#login_account').addClass('is-valid');
        $('#login_password').addClass('is-valid');
        $('#pass_div').addClass('is-valid');
        $('#btn_login').hide();
        $('#lg_sp').show();
        $.post('./php_files/admin_login.php',
        {acc:acc,pass:pass},
        function(data){
            if(data!==''){
                $('#login_invalid_mg').html(data);
                $('#login_account').removeClass('is-valid');
                $('#login_password').removeClass('is-valid');
                $('#pass_div').removeClass('is-valid');
                $('#login_account').addClass('is-invalid');
                $('#login_password').addClass('is-invalid');
                $('#pass_div').addClass('is-invalid');
                $('#lg_sp').hide();
                $('#btn_login').show();
            }else{
                let rt=getRequest('ret');
                if(rt!==''){location.href='./pages/master.php#!'+rt;}
                else{location.href='./pages/master.php';}
            }
        });
    }
}
$('#div_login').on('keydown','.form-control',function(e){
    if(e.which === 13){
        login();
    }
});