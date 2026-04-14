<?php
session_start();
session_destroy();
header("Content-type:application/json;charset:utf-8");
echo json_encode(['status' => 'ok', 'mensagem' => 'Logoff efetuado com sucesso.']);
?>