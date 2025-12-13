<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="grid-auth">
        <div class="hero-auth">
            <h1>Encontrei um filhote de gambá… e agora?</h1>
            <p>
                Este painel foi criado para os alunos registrarem animais atendidos, 
                de forma simples e organizada, substituindo anotações em papel.
            </p>
            <p style="margin-top:10px;font-size:13px;">
                Use as informações para estudo, nunca para manipular os animais sem orientação profissional.
            </p>
        </div>
        <div>
            <h2 class="card-title" style="margin-bottom:10px;">Acessar painel</h2>

            <?php if (!empty($erros)): ?>
                <div class="alert alert-erro">
                    <?php foreach ($erros as $erro): ?>
                        <div><?= htmlspecialchars($erro); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?rota=login">
                <div class="campo">
                    <label for="email">Email institucional</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="campo">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <button type="submit" class="btn-primario">Entrar</button>
            </form>

            <p style="margin-top:10px;font-size:13px;">
                Ainda não tem conta?
                <a href="index.php?rota=register" style="color:var(--verde-medio);font-weight:600;">
                    Cadastre-se
                </a>
            </p>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
