if(getRequest('mode')==='register'){
    gotoRegister();
}
else if(getRequest('mode')==='login'){
    gotoLogin();
}
var capPsw;var mlPsw;let cryr=new Date().getFullYear();
let dt=new Date();
let rc=dt.getHours()+''+dt.getMinutes()+''+dt.getSeconds()+''+dt.getMilliseconds()+''+Math.floor(Math.random()*100000)+100000;
for(const property in countryListAlpha2) {
    getElementID('rg_country_sel').innerHTML+=`<option value='${property}'>${countryListAlpha2[property]}</option>`;
}
function gotoRegister(){
    $('#div_login').hide();
    $('#div_register_validation').hide();
    $('#div_register').show();
}
function gotoLogin(){
    $('#div_register').hide();
    $('#div_register_validation').hide();
    $('#div_login').show();
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
function resendVC(){
    disableResend30s();
    let em=$('#reg_val_email').val();
    $('#rg_vc').removeClass('is-invalid');
    $('#rg_vc').removeClass('is-valid');
    $('#div_rsvc').removeClass('is-invalid');
    $('#div_rsvc').removeClass('is-valid');
    $.post('../../ua/php_files/resend_validation_code.php',
    {rc:rc,em:em},
    function(data){
        if(data!==''){
            $('#er_vc_mg').html(data);
            $('#div_rsvc').removeClass('is-valid');
            $('#div_rsvc').addClass('is-invalid');
        }
    });
}
function regValidation(){
    var pass=true;
    let rg_fn=$('#rg_fn').val();
    let rg_ln=$('#rg_ln').val();
    let rg_usn=$('#rg_usn').val();
    let rg_em=$('#rg_em').val();
    let rg_psw=$('#rg_psw').val();
    let rg_cpsw=$('#rg_cpsw').val();
    let rg_dobd=$('#dob_day_sel').val();
    let rg_dobm=$('#dob_mon_sel').val();
    let rg_doby=$('#dob_yar_sel').val();
    let rg_gd=$('input[name="rg_gender"]:checked').val();
    let rg_ctry=$('#rg_country_sel').val();
    if(rg_fn===null||rg_fn===''){
        pass=false;
        $('#er_fn_mg').html(epfl);
        $('#rg_fn').removeClass('is-valid');
        $('#rg_fn').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_fn)){
        pass=false;
        $('#er_fn_mg').html(stal);
        $('#rg_fn').removeClass('is-valid');
        $('#rg_fn').addClass('is-invalid');
    }else if(rg_fn.length>50){
        pass=false;
        $('#er_fn_mg').html(maxCharacterMessage(50));
        $('#rg_fn').removeClass('is-valid');
        $('#rg_fn').addClass('is-invalid');
    }else{
        $('#rg_fn').removeClass('is-invalid');
        $('#rg_fn').addClass('is-valid');
    }
    if(rg_ln===null||rg_ln===''){
        pass=false;
        $('#er_ln_mg').html(epfl);
        $('#rg_ln').removeClass('is-valid');
        $('#rg_ln').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_ln)){
        pass=false;
        $('#er_ln_mg').html(stal);
        $('#rg_ln').removeClass('is-valid');
        $('#rg_ln').addClass('is-invalid');
    }else if(rg_ln.length>50){
        pass=false;
        $('#er_ln_mg').html(maxCharacterMessage(50));
        $('#rg_ln').removeClass('is-valid');
        $('#rg_ln').addClass('is-invalid');
    }else{
        $('#rg_ln').removeClass('is-invalid');
        $('#rg_ln').addClass('is-valid');
    }
    if(rg_usn===null||rg_usn===''){
        pass=false;
        $('#er_usn_mg').html(epfl);
        $('#rg_usn').removeClass('is-valid');
        $('#rg_usn').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_usn)){
        pass=false;
        $('#er_usn_mg').html(stal);
        $('#rg_usn').removeClass('is-valid');
        $('#rg_usn').addClass('is-invalid');
    }else if(rg_usn.length>50){
        pass=false;
        $('#er_usn_mg').html(maxCharacterMessage(50));
        $('#rg_usn').removeClass('is-valid');
        $('#rg_usn').addClass('is-invalid');
    }else{
        $('#rg_usn').removeClass('is-invalid');
        $('#rg_usn').addClass('is-valid');
    }
    if(rg_em===null||rg_em===''){
        pass=false;
        $('#er_em_mg').html(epfl);
        $('#rg_em').removeClass('is-valid');
        $('#rg_em').addClass('is-invalid');
    }else if(!validateEmail(rg_em)||isSpecialCharacter(rg_em)){
        pass=false;
        $('#er_em_mg').html(ivem);
        $('#rg_em').removeClass('is-valid');
        $('#rg_em').addClass('is-invalid');
    }else if(rg_em.length>100){
        pass=false;
        $('#er_em_mg').html(maxCharacterMessage(100));
        $('#rg_em').removeClass('is-valid');
        $('#rg_em').addClass('is-invalid');
    }else{
        $('#rg_em').removeClass('is-invalid');
        $('#rg_em').addClass('is-valid');
    }
    if(rg_psw===null||rg_psw===''){
        pass=false;
        $('#er_psw_mg').html(epfl);
        $('#rg_psw').removeClass('is-valid');
        $('#rg_psw').addClass('is-invalid');
    }else if((capPsw&&!isUppercaseIncluded(rg_psw))||(rg_psw.length<mlPsw)){
        pass=false;
        var ms='Minimum password length is '+mlPsw;
        if(capPsw){ms+=' and uppercase required';}
        $('#er_psw_mg').html(ms+'.');
        $('#rg_psw').removeClass('is-valid');
        $('#rg_psw').addClass('is-invalid');
    }else if(rg_psw.length>80){
        pass=false;
        $('#er_psw_mg').html(maxCharacterMessage(80));
        $('#rg_psw').removeClass('is-valid');
        $('#rg_psw').addClass('is-invalid');
    }else{
        $('#rg_psw').removeClass('is-invalid');
        $('#rg_psw').addClass('is-valid');
    }
    if(rg_cpsw===null||rg_cpsw===''){
        pass=false;
        $('#er_cpsw_mg').html(epfl);
        $('#rg_cpsw').removeClass('is-valid');
        $('#rg_cpsw').addClass('is-invalid');
    }else if(rg_cpsw.length>80){
        pass=false;
        $('#er_cpsw_mg').html(maxCharacterMessage(80));
        $('#rg_cpsw').removeClass('is-valid');
        $('#rg_cpsw').addClass('is-invalid');
    }else if(rg_cpsw!==rg_psw){
        pass=false;
        $('#er_cpsw_mg').html(pwnm);
        $('#rg_cpsw').removeClass('is-valid');
        $('#rg_cpsw').addClass('is-invalid');
    }else{
        $('#rg_cpsw').removeClass('is-invalid');
        $('#rg_cpsw').addClass('is-valid');
    }
    if((rg_dobd===null||rg_dobd==='')||(rg_dobm===null||rg_dobm==='')||(rg_doby===null||rg_doby==='')){
        if(rg_dobd===null||rg_dobd===''){
            pass=false;
            $('#er_dob_d_mg').html(plsl);
            $('#dob_day_sel').removeClass('is-valid');
            $('#dob_day_sel').addClass('is-invalid');
        }else if(rg_dobd<1||rg_dobd>31){
            $('#er_dob_d_mg').html(ivdt);
            $('#dob_day_sel').removeClass('is-valid');
            $('#dob_day_sel').addClass('is-invalid');
        }else{
            $('#dob_day_sel').removeClass('is-invalid');
            $('#dob_day_sel').addClass('is-valid');
        }
        if(rg_dobm===null||rg_dobm===''){
            pass=false;
            $('#er_dob_m_mg').html(plsl);
            $('#dob_mon_sel').removeClass('is-valid');
            $('#dob_mon_sel').addClass('is-invalid');
        }else if(rg_dobm<1||rg_dobm>12){
            $('#er_dob_m_mg').html(ivdt);
            $('#dob_mon_sel').removeClass('is-valid');
            $('#dob_mon_sel').addClass('is-invalid');
        }else{
            $('#dob_mon_sel').removeClass('is-invalid');
            $('#dob_mon_sel').addClass('is-valid');
        }
        if(rg_doby===null||rg_doby===''){
            pass=false;
            $('#er_dob_y_mg').html(plsl);
            $('#dob_yar_sel').removeClass('is-valid');
            $('#dob_yar_sel').addClass('is-invalid');
        }else if(rg_doby<cryr-150||rg_doby>cryr){
            $('#er_dob_y_mg').html(ivdt);
            $('#dob_yar_sel').removeClass('is-valid');
            $('#dob_yar_sel').addClass('is-invalid');
        }else{
            $('#dob_yar_sel').removeClass('is-invalid');
            $('#dob_yar_sel').addClass('is-valid');
        }
    }else if(!isValidDate(rg_dobm+'-'+rg_dobd+'-'+rg_doby,'-')){
        pass=false;
        $('#er_dob_d_mg').html(ivdt);
        $('#er_dob_m_mg').html(ivdt);
        $('#er_dob_y_mg').html(ivdt);
        $('#dob_day_sel').removeClass('is-valid');
        $('#dob_day_sel').addClass('is-invalid');
        $('#dob_mon_sel').removeClass('is-valid');
        $('#dob_mon_sel').addClass('is-invalid');
        $('#dob_yar_sel').removeClass('is-valid');
        $('#dob_yar_sel').addClass('is-invalid');
    }else{
        $('#dob_day_sel').removeClass('is-invalid');
        $('#dob_day_sel').addClass('is-valid');
        $('#dob_mon_sel').removeClass('is-invalid');
        $('#dob_mon_sel').addClass('is-valid');
        $('#dob_yar_sel').removeClass('is-invalid');
        $('#dob_yar_sel').addClass('is-valid');
    }
    if(!rg_gd){
        pass=false;
        $('#gder').removeClass('is-valid');
        $('#gder').addClass('is-invalid');
    }else{
        $('#gder').removeClass('is-invalid');
        $('#gder').addClass('is-valid');
    }
    if(rg_ctry===null||rg_ctry===''){
        pass=false;
        $('#rg_country_sel').removeClass('is-valid');
        $('#rg_country_sel').addClass('is-invalid');
    }else{
        $('#rg_country_sel').removeClass('is-invalid');
        $('#rg_country_sel').addClass('is-valid');
    }
    if(!$('#register_agree_toc').prop('checked')){
        pass=false;
        $('#register_agree_toc').removeClass('is-valid');
        $('#register_agree_toc').addClass('is-invalid');
    }else{
        $('#register_agree_toc').removeClass('is-invalid');
        $('#register_agree_toc').addClass('is-valid');
    }
    if(pass){
        $('#btnx').hide();
        $('#spnx').show();
        disableResend30s();
        $.post('../php_files/register_user_send_vc.php',
        {rc:rc,em:rg_em,usn:rg_usn},
        function(data){
            $('#spnx').hide();
            $('#btnx').show();
            if(data==='1'||data==='2'||data==='3'){
                if(data==='1'){
                    $('#er_usn_mg').html(alex);
                    $('#rg_usn').removeClass('is-valid');
                    $('#rg_usn').addClass('is-invalid');
                    $('#rg_em').removeClass('is-invalid');
                    $('#rg_em').addClass('is-valid');
                }else if(data==='2'){
                    $('#er_em_mg').html(alex);
                    $('#rg_em').removeClass('is-valid');
                    $('#rg_em').addClass('is-invalid');
                    $('#rg_usn').removeClass('is-invalid');
                    $('#rg_usn').addClass('is-valid');
                }else if(data==='3'){
                    $('#er_usn_mg').html(alex);
                    $('#er_em_mg').html(alex);
                    $('#rg_usn').removeClass('is-valid');
                    $('#rg_usn').addClass('is-invalid');
                    $('#rg_em').removeClass('is-valid');
                    $('#rg_em').addClass('is-invalid');
                }
            }else if(data!==''){
                $('#rg_usn').removeClass('is-invalid');
                $('#rg_usn').addClass('is-valid');
                $('#rg_em').removeClass('is-invalid');
                $('#rg_em').addClass('is-valid');
                $('#er_vc_mg').html(data);
                $('#div_rsvc').removeClass('is-valid');
                $('#div_rsvc').addClass('is-invalid');
                $('#div_register').hide();
                $('#div_register_validation').show();
            }else{
                $('#rg_usn').removeClass('is-invalid');
                $('#rg_usn').addClass('is-valid');
                $('#rg_em').removeClass('is-invalid');
                $('#rg_em').addClass('is-valid');
                $('#reg_val_email').val(rg_em);
                $('#div_register').hide();
                $('#div_register_validation').show();
            }
        });
    }
}
function register(){
    var pass=true;
    let rg_fn=$('#rg_fn').val();
    let rg_ln=$('#rg_ln').val();
    let rg_usn=$('#rg_usn').val();
    let rg_em=$('#rg_em').val();
    let rg_psw=$('#rg_psw').val();
    let rg_cpsw=$('#rg_cpsw').val();
    let rg_dobd=$('#dob_day_sel').val();
    let rg_dobm=$('#dob_mon_sel').val();
    let rg_doby=$('#dob_yar_sel').val();
    let rg_gd=$('input[name="rg_gender"]:checked').val();
    let rg_ctry=$('#rg_country_sel').val();
    let rg_vc=$('#rg_vc').val();
    if(rg_vc===null||rg_vc===''){
        pass=false;
        $('#er_vc_mg').html(epfl);
        $('#rg_vc').removeClass('is-valid');
        $('#div_rsvc').removeClass('is-valid');
        $('#rg_vc').addClass('is-invalid');
        $('#div_rsvc').addClass('is-invalid');
    }else{
        $('#rg_vc').removeClass('is-invalid');
        $('#div_rsvc').removeClass('is-invalid');
        $('#rg_vc').addClass('is-valid');
        $('#div_rsvc').addClass('is-valid');
    }
    if(pass){
        $('#btrg').hide();
        $('#sprg').show();
        let form_data=new FormData();
        form_data.append('data[]',rg_vc);
        form_data.append('data[]',rc);
        form_data.append('data[]',rg_fn);
        form_data.append('data[]',rg_ln);
        form_data.append('data[]',rg_usn);
        form_data.append('data[]',rg_em);
        form_data.append('data[]',rg_psw);
        form_data.append('data[]',rg_dobd);
        form_data.append('data[]',rg_dobm);
        form_data.append('data[]',rg_doby);
        form_data.append('data[]',rg_gd);
        form_data.append('data[]',rg_ctry);
        $.ajax({url:'../php_files/register_user.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){
                $('#er_vc_mg').html(data);
                $('#rg_vc').removeClass('is-valid');
                $('#div_rsvc').removeClass('is-valid');
                $('#rg_vc').addClass('is-invalid');
                $('#div_rsvc').addClass('is-invalid');
                $('#sprg').hide();
                $('#btrg').show();
            }else{
                if(getRequest('ret')==='1'){history.back();}
                else{location.href='../index.php';}
            }
        }});
    }
}
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
       $('#lgbtns').hide();
       $('#lgsp').show();
        $.post('../php_files/login_user.php',
        {acc:acc,psw:psw},
        function(data){
            let js=$.parseJSON(data);
            if(js[0]===1){
                if(getRequest('ret')==='1'){history.back();}
                else{location.href='../index.php';}
            }else if(js[0]===3){location.href='./activate_account.php?uid='+js[1];}
            else if(js[0]===0||js[0]===2){
                if(js[0]===0){$('#lg_er_mg').html('Login fail please try again.');}
                else if(js[0]===2){$('#lg_er_mg').html('Account Locked.');}
                $('#lg_acc').removeClass('is-valid');
                $('#lg_acc').addClass('is-invalid');
                $('#lg_psw').removeClass('is-valid');
                $('#lg_psw').addClass('is-invalid');
                $('#lg_er_disp').removeClass('is-valid');
                $('#lg_er_disp').addClass('is-invalid');
                $('#lgsp').hide();
                $('#lgbtns').show();
            }
        });
   }
}
$('#div_login').on('keydown','.lg_input',function(e){
    if(e.which === 13){
        login();
    }
});