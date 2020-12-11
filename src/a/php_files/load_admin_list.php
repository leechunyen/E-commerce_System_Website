<?php
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';$tb;$lm;
    if($md!='*'){$m="`Type`='$md' and";}
    $sql="select * from `admin` where $m (`ID` like '%$se%' or `FirstName` like '%$se%' or LastName like '%$se%' or `Email` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['Username'].'</td>';
            $tb.='<td>'.$row['FirstName'].' '.$row['LastName'].'</td>';
            $tb.='<td>';if($row['Locked']){$tb.='Yes';}else{$tb.='No';}$tb.='</td>';
            $tb.='<td><button id=\'btview'.$row['ID'].'\' onclick="viewAdmin('.$row['ID'].')" type="button" class="btn btn-primary btn-sm">View</button>
                    <button id=\'spview'.$row['ID'].'\' class="hide btn btn-primary btn-sm" type="button" disabled>
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