<?php
require '../../php_framework/function.php';
if(!isset($_POST['p'])||!isset($_SESSION['uid'])){echo 'Process stopped.';}
else{
    $ls;$id=$_SESSION['uid'];
    $sql="select * from `shipping_info` where `UserID`=$id;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $ls.='<div id="spaddr'.$row['ID'].'" class="spaddrs card" style="width: 18rem;">';
            $ls.='<div class="card-body">';
            $ls.='<h5 class="card-title">'.$row['Tag'].'</h5>';
            $ls.='<p class="card-text">Name: '.$row['Name'].'</p>';
            $ls.='<p class="card-text">Phone: '.$row['Phone'].'</p>';
            $ls.='<p class="card-text">Email: '.$row['Email'].'</p>';
            $ls.='<p class="card-text">Address: '.$row['Address'].'</p>';
            $ls.='<p class="card-text">City: '.$row['City'].'</p>';
            $ls.='<p class="card-text">State: '.$row['State'].'</p>';
            $ls.='<p class="card-text">Country: '.$row['Country'].'</p>';
            $ls.='<p class="card-text">PostCode: '.$row['Postcode'].'</p>';
            $ls.='<center>';
            $ls.='<button onclick="view('.$row['ID'].');" type="button" class="btedt btn btn-primary">Edit</button>';
            $ls.='<button onclick="del('.$row['ID'].');" type="button" class="btdel btn btn-danger">Delete</button>';
            $ls.='</center>';
            $ls.='</div>';
            $ls.='</div>';
        }
    }
    echo$ls;
}
?>