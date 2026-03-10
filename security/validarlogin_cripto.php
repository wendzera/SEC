<?php
require_once __DIR__ . '/criptografia.php';

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if ($usuario === '' || $senha === '') {
    exit('Informe usuario e senha.');
}

try {
    $usuario_cripto = cifrar($usuario);
    $senha_cripto = cifrar($senha);
} catch (Exception $e) {
    http_response_code(500);
    exit('Erro ao criptografar os dados de login: ' . $e->getMessage());
}

$url = 'http://192.168.100.234/cripto/post/aes/validarlogin.php';

$params = http_build_query(
    array(
        'usuario' => $usuario_cripto,
        'senha' => $senha_cripto,
    ),
    '',
    '&'
);

$ch = curl_init($url);

curl_setopt_array($ch, array(
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
    CURLOPT_TIMEOUT => 10,
));

$result = curl_exec($ch);

if ($result === false) {
    http_response_code(502);
    echo 'Erro ao enviar a requisicao: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

echo $result;
?>
