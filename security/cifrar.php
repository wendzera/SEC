<?php
/**
 * cifrar.php — Exemplo prático de CIFRAGEM com AES
 *
 * Este script demonstra como usar a classe AES para CIFRAR (encriptar) um texto.
 * O texto cifrado pode ser enviado de forma segura pela rede.
 */

include 'AES.php'; // Importa (inclui) o arquivo que contém a classe AES

// Texto que será cifrado (dado original / texto plano)
$inputText = "Teste";

// Chave secreta de 16 caracteres = 128 bits
// DEVE ser a mesma usada na decifragem, pois AES é criptografia SIMÉTRICA
$inputKey = "5131af7a19f7057b";

// Tamanho do bloco AES em bits
// AES-128 usa chaves de 16 bytes e blocos de 16 bytes
$blockSize = 128;

// Cria um objeto da classe AES passando:
// 1º argumento: texto a cifrar
// 2º argumento: chave secreta
// 3º argumento: tamanho do bloco (128 bits)
// O modo de operação padrão é CBC (Cipher Block Chaining)
$aes = new AES($inputText, $inputKey, $blockSize);

// Chama o método encrypt() que usa openssl_encrypt internamente
// O resultado é um texto cifrado codificado em Base64
// Ex: "1OUdhPUr6mIcA8XPvcLQ/g=="
$enc = $aes->encrypt();

// Exibe o texto cifrado na tela
// <br/> é a quebra de linha em HTML
echo "Apos criptografia.: " . $enc . "<br/>";
?>
