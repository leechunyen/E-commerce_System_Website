var edt=false;var bfedt=[];var prostock=0;var wl=false;
var id=getRequest('id');var m=checkFrom();
loadData();
$('.venobox').venobox({
    framewidth : '95%',
    border     : '5px',
    numeratio  : true,
    infinigall : true
});
if(m==='a'){
    $(function(){$(".datepicker").datetimepicker({
        minDate         :moment(),
        format          :'MM/DD/YYYY HH:mm',
        showClear       :true,
        useCurrent      :true,
        showClose       :true,
        showTodayButton :true
    });});
}
$('#edtProDtl').each(function(){//text area
    this.setAttribute('style','height:'+(this.scrollHeight)+'px;overflow-y:hidden;');
}).on('input',function(){
    this.style.height='auto';
    this.style.height=(this.scrollHeight)+'px';
});
if(m==='a'){
    $('.custom-control-input,.form-control').prop('disabled',true);
    $('#divqty').hide();
}
function loadData(){
    $.post('../../ua/php_files/load_product_data.php',
    {id:id,m:m},
    function(data){
        let arr=$.parseJSON(data);
        if(m==='a'){//admin
            $('#edt_title').val(arr['Name']);
            $('#edt_model').val(arr['ModelID']);
            $('#edt_stock').val(arr['Stock']);
            $('#edt_price').val(arr['Price']);
            $('#edt_reop').val(arr['ReorderPoint']);
            var ava=false;
            if(arr['Available']==='1'){
                ava=true;
                $('#lbavasw').html('Available');
            }else{$('#lbavasw').html('Unavailable');}
            $('#avasw').prop('checked',ava);
            $('#edtProDtl').html(window.atob(arr['Detail']));
            var swatava=false;var swatunava=false;
            if(arr['AutoAvailableDateTime']!==''&&arr['AutoAvailableDateTime']!==null){
                let dt=dateFormat(arr['AutoAvailableDateTime']);swatava=true;
                $('#swlbdtatava').html('Enabled');
                $('#ipdtautoava').attr('placeholder',dt);
            }else{
                $('#swlbdtatava').html('Disabled');
                $('#ipdtautoava').removeAttr('placeholder');;
            }
            if(arr['AutoUnavailableDateTime']!==''&&arr['AutoUnavailableDateTime']!==null){
                let dt=dateFormat(arr['AutoUnavailableDateTime']);swatunava=true;
                $('#swlbdtatunava').html('Enabled');
                $('#ipdtautounava').attr('placeholder',dt);
            }else{
                $('#swlbdtatunava').html('Disabled');
                $('#ipdtautounava').removeAttr('placeholder');
            }
            $('#swdtatava').prop('checked',swatava);
            $('#swdtatunava').prop('checked',swatunava);
        }else{//user
            $('#lb_title').html(arr['Name']);
            $('#lb_model').html(arr['ModelID']);
            $('#lb_stock').html(arr['Stock']);
            $('#lb_price').html(arr['Price']);
            wl=arr['wl'];
            if(wl){$('#btaddwl').html('Remove from Wish List');}
            else{$('#btaddwl').html('Add to Wish List');}
        }
        $('#ln_df_pth').attr('href','../..'+arr['DefaultPhoto']);
        $('#df_pth').attr('src','../..'+arr['DefaultPhoto']);
        $('.img_view_arr_img_div').html(arr['mrph']);
        prostock=arr['Stock'];
        
        let lines=window.atob(arr['Detail']).split('\n');
        var dtlct;
        for (var i=0;i<lines.length;i++){
            dtlct+=lines[i];
            if(!isHTML(lines[i])){dtlct+='<br/>';}
        }
        $('#divdetail').html(dtlct);
    });
}
function incDecQty(e){
    let qty=parseInt($('#ip_qty').val());
    if(isNaN(qty)){qty=0;}
    if(e===1){
        if(qty>1){
            let dqty=qty-1;
            $('#ip_qty').val(dqty);
        }else{$('#ip_qty').val(1);}
    }else if(e===2){
        if(qty<prostock){
            let iqty=qty+1;
            $('#ip_qty').val(iqty);
        }
    }
}
function inputQty(e){
    if(isNaN($(e).val())){$(e).val(1);}
    else if(parseInt($(e).val())<1||parseInt($(e).val())>prostock){$(e).addClass('is-invalid');}
    else{$(e).removeClass('is-invalid');}
}
function avasw(e){
    if($(e).prop('checked')){
        $('#lbavasw').html('Available');
    }else{
        $('#lbavasw').html('Unavailable');
    }
}
function atavaatunava(e,l,i){
    if($(e).prop('checked')){
        $('#'+i).prop('disabled',false);
        $('#'+l).html('Enabled');
    }else{
        $('#'+i).removeClass('is-invalid').removeClass('is-valid');
        $('#'+i).val('');
        $('#'+i).prop('disabled',true);
        $('#'+l).html('Disabled');
    }
}
function deleteMrPh(e,pth){
    if(confirm('Are you sure u want to delete?')){
        $(e).prop('disabled',true);
        $.post('../php_files/delete_product_more_photo.php',
        {id:getRequest('id'),pth:pth},
        function(data){
            if(data===''){$(e).parent().parent().remove();}
            else{
                $(e).prop('disabled',false);
                alert(data);
            }
        });
    }
}
function removeAllNewAdded(){
    $('#addmorephoto').val(null);
    $('.nwadd').remove();
}
function chdfpth(e){
    let iv=getElementID('nwdfpth');
    let fl=$(e).prop('files')[0];
    if(fl&&fl.size>5242880){
        $(e).val('');
        alert('Logo only less than 5MB allowed.');
    }else{
        var reader=new FileReader();
        reader.onloadend=function (){iv.src=reader.result;};
        if(fl){reader.readAsDataURL(fl);}
    }
}
function uploadMorePhoto(e){
    let fl=$(e).prop('files');
    $('.nwadd').remove();
    if(fl.length>0){
        $(e).parent().append(`<div id='btdelallnew' class='nwadd imgivarrdiv'><center><button id='btrmalad' onclick="removeAllNewAdded();" type="button" class="btn btn-danger">Remove All New Added</button></center></div>`);
        for(var i=0;i<fl.length;i++){
            let reader=new FileReader();
            reader.addEventListener("load",function(){
                let src=reader.result;
                $('.img_view_arr_img_div').append(`<div class='nwadd imgivarrdiv'><img class="mrimgs" src="${src}"/><br/><center>new</div></center>`);
            },false);
            reader.readAsDataURL(fl[i]);
        }
    }
}
function edit(){
    if(!edt){//edit
        bfedt.push($('#edt_title').val());//0
        bfedt.push($('#edt_model').val());//1
        bfedt.push($('#edt_stock').val());//2
        bfedt.push($('#edt_reop').val());//3
        bfedt.push($('#edt_price').val());//4
        bfedt.push($('#avasw').prop('checked'));//5
        bfedt.push($('#edtProDtl').val());//6
        bfedt.push($('#swdtatava').prop('checked'));//7
        bfedt.push($('#swdtatunava').prop('checked'));//8
        edt=true;
        $('#divdetail').hide();
        $('.delMrPh,#edtProDtl,#addmrphdiv,#edtsav,#ch_dfpth').show();
        $('.custom-control-input,.form-control').prop('disabled',false);
        if(!$('#swdtatava').prop('checked')){$('#ipdtautoava').prop('disabled',true);}
        if(!$('#swdtatunava').prop('checked')){$('#ipdtautounava').prop('disabled',true);}
        $('#edtbtn').html('Cancel');
    }else{//cancel
        edt=false;
        $('.form-control').val('');
        $('#divdetail').show();
        $('.delMrPh,#edtProDtl,#addmrphdiv,#edtsav,#ch_dfpth').hide();
        $('.custom-control-input,.form-control').prop('disabled',true);
        $('*').removeClass('is-valid');
        $('*').removeClass('is-invalid');
        $('#edt_title').val(bfedt[0]);
        $('#edt_model').val(bfedt[1]);
        $('#edt_stock').val(bfedt[2]);
        $('#edt_reop').val(bfedt[3]);
        $('#edt_price').val(bfedt[4]);
        $('#avasw').prop('checked',bfedt[5]);
        $('#edtProDtl').val(bfedt[6]);
        $('#swdtatava').prop('checked',bfedt[7]);
        if(bfedt[7]){$('#swlbdtatava').html('Enabled');}
        else{$('#swlbdtatava').html('Disabled');}
        $('#swdtatunava').prop('checked',bfedt[8]);
        if(bfedt[8]){$('#swlbdtatunava').html('Enabled');}
        else{$('#swlbdtatunava').html('Disabled');}
        $('#edtbtn').html('Edit');
        removeAllNewAdded();
        $('#ipchdfpth').val('');
        $('#nwdfpth').removeAttr('src');
    }
}
function save(){
    let dfpth=$('#ipchdfpth').prop('files');
    let mrpth=$('#addmorephoto').prop('files');
    let title=$('#edt_title').val();
    let model=$('#edt_model').val();
    let stock=$('#edt_stock').val();
    let reopt=$('#edt_reop').val();
    let price=$('#edt_price').val();
    let atava=$('#ipdtautoava').val();
    let atunava=$('#ipdtautounava').val();
    let detil=$('#edtProDtl').val();
    let ava=$('#avasw').prop('checked');
    let swdtatava=$('#swdtatava').prop('checked');
    let swdtatunava=$('#swdtatunava').prop('checked');
    let atavaphd=getElementID('ipdtautoava').placeholder;
    let atunavaphd=getElementID('ipdtautounava').placeholder;
    var pass=true;
    if(title===null||title===''){
        pass=false;
        $('#ermg_title').html(epfl);
        $('#edt_title').removeClass('is-valid').addClass('is-invalid');
    }else if(title.length>50){
        pass=false;
        $('#ermg_title').html(maxCharacterMessage(50));
        $('#edt_title').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(title)){
        pass=false;
        $('#ermg_title').html(stal);
        $('#edt_title').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_title').removeClass('is-invalid').addClass('is-valid');
    }
    if(model===null||model===''){
        pass=false;
        $('#ermg_model').html(epfl);
        $('#edt_model').removeClass('is-valid').addClass('is-invalid');
    }else if(model.length>50){
        $('#ermg_model').html(maxCharacterMessage(50));
        $('#edt_model').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(model)){
        pass=false;
        $('#ermg_model').html(stal);
        $('#edt_model').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_model').removeClass('is-invalid').addClass('is-valid');
    }
    if(stock===''||stock===null){
        pass=false;
        $('#ermg_stock').html(epfl);
        $('#edt_stock').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(stock)){
        pass=false;
        $('#ermg_stock').html(plno);
        $('#edt_stock').removeClass('is-valid').addClass('is-invalid');
    }else if(parseInt(stock)<0||parseInt(stock)>10000){
        pass=false;
        $('#ermg_stock').html(valueRangeMessage('0-10000'));
        $('#edt_stock').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_stock').removeClass('is-invalid').addClass('is-valid');
    }
    if(reopt===''||reopt===null){
        pass=false;
        $('#ermg_reop').html(epfl);
        $('#edt_reop').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(reopt)){
        pass=false;
        $('#ermg_reop').html(plno);
        $('#edt_reop').removeClass('is-valid').addClass('is-invalid');
    }else if(parseInt(reopt)<0||parseInt(reopt)>9999){
        pass=false;
        $('#ermg_reop').html(valueRangeMessage('0-10000'));
        $('#edt_reop').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_reop').removeClass('is-invalid').addClass('is-valid');
    }
    if(price===''||price===null){
        pass=false;
        $('#ermg_price').html(epfl);
        $('#edt_price').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(price)){
        pass=false;
        $('#ermg_price').html(plno);
        $('#edt_price').removeClass('is-valid').addClass('is-invalid');
    }else if(parseFloat(price)<0.01||parseFloat(price)>10000000){
        pass=false;
        $('#ermg_price').html(valueRangeMessage('0.01-10000000'));
        $('#edt_price').removeClass('is-valid').addClass('is-invalid');
    }else{
        $('#edt_price').removeClass('is-invalid').addClass('is-valid');
    }
    if(swdtatava&&(atavaphd===''||atavaphd===null)){
        if(atava===null||atava===''){
            pass=false;
            $('#ermg_atava').html(epfl);
            $('#ipdtautoava').removeClass('is-valid').addClass('is-invalid');
        }else if(!isValidDateTime(atava)){
            pass=false;
            $('#ermg_atava').html(ivtd);
            $('#ipdtautoava').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#ipdtautoava').removeClass('is-invalid').addClass('is-valid');
        }
    }else if(swdtatava&&atava!==''&&atava!==null){
        if(!isValidDateTime(atava)){
            pass=false;
            $('#ermg_atava').html(ivtd);
            $('#ipdtautoava').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#ipdtautoava').removeClass('is-invalid').addClass('is-valid');
        }
    }else{
        $('#ipdtautoava').removeClass('is-invalid').removeClass('is-valid');
    }
    if(swdtatunava&&(atunavaphd===''||atunavaphd===null)){
        if(atunava===null||atunava===''){
            pass=false;
            $('#ermg_atunava').html(epfl);
            $('#ipdtautounava').removeClass('is-valid').addClass('is-invalid');
        }else if(!isValidDateTime(atunava)){
            pass=false;
            $('#ipdtautounava').html(ivtd);
            $('#ipdtautounava').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#ipdtautounava').removeClass('is-invalid').addClass('is-valid');
        }
    }else if(swdtatunava&&atunava!==''&&atunava!==null){
        if(!isValidDateTime(atunava)){
            pass=false;
            $('#ipdtautounava').html(ivtd);
            $('#ipdtautounava').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#ipdtautounava').removeClass('is-invalid').addClass('is-valid');
        }
    }else{
        $('#ipdtautounava').removeClass('is-invalid').removeClass('is-valid');
    }
    if(swdtatunava&&(atunava===''||atunava===null)&&atava!==''&&atava!==null){
        if(stringToDateTime(atava)>=stringToDateTime(atunavaphd)){
            pass=false;
                $('#ermg_atava').html(atua);
                $('#ipdtautoava').removeClass('is-valid').addClass('is-invalid');
        }else{$('#ipdtautoava').removeClass('is-invalid').addClass('is-valid');}
    }
    if(swdtatava&&(atava===''||atava===null)&&atunava!==''&&atunava!==null){
        if(stringToDateTime(atunava)<=stringToDateTime(atavaphd)){
            pass=false;
                $('#ermg_atunava').html(atua);
                $('#ipdtautounava').removeClass('is-valid').addClass('is-invalid');
        }else{$('#ipdtautounava').removeClass('is-invalid').addClass('is-valid');}
    }
    if(swdtatava&&swdtatunava&&atava!==null&&atava!==''&&atunava!==null&&atunava!==''){
        if(stringToDateTime(atunava)<=stringToDateTime(atava)){
            pass=false;
            $('#ermg_atunava').html(atua);
            $('#ipdtautounava').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#ipdtautounava').removeClass('is-invalid').addClass('is-valid');
        }
    }
    if(pass){
        $('#edtsav,#edtbtn').hide();
        $('#spsvedt').show();
        let form_data=new FormData();
        form_data.append('data[]',id);
        form_data.append('data[]',title);
        form_data.append('data[]',model);
        form_data.append('data[]',stock);
        form_data.append('data[]',reopt);
        form_data.append('data[]',price);
        form_data.append('data[]',atava);
        form_data.append('data[]',atunava);
        form_data.append('data[]',detil);
        form_data.append('data[]',ava);
        form_data.append('data[]',swdtatava);
        form_data.append('data[]',swdtatunava);
        if(dfpth.length>0){
            form_data.append('data[]',true);
            form_data.append('data[]',dfpth[0]);
        }else{form_data.append('data[]',false);}
        if(mrpth.length>0){
            form_data.append('data[]',true);
            for(var x=0;x<mrpth.length;x++){
                form_data.append('data[]',mrpth[x]);
            }
        }else{form_data.append('data[]',false);}
        $.ajax({url:'../../ua/php_files/edit_product.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            $('#spsvedt').hide();
            if(data!==''){
                alert(data);
                $('#edtsav,#edtbtn').show();
            }else{
                bfedt.splice(0,bfedt.length);
                edt=false;
                $('#addmorephoto').val('');
                $('#divdetail').show();
                $('.delMrPh,#edtProDtl,#addmrphdiv,#edtsav,#ch_dfpth').hide();
                $('.custom-control-input,.form-control').prop('disabled',true);
                $('*').removeClass('is-valid');
                $('*').removeClass('is-invalid');
                $('#btrmalad').remove();
                $('#edtbtn').show();
                $('#edtbtn').html('Edit');
                loadData();
            }
        }});
    }
}
function addRemoveWishList(){
    var m='a';if(wl){m='r';}
    $.post('../php_files/add_remove_wishlist.php',
    {id:id,m:m},
    function(data){
        if(data==='1'){$('#loginModal').modal('show');}
        else if(data!==''){alert(data);}
        else{
            if(m==='a'){
                wl=true;
                $('#btaddwl').html('Remove from Wish List');
            }else if(m==='r'){
                wl=false;
                $('#btaddwl').html('Add to Wish List');
            }
        }
    });
}
function addToCart(fb=true){
    let qty=$('#ip_qty').val();
    if(qty===''||qty===null){$('#ip_qty').addClass('is-invalid');}
    else if(parseInt(qty)<1||parseInt(qty)>prostock){$('#ip_qty').addClass('is-invalid');}
    else{
        $('#ip_qty').removeClass('is-invalid');
        $.post('../php_files/add_to_cart.php',
        {id:id,qty:parseInt(qty)},
        function(data){
            if(data==='1'){$('#loginModal').modal('show');
            }else if(data!==''){alert(data);}
            else{
                if(fb){alert('Added to cart.');}
            }
        });
    }
}
function buyNow(){
    addToCart(false);
    location.href='#!cart';
}