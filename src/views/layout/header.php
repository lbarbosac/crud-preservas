<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Preservas – CRUD Animais</title>
    <style>
        :root {
            --verde-escuro: #00462E;
            --verde-medio: #0B7D4B;
            --laranja: #FF7A1A;
            --creme: #FFF7E8;
            --branco: #FFFFFF;
            --cinza-claro: #F2F2F2;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        body { background: var(--creme); color: #1F1F1F; }
        a { text-decoration: none; color: inherit; }
        .topbar {
            background: var(--verde-escuro);
            color: var(--branco);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-text {
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: 14px;
        }
        .nav-links a {
            margin-left: 16px;
            font-size: 14px;
            padding: 6px 10px;
            border-radius: 20px;
            border: 1px solid transparent;
        }
        .nav-links a:hover {
            border-color: var(--laranja);
            background: rgba(255,255,255,0.06);
        }
        .btn-primario {
            background: var(--laranja);
            color: var(--branco);
            border-radius: 999px;
            padding: 8px 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .btn-primario:hover { opacity: 0.92; }
        .btn-secundario {
            background: var(--branco);
            color: var(--verde-escuro);
            border-radius: 999px;
            padding: 7px 14px;
            font-weight: 600;
            border: 1px solid var(--verde-escuro);
            cursor: pointer;
        }
        .container {
            max-width: 960px;
            margin: 24px auto;
            padding: 0 16px 24px;
        }
        .card {
            background: var(--branco);
            border-radius: 18px;
            padding: 20px 22px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.08);
            margin-bottom: 18px;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--verde-escuro);
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            background: var(--verde-medio);
            color: var(--branco);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--cinza-claro);
            font-size: 14px;
        }
        th { text-align: left; color: var(--verde-escuro); }
        tr:hover td { background: #FAFAFA; }
        .pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }
        .pill-sexo-m { background: rgba(11,125,75,.1); color: var(--verde-medio); }
        .pill-sexo-f { background: rgba(255,122,26,.12); color: #D05200; }
        .pill-sexo-i { background: #E0E0E0; color: #555; }
        .pill-idade { background: #FFF0D6; color: #C16600; }
        .alert {
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .alert-erro { background: #FFE2E0; color: #972021; }
        .alert-sucesso { background: #E0F5EA; color: #11693C; }
        form .campo {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        label { font-size: 14px; font-weight: 600; color: var(--verde-escuro); }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            padding: 9px 10px;
            border-radius: 10px;
            border: 1px solid #CED4DA;
            font-size: 14px;
        }
        textarea { resize: vertical; min-height: 70px; }
        .acoes-tabela a {
            margin-right: 8px;
            font-size: 13px;
            color: var(--verde-medio);
        }
        .acoes-tabela a.deletar { color: #C62828; }
        .grid-auth {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
            gap: 18px;
            align-items: center;
        }
        .hero-auth {
            background: var(--verde-escuro);
            color: var(--branco);
            border-radius: 18px;
            padding: 22px 20px;
        }
        .hero-auth h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .hero-auth p {
            font-size: 14px;
            opacity: .9;
        }
        @media (max-width: 768px) {
            .grid-auth { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="logo-text">
        PRESERVAS · Registro de Animais
    </div>
    <nav class="nav-links">
        <?php if (!empty($_SESSION['usuario_id'])): ?>
            <a href="index.php">Animais</a>
            <span style="font-size:13px;opacity:.9;">
                Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']); ?></strong>
            </span>
            <a href="index.php?rota=logout" class="btn-secundario">Sair</a>
        <?php else: ?>
            <a href="index.php?rota=login" class="btn-primario">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">
