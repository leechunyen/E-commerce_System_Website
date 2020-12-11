let d = new Date();const uid=getRequest('uid');
const rc=d.getHours()+''+d.getMinutes()+''+d.getSeconds()+''+d.getMilliseconds()+''+Math.floor(Math.random()*100000)+100000;
chechUserAndSendCode();
function chechUserAndSendCode(){
    disableResend30s();
    $.post('../php_files/check_id_send_code.php',
    {uid:uid,rc:rc},
    function(data){
        let arr=$.parseJSON(data);
        $('#reg_val_email').val(arr[0]);
        $('#spld').hide();
        $('#email_validation').show();
    });
}
function resendCode(){
    disableResend30s();
    let em=$('#reg_val_email').val();
    $.post('../../ua/php_files/resend_validation_code.php',
    {rc:rc,em:em,dt:uid},
    function(data){
        if(data!==''){
            $('#er_vc_mg').html(data);
            $('#ip_vc').removeClass('is-valid');
            $('#ip_vc').addClass('is-invalid');
        }
    });
}
function disableResend30s(){
    $('#bt_resend_code').prop("disabled",true);
    var counter = 30;
    setInterval(function(){
        counter--;
        if (counter>=0) {
           $('#bt_resend_code').html('Resend'+'('+counter+')');
        }
        if (counter===0) {
            clearInterval(counter);
            $('#bt_resend_code').prop( "disabled",false);
            $('#bt_resend_code').html('Resend');
        }
    }, 1000);
}
function cancel(){
    location.href='./index.php';
}
function activate(){
    let vc=$('#validation_code').val();
    if(vc===null||vc===''){
        $('#er_vc_mg').html(epfl);
        $('#ip_vc').removeClass('is-valid');
        $('#ip_vc').addClass('is-invalid');
    }else if(isNaN(vc)){
        $('#er_vc_mg').html(ivvc);
        $('#ip_vc').removeClass('is-valid');
        $('#ip_vc').addClass('is-invalid');
    }else{
        $('#bt_vc').hide();
        $('#spvc').show();
        $.post('../php_files/validate_activate_account.php',
        {vc:vc,rc:rc},
        function(data){
            $('#bt_vc').show();
            $('#spvc').hide();
            if(data==='0'){
                alert('Account activated plaese login.');
                location.href='./login_register.php';
            }else if(data==='1'){
                $('#er_vc_mg').html(ivvc);
                $('#ip_vc').removeClass('is-valid');
                $('#ip_vc').addClass('is-invalid');
            }else{
                alert(data);
            }
        });
    }
}