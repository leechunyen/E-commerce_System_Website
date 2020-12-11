<?php
require '../../php_framework/function.php';
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';
    if($md=='a'){
        $m="`Available`=true and";
    }elseif($md=='u'){
        $m="`Available`=false and";
    }
    $tb;
    $lm;
    $sql="select * from `product` where $m (`ID` like '%$se%' or `Name` like '%$se%' or `Price` like '%$se%' or `ModelID` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td><img class="prodfpho" src="../..'.$row['DefaultPhoto'].'"/></td>';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['Name'].'</td>';
            $tb.='<td>'.$row['ModelID'].'</td>';
            $tb.='<td>'.$row['Price'].'</td>';
            $tb.='<td>';if($row['Available']){$tb.='Yes';}else{$tb.='No';}$tb.='</td>';
            $tb.='<td><button id=\'btview'.$row['ID'].'\' onclick="view('.$row['ID'].')" type="button" class="btn btn-primary btn-sm">View</button>
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