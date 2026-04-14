<?php
/**
 * teste1.php — Teste simples de CIFRAGEM com AES-128-CBC
 *
 * Este arquivo serve para testar rapidamente se a classe AES
 * está funcionando corretamente ao cifrar um texto com uma chave.
 */

include('aes.php'); // Importa a classe AES

// Texto original que será cifrado (texto plano)
$texto = "Texto Cifrado...";

// Chave secreta de 16 caracteres (128 bits)
// Usada tanto para cifrar quanto para decifrar (criptografia simétrica)
$chave = "6121bc7a5557057c";

// Cria o objeto AES com o texto, a chave e o bloco de 128 bits
// O modo padrão de operação é CBC (Cipher Block Chaining)
$aes = new AES($texto, $chave, 128);

// Chama o método encrypt() para cifrar o texto
// O resultado é uma string em Base64 (ex: "r6CrYrpf...")
$resultado = $aes->encrypt();

// Exibe o resultado cifrado na tela
echo "Resultado: " . $resultado;
?>
