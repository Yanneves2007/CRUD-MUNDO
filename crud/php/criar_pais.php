<?php
// Recebe os dados do 'cadastrar_pais.html' e insere no banco.

include 'conexao.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $continente = $_POST['continente'];
    $idioma = $_POST['idioma'];

    // Trata o campo 'populacao' (opcional)
    // Se 'populacao' estiver vazio, define como NULL para o banco
    $populacao = !empty($_POST['populacao']) ? $_POST['populacao'] : NULL;

    // Prepara o SQL (Usando Prepared Statements)
    $sql = "INSERT INTO paises (nome, continente, populacao, idioma) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros (bind)
    // 'ssis' = string, string, integer, string
    $stmt->bind_param("ssis", $nome, $continente, $populacao, $idioma);

    // Executa e redireciona
    if ($stmt->execute()) {
        // Sucesso: Redireciona para a lista de países
        header("Location: ../listar_paises.php?sucesso=País cadastrado com sucesso!");
        exit();
    } else {
        // Erro: Devolve para o formulário de cadastro
        header("Location: ../cadastrar_pais.html?erro=Erro ao cadastrar país");
        exit();
    }

    // Fecha a statement e a conexão
    $stmt->close();
    $conn->close();
}
?>