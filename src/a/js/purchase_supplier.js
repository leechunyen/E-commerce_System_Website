$('#page_title').html('Supplier');
var se='';var str=1;var stp=25;
loadData();
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid');
    $('.modal *').removeClass('is-invalid');
    $('.modal .form-control').val('');
});
function reset(){
    $('#ipse').val('');
    $('#ipse').removeClass('is-invalid');
    se='';
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
    $.post('../php_files/load_supplier_list.php',
    {se:se,str:str,stp:stp},
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
function add(){
    let name=$('#add_name').val();
    let email=$('#add_email').val();
    let phone=$('#add_phone').val();
    let address=$('#add_address').val();
    var pass=true;
    if(name===''||name===null){
        pass=false;
        $('#add_er_name').html(epfl);
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else if(name.length>50){
        pass=false;
        $('#add_er_name').html(maxCharacterMessage(50));
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(name)){
        pass=false;
        $('#add_er_name').html(stal);
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#add_name').removeClass('is-invalid').addClass('is-valid');
    }
    if(email===''||email===null){
        pass=false;
        $('#add_er_email').html(epfl);
        $('#add_email').removeClass('is-valid').addClass('is-invalid');
    }else if(email.length>50){
        pass=false;
        $('#add_er_email').html(maxCharacterMessage(50));
        $('#add_email').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(email)||!validateEmail(email)){
        pass=false;
        $('#add_er_email').html(ivem);
        $('#add_email').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#add_email').removeClass('is-invalid').addClass('is-valid');
    }
    if(phone===''||phone===null){
        pass=false;
        $('#add_er_phone').html(epfl);
        $('#add_phone').removeClass('is-valid').addClass('is-invalid');
    }else if(phone.length>12){
        pass=false;
        $('#add_er_phone').html(maxCharacterMessage(12));
        $('#add_phone').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(phone)){
        pass=false;
        $('#add_er_phone').html(ivph);
        $('#add_phone').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#add_phone').removeClass('is-invalid').addClass('is-valid');
    }
    if(address===''||address===null){
        pass=false;
        $('#add_er_address').html(epfl);
        $('#add_address').removeClass('is-valid').addClass('is-invalid');
    }else if(address.length>150){
        pass=false;
        $('#add_er_address').html(maxCharacterMessage(150));
        $('#add_address').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#add_address').removeClass('is-invalid').addClass('is-valid');
    }
    if(pass){
        $('#btad').hide();
        $('#spad').show();
        let form_data=new FormData();
        form_data.append('data[]',name);
        form_data.append('data[]',email);
        form_data.append('data[]',phone);
        form_data.append('data[]',address);
        $.ajax({url:'../php_files/add_supplier.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);}
            else{$('#add_modal').modal('hide');loadData();}
            $('#spad').hide();
            $('#btad').show();
        }});
    }
}
function view(id){
    $('#btview'+id).hide();
    $('#spview'+id).show();
    $('.btview').prop('disabled',true);
    $.post('../php_files/load_supplier_data.php',
    {id:id},
    function(data){
        let arr=$.parseJSON(data);
        $('#edt_id').val(arr['ID']);
        $('#edt_name').val(arr['Name']);
        $('#edt_email').val(arr['Email']);
        $('#edt_phone').val(arr['Phone']);
        $('#edt_address').val(atob(arr['Address']));
        $('#edt_modal').modal('show');
        $('#spview'+id).hide();
        $('#btview'+id).show();
        $('.btview').prop('disabled',false);
    });
}
function deleteSuplier(){
    let id=$('#edt_id').val();
    if(confirm('Delete supplier id='+id+'?')){
        $('.btview').prop('disabled',true);
        $('#bt_del_sup').hide();$('#sp_del_sup').show();$('#btedt').prop('disabled',true);
        $.post('../php_files/delete_supplier.php',
        {id:id},
        function(data){
            if(data===''){
                $('#tbrw'+id).remove();
                $('#edt_modal').modal('hide');
            }
            else{alert(data);}
            $('#sp_del_sup').hide();$('#bt_del_sup').show();$('#btedt').prop('disabled',false);
            $('.btview').prop('disabled',false);
        });
    }
}
function update(){
    let id=$('#edt_id').val();
    let name=$('#edt_name').val();
    let email=$('#edt_email').val();
    let phone=$('#edt_phone').val();
    let address=$('#edt_address').val();
    var pass=true;
    if(name===''||name===null){
        pass=false;
        $('#edt_er_name').html(epfl);
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else if(name.length>50){
        pass=false;
        $('#edt_er_name').html(maxCharacterMessage(50));
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(name)){
        pass=false;
        $('#edt_er_name').html(stal);
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_name').removeClass('is-invalid').addClass('is-valid');
    }
    if(email===''||email===null){
        pass=false;
        $('#edt_er_email').html(epfl);
        $('#edt_email').removeClass('is-valid').addClass('is-invalid');
    }else if(email.length>50){
        pass=false;
        $('#edt_er_email').html(maxCharacterMessage(50));
        $('#edt_email').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(email)||!validateEmail(email)){
        pass=false;
        $('#edt_er_email').html(ivem);
        $('#edt_email').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_email').removeClass('is-invalid').addClass('is-valid');
    }
    if(phone===''||phone===null){
        pass=false;
        $('#edt_er_phone').html(epfl);
        $('#edt_phone').removeClass('is-valid').addClass('is-invalid');
    }else if(phone.length>12){
        pass=false;
        $('#edt_er_phone').html(maxCharacterMessage(12));
        $('#edt_phone').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(phone)){
        pass=false;
        $('#edt_er_phone').html(ivph);
        $('#edt_phone').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_phone').removeClass('is-invalid').addClass('is-valid');
    }
    if(address===''||address===null){
        pass=false;
        $('#edt_er_address').html(epfl);
        $('#edt_address').removeClass('is-valid').addClass('is-invalid');
    }else if(address.length>150){
        pass=false;
        $('#edt_er_address').html(maxCharacterMessage(150));
        $('#edt_address').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_address').removeClass('is-invalid').addClass('is-valid');
    }
    if(pass){
        $('#btedt').hide();
        $('#spedt').show();
        let form_data=new FormData();
        form_data.append('data[]',id);
        form_data.append('data[]',name);
        form_data.append('data[]',email);
        form_data.append('data[]',phone);
        form_data.append('data[]',address);
        $.ajax({url:'../php_files/edit_supplier.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data===''){
                $('#edt_modal').modal('hide');
                loadData();
            }else{alert(data);}
            $('#spedt').hide();
            $('#btedt').show();
        }});
    }
}