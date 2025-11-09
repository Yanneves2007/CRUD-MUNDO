<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Países - CRUD Mundo</title>
    
    <style>
        /* --- Configs Gerais / Tema Escuro --- */
        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        /* --- Layout Principal --- */
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: normal;
            font-size: 1.8rem;
        }
        
        /* --- Componentes (Links, Botões) --- */
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #888;
            text-decoration: none;
            padding: 5px 0;
        }

        .back-button:hover {
            color: #f0f0f0;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            color: #f0f0f0;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #2a5a7a;
        }

        .btn-edit:hover {
            background-color: #3a6a8a;
        }

        .btn-delete {
            background-color: #7a2a2a;
        }

        .btn-delete:hover {
            background-color: #8a3a3a;
        }
        
        /* --- Tabela de Listagem --- */
        .table-container {
            background-color: #2a2a2a;
            border: 1px solid #333;
            border-radius: 4px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #333;
            color: #f0f0f0;
            font-weight: normal;
        }

        tr:hover {
            background-color: #333;
        }

        .actions {
            display: flex;
            gap: 10px;
        }
        
        /* --- Mensagens de Feedback (Sucesso/Erro) --- */
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .success-message {
            background: linear-gradient(135deg, #2a5a7a 0%, #3a6a8a 100%);
            color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #4a7a9a;
            font-size: 1rem;
        }

        .error-message {
            background: linear-gradient(135deg, #7a2a2a 0%, #8a3a3a 100%);
            color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #9a4a4a;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-button">← Voltar para Início</a>
        <h1>Lista de Países</h1>

        <?php
        // Bloco PHP para buscar dados e exibir mensagens
        
        include 'php/conexao.php';

        // Exibe mensagem de sucesso (se houver)
        if (isset($_GET['sucesso'])) {
            echo '<div class="success-message" id="successMessage">' . htmlspecialchars($_GET['sucesso']) . '</div>';
        }

        // Exibe mensagem de erro (se houver)
        if (isset($_GET['erro'])) {
            echo '<div class="error-message" id="errorMessage">' . htmlspecialchars($_GET['erro']) . '</div>';
        }

        // Query principal: Lista todos os países
        $sql = "SELECT * FROM paises ORDER BY nome";
        $result = $conn->query($sql);

        // Verifica se a consulta retornou resultados
        if ($result->num_rows > 0) {
        ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Continente</th>
                        <th>População</th>
                        <th>Idioma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Loop PHP para exibir cada linha da tabela
                    while($row = $result->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?php echo $row['id_pais']; ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['continente']); ?></td>
                        
                        <td><?php echo $row['populacao'] ? number_format($row['populacao']) : 'N/A'; ?></td>
                        
                        <td><?php echo htmlspecialchars($row['idioma']); ?></td>
                        
                        <td class="actions">
                            <a href="editar_pais.php?id=<?php echo $row['id_pais']; ?>" class="btn btn-edit">Editar</a>
                            
                            <a href="php/excluir_pais.php?id=<?php echo $row['id_pais']; ?>" class="btn btn-delete" 
                               onclick="return confirm('Tem certeza que deseja excluir este país?')">Excluir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
        } else {
            // Mensagem caso não haja países cadastrados
            echo '<div class="empty-message">Nenhum país cadastrado.</div>';
        }

        // Fecha a conexão com o banco
        $conn->close();
        ?>
    </div>

    <script>
        // Roda o script quando a página carrega
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            
            // Função para fazer a mensagem desaparecer após 3 segundos
            function hideMessage(element) {
                if (element) {
                    setTimeout(() => {
                        element.remove();
                    }, 3000); 
                }
            }
            
            // Chama a função para ambas as mensagens
            hideMessage(successMessage);
            hideMessage(errorMessage);
        });
    </script>
</body>
</html>