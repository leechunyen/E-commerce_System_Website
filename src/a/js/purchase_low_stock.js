$('#page_title').html('Low Stock');
var se='';var str=1;var stp=25;
loadData();
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid').removeClass('is-invalid');
    $('.modal .form-control').val('');
    $('#po_supplier').val('0');
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
    $.post('../php_files/load_low_stock_list.php',
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
function purchaseOrder(id){
    $('#btview'+id).hide();$('#spview'+id).show();$('.btview').prop('disabled',true);
    $.post('../../ua/php_files/load_product_data.php',
    {id:id,m:'p'},
    function(data){
        let arr=$.parseJSON(data);
        $('#pid').val(id);
        $('#popdimg').attr('src','../../'+arr['DefaultPhoto']);
        $('#popdname').html(arr['Name']);
        $('#popdmid').html(arr['ModelID']);
        $('#popdprice').html(arr['Price']);
        $('#popdstock').html(arr['Stock']);
        $('#popdreop').html(arr['ReorderPoint']);
        $('#purchas_order_modal').modal('show');
        $('#spview'+id).hide();$('#btview'+id).show();$('.btview').prop('disabled',false);
    });
}
function purchase(){
    let pid=$('#pid').val();
    let qty=$('#po_quantity').val();
    let pri=$('#po_price').val();
    let sup=$('#po_supplier').val();
    var pass=true;
    if(qty===''||qty===null){
        pass=false;
        $('#po_er_quantity').html(epfl);
        $('#po_quantity').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(qty)){
        pass=false;
        $('#po_er_quantity').html(plno);
        $('#po_quantity').removeClass('is-valid').addClass('is-invalid');
    }else if(parseInt(qty)<0||parseInt(qty)>10000){
        pass=false;
        $('#po_er_quantity').html(valueRangeMessage('0-10000'));
        $('#po_quantity').removeClass('is-valid').addClass('is-invalid');
    }else{$('#po_quantity').removeClass('is-invalid').addClass('is-valid');}
    if(pri===''||pri===null){
        pass=false;
        $('#po_er_price').html(epfl);
        $('#po_price').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(pri)){
        pass=false;
        $('#po_er_price').html(plno);
        $('#po_price').removeClass('is-valid').addClass('is-invalid');
    }else if(parseFloat(pri)<0.01||parseFloat(pri)>10000000){
        pass=false;
        $('#po_er_price').html(valueRangeMessage('0.01-10000000'));
        $('#po_price').removeClass('is-valid').addClass('is-invalid');
    }else{$('#po_price').removeClass('is-invalid').addClass('is-valid');}
    if(sup===''||sup==='0'){
        pass=false;
        $('#po_supplier').removeClass('is-valid').addClass('is-invalid');
    }else{$('#po_supplier').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        $.post('../php_files/make_purchase.php',
        {pid:pid,qty:qty,pri:pri,sup:sup},
        function(data){
            if(data===''){$('.modal').modal('hide');}
            else{alert(data);}
        });
    }
}