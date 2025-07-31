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

<!DOCTYPE html>
<html>
<head>
    <title>Login do Administrador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
</head>
<body>
    <div class="login-container">
        <a href="index.php">
            <img class="logo" src="assets/logo.png" alt="Logo">
        </a>
        <h2>Login</h2>
        <form action="processa_login.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="email" name="email" placeholder="E-mail" required>

            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="password" name="senha" placeholder="Senha" required>
                <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
            </div>

            <input type="submit" value="ENTRAR">
        </form>

        <a class="cadastrar-admin" href="cadastrar_administrador.php">Crie sua conta</a>

    </div>

    <style>            
       
        * {
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
    }

    body {
        background-color: #F5F5F5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        flex-wrap: wrap;
        padding: 20px;
    }

    .login-container {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        width: 20%;
        text-align: center;
        min-width: 300px; /* garante que não fique pequeno demais */
    }

    .login-container img.logo {
        width: 60px;
        margin-bottom: 12px;
    }

    .login-container h2 {
        margin-bottom: 30px;
        font-size: 24px;
        color: #222;
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-group input {
        height: 50px;
        width: 100%;
        padding: 12px 45px 12px 45px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #EAEAEA;
        font-size: 16px;
    }

    .input-group i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 15px;
        color: #555;
    }

    .input-group .toggle-password {
        right: auto;
        cursor: pointer;
    }

    input[type="submit"] {
        width: 100%;
        background-color: #FF8548;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #ff503e;
    }

    .cadastrar-admin {
        margin-top: 20px;
        display: block;
        color: #444;
        text-decoration: none;
        font-size: 14px;
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .login-container {
            width: 30%;
        }
    }

    @media (max-width: 768px) {
        .login-container {
            width: 50%;
        }
    }

    @media (max-width: 480px) {
        .login-container {
            width: 90%;
        }
    }

 
    </style>
</body>
</html>
























