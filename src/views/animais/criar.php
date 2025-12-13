<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Novo atendimento</div>
            <h2 class="card-title">Registrar animal</h2>
        </div>
    </div>

    <?php if (!empty($erros)): ?>
        <div class="alert alert-erro">
            <?php foreach ($erros as $erro): ?>
                <div><?= htmlspecialchars($erro); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?rota=animais_criar">
        <div class="campo">
            <label for="especie">Espécie</label>
            <input type="text" name="especie" id="especie" required value="<?= htmlspecialchars($data['especie'] ?? ''); ?>">
        </div>
        <div class="campo">
            <label for="origem">Origem (onde foi encontrado)</label>
            <input type="text" name="origem" id="origem" required value="<?= htmlspecialchars($data['origem'] ?? ''); ?>">
        </div>
        <div class="campo">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo" required>
                <?php
                $sexoAtual = $data['sexo'] ?? 'indefinido';
                ?>
                <option value="masculino" <?= $sexoAtual === 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                <option value="feminino"  <?= $sexoAtual === 'feminino'  ? 'selected' : ''; ?>>Feminino</option>
                <option value="indefinido"<?= $sexoAtual === 'indefinido'? 'selected' : ''; ?>>Indefinido</option>
            </select>
        </div>
        <div class="campo">
            <label for="idade">Idade</label>
            <?php $idadeAtual = $data['idade'] ?? 'filhote'; ?>
            <select name="idade" id="idade" required>
                <option value="neonato" <?= $idadeAtual === 'neonato' ? 'selected' : ''; ?>>Neonato</option>
                <option value="filhote" <?= $idadeAtual === 'filhote' ? 'selected' : ''; ?>>Filhote</option>
                <option value="juvenil" <?= $idadeAtual === 'juvenil' ? 'selected' : ''; ?>>Juvenil</option>
                <option value="adulto"  <?= $idadeAtual === 'adulto'  ? 'selected' : ''; ?>>Adulto</option>
                <option value="idoso"   <?= $idadeAtual === 'idoso'   ? 'selected' : ''; ?>>Idoso</option>
            </select>
        </div>
        <div class="campo">
            <label for="obs">Observações (até 200 caracteres)</label>
            <textarea name="obs" id="obs" maxlength="200"><?= htmlspecialchars($data['obs'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn-primario">Salvar registro</button>
        <a href="index.php" class="btn-secundario" style="margin-left:8px;">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
