$('#page_title').html('Coupom Type');
$('.modal').on('hide.bs.modal',function(){
    $('.modal .form-control').val('');
    $('#add_dis_md,#edt_dis_md,.modal .form-control').removeClass('is-invalid').removeClass('is-valid');
    $('.btedt').prop('disabled',false);
    $('.modal .custom-control-input,.add_mode').prop('checked',false);
    $('#bted,#btad').show();
    $('#sped,#spad').hide();
});
loadData();
function swava(e,lb){
    if($(e).prop('checked')){$('#'+lb).html('Available');}
    else{$('#'+lb).html('Unavailable');}
}
function loadData(){
    $.post('../php_files/load_coupon_type_list.php',
    {p:''},
    function(data){
        $('#divcpty').html(data);
    });
}
function add(){
    let ava=$('#add_ava').prop('checked');
    let dsc=$('#add_dsc').val();
    let minpay=$('#add_minpay').val();
    let dis=$('#add_dis').val();
    let mode=$('input[name=add_mode]:checked').val();
    let dtexp=$('#add_dtexp').val();
    var pass=true;
    if(dsc===''||dsc===null){
        pass=false;
        $('#er_ad_dsc_mg').html(epfl);
        $('#add_dsc').removeClass('is-valid').addClass('is-invalid');
    }else if(dsc.length>30){
        pass=false;
        $('#er_ad_dsc_mg').html(maxCharacterMessage(30));
        $('#add_dsc').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(dsc)){
        pass=false;
        $('#er_ad_dsc_mg').html(stal);
        $('#add_dsc').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_dsc').removeClass('is-invalid').addClass('is-valid');}
    if(minpay===''||minpay===null){
        pass=false;
        $('#er_ad_minpay_mg').html(epfl);
        $('#add_minpay').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(minpay)){
        pass=false;
        $('#er_ad_minpay_mg').html(plno);
        $('#add_minpay').removeClass('is-valid').addClass('is-invalid');
    }else if(parseFloat(minpay)<0.01||parseFloat(minpay)>10000000){
        pass=false;
        $('#er_ad_minpay_mg').html(valueRangeMessage('0.01-10000000'));
        $('#add_minpay').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_minpay').removeClass('is-invalid').addClass('is-valid');}
    if(dis===''||dis===null){
        pass=false;
        $('#er_ad_dis_mg').html(epfl);
        $('#add_dis_md,#add_dis').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(dis)){
        pass=false;
        $('#er_ad_dis_mg').html(plno);
        $('#add_dis_md,#add_dis').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#add_dis').removeClass('is-invalid').addClass('is-valid');
        if(mode!=='c'&&mode!=='p'){
            pass=false;
            $('#er_ad_dis_mg').html('Please select mode.');
            $('#add_dis_md,.add_mode').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('.add_mode').removeClass('is-invalid');
            if(mode==='c'&&(parseFloat(dis)<0.01||parseFloat(dis)>10000000)){
                pass=false;
                $('#er_ad_dis_mg').html(valueRangeMessage('0.01-10000000'));
                $('#add_dis_md,#add_dis').removeClass('is-valid').addClass('is-invalid');
            }else if(mode==='p'&&(parseInt(dis)<1||parseInt(dis)>100)){
                pass=false;
                $('#er_ad_dis_mg').html(valueRangeMessage('1-100'));
                $('#add_dis_md,#add_dis').removeClass('is-valid').addClass('is-invalid');
            }else{$('#add_dis_md,#add_dis').removeClass('is-invalid').addClass('is-valid');}
        }
    }
    if(dtexp===''||dtexp===null){
        pass=false;
        $('#er_ad_dtexp_mg').html(epfl);
        $('#add_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(dtexp)){
        pass=false;
        $('#er_ad_dtexp_mg').html(plno);
        $('#add_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else if(parseInt(dtexp)<1||parseInt(dtexp)>99){
        pass=false;
        $('#er_ad_dtexp_mg').html(valueRangeMessage('1-99'));
        $('#add_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_dtexp').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        let form_data=new FormData();
        form_data.append('data[]',ava);
        form_data.append('data[]',dsc);
        form_data.append('data[]',minpay);
        form_data.append('data[]',dis);
        form_data.append('data[]',mode);
        form_data.append('data[]',dtexp);
         $.ajax({url:'../php_files/add_coupon_type.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);}
            else{
                loadData();
                $('.modal').modal('hide');
            }
            $('#spad').hide();
            $('#btad').show();
        }});
    }
}
function del(id,title){
    if(confirm('Delete coupon type '+title+' ?')){
        $('#ctedt'+id+',#ctdel'+id).prop('disabled',true);
        $.post('../php_files/delete_coupon_type.php',
        {id:id},
        function(data){
            if(data!==''){alert(data);}
            else{$('#ctdiv'+id).remove();}
        });
    }
}
function view(id){
    $.post('../php_files/load_coupon_type_data.php',
    {id:id},
    function(data){
        let arr=$.parseJSON(data);
        $('#edt_id').val(arr['ID']);
        $('#edt_dsc').val(arr['Description']);
        $('#edt_minpay').val(arr['MinPay']);
        if(arr['Mode']==='c'){
            $('#edt_dis').val(arr['Discount']);
            $('#edt_md_c').prop('checked',true);
        }
        else if(arr['Mode']==='p'){
            $('#edt_dis').val(parseInt(arr['Discount']));
            $('#edt_md_p').prop('checked',true);
        }
        $('#edt_dtexp').val(arr['DaysToExpired']);
        if(arr['Available']==='1'){$('#edt_ava').prop('checked',true);}
        else{$('#edt_ava').prop('checked',false);}
        $('#edt_modal').modal('show');
    });
}
function edit(){
    let id=$('#edt_id').val();
    let ava=$('#edt_ava').prop('checked');
    let dsc=$('#edt_dsc').val();
    let minpay=$('#edt_minpay').val();
    let dis=$('#edt_dis').val();
    let mode=$('input[name=edt_mode]:checked').val();
    let dtexp=$('#edt_dtexp').val();
    var pass=true;
    if(dsc===''||dsc===null){
        pass=false;
        $('#er_ed_dsc_mg').html(epfl);
        $('#edt_dsc').removeClass('is-valid').addClass('is-invalid');
    }else if(dsc.length>30){
        pass=false;
        $('#er_ed_dsc_mg').html(maxCharacterMessage(30));
        $('#edt_dsc').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(dsc)){
        pass=false;
        $('#er_ed_dsc_mg').html(stal);
        $('#edt_dsc').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_dsc').removeClass('is-invalid').addClass('is-valid');}
    if(minpay===''||minpay===null){
        pass=false;
        $('#er_ed_minpay_mg').html(epfl);
        $('#edt_minpay').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(minpay)){
        pass=false;
        $('#er_ed_minpay_mg').html(plno);
        $('#edt_minpay').removeClass('is-valid').addClass('is-invalid');
    }else if(parseFloat(minpay)<0.01||parseFloat(minpay)>10000000){
        pass=false;
        $('#er_ed_minpay_mg').html(valueRangeMessage('0.01-10000000'));
        $('#edt_minpay').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_minpay').removeClass('is-invalid').addClass('is-valid');}
    if(dis===''||dis===null){
        pass=false;
        $('#er_ed_dis_mg').html(epfl);
        $('#edt_dis_md,#edt_dis').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(dis)){
        pass=false;
        $('#er_ed_dis_mg').html(plno);
        $('#edt_dis_md,#edt_dis').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_dis').removeClass('is-invalid').addClass('is-valid');
        if(mode!=='c'&&mode!=='p'){
            pass=false;
            $('#er_ed_dis_mg').html('Please select mode.');
            $('#edt_dis_md,.edt_mode').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('.edt_mode').removeClass('is-invalid');
            if(mode==='c'&&(parseFloat(dis)<0.01||parseFloat(dis)>10000000)){
                pass=false;
                $('#er_ed_dis_mg').html(valueRangeMessage('0.01-10000000'));
                $('#edt_dis_md,#edt_dis').removeClass('is-valid').addClass('is-invalid');
            }else if(mode==='p'&&(parseInt(dis)<1||parseInt(dis)>100)){
                pass=false;
                $('#er_ed_dis_mg').html(valueRangeMessage('1-100'));
                $('#edt_dis_md,#edt_dis').removeClass('is-valid').addClass('is-invalid');
            }else{$('#edt_dis_md,#edt_dis').removeClass('is-invalid').addClass('is-valid');}
        }
    }
    if(dtexp===''||dtexp===null){
        pass=false;
        $('#er_ed_dtexp_mg').html(epfl);
        $('#edt_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(dtexp)){
        pass=false;
        $('#er_ed_dtexp_mg').html(plno);
        $('#edt_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else if(parseInt(dtexp)<1||parseInt(dtexp)>99){
        pass=false;
        $('#er_ed_dtexp_mg').html(valueRangeMessage('1-99'));
        $('#edt_dtexp').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_dtexp').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        $('#bted').hide();
        $('#sped').show();
        let form_data=new FormData();
        form_data.append('data[]',id);
        form_data.append('data[]',ava);
        form_data.append('data[]',dsc);
        form_data.append('data[]',minpay);
        form_data.append('data[]',dis);
        form_data.append('data[]',mode);
        form_data.append('data[]',dtexp);
        $.ajax({url:'../php_files/edit_coupon_type.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);}
            else{
                loadData();
                $('.modal').modal('hide');
            }
            $('#sped').hide();
            $('#bted').show();
        }});
    }
}