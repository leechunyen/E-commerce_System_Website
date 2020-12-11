let d = new Date();
const rc=d.getHours()+''+d.getMinutes()+''+d.getSeconds()+''+d.getMilliseconds()+''+Math.floor(Math.random()*100000)+100000;
var cap;var pml;
mode=getRequest('mode');
if(mode===''||mode===null){mode='u';}
function next(){
    let acc=$('#looking_acc_ip').val();
    if(acc===null||acc===''){
        $('#accermg').html(epfl);
        $('#looking_acc_ip').removeClass('is-valid');
        $('#looking_acc_ip').addClass('is-invalid');
    }else if(isSpecialCharacter(acc)){
        $('#accermg').html(stal);
        $('#looking_acc_ip').removeClass('is-valid');
        $('#looking_acc_ip').addClass('is-invalid');
    }else{
        $('#btlacc').hide();
        $('#splacc').show();
        disableResend30s();
        $.post('../php_files/looking_acc.php',
        {acc:acc,md:mode,rc:rc},
        function(data){
            $('#splacc').hide();
            $('#btlacc').show();
            if(!validateEmail(data)){
                $('#accermg').html(data);
                $('#looking_acc_ip').removeClass('is-valid');
                $('#looking_acc_ip').addClass('is-invalid');
            }else{
                $('#looking_acc_ip').removeClass('is-invalid');
                $('#looking_acc_ip').addClass('is-valid');
                $('#reg_val_email').val(data);
                $('#looking_acc').hide();
                $('#email_validation').show();
            }
        });
    }
}
function resendCode(){
    disableResend30s();
    let em=$('#reg_val_email').val();
    $.post('../php_files/resend_validation_code.php',
    {rc:rc,em:em,md:mode},
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
function back_looking_acc(){
    $('#looking_acc_ip').removeClass('is-invalid');
    $('#looking_acc_ip').removeClass('is-valid');
    $('#email_validation').hide();
    $('#reset_password').hide();
    $('#looking_acc').show();
}
function goto_reset(){
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
        $.post('../php_files/validation_code_validate.php',
        {vc:vc,rc:rc},
        function(data){
            $('#bt_vc').show();
            $('#spvc').hide();
            if(data===''){
                $('#email_validation').hide();
                $('#looking_acc').hide();
                $('#reset_password').show();
            }else{
                $('#er_vc_mg').html(data);
                $('#ip_vc').removeClass('is-valid');
                $('#ip_vc').addClass('is-invalid');
            }
        });
    }
}
function reset(){
    let nwpass=$('#new_password').val();
    let cfpass=$('#confirm_password').val();
    if(nwpass===null||nwpass===''||cfpass===null||cfpass===''){
        if(nwpass===null||nwpass===''){
            $('#new_password').removeClass('is-valid');
            $('#new_password').addClass('is-invalid');
        }
        if(cfpass===null||cfpass===''){
            $('#confirm_password').removeClass('is-valid');
            $('#confirm_password').addClass('is-invalid');
        }
        $('#er_pass_mg').html(epfl);
        $('#pass_error').removeClass('is-valid');
        $('#pass_error').addClass('is-invalid');
    }else if((nwpass.length<pml)||(cap==='true'&&!isUppercaseIncluded(nwpass))){
        var ms='Minimum password length is '+pml;
        if(cap==='true'){ms+=' and uppercase required';}
        $('#er_pass_mg').html(ms+'.');
        $('#new_password').removeClass('is-valid');
        $('#new_password').addClass('is-invalid');
        $('#pass_error').removeClass('is-valid');
        $('#pass_error').addClass('is-invalid');
    }else if(nwpass!==cfpass){
        $('#er_pass_mg').html(pwnm);
        $('#new_password').removeClass('is-valid');
        $('#confirm_password').removeClass('is-valid');
        $('#pass_error').removeClass('is-valid');
        $('#pass_error').addClass('is-invalid');
        $('#confirm_password').addClass('is-invalid');
        $('#new_password').addClass('is-invalid');
    }else{
        $('#pass_error').removeClass('is-invalid');
        $('#pass_error').addClass('is-valid');
        $('#btreset').hide();
        $('#spreset').show();
        $.post('../php_files/reset_password_action.php',
        {rc:rc,pass:nwpass},
        function(data){
            if(data===''){
                alert('Password has been reset.');
                window.history.back();
            }else if(data===1){
                alert('Please try again later.');
                $('#pass_error').removeClass('is-valid');
                $('#pass_error').removeClass('is-invalid');
                back_looking_acc();
            }else{
                $('#er_pass_mg').html(data);
                $('#pass_error').removeClass('is-valid');
                $('#pass_error').addClass('is-invalid');
            }
        });
    }
}