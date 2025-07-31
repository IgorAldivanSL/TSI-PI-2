<?php
session_start();
require_once 'conexao.php'; // Sua conexão com o banco de dados

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

$viagem_para_edicao = []; // Inicializa a variável para evitar erro caso não encontre ID

// --- Lógica para PROCESSAR A ATUALIZAÇÃO (quando o formulário é SUBMETIDO via POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura segura do ID (Desta vez, SÓ do POST)
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;

    if (!$id) {
        die("ID de viagem inválido para atualização."); // Mensagem mais específica
    }

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_ida = $_POST['data-ida'];
    $data_volta = $_POST['data-volta'];
    $valor = str_replace(',', '.', $_POST['valor']);

    $sql = "";
    $params = [];
    $imagem_para_db = null;

    if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $caminho_destino_servidor = __DIR__ . '/assets/' . $imagem_nome;

        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            die("Erro no upload da imagem. Código do erro: " . $_FILES['imagem']['error']);
        }

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_destino_servidor)) {
            die("Erro ao salvar imagem no servidor.");
        }
        $imagem_para_db = $imagem_nome; // Salva APENAS o nome do arquivo

        $sql = "UPDATE viagens SET titulo = :titulo, descricao = :descricao, data_ida = :data_ida, data_volta = :data_volta, valor = :valor, imagem = :imagem WHERE id = :id";
        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':data_ida' => $data_ida,
            ':data_volta' => $data_volta,
            ':valor' => $valor,
            ':imagem' => $imagem_para_db,
            ':id' => $id
        ];
    } else {
        $sql = "UPDATE viagens SET titulo = :titulo, descricao = :descricao, data_ida = :data_ida, data_volta = :data_volta, valor = :valor WHERE id = :id";
        $params = [
            ':titulo' => $titulo,
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
        // Mensagem de sucesso e redirecionamento ou link de voltar
        echo "<p style='color:green; text-align:center;'>Viagem atualizada com sucesso!<br><a href='#' onclick=\"carregarPagina('backend/listar_viagens.php')\">Voltar</a></p>";
        // Opcional: Para evitar que o formulário seja submetido novamente se o usuário atualizar a página
        // header("Location: editar_viagens.php?id=" . $id . "&success=1");
        // exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    // IMPORTANTE: Após o processamento POST, você deve carregar os dados atualizados no formulário
    // ou redirecionar para evitar submissão dupla.
    // Para simplificar, vamos recarregar os dados para o formulário.
    // O ID deve vir da requisição POST que acabou de ser processada.
    $id_para_exibir_apos_post = $id;

} else {
    // --- Lógica para CARREGAR OS DADOS (quando a página é acessada via GET ou após o POST) ---
    // Pega o ID da URL (GET) quando a página é carregada pela primeira vez
    $id_para_exibir_apos_post = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
}

// Agora, use $id_para_exibir_apos_post para buscar os dados da viagem para exibir no formulário
if ($id_para_exibir_apos_post) {
    try {
        $stmt_select = $pdo->prepare("SELECT * FROM viagens WHERE id = :id");
        $stmt_select->execute([':id' => $id_para_exibir_apos_post]);
        $viagem_para_edicao = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if (!$viagem_para_edicao) {
            die("Viagem não encontrada com o ID fornecido.");
        }
    } catch (PDOException $e) {
        die("Erro ao carregar dados da viagem para edição: " . htmlspecialchars($e->getMessage()));
    }
} else {
    die("ID de viagem não especificado para edição."); // Este erro ocorrerá se você tentar abrir editar_viagens.php sem ?id=
}

?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/editar_viagens.css">
<title>Editar Viagem</title>
<div class="produto-container">
    <img class="logo" src="assets/logo.png" alt="Logo">
    <h2>Editar Viagem</h2>

    <form action="editar_viagens.php?id=<?= $viagem_para_edicao['id'] ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $viagem_para_edicao['id']; ?>">
        <div class="input-group">
            <input type="file" name="imagem" accept="image/*">
        </div>

        <div class="input-group">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo htmlspecialchars($viagem_para_edicao['titulo']); ?>" required>
        </div>

        <div class="input-group">
            <input type="number" name="valor" placeholder="Valor" step="0.01" value="<?php echo htmlspecialchars($viagem_para_edicao['valor']); ?>" required>
        </div>

        <div class="input-group-cadastro1">
            <input type="date" name="data-ida" value="<?php echo htmlspecialchars($viagem_para_edicao['data_ida']); ?>" required>
            <input type="date" name="data-volta" value="<?php echo htmlspecialchars($viagem_para_edicao['data_volta']); ?>" required>
        </div>

        <div class="descriçao">
            <textarea name="descricao" rows="5"><?php echo htmlspecialchars($viagem_para_edicao['descricao']); ?></textarea>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>
