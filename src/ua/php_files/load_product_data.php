<?php
if(!isset($_POST['id'])||!isset($_POST['m'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $id=$_POST['id'];
    $m=$_POST['m'];
    $data=getData($conn,$maxCacheItem,'product','ID',$id);
    if($m!='p'){
        $data['wl']=false;
        if(isset($_SESSION['uid'])){
            $uid=$_SESSION['uid'];
            $sql="select * from `user_wishlist_product` where `UserID`=$uid and `ProductID`=$id";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    if($row['UserID']==$uid&&$row['ProductID']==$id){
                        $data['wl']=true;
                    }
                }
            }
        }
        $mrph='';
        $sql="select * from `product_photo` where `ProductID`=$id;";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                $mrph.='<div class="imgivarrdiv">
                    <a class="venobox" data-gall="photos" href="../..'.$row['Photo'].'"><img class="mrimgs" src="../..'.$row['Photo'].'"/></a>';
                if($m=='a'){$mrph.='<br/><center><button onclick="deleteMrPh(this,\''.$row['Photo'].'\');" type="button" class="btn btn-danger hide delMrPh">Delete</button></center>';}
                $mrph.='</div>';
            }
        }
        $data['mrph']=$mrph;
    }
    $json=json_encode($data);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>