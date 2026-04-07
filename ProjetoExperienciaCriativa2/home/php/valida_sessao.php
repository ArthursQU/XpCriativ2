<?php
session_start();

$retorno = ['status' => 'nok', 'mensagem' => 'Sessão inválida', 'data' => []];

if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
    $retorno = ['status' => 'ok', 'mensagem' => 'Sessão válida', 'data' => [$_SESSION['usuario']]];
}

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
