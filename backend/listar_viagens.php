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

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Viagens</title>
<link rel="stylesheet" href="seu-arquivo.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>

    *{
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    .destinos {
        margin-top: 20px;
        justify-content: center;
        width: 100%;
        display: grid;
        text-align: center;
        padding: 0;
    }
    .destinos .destinos-container {
        border-radius: 35px;
        background-color: #FF8548;
        display: flex;
        flex-wrap: wrap;
        padding: 40px;
        gap: 20px;
    }
    .destinos h2 {
        font-size: 2.0rem;
        margin-bottom: 20px;
    }

    .destino-card {
        background-color: #fff;
        border-radius: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 375px;
        padding: 15px;
        text-align: left;
        transition: transform 0.3s ease;
    }
    .destino-card:hover {
        transform: translateY(-5px);
    }
    .destino-card .img-card {
        position: relative;
        width: 100%; /* Added for consistent image sizing */
    }
    .destino-card .img-card img {
        width: 100%;
        border-radius: 20px;
        margin-bottom: 15px;
    }
    .destino-card .img-card .preco {
        position: absolute;
        bottom: 35px;
        left: 10px; /* Adjusted positioning for better alignment */
        font-size: 1rem;
        font-weight: bold;
        color: #000;
        background-color: rgba(255, 255, 255, 0.8705882353);
        padding: 2px 20px;
        border-radius: 35px;
    }
    
    .destino-card p {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
    }
    .destino-card .data {
        font-size: 0.9rem;
        color: #444;
        margin-bottom: 20px;
        border-radius: 20px;
    }
    .destino-card .data span {
        display: inline-block;
        margin-right: 5px;
    }
    .destino-card .data .data-valor {
        background-color: #FF8548;
        font-weight: 600;
        border-radius: 10px;
        padding: 3px 5px;
        color: #61321a;
    }
    .destino-card .btn-reservar {
        background-color: #114A49;
        color: #fff;
        border: none;
        padding: 2px 3px;
        border-radius: 120px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        font-size: 1rem;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .destino-card .btn-reservar:hover {
        background-color: #155e5c;
    }
    .destino-card .btn-reservar i {
        color: #ffffff;
        padding: 3px 5px;
        border-radius: 50%;
        font-size: 2rem;
        margin-left: -20px;
    }
    .destino-card .btn-reservar span {
        flex-grow: 1;
        text-align: center;
    }

    .

    .botao-editar{
        background-color: #FF8548;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    .botao-editar:hover {
        background-color: #ff503e;
    }

    .botao-editar{
        background-color:rgb(47, 191, 7);
        margin-top: 20px;
        margin-bottom: 20px;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
        display: flex;
        
        
    }

    .botao-excluir {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
        display: flex;
    }

    .botao-excluir:hover {
        background-color: #c0392b;
    }

    /* Responsivo */
    @media (max-width: 768px) {
    .destinos .destinos-container {
        flex-direction: column;
        padding: 20px;
    }

    .destino-card {
        width: 100%;
    }
    }
   

</style>
</head>
<body>

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
                            <?php echo date('M d, Y', strtotime($viagem['data_ida'])); ?>
                        </span>
                        <span>Volta</span> 
                        <span class="data-valor">
                            <?php echo date('M d, Y', strtotime($viagem['data_volta'])); ?>
                        </span>
                    </div>

                    <a href="">
                        <button class="btn-reservar">
                            <span>Reservar passagem</span>
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        
                        <a href="#" class="botao-editar" onclick="carregarPagina('editar_viagens.php?id=<?php echo $id['viagem_id']; ?>'); return false;">Editar</a>

                        <a href="excluir_viagen.php?id=<?php echo $id['id']; ?>" class="botao-excluir" onclick="return confirmDeletion();">Excluir</a>
                    
                    </a>
                    
                </div>
            <?php endforeach; ?>
            
        </div>
    </div>

</body>
</html>
