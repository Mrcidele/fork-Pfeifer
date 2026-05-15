<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quero Passagem</title>
    <link rel="stylesheet" href="/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<a href="#" class="help-center">
    <i class="fa-regular fa-circle-question"></i>
    Central de ajuda
</a>

<div class="right-panel">
    <div class="login-container">

        <a  href="/viacoes/home#">
<img src="/Images/logo_nova_grande.png" alt="Logo" width="250" height="120">
        </a>
        <h1>Acesse suas viagens</h1>

        <?php if (!empty($erro)): ?>
            <div class="error-box">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p><?= htmlspecialchars($erro) ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login">

            <div class="input-group">
                <input type="email" name="email" placeholder="E-mail"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
            </div>

            <div class="input-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="info-box">
                <i class="fa-solid fa-circle-info"></i>
                <p>Área exclusiva para administradores.</p>
            </div>

            <button class="btn-continue" type="submit">CONTINUAR</button>

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

</body>
</html>