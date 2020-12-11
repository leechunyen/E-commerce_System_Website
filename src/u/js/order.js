var mode='*';var se='';var str=1;var stp=10;var oid;
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
function next(){
    str=str+stp;
    loadData();
}
function previous(){
    str=str-stp;
    loadData();
}
function loadData(){
    $.post('../php_files/load_order.php',
    {mode:mode,se:se,str:str,stp:stp},
    function(data){
        let js=$.parseJSON(data);
        $('#odls').html(js[1]);
        $('#oprt').html(js[0]);
        if(js[0]>stp){
            $('.btnp').prop('disabled',false);
        }else{
            $('.btnp').prop('disabled',true);
        }
    });
}