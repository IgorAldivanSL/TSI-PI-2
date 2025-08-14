<?php
session_start(); // Iniciar a sessão
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="src/css/painel_admin.css">
<title>Document</title>

<div class="main-container">
  <div class="sidebar">
      <a href="index.php">
          <img class="logo" src="assets/logo.png" alt="Logo">
      </a>
        <button onclick="carregarPagina('cadastrar_viagens.php')">
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

    document.addEventListener("submit", function(event) {
    event.preventDefault(); // Impede envio tradicional

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action || window.location.href, {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('painel-conteudo').innerHTML = html;
    })
    .catch(error => {
        console.error('Erro ao enviar formulário:', error);
        document.getElementById('painel-conteudo').innerHTML = "<p>Erro ao processar.</p>";
    });
});

    function excluirViagem(id) {
      if (confirm('Tem certeza que deseja excluir esta viagem')) {
        fetch('excluir_viagen.php?id=' + id)
        .then(response => {
          if(!response.ok) throw new Error('Erro ao excluir');
          return response.text();
        })
        .then(() => {
          //recarrega a lista apos excluir
          carregarPagina('listar_viagens.php');
        })
        .catch(error => {
          alert('Erro ao excluir viagem: ' + error.message);
        });
      }
    }

    function excluirAdministrador(admId) {
      if (confirm('Tem certeza que deseja excluir este administrador')) {
        fetch('excluir_administrador.php?id=' + admId)
        .then(response => {
          if(!response.ok) throw new Error('Erro ao excluir');
          return response.text();
        })
        .then(() => {
          //recarrega a lista apos excluir
          carregarPagina('listar_administrador.php');
        })
        .catch(error => {
          alert('Erro ao excluir administrador: ' + error.message);
        });
      }
    }
</script>

  










































