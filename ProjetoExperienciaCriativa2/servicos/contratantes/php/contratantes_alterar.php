<?php
include_once('conexao.php');

$retorno = [
    'status'    => '',
    'mensagem'  => '',
    'data'      => []
];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $localidade = $_POST['localidade'] ?? '';

    if ($nome == '' || $descricao == '' || $tipo == '' || $valor == '' || $localidade == '') {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Preencha todos os campos',
            'data' => []
        ];
    } else {
        $stmt = $conexao->prepare("UPDATE servico SET nome = ?, descricao = ?, tipo = ?, valor = ?, localidade = ? WHERE id = ?");
        $stmt->bind_param("sssdsi", $nome, $descricao, $tipo, $valor, $localidade, $id);
        $stmt->execute();

        if ($stmt->affected_rows >= 0) {
            $retorno = [
                'status' => 'ok',
                'mensagem' => 'Registro alterado com sucesso',
                'data' => []
            ];
        } else {
            $retorno = [
                'status' => 'nok',
                'mensagem' => 'Não foi possível alterar o registro',
                'data' => []
            ];
        }

        $stmt->close();
    }
} else {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Não foi possível alterar o registro sem ID',
        'data' => []
    ];
}

$conexao->close();

header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);