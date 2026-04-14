<?php
/**
 * teste3.php — Teste de CIFRAGEM com múltiplas chaves (AES-128-CBC)
 *
 * Este arquivo demonstra uma característica fundamental do AES:
 * O MESMO texto cifrado com chaves DIFERENTES produz resultados COMPLETAMENTE DIFERENTES.
 *
 * Isso ilustra a importância da chave secreta na criptografia simétrica:
 * sem a chave correta, é impossível decifrar o conteúdo.
 */

include('aes.php'); // Importa a classe AES

// Texto original que será cifrado com cada uma das chaves
$texto = "Correto, ta blza...";

// Array (lista) com 5 chaves diferentes de 16 caracteres (128 bits)
// Cada chave irá gerar um resultado cifrado totalmente diferente
$chaves = [
    "54062b7e1b70b423", // Chave 1
    "1fefc2c0e23b9ffc", // Chave 2
    "63921de8b26cd36b", // Chave 3
    "dc5d521bee2df9d5", // Chave 4
    "1231badc39h9857e"  // Chave 5
];

// Loop foreach: percorre cada chave do array automaticamente
// A cada iteração, $chave recebe o valor de uma das chaves da lista
foreach ($chaves as $chave) {

    // Cria um novo objeto AES para cada chave
    // O texto é o mesmo, mas a chave muda a cada iteração
    $aes = new AES($texto, $chave, 128);

    // Cifra o texto com a chave atual
    // Mesmo texto + chave diferente = resultado cifrado totalmente diferente
    $resultado = $aes->encrypt();

    // Exibe a chave usada e o respectivo resultado cifrado
    // <br> é quebra de linha em HTML
    echo "Chave: $chave <br>";
    echo "Resultado: $resultado <br><br>";
}
?>
