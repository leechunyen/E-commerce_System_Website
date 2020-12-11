<?php
if(!isset($_POST['v'])){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $id=$_SESSION['uid'];$ls;$cp;$spa;
    $v=$_POST['v'];
    $total=0;
    $sql="select * from `user_cart_product` join `product` on `user_cart_product`.`ProductID`=`product`.`ID` where `user_cart_product`.`UserID`=$id;";
    $result=mysqli_query($conn,$sql);
    $itc=mysqli_num_rows($result);
    if($itc>0){
        if($v=='d'){
            $ls='<table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col" class="tbpthcol">Photo</th>
                    <th scope="col" class="tbnamecol">Name</th>
                    <th scope="col" class="tbpricecol">Price</th>
                    <th scope="col" class="tbqtycol">Quantity</th>
                    <th scope="col" class="tbtpricecol">Total Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';
        }
        while($row=mysqli_fetch_assoc($result)){
            if($v=='d'){
                $ls.='<tr id="row'.$row['ProductID'].'">';
                $ls.='<td class="tbpthcol"><img class="pdpth" src="../..'.$row['DefaultPhoto'].'"/></td>';
                $ls.='<td class="tbnamecol tbnamecell" onclick="gotoPorduct('.$row['ID'].');"><p class="tbnamecellp">'.$row['Name'].'</p></td>';
                $ls.='<td class="tbpricecol">'.$xmldata->Currency.'&nbsp;'.number_format($row['Price'],2).'</td>';
                $ls.='<td class="tbqtycol">
                    <div class="input-group-prepend qtycpm">
                        <button onclick="incDecQty(1,'.$row['ProductID'].','.$row['Stock'].');" class="btn btn-outline-secondary" type="button">-</button>
                    </div>
                    <input onchange="qtyChanged(this,'.$row['ProductID'].','.$row['Stock'].');" id="ip_qty'.$row['ProductID'].'" oninput="inputQty(this,'.$row['Stock'].');" type="text" class="ipqty qtycpm form-control" value="'.$row['Quantity'].'">
                    <div class="input-group-prepend qtycpm">
                        <button onclick="incDecQty(2,'.$row['ProductID'].','.$row['Stock'].');" class="btn btn-outline-secondary" type="button">+</button>
                    </div><br/>
                    <spam class="qtystock">stock: '.$row['Stock'].'
                </td>';
                $ls.='<td class"tbtpricecol">'.$xmldata->Currency.'&nbsp;'.number_format((double)$row['Price']*(int)$row['Quantity'],2).'</td>';
                $ls.='<td><button onclick="removeProduct('.$row['ProductID'].')" type="button" class="btn btn-danger">Remove</button></td>';
                $ls.='</tr>';
            }elseif($v=='m'){
                $ls="$v";
            }
            $total+=(double)$row['Price']*(int)$row['Quantity'];
        }
        if($v=='d'){
            $ls.='</tbody>
        </table>';
        }
    }else{$ls='<center><h3>Empty</h3></center>';}
    $sql1="select * from `user_coupon` where `UserID`=$id and `Used`=false and $total>=`MinPay` and '".getDateTime()."'<`ExpireDateTime`;";
    $result1=mysqli_query($conn,$sql1);
    if(mysqli_num_rows($result1)>0) {
        while($row=mysqli_fetch_assoc($result1)){
            $cp.='<div class="input-group spmdseldiv">';
            $cp.='<div class="input-group-prepend">';
            $cp.='<div class="input-group-text">';
            $cp.='<input onclick="couponSele('.$row['ID'].','.$row['Discount'].',`'.$row['Mode'].'`,'.$row['MinPay'].',`'.$xmldata->Currency.'`);" type="radio" name="rbucp">';
            $cp.='</div>';
            $cp.='</div>';
            $cp.='<div class="col spmdsel">';
            $cp.='<labe class="float-left">';
            if($row['Mode']=='c'){$cp.=$xmldata->Currency.'&nbsp;'.$row['Discount'];}
            if($row['Mode']=='p'){$cp.=$row['Discount'].'%';}
            $cp.=' Discount Buy '.$xmldata->Currency.'&nbsp;'.$row['MinPay'].'</label>';
            $cp.='</div>';
            $cp.='</div>';
        }
    }
    $cp.='<div class="input-group spmdseldiv">';
    $cp.='<div class="input-group-prepend">';
    $cp.='<div class="input-group-text">';
    $cp.='<input checked onclick="couponSele(null,null,null,null,null);" type="radio" name="rbucp">';
    $cp.='</div>';
    $cp.='</div>';
    $cp.='<div class="col spmdsel">';
    $cp.='<label>Don\'t use coupon</label>';
    $cp.='</div>';
    $cp.='</div>';
    $sql2="select * from `shipping_info` where `UserID`=$id;";
    $result2=mysqli_query($conn,$sql2);
    if(mysqli_num_rows($result2)>0){
        while($row=mysqli_fetch_assoc($result2)){
            $spa.='<div class="input-group spmdseldiv">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="radio" name="rbspaddr" onclick="shippingAddrSel('.$row['ID'].');">
                    </div>
                </div>
                <div class="col spmdsel">
                    <p>Tag: '.$row['Tag'].'</p>
                    <p>Name: '.$row['Name'].'</p>
                    <p>Email: '.$row['Email'].'</p>
                    <p>Phone: '.$row['Phone'].'</p>
                    <p>Address: '.$row['Address'].' '.$row['City'].' '.$row['State'].' '.$row['Country'].' '.$row['Postcode'].'</p>
                </div>
            </div>';
        }
    }else{$spa.='<center>
        <button onclick="$(\'#spaddr\').modal(\'hide\');location.href=\'#!shipping-address\'";" type="button" class="btn btn-primary">Add Shipping Address</button>
    </center>';}
    mysqli_close($conn);
    $arr=array($ls,$cp,$spa,$total,$itc);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>