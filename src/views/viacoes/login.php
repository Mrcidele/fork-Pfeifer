<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quero Passagem</title>

    <link rel="stylesheet" href="../../../public/login.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="left-panel">

    <div class="logo">
        <img src="Images/logo-branca.png"
             onclick="irParaHome()"
             width="110"
             height="50">
    </div>

    <div class="phone-container">
        <img src="Images/808212b4-ce05-4c77-ab32-35c01f5526d3.png"
             width="400"
             height="600">
    </div>

</div>

<div class="right-panel">

    <a href="#" class="help-center">
        <i class="fa-regular fa-circle-question"></i>
        Central de ajuda
    </a>

    <div class="login-container">

        <h1>Acesse suas viagens</h1>

        <?php if ($erro): ?>
            <div style="
                background:#ffe5e5;
                color:red;
                padding:10px;
                border-radius:8px;
                margin-bottom:15px;
            ">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="input-group">
                <input
                    type="text"
                    name="email"
                    placeholder="E-mail"
                    required>
            </div>

            <div class="input-group">
                <input
                    type="text"
                    name="senha"
                    placeholder="Senha"
                    required>
            </div>
            <div class="input-group">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            </div>

            <div class="info-box">
                <i class="fa-solid fa-circle-info"></i>
                <p>
                    Área exclusiva para administradores.
                </p>
            </div>

            <button class="btn-continue" type="submit">
                CONTINUAR
            </button>

        </form>

        <div class="divider">ou</div>

        <button class="social-btn">
            <i class="fa-brands fa-facebook"></i>
            Continue com o Facebook
        </button>

        <button class="social-btn">
            <i class="fa-brands fa-google"></i>
            Continue com o Google
        </button>

        <button class="social-btn">
            <i class="fa-brands fa-apple"></i>
            Continue com a Apple
        </button>

    </div>

</div>

<script src="JavaScript/redirecionamento.js"></script>

</body>
</html>