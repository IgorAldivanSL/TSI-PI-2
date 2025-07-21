<?php
// Caminho relativo com base na localização do próprio arquivo
$dbPath = __DIR__ . '/RtripsDB.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    // echo "Conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao tentar conectar ao banco de dados SQLite!<br><br>";
    echo $e->getMessage();
    exit;
}
?>