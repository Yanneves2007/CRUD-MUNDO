<?php
// Recebe os dados do 'editar_cidade.php' e faz o UPDATE no banco.

include 'conexao.php';

// Verifica se o ID da cidade foi enviado (via POST)
if (isset($_POST['id_cidade'])) {
    
    // Coleta os dados do formulário
    $id_cidade = $_POST['id_cidade'];
    $nome = trim($_POST['nome']); // trim() remove espaços em branco
    $id_pais = $_POST['id_pais'];
    $populacao = !empty($_POST['populacao']) ? $_POST['populacao'] : null;

    // Validação simples no lado do servidor
    if (empty($nome) || empty($id_pais)) {
        header("Location: ../listar_cidades.php?erro=Preencha todos os campos obrigatórios");
        exit();
    }

    // Prepara o SQL para o UPDATE
    $sql = "UPDATE cidades SET nome = ?, id_pais = ?, populacao = ? WHERE id_cidade = ?";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros (bind)
    // 'siii' = string (nome), integer (id_pais), integer (populacao), integer (id_cidade)
    $stmt->bind_param("siii", $nome, $id_pais, $populacao, $id_cidade);

    // Executa e redireciona
    if ($stmt->execute()) {
        header("Location: ../listar_cidades.php?sucesso=Cidade atualizada com sucesso!");
    } else {
        header("Location: ../listar_cidades.php?erro=Erro ao atualizar cidade");
    }

    $stmt->close();
}

$conn->close();
?>