
<?php

//Nesse arquivo, primeiro recuperamos os dados do administrador que queremos editar (que foram enviados da página listar_administrador.php ao clicar o link editar). 
//Para saber qual administrador estamos considerando, recuperamos via superglobal $_GET o id do administrador em questão
//Feito isso, vamos para a página html que está no final desse arquivo e apresentamos os dados num formulário html, que nos permite editar os dados necessários.
//Feito isso, temos no html, no final da página, um botão que permite enviar os dados para serem atualizados no BD via script php que está no meio desse arquivo aqui
//Aí, nesse  script php, recebemos os dados que foram atualizados no formulário e enviados via método post para esse arquivo mesmo e atualizamos os dados no BD
//
session_start();

require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$adm_id = $_GET['id']; 
// Busca as informações do administrador no BD
$stmt_adm = $pdo->prepare("SELECT * FROM usuarios_adm WHERE adm_id = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);

//____________________________________________________________________


//3.Recuperando os dados que foram atualizados no formulário abaixo (html) via método post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    // Atualizando as informações do administrador no BD
    try {
        $stmt_update_adm = $pdo->prepare("UPDATE usuarios_adm SET adm_nome = :nome, adm_email = :email, adm_senha = :senha,  adm_ativo = :ativo  WHERE adm_id = :adm_id");
        $stmt_update_adm->bindParam(':nome', $nome);
        $stmt_update_adm->bindParam(':email', $email);
        $stmt_update_adm->bindParam(':senha', $senha);
        $stmt_update_adm->bindParam(':ativo', $ativo);
        $stmt_update_adm->bindParam(':adm_id' ,$adm_id);
        $stmt_update_adm->execute();

        echo "<p style='color:green;'>Administrador atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <h2>Editar Administrador</h2>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $adm['adm_nome'] ?>" required>
        <p>
        <!-- Na linha acima, o short echo tag (< ?=)  é exatamente equivalente a: (< ?php) -->
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value=" <?= $adm['adm_email'] ?>" required>
        <p> 
        <label for="senha">Senha:</label>
        <input type="text" name="senha" id="senha" value=" <?= $adm['adm_senha'] ?>" required>
        <p>
        <p>
        <label for="ativo">Ativo:</label>
        <input type="checkbox" name="ativo" id="ativo" value="1" <?= $adm['adm_ativo'] ? 'checked' : '' ?>>
        <p>
        <!-- 
        value="1"   Define o que será enviado ao servidor, se o checkbox estiver marcado
        checked     Controla o estado inicial do checkbox quando a página carrega (se vai aparecer marcado ou não). Sem ele, mesmo que value="1", o checkbox inicia sempre desmarcado. --> 


        <p>
        <button type="submit">Atualizar Administrador</button>
    </form>

<p></p>
    <a href="listar_administrador.php">Voltar à Lista de Administradores</a>
</body>
</html>
    
</body>
</html>
