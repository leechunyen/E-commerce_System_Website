var mode='*';var se='';var str=1;var stp=10;var oid;
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
function showExpired(){
    mode='e';
    setLabel();
    loadData();
}
function showUsed(){
    mode='u';
    setLabel();
    loadData();
}
function setLabel(){
    if(mode==='*'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='a'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;Available&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='e'){$('#lbmode').html('&nbsp;&nbsp;&nbsp;Expired&nbsp;&nbsp;&nbsp;&nbsp;');}
    else if(mode==='u'){$('#lbmode').html('Used');}
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
    $.post('../php_files/load_coupon.php',
    {mode:mode,se:se,str:str,stp:stp},
    function(data){
        let js=$.parseJSON(data);
        $('#cps').html(js[1]);
        $('#oprt').html(js[0]);
        if(js[0]>stp){
            $('.btnp').prop('disabled',false);
        }else{
            $('.btnp').prop('disabled',true);
        }
    });
}