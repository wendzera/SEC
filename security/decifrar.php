<?php
/**
 * decifrar.php — Exemplo prático de DECIFRAGEM com AES
 *
 * Este script demonstra como usar a classe AES para DECIFRAR (desencriptar) um texto
 * que foi previamente cifrado com AES-128-CBC.
 *
 * IMPORTANTE: Para decifrar corretamente é necessário usar:
 * - A MESMA chave usada na cifragem
 * - O MESMO algoritmo (AES-128-CBC)
 * - O MESMO IV (vetor de inicialização) — neste projeto está fixo em '1234567890123456'
 */

include 'AES.php'; // Importa o arquivo que contém a definição da classe AES

// Texto cifrado em Base64 que será decifrado
// Este valor foi gerado pelo script cifrar.php com a mesma chave abaixo
// O formato Base64 usa caracteres A-Z, a-z, 0-9, +, / e = (padding)
$inputText = "1OUdhPUr6mIcA8XPvcLQ/g==";

// Chave secreta de 16 caracteres = 128 bits
// DEVE SER IDÊNTICA à chave usada durante a cifragem (criptografia simétrica)
$inputKey = "5131af7a19f7057b";

// Tamanho do bloco AES em bits (deve ser o mesmo da cifragem)
$blockSize = 128;

// Cria um objeto da classe AES passando:
// 1º argumento: texto cifrado (em Base64) a ser decifrado
// 2º argumento: chave secreta (a mesma usada para cifrar)
// 3º argumento: tamanho do bloco (128 bits)
$aes = new AES($inputText, $inputKey, $blockSize);

// Chama o método decrypt() que usa openssl_decrypt internamente
// O resultado é o texto original recuperado
$dec = $aes->decrypt();

// Exibe o texto decifrado na tela
// Deve mostrar o valor original antes da cifragem (ex: "Teste")
echo "Apos da decifragem.: " . $dec . "<br/>";
?>
