<?php
/**
 * criptografia.php — Cifra de Substituição (Cifra de César estendida)
 *
 * Este arquivo implementa uma CIFRA DE SUBSTITUIÇÃO SIMPLES,
 * um dos métodos mais antigos de criptografia.
 *
 * Como funciona:
 * - Cada caractere do texto original é substituído por outro caractere
 * - A substituição é feita com base em duas tabelas (CHARS e CHAVE)
 * - Para cifrar: encontra o caractere em CHARS e pega o correspondente em CHAVE
 * - Para decifrar: encontra o caractere em CHAVE e pega o correspondente em CHARS
 *
 * ATENÇÃO: Este tipo de cifra é FRACO e facilmente quebrado por análise de frequência.
 * É usado aqui apenas para fins EDUCATIVOS / estudo de fundamentos de criptografia.
 */

// Define a constante CHARS: alfabeto original com letras maiúsculas, minúsculas e números
// Esta é a tabela de ORIGEM — os caracteres do texto original
define('CHARS', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');

// Define a constante CHAVE: alfabeto INVERTIDO (Z→A, z→a, 9→0)
// Esta é a tabela de DESTINO — cada posição substitui o caractere de CHARS
// Exemplo: A (pos 0) → Z | B (pos 1) → Y | a (pos 26) → z | 0 (pos 62) → 9
define('CHAVE', 'ZYXWVUTSRQPONMLKJIHGFEDCBAzyxwvutsrqponmlkjihgfedcba9876543210');

/**
 * Função cifrar() — Transforma o texto original em texto cifrado
 *
 * Percorre cada caractere do texto, encontra sua posição na tabela CHARS
 * e substitui pelo caractere da mesma posição em CHAVE.
 *
 * Exemplo: "Abc" → "Zyx"
 *   A (pos 0 em CHARS) → Z (pos 0 em CHAVE)
 *   b (pos 27 em CHARS) → y (pos 27 em CHAVE)
 *   c (pos 28 em CHARS) → x (pos 28 em CHAVE)
 *
 * @param  string $m  Texto original a ser cifrado
 * @return string     Texto cifrado
 */
function cifrar($m)
{
    // $m = strtoupper($m); // Linha comentada: converteria tudo para maiúsculo antes de cifrar

    $cifrada = '';          // Variável que vai acumulando os caracteres cifrados
    $qtde = strlen($m);     // strlen() retorna o número de caracteres da string $m

    // Loop que percorre cada posição do texto caractere por caractere
    for ($i = 0; $i < $qtde; $i++) {
        $c = substr($m, $i, 1);          // Extrai 1 caractere na posição $i
        $posicao = strpos(CHARS, $c);    // Busca a posição desse caractere em CHARS
        $cifrada = $cifrada . substr(CHAVE, $posicao, 1); // Pega o substituto em CHAVE e concatena
    }

    return $cifrada; // Retorna o texto completamente cifrado
}

/**
 * Função decifrar() — Converte o texto cifrado de volta ao texto original
 *
 * Processo inverso ao cifrar(): percorre cada caractere do texto cifrado,
 * encontra sua posição na tabela CHAVE e substitui pelo caractere em CHARS.
 *
 * Exemplo: "Zyx" → "Abc"
 *   Z (pos 0 em CHAVE) → A (pos 0 em CHARS)
 *   y (pos 27 em CHAVE) → b (pos 27 em CHARS)
 *   x (pos 28 em CHAVE) → c (pos 28 em CHARS)
 *
 * @param  string $m  Texto cifrado
 * @return string     Texto original (decifrado)
 */
function decifrar($m)
{
    // $m = strtoupper($m); // Linha comentada: converteria tudo para maiúsculo antes de decifrar

    $decifrada = '';        // Variável que vai acumulando os caracteres decifrados
    $qtde = strlen($m);     // Obtém o comprimento do texto cifrado

    // Loop que percorre cada posição do texto cifrado
    for ($i = 0; $i < $qtde; $i++) {
        $c = substr($m, $i, 1);           // Extrai 1 caractere cifrado na posição $i
        $posicao = strpos(CHAVE, $c);     // Busca a posição desse caractere em CHAVE
        $decifrada = $decifrada . substr(CHARS, $posicao, 1); // Recupera o original de CHARS
    }

    return $decifrada; // Retorna o texto original recuperado
}
?>
