<?php
$login = $_POST['login'];
$senha = $_POST['senha'];

$senhaHash = sha1(string: $senha);

$db = pg_pconnect('host=localhost port=5432
	dbname=seg user=postgres
	password=123456') or die
	 ("Não foi possível conectar-se ao banco de dados...");

$sql = "SELECT * FROM usuarios WHERE 
login='$login' and senha='$senhaHash'";

$resultado = pg_query($db,$sql);
	
// Verifica se encontrou algum registro
if (pg_num_rows($resultado) == 1) {
	// O registro foi encontrado => o usuário é valido
	$row = pg_fetch_array($resultado);
	echo 'Seja bem vindo.: '.$row['nome']; 
} else {
// Nenhum registro foi encontrado => o usuário é inválido
	echo 'Login ou senha incorretos....';
}
?>		





