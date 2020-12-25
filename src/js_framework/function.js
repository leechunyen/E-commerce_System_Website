let stal='Please use standard alphanumerics.';
let epfl='Please fill.';
let plno='Please fill a number.';
let plpo='Invalid port number.';
let ivph='Invalid phone number.';
let ivvc='Invalid validation code.';
let pwnm='Password not match.';
let plsl='Please select.';
let ivem='Please fill in a valid email.';
let ivdt='Invalid date.';
let ivtd='Invalid date time.';
let alex='Already exist please use another.';
let atua='unavailabel time can\'t early or equre toavailable time.';
let ivip="Invalid input.";
function gotoHTTPS(){
    location.protocol = "https:";
}
function getRequest(name){
    let results=new RegExp('[\?&]'+name+'=([^&#]*)').exec(window.location.href);
    if (results===null){return null;}
    else{return results[1]||0;}
}
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function getElementID(e){
    return document.getElementById(e);
}
function isSpecialCharacter(str){
    var pattern=new RegExp(/[~`!#$\^&*+=\[\]\\';/{}|\\":<>\?]/); //unacceptable chars
    if(pattern.test(str)){return true;}else{return false;}
    
}
function isUppercaseIncluded(str){
    return /[A-Z]/.test(str);
}
function maxCharacterMessage(max){
    return max+' characters is the maximum allowed.';
}
function valueRangeMessage(rg){
    return `only ${rg} allowed.`;
}
function isValidPortNumber(port){
    if(isNaN(port)||(port<0||port>65353)){return false;}
    else{return true;}
}
function logOut(m){//1=user 2=admin
    var p='../../ua/php_files/log_out.php';
    $.post(p,{m:m},function(data){
        if(data===''){location.reload();}else{alert(data);}
    });
}
function isValidDate(dateString,sp){//mm/dd/yyyy
    if(!dateString.length===10){return false;}
    let parts=dateString.split(sp);
    let day=parseInt(parts[1],10);
    let month=parseInt(parts[0],10);
    let year=parseInt(parts[2],10);
    if(isNaN(year)||isNaN(month)||month<1||month>12){return false;}
    let monthLength=[31,28,31,30,31,30,31,31,30,31,30,31];
    if(year%400===0||(year%100!==0&&year%4===0)){monthLength[1]=29;}
    return !isNaN(day)&&day>0&&day<=monthLength[month-1];
};
function isValidDateTime(dt){//MM/DD/YYYY HH:mm
    return moment(dt).format('MM/DD/YYYY HH:mm');
}
function stringToDateTime(dt){
    return new Date(dt);
}
function getAllUrlParameter(){
    let url=$(location).attr('href');
    if(url.includes("?")){
        let urllg=url.length;
        let st=url.indexOf("?");
        return url.substring(st,urllg);
    }return'';
}
function checkFrom(){
    let pth=location.pathname;
    let pg=pth.indexOf('pages')-2;
    return pth.substring(pg,pg+1);
}
function dateFormat(dstr){
    let parts=dstr.split(' ');
    let date=parts[0].split('-');
    let y=date[0];
    let m=date[1];
    let d=date[2];
    let time=parts[1].split(':');
    let h=time[0];
    let M=time[1];
    return m+'/'+d+'/'+y+' '+h+':'+M;
}
function formatMoney(number,decPlaces,decSep,thouSep){
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;
    return sign +
	(j ? i.substr(0, j) + thouSep : "") +
	i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
	(decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}
function isHTML(str){
    var a=document.createElement('div');
    a.innerHTML=str;
    for (var c = a.childNodes, i = c.length; i--; ) {
        if(c[i].nodeType===1)return true; 
    }return false;
}