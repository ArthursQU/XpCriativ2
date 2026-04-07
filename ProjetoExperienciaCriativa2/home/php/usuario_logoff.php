<?php
session_start();
session_unset();
session_destroy();

$retorno = ['status' => 'ok', 'mensagem' => 'Logout efetuado.', 'data' => []];

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
