<?php
if(!isset($_POST['f'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    require_once '../../php_framework/get_country_info_by_ip.php';
    $id;$data;$tb;$m=$_POST['f'];
    if($m=='a'){$tb='admin';$id=$_SESSION['aid'];}
    elseif($m=='u'){$tb='user';$id=$_SESSION['uid'];}
    $sql="select * from `$tb` where ID='$id';";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0) {
        while($row=mysqli_fetch_assoc($result)){$data=$row;}
    }
    mysqli_close($conn);
    $data['cdt']=dataFormat($data['CreateDateTime'],'m/d/Y H:i');
    $data['ldt']=dataFormat($data['LastLoginDateTime'],'m/d/Y H:i');
    $data['llc']=getCountryInfo($data['LastLoginIp'])->geoplugin_countryName.' '.getCountryInfo($data['LastLoginIp'])->geoplugin_city;
    $json=json_encode($data);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>