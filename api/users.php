<?php
//users.php
include 'private/connect.php';
include 'private/validate.php';


//listar os usuarios cadastrados
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['list'])){

    $result = $mysqli->query('SELECT * FROM users');
    $rows = array();
    while($row = $result->fetch_assoc()){
        $rows[] = $row; 
    }

    echo json_encode($rows);
    
}

//listar um unico item
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $mysqli->query("SELECT * FROM users WHERE id = $id");
    $rows = $result->fetch_assoc();
    echo json_encode($rows);
}

//inserir dados no database
if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_GET['id'])){

    $valid = isValid(['name', 'email', 'password']);

    if($valid){
        echo $valid;
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $status = 'A';

        // Insira os dados no banco de dados
    $query = "INSERT INTO `users` (`name`, `email`, `password`, `status`) 
    VALUES ('$name', '$email', '$password', '$status')";

        if ($mysqli->query($query)) {
            // Se a inserção foi bem-sucedida
            $result = array('msg' => 'Cadastro realizado com sucesso', 'status' => 200);
            echo json_encode($result);
        } else {
            // Se ocorreu algum erro na inserção
            $result = array('msg' => 'Erro ao cadastrar usuário', 'status' => 500);
            echo json_encode($result);
        }
    }

}


//update dados no database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])){

    $valid = isValid(['name', 'email', 'password']);
    
    if($valid){
        echo $valid;
    } else {

        $id = $_GET['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $status = $_POST['status'];

        $mysqli->query("UPDATE `users` SET
            `name`='${name}', 
            `email`='${email}', 
            `password`='${password}', 
            `status`='${status}'
            WHERE `id`='${id}'
        ");

        $result = array('msg' => 'Atualizado realizado com sucesso', 
                        'status' => 200
                );
        echo json_encode($result);

    }
}



//deletar registro no dados no database
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['del'])){

    $id = $_GET['del'];
    $mysqli->query("DELETE FROM users WHERE `id`='${id}'");

    $result = array('msg' => 'Deletado com sucesso', 
                    'status' => 200
                );
    echo json_encode($result);

}

?>