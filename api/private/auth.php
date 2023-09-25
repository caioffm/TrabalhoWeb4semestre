<?php

if(!isset($_SESSION['user'])){

    $a = array(
        'msg' => 'Não autorizado',
        'status' => 403
    );

    echo json_encode($a);
    exit;
}