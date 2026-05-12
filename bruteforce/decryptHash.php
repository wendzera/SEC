<?php
for ($i= 180000; $i <=190000; $i++) {
	$senha = strval("$i");
    if (sha1($senha) == '8bba000fa1e4ad19829f5d1ec57de1df26931186') {
        echo 'descobri a senha = ' . $senha; 
		exit;		
    }
    echo 'Testando senha = ' . $i . '<br>';
}
?>

