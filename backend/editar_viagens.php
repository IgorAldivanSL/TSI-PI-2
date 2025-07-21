<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de viagem inválido.");
}

$id = (int)$_GET['id'];
$viagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_ida = $_POST['data-ida'];
    $data_volta = $_POST['data-volta'];
    $valor = str_replace(',', '.', $_POST['valor']);

    // se for enviado um novo arquivo de imagem
    if (!empty($_FILES['imagem']['name'])) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $caminho_destino = 'backend/assets/' . $imagem_nome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_destino)) {
            $sql = "UPDATE viagens 
                    SET destino = :destino, descricao = :descricao, data_ida = :data_ida, 
                        data_volta = :data_volta, valor = :valor, imagem = :imagem 
                    WHERE id = :id";
            $params = [
                ':destino' => $titulo,
                ':descricao' => $descricao,
                ':data_ida' => $data_ida,
                ':data_volta' => $data_volta,
                ':valor' => $valor,
                ':imagem' => $caminho_destino,
                ':id' => $id
            ];
        } else {
            die("Erro ao salvar nova imagem.");
        }
    } else {
        // sem alterar imagem
        $sql = "UPDATE viagens 
                SET destino = :destino, descricao = :descricao, data_ida = :data_ida, 
                    data_volta = :data_volta, valor = :valor
                WHERE id = :id";
        $params = [
            ':destino' => $titulo,
            ':descricao' => $descricao,
            ':data_ida' => $data_ida,
            ':data_volta' => $data_volta,
            ':valor' => $valor,
            ':id' => $id
        ];
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo "<p style='color:green;text-align:center;'>Viagem atualizada com sucesso! <a href='listar_viagens.php'>Voltar</a></p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar: " . $e->getMessage() . "</p>";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM viagens WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $viagem = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$viagem) {
        die("Viagem não encontrada.");
    }

} catch (PDOException $e) {
    die("Erro ao buscar viagem: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Viagem</title>
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
            position: relative;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
            gap: 2.6px;
        }

        .input-group-cadastro1 input {
            height: 50px;
            width: 50%;
            padding: 12px 45px 12px 45px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #EAEAEA;
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
</style>
</head>
<body>

<div class="produto-container">
    <img class="logo" src="assets/logo.png" alt="Logo">
    <h2>Editar Viagem</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="input-group">
            <input type="file" name="imagem" accept="image/*">
        </div>

        <div class="input-group">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo htmlspecialchars($viagem['destino']); ?>" required>
        </div>

        <div class="input-group">
            <input type="number" name="valor" placeholder="Valor" step="0.01" value="<?php echo htmlspecialchars($viagem['valor']); ?>" required>
        </div>

        <div class="input-group-cadastro1">
            <input type="date" name="data-ida" value="<?php echo htmlspecialchars($viagem['data_ida']); ?>" required>
            <input type="date" name="data-volta" value="<?php echo htmlspecialchars($viagem['data_volta']); ?>" required>
        </div>

        <div class="descriçao">
            <textarea name="descricao" rows="5"><?php echo htmlspecialchars($viagem['descricao']); ?></textarea>
        </div>

        <button type="submit" onclick="carregarPagina('listar_viagens.php?id=<?php echo $viagem['id']; ?>'); return false;">Salvar Alterações</button>
        

    </form>
</div>

</body>
</html>
