
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

$stmt_adm = $pdo->prepare("SELECT * FROM usuarios_adm WHERE adm_id = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $stmt_update_adm = $pdo->prepare("UPDATE usuarios_adm SET adm_nome = :nome, adm_email = :email, adm_senha = :senha, adm_ativo = :ativo WHERE adm_id = :adm_id");
        $stmt_update_adm->bindParam(':nome', $nome);
        $stmt_update_adm->bindParam(':email', $email);
        $stmt_update_adm->bindParam(':senha', $senha);
        $stmt_update_adm->bindParam(':ativo', $ativo);
        $stmt_update_adm->bindParam(':adm_id', $adm_id);
        $stmt_update_adm->execute();

        echo "<p style='color:green;'>Administrador atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/editar_administrador.css">
<title>Cadastrar Viagem</title>

<div class="editadm-container">
    <h2>Editar administrador</h2>

    <form action="editar_administrador.php?id=<?= $adm['adm_id'] ?>" method="post" >

        <div class="input-group">
            <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($adm['adm_nome']) ?>" required>
        </div>
        <div class="input-group">
            <input type="email" name="email" placeholder="E-mail" value="<?= htmlspecialchars($adm['adm_email']) ?>" required>
        </div>
        <div class="input-group">
            <input type="password" name="senha" placeholder="Senha" value="<?= htmlspecialchars($adm['adm_senha']) ?>" required>
        </div>
        <label for="ativo">Ativo:</label>
        <input type="checkbox" name="ativo" id="ativo" value="1" <?= $adm['adm_ativo'] ? 'checked' : '' ?>>
        <br><br>
        
         <button type="submit">Salvar Alterações</button>

    </form>
</div> 
</body>
</html>
