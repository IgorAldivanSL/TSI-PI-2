<?php
session_start();

require_once('conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Captura dos campos do formulário
    $titulo     = trim($_POST['titulo'] ?? '');
    $valor      = trim($_POST['valor']  ?? '');
    $data_ida   = $_POST['data_ida']    ?? null;
    $data_volta = $_POST['data_volta']  ?? null;
    $descricao  = trim($_POST['descricao'] ?? '');

    // 2) Validação básica
    if ($titulo === '' || $valor === '' || !$data_ida || !$data_volta) {
        echo "<p style='color:red;'>Por favor, preencha todos os campos obrigatórios.</p>";
        exit;
    }

    // 3) Upload de imagem para ../assets/
    if (empty($_FILES['imagem']['name']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
        echo "<p style='color:red;'>Imagem é obrigatória.</p>";
        exit;
    }
    $tiposPermitidos = ['image/jpeg','image/png','image/gif'];
    if (!in_array($_FILES['imagem']['type'], $tiposPermitidos)) {
        echo "<p style='color:red;'>Tipo de arquivo não permitido. Use JPG, PNG ou GIF.</p>";
        exit;
    }
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagemNome = uniqid('viagem_') . '.' . $ext;
    // ajusta o caminho relativo para chegar em /projeto/assets/
    $destino    = __DIR__ . '/assets/' . $imagemNome;


    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        echo "<p style='color:red;'>Erro a77777777777777o enviar a imagem.</p>";
        exit;
    }

    // 4) Inserção no banco
    try {
        $sql = "INSERT INTO viagens (titulo, valor, data_ida, data_volta, descricao, imagem) VALUES (:titulo, :valor, :data_ida, :data_volta, :descricao, :imagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindValue(':valor', floatval($valor), PDO::PARAM_STR);
        $stmt->bindValue(':data_ida', $data_ida, PDO::PARAM_STR);
        $stmt->bindValue(':data_volta', $data_volta, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':imagem', $imagemNome, PDO::PARAM_STR);

        $stmt->execute();
        $id = $pdo->lastInsertId();

        echo "<p style='color:green;'>Viagem cadastrada com sucesso! ID: {$id}</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar viagem: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Viagem</title>
</head>
<body>
    
    <div class="produto-container">
        <img class="logo"  src="assets/logo.png" alt="Logo">
        <h2>Cadastro de Viagens</h2>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="input-group">
                <input type="file" name="imagem" accept="image/*" required><br><br>
            </div>
            
            <div class="input-group">
                <input type="text" name="titulo" placeholder="Titulo" required><br><br>                
            </div>

            <div class="input-group">
                <input type="number" name="valor" placeholder="Valor" step="0.01" required><br><br>
            </div>
        
            <div class="input-group-cadastro1">
                <input type="date" name="data-ida"  required>
                <input type="date" name="data-volta"  required>
            </div>

            <div class="descriçao">
                <textarea name="descricao" rows="5"></textarea><br><br>
            </div>

            <button type="submit" onclick="carregarPagina('index.php?id=<?php echo $viagem['id']; ?>'); return false;">Publicar</button>
        
        </form>
    </div>

    <style>
        *{
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body{
            background-color: #F5F5F5 ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .produto-container{
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 26%;
            text-align: center;
            
        }

        .produto-container img.logo {
            width: 60px;
            margin-bottom: 12px;
        }

        .produto-container h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #222;
        }


        .input-group {
            position: relative;
            margin-bottom: 10px;
        }

        .input-group input{
            height: 50px;
            width: 100%;
            padding: 12px 45px 12px 45px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #EAEAEA;
            font-size: 16px;
        }

        .input-group-cadastro1 {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap; /* Para quebrar em telas pequenas */
        }

        .input-group-cadastro1 input {
            height: 50px;
            flex: 1 1 48%; /* Cresce até 48% e quebra para baixo */
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #EAEAEA;
            font-size: 16px;
            min-width: 120px;
        }

        .descriçao{
            position: relative;
            margin-bottom: 10px;
        }

        .descriçao textarea{
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #EAEAEA;
            font-size: 16px;
           
        }

        button[type="submit"]{
            width: 100%;
            background-color: #FF8548;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom:6px;
        }

        button[type="submit"]:hover{
            background-color: #ff503e;
        }

        /* Responsividade */
        @media (max-width: 480px) {
            .produto-container {
                padding: 20px;
            }

            .input-group-cadastro1 input {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 1024px) {
            .produto-container {
                width: 35%;
            }
        }

        @media (max-width: 768px) {
            .produto-container {
                width: 50%;
            }
        }

        @media (max-width: 480px) {
            .produto-container {
                width: 90%;
            }
        }

    </style>
</body>
</html>