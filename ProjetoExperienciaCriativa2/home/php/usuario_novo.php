<?php
include_once('conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';
$tipo = $_POST['tipo'] ?? 'contratante';

if ($nome == '' || $email == '' || $telefone == '' || $usuario == '' || $senha == '') {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Preencha todos os campos.',
        'data' => []
    ];
} else {
    $stmt = $conexao->prepare("INSERT INTO usuario (nome, email, telefone, usuario, senha, tipo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $email, $telefone, $usuario, $senha, $tipo);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Usuário cadastrado com sucesso.',
            'data' => []
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Não foi possível cadastrar o usuário.',
            'data' => []
        ];
    }

    $stmt->close();
}

$conexao->close();

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
