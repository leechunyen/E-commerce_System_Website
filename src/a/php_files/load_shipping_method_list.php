<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])){
    echo 'Process stopped';
}else{
    $ls;
    $sql="select * from `shipping_method`;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $ls.='<div id="spmdiv'.$row['ID'].'" class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">'.$row['Title'].'</h5>
                        <p class="card-text">Price: '.$xmldata->Currency.'&nbsp;'.$row['Price'].'</p>
                        <p class="card-text">Delivery in: '.$row['DeliveryDays'].'</p>
                        <center>
                            <button id="spmedt'.$row['ID'].'" onclick="view('.$row['ID'].');" type="button" class="btedt btn btn-primary">Edit</button>
                            <button id="spmdel'.$row['ID'].'" onclick="del('.$row['ID'].',\''.$row['Title'].'\');" type="button" class="btedt btn btn-danger">Delete</button>
                        </center>
                    </div>
                </div>';
        }
    }
    mysqli_close($conn);
    echo$ls;
}
?>