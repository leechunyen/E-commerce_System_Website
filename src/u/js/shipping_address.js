$('.modal').on('hide.bs.modal',function(){
    $('.modal .form-control').val('');
    $('.modal .form-control').removeClass('is-valid').removeClass('is-invalid');
});
for(const property in countryListAlpha2) {
    $('.country_sel').append(`<option value='${countryListAlpha2[property]}'>${countryListAlpha2[property]}</option>`);
}
loadData();
function add(){
    let name=$('#add_name').val();
    let ph=$('#add_ph').val();
    let em=$('#add_em').val();
    let addr=$('#add_addr').val();
    let city=$('#add_city').val();
    let zc=$('#add_zc').val();
    let st=$('#add_st').val();
    let cty=$('#add_cty').val();
    let tag=$('#add_tag').val();
    var pass=true;
    if(name===''||name===null){
        pass=false;
        $('#er_ad_name').html(epfl);
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else if(name.length>50){
        pass=false;
        $('#er_ad_name').html(maxCharacterMessage(50));
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(name)){
        pass=false;
        $('#er_ad_name').html(stal);
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else if(!isNaN(name.substr(0,1))){
        pass=false;
        $('#er_ad_name').html(ivip);
        $('#add_name').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_name').removeClass('is-invalid').addClass('is-valid');}
    if(ph===''||ph===null){
        pass=false;
        $('#er_ad_ph').html(epfl);
        $('#add_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(ph)){
        pass=false;
        $('#er_ad_ph').html(ivph);
        $('#add_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(ph.length>12){
        pass=false;
        $('#er_ad_ph').html(maxCharacterMessage(12));
        $('#add_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(ph)){
        pass=false;
        $('#er_ad_ph').html(stal);
        $('#add_ph').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_ph').removeClass('is-invalid').addClass('is-valid');}
    if(em===''||em===null){
        pass=false;
        $('#er_ad_em').html(epfl);
        $('#add_em').removeClass('is-valid').addClass('is-invalid');
    }else if(em.length>100){
        pass=false;
        $('#er_ad_em').html(maxCharacterMessage(100));
        $('#add_em').removeClass('is-valid').addClass('is-invalid');
    }else if(!validateEmail(em)||isSpecialCharacter(em)){
        pass=false;
        $('#er_ad_em').html(ivem);
        $('#add_em').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_em').removeClass('is-invalid').addClass('is-valid');}
    if(addr===''||addr===null){
        pass=false;
        $('#er_ad_addr').html(epfl);
        $('#add_addr').removeClass('is-valid').addClass('is-invalid');
    }else if(addr.length>100){
        pass=false;
        $('#er_ad_addr').html(maxCharacterMessage(100));
        $('#add_addr').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(addr)){
        pass=false;
        $('#er_ad_addr').html(stal);
        $('#add_addr').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_addr').removeClass('is-invalid').addClass('is-valid');}
    if(city===''||city===null){
        pass=false;
        $('#er_ad_city').html(epfl);
        $('#add_city').removeClass('is-valid').addClass('is-invalid');
    }else if(city.length>100){
        pass=false;
        $('#er_ad_city').html(maxCharacterMessage(100));
        $('#add_city').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(city)){
        pass=false;
        $('#er_ad_city').html(stal);
        $('#add_city').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_city').removeClass('is-invalid').addClass('is-valid');}
    if(zc===''||zc===null){
        pass=false;
        $('#er_ad_zc').html(epfl);
        $('#add_zc').removeClass('is-valid').addClass('is-invalid');
    }else if(zc.length>10){
        pass=false;
        $('#er_ad_zc').html(maxCharacterMessage(10));
        $('#add_zc').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(zc)){
        pass=false;
        $('#er_ad_zc').html(plno);
        $('#add_zc').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_zc').removeClass('is-invalid').addClass('is-valid');}
    if(st===''||st===null){
        pass=false;
        $('#er_ad_st').html(epfl);
        $('#add_st').removeClass('is-valid').addClass('is-invalid');
    }else if(st.length>100){
        pass=false;
        $('#er_ad_st').html(maxCharacterMessage(100));
        $('#add_st').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(st)){
        pass=false;
        $('#er_ad_st').html(stal);
        $('#add_st').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_st').removeClass('is-invalid').addClass('is-valid');}
    if(cty===''||cty===null){
        pass=false;
        $('#er_ad_cty').html(epfl);
        $('#add_cty').removeClass('is-valid').addClass('is-invalid');
    }else if(cty.length>100){
        pass=false;
        $('#er_ad_cty').html(maxCharacterMessage(100));
        $('#add_cty').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(cty)){
        pass=false;
        $('#er_ad_cty').html(stal);
        $('#add_cty').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_cty').removeClass('is-invalid').addClass('is-valid');}
    if(tag===''||tag===null){
        pass=false;
        $('#er_ad_tag').html(epfl);
        $('#add_tag').removeClass('is-valid').addClass('is-invalid');
    }else if(tag.length>50){
        pass=false;
        $('#er_ad_tag').html(maxCharacterMessage(50));
        $('#add_tag').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(tag)){
        pass=false;
        $('#er_ad_tag').html(stal);
        $('#add_tag').removeClass('is-valid').addClass('is-invalid');
    }else{$('#add_tag').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        let form_data=new FormData();
        form_data.append('data[]',name);
        form_data.append('data[]',ph);
        form_data.append('data[]',em);
        form_data.append('data[]',addr);
        form_data.append('data[]',st);
        form_data.append('data[]',city);
        form_data.append('data[]',zc);
        form_data.append('data[]',cty);
        form_data.append('data[]',tag);
        $.ajax({url:'../php_files/add_shipping_address.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);}
            else{$('.modal').modal('hide');loadData();}
        }});
    }
}
function loadData(){
    $.post('../php_files/load_shipping_address_list.php',
    {p:''},
    function(data){
        $('#divaddrs').html(data);
    });
}
function del(id){
    if(confirm('Delete Shipping Address?')){
        $.post('../php_files/delete_shipping_address.php',
        {id:id},
        function(data){
            if(data!==''){alert(data);}
            else{$('#spaddr'+id).remove();}
        });
    }
}
function view(id){
    $.post('../php_files/load_shipping_address_data.php',
    {id:id},
    function(data){
        let arr=$.parseJSON(data);
        $('#edtid').val(arr['ID']);
        $('#edt_name').val(arr['Name']);
        $('#edt_ph').val(arr['Phone']);
        $('#edt_em').val(arr['Email']);
        $('#edt_addr').val(arr['Address']);
        $('#edt_city').val(arr['City']);
        $('#edt_zc').val(arr['Postcode']);
        $('#edt_st').val(arr['State']);
        $('#edt_cty').val(arr['Country']);
        $('#edt_tag').val(arr['Tag']);
        $('#edt_modal').modal('show');
    });
}
function edit(){
    let id=$('#edtid').val();
    let name=$('#edt_name').val();
    let ph=$('#edt_ph').val();
    let em=$('#edt_em').val();
    let addr=$('#edt_addr').val();
    let city=$('#edt_city').val();
    let zc=$('#edt_zc').val();
    let st=$('#edt_st').val();
    let cty=$('#edt_cty').val();
    let tag=$('#edt_tag').val();
    var pass=true;
    if(name===''||name===null){
        pass=false;
        $('#er_ed_name').html(epfl);
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else if(name.length>50){
        pass=false;
        $('#er_ed_name').html(maxCharacterMessage(50));
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(name)){
        pass=false;
        $('#er_ed_name').html(stal);
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else if(!isNaN(name.substr(0,1))){
        pass=false;
        $('#er_ed_name').html(ivip);
        $('#edt_name').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_name').removeClass('is-invalid').addClass('is-valid');}
    if(ph===''||ph===null){
        pass=false;
        $('#er_ed_ph').html(epfl);
        $('#edt_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(ph)){
        pass=false;
        $('#er_ed_ph').html(ivph);
        $('#edt_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(ph.length>12){
        pass=false;
        $('#er_ed_ph').html(maxCharacterMessage(12));
        $('#edt_ph').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(ph)){
        pass=false;
        $('#er_ed_ph').html(stal);
        $('#edt_ph').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_ph').removeClass('is-invalid').addClass('is-valid');}
    if(em===''||em===null){
        pass=false;
        $('#er_ed_em').html(epfl);
        $('#edt_em').removeClass('is-valid').addClass('is-invalid');
    }else if(em.length>100){
        pass=false;
        $('#er_ed_em').html(maxCharacterMessage(100));
        $('#edt_em').removeClass('is-valid').addClass('is-invalid');
    }else if(!validateEmail(em)||isSpecialCharacter(em)){
        pass=false;
        $('#er_ed_em').html(ivem);
        $('#edt_em').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_em').removeClass('is-invalid').addClass('is-valid');}
    if(addr===''||addr===null){
        pass=false;
        $('#er_ed_addr').html(epfl);
        $('#edt_addr').removeClass('is-valid').addClass('is-invalid');
    }else if(addr.length>100){
        pass=false;
        $('#er_ed_addr').html(maxCharacterMessage(100));
        $('#edt_addr').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(addr)){
        pass=false;
        $('#er_ed_addr').html(stal);
        $('#edt_addr').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_addr').removeClass('is-invalid').addClass('is-valid');}
    if(city===''||city===null){
        pass=false;
        $('#er_ed_city').html(epfl);
        $('#edt_city').removeClass('is-valid').addClass('is-invalid');
    }else if(city.length>100){
        pass=false;
        $('#er_ed_city').html(maxCharacterMessage(100));
        $('#edt_city').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(city)){
        pass=false;
        $('#er_ed_city').html(stal);
        $('#edt_city').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_city').removeClass('is-invalid').addClass('is-valid');}
    if(zc===''||zc===null){
        pass=false;
        $('#er_ed_zc').html(epfl);
        $('#edt_zc').removeClass('is-valid').addClass('is-invalid');
    }else if(zc.length>10){
        pass=false;
        $('#er_ed_zc').html(maxCharacterMessage(10));
        $('#edt_zc').removeClass('is-valid').addClass('is-invalid');
    }else if(isNaN(zc)){
        pass=false;
        $('#er_ed_zc').html(plno);
        $('#edt_zc').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_zc').removeClass('is-invalid').addClass('is-valid');}
    if(st===''||st===null){
        pass=false;
        $('#er_ed_st').html(epfl);
        $('#edt_st').removeClass('is-valid').addClass('is-invalid');
    }else if(st.length>100){
        pass=false;
        $('#er_ed_st').html(maxCharacterMessage(100));
        $('#edt_st').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(st)){
        pass=false;
        $('#er_ed_st').html(stal);
        $('#edt_st').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_st').removeClass('is-invalid').addClass('is-valid');}
    if(cty===''||cty===null){
        pass=false;
        $('#er_ed_cty').html(epfl);
        $('#edt_cty').removeClass('is-valid').addClass('is-invalid');
    }else if(cty.length>100){
        pass=false;
        $('#er_ed_cty').html(maxCharacterMessage(100));
        $('#edt_cty').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(cty)){
        pass=false;
        $('#er_ed_cty').html(stal);
        $('#edt_cty').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_cty').removeClass('is-invalid').addClass('is-valid');}
    if(tag===''||tag===null){
        pass=false;
        $('#er_ed_tag').html(epfl);
        $('#edt_tag').removeClass('is-valid').addClass('is-invalid');
    }else if(tag.length>50){
        pass=false;
        $('#er_ed_tag').html(maxCharacterMessage(50));
        $('#edt_tag').removeClass('is-valid').addClass('is-invalid');
    }else if(isSpecialCharacter(tag)){
        pass=false;
        $('#er_ed_tag').html(stal);
        $('#edt_tag').removeClass('is-valid').addClass('is-invalid');
    }else{$('#edt_tag').removeClass('is-invalid').addClass('is-valid');}
    if(pass){
        let form_data=new FormData();
        form_data.append('data[]',id);
        form_data.append('data[]',name);
        form_data.append('data[]',ph);
        form_data.append('data[]',em);
        form_data.append('data[]',addr);
        form_data.append('data[]',st);
        form_data.append('data[]',city);
        form_data.append('data[]',zc);
        form_data.append('data[]',cty);
        form_data.append('data[]',tag);
        $.ajax({url:'../php_files/edit_shipping_address.php',dataType:'text',
        cache:false,contentType:false,processData:false,data:form_data,
        type:'post',success:function(data){
            if(data!==''){alert(data);}
            else{$('.modal').modal('hide');loadData();}
        }});
    }
}