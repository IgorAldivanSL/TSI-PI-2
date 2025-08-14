<?php

session_start();
require_once('conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

// Inicializa variáveis para preencher o formulário em caso de erro, se quiser
$titulo_val     = '';
$valor_val      = '';
$data_ida_val   = '';
$data_volta_val = '';
$descricao_val  = '';
$mensagem_status = ''; // Para exibir mensagens de erro/sucesso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Captura dos campos do formulário
    // CORREÇÃO AQUI: Usar 'data-ida' e 'data-volta' para corresponder ao HTML
    $titulo     = trim($_POST['titulo'] ?? '');
    $valor      = trim(str_replace(',', '.', $_POST['valor'] ?? '')); // Garante ponto como separador decimal
    $data_ida   = $_POST['data-ida']    ?? null; // CORRIGIDO
    $data_volta = $_POST['data-volta']  ?? null; // CORRIGIDO
    $descricao  = trim($_POST['descricao'] ?? '');

    // Mantém os valores preenchidos no formulário em caso de erro
    $titulo_val     = $titulo;
    $valor_val      = $valor;
    $data_ida_val   = $data_ida;
    $data_volta_val = $data_volta;
    $descricao_val  = $descricao;

    // 2) Validação básica
    if ($titulo === '' || $valor === '' || !$data_ida || !$data_volta) {
        $mensagem_status = "<p style='color:red;'>Por favor, preencha todos os campos obrigatórios.</p>";
    } elseif (empty($_FILES['imagem']['name']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
        $mensagem_status = "<p style='color:red;'>Imagem é obrigatória.</p>";
    } else {
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagem']['type'], $tiposPermitidos)) {
            $mensagem_status = "<p style='color:red;'>Tipo de arquivo não permitido. Use JPG, PNG ou GIF.</p>";
        } else {
            // Tudo validado, prosseguir com upload e inserção
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagemNome = uniqid('viagem_') . '.' . $ext;
            // Ajusta o caminho de destino no servidor
            $destino = __DIR__ . '/assets/' . $imagemNome;

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $mensagem_status = "<p style='color:red;'>Erro ao enviar a imagem. Verifique permissões da pasta 'assets/'.</p>";
            } else {
                // 4) Inserção no banco
                try {
                    $sql = "INSERT INTO viagens (titulo, valor, data_ida, data_volta, descricao, imagem) VALUES (:titulo, :valor, :data_ida, :data_volta, :descricao, :imagem)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
                    // Usar floatval() e deixar o PDO::PARAM_STR é geralmente seguro, mas garanta que a coluna no DB seja apropriada (REAL, NUMERIC)
                    $stmt->bindValue(':valor', floatval($valor), PDO::PARAM_STR);
                    $stmt->bindValue(':data_ida', $data_ida, PDO::PARAM_STR);
                    $stmt->bindValue(':data_volta', $data_volta, PDO::PARAM_STR);
                    $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
                    // Salvamos apenas o nome do arquivo para o banco de dados
                    $stmt->bindValue(':imagem', $imagemNome, PDO::PARAM_STR);

                    $stmt->execute();
                    $id = $pdo->lastInsertId();

                    $mensagem_status = "<p style='color:green;'>Viagem cadastrada com sucesso! ID: {$id}</p>";
                    // Limpar campos do formulário após sucesso
                    $titulo_val     = '';
                    $valor_val      = '';
                    $data_ida_val   = '';
                    $data_volta_val = '';
                    $descricao_val  = '';

                } catch (PDOException $e) {
                    $mensagem_status = "<p style='color:red;'>Erro ao cadastrar viagem: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            }
        }
    }
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/cadastrar_viagens.css">
<title>Cadastrar Viagem</title>

<div class="produto-container">
    <img class="logo"  src="assets/logo.png" alt="Logo">
    <h2>Cadastro de Viagens</h2>

    <?php echo $mensagem_status; // Exibe mensagens de status, se houver ?>
    <br>
        
    <form action="cadastrar_viagens.php" method="post" enctype="multipart/form-data">
            
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

        <button type="submit">Publicar</button>
        
    </form>
</div>
    
    
