$('#page_title').html('User');
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
    $('#add_lb_swac,#edt_lb_swac').html('Deactivated');
    $('#add_swlc,#add_swac,#edt_swlc,#edt_swac,#add_gd_m,#add_gd_f,#edt_gd_m,#edt_gd_f').prop('checked',false);
    $('#file_edt_ph,#file_add_ph').val(null);
    $('#btedt').prop('disabled',false);
    gotoEditInfo();
});
$('.sel_country_sel').html('<option value=\'\'>--</option>');
for(const property in countryListAlpha2) {
    $('.sel_country_sel').append(`<option value='${property}'>${countryListAlpha2[property]}</option>`);
}
function showAll(){
    mode='*';
    setLabel();
    loadData();
}
function showActive(){
    mode='a';
    setLabel();
    loadData();
}
function showLocked(){
    mode='l';
    setLabel();
    loadData();
}
function showDeleted(){
    mode='d';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='a'){$('#lbmode').html('&nbsp;&nbsp;Active&nbsp;&nbsp;');}
    else if(mode==='l'){$('#lbmode').html('&nbsp;Locked&nbsp;');}
    else if(mode==='d'){$('#lbmode').html('&nbsp;Deleted');}
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
function addEdtActivateSw(e,lb){
    if($(e).prop('checked')){
        $('#'+lb).html('Activated');
    }else{$('#'+lb).html('Deactivated');}
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
function addUsnExist(){
    $('#add_er_usn_mg').html(alex);
    $('#add_usn').removeClass('is-valid');
    $('#add_usn').addClass('is-invalid');
}
function addEmExist(){
    $('#add_er_em_mg').html(alex);
    $('#add_em').removeClass('is-valid');
    $('#add_em').addClass('is-invalid');
}
function edtUsnExist(){
    $('#edt_er_usn_mg').html(alex);
    $('#edt_usn').removeClass('is-valid');
    $('#edt_usn').addClass('is-invalid');
}
function edtEmExist(){
    $('#edt_er_em_mg').html(alex);
    $('#edt_em').removeClass('is-valid');
    $('#edt_em').addClass('is-invalid');
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
function loadData(){
    $.post('../php_files/load_user_list.php',
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
function viewUser(id){
    $('#btview'+id).hide();
    $('#spview'+id).show();
    $.post('../php_files/load_admin_user_data.php',
    {id:id,type:'u'},
    function(data){
        let arr=$.parseJSON(data);
        $('#edt_id').val(arr['ID']);
        $('#edt_fn').val(arr['FirstName']);
        $('#edt_ln').val(arr['LastName']);
        $('#edt_usn').val(arr['Username']);
        $('#edt_em').val(arr['Email']);
        $('#edt_dob_d').val(arr['DobDay']);
        $('#edt_dob_m').val(arr['DobMonth']);
        $('#edt_dob_y').val(arr['DobYear']);
        $('#edt_country_sel').val(arr['CountryRegional']);
        var lc=false;if(arr['Locked']==='1'){lc=true;$('#edt_lb_swlc').html('Locked');}
        $('#edt_swlc').prop('checked',lc);
        var ac=false;if(arr['Activated']==='1'){ac=true;$('#edt_lb_swac').html('Activated');}
        $('#edt_swac').prop('checked',ac);
        if(arr['Gender']==='m'){$('#edt_gd_m').prop('checked',true);}
        else if(arr['Gender']==='f'){$('#edt_gd_f').prop('checked',true);}
        if(arr['Photo']!==null){$('#edt_photo').attr('src','../..'+arr['Photo']);}
        if(arr['Deleted']==='1'){
            $('#edt_modal .form-control,#edt_modal .custom-control-input,#btedt').prop('disabled',true);
            $('#edt_modal .middle,#edt_modal #btrsacps,#edt_modal #btdelacc').hide();
            $('#btrecacc').show();
        }else{
            $('#edt_modal .form-control,#edt_modal .custom-control-input,#btedt').prop('disabled',false);
            $('#edt_modal .middle,#edt_modal #btrsacps,#edt_modal #btdelacc').show();
            $('#btrecacc').hide();
        }
        $('#edt_id').prop('disabled',true);
        $('#edt_modal').modal('show');
        $('#spview'+id).hide();
        $('#btview'+id).show();
    });
}
function deleteUser(){
    let id=$('#edt_id').val();
    if(confirm('Delete user id='+id+'?')){
        $('#btdelacc').hide();$('#spdelacc').show();$('#btedt').prop('disabled',true);
        $.post('../../ua/php_files/delete_admin_user_account.php',
        {id:id,type:'u'},
        function(data){
            if(data===''){
                $('#edt_modal').modal('hide');
                loadData();
            }else{alert(data);}
            $('#spdelacc').hide();$('#btdelacc').show();$('#btedt').prop('disabled',false);
        });
    }
}
function add(){
    let photo=$('#file_add_ph').prop('files')[0];
    let lock=$('#add_swlc').prop('checked');
    let act=$('#add_swac').prop('checked');
    let fn=$('#add_fn').val();
    let ln=$('#add_ln').val();
    let usn=$('#add_usn').val();
    let em=$('#add_em').val();
    let psw=$('#add_psw').val();
    let cfpsw=$('#add_cpsw').val();
    let dobd=$('#add_dob_d').val();
    let dobm=$('#add_dob_m').val();
    let doby=$('#add_dob_y').val();
    let ctry=$('#add_country_sel').val();
    let gd=$('input[name=add_gender]:checked').val();
    var pass=true;
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
        $('#add_er_fn_mg').html(epfl);
        $('#add_fn').removeClass('is-valid');
        $('#add_fn').addClass('is-invalid');
    }else if(fn.length>50){
        pass=false;
        $('#add_er_fn_mg').html(maxCharacterMessage(50));
        $('#add_fn').removeClass('is-valid');
        $('#add_fn').addClass('is-invalid');
    }else if(isSpecialCharacter(fn)){
        pass=false;
        $('#add_er_fn_mg').html(stal);
        $('#add_fn').removeClass('is-valid');
        $('#add_fn').addClass('is-invalid');
    }else{
        $('#add_fn').removeClass('is-invalid');
        $('#add_fn').addClass('is-valid');
    }
    if(ln===null||ln===''){
        pass=false;
        $('#add_er_ln_mg').html(epfl);
        $('#add_ln').removeClass('is-valid');
        $('#add_ln').addClass('is-invalid');
    }else if(ln.length>50){
        pass=false;
        $('#add_er_ln_mg').html(maxCharacterMessage(50));
        $('#add_ln').removeClass('is-valid');
        $('#add_ln').addClass('is-invalid');
    }else if(isSpecialCharacter(ln)){
        pass=false;
        $('#add_er_ln_mg').html(stal);
        $('#add_ln').removeClass('is-valid');
        $('#add_ln').addClass('is-invalid');
    }else{
        $('#add_ln').removeClass('is-invalid');
        $('#add_ln').addClass('is-valid');
    }
    if(usn===null||usn===''){
        pass=false;
        $('#add_er_usn_mg').html(epfl);
        $('#add_usn').removeClass('is-valid');
        $('#add_usn').addClass('is-invalid');
    }else if(usn.length>50){
        pass=false;
        $('#add_er_usn_mg').html(maxCharacterMessage(50));
        $('#add_usn').removeClass('is-valid');
        $('#add_usn').addClass('is-invalid');
    }else if(isSpecialCharacter(usn)){
        pass=false;
        $('#add_er_usn_mg').html(stal);
        $('#add_usn').removeClass('is-valid');
        $('#add_usn').addClass('is-invalid');
    }else{
        $('#add_usn').removeClass('is-invalid');
        $('#add_usn').addClass('is-valid');
    }
    if(em===null||em===''){
        pass=false;
        $('#add_er_em_mg').html(epfl);
        $('#add_em').removeClass('is-valid');
        $('#add_em').addClass('is-invalid');
    }else if(em.length>100){
        pass=false;
        $('#add_er_em_mg').html(maxCharacterMessage(100));
        $('#add_em').removeClass('is-valid');
        $('#add_em').addClass('is-invalid');
    }else if(!validateEmail(em)||isSpecialCharacter(em)){
        pass=false;
        $('#add_er_em_mg').html(ivem);
        $('#add_em').removeClass('is-valid');
        $('#add_em').addClass('is-invalid');
    }else{
        $('#add_em').removeClass('is-invalid');
        $('#add_em').addClass('is-valid');
    }
    if(psw===null||psw===''){
        pass=false;
        $('#add_er_psw_mg').html(epfl);
        $('#add_psw').removeClass('is-valid');
        $('#add_psw').addClass('is-invalid');
    }else if(psw.length>80){
        pass=false;
        $('#add_er_psw_mg').html(maxCharacterMessage(80));
        $('#add_psw').removeClass('is-valid');
        $('#add_psw').addClass('is-invalid');
    }else if((pswcap&&!isUppercaseIncluded(psw))||psw.length<minpswlg){
        pass=false;
        var ms='Minimum password length is '+minpswlg;
        if(pswcap){ms+=' and uppercase required';}
        $('#add_er_psw_mg').html(ms);
        $('#add_psw').removeClass('is-valid');
        $('#add_psw').addClass('is-invalid');
    }else{
        $('#add_psw').removeClass('is-invalid');
        $('#add_psw').addClass('is-valid');
    }
    if(cfpsw===null||cfpsw===''){
        pass=false;
        $('#add_er_cpsw_mg').html(epfl);
        $('#add_cpsw').removeClass('is-valid');
        $('#add_cpsw').addClass('is-invalid');
    }else if(cfpsw.length>80){
        pass=false;
        $('#add_er_cpsw_mg').html(maxCharacterMessage(80));
        $('#add_cpsw').removeClass('is-valid');
        $('#add_cpsw').addClass('is-invalid');
    }else if(cfpsw!==psw){
        pass=false;
        $('#add_er_cpsw_mg').html(pwnm);
        $('#add_cpsw').removeClass('is-valid');
        $('#add_cpsw').addClass('is-invalid');
    }else{
        $('#add_cpsw').removeClass('is-invalid');
        $('#add_cpsw').addClass('is-valid');
    }
    if(ctry===null||ctry===''){
        $('#add_country_sel').removeClass('is-valid');
        $('#add_country_sel').addClass('is-invalid');
    }else{
        $('#add_country_sel').removeClass('is-invalid');
        $('#add_country_sel').addClass('is-valid');
    }
    if(dobd===null||dobd===''||dobm===null||dobm===''||doby===null||doby===''){
        if(dobd===null||dobd===''){
            $('#add_er_dob_d_mg').html(plsl);
            $('#add_dob_d').removeClass('is-valid');
            $('#add_dob_d').addClass('is-invalid');
        }else{
            $('#add_dob_d').removeClass('is-invalid');
            $('#add_dob_d').addClass('is-valid');
        }
        if(dobm===null||dobm===''){
            $('#add_er_dob_m_mg').html(plsl);
            $('#add_dob_m').removeClass('is-valid');
            $('#add_dob_m').addClass('is-invalid');
        }else{
            $('#add_dob_m').removeClass('is-invalid');
            $('#add_dob_m').addClass('is-valid');
        }
        if(doby===null||doby===''){
            $('#add_er_dob_y_mg').html(plsl);
            $('#add_dob_y').removeClass('is-valid');
            $('#add_dob_y').addClass('is-invalid');
        }else{
            $('#add_dob_y').removeClass('is-invalid');
            $('#add_dob_y').addClass('is-valid');
        }
    }else if(!isValidDate(dobm+'-'+dobd+'-'+doby,'-')){
        pass=false;
        $('#add_er_dob_d_mg').html(ivdt);
        $('#add_er_dob_m_mg').html(ivdt);
        $('#add_er_dob_y_mg').html(ivdt);
        $('#add_dob_d').removeClass('is-valid');
        $('#add_dob_d').addClass('is-invalid');
        $('#add_dob_m').removeClass('is-valid');
        $('#add_dob_m').addClass('is-invalid');
        $('#add_dob_y').removeClass('is-valid');
        $('#add_dob_y').addClass('is-invalid');
    }else{
        $('#add_dob_d').removeClass('is-invalid');
        $('#add_dob_d').addClass('is-valid');
        $('#add_dob_m').removeClass('is-invalid');
        $('#add_dob_m').addClass('is-valid');
        $('#add_dob_y').removeClass('is-invalid');
        $('#add_dob_y').addClass('is-valid');
    }
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        let form_data=new FormData();
        if(photo){form_data.append('data[]',photo);}
        form_data.append('data[]',lock);
        form_data.append('data[]',act);
        form_data.append('data[]',fn);
        form_data.append('data[]',ln);
        form_data.append('data[]',usn);
        form_data.append('data[]',em);
        form_data.append('data[]',psw);
        form_data.append('data[]',dobd);
        form_data.append('data[]',dobm);
        form_data.append('data[]',doby);
        form_data.append('data[]',ctry);
        form_data.append('data[]',gd);
        $.ajax({url:'../php_files/add_user.php',dataType:'text',
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
            {psw:nwpsw,type:'u',id:id},
            function(data){
                if(data!==''){alert(data);}
                else{$('#edt_modal').modal('hide');}
                $('#spedt').hide();
                $('#btedt').show();
            });
        }
    }else{
        let photo=$('#file_edt_ph').prop('files')[0];
        let lock=$('#edt_swlc').prop('checked');
        let act=$('#edt_swac').prop('checked');
        let fn=$('#edt_fn').val();
        let ln=$('#edt_ln').val();
        let usn=$('#edt_usn').val();
        let em=$('#edt_em').val();
        let dobd=$('#edt_dob_d').val();
        let dobm=$('#edt_dob_m').val();
        let doby=$('#edt_dob_y').val();
        let ctry=$('#edt_country_sel').val();
        let gd=$('input[name=edt_gender]:checked').val();
        var pass=true;
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
            $('#edt_er_fn_mg').html(epfl);
            $('#edt_fn').removeClass('is-valid');
            $('#edt_fn').addClass('is-invalid');
        }else if(fn.length>50){
            pass=false;
            $('#edt_er_fn_mg').html(maxCharacterMessage(50));
            $('#edt_fn').removeClass('is-valid');
            $('#edt_fn').addClass('is-invalid');
        }else if(isSpecialCharacter(fn)){
            pass=false;
            $('#edt_er_fn_mg').html(stal);
            $('#edt_fn').removeClass('is-valid');
            $('#edt_fn').addClass('is-invalid');
        }else{
            $('#edt_fn').removeClass('is-invalid');
            $('#edt_fn').addClass('is-valid');
        }
        if(ln===null||ln===''){
            pass=false;
            $('#edt_er_ln_mg').html(epfl);
            $('#edt_ln').removeClass('is-valid');
            $('#edt_ln').addClass('is-invalid');
        }else if(ln.length>50){
            pass=false;
            $('#edt_er_ln_mg').html(maxCharacterMessage(50));
            $('#edt_ln').removeClass('is-valid');
            $('#edt_ln').addClass('is-invalid');
        }else if(isSpecialCharacter(ln)){
            pass=false;
            $('#edt_er_ln_mg').html(stal);
            $('#edt_ln').removeClass('is-valid');
            $('#edt_ln').addClass('is-invalid');
        }else{
            $('#edt_ln').removeClass('is-invalid');
            $('#edt_ln').addClass('is-valid');
        }
        if(usn===null||usn===''){
            pass=false;
            $('#edt_er_usn_mg').html(epfl);
            $('#edt_usn').removeClass('is-valid');
            $('#edt_usn').addClass('is-invalid');
        }else if(usn.length>50){
            pass=false;
            $('#edt_er_usn_mg').html(maxCharacterMessage(50));
            $('#edt_usn').removeClass('is-valid');
            $('#edt_usn').addClass('is-invalid');
        }else if(isSpecialCharacter(usn)){
            pass=false;
            $('#edt_er_usn_mg').html(stal);
            $('#edt_usn').removeClass('is-valid');
            $('#edt_usn').addClass('is-invalid');
        }else{
            $('#edt_usn').removeClass('is-invalid');
            $('#edt_usn').addClass('is-valid');
        }
        if(em===null||em===''){
            pass=false;
            $('#edt_er_em_mg').html(epfl);
            $('#edt_em').removeClass('is-valid');
            $('#edt_em').addClass('is-invalid');
        }else if(em.length>100){
            pass=false;
            $('#edt_er_em_mg').html(maxCharacterMessage(100));
            $('#edt_em').removeClass('is-valid');
            $('#edt_em').addClass('is-invalid');
        }else if(!validateEmail(em)||isSpecialCharacter(em)){
            pass=false;
            $('#edt_er_em_mg').html(ivem);
            $('#edt_em').removeClass('is-valid');
            $('#edt_em').addClass('is-invalid');
        }else{
            $('#edt_em').removeClass('is-invalid');
            $('#edt_em').addClass('is-valid');
        }
        if(ctry===null||ctry===''){
            $('#edt_country_sel').removeClass('is-valid');
            $('#edt_country_sel').addClass('is-invalid');
        }else{
            $('#edt_country_sel').removeClass('is-invalid');
            $('#edt_country_sel').addClass('is-valid');
        }
        if(dobd===null||dobd===''||dobm===null||dobm===''||doby===null||doby===''){
            if(dobd===null||dobd===''){
                $('#edt_er_dob_d_mg').html(plsl);
                $('#edt_dob_d').removeClass('is-valid');
                $('#edt_dob_d').addClass('is-invalid');
            }else{
                $('#edt_dob_d').removeClass('is-invalid');
                $('#edt_dob_d').addClass('is-valid');
            }
            if(dobm===null||dobm===''){
                $('#edt_er_dob_m_mg').html(plsl);
                $('#edt_dob_m').removeClass('is-valid');
                $('#edt_dob_m').addClass('is-invalid');
            }else{
                $('#edt_dob_m').removeClass('is-invalid');
                $('#edt_dob_m').addClass('is-valid');
            }
            if(doby===null||doby===''){
                $('#edt_er_dob_y_mg').html(plsl);
                $('#edt_dob_y').removeClass('is-valid');
                $('#edt_dob_y').addClass('is-invalid');
            }else{
                $('#edt_dob_y').removeClass('is-invalid');
                $('#edt_dob_y').addClass('is-valid');
            }
        }else if(!isValidDate(dobm+'-'+dobd+'-'+doby,'-')){
            pass=false;
            $('#edt_er_dob_d_mg').html(ivdt);
            $('#edt_er_dob_m_mg').html(ivdt);
            $('#edt_er_dob_y_mg').html(ivdt);
            $('#edt_dob_d').removeClass('is-valid');
            $('#edt_dob_d').addClass('is-invalid');
            $('#edt_dob_m').removeClass('is-valid');
            $('#edt_dob_m').addClass('is-invalid');
            $('#edt_dob_y').removeClass('is-valid');
            $('#edt_dob_y').addClass('is-invalid');
        }else{
            $('#edt_dob_d').removeClass('is-invalid');
            $('#edt_dob_d').addClass('is-valid');
            $('#edt_dob_m').removeClass('is-invalid');
            $('#edt_dob_m').addClass('is-valid');
            $('#edt_dob_y').removeClass('is-invalid');
            $('#edt_dob_y').addClass('is-valid');
        }
        if(pass){
            $('#btedt').hide();
            $('#spedt').show();
            let form_data=new FormData();
            if(photo){form_data.append('data[]',photo);}
            form_data.append('data[]',lock);
            form_data.append('data[]',act);
            form_data.append('data[]',fn);
            form_data.append('data[]',ln);
            form_data.append('data[]',usn);
            form_data.append('data[]',em);
            form_data.append('data[]',dobd);
            form_data.append('data[]',dobm);
            form_data.append('data[]',doby);
            form_data.append('data[]',ctry);
            form_data.append('data[]',gd);
            form_data.append('data[]',id);
            $.ajax({url:'../php_files/edit_user.php',dataType:'text',
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
function recoverAcc(){
    let id=$('#edt_id').val();
    if(confirm('Recover user id='+id+'?')){
        $('#btrecacc').hide();$('#spdelacc').show();
        $.post('../php_files/recover_user.php',
        {id:id},
        function(data){
            let arr=$.parseJSON(data);
            if(arr['ermg']){
                alert(arr['ermg']);
                 $('#spdelacc').hide();$('#btrecacc').show();
            }
            else{
                $('#edt_usn').val(arr['usn']);
                $('#edt_em').val(arr['em']);
                if(arr['er']===1){
                    edtUsnExist();
                }else if(arr['er']===2){
                    edtEmExist();
                }else if(arr['er']===3){
                    edtUsnExist();
                    edtEmExist();
                }
                $('#edt_modal .form-control,#edt_modal .custom-control-input,#btedt').prop('disabled',false);
                $('#edt_modal .middle,#edt_modal #btrsacps,#edt_modal #btdelacc').show();
                $('#btrecacc,#spdelacc').hide();
                loadData();
            }
           
        });
    }
}