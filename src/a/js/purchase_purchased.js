$('#page_title').html('Purchased');
var mode='*';var se='';var str=1;var stp=25;
loadData();setLabel();
$('.modal').on('hide.bs.modal',function(){
    $('.modal *').removeClass('is-valid');
    $('.modal *').removeClass('is-invalid');
    $('.modal .form-control').val('');
    $('#popdimg').removeAttr('src');
});
function showAll(){
    mode='*';
    setLabel();
    loadData();
}
function showWaiting(){
    mode='w';
    setLabel();
    loadData();
}
function showFinished(){
    mode='f';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='w'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;Waiting&nbsp;&nbsp;');}
    else if(mode==='f'){$('#lbmode').html('Finished');}
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
    $.post('../php_files/load_purchased_list.php',
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
function view(id){
    $('#btview'+id).hide();
    $('#spview'+id).show();
    $.post('../php_files/load_purchased_data.php',
    {id:id,type:'a'},
    function(data){
        let arr=$.parseJSON(data);
        $('#poid').val(arr['ID']);
        $('#popdimg').attr('src','../..'+arr['ProductPhoto']);
        $('#popdname').html(arr['ProductName']);
        $('#popdmid').html(arr['ProductModelID']);
        $('#po_quantity').val(arr['Quantity']);
        $('#po_price').val(arr['Price']);
        $('#spi_id').val(arr['SupplierID']);
        $('#spi_name').val(arr['SupplierName']);
        $('#spi_addr').val(atob(arr['SupplierAddress']));
        $('#spi_em').val(arr['SupplierEmail']);
        $('#spi_ph').val(arr['SupplierPhone']);
        $('#purchas_order_modal').modal('show');
        $('#spview'+id).hide();
        $('#btview'+id).show();
        if(arr['Status']==='w'){$('#btg').show();}
        else if(arr['Status']==='f'||arr['Status']==='c'){$('#btg').hide();}
    });
}
function cancelPurchase(){
    let id=$('#poid').val();
    if(confirm('Cancel this purchase?')){
        $.post('../php_files/cancel_purchase.php',
        {id:id},
        function(data){
            if(data!==''){alert(data);}
            else{$('#purchas_order_modal').modal('hide');loadData();}
        });
    }
}
function addStock(){
    let id=$('#poid').val();
    if(confirm('Add to Stock?')){
        $.post('../php_files/purchase_add_to_stock.php',
        {id:id},
        function(data){
            if(data!==''){alert(data);}
            else{$('#purchas_order_modal').modal('hide');loadData();}
        });
    }
}