<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quero Passagem</title>
    <link rel="stylesheet" href="/home.css">
</head>
<body>

<!--navbar-->
<nav class="navbar">
    <img src="/Images/logo_nova_grande.png" alt="logo" class="logo-qp">
    <div class="navbar-links">
        <ul>
            <li><a href="#"><b>Passagens</b></a></li>
            <li><a href="#"><b>Hotéis</b></a></li>
            <li><a href="#"><b>? central de ajuda</b></a></li>
            <button type="submit" class="button-submit" onclick="irParaLogin()">Entrar</button>
        </ul>
    </div>
</nav>

<div>
    <img src="/Images/Captura%20de%20tela%20de%202026-04-08%2008-40-51.png" class="imagemprincipal">
</div>

<!--form-->
<section class="comprar-passagens">
    <p class="comprar-passagens-de-ônibus"><b>Comprar Passagens de Ônibus</b></p>
    <div class="autocomplete">
        <input id="input-partida" class="input" placeholder="Partindo de:">
        <div id="sugestoes-partida" class="sugestoes"></div>
    </div>

    <input class="input" placeholder="Indo para:" list="indopara"></input>
    <datalist id="indopara">
        <option value="Curitiba">
        <option value="Rio de janeiro">
    </datalist>

    <div style="display: flex">
        <input class="input" placeholder="Data Saída:"></input>
        <input class="input" placeholder="Data Retorno:"></input>
    </div>

    <button class="button-buscar-passagem" onclick="irParaBuscarPassagens()">BUSCAR PASSAGEM</button>
</section>

<!--top bar-->
<div class="topbar-qp">
    <div class="topbar-qp-container">

        <div class="topbar-qp-item">
            <strong>Viagens seguras</strong>
            <p>Mais de 30 milhões de compras</p>
        </div>

        <div class="topbar-qp-item">
            <strong>Pagamento</strong>
            <p>Pague com Pix, Nupay ou em até 12x</p>
        </div>

        <div class="topbar-qp-item">
            <strong>Cancelamento</strong>
            <p>Passagens flexíveis e atendimento personalizado</p>
        </div>

    </div>
</div>

<br>

<!--escolha seu destino-->
<div class="texto-centralizado-cardview">
    <br>
    <h2 class="escolha-seu-destino">Escolha seu destino</h2>
    <p class="escolha-seu-destino-paragrafo">São mais de 5 mil destinos em todo o país para escolher sem sair de casa.</p>
</div>
<br>

<section class="lado-a-lado-card">
    <div class="card">
        <img class="imagem-cards" src="/Images/1a.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>São paulo</b></h4>
            <p>Partindo de</p>
            <p>Rio de janeiro, RJ   R$ 104</p>
            <p>Belo Horizonte, MG   R$ 139</p>
        </div>
    </div>

    <div class="card">
        <img class="imagem-cards" src="/Images/10.28GOIANIAGERAL_PJ-1-1024x569.jpeg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Goiânia</b></h4>
            <p>Partindo de</p>
            <p>Rio de janeiro, RJ   R$ 124</p>
            <p>Belo Horizonte, MG   R$ 139</p>
        </div>
    </div>

    <div class="card">
        <img class="imagem-cards" src="/Images/57a.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Rio de janeiro</b></h4>
            <p>Partindo de</p>
            <p>Rio de janeiro, RJ   R$ 140</p>
            <p>Belo Horizonte, MG   R$ 129</p>
        </div>
    </div>

    <div class="card">
        <img class="imagem-cards" src="/Images/55a.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Curitiba</b></h4>
            <p>Partindo de</p>
            <p>Rio de janeiro, RJ   R$ 108</p>
            <p>Belo Horizonte, MG   R$ 169</p>
        </div>
    </div>
</section>

<br>
<br>
<br>
<br>

<!--seja um parceiro-->
<img src="/Images/banner_download_app_2.png" style="width: 100%">

<section class="back-seja-um-parceiro">

    <div class="seja-um-parceiro-lado-a-lado">

        <img src="/Images/parceiro.png" width="600px" class="imagem-responsiva">
        <div class="colunas-paragrafos-e-botao">
            <h4>Agências de Viagem</h4>
            <p>Sistema completo de emissão e venda de passagens <br>rodoviárias para agências de viagens.</p>

            <h4>OTA's</h4>
            <p>Insira nosso banner (buscador de passagens) em seu <br>site e ganhe comissões por cada venda.</p>

            <button class="button-saiba-mais">
                <b>Saiba mais</b>
            </button>
        </div>

    </div>

</section>

<!--top trechos-->
<div class="top-trechos">
    <h2>Top 15 trechos de ônibus</h2>
    <p class="escolha-seu-destino-paragrafo">Os trechos mais procurados em nossa Central de Passagens.</p>

    <div class="top-grid">

        <div class="top-card">
            <div class="top-header">
                <span>Partindo de</span>
                <span>Indo para</span>
            </div>

            <div class="top-item">
                <span>Rio de Janeiro</span>
                <span class="seta">›</span>
                <span>São Paulo</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Rio de Janeiro</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Curitiba</span>
            </div>
            <div class="top-item">
                <span>Curitiba</span>
                <span class="seta">›</span>
                <span>São Paulo</span>
            </div>
            <div class="top-item">
                <span>Brasília</span>
                <span class="seta">›</span>
                <span>Goiânia</span>
            </div>
        </div>

        <div class="top-card">
            <div class="top-header">
                <span>Partindo de</span>
                <span>Indo para</span>
            </div>

            <div class="top-item">
                <span>Goiânia</span>
                <span class="seta">›</span>
                <span>Brasília</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Goiânia</span>
            </div>
            <div class="top-item">
                <span>Belo Horizonte</span>
                <span class="seta">›</span>
                <span>São Paulo</span>
            </div>
            <div class="top-item">
                <span>Goiânia</span>
                <span class="seta">›</span>
                <span>São Paulo</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Belo Horizonte</span>
            </div>
        </div>

        <div class="top-card">
            <div class="top-header">
                <span>Partindo de</span>
                <span>Indo para</span>
            </div>

            <div class="top-item">
                <span>Florianópolis</span>
                <span class="seta">›</span>
                <span>Curitiba</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Londrina</span>
            </div>
            <div class="top-item">
                <span>Porto Alegre</span>
                <span class="seta">›</span>
                <span>Curitiba</span>
            </div>
            <div class="top-item">
                <span>Curitiba</span>
                <span class="seta">›</span>
                <span>Florianópolis</span>
            </div>
            <div class="top-item">
                <span>São Paulo</span>
                <span class="seta">›</span>
                <span>Bauru</span>
            </div>
        </div>

    </div>
</div>

<!--deseja receber email-->
<div class="cor-back">
    <div class="texto-centralizado-cardview">
        <h2>Deseja receber e-mails com novidades e descontos exclusivos?</h2>
    </div>

    <section class="deseja-receber-grupo">
        <input placeholder="Seu nome" class="input-deseja-receber">
        <input placeholder="Seu e-mail" class="input-deseja-receber">
        <button class="button-inscreva-se">
            <b>Inscreva-se</b>
        </button>
    </section>
</div>

<br>
<br>

<!--viajar de onibus-->
<div class="viajar-de-onibus">
    <h2>Viajar de ônibus é rápido e fácil com a Quero Passagem</h2>
    <p>A Quero Passagem é o maior Portal de Passagens de Ônibus do Brasil - sua Central de Passagens Rodoviárias online. Pesquise viações, compare horários, preços e compre passagens rodoviárias sem sair de casa. São mais de 5 mil destinos em todo o país, conectando cidades como Belo Horizonte, Curitiba, Brasília, São Paulo, Rio de Janeiro, Salvador, Goiânia e muito mais.</p>
</div>

<section class="lado-a-lado-inf">
    <div class="card-inf">
        <img class="imagem-cards" src="/Images/card_pagamento.png" alt="Avatar" style="width:100%">
        <div class="container">
            <p>Escolha a melhor forma de pagamento para você: compre sua passagem de ônibus em até 12x no cartão de crédito ou pague com débito, transferência bancária, boleto ou via Pix.</p>
        </div>
    </div>

    <div class="card-inf">
        <img class="imagem-cards" src="/Images/card_onibus.png" alt="Avatar" style="width:100%">
        <div class="container">
            <p class="paragrafo-card-viajar">Viaje com conforto e segurança nas melhores companhias de ônibus do Brasil, como Viação Cometa, 1001, Catarinense, Itapemirim, Guanabara e outras 350 viações parceiras.</p>
        </div>
    </div>

    <div class="card-inf">
        <img class="imagem-cards" src="/Images/card_bilhetes.png" alt="Avatar" style="width:100%">
        <div class="container">
            <p class="paragrafo-card-viajar">Na Quero Passagem, você escolhe o horário, o assento e a empresa favorita para viajar. Finalize sua compra de passagem rodoviária online de forma rápida, segura e sem complicação.</p>
        </div>
    </div>

    <div class="card-inf">
        <img class="imagem-cards" src="/Images/card_praia.png" alt="Avatar" style="width:100%">
        <div class="container">
            <p class="paragrafo-card-viajar">Confiança de quem já colocou mais de 15 milhões de passageiros na estrada. Compre sua passagem de ônibus em menos de 5 minutos e bora viajar tranquilo.</p>
        </div>
    </div>
</section>

<br>
<br>
<br>
<br>

<!-- cards grid passagens -->
<section class="passagens-de-onibus">

    <div class="top-trechos-de-onibus">
        <h2>Passagens de Ônibus em oferta: Viações de Ônibus</h2>
        <p class="escolha-seu-destino-paragrafo">A sua passagem de ônibus na viação de sua preferência</p>
        <br>
    </div>

    <div class="container-grid">

        <?php foreach ($viacoes as $v): ?>
            <div class="item">
                <img src="uploads/<?= $v['logo'] ?>" width="80" height="100" style="border-radius: 5px">
                <hr>
                <p><?= $v['nome'] ?></p>
            </div>
        <?php endforeach;?>
    </div>

</section>

<br>
<br>
<br>

<div class="container-Faq-center">
    <h2>Perguntas frequentes</h2>
</div>

<!--faq-->
<div class="container-faq">
    <details>
        <summary>Quero Passagem é seguro para comprar passagens de ônibus online?</summary>
        <p>Sim! Comprar sua passagem pela Quero Passagem é seguro. A plataforma utiliza tecnologia de proteção de dados e pagamentos confiáveis para garantir que suas informações estejam sempre protegidas.</p>
    </details>

    <details>
        <summary>Quero Passagem é Confiável?</summary>
        <p>Sim! A Quero Passagem conecta você a diversas empresas de ônibus em todo o Brasil, permitindo comparar preços, horários e rotas para escolher a melhor opção.</p>
    </details>

    <details>
        <summary>Como fazer o cancelamento da minha passagem de ônibus?</summary>
        <p>Basta acessar Minha Conta, localizar sua passagem e seguir as orientações. O pedido deve ser feito antes do horário da viagem e segue as regras da empresa de ônibus.</p>
    </details>

    <details>
        <summary>Como e onde vou receber a confirmação de compra da minha passagem de ônibus?</summary>
        <p>Assim que o pagamento for aprovado, você recebe um e-mail com todos os detalhes da sua viagem, como dados da passagem, horário e orientações para o embarque.</p>
    </details>

    <details>
        <summary>Como alterar a data ou o horário da minha viagem de ônibus?</summary>
        <p>Basta acessar Minha Conta, encontrar sua passagem e solicitar a mudança. A alteração depende da disponibilidade de novos horários e das regras da empresa de ônibus.</p>
    </details>

    <details>
        <summary>Como usar o ID Jovem na reserva da passagem de ônibus?</summary>
        <p>Se você possui o ID Jovem, pode utilizar o benefício em viagens interestaduais. Para a compra, é necessário utilizar o link: https://queropassagem.com.br/gratuidade.</p>
    </details>

    <details>
        <summary>Qual é o melhor app para comprar passagens de ônibus?</summary>
        <p>Com o aplicativo da Quero Passagem você pode pesquisar destinos, comparar horários e comprar sua passagem diretamente pelo celular de forma rápida e segura.</p>
    </details>

    <details>
        <summary>Como comprar passagens de ônibus online?</summary>
        <p>Informe origem, destino e data; escolha o horário e a empresa; preencha os dados do passageiro e finalize o pagamento. A confirmação chegará por e-mail.</p>
    </details>
</div>

<br>
<br>
<br>
<br>

<!-- footer -->
<footer class="footer-espaco">

    <div class="footer-right">

        <div>
            <ul>
                <li><b>Top destinos</b></li>
                <li class="ul-footer">Ônibus Rio de janeiro</li>
                <li class="ul-footer">Ônibus São paulo</li>
                <li class="ul-footer">Ônibus Brasília</li>
                <li class="ul-footer">Ônibus Campinas</li>
                <li class="ul-footer">Ônibus Londrina</li>
                <li class="ul-footer"><b>+ Destinos</b>></li>
            </ul>
        </div>

        <div>
            <ul>
                <li><b>Top viações</b></li>
                <li class="ul-footer">Passagens Cometa</li>
                <li class="ul-footer">Passagens Gontijo</li>
                <li class="ul-footer">Passagens 1001</li>
                <li class="ul-footer">Passagens Águia Branca</li>
                <li class="ul-footer">Passagens Pássaro Marron</li>
                <li class="ul-footer"><b>+ Viações</b></li>
            </ul>
        </div>

        <div>
            <ul>
                <li><b>Top rodoviárias</b></li>
                <li class="ul-footer">Rodoviária São paulo - Tietê</li>
                <li class="ul-footer">Rodoviária Rio de janeiro - Novo Rio</li>
                <li class="ul-footer">Rodoviária Belo Horizonte - Gov.Israel</li>
                <li class="ul-footer">Rodoviária Curitiba</li>
                <li class="ul-footer">Rodoviária São paulo - Barra Funda</li>
                <li class="ul-footer"><b>+ Rodoviária</b><li>
            </ul>
        </div>
    </div>

</footer>

<footer class="footer-qp">
    <div class="footer-qp-container">

        <div class="footer-qp-left">
            <img src="/Images/logo_nova_grande.png" alt="Quero Passagem" class="footer-qp-logo">

            <p>
                Na Quero Passagem sua compra é totalmente segura!
            </p>

            <p>
                Para garantirmos que seus dados estejam sempre protegidos, não armazenamos nenhuma informação do cartão de crédito utilizado, seguindo os protocolos de criptografia e de segurança das principais instituições bancárias do Brasil.
            </p>

            <h4>SIGA NOSSAS REDES SOCIAIS:</h4>

            <div class="footer-qp-social">
                <span>📷</span>
                <span>▶️</span>
                <span>📘</span>
                <span>💼</span>
            </div>
        </div>

        <div class="footer-qp-links">
            <ul>
                <li>Sobre nós</li>
                <li>Termos de uso</li>
                <li>Política de privacidade</li>
                <li>Termos de Uso Louge Vip</li>
                <li>Imprensa</li>
                <li>Minha Conta</li>
            </ul>

            <ul>
                <li>Atendimento Online</li>
                <li>Trabalhe Conosco</li>
                <li>Gratuidade</li>
                <li>Auto Viações</li>
                <li>Rodoviárias</li>
                <li>Destinos</li>
            </ul>

            <ul>
                <li>Afiliados</li>
                <li>Versão Mobile</li>
                <li>Rodomilhas</li>
                <li>Viajo Mucho</li>
                <li>La terminal Costa Rica</li>
            </ul>
        </div>
    </div>

    <div class="footer-qp-bottom">
        <span>CONHEÇA O GRUPO QP:</span>

        <div class="footer-qp-brands">
            <span>RODON</span>
            <span>ViajoMucho</span>
            <span>LaTerminal</span>
        </div>
    </div>
</footer>

<hr>
<footer class="site-footer">
    <div class="footer-content">
        <p>Calçada das Margaridas, 163 - Sala 02 - Condomínio Centro Comercial Alphaville, Barueri - SP | CEP: 06453-038 | CNPJ: 18.087.991/0001-57 | saconibus@queropassagem.com.br</p>
        <ul class="footer-links">
            <li><a href="#">Copyright 2026 © QueroPassagem.com.br</a></li>
        </ul>
    </div>
</footer>

<script src="/index.js"></script>

</body>
</html>