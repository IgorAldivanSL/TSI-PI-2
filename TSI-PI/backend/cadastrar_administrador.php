<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
//require_once('conexao.php');
require_once('conexao.php');

// Verifica se o administrador está logado.


// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0; //esse comando é uma maneira concisa de dizer: "Se o campo ativo do formulário foi marcado, defina $ativo como 1. Caso contrário, defina como 0." Isso é útil para manipular checkboxes em formulários, pois eles só são incluídos nos dados do POST se estiverem marcados. Portanto, essa abordagem permite que você traduza a presença ou ausência do checkbox marcado em um valor booleano representado por 1 ou 0, respectivamente
    
    // Inserindo administrador no banco.
    try {
        $sql = "INSERT INTO usuarios_adm (adm_nome, adm_telefone, adm_cpf, adm_email, adm_senha) VALUES (:nome, :telefone, :cpf, :email, :senha);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

        $stmt->execute(); // Adicionado para executar a instrução

        // Pegando o ID do administrador inserido.
        $adm_id = $pdo->lastInsertId();

        
        echo "<p style='color:green;'>Administrador cadastrado com sucesso! ID: " . $adm_id . "</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar Administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Início do código HTML -->

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/cadastrar_administrador.css">
<title>Cadastro</title>

<div class="cadastro-container">
    <img class="logo"  src="assets/logo.png" alt="Logo">
    <h2>Cadastro</h2>
    <form action="cadastrar_administrador.php" method="post" >
        <div class="input-group-cadastro1">
            <i class="fas fa-user"></i>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="telefone" placeholder="Telefone" required>
        </div>

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="E-mail" required>
            <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
        </div>

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="cpf" placeholder="CPF" required>
            <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
        </div>

        <div class="input-group-cadastro1">
            <i class="fas fa-user"></i>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="senha" placeholder="Confirmar" required>
        </div>

        <button type="submit">Cadastrar</button>
        <label for="ativo">Ativo:</label>
        <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    </form>

    <a class="fazer-login" href="login.php">Fazer login</a>
</div>
    
