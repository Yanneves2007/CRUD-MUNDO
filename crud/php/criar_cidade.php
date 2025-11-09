<?php
// Função: Recebe os dados do 'cadastrar_cidade.html' e insere no banco.

// Inclui o arquivo de conexão com o banco
include 'conexao.php'; 

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $id_pais = $_POST['id_pais'];
    
    // Trata o campo 'populacao' (que é opcional)
    // Se 'populacao' estiver vazio, define como NULL para o banco
    $populacao = !empty($_POST['populacao']) ? $_POST['populacao'] : NULL;

    // Prepara o SQL (Usando Prepared Statements para evitar SQL Injection)
    $sql = "INSERT INTO cidades (nome, populacao, id_pais) VALUES (?, ?, ?)";
    
    // Prepara a query
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros (bind)
    // 'sii' = string (nome), integer (populacao), integer (id_pais)
    $stmt->bind_param("sii", $nome, $populacao, $id_pais);

    // Executa a query e redireciona
    if ($stmt->execute()) {
        // Se der certo, redireciona para a lista (passando msg de sucesso)
        header("Location: ../listar_cidades.php?sucesso=Cidade cadastrada com sucesso!");
        exit();
    } else {
        // Se der erro, devolve para o formulário (passando msg de erro)
        header("Location: ../cadastrar_cidade.html?erro=Erro ao cadastrar cidade");
        exit();
    }

    // Fecha a statement e a conexão
    $stmt->close();
    $conn->close();
}
?>