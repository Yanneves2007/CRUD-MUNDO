<?php
// Exclui uma cidade baseado no ID recebido via GET.

include 'conexao.php'; 

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: ../listar_cidades.php?erro=ID da cidade não especificado.");
    exit();
}

$id_cidade = $_GET['id'];

// Prepara o SQL para exclusão (DELETE)
$sql = "DELETE FROM cidades WHERE id_cidade = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cidade);

// Executa e redireciona
try {
    if ($stmt->execute()) {
        // Verifica se alguma linha foi realmente excluída
        if ($stmt->affected_rows > 0) {
            header("Location: ../listar_cidades.php?sucesso=Cidade excluída com sucesso!");
        } else {
            // Se o ID não existia (affected_rows = 0)
            header("Location: ../listar_cidades.php?erro=Cidade não encontrada.");
        }
    } else {
        // Falha na execução
        throw new Exception("Erro ao executar a exclusão.");
    }
} catch (mysqli_sql_exception $e) {
    // Captura erros do SQL
    header("Location: ../listar_cidades.php?erro=Erro de banco de dados ao excluir.");
}

$stmt->close();
$conn->close();
?>