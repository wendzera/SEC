<?php
/**
 * teste2.php — Teste simples de DECIFRAGEM com AES-128-CBC
 *
 * Este arquivo serve para testar rapidamente se a classe AES
 * está corretamente decifrado um texto que foi previamente cifrado.
 *
 * ATENÇÃO: Para decifrar com sucesso:
 * - O texto de entrada deve ser o resultado de um encrypt() com a MESMA chave
 * - A chave usada aqui DEVE ser idêntica à usada na cifragem
 * - O IV interno também deve ser o mesmo (neste projeto está fixo)
 */

include('aes.php'); // Importa a classe AES

// Texto cifrado em Base64 que será decifrado
// Este valor é o resultado de um encrypt() feito com a chave abaixo
$texto = "r6CrYrpfPWyab5C0ZYG8QfKoAzF/w9DfdcN834YAr84=";

// Chave secreta de 16 caracteres (128 bits)
// DEVE SER A MESMA usada durante a cifragem para recuperar o texto original
$chave = "9871babc39h8857e";

// Cria o objeto AES com o texto cifrado, a chave e o bloco de 128 bits
$aes = new AES($texto, $chave, 128);

// Chama o método decrypt() para decifrar e recuperar o texto original
$resultado = $aes->decrypt();

// Exibe o texto original recuperado
echo "Resultado: " . $resultado;
?>
