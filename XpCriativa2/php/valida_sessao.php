<?php
session_start();
header("Content-type:application/json;charset:utf-8");

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'status' => 'ok',
        'mensagem' => 'Sessão ativa',
        'data' => [$_SESSION['usuario']]
    ]);
} else {
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Sessão inválida',
        'data' => []
    ]);
}
?>