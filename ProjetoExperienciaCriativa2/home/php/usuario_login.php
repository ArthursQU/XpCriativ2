<?php
include_once('conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $conexao->prepare("SELECT * FROM usuario WHERE usuario = ? AND senha = ?");
$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();
$resultado = $stmt->get_result();

$tabela = [];

if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $tabela[] = $linha;
    }

    session_start();
    $_SESSION['usuario'] = $tabela[0];

    $retorno = [
        'status' => 'ok',
        'mensagem' => 'Login efetuado com sucesso.',
        'data' => $tabela
    ];
} else {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Usuário ou senha inválidos.',
        'data' => []
    ];
}

$stmt->close();
$conexao->close();

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
