var mode='*';var se='';var str=1;var stp=25;
loadData();
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
        $('#pv').html(js[1]);
        $('#cpdiv').html(js[2]);
        $('#oprt').html(js[0]);
        if(js[0]>stp){
            $('.btnp').prop('disabled',false);
        }else{
            $('.btnp').prop('disabled',true);
        }
    });
}
function getCoupon(id){
    $('#cpbtn'+id).prop('disabled',true);
    $.post('../php_files/get_coupon.php',
    {id:id},
    function(data){
        if(data==='1'){$('#loginModal').modal('show');}
        else if(data!==''){alert(data);}
        else{$('#cp'+id).remove();}
        $('#cpbtn'+id).prop('disabled',false);
    });
}