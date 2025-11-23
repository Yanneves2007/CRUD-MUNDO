<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mundo</title>
    
    <style>
        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            margin: 0;
            padding: 30px 20px;
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 8px;
            font-weight: normal;
        }

        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 40px;
            font-size: 0.9rem;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 40px;
        }

        .menu-card {
            background-color: #2a2a2a;
            border: 1px solid #333;
            border-radius: 6px;
            padding: 25px 20px;
            text-align: center;
            text-decoration: none;
            color: #f0f0f0;
        }

        .menu-card:hover {
            background-color: #333;
        }

        .menu-card h2 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-weight: normal;
        }

        .menu-card p {
            color: #888;
            font-size: 0.8rem;
            margin: 0;
        }
        .menu-grid a:last-child {
            grid-column: span 2;
            width: 60%;
            margin: 0 auto;
        }

        @media (max-width: 500px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            /* Em celular volta ao normal (auto centraliza sozinho) */
            .menu-grid a:last-child {
                grid-column: span 1;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>CRUD Mundo</h1>
        <p class="subtitle">Sistema de gerenciamento de países e cidades</p>

        <div class="menu-grid">
            
            <a href="cadastrar_pais.html" class="menu-card">
                <h2>Cadastrar País</h2>
                <p>Adicionar novo país</p>
            </a>

            <a href="listar_paises.php" class="menu-card">
                <h2>Listar Países</h2>
                <p>Visualizar e gerenciar</p>
            </a>

            <a href="cadastrar_cidade.html" class="menu-card">
                <h2>Cadastrar Cidade</h2>
                <p>Adicionar nova cidade</p>
            </a>

            <a href="listar_cidades.php" class="menu-card">
                <h2>Listar Cidades</h2>
                <p>Visualizar e gerenciar</p>
            </a>

            <!-- CARD CENTRALIZADO -->
            <a href="estatisticas.php" class="menu-card">
                <h2>Estatísticas</h2>
                <p>Dados gerais do sistema</p>
            </a>

        </div>

    </div>
</body>
</html>
