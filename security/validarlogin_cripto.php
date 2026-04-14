<?php
/**
 * validarlogin_cripto.php — Validação de Login com Criptografia AES + Transmissão via cURL
 *
 * Este script recebe os dados do formulário de login (index.php),
 * CIFRA o usuário e a senha usando AES-128-CBC,
 * e envia os dados cifrados para um servidor remoto via requisição HTTP POST (cURL).
 *
 * Fluxo completo:
 *   index.php → envia usuário/senha em texto plano (via POST local)
 *   validarlogin_cripto.php → cifra com AES → envia cifrado via cURL para outro servidor
 *   Servidor remoto (validarlogin.php) → decifra e valida as credenciais
 *
 * Isso garante que as credenciais não trafeguem em texto puro pela rede.
 */

include('aes.php'); // Importa a classe AES para uso neste arquivo

// Recebe os dados enviados pelo formulário HTML via método POST
// $_POST é um array superglobal do PHP que contém os campos do formulário
$usuario = $_POST['usuario']; // Captura o campo "usuario" enviado pelo formulário
$senha   = $_POST['senha'];   // Captura o campo "senha" enviado pelo formulário

// Chave secreta compartilhada de 16 caracteres (128 bits)
// Esta chave deve ser IGUAL no cliente (aqui) e no servidor que vai decifrar
$chave = "5131af7a19f7057b";

// ─── CIFRAGEM DO USUÁRIO ───────────────────────────────────────────────────────

// Cria um objeto AES para cifrar o nome de usuário
// Parâmetros: dado, chave, tamanho do bloco (128 bits), modo padrão (CBC)
$aesUsuario = new AES($usuario, $chave, 128);

// encrypt() cifra o texto e retorna em Base64
// base64_encode() garante que o resultado possa ser enviado como parâmetro de URL
// (Base64 evita problemas com caracteres especiais como +, /, = na URL)
$usuario_cripto = base64_encode($aesUsuario->encrypt());

// ─── CIFRAGEM DA SENHA ────────────────────────────────────────────────────────

// Mesmo processo para a senha
$aesSenha = new AES($senha, $chave, 128);
$senha_cripto = base64_encode($aesSenha->encrypt());

// ─── ENVIO VIA cURL ───────────────────────────────────────────────────────────

# URL do servidor remoto que irá RECEBER e VALIDAR as credenciais cifradas
# Em produção, esta URL deveria usar HTTPS para mais segurança
$url = 'http://192.168.103.29/cripto/aes/validarlogin.php';

// Inicializa uma sessão cURL apontando para a URL de destino
// cURL é uma biblioteca do PHP para fazer requisições HTTP a outros servidores
$ch = curl_init($url);

// Monta a string de parâmetros POST com os dados cifrados
// Formato: "campo1=valor1&campo2=valor2"
$params = "usuario=$usuario_cripto&senha=$senha_cripto";

// Configura as opções da requisição cURL:

// CURLOPT_POST = 1 → indica que a requisição será do tipo POST (envia dados no corpo)
curl_setopt($ch, CURLOPT_POST, 1);

// CURLOPT_POSTFIELDS → define o corpo da requisição com os parâmetros cifrados
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

// CURLOPT_RETURNTRANSFER = true → faz o cURL retornar a resposta como string
// (sem isso, a resposta seria impressa diretamente na tela)
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição HTTP POST e armazena a resposta do servidor remoto
$result = curl_exec($ch);

// Exibe a resposta recebida do servidor remoto
// Pode conter mensagens como "Login bem-sucedido" ou "Usuário/senha inválidos"
print_r($result);

// Fecha e libera os recursos da sessão cURL (boa prática para liberar memória)
curl_close($ch);
?>
