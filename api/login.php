<?php
include 'private/connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST['email']) 
    && isset($_POST['password'])){

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $mysqli->query(
        "SELECT * FROM users 
            WHERE 
                `email` = '${email}'
                AND
                `password` = '${password}'
        "
    );

    $resp = array('msg' => 'E-mail ou Senha inválida', 'status' => 403);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $_SESSION['user'] = array(
            'name' => $row['name'],
            'email' => $row['email']
        );

        $resp = array('msg' => 'Login efetuado com sucesso', 'status' => 200);
    }
    
    echo json_encode($resp);
}


if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout'])){
    $_SESSION['user'] = array();
    $resp = array(
        'msg' => 'Logout realizado com sucesso.',
        'status' => 200
    );
    echo json_encode($res);
}

?>