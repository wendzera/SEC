<!--
    index.php — Página de Login com envio seguro via criptografia AES

    Este arquivo é a INTERFACE (frontend) do sistema de login.
    O formulário coleta usuário e senha e envia via POST para
    o arquivo validarlogin_cripto.php, que irá cifrar os dados
    com AES antes de enviá-los ao servidor de validação.
-->

<html>
<head>
<title>Sistema de Login</title>
<!-- Define o charset da página para ISO-8859-1 (suporte a acentos em português) -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<!-- Links/scripts comentados que poderiam ser usados para estilo e jQuery -->
<!--link rel="stylesheet" type="text/css" href="estilo.css"/>
<script src="jquery.js" type="text/javascript" language="javascript"></script-->

<!-- Estilos CSS internos para formatação visual da página -->
<style type="text/css">

/* Estilo base do corpo da página: fonte Verdana, tamanho 11px */
body {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 11px;
}

/* Classe para o topo do formulário com margem inferior */
.top {
    margin-bottom: 15px;
}

/* Classe para a div que contém o botão, com margem superior */
.buttondiv {
    margin-top: 10px;
}

/* Caixa de mensagem genérica: borda amarela, fundo amarelo claro */
.messagebox {
    position: absolute;
    width: 100px;
    margin-left: 30px;
    border: 1px solid #c93;
    background: #ffc;
    padding: 3px;
}

/* Caixa de mensagem de SUCESSO: borda verde, fundo verde claro, texto verde */
.messageboxok {
    position: absolute;
    width: auto;
    margin-left: 30px;
    border: 1px solid #349534;
    background: #C9FFCA;
    padding: 3px;
    font-weight: bold;
    color: #008000;
}

/* Caixa de mensagem de ERRO: borda vermelha, fundo vermelho claro, texto vermelho */
.messageboxerror {
    position: absolute;
    width: auto;
    margin-left: 30px;
    border: 1px solid #CC0000;
    background: #F7CBCA;
    padding: 3px;
    font-weight: bold;
    color: #CC0000;
}
</style>
</head>
<body>

<!-- Três quebras de linha para dar espaço no topo da página -->
<br>
<br>
<br>

<!-- Div central que agrupa todo o conteúdo de login -->
<div id="demos" align="center">

    <!-- Título principal da página -->
    <h2 align="center">Sistema de Login...</h2>
    <br clear="all" /><br clear="all" />

    <!-- Container do formulário -->
    <div id="s4">
        <div class="form" id="first">

            <!--
                FORMULÁRIO DE LOGIN
                - name="form"   : nome do formulário
                - method="POST" : envia os dados no corpo da requisição HTTP (não visível na URL)
                - action="validarlogin_cripto.php" : arquivo PHP que recebe e processa os dados
                - id="login_form": identificador único do formulário (usado por CSS/JS)
            -->
            <form name="form" method="POST" action="validarlogin_cripto.php" id="login_form">

                <br clear="all" />
                <!-- Instrução ao usuário -->
                <div class="heading" style="width:183px;">Insira os dados e clique em entrar...</div>
                <br clear="all" /><br clear="all" />

                <!-- Campo de texto para o USUÁRIO -->
                <!-- type="text"     : campo de texto visível -->
                <!-- name="usuario"  : nome do campo enviado via POST -->
                <!-- maxlength="20"  : limita a 20 caracteres digitados -->
                <div style="margin-top:5px">
                    Usuario..: <input name="usuario" type="text" id="usuario" value="" maxlength="20" />
                </div>

                <!-- Campo de senha — os caracteres digitados aparecem como pontos/asteriscos -->
                <!-- type="password" : oculta os caracteres na tela para segurança -->
                <!-- name="senha"    : nome do campo enviado via POST -->
                <div style="margin-top:5px">
                    Senha....: <input name="senha" type="password" id="senha" value="" maxlength="20" />
                </div>

                <br>

                <!-- Botão de envio do formulário -->
                <!-- type="submit" : ao clicar, envia os dados do formulário para o action -->
                <!-- value="Entrar": texto exibido no botão -->
                <input name="enviar" type="submit" id="enviar" value="Entrar">

            </form>
        </div>
    </div>
</div>
</body>
</html>
