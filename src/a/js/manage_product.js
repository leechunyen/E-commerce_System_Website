$('#page_title').html('Product');
var mode='*';var se='';var str=1;var stp=25;
$(function(){
    $( ".datepicker" ).datetimepicker({
        minDate:moment(),
        format :'MM/DD/YYYY HH:mm',
        showClear:true,
        useCurrent:true,
        showClose:true,
        showTodayButton:true
    });
});
$('#add_detail').each(function(){
    this.setAttribute('style','height:'+(this.scrollHeight)+'px;overflow-y:hidden;');
}).on('input',function(){
    this.style.height='auto';
    this.style.height=(this.scrollHeight)+'px';
});
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid');
    $('.modal *').removeClass('is-invalid');
    $('.modal .form-control').val('');
    $('#add_photo, #edt_photo').attr('src','../../img/tmp_img.png');
    $('#spad,#spedt').hide();
    $('#btad,#btedt').show();
    $('#add_dateautounava,#add_dateautoava').prop('disabled',true);
    $('#add_swava,.add_atavasw').prop('checked',false);
    $('#add_lbswava').html('Unavailable');
    $('.add_swatavalb').html('Disabled');
    $('#file_edt_ph,#file_add_ph,#add_imgarr,#edt_imgarr').val(null);
    $('.imgs_arr').remove();
});
setLabel();loadData();
function showAll(){
    mode='*';
    setLabel();
    loadData();
}
function showAvailable(){
    mode='a';
    setLabel();
    loadData();
}
function showUnavailable(){
    mode='u';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='a'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;Available&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='u'){$('#lbmode').html('Unavailable');}
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
    $.post('../php_files/load_product_list.php',
    {mode:mode,se:se,str:str,stp:stp},
    function(data){
        let js=$.parseJSON(data);
        $('#tb_ls').html(js[1]);
        $('#oprt').html(js[0]);
        if(js[0]>stp){
            $('.btnp').prop('disabled',false);
        }else{
            $('.btnp').prop('disabled',true);
        }
    });
}
function imgArrDisplay(e){
    let fls=$(e).prop('files');
    $('.imgs_arr').remove();
    for(var x=0;x<fls.length;x++){
        let fl=$(e).prop('files')[x];
        if(fl){
            let reader=new FileReader();
            reader.addEventListener("load",function(){
                let src=reader.result;
                $(e).parent().append(`<img class="imgs_arr" src="${src}"/>`);
            },false);
            reader.readAsDataURL(fl);
        }
    }
}
function availableSw(e,lb){
    if($(e).prop('checked')){$('#'+lb).html('Available');}
    else{$('#'+lb).html('Unavailable');}
}
function autoAvaUnavaSw(e,lb){
    if($(e).prop('checked')){
        $('#'+lb).html('Enabled');
        if(lb==='add_lbswatava'){
            $('#add_dateautoava').prop('disabled',false);
        }else if(lb==='add_lbswatunava'){
            $('#add_dateautounava').prop('disabled',false);
        }
    }else{
        $('#'+lb).html('Disabled');
        if(lb==='add_lbswatava'){
            $('#add_dateautoava').prop('disabled',true);
            $('#add_dateautoava').removeClass('is-valid');
            $('#add_dateautoava').removeClass('is-invalid');
            $('#add_dateautoava').val('');
        }else if(lb==='add_lbswatunava'){
            $('#add_dateautounava').prop('disabled',true);
            $('#add_dateautounava').removeClass('is-valid');
            $('#add_dateautounava').removeClass('is-invalid');
            $('#add_dateautounava').val('');
        }
    }
}
function add(){
    let dfphoto=$('#file_add_ph').prop('files')[0];
    let name=$('#add_name').val();
    let model=$('#add_model').val();
    let price=$('#add_price').val();
    let stock=$('#add_stock').val();
    let orpoi=$('#add_reordrtpoint').val();
    let avail=$('#add_swava').prop('checked');
    let dtautoava=$('#add_dateautoava').val();
    let dtautounava=$('#add_dateautounava').val();
    let detail=$('#add_detail').val();
    let swatava=$('#add_swatava').prop('checked');
    let swatunava=$('#add_swatunava').prop('checked');
    var pass=true;var dtpass=true;
    if(!dfphoto){
        pass=false;
        $('#add_dfphoto_er').removeClass('is-valid');
        $('#add_dfphoto_er').addClass('is-invalid');
    }else{
        $('#add_dfphoto_er').removeClass('is-invalid');
        $('#add_dfphoto_er').addClass('is-valid');
    }
    if(name===null||name===''){
        pass=false;
        $('#add_name_ermg').html(epfl);
        $('#add_name').removeClass('is-valid');
        $('#add_name').addClass('is-invalid');
    }else if(name.length>50){
        pass=false;
        $('#add_name_ermg').html(maxCharacterMessage(50));
        $('#add_name').removeClass('is-valid');
        $('#add_name').addClass('is-invalid');
    }else if(isSpecialCharacter(name)){
        pass=false;
        $('#add_name_ermg').html(stal);
        $('#add_name').removeClass('is-valid');
        $('#add_name').addClass('is-invalid');
    }else{
        $('#add_name').removeClass('is-invalid');
        $('#add_name').addClass('is-valid');
    }
    if(model===null||model===''){
        pass=false;
        $('#add_model_ermg').html(epfl);
        $('#add_model').removeClass('is-valid');
        $('#add_model').addClass('is-invalid');
    }else if(model.length>50){
        pass=false;
        $('#add_model_ermg').html(maxCharacterMessage(50));
        $('#add_model').removeClass('is-valid');
        $('#add_model').addClass('is-invalid');
    }else if(isSpecialCharacter(model)){
        pass=false;
        $('#add_model_ermg').html(stal);
        $('#add_model').removeClass('is-valid');
        $('#add_model').addClass('is-invalid');
    }else{
        $('#add_model').removeClass('is-invalid');
        $('#add_model').addClass('is-valid');
    }
    if(price===null||price===''){
        pass=false;
        $('#add_price_ermg').html(epfl);
        $('#add_price').removeClass('is-valid');
        $('#add_price').addClass('is-invalid');
    }else if(isNaN(price)){
        pass=false;
        $('#add_price_ermg').html(plno);
        $('#add_price').removeClass('is-valid');
        $('#add_price').addClass('is-invalid');
    }else if(parseFloat(price)<0.01||parseFloat(price)>10000000){
        pass=false;
        $('#add_price_ermg').html(valueRangeMessage('0.01-10000000'));
        $('#add_price').removeClass('is-valid');
        $('#add_price').addClass('is-invalid');
    }else{
        $('#add_price').removeClass('is-invalid');
        $('#add_price').addClass('is-valid');
    }
    if(stock===null||stock===''){
        pass=false;
        $('#add_stock_ermg').html(epfl);
        $('#add_stock').removeClass('is-valid');
        $('#add_stock').addClass('is-invalid');
    }else if(isNaN(stock)){
        pass=false;
        $('#add_stock_ermg').html(plno);
        $('#add_stock').removeClass('is-valid');
        $('#add_stock').addClass('is-invalid');
    }else if(parseInt(stock)<0||parseInt(stock)>10000){
        pass=false;
        $('#add_stock_ermg').html(valueRangeMessage('0-10000'));
        $('#add_stock').removeClass('is-valid');
        $('#add_stock').addClass('is-invalid');
    }else{
        $('#add_stock').removeClass('is-invalid');
        $('#add_stock').addClass('is-valid');
    }
    if(orpoi===null||orpoi===''){
        pass=false;
        $('#add_reorderpoint_ermg').html(epfl);
        $('#add_reordrtpoint').removeClass('is-valid');
        $('#add_reordrtpoint').addClass('is-invalid');
    }else if(isNaN(orpoi)){
        pass=false;
        $('#add_reorderpoint_ermg').html(plno);
        $('#add_reordrtpoint').removeClass('is-valid');
        $('#add_reordrtpoint').addClass('is-invalid');
    }else if(parseInt(orpoi)<0||parseInt(orpoi)>9999){
        pass=false;
        $('#add_reorderpoint_ermg').html(valueRangeMessage('0-9999'));
        $('#add_reordrtpoint').removeClass('is-valid');
        $('#add_reordrtpoint').addClass('is-invalid');
    }else{
        $('#add_reordrtpoint').removeClass('is-invalid');
        $('#add_reordrtpoint').addClass('is-valid');
    }
    if(detail===null||detail===''){
        pass=false;
        $('#add_detailermg').html(epfl);
        $('#add_detail').removeClass('is-valid');
        $('#add_detail').addClass('is-invalid');
    }else if(detail.length>16777215 ){
        pass=false;
        $('#add_detailermg').html(maxCharacterMessage(16777215));
        $('#add_detail').removeClass('is-valid');
        $('#add_detail').addClass('is-invalid');
    }else{
        $('#add_detail').removeClass('is-invalid');
        $('#add_detail').addClass('is-valid');
    }
    if(swatava){
        if(dtautoava===null||dtautoava===''){
            pass=false;dtpass=false;
            $('#add_dateautoava_ermg').html(epfl);
            $('#add_dateautoava').removeClass('is-valid');
            $('#add_dateautoava').addClass('is-invalid');
        }else if(!isValidDateTime(dtautoava)){
             pass=false;dtpass=false;
            $('#add_dateautoava_ermg').html(ivtd);
            $('#add_dateautoava').removeClass('is-valid');
            $('#add_dateautoava').addClass('is-invalid');
        }else{
            $('#add_dateautoava').removeClass('is-invalid');
            $('#add_dateautoava').addClass('is-valid');
        }
    }
    if(swatunava){
        if(dtautounava===null||dtautounava===''){
            pass=false;dtpass=false;
            $('#add_dateautounava_ermg').html(epfl);
            $('#add_dateautounava').removeClass('is-valid');
            $('#add_dateautounava').addClass('is-invalid');
        }else if(!isValidDateTime(dtautounava)){
             pass=false;dtpass=false;
            $('#add_dateautounava_ermg').html(ivtd);
            $('#add_dateautounava').removeClass('is-valid');
            $('#add_dateautounava').addClass('is-invalid');
        }else{
            $('#add_dateautounava').removeClass('is-invalid');
            $('#add_dateautounava').addClass('is-valid');
        }
    }
    if(swatava&&swatunava&&dtpass){
        if(stringToDateTime(dtautounava)<=stringToDateTime(dtautoava)){
            pass=false;
            $('#add_dateautounava_ermg').html(atua);
             $('#add_dateautounava').removeClass('is-valid');
            $('#add_dateautounava').addClass('is-invalid');
        }else{
            $('#add_dateautounava').removeClass('is-invalid');
            $('#add_dateautounava').addClass('is-valid');
        }
    }
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        let otphoto=$('#add_imgarr').prop('files');
        let form_data=new FormData();
        form_data.append('data[]',dfphoto);
        form_data.append('data[]',name);
        form_data.append('data[]',model);
        form_data.append('data[]',price);
        form_data.append('data[]',stock);
        form_data.append('data[]',orpoi);
        form_data.append('data[]',avail);
        form_data.append('data[]',dtautoava);
        form_data.append('data[]',dtautounava);
        form_data.append('data[]',detail);
        if(otphoto.length>0){
            for(var x=0;x<otphoto.length;x++){
                form_data.append('data[]',otphoto[x]);
            }
        }
        $.ajax({url:'../php_files/add_product.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data===''){
                $('#add_modal').modal('hide');
                loadData();
            }else{alert(data);}
            $('#spad').hide();
            $('#btad').show();
        }});
    }
}
function view(id){
    $('#btview'+id).hide();
    $('#spview'+id).show();
    location.href='#!product?id='+id+'&&edt=1';
}