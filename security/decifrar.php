<?php
require_once __DIR__ . '/criptografia.php';

$inputText = '1OUdhPUr6mIcA8XPvcLQ/g==';
$dec = decifrar($inputText);

echo 'Apos da decifragem.: ' . $dec . '<br/>';
?>
