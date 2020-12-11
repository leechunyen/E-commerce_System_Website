<?php
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';$tb;$lm="limit $str, $stp";
    if($md=='o'){
        $m="`DeliveryID`is null and";
    }elseif($md=='s'){
        $m="`DeliveryID` is not null and";
    }
    $sql="select * from `order` where $m (`ID` like '%$se%' or `DateTime` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tpd=0;
            $sql1="select `Quantity` from `order_product` where `OrderID`=".$row['ID'].";";
            $result1=mysqli_query($conn,$sql1);
            if(mysqli_num_rows($result1)>0){
                while($row1=mysqli_fetch_assoc($result1)){
                    $tpd+=(int)$row1['Quantity'];
                }
            }            
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['DateTime'].'</td>';
            $tb.='<td>'.$tpd.'</td>';
            $tb.='<td>';if($row['DeliveryID']!=null||$row['DeliveryID']!=''){$tb.='Yes';}else{$tb.='No';}$tb.='</td>';
            $tb.='<td><button id=\'btview'.$row['ID'].'\' onclick="view('.$row['ID'].')" type="button" class="btview btn btn-primary btn-sm">View</button>
                    <button id=\'spview'.$row['ID'].'\' class="hide btn btn-primary btn-sm" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        ..
                    </button></td>';
            $tb.='</tr>';
        }
    }
    mysqli_close($conn);
    $arr= array($rc,$tb,$sql1);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>