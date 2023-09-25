<?php
//peoples.php
include 'private/connect.php';
include 'private/validate.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Listar as pessoas cadastradas
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['list'])) {
    $result = $mysqli->query('SELECT * FROM peoples');
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}

// Listar uma única pessoa
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $mysqli->query("SELECT * FROM peoples WHERE id = $id");
    $rows = $result->fetch_assoc();
    echo json_encode($rows);
}

// Inserir dados no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_GET['id'])) {
    $valid = isValid(['name', 'email', 'doc', 'type', 'cep', 'address', 'city', 'state']);
    // Recebe os dados do cliente
$data = $_POST;

// Imprime os dados recebidos no log de erro (pode ser visto no arquivo de log do servidor)
error_log(print_r($data, true));

    if ($valid) {
        echo $valid;
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $doc = $_POST['doc'];
        $type = $_POST['type'];
        $cep = $_POST['cep'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $status = 'A'; 

        // Insira os dados no banco de dados
        $query = "INSERT INTO `peoples` (`name`, `email`, `doc`, `type`, `cep`, `address`, `city`, `state`, `status`)  VALUES ('$name', '$email', '$doc', '$type', '$cep', '$address', '$city', '$state', '$status')";

        if ($mysqli->query($query)) {
            // Se a inserção foi bem-sucedida
            $result = array('msg' => 'Cadastro realizado com sucesso', 'status' => 200);
            echo json_encode($result);
        } else {
            // Se ocorreu algum erro na inserção
            $result = array('msg' => 'Erro ao cadastrar pessoa', 'status' => 500);
            echo json_encode($result);
        }
    }
}

// Atualizar dados no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $valid = isValid(['name', 'email', 'doc', 'type', 'cep', 'address', 'city', 'state']);

    if ($valid) {
        echo $valid;
    } else {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $doc = $_POST['doc'];
        $type = $_POST['type'];
        $cep = $_POST['cep'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $status = $_POST['status']; // Atualize o status conforme necessário

        $mysqli->query("UPDATE `peoples` SET
            `name`='$name', 
            `email`='$email', 
            `doc`='$doc', 
            `type`='$type', 
            `cep`='$cep', 
            `address`='$address', 
            `city`='$city', 
            `state`='$state', 
            `status`='$status'
            WHERE `id`='$id'
        ");

        $result = array('msg' => 'Atualizado realizado com sucesso', 'status' => 200);
        echo json_encode($result);
    }
}

// Deletar registro no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['del'])) {
    $id = $_GET['del'];
    $mysqli->query("DELETE FROM peoples WHERE `id`='$id'");

    $result = array('msg' => 'Deletado com sucesso', 'status' => 200);
    echo json_encode($result);
}
?>
