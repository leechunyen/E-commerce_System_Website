<?php
require '../../php_framework/function.php';
if(!isset($_POST['id'])||!checkAdminLogin(false)){
    echo 'Process stopped';
}else{
    $id=$_POST['id'];$pdls;$tits;$cp;$dv;$cry=$xmldata->Currency;
    $od=getData($conn,$maxCacheItem,'order','ID',$id);
    $pm=getData($conn,$maxCacheItem,'payment','ID',$od['PaymentID']);
    if($pm['UserCouponID']!=''&&$pm['UserCouponID']!=null){
        $cp=getData($conn,$maxCacheItem,'user_coupon','ID',$pm['UserCouponID']);
    }
    if($od['DeliveryID']!=''&&$od['DeliveryID']!=null){
        $dv=getData($conn,$maxCacheItem,'delivery','ID',$od['DeliveryID']);
    }
    $sql="select * from `order_product` where `OrderID`=".$id.";";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $pdls.="<tr>";
            $pdls.="<td><img class='lsppth' src='../..".$row['ProductPhoto']."'/></td>";
            $pdls.="<td>".$row['ProductID']."</td>";
            $pdls.="<td>".$row['ProductName']."</td>";
            $pdls.="<td>".$row['Quantity']."</td>";
            $pdls.="<td>".$cry.'&nbsp;'.$row['ProductPrice']."</td>";
            $pdls.="<td>".$cry.'&nbsp;'.(double)$row['ProductPrice']*(int)$row['Quantity']."</td>";
            $pdls.="</tr>";
            $tits+=(int)$row['Quantity'];
        }
    }
    mysqli_close($conn);
    $arr= array($od,$pm,$pdls,$tits,$cp,$cry,$dv);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>