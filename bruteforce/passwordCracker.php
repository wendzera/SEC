<?php
@set_time_limit(0);

$hashPadrao = '20a0b2a324683255da877035ee93175fdbf2548a';
$hashAlvo = $_GET['hash'] ?? ($argv[1] ?? $hashPadrao);
$hashAlvo = strtolower(trim($hashAlvo));
$anoInicial = 1900;
$anoFinal = intval(date('Y'));
$datasTestadas = [];
$tentativas = 0;

if (!preg_match('/^[a-f0-9]{40}$/', $hashAlvo)) {
    echo ' 9f5e79d3239f8b26da2b3899eaae0243efc218ca';
    exit;
}

function testarSenha($senha, $hashAlvo, &$tentativas)
{
    $tentativas++;

    if (sha1($senha) === $hashAlvo) {
        echo 'Descobri a senha = ' . $senha . '<br>';
        echo 'Tentativas realizadas = ' . $tentativas;
        exit;
    }

    return false;
}

for ($ano = $anoInicial; $ano <= $anoFinal; $ano++) {
    for ($mes = 1; $mes <= 12; $mes++) {
        for ($dia = 1; $dia <= 31; $dia++) {
            if (!checkdate($mes, $dia, $ano)) {
                continue;
            }

            $diaFormatado = str_pad(strval($dia), 2, '0', STR_PAD_LEFT);
            $mesFormatado = str_pad(strval($mes), 2, '0', STR_PAD_LEFT);
            $senhas = [
                $diaFormatado . $mesFormatado . $ano,
                $mesFormatado . $diaFormatado . $ano,
                $ano . $mesFormatado . $diaFormatado,
            ];

            foreach ($senhas as $senha) {
                if (isset($datasTestadas[$senha])) {
                    continue;
                }

                $datasTestadas[$senha] = true;
                testarSenha($senha, $hashAlvo, $tentativas);
            }
        }
    }
}

for ($i = 0; $i <= 99999999; $i++) {
    $senha = str_pad(strval($i), 8, '0', STR_PAD_LEFT);

    if (isset($datasTestadas[$senha])) {
        continue;
    }

    testarSenha($senha, $hashAlvo, $tentativas);
}

echo 'Senha nao encontrada.<br>';
echo 'Tentativas realizadas = ' . $tentativas;
?>
