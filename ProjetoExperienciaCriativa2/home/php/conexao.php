<?php
$servidor = "localhost:3307";
$usuario  = "root";
$senha    = "";
$banco    = "pf";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão com o banco: " . $conexao->connect_error);
}
?>
