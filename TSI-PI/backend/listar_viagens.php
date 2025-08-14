<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$viagens = [];

try {
    $stmt = $pdo->prepare("SELECT * FROM viagens ORDER BY id DESC");
    $stmt->execute();
    $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar viagens: " . $e->getMessage() . "</p>";
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Viagens</title>
<link rel="stylesheet" href="src/css/listar_viagens.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="destinos">
    <h2>Viagens Cadastradas</h2>
    <div class="destinos-container">
        <?php foreach ($viagens as $viagem): ?>
            <div class="destino-card">
                <div class="img-card">
                    <img src="assets/<?php echo htmlspecialchars($viagem['imagem']); ?>" 
                        alt="<?php echo htmlspecialchars($viagem['titulo']); ?>">
                    <div class="preco">
                        R$ <?php echo number_format($viagem['valor'], 2, ',', '.'); ?>
                    </div>
                </div>

                <h3><?php echo htmlspecialchars($viagem['titulo']); ?></h3>

                <p><?php echo htmlspecialchars($viagem['descricao']); ?></p>

                <div class="data">
                    <span>Ida</span> 
                    <span class="data-valor">
                        <?php echo date('d/m/Y', strtotime($viagem['data_ida'])); ?>
                    </span>
                    <span>Volta</span> 
                    <span class="data-valor">
                        <?php echo date('d/m/Y', strtotime($viagem['data_volta'])); ?>
                    </span>
                </div>

                <button class="btn-reservar">
                    <span>Reservar passagem</span>
                    <i class="fab fa-whatsapp"></i>
                </button>

                <a href="#" onclick="carregarPagina('editar_viagens.php?id=<?= $viagem['id'] ?>')" class="botao-editar">Editar</a>

                <a href="#" onclick="excluirViagem(<?php echo $viagem['id']; ?>)" class="botao-excluir">Excluir</a>
                   
            </div>
        <?php endforeach; ?>
    </div>
</div>


    
