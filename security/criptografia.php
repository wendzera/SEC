<?php
require_once __DIR__ . '/aes.php';

define('AES_KEY', '5131af7a19f7057b');
define('AES_BLOCK_SIZE', 128);
define('AES_MODE', 'CBC');

/**
 * Mantem o nome da funcao antiga para evitar mudar o restante do sistema,
 * mas agora a cifra utilizada e AES.
 *
 * @param string $mensagem
 * @return string
 * @throws Exception
 */
function cifrar($mensagem)
{
    if ($mensagem === null || $mensagem === '') {
        return '';
    }

    $aes = new AES($mensagem, AES_KEY, AES_BLOCK_SIZE, AES_MODE);
    return $aes->encrypt();
}

/**
 * @param string $mensagem
 * @return string
 * @throws Exception
 */
function decifrar($mensagem)
{
    if ($mensagem === null || $mensagem === '') {
        return '';
    }

    $aes = new AES($mensagem, AES_KEY, AES_BLOCK_SIZE, AES_MODE);
    return $aes->decrypt();
}
?>
