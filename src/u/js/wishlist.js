var v='d';var total=0;var spn='';var spp=0;var spid=0;var dscam=0;var cpid=0;var dscmp=0;var spaddr=0;var tp=0;
if(window.screen.width<=991){v='m';}//mobile
else{v='d';}//desktop
loadData();
function loadData(){
    $.post('../php_files/load_wishlist_list.php',
    {v:v},
    function(data){
        $('#tbls').html(data);
    });
}
function removeProduct(pid){
    $.post('../php_files/remove_from_wishlist.php',
    {pid:pid},
    function(data){
        if(data!==''){alert(data);}
        else{
            $('#row'+pid).remove();
            loadData();
        }
    });
}