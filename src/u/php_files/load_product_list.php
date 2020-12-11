<?php
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';$ls;$acp;$lm;
    $sql="select * from `product` where `Available`=true and `Stock`>0 and (`Name` like '%$se%' or `ModelID` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    $lm="limit $str, $stp";
    if($rc>0){
        while($row=mysqli_fetch_assoc($result)){
            $ls.="<div onclick='gotoPorduct(".$row['ID'].");' class='card products'>";
            $ls.="<img src='../..".$row['DefaultPhoto']."' class='card-img-top product_photo' alt='Img'>";
            $ls.="<div class='card-body'>";
            $ls.="<p class='pro_name'>".$row['Name']."</p>";
            $ls.="<p class='pro_price'>".$xmldata->Currency.'&nbsp;'.$row['Price']."</p>";
            $ls.="</div>";
            $ls.="</div>";
        }
    }
    $id=$_SESSION['uid'];
    $sql1="select * from `coupon_type` where `Available`=true and `ID` not in (select `CouponTypeID` from `user_coupon` where `UserID`='$id');";
    $result1=mysqli_query($conn,$sql1);
    if(mysqli_num_rows($result1)>0){
    $acp.='<div id="coupon_view_arr_div">';
        while($row=mysqli_fetch_assoc($result1)){
        $mode=$row['Mode'];
        $acp.='<div id="cp'.$row['ID'].'" class="form-group cpdiv">
            <div class="cpct">
                <h3>'.$row['Description'].'</h3>
                <label>Pay '.$xmldata->Currency.'&nbsp;'.$row['MinPay'].' get '; if($mode=='c'){$acp.=$xmldata->Currency.'&nbsp;'.$row['Discount'];}elseif($mode=='p'){$acp.=number_format($row['Discount'],0).'%';}$acp.=' offer</label>
            </div>
            <div class="cpct">
                <button id="cpbtn'.$row['ID'].'" onclick="getCoupon('.$row['ID'].');" type="button" class="btn btn-primary btgtcp">Get</button>
            </div>
        </div>';
        }$acp.='</div>';
    }
    
    mysqli_close($conn);
    $arr= array($rc,$ls,$acp);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>