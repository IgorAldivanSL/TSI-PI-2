<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$id = $_GET['id'] ?? null; //verifica se o valor à sua esquerda é null ou não definido. Se for, o operador retorna o valor à sua direita. Se não for, retorna o valor à esquerda

if (!$id) {
    header('Location: listar_viagens.php');
    exit();
}

try {
        // Excluir administrador
    $stmt = $pdo->prepare("DELETE FROM viagens WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: listar_viagens.php');
    exit();
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir viagem: " . $e->getMessage() . "</p>";
}
?>