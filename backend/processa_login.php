<?php
session_start();

try {
    require_once('conexao.php');

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios_adm WHERE adm_email = :email AND adm_senha = :senha AND adm_ativo = 1";
    $query = $pdo->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);
    $query->execute();

    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $_SESSION['admin_logado'] = true;
        header('Location: painel_admin.php');
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "NOME DE USUÁRIO OU SENHA INCORRETO";
        header('Location: login.php?erro');
        exit;
    }
} catch (Exception $e) {
    $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();
    header('Location: login.php?erro');
    exit;
}
?>




