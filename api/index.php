<?php
// header("Content-type: application/json; charset=utf-8");

include 'private/connect.php';






// if(isset($_GET['id'])){

//     $id = $_GET['id'];
//     $sqlQuery = "SELECT * FROM users WHERE id = $id";
//     //echo mysqli_num_rows(mysqli_query($mysqli, $sqlQuery));
//     if($sqlRes = mysqli_query($mysqli, $sqlQuery)){
//         $row = mysqli_fetch_assoc($sqlRes);
//     }

//     if(@$row != null){
//         echo json_encode($row);
//     } else {
//         echo 'Dados não encontrado';
//     }
// }



$query = mysqli_query($mysqli, "SELECT * FROM users WHERE `status` = 'A'");
$a = [];
while ($row = mysqli_fetch_assoc($query)) {     	
    $a[] = $row;   
}
echo json_encode($a);




    //$sqlQuery = "SELECT * FROM users WHERE `status` = 'A'";
    
    // if($sqlRes = mysqli_query($mysqli, $sqlQuery)){
    //     $row = mysqli_fetch_all($sqlRes);
    // }

    // if($row != null){
    //     $jsonData = json_encode(array('data'=>json_encode($row), 'status' => 'success'));
    //     //echo json_encode($row);
    //     echo $jsonData;
    // } else {
    //     echo 'Dados não encontrado';
    // }


?>