<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <h2 class="card-title" style="margin-bottom:10px;">Criar conta</h2>

    <?php if (!empty($erros)): ?>
        <div class="alert alert-erro">
            <?php foreach ($erros as $erro): ?>
                <div><?= htmlspecialchars($erro); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?rota=register">
        <div class="campo">
            <label for="nome">Nome completo</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div class="campo">
            <label for="email">Email institucional</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>
        </div>
        <div class="campo">
            <label for="senha_confirmacao">Confirmar senha</label>
            <input type="password" name="senha_confirmacao" id="senha_confirmacao" required>
        </div>
        <button type="submit" class="btn-primario">Cadastrar</button>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
