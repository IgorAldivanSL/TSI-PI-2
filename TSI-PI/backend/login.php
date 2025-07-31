<?php

//nesse arquivo, através de um formulário html, coletamos os dados de login do administrador que está querendo acessar o sistema.
//Uma vez feito isso, enviamos via método post desse formulário, os dados para o arquivo processa_login.php
//No final do arquivo html, capturamos e escrevemos um possível erro que possa ter havido no login do usuário que foi processado (e enviado) no arquivo processa_login.php

session_start();

// Se a variável de sessão com a mensagem de erro estiver definida
if(isset($_SESSION['mensagem_erro'])) {
    echo '<p>' . $_SESSION['mensagem_erro'] . '</p>'; // Exibe a mensagem de erro
    unset($_SESSION['mensagem_erro']); // Descarta a variável de sessão
}
?>

<title>Login do Administrador</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/login.css">

<body>
    <div class="login-container">
        <a href="index.php">
            <img class="logo" src="assets/logo.png" alt="Logo">
        </a>
        <h2>Login</h2>
        <form action="processa_login.php" method="post">
            <div class="input-group">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="input-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <input type="submit" value="ENTRAR">
        </form>

        <a class="cadastrar-admin" href="cadastrar_administrador.php">Crie sua conta</a>

    </div>

</body>
</html>
























