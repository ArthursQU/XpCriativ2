<?php
include_once('conexao.php');

$retorno = ['status' => 'nok', 'mensagem' => ''];

$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$valor = $_POST['valor'] ?? 0;
$localidade = $_POST['localidade'] ?? '';
$origem = $_POST['origem'] ?? 'oferta'; // 'oferta' ou 'chamado'

$nome_foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nome_foto = uniqid() . "." . $extensao;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $nome_foto);
}

$sql = "INSERT INTO servico (nome, descricao, tipo, valor, localidade, origem, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssss", $nome, $descricao, $tipo, $valor, $localidade, $origem, $nome_foto);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $retorno = ['status' => 'ok', 'mensagem' => 'Cadastrado com sucesso!'];
    } else {
        $retorno['mensagem'] = 'Erro ao cadastrar no banco.';
    }
    $stmt->close();
}

$conexao->close();
header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);
?>