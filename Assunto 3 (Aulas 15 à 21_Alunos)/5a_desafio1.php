<?php
/**
 * Verificação de acesso por idade
 * -------------------------------
 * 1. Exibe um formulário com "Nome" e "Ano de Nascimento".
 * 2. No envio, calcula a idade a partir do ano informado.
 * 3. Idade >= 18  -> "Acesso permitido" + registro em log_acessos.txt
 * 4. Idade <  18  -> "Acesso negado"
 */
 
const ARQUIVO_LOG   = __DIR__ . '/log_acessos.txt';
const IDADE_MINIMA  = 18;
 
$nome        = '';
$anoNasc     = '';
$idade       = null;
$permitido   = false;
$enviado     = false;
$erro        = '';
$erroLog     = '';
$anoAtual    = (int) date('Y');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enviado  = true;
    $nome     = trim($_POST['nome'] ?? '');
    $anoNasc  = trim($_POST['ano_nascimento'] ?? '');
 
    if ($nome === '') {
        $erro = 'Informe o nome.';
    } elseif (!ctype_digit($anoNasc)) {
        $erro = 'O ano de nascimento deve conter apenas números (ex.: 1998).';
    } elseif ((int) $anoNasc < 1900 || (int) $anoNasc > $anoAtual) {
        $erro = "Informe um ano entre 1900 e {$anoAtual}.";
    } else {
        $idade     = $anoAtual - (int) $anoNasc;
        $permitido = $idade >= IDADE_MINIMA;
 
        if ($permitido) {
            $linha = sprintf(
                "[%s] Nome: %s | Idade: %d%s",
                date('d/m/Y H:i:s'),
                $nome,
                $idade,
                PHP_EOL
            );
 
            if (file_put_contents(ARQUIVO_LOG, $linha, FILE_APPEND | LOCK_EX) === false) {
                $erroLog = 'O acesso foi liberado, mas não foi possível gravar em log_acessos.txt. '
                         . 'Verifique a permissão de escrita na pasta.';
            }
        }
    }
}
 
/** Escapa a saída para evitar injeção de HTML. */
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verificação de acesso</title>
<style>
    :root {
        --tinta:      #1d2530;
        --papel:      #e9ebe6;
        --superficie: #ffffff;
        --borda:      #c9ccc4;
        --liberado:   #2f5d50;
        --negado:     #8c2f39;
    }
 
    * { box-sizing: border-box; }
 
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: var(--papel);
        color: var(--tinta);
        font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        line-height: 1.5;
    }
 
    main {
        width: 100%;
        max-width: 420px;
        background: var(--superficie);
        border: 1px solid var(--borda);
        padding: 32px;
    }
 
    h1 {
        margin: 0 0 4px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 1.75rem;
        font-weight: 600;
        letter-spacing: -0.01em;
    }
 
    .subtitulo {
        margin: 0 0 28px;
        font-size: 0.9rem;
        color: #5a6270;
    }
 
    label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }
 
    input {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border: 1px solid var(--borda);
        background: #fbfbfa;
        font: inherit;
        color: inherit;
    }
 
    input:focus {
        outline: 2px solid var(--tinta);
        outline-offset: 1px;
    }
 
    button {
        width: 100%;
        padding: 12px;
        border: none;
        background: var(--tinta);
        color: #fff;
        font: inherit;
        font-weight: 600;
        cursor: pointer;
    }
 
    button:hover { background: #2c3949; }
 
    .resultado {
        margin-top: 26px;
        padding: 16px 18px;
        border-left: 4px solid var(--borda);
        background: #f6f7f5;
    }
 
    .resultado p { margin: 0; }
 
    .resultado .mensagem {
        font-family: Georgia, "Times New Roman", serif;
        font-size: 1.15rem;
    }
 
    .resultado .detalhe {
        margin-top: 6px;
        font-size: 0.85rem;
        color: #5a6270;
    }
 
    .liberado { border-left-color: var(--liberado); }
    .liberado .mensagem { color: var(--liberado); }
 
    .negado { border-left-color: var(--negado); }
    .negado .mensagem { color: var(--negado); }
 
    .erro {
        margin-top: 26px;
        padding: 12px 14px;
        border-left: 4px solid var(--negado);
        background: #faf1f1;
        font-size: 0.9rem;
    }
</style>
</head>
<body>
<main>
    <h1>Verificação de acesso</h1>
    <p class="subtitulo">Liberado para maiores de <?= IDADE_MINIMA ?> anos.</p>
 
    <form method="post" novalidate>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= e($nome) ?>" required>
 
        <label for="ano_nascimento">Ano de nascimento</label>
        <input type="number" id="ano_nascimento" name="ano_nascimento"
               value="<?= e($anoNasc) ?>" min="1900" max="<?= $anoAtual ?>"
               placeholder="<?= $anoAtual - 25 ?>" required>
 
        <button type="submit">Verificar acesso</button>
    </form>
 
<?php if ($enviado && $erro !== ''): ?>
    <p class="erro"><?= e($erro) ?></p>
<?php elseif ($enviado && $idade !== null): ?>
    <div class="resultado <?= $permitido ? 'liberado' : 'negado' ?>">
        <p class="mensagem">
            <?= $permitido
                ? 'Acesso permitido, ' . e($nome) . '!'
                : 'Acesso negado, ' . e($nome) . '!' ?>
        </p>
        <p class="detalhe">
            Idade: <?= $idade ?> anos.
            <?= $permitido && $erroLog === '' ? 'Registro salvo em log_acessos.txt.' : '' ?>
        </p>
    </div>
    <?php if ($erroLog !== ''): ?>
        <p class="erro"><?= e($erroLog) ?></p>
    <?php endif; ?>
<?php endif; ?>
</main>
</body>
</html>