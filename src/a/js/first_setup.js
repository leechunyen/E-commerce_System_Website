$('#smtp_pass_invalid_mg').html(epfl);
$('#db_pass_invalid_mg').html(epfl);
if (!window.File||!window.FileReader||!window.FileList||!window.Blob){
    alert('The File APIs are not fully supported in this browser.');
}
for(const property in CommonCurrency){
    $('.sel_currency').append(`<option value='${CommonCurrency[property]['code']}'>${CommonCurrency[property]['code']} ${CommonCurrency[property]['name']}</option>`);
}
function goToS2(){
    let sitename=$('#site_title').val();
    let min_pass_lg=$('#min_pass').val();
    let logo=$('#logo_file').prop('files')[0];
    let toc=$('#usr_toc_file').prop('files')[0];
    let db_host=$('#db_host').val();
    let db_port=$('#db_porrt').val();
    let db_usn=$('#db_username').val();
    let db_pass=$('#db_password').val();
    let db_name=$('#db_name').val();
    let currency=$('#sel_currency').val();
    var pass=true;
    if(sitename===''||sitename===null){
        pass=false;
        $('#site_title_invalid_mg').html(epfl);
        $('#site_title').removeClass('is-valid');
        $('#site_title').addClass('is-invalid');
    }else if(sitename.length>20){
        pass=false;
        $('#site_title_invalid_mg').html(maxCharacterMessage(20));
        $('#site_title').removeClass('is-valid');
        $('#site_title').addClass('is-invalid');
    }else if(isSpecialCharacter(sitename)){
        pass=false;
        $('#site_title_invalid_mg').html(stal);
        $('#site_title').removeClass('is-valid');
        $('#site_title').addClass('is-invalid');
    }else{
        $('#site_title').removeClass('is-invalid');
        $('#site_title').addClass('is-valid');
    }
    if(min_pass_lg===''||min_pass_lg===null){
        pass=false;
        $('#pass_lg_invalid_mg').html(epfl);
        $('#min_pass').removeClass('is-valid');
        $('#min_pass').addClass('is-invalid');
    }else if(isNaN(min_pass_lg)){
        pass=false;
        $('#pass_lg_invalid_mg').html(plno);
        $('#min_pass').removeClass('is-valid');
        $('#min_pass').addClass('is-invalid');
    }else if(min_pass_lg<1||min_pass_lg>12){
        pass=false;
        $('#pass_lg_invalid_mg').html('Only allowed in 1 to 12.');
        $('#min_pass').removeClass('is-valid');
        $('#min_pass').addClass('is-invalid');
    }else{
        $('#min_pass').removeClass('is-invalid');
        $('#min_pass').addClass('is-valid');
    }
    if(!logo){
        pass=false;
        $('#logo_ctn').removeClass('is-valid');
        $('#logo_ctn').addClass('is-invalid');
    }else{
        $('#logo_ctn').removeClass('is-invalid');
        $('#logo_ctn').addClass('is-valid');
    }
    if(!toc){
        pass=false;
        $('#usr_toc_file').removeClass('is-valid');
        $('#usr_toc_file').addClass('is-invalid');
    }else{
        $('#usr_toc_file').removeClass('is-invalid');
        $('#usr_toc_file').addClass('is-valid');
    }
    if(db_host===''||db_host===null){
        pass=false;
        $('#db_host_invalid_mg').html(epfl);
        $('#db_host').removeClass('is-valid');
        $('#db_host').addClass('is-invalid');
    }else if(db_host.length>78){
        pass=false;
        $('#db_host_invalid_mg').html(maxCharacterMessage(78));
        $('#db_host').removeClass('is-valid');
        $('#db_host').addClass('is-invalid');
    }else if(isSpecialCharacter(db_host)){
        pass=false;
        $('#db_host_invalid_mg').html(stal);
        $('#db_host').removeClass('is-valid');
        $('#db_host').addClass('is-invalid');
    }else{
        $('#db_host').removeClass('is-invalid');
        $('#db_host').addClass('is-valid');
    }
    if(db_port===''||db_port===null){
        pass=false;
        $('#db_port_invalid_mg').html(epfl);
        $('#db_porrt').removeClass('is-valid');
        $('#db_porrt').addClass('is-invalid');
    }else if(!isValidPortNumber(db_port)){
        pass=false;
        $('#db_port_invalid_mg').html(plpo);
        $('#db_porrt').removeClass('is-valid');
        $('#db_porrt').addClass('is-invalid');
    }else{
        $('#db_porrt').removeClass('is-invalid');
        $('#db_porrt').addClass('is-valid');
    }
    if(db_usn===''||db_usn===null){
        pass=false;
        $('#db_usn_invalid_mg').html(epfl);
        $('#db_username').removeClass('is-valid');
        $('#db_username').addClass('is-invalid');
    }else if(db_usn.length>16){
        pass=false;
        $('#db_usn_invalid_mg').html(maxCharacterMessage(16));
        $('#db_username').removeClass('is-valid');
        $('#db_username').addClass('is-invalid');
    }else if(isSpecialCharacter(db_usn)){
        pass=false;
        $('#db_usn_invalid_mg').html(stal);
        $('#db_username').removeClass('is-valid');
        $('#db_username').addClass('is-invalid');
    }else{
        $('#db_username').removeClass('is-invalid');
        $('#db_username').addClass('is-valid');
    }
    if(db_name===''||db_name===null){
        pass=false;
        $('#db_name_invalid_mg').html(epfl);
        $('#db_name').removeClass('is-valid');
        $('#db_name').addClass('is-invalid');
    }else if(db_name.length>64){
        pass=false;
        $('#db_name_invalid_mg').html(maxCharacterMessage(64));
        $('#db_name').removeClass('is-valid');
        $('#db_name').addClass('is-invalid');
    }else if(isSpecialCharacter(db_name)){
        pass=false;
        $('#db_name_invalid_mg').html(stal);
        $('#db_name').removeClass('is-valid');
        $('#db_name').addClass('is-invalid');
    }else{
        $('#db_name').removeClass('is-invalid');
        $('#db_name').addClass('is-valid');
    }
    if(currency===''||currency===null){
        pass=false;
        $('#sel_currency').removeClass('is-valid');
        $('#sel_currency').addClass('is-invalid');
    }else{
        $('#sel_currency').removeClass('is-invalid');
        $('#sel_currency').addClass('is-valid');
    }
    if(pass){
        $('#s1').hide();
        $('#s3').hide();
        $('#s2').show();
        $('#st1').removeClass('active');
        $('#st3').removeClass('active');
        $('#st2').addClass('active');
    }
}
function goToS3(){
    let em_host=$('#smtp_host').val();
    let em_port=$('#smtp_porrt').val();
    let em_secure=$('#smtp_secure').val();
    let em_auth=$('#sw_mail_auth').prop('checked');
    let em_usn=$('#smtp_username').val();
    let em_pass=$('#smtp_password').val();
    let pp_api=$('#ppapi').val();
    var pass=true;
    if(em_host===''||em_host===null){
        pass=false;
        $('#smtp_host_invalid_mg').html(epfl);
        $('#smtp_host').removeClass('is-valid');
        $('#smtp_host').addClass('is-invalid');
    }else if(em_host.length>78){
        pass=false;
        $('#smtp_host_invalid_mg').html(maxCharacterMessage(78));
        $('#smtp_host').removeClass('is-valid');
        $('#smtp_host').addClass('is-invalid');
    }else if(isSpecialCharacter(em_host)){
        pass=false;
        $('#smtp_host_invalid_mg').html(stal);
        $('#smtp_host').removeClass('is-valid');
        $('#smtp_host').addClass('is-invalid');
    }else{
        $('#smtp_host').removeClass('is-invalid');
        $('#smtp_host').addClass('is-valid');
    }
    if(em_port===''||em_port===null){
        pass=false;
        $('#smtp_port_invalid_mg').html(epfl);
        $('#smtp_porrt').removeClass('is-valid');
        $('#smtp_porrt').addClass('is-invalid');
    }else if(!isValidPortNumber(em_port)){
        pass=false;
        $('#smtp_port_invalid_mg').html(plpo);
        $('#smtp_porrt').removeClass('is-valid');
        $('#smtp_porrt').addClass('is-invalid');
    }else{
        $('#smtp_porrt').removeClass('is-invalid');
        $('#smtp_porrt').addClass('is-valid');
    }
    if(em_secure===''||em_secure===null){
        pass=false;
        $('#smtp_secure_invalid_mg').html(epfl);
        $('#smtp_secure').removeClass('is-valid');
        $('#smtp_secure').addClass('is-invalid');
    }else if(em_secure.length>10){
        pass=false;
        $('#smtp_secure_invalid_mg').html(maxCharacterMessage(10));
        $('#smtp_secure').removeClass('is-valid');
        $('#smtp_secure').addClass('is-invalid');
    }else if(isSpecialCharacter(em_secure)){
        pass=false;
        $('#smtp_secure_invalid_mg').html(stal);
        $('#smtp_secure').removeClass('is-valid');
        $('#smtp_secure').addClass('is-invalid');
    }else{
        $('#smtp_secure').removeClass('is-invalid');
        $('#smtp_secure').addClass('is-valid');
    }
    if(em_auth){
        if(em_usn===''||em_usn===null){
            pass=false;
            $('#smtp_usn_invalid_mg').html(epfl);
            $('#smtp_username').removeClass('is-valid');
            $('#smtp_username').addClass('is-invalid');
        }else if(em_usn.length>100){
            pass=false;
            $('#smtp_usn_invalid_mg').html(maxCharacterMessage(100));
            $('#smtp_username').removeClass('is-valid');
            $('#smtp_username').addClass('is-invalid');
        }else if(isSpecialCharacter(em_usn)){
            pass=false;
            $('#smtp_usn_invalid_mg').html(stal);
            $('#smtp_username').removeClass('is-valid');
            $('#smtp_username').addClass('is-invalid');
        }else{
            $('#smtp_username').removeClass('is-invalid');
            $('#smtp_username').addClass('is-valid');
        }
        if(em_pass===''||em_pass===null){
            pass=false;
            $('#smtp_pass_invalid_mg').html(epfl);
            $('#smtp_password').removeClass('is-valid');
            $('#smtp_password').addClass('is-invalid');
        }else if(em_pass.length>100){
            pass=false;
            $('#smtp_pass_invalid_mg').html(maxCharacterMessage(100));
            $('#smtp_password').removeClass('is-valid');
            $('#smtp_password').addClass('is-invalid');
        }else{
            $('#smtp_password').removeClass('is-invalid');
            $('#smtp_password').addClass('is-valid');
        }
    }
    if(pp_api===''||pp_api===null){
        pass=false;
        $('#ppapi_invalid_mg').html(epfl);
        $('#ppapi').removeClass('is-valid');
        $('#ppapi').addClass('is-invalid');
    }else{
        $('#ppapi').removeClass('is-invalid');
        $('#ppapi').addClass('is-valid');
    }
    if(pass){
        $('#s1').hide();
        $('#s2').hide();
        $('#s3').show();
        $('#st1').removeClass('active');
        $('#st2').removeClass('active');
        $('#st3').addClass('active');
    }
}
function goToS1(){
    $('#s2').hide();
    $('#s3').hide();
    $('#s1').show();
    $('#st2').removeClass('active');
    $('#st3').removeClass('active');
    $('#st1').addClass('active');
}
function displayLogo(){
    let imgView=getElementID('iv_tmp_logo');
    let file=getElementID('logo_file').files[0];
    if(file&&file.size>5242880){
        file=null;
        alert('Logo only less than 5MB allowed.');
    }else{
        var reader=new FileReader();
        reader.onloadend=function (){imgView.src=reader.result;};
        if (file){
            reader.readAsDataURL(file);
            $('#sel_img_btn').html('Change');        
        }
    }
}
function uploadToc(){
    let file=$('#usr_toc_file').prop('files')[0];
    if(file&&file.size>5242880){
        file=null;
        alert('Logo only less than 5MB allowed.');
    }else{$('#sel_toc_btn').html('Change');}
}
function swHTTPS(){
    if($('#https_sw').prop('checked')){
        $('#swst').html('Enabled');
    }else{
        $('#swst').html('Disabled');
    }
}
function swHPassCap(){
    if($('#pass_cap_sw').prop('checked')){
        $('#pass_cap_st').html('Enabled');
    }else{
        $('#pass_cap_st').html('Disabled');
    }
}
function done(){
    let logo=$('#logo_file').prop('files')[0];
    let toc=$('#usr_toc_file').prop('files')[0];
    let sitename=$('#site_title').val();
    let min_pass_lg=$('#min_pass').val();
    let pass_cap=$('#pass_cap_sw').prop('checked');
    let foece_https=$('#https_sw').prop('checked');
    let db_host=$('#db_host').val();
    let db_port=$('#db_porrt').val();
    let db_usn=$('#db_username').val();
    let db_pass=$('#db_password').val();
    let db_name=$('#db_name').val();
    let em_host=$('#smtp_host').val();
    let em_port=$('#smtp_porrt').val();
    let em_secure=$('#smtp_secure').val();
    let em_auth=$('#sw_mail_auth').prop('checked');
    let em_usn=$('#smtp_username').val();
    let em_pass=$('#smtp_password').val();
    let rg_fn=$('#register_first_name').val();
    let rg_ln=$('#register_last_name').val();
    let rg_usn=$('#register_username').val();
    let rg_em=$('#register_email').val();
    let rg_pass=$('#register_password').val();
    let rg_cfpass=$('#register_confirm_password').val();
    let rg_gender=$("input[name='register_gender']:checked").val();
    let currency=$('#sel_currency').val();
    let pp_api=$('#ppapi').val();
    var pass=true;
    if(rg_fn===''||rg_fn===null){
        pass=false;
        $('#user_fn_invalid_mg').html(epfl);
        $('#register_first_name').removeClass('is-valid');
        $('#register_first_name').addClass('is-invalid');
    }else if(rg_fn.length>50){
        pass=false;
        $('#user_fn_invalid_mg').html(maxCharacterMessage(50));
        $('#register_first_name').removeClass('is-valid');
        $('#register_first_name').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_fn)){
        pass=false;
        $('#user_fn_invalid_mg').html(stal);
        $('#register_first_name').removeClass('is-valid');
        $('#register_first_name').addClass('is-invalid');
    }else{
        $('#register_first_name').removeClass('is-invalid');
        $('#register_first_name').addClass('is-valid');
    }
    if(rg_ln===''||rg_ln===null){
        pass=false;
        $('#user_ln_invalid_mg').html(epfl);
        $('#register_last_name').removeClass('is-valid');
        $('#register_last_name').addClass('is-invalid');
    }else if(rg_ln.length>50){
        pass=false;
        $('#user_ln_invalid_mg').html(maxCharacterMessage(50));
        $('#register_last_name').removeClass('is-valid');
        $('#register_last_name').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_ln)){
        pass=false;
        $('#user_ln_invalid_mg').html(stal);
        $('#register_last_name').removeClass('is-valid');
        $('#register_last_name').addClass('is-invalid');
    }else{
        $('#register_last_name').removeClass('is-invalid');
        $('#register_last_name').addClass('is-valid');
    }
    if(rg_usn===''||rg_usn===null){
        pass=false;
        $('#user_usn_invalid_mg').html(epfl);
        $('#register_username').removeClass('is-valid');
        $('#register_username').addClass('is-invalid');
    }else if(rg_usn.length>50){
        pass=false;
        $('#user_usn_invalid_mg').html(maxCharacterMessage(50));
        $('#register_username').removeClass('is-valid');
        $('#register_username').addClass('is-invalid');
    }else if(isSpecialCharacter(rg_usn)||validateEmail(rg_usn)){
        pass=false;
        $('#user_usn_invalid_mg').html(stal);
        $('#register_username').removeClass('is-valid');
        $('#register_username').addClass('is-invalid');
    }else{
        $('#register_username').removeClass('is-invalid');
        $('#register_username').addClass('is-valid');
    }
    if(!rg_gender){
        pass=false;
        $('#register_gd').removeClass('is-valid');
        $('#register_gd').addClass('is-invalid');
    }else{
        $('#register_gd').removeClass('is-invalid');
        $('#register_gd').addClass('is-valid');
    }
    if(rg_em===''||rg_em===null){
        pass=false;
        $('#register_email_invalid_mg').html(epfl);
        $('#register_email').removeClass('is-valid');
        $('#register_email').addClass('is-invalid');
    }else if(rg_em.length>100){
        pass=false;
        $('#register_email_invalid_mg').html(maxCharacterMessage(100));
        $('#register_email').removeClass('is-valid');
        $('#register_email').addClass('is-invalid');
    }else if(!validateEmail(rg_em)||isSpecialCharacter(rg_em)){
        pass=false;
        $('#register_email_invalid_mg').html(ivem);
        $('#register_email').removeClass('is-valid');
        $('#register_email').addClass('is-invalid');
    }else{
        $('#register_email').removeClass('is-invalid');
        $('#register_email').addClass('is-valid');
    }
    if(rg_pass===''||rg_pass===null){
        pass=false;
        $('#register_pass_invalid_mg').html(epfl);
        $('#register_password').removeClass('is-valid');
        $('#register_password').addClass('is-invalid');
    }else if(rg_pass.length>80){
        pass=false;
        $('#register_pass_invalid_mg').html(maxCharacterMessage(80));
        $('#register_password').removeClass('is-valid');
        $('#register_password').addClass('is-invalid');
    }else if((pass_cap&&!isUppercaseIncluded(rg_pass))||(rg_pass.length<min_pass_lg)){
        pass=false;
        var ms='Minimum password length is '+min_pass_lg;
        if(pass_cap){ms+=' and uppercase required';}
        $('#register_pass_invalid_mg').html(ms+'.');
        $('#register_password').removeClass('is-valid');
        $('#register_password').addClass('is-invalid');
    }else{
        $('#register_password').removeClass('is-invalid');
        $('#register_password').addClass('is-valid');
    }
    if(rg_cfpass===''||rg_cfpass===null){
        pass=false;
        $('#register_cfpass_invalid_mg').html(epfl);
        $('#register_confirm_password').removeClass('is-valid');
        $('#register_confirm_password').addClass('is-invalid');
    }else if(rg_cfpass.length>80){
        pass=false;
        $('#register_cfpass_invalid_mg').html(maxCharacterMessage(80));
        $('#register_confirm_password').removeClass('is-valid');
        $('#register_confirm_password').addClass('is-invalid');
    }else if(rg_cfpass!==rg_pass){
        pass=false;
        $('#register_cfpass_invalid_mg').html(pwnm);
        $('#register_confirm_password').removeClass('is-valid');
        $('#register_confirm_password').addClass('is-invalid');
    }else{
        $('#register_confirm_password').removeClass('is-invalid');
        $('#register_confirm_password').addClass('is-valid');
    }
    if(pass){
        $('#btn_done').hide();
        $('#sp').show();
        let form_data=new FormData();
        form_data.append('data[]',logo);
        form_data.append('data[]',toc);
        form_data.append('data[]',sitename);
        form_data.append('data[]',min_pass_lg);
        form_data.append('data[]',pass_cap);
        form_data.append('data[]',foece_https);
        form_data.append('data[]',db_host);
        form_data.append('data[]',db_port);
        form_data.append('data[]',db_usn);
        form_data.append('data[]',db_pass);
        form_data.append('data[]',db_name);
        form_data.append('data[]',em_host);
        form_data.append('data[]',em_port);
        form_data.append('data[]',em_secure);
        form_data.append('data[]',em_auth);
        form_data.append('data[]',em_usn);
        form_data.append('data[]',em_pass);
        form_data.append('data[]',rg_fn);
        form_data.append('data[]',rg_ln);
        form_data.append('data[]',rg_usn);
        form_data.append('data[]',rg_em);
        form_data.append('data[]',rg_pass);
        form_data.append('data[]',rg_gender);
        form_data.append('data[]',currency);
        form_data.append('data[]',pp_api);
        $.ajax({url:'../php_files/first_setup_start.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);$('#sp').hide();$('#btn_done').show();}
            else{window.location='./master.php';}
        }});
    }
}