<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cidade - CRUD Mundo</title>
    
    <style>
        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        /* --- Layout Principal --- */
        .container {
            max-width: 500px;
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
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #2a5a7a; /* Cor diferente para 'Atualizar' */
            border: none;
            border-radius: 4px;
            color: #f0f0f0;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #3a6a8a;
        }

        /* --- Estilos do Formulário --- */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
        }

        input, select {
            width: 100%;
            padding: 12px;
            background-color: #2a2a2a;
            border: 1px solid #333;
            border-radius: 4px;
            color: #f0f0f0;
            font-size: 1rem;
            box-sizing: border-box;
        }

        /* --- Estilos de Estado (Erro) --- */
        .error-message {
            background: linear-gradient(135deg, #7a2a2a 0%, #8a3a3a 100%);
            color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #9a4a4a;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="listar_cidades.php" class="back-button">← Voltar para Lista</a>
        <h1>Editar Cidade</h1>

        <?php
        // Bloco PHP para buscar os dados da cidade
        
        include 'php/conexao.php';

        // Verifica se o ID da cidade foi passado pela URL (GET)
        if (!isset($_GET['id'])) {
            echo '<div class="error-message">ID da cidade não especificado.</div>';
            exit();
        }

        $id = $_GET['id'];

        // Busca os dados atuais da cidade para preencher o formulário
        $sql = "SELECT * FROM cidades WHERE id_cidade = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se a cidade foi encontrada
        if ($result->num_rows === 0) {
            echo '<div class="error-message">Cidade não encontrada.</div>';
            exit();
        }

        // Armazena os dados da cidade
        $cidade = $result->fetch_assoc();

        // Busca a lista completa de países para preencher o <select>
        $paises_sql = "SELECT id_pais, nome FROM paises ORDER BY nome";
        $paises_result = $conn->query($paises_sql);
        ?>

        <form action="php/atualizar_cidade.php" method="POST">
            
            <input type="hidden" name="id_cidade" value="<?php echo $cidade['id_cidade']; ?>">

            <div class="form-group">
                <label for="nome">Nome da Cidade *</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cidade['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="id_pais">País *</label>
                <select id="id_pais" name="id_pais" required>
                    <option value="">Selecione...</option>
                    
                    <?php while ($pais = $paises_result->fetch_assoc()) { ?>
                        <option value="<?php echo $pais['id_pais']; ?>" 
                            
                            <?php echo $cidade['id_pais'] == $pais['id_pais'] ? 'selected' : ''; ?>>
                            
                            <?php echo htmlspecialchars($pais['nome']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="populacao">População</label>
                <input type="number" id="populacao" name="populacao" 
                       value="<?php echo $cidade['populacao']; ?>" min="0">
            </div>

            <button type="submit">Atualizar Cidade</button>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const nome = document.getElementById('nome').value.trim();
            const pais = document.getElementById('id_pais').value;
            
            // Impede o envio se campos obrigatórios estiverem vazios
            if (!nome || !pais) {
                e.preventDefault();
                alert('Preencha todos os campos obrigatórios (*)');
            }
        });
    </script>
</body>
</html>