<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Painel de campo</div>
            <h2 class="card-title">Animais registrados</h2>
        </div>
        <a href="index.php?rota=animais_criar" class="btn-primario">+ Novo registro</a>
    </div>

    <?php if (isset($mensagemSucesso)): ?>
        <div class="alert alert-sucesso"><?= htmlspecialchars($mensagemSucesso); ?></div>
    <?php endif; ?>

    <?php if (empty($animais)): ?>
        <p style="font-size:14px;">Nenhum animal cadastrado ainda. Use o botão “Novo registro”.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Espécie</th>
                    <th>Origem</th>
                    <th>Sexo</th>
                    <th>Idade</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($animais as $animal): ?>
                <?php
                    $sexo = $animal->getSexo();
                    $idade = $animal->getIdade();
                ?>
                <tr>
                    <td>#<?= $animal->getId(); ?></td>
                    <td><?= htmlspecialchars($animal->getEspecie()); ?></td>
                    <td><?= htmlspecialchars($animal->getOrigem()); ?></td>
                    <td>
                        <?php if ($sexo === 'masculino'): ?>
                            <span class="pill pill-sexo-m">Masculino</span>
                        <?php elseif ($sexo === 'feminino'): ?>
                            <span class="pill pill-sexo-f">Feminino</span>
                        <?php else: ?>
                            <span class="pill pill-sexo-i">Indefinido</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="pill pill-idade">
                            <?= ucfirst($idade); ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($animal->getObs() ?? '–'); ?></td>
                    <td class="acoes-tabela">
                        <a href="index.php?rota=animais_editar&id=<?= $animal->getId(); ?>">Editar</a>
                        <a href="#"
                        class="deletar"
                        data-id="<?= $animal->getId(); ?>"
                        data-especie="<?= htmlspecialchars($animal->getEspecie(), ENT_QUOTES); ?>">
                            Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div id="modal-excluir" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    align-items:center;
    justify-content:center;
    z-index:999;
">
    <div style="
        background:#FFFFFF;
        border-radius:16px;
        padding:20px 22px;
        max-width:380px;
        width:90%;
        box-shadow:0 8px 20px rgba(0,0,0,0.25);
    ">
        <h3 style="margin-bottom:10px;color:#00462E;font-size:18px;">
            Confirmar exclusão
        </h3>
        <p id="modal-texto" style="font-size:14px;margin-bottom:16px;">
            Tem certeza que deseja excluir este registro?
        </p>
        <div style="display:flex;justify-content:flex-end;gap:10px;">
            <button type="button" id="btn-cancelar" class="btn-secundario">
                Cancelar
            </button>
            <a href="#" id="btn-confirmar" class="btn-primario">
                Excluir
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal      = document.getElementById('modal-excluir');
    const btnCancela = document.getElementById('btn-cancelar');
    const btnConfirma= document.getElementById('btn-confirmar');
    const texto      = document.getElementById('modal-texto');

    document.querySelectorAll('.deletar').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const id      = this.getAttribute('data-id');
            const especie = this.getAttribute('data-especie') || '';
            texto.textContent = 'Tem certeza que deseja excluir o animal #' + id +
                (especie ? ' (' + especie + ')?' : '?');

            btnConfirma.href = 'index.php?rota=animais_deletar&id=' + encodeURIComponent(id);
            modal.style.display = 'flex';
        });
    });

    btnCancela.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>


<?php require __DIR__ . '/../layout/footer.php'; ?>
