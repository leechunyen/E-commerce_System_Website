<?php
if(!isset($_POST['mode'])||!isset($_POST['se'])||!isset($_POST['str'])||!isset($_POST['stp'])){
    echo 'Process stopped';
}else{
    require '../../php_framework/function.php';
    $md=$_POST['mode'];
    $se=$_POST['se'];
    $str=$_POST['str']-1;
    $stp=$_POST['stp'];
    $m='';$ls;$lm;
    $sql="select * from `product` where (`Name` like '%$se%' or Detail like '%$se%' or `ModelID` like '%$se%') $lm;";
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
    mysqli_close($conn);
    $arr= array($rc,$ls);
    $json=json_encode($arr);
    if($json){echo $json;}
    else{errorLog('Fail to encode json '.json_last_error_msg());}
}
?>