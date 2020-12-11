<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])){
    echo 'Process stopped';
}else{
    $ls;
    $sql="select * from `coupon_type`;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $ls.='<div id="ctdiv'.$row['ID'].'" class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">'.$row['Description'].'</h5>';
                        $ls.='<p class="card-text">Available: ';if($row['Available']){$ls.='Yes';}else{$ls.='No';}$ls.='</p>';
                        $ls.='<p class="card-text">Minmum Pay: '.$xmldata->Currency.'&nbsp;'.$row['MinPay'].'</p>
                        <p class="card-text">Discount: ';if($row['Mode']=='c'){$ls.=$xmldata->Currency.'&nbsp;'.$row['Discount'];}if($row['Mode']=='p'){$ls.=(int)$row['Discount'].'&nbsp;%';}$ls.='</p>
                        <p class="card-text">Days To Expired: '.$row['DaysToExpired'].'</p>
                        <center>
                            <button id="ctedt'.$row['ID'].'" onclick="view('.$row['ID'].');" type="button" class="btedt btn btn-primary">Edit</button>
                            <button id="ctdel'.$row['ID'].'" onclick="del('.$row['ID'].',\''.$row['Description'].'\');" type="button" class="btedt btn btn-danger">Delete</button>
                        </center>
                    </div>
                </div>';
        }
    }
    mysqli_close($conn);
    echo$ls;
}
?>