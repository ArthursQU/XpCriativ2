<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "pf";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    header("Content-type:application/json;charset:utf-8");
    die(json_encode(['status' => 'nok', 'mensagem' => 'Erro de conexão: ' . $conexao->connect_error]));
}
?>