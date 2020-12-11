<?php
if(!isset($_POST['v'])){echo 'Process stopped.';}
else{
    require '../../php_framework/function.php';
    $uid=$_SESSION['uid'];$ls;$cp;
    $v=$_POST['v'];
    $sql="select * from `user_wishlist_product` join `product` on `user_wishlist_product`.`ProductID`=`product`.`ID` where `user_wishlist_product`.`UserID`=$uid;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        if($v=='d'){
            $ls='<table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col" class="tbpthcol">Photo</th>
                    <th scope="col" class="tbnamecol">Name</th>
                    <th scope="col" class="tbpricecol">Price</th>
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
                $ls.='<td><button onclick="removeProduct('.$row['ID'].')" type="button" class="btn btn-danger">Remove</button></td>';
                $ls.='</tr>';
            }elseif($v=='m'){
                $ls="$v";
            }
        }
        if($v=='d'){
            $ls.='</tbody>
        </table>';
        }
    }else{$ls='<center><h3>Empty</h3></center>';}
    mysqli_close($conn);
    echo$ls;
}
?>