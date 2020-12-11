$('.modal').on('hide.bs.modal',function(){
    $('.modal #cbaggdelacc').prop('checked',false);
    $('#bt_del_acc').prop('disabled',true);
    $('.modal .form-control').val('');
    $('.modal .form-control').removeClass('is-invalid').removeClass('is-valid');
    $('#spchpsw').hide();
    $('#btchpsw').show();
});
for(const property in countryListAlpha2) {
    $('#country_sel').append(`<option value='${property}'>${countryListAlpha2[property]}</option>`);
}
$('.input-group-append .btn,#btchimg').prop('disabled',true);
var f=checkFrom();var minpswlg;var pswcap;var orgndata=[];var ipid=[];var edting=false;
var dt=new Date();
var rc=dt.getHours()+''+dt.getMinutes()+''+dt.getSeconds()+''+dt.getMilliseconds()+''+Math.floor(Math.random()*100000)+100000;
loadData();
function changePhoto(e){
    let fl=$(e).prop('files')[0];
    if(fl&&fl.size>5242880){//5MB
        alert('5MB is the max allowed');
    }else{
        let form_data=new FormData();
        form_data.append('data[]',fl);
        form_data.append('data[]',f);
        $.ajax({url:'../../ua/php_files/change_profile_photo.php',dataType:'text',
            cache:false,contentType:false,processData:false,data:form_data,
            type:'post',success:function(data){
                if(data!==''){alert(data);}
                else{
                    let iv=getElementID('propth');
                    var reader=new FileReader();
                    reader.onloadend=function (){iv.src=reader.result;};
                    if (fl){reader.readAsDataURL(fl);}
                }
            }
        });
    }
}
function loadData(){
    $.post('../../ua/php_files/load_profile_data.php',
    {f:f},
    function(data){
        let arr=$.parseJSON(data);
        if(arr['Photo']!==null&&arr['photo']!==''){$('#propth').attr('src','../..'+arr['Photo']);}
        $('#llgip').val(arr['LastLoginIp']+'('+arr['llc']+')');
        $('#llgdt').val('(UTC)'+arr['ldt']);
        $('#cdt').val('(UTC)'+arr['cdt']);
        $('#ipusn').val(arr['Username']);
        $('#ipem').val(arr['Email']);
        $('#ipfn').val(arr['FirstName']);
        $('#ipln').val(arr['LastName']);
        if(arr['Gender']==='m'){$('#gender_m').prop('checked',true);}
        else if(arr['Gender']==='f'){$('#gender_f').prop('checked',true);}
        if(f==='u'){
            $('#country_sel').val(arr['CountryRegional']);
            $('#dob_day_sel').val(arr['DobDay']);
            $('#dob_mon_sel').val(arr['DobMonth']);
            $('#dob_yar_sel').val(arr['DobYear']);
        }
        $('.input-group-append .btn,#btchimg').prop('disabled',false);
        $('#spdiv').hide();
        $('#ct').show();
    });
}
function deleteAgree(e){
    if($(e).prop('checked')){$('#bt_del_acc').prop('disabled',false);}
    else{$('#bt_del_acc').prop('disabled',true);}
}
function deleteAcc(){
    $.post('../../ua/php_files/delete_admin_user_account.php',
    {type:f,id:'-'},
    function(data){
        if(data!==''){alert(data);}
        else{location.reload();}
    });
}
function changePassword(){
    let cr=$('#chpsw_cr').val();
    let nw=$('#chpsw_nw').val();
    let cf=$('#chpsw_cf').val();
    var pass=true;
    if(cr===''||cr===null){
        pass=false;
        $('#er_chpsw_cr').html(epfl);
        $('#chpsw_cr').removeClass('is-valid').addClass('is-invalid');
    }else if(cr.length>80){
        pass=false;
        $('#er_chpsw_cr').html(maxCharacterMessage(80));
        $('#chpsw_cr').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#chpsw_cr').removeClass('is-invalid').addClass('is-valid');
    }
    if(nw===''||nw===null){
        pass=false;
        $('#er_chpsw_nw').html(epfl);
        $('#chpsw_nw').removeClass('is-valid').addClass('is-invalid');
    }else if(nw.length>80){
        pass=false;
        $('#er_chpsw_nw').html(maxCharacterMessage(80));
        $('#chpsw_nw').removeClass('is-valid').addClass('is-invalid');
    }else if((pswcap&&!isUppercaseIncluded(nw))||nw.length<minpswlg){
        pass=false;
        var ms='Minimum password length is '+minpswlg;
        if(pswcap){ms+=' and uppercase required';}
        $('#er_chpsw_nw').html(ms);
        $('#chpsw_nw').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#chpsw_nw').removeClass('is-invalid').addClass('is-valid');
    }
    if(cf===''||cf===null){
        pass=false;
        $('#er_chpsw_cf').html(epfl);
        $('#chpsw_cf').removeClass('is-valid').addClass('is-invalid');
    }else if(cf.length>80){
        pass=false;
        $('#er_chpsw_cf').html(maxCharacterMessage(80));
        $('#chpsw_cf').removeClass('is-valid').addClass('is-invalid');
    }else if(cf!==nw){
        pass=false;
        $('#er_chpsw_cf').html(pwnm);
        $('#chpsw_cf').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#chpsw_cf').removeClass('is-invalid').addClass('is-valid');
    }
    if(pass){
        $('#btchpsw').hide();
        $('#spchpsw').show();
        $.post('../../ua/php_files/change_admin_user_password.php',
        {psw:nw,type:f,id:'-',crpsw:cr},
        function(data){
            if(data==='1'){
                $('#er_chpsw_cr').html('wrong password.');
                $('#chpsw_cr').removeClass('is-valid').addClass('is-invalid');
            }else if(data!==''){alert(data);}
            else{$('.modal').modal('hide');}
            $('#spchpsw').hide();
            $('#btchpsw').show();
        });
    }
}
function edit(e,mode,ip1,ip2=null,ip3=null,ipck=false){
   if(!edting){
        $('.input-group-append .btn,#btchimg').prop('disabled',true);
        $(e).prop('disabled',false);
        $('#btcpsw,#btdacc').hide();
        $('#btcedt').show();
        ipid.push(ip1,ip2,ip3,ipck);
        if(ipck){
            orgndata.push($('#'+ip1).prop('checked'));
            if(ip2!==null){orgndata.push($('#'+ip2).prop('checked'));}
            if(ip3!==null){orgndata.push($('#'+ip3).prop('checked'));}
        }else{
            orgndata.push($('#'+ip1).val());
            if(ip2!==null){orgndata.push($('#'+ip2).val());}
            if(ip3!==null){orgndata.push($('#'+ip3).val());}
        }
        $('#'+ip1).prop('disabled',false);
        if(ip2!==null){$('#'+ip2).prop('disabled',false);}
        if(ip3!==null){$('#'+ip3).prop('disabled',false);}
        edting=true;
        $(e).html('Save');
   }else{
        let ipv1=$('#'+ip1).val();
        var ipv2=null;if(ip2!==null){ipv2=$('#'+ip2).val();}
        var ipv3=null;if(ip3!==null){ipv3=$('#'+ip3).val();}
        var pass=true;
        if(mode==='usn'){
            if(ipv1===''||ipv1===null){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
            }else if(ipv1.length>50){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                alert(maxCharacterMessage(50));
            }else if(isSpecialCharacter(ipv1)){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                alert(stal);
            }else{$('#'+ip1).removeClass('is-invalid').addClass('is-valid');}
        }
        else if(mode==='name'){
            if(ipv1===''||ipv1===null){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
            }else{$('#'+ip1).removeClass('is-invalid').addClass('is-valid');}
            if(ipv2===''||ipv2===null){
                pass=false;
                $('#'+ip2).removeClass('is-valid').addClass('is-invalid');
            }else{$('#'+ip2).removeClass('is-invalid').addClass('is-valid');}
            if(ipv1.length>50||ipv2.length>50){
                alert(maxCharacterMessage(50));
                pass=false;
                if(ipv1.length>50){
                    $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                }
                if(ipv2.length>50){
                    $('#'+ip2).removeClass('is-valid').addClass('is-invalid');
                }
            }
            if(isSpecialCharacter(ipv1)||isSpecialCharacter(ipv2)){
                pass=false;
                alert(stal);
                if(isSpecialCharacter(ipv1)){
                    $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                }
                if(isSpecialCharacter(ipv2)){
                    $('#'+ip2).removeClass('is-valid').addClass('is-invalid');
                }
            }
        }
        else if(mode==='gd'){
            ipv1=null;ipv2=null;ipv3=null;
            if($('#'+ip1).prop('checked')){ipv1=$('#'+ip1).val();}
            else if($('#'+ip2).prop('checked')){ipv1=$('#'+ip2).val();}
        }
        else if(mode==='dob'){
            if(!isValidDate(ipv2+'-'+ipv1+'-'+ipv3,'-')){
                pass=false;
                $('#'+ip1+',#'+ip2+',#'+ip3).removeClass('is-valid').addClass('is-invalid');
            }else{$('#'+ip1+',#'+ip2+',#'+ip3).removeClass('is-invalid').addClass('is-valid');}
        }
        else if(mode==='em'){
            ipv2=rc;
            if(ipv1===''||ipv1===null){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
            }else if(ipv1.length>100){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                alert(maxCharacterMessage(100));
            }else if(!validateEmail(ipv1)||isSpecialCharacter(ipv1)){
                pass=false;
                $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                alert(ivem);
            }else{$('#'+ip1).removeClass('is-invalid').addClass('is-valid');}
        }
        if(pass){
            $(e).prop('disabled',true);
            $(e).html('Save...');
            $.post('../../ua/php_files/update_profile.php',
            {m:mode,f:f,v1:ipv1,v2:ipv2,v3:ipv3},
            function(data){
                if(data==='1'){sendValidationCode(ipv1);}
                else if(data!==''){
                    $('#'+ip1).removeClass('is-valid').addClass('is-invalid');
                    alert(data);
                }else{
                    edting=false;
                    $('.input-group-append .btn,#btchimg').prop('disabled',false);
                    $('.edtip').prop('disabled',true);
                    $(e).html('Edit');
                    $('#btcedt').hide();
                    $('#btcpsw,#btdacc').show();
                    ipid.splice(0);
                    orgndata.splice(0);
                    $('.form-control').removeClass('is-invalid').removeClass('is-valid');
                }
                $(e).html('Save');
                $(e).prop('disabled',false);
            });
        }
   }
}
function sendValidationCode(em){
    disableResend30s();
    $('#nw_val_email').val(em);
    $('#emvalidate').modal('show');
}
function resendVC(){
    disableResend30s();
    let em=$('#nw_val_email').val();
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
function validationCodeValidate(){
    let vc=$('#em_vc').val();
    var pass=true;
    if(vc===''||vc===null){
        pass=false;
        $('#er_vc_mg').html(epfl);
        $('#div_rsvc').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(vc)){
        pass=false;
        $('#er_vc_mg').html(ivvc);
        $('#div_rsvc').removeClass('is-valid').addClass('is-invalid');
    }else{$('#div_rsvc').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        $('#btemvl').hide();
        $('#spemvl').show();
        let em=$('#nw_val_email').val();
        $.post('../../ua/php_files/update_profile_email.php',
        {rc:rc,vc:vc,em:em},
        function(data){
            if(data!==''){
                $('#er_vc_mg').html(data);
                $('#div_rsvc').removeClass('is-valid').addClass('is-invalid');
            }else{
                $('.modal').modal('hide');
                edting=false;
                $('.input-group-append .btn,#btchimg').prop('disabled',false);
                $('.edtip').prop('disabled',true);
                $('.edtbt').html('Edit');
                $('#btcedt').hide();
                $('#btcpsw,#btdacc').show();
                ipid.splice(0);
                orgndata.splice(0);
                $('.form-control').removeClass('is-invalid').removeClass('is-valid');;
            }
            $('#spemvl').hide();
            $('#btemvl').show();
        });
    }
}
function cancelEdit(){
    edting=false;
    if(ipid[3]){
        $('#'+ipid[0]).prop('checked',orgndata[0]);
        if(ipid[1]!==null){'#'+$(ipid[1]).prop('checked',orgndata[1]);}
        if(ipid[2]!==null){'#'+$(ipid[2]).prop('checked',orgndata[2]);}
    }else{
        $('#'+ipid[0]).val(orgndata[0]);
        if(ipid[1]!==null){$('#'+ipid[1]).val(orgndata[1]);}
        if(ipid[2]!==null){$('#'+ipid[2]).val(orgndata[2]);}
    }
    $('#btcedt').hide();
    $('#btcpsw,#btdacc').show();
    $('.input-group-append .btn,#btchimg').prop('disabled',false);
    $('.edtip').prop('disabled',true);
    $('.edtbt').html('Edit');
    ipid.splice(0);
    orgndata.splice(0);
    $('.form-control').removeClass('is-invalid').removeClass('is-valid');;
}