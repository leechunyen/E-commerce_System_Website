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
    if($md!='*'){$m="`Status`='$md' and";}
    $sql="select * from `purchase_history` where $m (`ID` like '%$se%' or `ProductID` like '%$se%' or Quantity like '%$se%' or `Price` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $tb.='<tr id="tbrw'.$row['ID'].'">';
            $tb.='<td><img class="pths" src="../..'.$row['ProductPhoto'].'"/></td>';
            $tb.='<td>'.$row['ID'].'</td>';
            $tb.='<td>'.$row['ProductID'].'</td>';
            $tb.='<td>'.$row['ProductName'].'</td>';
            $tb.='<td>'.$row['Quantity'].'</td>';
            $tb.='<td>'.$row['Price'].'</td>';
            $tb.='<td>';if($row['Status']=='w'){$tb.='Waiting';}elseif($row['Status']=='f'){$tb.='Finished';}elseif($row['Status']=='c'){$tb.='Cancelled';}$tb.='</td>';
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