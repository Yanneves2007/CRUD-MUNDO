<?php
// Recebe os dados do 'editar_pais.php' e faz o UPDATE no banco.

include 'conexao.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta os dados do formulário (incluindo o ID)
    $id = $_POST['id_pais'];
    $nome = $_POST['nome'];
    $continente = $_POST['continente'];
    $idioma = $_POST['idioma'];
    
    // Trata campo opcional (população)
    $populacao = !empty($_POST['populacao']) ? $_POST['populacao'] : NULL;

    // Prepara o SQL para o UPDATE
    $sql = "UPDATE paises SET nome = ?, continente = ?, populacao = ?, idioma = ? WHERE id_pais = ?";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros (bind)
    // 'ssisi' = string, string, integer, string, integer (id_pais)
    $stmt->bind_param("ssisi", $nome, $continente, $populacao, $idioma, $id);

    // Executa e redireciona
    if ($stmt->execute()) {
        // Sucesso: Redireciona para a lista
        header("Location: ../listar_paises.php?sucesso=País atualizado com sucesso!");
    } else {
        // Erro: Devolve para a página de edição (mantendo o ID)
        header("Location: ../editar_pais.php?id=$id&erro=Erro ao atualizar país");
    }

    $stmt->close();
    $conn->close();
}
?>