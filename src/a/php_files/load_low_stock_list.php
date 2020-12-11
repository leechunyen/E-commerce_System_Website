<?php
if(!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $tb;$lm;
    $sql="select * from `product` where `Stock` <= `ReorderPoint` and (`ID` like '%$se%' or `Name` like '%$se%' or Price like '%$se%' or `Stock` like '%$se%' or ReorderPoint like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td><img class="pths" src="../..'.$row['DefaultPhoto'].'"/></td>';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['Name'].'</td>';
            $tb.='<td>'.$xmldata->Currency.'&nbsp;'.$row['Price'].'</td>';
            $tb.='<td>'.$row['Stock'].'</td>';
            $tb.='<td>'.$row['ReorderPoint'].'</td>';
            $tb.='<td><button id=\'btview'.$row['ID'].'\' onclick="purchaseOrder('.$row['ID'].')" type="button" class="btview btn btn-primary btn-sm">Purchase</button>
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