<?php
include_once('conexao.php');
session_start();

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

if (isset($_GET['perfil'])) {
    if (isset($_SESSION['usuario'])) {
        $usuarioSessao = $_SESSION['usuario'];
        $id = $usuarioSessao['id'];

        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id = ?");
        $stmt->bind_param("i", $id);
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Sessão não encontrada.',
            'data' => []
        ];

        header("Content-type:application/json;charset:utf-8");
        echo json_encode($retorno);
        exit;
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id);
} else {
    $stmt = $conexao->prepare("SELECT * FROM usuario ORDER BY id DESC");
}

$stmt->execute();
$resultado = $stmt->get_result();

$tabela = [];

if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $tabela[] = $linha;
    }

    $retorno = [
        'status' => 'ok',
        'mensagem' => 'Registros encontrados',
        'data' => $tabela
    ];
} else {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Nenhum registro encontrado',
        'data' => []
    ];
}

$stmt->close();
$conexao->close();

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
