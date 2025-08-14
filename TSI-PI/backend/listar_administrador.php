<?php

//Nesse arquivo, que pode ser chamado na página painel_administrador, primeiro selecionamos através de um script php todos os administradores ativos do banco de dados. Armazenamos esse resultado na variável $administradores
//A seguir, através de uma tabela no html, puxamos esses dados selecionados (através de um foreach, usando a variável $administradores e uma variável $adm, criada no foreach) e os apresentamos.
//Também criamos dois links em cada linha da tabela para editar (quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL) ou excluir o administrador (quando clicado, chama a function confirmDeletion(), que cria uma janela que é apresentada ao usuário para confirmar a exclusão ou não do administrador)

session_start();

require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
$administradores = []; // Inicializa como array vazio

try {
    /*sem usar declarações preparadas (Executa a consulta diretamente):
     $result = $pdo->query("SELECT * FROM ADMINISTRADOR");
    // Busca todos os registros retornados
    $administradores = $result->fetchAll(PDO::FETCH_ASSOC); */

    //Usando declarações preparadas (recomendado):
    $stmt = $pdo->prepare("SELECT * FROM usuarios_adm "); //vai buscar todas as colunas da tabela ADMINISTRADOR
    $stmt->execute();  //***vide explicações sobre a dinâmica desses comandos no final do arquivo
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch = recuperar, buscar
    
    /*Para efeitos de depuração, se quisesse ver a variável $administradores, poderia mandar escrevê-la:
    echo '<pre>';
    print_r($administradores);
    echo '</pre>';  */

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
}
?>


<meta charset="UTF-8">

<title>Listar Administradores</title>
<link rel="stylesheet" href="src/css/listar_administrador.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="container-table">
    <h2>Administradores cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Ativo</th>
            <th>Ações</th>
            <!-- <th>Imagem</th> -->
        </tr>
        <?php foreach($administradores as $adm): ?>
        <tr>
            <td><?php echo $adm['adm_id']; ?></td>
            <td><?php echo $adm['adm_nome']; ?></td>
            <td><?php echo $adm['adm_email']; ?></td>
            <td><?php echo $adm['adm_senha']; ?></td>
            <td><?php echo ($adm['adm_ativo'] == 1 ? 'Sim' : 'Não'); ?></td>
                
            <td>
                <a href="#" onclick="carregarPagina('editar_administrador.php?id=<?php echo $adm['adm_id']; ?>')" class="action-btn">Editar</a>

                    <!-- A linha de código HTML acima, cria um link que, quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL. Além disso, o link é estilizado com uma classe CSS chamada action-btn. 
                    ?id=< ?php echo $adm['ADM_ID']; ?>: Esta parte é um parâmetro de query na URL. Após o nome do arquivo PHP (editar_administrador.php), o ? inicia a string de query. id= define uma variável de query chamada id, cujo valor é definido pelo trecho PHP < ?php echo $adm['ADM_ID']; ?>. Este código PHP insere dinamicamente o ID do administrador no link, pegando o valor da chave ADM_ID do array $adm. Isso significa que, para cada administrador listado, será gerado um link único que inclui seu respectivo ID como parte da URL. Essa técnica é comumente usada para passar informações entre páginas via URL
                    
                    Como funciona o <a href="…?id=< ?php echo $adm['ADM_ID']; ?>">
                    O browser renderiza esse trecho em HTML puro. Por exemplo, para o administrador de ID 2:

                    <a href="editar_administrador.php?id=2" class="action-btn">Editar</a>
                    Quando o usuário clica, o navegador faz uma requisição GET para
                    editar_administrador.php?id=2.

                    Em editar_administrador.php, você acessa $_GET['id'] (aqui, o valor 2) e pode usá-lo para carregar o registro correto do banco de dados ou apenas confirmar que recebeu o parâmetro.

                    Dessa forma, usando query strings (?chave=valor), você passa informações entre páginas sem formulários, só com links dinâmicos.
                        -->

                <a href="#" onclick="excluirAdministrador(<?php echo $adm['adm_id']; ?>)" class="delete-btn">Excluir</a>

                    <!-- O atributo onclick em um elemento HTML define um handler (ou “ouvinte”) de evento JavaScript que será executado quando o usuário clicar naquele elemento. Antes de seguir a URL (excluir_administrador.php?id=...), o navegador vai executar a função JavaScript confirmDeletion().O return é fundamental. Se confirmDeletion() retornar true, o clique prossegue normalmente e o navegador carrega a página apontada em href.Se retornar false, a ação padrão (navegar para href) é cancelada.-->
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
