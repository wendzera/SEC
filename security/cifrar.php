<?php
require_once __DIR__ . '/criptografia.php';

$inputText = 'Teste';
$enc = cifrar($inputText);

echo 'Apos criptografia.: ' . $enc . '<br/>';
?>
