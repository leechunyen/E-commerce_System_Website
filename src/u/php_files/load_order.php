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
    $m='';$tb;$lm="limit $str, $stp";$dv;$cry=$xmldata->Currency;
    if($md=='o'){
        $m="`DeliveryID`is null and";
    }elseif($md=='s'){
        $m="`DeliveryID` is not null and";
    }
    $sql="select * from `order` where $m `UserID`=$uid and (`ID` like '%$se%' or `DateTime` like '%$se%') $lm;";
    $result=mysqli_query($conn,$sql);
    $rc=mysqli_num_rows($result);
    if($rc>0){
        while($od=mysqli_fetch_assoc($result)){
            $py=getData($conn,$maxCacheItem,'payment','ID',$od['PaymentID']);
            if($od['DeliveryID']!=''&&$od['DeliveryID']!=null){
                $dv=getData($conn,$maxCacheItem,'delivery','ID',$od['DeliveryID']);
            }
            if($py['UserCouponID']!=''&&$py['UserCouponID']!=null){
                $cp=getData($conn,$maxCacheItem,'user_coupon','ID',$py['UserCouponID']);
            }
            $tb.='<div class="pds">
                <div class="ohd">
                    <div>
                        <div class="dp_il_b viewcts">
                            Order ID:&nbsp;<label>'.$od['ID'].'</label>
                        </div>
                        <div class="dp_il_b viewcts">
                            User ID:&nbsp;<label>'.$od['UserID'].'</label>
                        </div>
                        <div class="dp_il_b viewcts">
                            Order Date Time:&nbsp;<label>'.dataFormat($od['DateTime']).'</label>
                        </div>
                    </div>
                    <div>
                        <br/><b class="lbs">Shipping info:</b><br/>
                        <div class="dp_il_b viewcts">
                            Name:&nbsp;<label>'.$od['ShippingName'].'</label>
                        </div>
                        <div class="dp_il_b viewcts">
                            Phone:&nbsp;<label>'.$od['ShippingPhone'].'</label>
                        </div>
                        <div class="dp_il_b viewcts">
                            Email:&nbsp;<label>'.$od['ShippingEmail'].'</label>
                        </div>
                        <div>
                            <div class="viewcts">
                                Address:&nbsp;<label>'.$od['ShippingAddress'].'</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pdtdiv">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $sql1="select * from `order_product` where `OrderID`=".$od['ID'].";";
                            $result1=mysqli_query($conn,$sql1);
                            if(mysqli_num_rows($result1)>0){
                                while($pd=mysqli_fetch_assoc($result1)){
                                    $tb.="<tr>";
                                    $tb.="<td><img class='lsppth' src='../..".$pd['ProductPhoto']."'/></td>";
                                    $tb.="<td>".$pd['ProductID']."</td>";
                                    $tb.="<td>".$pd['ProductName']."</td>";
                                    $tb.="<td>".$pd['Quantity']."</td>";
                                    $tb.="<td>".$cry.'&nbsp;'.$pd['ProductPrice']."</td>";
                                    $tb.="<td>".$cry.'&nbsp;'.(double)$pd['ProductPrice']*(int)$pd['Quantity']."</td>";
                                    $tb.="</tr>";
                                }
                            }
                        $tb.='</tbody>
                    </table>
                </div>
                <div class="float-left botdiv">
                    <b class="lbs">Payment:</b>
                    <div class="viewcts">
                        Total:&nbsp;<label>'.$cry.'&nbsp;'.number_format((double)$od['TotalAmount'], 2, '.', '').'</label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Shipping Fee:&nbsp;<label>'.$cry.'&nbsp;'.number_format((double)$py['ShippingFee'], 2, '.', '').'</label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Shipping Method:&nbsp;<label>'.$py['ShippingMethodSelected'].'</label>
                    </div>
                    <div class="viewcts">
                        Coupon:&nbsp;<label>';if($py['UserCouponID']!=''&&$py['UserCouponID']!=null){
                            if($cp['Mode']=='p'){$tb.=$cry.'&nbsp;'.number_format((double)$od['TotalAmount']*(int)$cp['Discount']/100, 2, '.', '').'&nbsp;('.(int)$cp['Discount'].'%)';}
                            elseif($cp['Mode']=='c'){$tb.=$cry.'&nbsp;'.number_format((double)$cp['Discount'], 2, '.', '');}
                        }else{$tb.=$cry.'&nbsp;0.00';}$tb.='</label>
                    </div>
                    <div class="viewcts">
                        Paid:&nbsp;<label>'.$cry.'&nbsp;'.number_format((double)$py['PaidAmount'],2,'.','').'</label>
                    </div>
                </div>
                <div id="spdiv" class="float-right botdiv">
                    <b class="lbs">Shipping:</b>
                    <div class="viewcts">
                        Shipped Out:&nbsp;<label>';if($od['DeliveryID']==null||$od['DeliveryID']==''){$tb.='NO';}else{$tb.='YES';}$tb.='</label>
                    </div>';
                    if($od['DeliveryID']!=null&&$od['DeliveryID']!=''){
                    $tb.='<div id="vsptdiv">
                        <div class="viewcts">
                            Date Time:&nbsp;<label>'.dataFormat($dv['DateTime']).'</label>
                        </div>
                        <div class="viewcts">
                            Tracking Code:&nbsp;<label>'.$dv['TrackingNumber'].'</label>
                        </div>
                    </div>';
                    }
                $tb.='</div>
                <div style="clear: both;"></div>
            </div>';
            
        }
    }
    mysqli_close($conn);
    $arr= array($rc,$tb);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>