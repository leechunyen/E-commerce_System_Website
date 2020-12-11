$('#page_title').html('Order');
var mode='*';var se='';var str=1;var stp=25;var oid;
$('.modal').on('hide.bs.modal',function(){
    shipOutCancel();
});
setLabel();loadData();
function showAll(){
    mode='*';
    setLabel();
    loadData();
}
function showOrder(){
    mode='o';
    setLabel();
    loadData();
}
function showShippedOut(){
    mode='s';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='o'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;Order&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='s'){$('#lbmode').html('ShippedOut');}
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
    $.post('../php_files/load_order_list.php',
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
function shipOut(e){
    $(e).hide();
    $('#vspiptnodiv').show();
}
function shipOutCancel(){
    $('#iptno').val('');
    $('#vspiptnodiv').hide();
    $('#btso').show();
}
function view(id){
    oid=id;
    $('.btview').prop('disabled',true);
    $('#btview'+id).hide();
    $('#spview'+id).show();
    $.post('../php_files/load_order_data.php',
    {id:id},
    function(data){
        let arr=$.parseJSON(data);
        $('#void').html(arr[0]['ID']);
        $('#vuid').html(arr[0]['UserID']);
        $('#pdtls').html(arr[2]);
        $('#vtit').html(arr[3]);
        $('#vspn').html(arr[0]['ShippingName']);
        $('#vspp').html(arr[0]['ShippingPhone']);
        $('#vspe').html(arr[0]['ShippingEmail']);
        $('#vspa').html(arr[0]['ShippingAddress']);
        $('#vtot').html(arr[5][0]+'&nbsp;'+formatMoney(arr[0]['TotalAmount']));
        $('#vspf').html(arr[5][0]+'&nbsp;'+formatMoney(arr[1]['ShippingFee']));
        $('#vspm').html(arr[1]['ShippingMethodSelected']);
        $('#vpad').html(arr[5][0]+'&nbsp;'+formatMoney(arr[1]['PaidAmount']));
        $('#vodt').html(dateFormat(arr[0]['DateTime']));
        if(arr[1]['UserCouponID']!==''&&arr[1]['UserCouponID']!==null){
            if(arr[4]['Mode']==='p'){
                let tam=parseFloat(arr[0]['TotalAmount'])*parseInt(arr[4]['Discount'])/100;
                $('#vucp').html(arr[5][0]+'&nbsp;'+formatMoney(tam)+'&nbsp;'+parseInt(arr[4]['Discount'])+'%');
            }else if(arr[4]['Mode']==='c'){$('#vucp').html(arr[5][0]+'&nbsp;'+arr[4]['Discount']);}
        }else{$('#vucp').html(arr[5][0]+'&nbsp;0.00');}
        if(arr[0]['DeliveryID']===''||arr[0]['DeliveryID']===null){
            $('#vspo').html('No');
            $('#vsptdiv').hide();
            $('#vspsdiv').show();
        }else{
            $('#vspo').html('Yes');
            $('#vspsdiv').hide();
            $('#vsptdiv').show();
            $('#vspt').html(arr[6]['TrackingNumber']);
            $('#vspd').html(arr[6]['DateTime']);
        }
        $('#view_modal').modal('show');
        $('.btview').prop('disabled',false);
        $('#spview'+id).hide();
        $('#btview'+id).show();
    });
}
function saveTrackingCode(){
    let tc=$('#iptno').val();
    if(tc===''||tc===null){
        $('#ermg_tc').html(epfl);
        $('#iptno').removeClass('is-valid').addClass('is-invalid');
    }else if(tc.length>30){
        $('#ermg_tc').html(maxCharacterMessage(30));
        $('#iptno').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(tc)){
        $('#ermg_tc').html(stal);
        $('#iptno').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#iptno').removeClass('is-invalid').addClass('is-valid');
        if(confirm('After save can\'t be edit. save?')){
            $.post('../php_files/shipped_out.php',
            {tc:tc,oid:oid},
            function(data){
                if(data!==''){alert(data);}
                else{$('.modal').modal('hide');}
            });
        }
    }
}