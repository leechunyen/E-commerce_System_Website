var v='d';var total=0;var spn='';var spp=0;var spid=0;var dscam=0;var cpid=0;var dscmp=0;var spaddr=0;var tp=0;
if(window.screen.width<=991){v='m';}//mobile
else{v='d';}//desktop
loadData();
paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value:tp
          }
        }]
      });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            $('#checkout').modal('hide');
            $('#plld').show();
            $.post('../php_files/place_order.php',
            {spmdid:spid,addrid:spaddr,cpid:cpid,tp:tp},
            function(data){
                if(data!==''){alert(data);}
                else{location.reload();}
            });
        });
    }
}).render('#paypal-button-container');
function loadData(){
    $.post('../php_files/load_cart_list.php',
    {v:v},
    function(data){
        let arr=$.parseJSON(data);
        if(arr[4]===0){$('#btpo').prop('disabled',true);}
        else{$('#btpo').prop('disabled',false);}
        $('#list').html(arr[0]);
        $('#cps').html(arr[1]);
        $('#spa').html(arr[2]);
        $('#price').html(formatMoney(arr[3]));
        $('#co_pdp').html(formatMoney(arr[3]));
        total=arr[2];tp=arr[2];
        countTotalPayment();
    });
}
function incDecQty(e,ipc,stock){
    let qty=parseInt($('#ip_qty'+ipc).val());
    if(isNaN(qty)){qty=0;}
    if(e===1){
        if(qty>1){
            let dqty=qty-1;
            $('#ip_qty'+ipc).val(dqty);
        }else{$('#ip_qty'+ipc).val(1);}
    }else if(e===2){
        if(qty<stock){
            let iqty=qty+1;
            $('#ip_qty'+ipc).val(iqty);
        }
    }
    qtyChanged($('#ip_qty'+ipc),ipc,stock);
}
function inputQty(e,stock){
    if(isNaN($(e).val())){$(e).val(1);}
    else if(parseInt($(e).val())<1||parseInt($(e).val())>stock){$(e).addClass('is-invalid');}
    else{$(e).removeClass('is-invalid');}
}
function removeProduct(pid){
    $.post('../php_files/remove_from_cart.php',
    {pid:pid},
    function(data){
        if(data!==''){alert(data);}
        else{
            $('#row'+pid).remove();
            loadData();
        }
    });
}
function qtyChanged(e,pid,stock){
    if(parseInt($(e).val())>=1&&parseInt($(e).val())<=stock){
       updateQty(pid,$(e).val());
    }
}
function updateQty(pid,qty){
     $('.qtycpm,.qtycpm *').prop('disabled',true);
    $.post('../php_files/update_cart_qty.php',
    {pid:pid,qty:qty},
    function(data){
        if(data!==''){alert(data);}
        else{loadData();}
        $('.qtycpm,.qtycpm *').prop('disabled',false);
    });
}
function shippingMethodSel(name,pri,id){
    spn=name;spp=pri;spid=id;
    $('#spmdch').html(spn);
    $('#smpr,#co_spf').html(formatMoney(spp));
    countTotalPayment();
}
function couponSele(id,am,md,mp,cr){
    if(id===null||am===null||md===null||mp===null,cr===null){
        cpid=0;dscam=0;dscmp=0;
        $('#cpdsc,#co_cp').html(formatMoney(0));
        $('#cpselch').html('------');
    }else{
        cpid=id;dscam=am;dscmp=mp;
        if(md==='c'){$('#cpselch').html(cr+' '+mp+' - '+cr+' '+am);}
        else if(md==='p'){$('#cpselch').html(cr+' '+mp+' - '+am+'%');}
        if(md==='c'){$('#cpdsc,#co_cp').html(formatMoney(am));}
        else if(md==='p'){
            dscam=total*am/100;
            $('#cpdsc,#co_cp').html(formatMoney(dscam)+'&nbsp;('+parseInt(am)+'%)');
        }
    }
    countTotalPayment();
}
function countTotalPayment(){
    let tp=(parseFloat(total)+parseFloat(spp))-parseFloat(dscam);
    $('#ttprc').html(formatMoney(tp));
}
function shippingAddrSel(id){
    spaddr=id;$('#spaddrch').html('selected');
}
function placeOrder(){
    var pass=true;
    if(spid===0){
        pass=false;
        $('#spmdch').addClass('error');
    }else{$('#spmdch').removeClass('error');}
    if(spaddr===0){
        pass=false;
        $('#spaddrch').addClass('error');
    }else{$('#spaddrch').removeClass('error');}
    if(pass){
        $('#btpo').hide();
        $('#sppo').show();
        $.post('../php_files/count_payment.php',
        {spmdid:spid,addrid:spaddr,cpid:cpid},
        function(data){
            let arr=$.parseJSON(data);
            tp=parseFloat(arr[0]);
            $('#co_tpay').html(formatMoney(tp));
            $('#co_top').html(arr[1]);
            $('#checkout').modal('show');
            $('#sppo').hide();
            $('#btpo').show();
        });
    }
}