<?php
if(!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $tb;$lm;
    $sql="select * from `manage_supplier` where (`ID` like '%$se%' or `Name` like '%$se%' or Email like '%$se%' or `Phone` like '%$se%' or Address like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['Name'].'</td>';
            $tb.='<td>'.$row['Email'].'</td>';
            $tb.='<td>'.$row['Phone'].'</td>';
            $tb.='<td>'.base64_decode($row['Address']).'</td>';
            $tb.='<td><button id=\'btview'.$row['ID'].'\' onclick="view('.$row['ID'].')" type="button" class="btview btn btn-primary btn-sm">View</button>
                    <button id=\'spview'.$row['ID'].'\' class="spview hide btn btn-primary btn-sm" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        ..
                    </button></td>';
            $tb.='</tr>';
        }
    }
    mysqli_close($conn);
    $arr= array($rc,$tb);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>