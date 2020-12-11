$('#page_title').html('Shipping Method');
$('.modal').on('hide.bs.modal',function(){
    $('.modal .form-control').removeClass('is-invalid');
    $('.modal .form-control').removeClass('is-valid');
    $('.modal .form-control').val('');
    $('.btedt').prop('disabled',false);
});
loadData();
function loadData(){
    $.post('../php_files/load_shipping_method_list.php',
    {p:''},
    function(data){
        $('#divspmd').html(data);
    });
}
function add(){
    let title=$('#add_title').val();
    let price=$('#add_price').val();
    let dd=$('#add_dd').val();
    var pass=true;
    if(title===null||title===''){
        pass=false;
        $('#er_ad_title_mg').html(epfl);
        $('#add_title').removeClass('is-valid');
        $('#add_title').addClass('is-invalid');
    }else if(title.length>30){
        pass=false;
        $('#er_ad_title_mg').html(maxCharacterMessage(30));
        $('#add_title').removeClass('is-valid');
        $('#add_title').addClass('is-invalid');
    }else if(isSpecialCharacter(title)){
        pass=false;
        $('#er_ad_title_mg').html(stal);
        $('#add_title').removeClass('is-valid');
        $('#add_title').addClass('is-invalid');
    }else{
        $('#add_title').removeClass('is-invalid');
        $('#add_title').addClass('is-valid');
    }
    if(price===null||price===''){
        pass=false;
        $('#er_ad_price_mg').html(epfl);
        $('#add_price').removeClass('is-valid');
        $('#add_price').addClass('is-invalid');
    }else if(isNaN(price)||isSpecialCharacter(price)){
        pass=false;
        $('#er_ad_price_mg').html(plno);
        $('#add_price').removeClass('is-valid');
        $('#add_price').addClass('is-invalid');
    }else{
        $('#add_price').removeClass('is-invalid');
        $('#add_price').addClass('is-valid');
    }
    if(dd===null||dd===''){
        pass=false;
        $('#er_ad_dd_mg').html(epfl);
        $('#add_dd').removeClass('is-valid');
        $('#add_dd').addClass('is-invalid');
    }else if(dd.length>7){
        pass=false;
        $('#er_ad_dd_mg').html(maxCharacterMessage(7));
        $('#add_dd').removeClass('is-valid');
        $('#add_dd').addClass('is-invalid');
    }else{
        $('#add_dd').removeClass('is-invalid');
        $('#add_dd').addClass('is-valid');
    }
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        $.post('../php_files/add_shipping_method.php',
        {title:title,price:price,dd:dd},
        function(data){
            let arr=$.parseJSON(data);
            if(arr['er']){alert(arr['er']);}
            else if(arr['ti']){
                $('#er_ad_title_mg').html(alex);
                $('#add_title').removeClass('is-valid');
                $('#add_title').addClass('is-invalid');
            }else{
                $('#add_modal').modal('hide');
                loadData();
            }
            $('#spad').hide();
            $('#btad').show();
        });
    }
}
function del(id,name){
    if(confirm('Delete '+name+'?')){
        $('#spmedt'+id+', #spmdel'+id).prop('disabled',true);
        $.post('../php_files/delete_shipping_method.php',
        {id:id},
        function(data){
            if(data===''){
                $('#spmdiv'+id).remove();
            }else{
                alert(data);
                $('#spmedt'+id+', #spmdel'+id).prop('disabled',false);
            }
        });
    }
}
function view(id){
    $('#spmedt'+id+', #spmdel'+id).prop('disabled',true);
    $.post('../php_files/load_shipping_method_data.php',
    {id:id},
    function(data){
        arr=$.parseJSON(data);
        $('#edtid').val(id);
        $('#edt_title').val(arr['Title']);
        $('#edt_price').val(arr['Price']);
        $('#edt_dd').val(arr['DeliveryDays']);
        $('#edt_modal').modal('show');
    });
}
function edit(){
    let title=$('#edt_title').val();
    let price=$('#edt_price').val();
    let dd=$('#edt_dd').val();
    var pass=true;
    if(title===null||title===''){
        pass=false;
        $('#er_ed_title_mg').html(epfl);
        $('#edt_title').removeClass('is-valid');
        $('#edt_title').addClass('is-invalid');
    }else if(title.length>30){
        pass=false;
        $('#er_ed_title_mg').html(maxCharacterMessage(30));
        $('#edt_title').removeClass('is-valid');
        $('#edt_title').addClass('is-invalid');
    }else if(isSpecialCharacter(title)){
        pass=false;
        $('#er_ed_title_mg').html(stal);
        $('#edt_title').removeClass('is-valid');
        $('#edt_title').addClass('is-invalid');
    }else{
        $('#edt_title').removeClass('is-invalid');
        $('#edt_title').addClass('is-valid');
    }
    if(price===null||price===''){
        pass=false;
        $('#er_ed_price_mg').html(epfl);
        $('#edt_price').removeClass('is-valid');
        $('#edt_price').addClass('is-invalid');
    }else if(isNaN(price)||isSpecialCharacter(price)){
        pass=false;
        $('#er_ed_price_mg').html(plno);
        $('#edt_price').removeClass('is-valid');
        $('#edt_price').addClass('is-invalid');
    }else{
        $('#edt_price').removeClass('is-invalid');
        $('#edt_price').addClass('is-valid');
    }
    if(dd===null||dd===''){
        pass=false;
        $('#er_ed_dd_mg').html(epfl);
        $('#edt_dd').removeClass('is-valid');
        $('#edt_dd').addClass('is-invalid');
    }else if(dd.length>7){
        pass=false;
        $('#er_ed_dd_mg').html(maxCharacterMessage(7));
        $('#edt_dd').removeClass('is-valid');
        $('#edt_dd').addClass('is-invalid');
    }else{
        $('#edt_dd').removeClass('is-invalid');
        $('#edt_dd').addClass('is-valid');
    }
    if(pass){
        let id=$('#edtid').val();
        $('#bted').hide();
        $('#sped').show();
        $.post('../php_files/edit_shipping_method.php',
        {id:id,title:title,price:price,dd:dd},
        function(data){
            let arr=$.parseJSON(data);
            if(arr['er']){alert(arr['er']);}
            else if(arr['ti']){
                $('#er_ed_title_mg').html(alex);
                $('#edt_title').removeClass('is-valid');
                $('#edt_title').addClass('is-invalid');
            }else{
                $('#edt_modal').modal('hide');
                loadData();
            }
            $('#sped').hide();
            $('#bted').show();
        });
    }
}