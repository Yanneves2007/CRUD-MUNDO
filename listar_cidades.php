<?php
// Inclui a conexão
include 'php/conexao.php';

// Query principal: Lista cidades com o nome do país (JOIN)
// Seleciona todas as colunas de 'cidades' (c.*) e o 'nome' de 'paises' (dando o apelido 'pais_nome')
$sql = "SELECT c.*, p.nome as pais_nome 
        FROM cidades c 
        JOIN paises p ON c.id_pais = p.id_pais 
        ORDER BY p.nome, c.nome"; // Ordena por país, depois por cidade
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Cidades - CRUD Mundo</title>
    
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
            max-width: 1000px;
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
            overflow: hidden; /* Para o radius funcionar na tabela */
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
        
        /* --- Seção de Clima (API) --- */
        .weather {
            font-size: 0.9rem;
            color: #4a9a4a;
        }

        .loading {
            color: #888;
            font-style: italic;
        }

        .no-weather {
            color: #888;
            font-style: italic;
        }

        /* --- Mensagens de Feedback (Sucesso/Erro) --- */
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
        <h1>Lista de Cidades</h1>

        <?php
        // Bloco PHP para exibir mensagens de feedback (passadas via GET na URL)
        if (isset($_GET['sucesso'])) {
            echo '<div class="success-message" id="successMessage">' . htmlspecialchars($_GET['sucesso']) . '</div>';
        }
        if (isset($_GET['erro'])) {
            echo '<div class="error-message" id="errorMessage">' . htmlspecialchars($_GET['erro']) . '</div>';
        }
        ?>

        <?php 
        // Verifica se a consulta (do topo da página) retornou resultados
        if ($result->num_rows > 0) { 
        ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cidade</th>
                        <th>País</th>
                        <th>População</th>
                        <th>Clima</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Loop PHP para exibir cada linha da tabela
                    while($row = $result->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?php echo $row['id_cidade']; ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['pais_nome']); ?></td>
                        <td><?php echo $row['populacao'] ? number_format($row['populacao']) : 'N/A'; ?></td>
                        
                        <td class="weather" id="weather-<?php echo $row['id_cidade']; ?>">
                            <span class="loading">🌤️ Buscando clima...</span>
                        </td>
                        
                        <td class="actions">
                            <a href="editar_cidade.php?id=<?php echo $row['id_cidade']; ?>" class="btn btn-edit">Editar</a>
                            
                            <a href="php/excluir_cidade.php?id=<?php echo $row['id_cidade']; ?>" class="btn btn-delete" 
                               onclick="return confirm('Tem certeza que deseja excluir esta cidade?')">Excluir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
        } else {
            // Mensagem caso não haja cidades cadastradas
            echo '<div style="text-align: center; padding: 40px; color: #888;">Nenhuma cidade cadastrada.</div>';
        }

        // Fecha a conexão com o banco
        $conn->close();
        ?>
    </div>

<script>
    // Chave da API OpenWeatherMap (Bônus)
    const apiKey = '70d01e04fafa2592962185d185c05d34';

    // Função async para buscar o clima real na API
    async function getWeather(cityName) {
        const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(cityName)}&units=metric&lang=pt_br&appid=${apiKey}`;
        try {
            const response = await fetch(weatherUrl);
            if (!response.ok) {
                throw new Error('Cidade não encontrada pela API');
            }
            const data = await response.json();
            
            // Formata o retorno do clima
            if (data.main && data.weather) {
                const temp = data.main.temp;
                const desc = data.weather[0].description;
                const icon = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`;
                return `${temp.toFixed(1)}°C <img src="${icon}" alt="${desc}" style="width:20px;vertical-align:middle;"> ${desc}`;
            }
        } catch (error) {
            console.error('Erro ao buscar clima:', error);
        }
        return null; // Retorna nulo se falhar
    }

    // Função de fallback (Mock) caso a API falhe
    function getMockWeather(cityName) {
        const mock = {
            'São Paulo': '25°C ☀️ Ensolarado',
            'Rio de Janeiro': '28°C ⛅ Parcialmente nublado',
            'Brasília': '24°C 🌧️ Chuvoso'
        };
        return mock[cityName] || '22°C ☀️ Ensolarado (Mock)'; 
    }

    // Função principal para carregar o clima de todas as linhas
    async function carregarClimas() {
        // Pega todas as células de clima
        const weatherCells = document.querySelectorAll('[id^="weather-"]');
        
        for (const cell of weatherCells) {
            // Pega o nome da cidade e do país da mesma linha (tr)
            const row = cell.closest('tr');
            const cityName = row.querySelector('td:nth-child(2)').textContent.trim();
            const countryName = row.querySelector('td:nth-child(3)').textContent.trim();
            const searchQuery = `${cityName},${countryName}`; // Ex: "São Paulo,Brasil"
            
            cell.innerHTML = '<span class="loading">🌤️ Buscando clima...</span>';
            
            try {
                // Tenta buscar o clima real
                const weather = await getWeather(searchQuery);
                
                if (weather) {
                    cell.innerHTML = weather;
                } else {
                    // Se falhar (API não achou), usa o mock
                    cell.innerHTML = `<span class="no-weather">(Mock: ${getMockWeather(cityName)})</span>`;
                }
            } catch (error) {
                // Se der erro geral, usa o mock
                console.error('Erro geral:', error);
                cell.innerHTML = `<span class="no-weather">(Mock: ${getMockWeather(cityName)})</span>`;
            }
        }
    }

    // --- Inicialização do Script (quando a página carrega) ---
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Chama a função para carregar os climas
        carregarClimas();

        // Controla as mensagens de feedback (sucesso/erro)
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        
        // Função para fazer a mensagem desaparecer após 3 segundos
        function hideMessage(element) {
            if (element) setTimeout(() => element.remove(), 3000);
        }
        
        hideMessage(successMessage);
        hideMessage(errorMessage);
    });
</script>

</body>
</html>