<?php
require_once 'config.php';

function validarDados($dados, $camposObrigatorios) {
    $erros = [];
    foreach ($camposObrigatorios as $campo) {
        if (empty($dados[$campo])) {
            $erros[] = "O campo $campo é obrigatório";
        }
    }
    return $erros;
}

function getJsonInput() {
    return json_decode(file_get_contents('php://input'), true);
}
?>