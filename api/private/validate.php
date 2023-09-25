<?php 

function isValid($campos = []){

    foreach ($campos as $key => $value) {
            if(empty($_POST[$value]) OR isset($_POST[$value]) && $_POST[$value] == ''){
                $result = array(
                    'msg' =>  ucfirst($value) . ' não pode ser vazio', 
                    'status' => 401
                );

            return json_encode($result);
        }
        
    }

    return false;
}

?>