<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar País - CRUD Mundo</title>
    
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
            background-color: #2a5a7a; /* Cor de 'Atualizar' */
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
        <a href="listar_paises.php" class="back-button">← Voltar para Lista</a>
        <h1>Editar País</h1>

        <?php
        // Bloco PHP para buscar os dados do país
        
        include 'php/conexao.php';

        // Verifica se o ID do país foi passado pela URL (GET)
        if (!isset($_GET['id'])) {
            echo '<div class="error-message">ID do país não especificado.</div>';
            exit();
        }

        $id = $_GET['id'];

        // Busca os dados atuais do país para preencher o formulário
        $sql = "SELECT * FROM paises WHERE id_pais = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se o país foi encontrado
        if ($result->num_rows === 0) {
            echo '<div class="error-message">País não encontrado.</div>';
            exit();
        }

        // Armazena os dados do país
        $pais = $result->fetch_assoc();
        ?>

        <form action="php/atualizar_pais.php" method="POST">
            
            <input type="hidden" name="id_pais" value="<?php echo $pais['id_pais']; ?>">
            
            <div class="form-group">
                <label for="nome">Nome do País *</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($pais['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="continente">Continente *</label>
                <select id="continente" name="continente" required>
                    <option value="">Selecione...</option>
                    
                    <option value="África" <?php echo $pais['continente'] == 'África' ? 'selected' : ''; ?>>África</option>
                    <option value="América do Norte" <?php echo $pais['continente'] == 'América do Norte' ? 'selected' : ''; ?>>América do Norte</option>
                    <option value="América Central" <?php echo $pais['continente'] == 'América Central' ? 'selected' : ''; ?>>América Central</option>
                    <option value="América do Sul" <?php echo $pais['continente'] == 'América do Sul' ? 'selected' : ''; ?>>América do Sul</option>
                    <option value="Ásia" <?php echo $pais['continente'] == 'Ásia' ? 'selected' : ''; ?>>Ásia</option>
                    <option value="Europa" <?php echo $pais['continente'] == 'Europa' ? 'selected' : ''; ?>>Europa</option>
                    <option value="Oceania" <?php echo $pais['continente'] == 'Oceania' ? 'selected' : ''; ?>>Oceania</option>
                </select>
            </div>

            <div class="form-group">
                <label for="populacao">População</label>
                <input type="number" id="populacao" name="populacao" value="<?php echo $pais['populacao']; ?>" min="0">
            </div>

            <div class="form-group">
                <label for="idioma">Idioma Principal *</label>
                <input type="text" id="idioma" name="idioma" value="<?php echo htmlspecialchars($pais['idioma']); ?>" required>
            </div>

            <button type="submit">Atualizar País</button>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const nome = document.getElementById('nome').value.trim();
            const continente = document.getElementById('continente').value;
            const idioma = document.getElementById('idioma').value.trim();

            // Impede o envio se campos obrigatórios estiverem vazios
            if (!nome || !continente || !idioma) {
                e.preventDefault();
                alert('Preencha todos os campos obrigatórios (*)');
            }
        });
    </script>
</body>
</html>