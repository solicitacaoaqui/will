<?php
// Definir cabeçalhos para permitir requisição JSON
header("Content-Type: application/json");

// Ler os dados recebidos do POST
$inputJSON = file_get_contents("php://input");
$dados = json_decode($inputJSON, true);

// Verificar se os dados foram recebidos corretamente
if (!$dados || !isset($dados['nome']) || !isset($dados['cpf'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Dados incompletos ou inválidos."
    ]);
    exit;
}

// Preparar o arquivo onde vamos salvar os dados
$arquivo = "usuarios.json";

// Ler conteúdo existente
$conteudoAtual = file_exists($arquivo) ? file_get_contents($arquivo) : "[]";
$usuarios = json_decode($conteudoAtual, true);

// Adicionar o novo usuário
$usuarios[] = $dados;

// Salvar de volta no arquivo
if(file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT))) {
    echo json_encode([
        "status" => "success",
        "message" => "Dados salvos com sucesso!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Erro ao salvar os dados."
    ]);
}
?>
