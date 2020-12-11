var cy=new Date().getFullYear();
var d='<option class="dobselfs" value="">--</option>';
var m='<option class="dobselfs" value="">--</option>';
var y='<option class="dobselfs" value="">--</option>';
for (var i =1;i<=31;i++){
    d+="<option value='"+i+"'>"+i+"</option>";
}
for (var i =1;i<=12;i++){
    m+="<option value='"+i+"'>"+i+"</option>";
}
for (var i =cy;i>=cy-150;i--){
    y+="<option value='"+i+"'>"+i+"</option>";
    
}
$('#dob_day_sel,.dob_day_sel').html(d);
$('#dob_mon_sel,.dob_mon_sel').html(m);
$('#dob_yar_sel,.dob_yar_sel').html(y);