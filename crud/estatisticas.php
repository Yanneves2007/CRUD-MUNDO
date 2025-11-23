<?php
include 'php/conexao.php';

// País mais populoso
$top = $conn->query("SELECT nome, populacao FROM paises WHERE populacao IS NOT NULL ORDER BY populacao DESC LIMIT 1")->fetch_assoc();

// País menos populoso
$low = $conn->query("SELECT nome, populacao FROM paises WHERE populacao IS NOT NULL ORDER BY populacao ASC LIMIT 1")->fetch_assoc();

// Total de população
$total = $conn->query("SELECT SUM(populacao) AS total FROM paises")->fetch_assoc();

// Quantidade de países
$qt_paises = $conn->query("SELECT COUNT(*) AS qt FROM paises")->fetch_assoc();

// Quantidade de cidades
$qt_cidades = $conn->query("SELECT COUNT(*) AS qt FROM cidades")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estatísticas</title>

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
            font-size: 2rem;
            font-weight: normal;
            margin-bottom: 30px;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 25px;
            color: #888;
            text-decoration: none;
            padding: 5px 0;
        }

        .back-button:hover {
            color: #f0f0f0;
        }

        .card {
            background-color: #2a2a2a;
            border: 1px solid #333;
            padding: 18px 20px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .card h2 {
            font-weight: normal;
            font-size: 1.2rem;
            margin-bottom: 6px;
        }

        .card p {
            color: #ccc;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="index.php" class="back-button">← Voltar para Início</a>

    <h1>Estatísticas</h1>

    <div class="card">
        <h2>País mais populoso</h2>
        <p><?= $top['nome'] ?> — <?= number_format($top['populacao'], 0, ',', '.') ?> habitantes</p>
    </div>

    <div class="card">
        <h2>País menos populoso</h2>
        <p><?= $low['nome'] ?> — <?= number_format($low['populacao'], 0, ',', '.') ?> habitantes</p>
    </div>

    <div class="card">
        <h2>População total cadastrada</h2>
        <p><?= number_format($total['total'], 0, ',', '.') ?> habitantes</p>
    </div>

    <div class="card">
        <h2>Total de países</h2>
        <p><?= $qt_paises['qt'] ?> países cadastrados</p>
    </div>

    <div class="card">
        <h2>Total de cidades</h2>
        <p><?= $qt_cidades['qt'] ?> cidades cadastradas</p>
    </div>
</div>

</body>
</html>
