<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<body>
  <div class="main-container">
    <div class="sidebar">
      <a href="index.php">
          <img class="logo" src="assets/logo.png" alt="Logo">
      </a>
        <button onclick="carregarPagina('cadastrar_viagem.php')">
            <img src="assets/+.png" alt="Viagem" />
        </button>

        <div class="fundo-branco">
            <button onclick="carregarPagina('cadastrar_administrador.php')">
                <img src="assets/addusuario.png" alt="Administrador" />
            </button>

            <button onclick="carregarPagina('listar_administrador.php')">
                <img src="assets/usuario.png" alt="Administradores" />
            </button>

            <button onclick="carregarPagina('listar_viagens.php')">
                <img src="assets/onibus.png" alt="Produtos" />
            </button>
        </div>
    </div>

    <div class="painel-conteudo" id="painel-conteudo">
    </div>
  </div>

  <script>
    function carregarPagina(pagina) {
        fetch(pagina)
            .then(response => {
                if (!response.ok) {
                throw new Error('Erro ao carregar a página: ' + response.statusText);
                }
                return response.text();
            })
            .then(html => {
                document.getElementById('painel-conteudo').innerHTML = html;
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('painel-conteudo').innerHTML = '<p>Erro ao carregar o conteúdo.</p>';
            });
    }
  </script>


  <style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

body {
  background-color: #F5F5F5;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  overflow: hidden;
}

.main-container {
  display: flex;
  height: 100vh;
  width: 100%;
}

/* Sidebar */
.sidebar {
  background-color: #EAEAEA;
  width: 90px;
  min-width: 70px;
  margin: 20px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px 10px;
  border-radius: 20px;
  gap: 20px;
}

.sidebar img.logo {
  width: 48px;
  margin-bottom: 20px;
}

.sidebar button {
  background-color: #FF8548;
  border: none;
  cursor: pointer;
  padding: 10px;
  border-radius: 10px;
  width: 46px;
  height: 46px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s;
}

.sidebar button img {
  width: 20px;
  height: 20px;
}

.sidebar button:hover {
  background-color: #ff503e;
}

/* Botões com fundo branco */
.fundo-branco button {
  background-color: #fff;
  border: 2px solid #FF8548;
  margin-bottom: 10px;
}

.fundo-branco button:hover {
  background-color: #FFE2D5;
}

/* Conteúdo principal */
.painel-conteudo {
  flex: 1;
  background-color: #fff;
  margin: 20px;
  border-radius: 12px;
  padding: 20px;
  overflow-y: auto;
  min-width: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Responsividade */
@media (max-width: 768px) {
  .main-container {
    flex-direction: column;
  }

  .sidebar {
    flex-direction: row;
    width: 100%;
    height: auto;
    border-radius: 0;
    justify-content: center;
    gap: 10px;
  }

  .sidebar img.logo {
    width: 36px;
    margin: 0;
  }

  .painel-conteudo {
    margin: 10px;
    padding: 15px;
  }
}

@media (max-width: 480px) {
  .sidebar button {
    width: 40px;
    height: 40px;
    padding: 8px;
  }

  .sidebar button img {
    width: 16px;
    height: 16px;
  }

  .painel-conteudo {
    margin: 5px;
    padding: 10px;
    justify-content: center;
    align-items: center;
  }
}
    
  </style>

</body>
</html>








































