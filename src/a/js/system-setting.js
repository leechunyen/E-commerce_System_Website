$('#page_title').html('System Setting');
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid');
    $('.modal *').removeClass('is-invalid');
    $('.modal .form-control').val('');
});
function displayLogo(){
    let imgView=getElementID('logo_pv');
    let file=getElementID('logo_file').files[0];
    if(file&&file.size>5242880){
        file=null;
        alert('Logo only less than 5MB allowed.');
    }else{
        let reader=new FileReader();
        reader.onloadend=function (){imgView.src=reader.result;};
        if (file){
            reader.readAsDataURL(file);
            $("#btn_logo_save").prop("disabled",false);
        }
    }
}
function saveLogo(){
    $('#btn_logo_save').hide();
    $('#sp_save_logo').show();
    let syslogo=getElementID('logo_file');
    let file=getElementID('logo_file').files[0];
    if(!file){
        alert('Please upload an image.');
    }else if(file.size>5242880){
        alert('Logo only less than 5MB allowed.');
    }else{
        var form_data=new FormData();                  
        form_data.append('data',file);
        $.ajax({
            url: '../php_files/change_logo.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                $('#sp_save_logo').hide();
                $('#btn_logo_save').show();
                if(data===''){
                    let lgView=getElementID('logo');
                    let reader=new FileReader();
                    reader.onloadend=function (){lgView.src=reader.result;};
                    if (file){reader.readAsDataURL(file);}
                    $("#btn_logo_save").prop("disabled",true);
                    file=null;
                }else{alert(data);}
            }
        });
    }
}
function checkNewTitleInput(){
    let ip=$('#ip_nw_title').val();
    if(ip!==null&&ip.length>0&&ip.length<=20){
        $('#btn_nwtitle_save').prop("disabled",false);
        return true;
    }else{
        $('#btn_nwtitle_save').prop("disabled",true);
        return false;
    }
}
function saveNewTitle(){
    if(checkNewTitleInput()){
        $('#btn_nwtitle_save').prop("disabled",true);
        let nw_title=$('#ip_nw_title').val();
        $.post('../php_files/change_title.php',
        {nwtitle:nw_title},
        function(data){
            if(data===''){
                $('#ip_nw_title').val('');
                $('#lb_title').html(nw_title);
                $('#site_title').html(nw_title);
            }else{alert(data);}
        });
    }else{alert('Invalid title format.');}
}
function checkNewPswLgInput(){
    let ip=$('#ip_nw_pswlg').val();
    if(ip!==null&&ip>0&&ip<=12){
        $('#btn_nwpswlg_save').prop("disabled",false);
        return true;
    }else{
        $('#btn_nwpswlg_save').prop("disabled",true);
        return false;
    }
}
function saveNewPswLg(){
    if(checkNewPswLgInput()){
        let nw_pswlg=$('#ip_nw_pswlg').val();
        $.post('../php_files/change_psw_lg.php',
        {nwpswlg:nw_pswlg},
        function(data){
            if(data===''){
                $('#ip_nw_pswlg').val('');
                $('#lb_pswlg').html(nw_pswlg);
            }else{alert(data);}
        });
    }else{alert('Invalid title format.');}
}
function forceHTTPS_PswCap_change(e,m){
    if(m!==1&&m!==2){
        alert("Please refresh and try again.");
    }else{
        let sw=$(e).prop("checked");
        $.post('../php_files/change_fhttps_pswcap.php',
        {mode:m,val:sw},
        function(data){
            if(data!==''){alert(data);}
        });
    }
}
function updateMailServer(){
    let em_host=$('#smtp_host').val();
    let em_port=$('#smtp_porrt').val();
    let em_secure=$('#smtp_secure').val();
    let em_auth=$('#sw_mail_auth').prop('checked');
    let em_usn=$('#smtp_username').val();
    let em_pass=$('#smtp_password').val();
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
    if(pass){
        $('#bt_upem').hide();
        $('#sp_upem').show();
        
        var form_data=new FormData();
        form_data.append('data[]',em_host);
        form_data.append('data[]',em_port);
        form_data.append('data[]',em_secure);
        form_data.append('data[]',em_auth);
        form_data.append('data[]',em_usn);
        form_data.append('data[]',em_pass);
        
        $.ajax({url:'../php_files/update_mail_info.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data===''){$('#mdl_mail').modal('hide');}
            else{alert(data);}
            $('#sp_upem').hide();
            $('#bt_upem').show();
        }});
    }
}
function mailTest(){
    $('#btstem').hide();
    $('#spstem').show();
    $.post('../php_files/send_test_email.php',
    {p:"send"},
    function(data){
        if(data!==''){alert(data);}
        $('#spstem').hide();
        $('#btstem').show();
    });
}
function loadToc(){
    let file=getElementID('toc_file').files[0];
    if(!file){
        alert('No file');
    }else if(file&&file.size>5242880){
        alert('Logo only less than 5MB allowed.');
    }else{
        $('#bt_toc_save').prop("disabled",false);
        let reader=new FileReader();
        reader.onload=function(progressEvent){
            let lines=this.result.split('\n');
            var ct;
            for(var line=0;line<lines.length;line++){
                ct+=lines[line]+'<br/>';
            }
            $('#tocctn').html(ct);
        };
        reader.readAsText(file);
    }
}
function saveToc(){
    let file=getElementID('toc_file').files[0];
    if(!file){
        alert('Please upload an file.');
    }else if(file.size>5242880){
        alert('Logo only less than 5MB allowed.');
    }else{
        var form_data=new FormData();                  
        form_data.append('data',file);
        $.ajax({
            url: '../php_files/change_toc.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                $('#sp_save_logo').hide();
                $('#btn_logo_save').show();
                if(data===''){
                    $("#bt_toc_save").prop("disabled",true);
                    file=null;
                }else{alert(data);}
            }
        });
    }
}
function clearCache(){
    $('#btcc').hide();
    $('#spcc').show();
    $.post('../php_files/clear_cache.php',
    {p:'a'},
    function(data){
        $('#lb_cc').html('0.00B');
        $('#spcc').hide();
        $('#btcc').show();
    });
}
function viewMailServer(e){
    $(e).prop('disabled',true);
    $.post('../php_files/load_mail_server_data.php',
    {p:''},
    function(data){
        let arr=$.parseJSON(data);
        $('#smtp_host').val(arr['host']);
        $('#smtp_porrt').val(arr['port']);
        $('#smtp_secure').val(arr['secure']);
        $('#sw_mail_auth').prop('checked',arr['auth']);
        $('#smtp_username').val(arr['acc']);
        $('#smtp_password').val(arr['psw']);
        $('#mdl_mail').modal('show');
        $(e).prop('disabled',false);
    });
}
function viewPPClientID(){
    $.post('../php_files/load_paypal_client_id_data.php',
    {p:''},
    function(data){
        $('#ip_ppcid').val(data);
        $('#mdl_pp').modal('show');
    });
}
function updatePPClicntID(){
    let ppcid=$('#ip_ppcid').val();
    if(ppcid===''||ppcid===null){
        $('#ip_ppcid').removeClass('is-valid').addClass('is-invalid');
    }else{$('#ip_ppcid').removeClass('is-invalid').addClass('is-valid');
        $.post('../php_files/update_paypal_client_id.php',
        {ppcid:ppcid},
        function(data){
            if(data!==''){alert(data);}
            else{$('#mdl_pp').modal('hide');}
        });
    }
}