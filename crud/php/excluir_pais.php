<?php
include 'conexao.php'; // Inclui sua conexão

//  Verificar se o ID foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: ../listar_paises.php?erro=ID do país não especificado.");
    exit();
}

$id_pais = $_GET['id'];

// Iniciar uma transação
// Isso garante que ambas as exclusões (cidades e país) funcionem,
// ou nenhuma delas.
$conn->begin_transaction();

try {
    // PRIMEIRO: Excluir as CIDADES filhas
    // Esta é a etapa que permite contornar o 'RESTRICT'
    $sql_cidades = "DELETE FROM cidades WHERE id_pais = ?";
    $stmt_cidades = $conn->prepare($sql_cidades);
    $stmt_cidades->bind_param("i", $id_pais);
    $stmt_cidades->execute();
    $stmt_cidades->close();

    // SEGUNDO: Excluir o PAÍS pai
    $sql_pais = "DELETE FROM paises WHERE id_pais = ?";
    $stmt_pais = $conn->prepare($sql_pais);
    $stmt_pais->bind_param("i", $id_pais);
    $stmt_pais->execute();
    
    // Verificar se o país foi realmente excluído
    if ($stmt_pais->affected_rows > 0) {
        // Se tudo deu certo, aplicar as mudanças
        $conn->commit();
        header("Location: ../listar_paises.php?sucesso=País e suas cidades foram excluídos com sucesso!");
    } else {
        // Se o país não existia (talvez já excluído por outro)
        throw new Exception("País não encontrado.");
    }

    $stmt_pais->close();

} catch (Exception $e) {
    // Se qualquer etapa falhar, reverter tudo
    $conn->rollback();
    header("Location: ../listar_paises.php?erro=Erro ao excluir país: " . $e->getMessage());
}

$conn->close();
?>