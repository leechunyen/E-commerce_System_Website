<?php
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $uid=$_SESSION['uid'];
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';$cps;$lm="limit $str, $stp";$dv;$cry=$xmldata->Currency;
    if($md=='a'){
        $m="`ExpireDateTime` < '".getDateTime()."' and `Used` = false and";
    }elseif($md=='e'){
        $m="`ExpireDateTime` >= '".getDateTime()."' and `Used` = false and";
    }elseif($md=='u'){
        $m="`Used` = true and";
    }
    $sql="select * from `user_coupon` where $m `UserID`=$uid $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $mode=$row['Mode'];
            $cps.='<div class="form-group cpdiv dp_il_b">
                <div class="cpct">
                    <label>Pay '.$xmldata->Currency.'&nbsp;'.$row['MinPay'].' get '; if($mode=='c'){$cps.=$xmldata->Currency.'&nbsp;'.$row['Discount'];}elseif($mode=='p'){$cps.=number_format($row['Discount'],0).'%';} $cps.=' offer</label>
                    <br/><label>Valid until '.dataFormat($row['ExpireDateTime']).'</label>
                    <br/><label>';if($row['Used']){$cps.='Used';}elseif(new DateTime($row['ExpireDateTime'])>new DateTime(getDateTime())){$cps.='Available';}else{$cps.='Expired';}$cps.='</label>
                </div>
            </div>';
        }
    }
    mysqli_close($conn);
    $arr= array($rc,$cps);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>