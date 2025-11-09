<?php
// Retorna um JSON com a lista de países

include 'conexao.php'; 

// Informa ao cliente que a resposta é JSON
header('Content-Type: application/json');

// Busca os países
$sql = "SELECT id_pais, nome FROM paises ORDER BY nome ASC";
$result = $conn->query($sql);

$paises = []; 

// Monta o array de países
if ($result && $result->num_rows > 0) {
    $paises = $result->fetch_all(MYSQLI_ASSOC);
}

// Imprime o JSON (mesmo que seja um array vazio '[]')
echo json_encode($paises);

$conn->close();
?>