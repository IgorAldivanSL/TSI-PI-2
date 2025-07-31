<?php
require_once('conexao.php');

try {
    $stmt = $pdo->query("SELECT * FROM viagens ORDER BY id DESC");
    $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar viagens: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R Trips</title>
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <img class="logo" src="assets/logo.png" alt="Logo">    
        <div class="menu-container">
            <button class="menu-toggle">☰</button>
            <nav>
                <ul>
                    <li><a href="#home">Início</a></li>
                    <li><a href="#destinos">Destinos</a></li>
                    <li><a href="#vantagens">Vantagens</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#depoimentos">Depoimentos</a></li>
                </ul>
                <a href="login.php"><button class="botao-contato">l00gin</button></a>
            </nav>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.querySelector('.menu-toggle');
            const nav = document.querySelector('.menu-container nav');

            menuToggle.addEventListener('click', function () {
                nav.classList.toggle('active');
            });
        });
    </script>

    <!-- Sessão 1: Banner -->
    <section class="banner" id="home">
        <div class="coluna-1 conteudo-texto">
            <h1>O mundo espera pelas suas próximas memórias</h1>
            <p>Roteiros exclusivos, suporte completo e experiências inesquecíveis. Viaje com a R Trips!</p>

            <div class="botoes">
                <img class="img-mobile" src="assets/mulher-na-praia.png" alt="Imagem de praia">
                <a href="#contato"><button class="botao-reservar">Reservar minhas passagens</button></a>
                <a href="wa.me/5511984333287"><button class="botao-duvidas">Tirar dúvidas</button></a>
            </div>
        </div>
        <div class="coluna-2 imagem-principal">
            <img src="assets/mulher-na-praia.png" alt="Imagem de praia">
        </div>
    </section>

    <!-- Sessão 2: Destinos -->
    <section id="destinos" class="destinos">
            <h2>Viagens Cadastradas</h2>
            <div class="destinos-container">
                <?php foreach ($viagens as $viagem): ?>
                    <div class="destino-card">
                        <div class="img-card">
                            <img src="assets/<?php echo htmlspecialchars($viagem['imagem']); ?>" 
                                alt="<?php echo htmlspecialchars($viagem['titulo']); ?>">
                            <div class="preco">
                                R$ <?php echo number_format($viagem['valor'], 2, ',', '.'); ?>
                            </div>
                            
                        </div>

                        <h3><?php echo htmlspecialchars($viagem['titulo']); ?></h3>

                        <p><?php echo htmlspecialchars($viagem['descricao']); ?></p>

                        <div class="data">
                            <span>Ida</span> 
                            <span class="data-valor">
                                <?php echo date('M d, Y', strtotime($viagem['data_ida'])); ?>
                            </span>
                            <span>Volta</span> 
                            <span class="data-valor">
                                <?php echo date('M d, Y', strtotime($viagem['data_volta'])); ?>
                            </span>
                        </div>

                        <a href="">
                            <button class="btn-reservar">
                                <span>Reservar passagem</span>
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            
                            
                        
                        </a>
                        
                    </div>
                <?php endforeach; ?>
                
            </div>
    </section>

    <!-- Sessão 3: Vantagens -->
    <section id="vantagens" class="vantagens">
        <div class="coluna-1 imagem-vantagens">
            <img src="assets/vantagens.svg" alt="Viajante com mala">
        </div>
        <div class="coluna-2">
            <div class="texto-sessao3">
                <h2>Por que nos escolher a<br>R Trips?</h2>
                <p>
                    Oferecemos roteiros cuidadosamente planejados, guias experientes e suporte completo do início ao fim.
                    Além disso, priorizamos conforto, segurança e momentos únicos, garantindo que cada viagem seja
                    inesquecível e adaptada às suas expectativas.
                </p>
                <div class="beneficios">
                    <div class="beneficios-texto">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Experiências Enriquecedoras</h3>
                            <p>Explorar novos destinos permite mergulhar em diferentes culturas, gastronomias e tradições.</p>
                        </div>
                    </div>
                    <div class="beneficios-texto">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Comodidade e Segurança</h3>
                            <p>Fazer uma excursão elimina o estresse de organizar todos os detalhes da viagem.</p>
                        </div>
                    </div>
                    <div class="beneficios-texto">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Novas Amizades</h3>
                            <p>Viajar em grupo possibilita conhecer novas pessoas com interesses similares.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sessão 4: Sobre -->
    <section class="sobre" id="sobre">
        <div class="coluna-1 sobre">
            <h2>Sobre nós</h2>
            <p>Aqui cada viagem é planejada com o coração. Fundada por Rita Santos, uma verdadeira apaixonada por explorar o Brasil, a R Trips nasce do desejo de compartilhar essa paixão com você. Acreditamos que cada destino traz uma nova história e, com sua experiência, cuidamos de cada detalhe para garantir que sua jornada seja tão incrível quanto os lugares que vai conhecer!</p>
            <img class="img-mobile" src="backend/assets/sobre.png" alt="Viajante com mala">
            <div class="botoes">
                <button class="botao-reservar">Reservar minhas passagens</button>
            </div>
        </div>
        <div class="coluna-2 sobre" >
            <img src="assets/sobre.png" alt="Viajante com mala">
        </div>
    </section>

    <!-- Sessão 5: Depoimentos -->
    <section class="depoimentos-container" id="depoimentos">
        <h2>Depoimento de nossos clientes</h2>
        <div class="depoimentos">
            <div class="cards">
                <div>
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de Maria">
                    <h3>Maria Clara</h3>
                    <div class="stars">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <p>Fui em uma excursão para Angra dos Reis e foi uma experiência maravilhosa! As praias são deslumbrantes e as ilhas, um paraíso. O passeio foi super organizado, com guias muito atenciosos. Recomendo a todos que amam natureza e tranquilidade!</p>
                </div>
            </div>

            <div class="cards">
                <div>
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de João">
                    <h3>João Pedro</h3>
                    <div class="stars">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>

                    <p>A excursão para o Rio de Janeiro foi sensacional! Além de conhecer o Cristo Redentor e o Pão de Açúcar, ainda tivemos tempo para aproveitar a praia de Copacabana. Tudo muito bem planejado, com transporte confortável e ótimos guias. Já estou pensando na próxima!</p>
                </div>
            </div>

            <div class="cards">
                <div>
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de Ana">
                    <h3>Fernanda Alves</h3>
                    <div class="stars">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <p> excursão para Campos do Jordão foi simplesmente encantadora! O clima frio, as paisagens montanhosas e a arquitetura charmosa da cidade fizeram a viagem ser única. Além disso, os passeios foram muito bem organizados, com visitas a pontos turísticos como o Horto Florestal e o Palácio Boa Vista. Um destino perfeito para quem busca descanso e contato com a natureza!</p>
                                </div>
            </div>

        </div>
    </section>

    <!-- Sessão 6: Contato -->
    <section class="contato-container" id="contato">
        <div class="coluna-1 contato">
            <h2>Já agendou suas férias?</h2>
            <p>Fale conosco e descubra destinos incríveis e experiências memoráveis que aguardam por você.</p>
            <img src="assets/contato.png" height="400px" alt="Imagem de contato">
        </div>
        <div class="coluna-2">
            <form action="" method="post">
                <div class="input-group">
                    <input type="text" placeholder="Nome Completo" name="nome" required>
                    <input type="email" placeholder="Seu E-mail" name="email" required>
                </div>
                <input type="tel" placeholder="Telefone / WhatsApp" name="telefone" required>
                <textarea placeholder="Sua Mensagem" name="mensagem" rows="4" required></textarea>
                <button class="enviar-contato" type="submit">Enviar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2024 R Trips. Todos os direitos reservados. Proibida a reprodução total ou parcial sem autorização prévia.</p>
    </footer>

</body>

</html>
