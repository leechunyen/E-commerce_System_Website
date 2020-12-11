$('#page_title').html('Admin');
var minpswlg;var pswcap;var edt_psw=false; var mode='*';var se='';var str=1;var stp=25;
if (!window.File||!window.FileReader||!window.FileList||!window.Blob){
    alert('The File APIs are not fully supported in this browser.');
}
loadData();setLabel();
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid');
    $('.modal *').removeClass('is-invalid');
    $('.modal .form-control').val('');
    $('#edt_photo').attr('src','../../img/df_user.png');
    $('#add_photo').attr('src','../../img/tmp_img.png');
    $('#spad,#spedt,#spdelacc').hide();
    $('#btad,#btedt,#btdelacc').show();
    $('#add_lb_swlc,#edt_lb_swlc').html('Unlocked');
    $('#edt_type_a,#add_type_a').prop('checked',true);
    $('#add_swlc,#add_gender_m,#add_gender_f,#edt_gender_m,#edt_gender_f').prop('checked',false);
    $('#file_edt_ph,#file_add_ph').val(null);
    $('#btedt').prop('disabled',false);
    gotoEditInfo();
});
function showAll(){
    mode='*';
    setLabel();
    loadData();
}
function showAdmin(){
    mode='a';
    setLabel();
    loadData();
}
function showSuperUser(){
    mode='s';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='a'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;Admin&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='s'){$('#lbmode').html('SuperUser');}
}
function reset(){
    $('#ipse').val('');
    $('#ipse').removeClass('is-invalid');
    mode='*';
    se='';
    setLabel();
    loadData();
}
function search(){
    let ip=$('#ipse').val();
    if(ip===null||ip===''){$('#ipse').addClass('is-invalid');}
    else{
        $('#ipse').removeClass('is-invalid');
        se=ip;
        loadData();
    }
}
function addDisplayPhoto(){
    let iv=getElementID('add_photo');
    let fl=getElementID('file_add_ph').files[0];
    if(fl&&fl.size>5242880){
        fl=null;
        alert('Logo only less than 5MB allowed.');
    }else{
        var reader=new FileReader();
        reader.onloadend=function (){iv.src=reader.result;};
        if (fl){
            reader.readAsDataURL(fl);
            $('#bt_ph_up').html('Change');
        }
    }
}
function edtDisplayPhoto(){
    let iv=getElementID('edt_photo');
    let fl=getElementID('file_edt_ph').files[0];
    if(fl&&fl.size>5242880){
        fl=null;
        alert('Logo only less than 5MB allowed.');
    }else{
        var reader=new FileReader();
        reader.onloadend=function (){iv.src=reader.result;};
        if (fl){reader.readAsDataURL(fl);}
    }
}
function addEdtLockSw(e,lb){
    if($(e).prop('checked')){
        $('#'+lb).html('Locked');
    }else{$('#'+lb).html('Unlocked');}
}
function changeNumOfRow(){
    stp=parseInt($('#sel_nor').val());
    loadData();
}
function next(){
    str=str+stp;
    loadData();
}
function previous(){
    str=str-stp;
    loadData();
}
function loadData(){
    $.post('../php_files/load_admin_list.php',
    {mode:mode,se:se,str:str,stp:stp},
    function(data){
        let js=$.parseJSON(data);
        $('#tb_adm').html(js[1]);
        $('#oprt').html(js[0]);
        if(js[0]>stp){
            $('.btnp').prop('disabled',false);
        }else{
            $('.btnp').prop('disabled',true);
        }
    });
}
function viewAdmin(id){
    $('#btview'+id).hide();
    $('#spview'+id).show();
    $.post('../php_files/load_admin_user_data.php',
    {id:id,type:'a'},
    function(data){
        let arr=$.parseJSON(data);
        if(arr['Self']){
            $('#edt_swlc,#edt_type *').prop('disabled',true);
            $('#bt_delacc').hide();
        }else{
            $('#edt_swlc,#edt_type *').prop('disabled',false);
            $('#bt_delacc').show();
        }
        $('#edt_id').val(arr['ID']);
        $('#edt_first_name').val(arr['FirstName']);
        $('#edt_last_name').val(arr['LastName']);
        $('#edt_username').val(arr['Username']);
        $('#edt_email').val(arr['Email']);
        var lc=false;if(arr['Locked']==='1'){lc=true;$('#edt_lb_swlc').html('Locked');}
        $('#edt_swlc').prop('checked',lc);
        if(arr['Type']==='a'){$('#edt_type_a').prop('checked',true);}
        else if(arr['Type']==='s'){$('#edt_type_s').prop('checked',true);}
        if(arr['Gender']==='m'){$('#edt_gender_m').prop('checked',true);}
        else if(arr['Gender']==='f'){$('#edt_gender_f').prop('checked',true);}
        if(arr['Photo']!==null){$('#edt_photo').attr('src','../..'+arr['Photo']);}
        $('#edt_modal').modal('show');
        $('#spview'+id).hide();
        $('#btview'+id).show();
    });
}
function gotoResetPassword(){
    $('#edt_edit').hide();
    $('#edt_rs_psw').show();
    edt_psw=true;
}
function gotoEditInfo(){
    $('#edt_rs_psw').hide();
    $('#edt_edit').show();
    edt_psw=false;
}
function deleteAdmin(){
    let id=$('#edt_id').val();
    if(confirm('Delete admin id='+id+'?')){
        $('#btdelacc').hide();$('#spdelacc').show();$('#btedt').prop('disabled',true);
        $.post('../../ua/php_files/delete_admin_user_account.php',
        {id:id,type:'a'},
        function(data){
            if(data===''){
                $('#edt_modal').modal('hide');
                $('#tbrw'+id).remove();
            }
            else{alert(data);}
            $('#spdelacc').hide();$('#btdelacc').show();$('#btedt').prop('disabled',false);
        });
    }
}
function addUsnExist(){
    $('#add_usn_invalid_mg').html(alex);
    $('#add_username').removeClass('is-valid');
    $('#add_username').addClass('is-invalid');
}
function addEmExist(){
    $('#add_email_invalid_mg').html(alex);
    $('#add_email').removeClass('is-valid');
    $('#add_email').addClass('is-invalid');
}
function edtUsnExist(){
    $('#edt_usn_invalid_mg').html(alex);
    $('#edt_username').removeClass('is-valid');
    $('#edt_username').addClass('is-invalid');
}
function edtEmExist(){
    $('#edt_email_invalid_mg').html(alex);
    $('#edt_email').removeClass('is-valid');
    $('#edt_email').addClass('is-invalid');
}
function add(){
    let photo=$('#file_add_ph').prop('files')[0];
    let type=$('input[name=add_type]:checked').val();
    let lock=$('#add_swlc').prop('checked');
    let fn=$('#add_first_name').val();
    let ln=$('#add_last_name').val();
    let usn=$('#add_username').val();
    let em=$('#add_email').val();
    let psw=$('#add_password').val();
    let cfpsw=$('#add_confirm_password').val();
    let gd=$('input[name=add_gender]:checked').val();
    var pass=true;
    if(type!=='a'&&type!=='s'){
        pass=false;
        $('#add_type').removeClass('is-valid');
        $('#add_type').addClass('is-invalid');
    }else{
        $('#add_type').removeClass('is-invalid');
        $('#add_type').addClass('is-valid');
    }
    if(gd!=='f'&&gd!=='m'){
        pass=false;
        $('#add_gd').removeClass('is-valid');
        $('#add_gd').addClass('is-invalid');
    }else{
        $('#add_gd').removeClass('is-invalid');
        $('#add_gd').addClass('is-valid');
    }
    if(fn===null||fn===''){
        pass=false;
        $('#add_fn_invalid_mg').html(epfl);
        $('#add_first_name').removeClass('is-valid');
        $('#add_first_name').addClass('is-invalid');
    }else if(fn.length>50){
        pass=false;
        $('#add_fn_invalid_mg').html(maxCharacterMessage(50));
        $('#add_first_name').removeClass('is-valid');
        $('#add_first_name').addClass('is-invalid');
    }else if(isSpecialCharacter(fn)){
        pass=false;
        $('#add_fn_invalid_mg').html(stal);
        $('#add_first_name').removeClass('is-valid');
        $('#add_first_name').addClass('is-invalid');
    }else{
        $('#add_first_name').removeClass('is-invalid');
        $('#add_first_name').addClass('is-valid');
    }
    if(ln===null||ln===''){
        pass=false;
        $('#add_ln_invalid_mg').html(epfl);
        $('#add_last_name').removeClass('is-valid');
        $('#add_last_name').addClass('is-invalid');
    }else if(ln.length>50){
        pass=false;
        $('#add_ln_invalid_mg').html(maxCharacterMessage(50));
        $('#add_last_name').removeClass('is-valid');
        $('#add_last_name').addClass('is-invalid');
    }else if(isSpecialCharacter(ln)){
        pass=false;
        $('#add_ln_invalid_mg').html(stal);
        $('#add_last_name').removeClass('is-valid');
        $('#add_last_name').addClass('is-invalid');
    }else{
        $('#add_last_name').removeClass('is-invalid');
        $('#add_last_name').addClass('is-valid');
    }
    if(usn===null||usn===''){
        pass=false;
        $('#add_usn_invalid_mg').html(epfl);
        $('#add_username').removeClass('is-valid');
        $('#add_username').addClass('is-invalid');
    }else if(usn.length>50){
        pass=false;
        $('#add_usn_invalid_mg').html(maxCharacterMessage(50));
        $('#add_username').removeClass('is-valid');
        $('#add_username').addClass('is-invalid');
    }else if(isSpecialCharacter(usn)){
        pass=false;
        $('#add_usn_invalid_mg').html(stal);
        $('#add_username').removeClass('is-valid');
        $('#add_username').addClass('is-invalid');
    }else{
        $('#add_username').removeClass('is-invalid');
        $('#add_username').addClass('is-valid');
    }
    if(em===null||em===''){
        pass=false;
        $('#add_email_invalid_mg').html(epfl);
        $('#add_email').removeClass('is-valid');
        $('#add_email').addClass('is-invalid');
    }else if(em.length>100){
        pass=false;
        $('#add_email_invalid_mg').html(maxCharacterMessage(100));
        $('#add_email').removeClass('is-valid');
        $('#add_email').addClass('is-invalid');
    }else if(!validateEmail(em)||isSpecialCharacter(em)){
        pass=false;
        $('#add_email_invalid_mg').html(ivem);
        $('#add_email').removeClass('is-valid');
        $('#add_email').addClass('is-invalid');
    }else{
        $('#add_email').removeClass('is-invalid');
        $('#add_email').addClass('is-valid');
    }
    if(psw===null||psw===''){
        pass=false;
        $('#add_psw_invalid_mg').html(epfl);
        $('#add_password').removeClass('is-valid');
        $('#add_password').addClass('is-invalid');
    }else if(psw.length>80){
        pass=false;
        $('#add_psw_invalid_mg').html(maxCharacterMessage(80));
        $('#add_password').removeClass('is-valid');
        $('#add_password').addClass('is-invalid');
    }else if((pswcap&&!isUppercaseIncluded(psw))||psw.length<minpswlg){
        pass=false;
        var ms='Minimum password length is '+minpswlg;
        if(pswcap){ms+=' and uppercase required';}
        $('#add_psw_invalid_mg').html(ms);
        $('#add_password').removeClass('is-valid');
        $('#add_password').addClass('is-invalid');
    }else{
        $('#add_password').removeClass('is-invalid');
        $('#add_password').addClass('is-valid');
    }
    if(cfpsw===null||cfpsw===''){
        pass=false;
        $('#add_cfpsw_invalid_mg').html(epfl);
        $('#add_confirm_password').removeClass('is-valid');
        $('#add_confirm_password').addClass('is-invalid');
    }else if(cfpsw.length>80){
        pass=false;
        $('#add_cfpsw_invalid_mg').html(maxCharacterMessage(80));
        $('#add_confirm_password').removeClass('is-valid');
        $('#add_confirm_password').addClass('is-invalid');
    }else if(cfpsw!==psw){
        pass=false;
        $('#add_cfpsw_invalid_mg').html(pwnm);
        $('#add_confirm_password').removeClass('is-valid');
        $('#add_confirm_password').addClass('is-invalid');
    }else{
        $('#add_confirm_password').removeClass('is-invalid');
        $('#add_confirm_password').addClass('is-valid');
    }
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        let form_data=new FormData();
        if(photo){form_data.append('data[]',photo);}
        form_data.append('data[]',type);
        form_data.append('data[]',lock);
        form_data.append('data[]',fn);
        form_data.append('data[]',ln);
        form_data.append('data[]',usn);
        form_data.append('data[]',em);
        form_data.append('data[]',psw);
        form_data.append('data[]',gd);
        $.ajax({url:'../php_files/add_admin.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data===''){
                $('#add_modal').modal('hide');
                loadData();
            }else if(data==='1'){
                addUsnExist();
            }else if(data==='2'){
                addEmExist();
            }else if(data==='12'){
                addUsnExist();
                addEmExist();
            }else{alert(data);}
            $('#spad').hide();
            $('#btad').show();
        }});
    }
}
function update(){
    let id=$('#edt_id').val();
    if(edt_psw){
        let nwpsw=$('#edt_nwpsw').val();
        let cfpsw=$('#edt_cfpsw').val();
        var pass=true;
        if(nwpsw===null||nwpsw===''){
            pass=false;
            $('#er_edt_nwpsw_mg').html(epfl);
            $('#edt_nwpsw').removeClass('is-valid');
            $('#edt_nwpsw').addClass('is-invalid');
        }else if(nwpsw.length>80){
            pass=false;
            $('#er_edt_nwpsw_mg').html(maxCharacterMessage(80));
            $('#edt_nwpsw').removeClass('is-valid');
            $('#edt_nwpsw').addClass('is-invalid');
        }else if((pswcap&&!isUppercaseIncluded(nwpsw))||nwpsw.length<minpswlg){
            pass=false;
            var ms='Minimum password length is '+minpswlg;
            if(pswcap){ms+=' and uppercase required';}
            $('#er_edt_nwpsw_mg').html(ms);
            $('#edt_nwpsw').removeClass('is-valid');
            $('#edt_nwpsw').addClass('is-invalid');
        }else{
            $('#edt_nwpsw').removeClass('is-invalid');
            $('#edt_nwpsw').addClass('is-valid');
        }
        if(cfpsw===null||cfpsw===''){
            pass=false;
            $('#er_edt_cfpsw_mg').html(epfl);
            $('#edt_cfpsw').removeClass('is-valid');
            $('#edt_cfpsw').addClass('is-invalid');
        }else if(cfpsw.length>80){
            pass=false;
            $('#er_edt_nwpsw_mg').html(maxCharacterMessage(80));
            $('#edt_nwpsw').removeClass('is-valid');
            $('#edt_nwpsw').addClass('is-invalid');
        }if(nwpsw!==cfpsw){
            pass=false;
            $('#er_edt_cfpsw_mg').html(pwnm);
            $('#edt_cfpsw').removeClass('is-valid');
            $('#edt_cfpsw').addClass('is-invalid');
        }else{
            $('#edt_cfpsw').removeClass('is-invalid');
            $('#edt_cfpsw').addClass('is-valid');
        }
        if(pass){
            $('#btedt').hide();
            $('#spedt').show();
            $.post('../../ua/php_files/change_admin_user_password.php',
            {psw:nwpsw,type:'a',id:id},
            function(data){
                if(data!==''){alert(data);}
                else{$('#edt_modal').modal('hide');}
                $('#spedt').hide();
                $('#btedt').show();
            });
        }
    }else{
        let photo=$('#file_edt_ph').prop('files')[0];
        let type=$('input[name=edt_type]:checked').val();
        let lock=$('#edt_swlc').prop('checked');
        let fn=$('#edt_first_name').val();
        let ln=$('#edt_last_name').val();
        let usn=$('#edt_username').val();
        let em=$('#edt_email').val();
        let gd=$('input[name=edt_gender]:checked').val();
        var pass=true;
        if(type!=='a'&&type!=='s'){
            pass=false;
            $('#edt_type').removeClass('is-valid');
            $('#edt_type').addClass('is-invalid');
        }else{
            $('#edt_type').removeClass('is-invalid');
            $('#edt_type').addClass('is-valid');
        }
        if(gd!=='f'&&gd!=='m'){
            pass=false;
            $('#edt_gd').removeClass('is-valid');
            $('#edt_gd').addClass('is-invalid');
        }else{
            $('#edt_gd').removeClass('is-invalid');
            $('#edt_gd').addClass('is-valid');
        }
        if(fn===null||fn===''){
            pass=false;
            $('#edt_fn_invalid_mg').html(epfl);
            $('#edt_first_name').removeClass('is-valid');
            $('#edt_first_name').addClass('is-invalid');
        }else if(fn.length>50){
            pass=false;
            $('#edt_fn_invalid_mg').html(maxCharacterMessage(50));
            $('#edt_first_name').removeClass('is-valid');
            $('#edt_first_name').addClass('is-invalid');
        }else if(isSpecialCharacter(fn)){
            pass=false;
            $('#edt_fn_invalid_mg').html(stal);
            $('#edt_first_name').removeClass('is-valid');
            $('#edt_first_name').addClass('is-invalid');
        }else{
            $('#edt_first_name').removeClass('is-invalid');
            $('#edt_first_name').addClass('is-valid');
        }
        if(ln===null||ln===''){
            pass=false;
            $('#edt_ln_invalid_mg').html(epfl);
            $('#edt_last_name').removeClass('is-valid');
            $('#edt_last_name').addClass('is-invalid');
        }else if(ln.length>50){
            pass=false;
            $('#edt_ln_invalid_mg').html(maxCharacterMessage(50));
            $('#edt_last_name').removeClass('is-valid');
            $('#edt_last_name').addClass('is-invalid');
        }else if(isSpecialCharacter(ln)){
            pass=false;
            $('#edt_ln_invalid_mg').html(stal);
            $('#edt_last_name').removeClass('is-valid');
            $('#edt_last_name').addClass('is-invalid');
        }else{
            $('#edt_last_name').removeClass('is-invalid');
            $('#edt_last_name').addClass('is-valid');
        }
        if(usn===null||usn===''){
            pass=false;
            $('#edt_usn_invalid_mg').html(epfl);
            $('#edt_username').removeClass('is-valid');
            $('#edt_username').addClass('is-invalid');
        }else if(usn.length>50){
            pass=false;
            $('#edt_usn_invalid_mg').html(maxCharacterMessage(50));
            $('#edt_username').removeClass('is-valid');
            $('#edt_username').addClass('is-invalid');
        }else if(isSpecialCharacter(usn)){
            pass=false;
            $('#edt_usn_invalid_mg').html(stal);
            $('#edt_username').removeClass('is-valid');
            $('#edt_username').addClass('is-invalid');
        }else{
            $('#edt_username').removeClass('is-invalid');
            $('#edt_username').addClass('is-valid');
        }
        if(em===null||em===''){
            pass=false;
            $('#edt_email_invalid_mg').html(epfl);
            $('#edt_email').removeClass('is-valid');
            $('#edt_email').addClass('is-invalid');
        }else if(em.length>100){
            pass=false;
            $('#edt_email_invalid_mg').html(maxCharacterMessage(100));
            $('#edt_email').removeClass('is-valid');
            $('#edt_email').addClass('is-invalid');
        }else if(!validateEmail(em)||isSpecialCharacter(em)){
            pass=false;
            $('#edt_email_invalid_mg').html(ivem);
            $('#edt_email').removeClass('is-valid');
            $('#edt_email').addClass('is-invalid');
        }else{
            $('#edt_email').removeClass('is-invalid');
            $('#edt_email').addClass('is-valid');
        }
        if(pass){
            $('#btedt').hide();
            $('#spedt').show();

            let form_data=new FormData();
            if(photo){form_data.append('data[]',photo);}
            form_data.append('data[]',type);
            form_data.append('data[]',lock);
            form_data.append('data[]',fn);
            form_data.append('data[]',ln);
            form_data.append('data[]',usn);
            form_data.append('data[]',em);
            form_data.append('data[]',gd);
            form_data.append('data[]',id);
            $.ajax({url:'../php_files/edit_admin.php',dataType:'text',
            cache:false,contentType:false,processData:false,data:form_data,
            type:'post',success:function(data){
            if(data===''){
                $('#edt_modal').modal('hide');
                    loadData();
                }else if(data==='1'){
                    edtUsnExist();
                }else if(data==='2'){
                    edtEmExist();
                }else if(data==='12'){
                    edtUsnExist();
                    edtEmExist();
                }else{alert(data);}
                $('#spedt').hide();
                $('#btedt').show();
            }});
        }
    }
}