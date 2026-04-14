<?php
/**
 * Classe AES - Implementação de criptografia simétrica usando o algoritmo AES
 *
 * AES (Advanced Encryption Standard) é um algoritmo de criptografia SIMÉTRICA,
 * ou seja, a MESMA chave é usada tanto para cifrar quanto para decifrar os dados.
 * É o padrão de criptografia mais usado no mundo (bancos, HTTPS, etc.).
 *
 * Tamanhos de bloco suportados: 128, 192 ou 256 bits
 * Modos de operação: CBC, CFB, CTR, ECB, OFB, etc.
 */
class AES {

    protected $key;    // A chave secreta usada para cifrar e decifrar
    protected $data;   // Os dados (texto) que serão cifrados ou decifrados
    protected $method; // O método completo de criptografia (ex: "AES-128-CBC")

    /**
     * $options define comportamentos extras da função openssl_encrypt/decrypt:
     * - OPENSSL_RAW_DATA : retorna dados binários brutos (sem codificação base64)
     * - OPENSSL_ZERO_PADDING: não adiciona padding automático
     * - 0 (padrão): retorna base64 e usa padding PKCS7 automaticamente
     */
    protected $options = 0;

    /**
     * Construtor da classe — executado automaticamente ao criar um objeto AES
     *
     * @param $data      Texto a ser cifrado ou decifrado
     * @param $key       Chave secreta (deve ter 16, 24 ou 32 caracteres para AES-128, 192 e 256)
     * @param $blockSize Tamanho do bloco em bits: 128, 192 ou 256
     * @param $mode      Modo de operação (padrão: CBC - Cipher Block Chaining)
     */
    function __construct($data = null, $key = null, $blockSize = null, $mode = 'CBC') {
        $this->setData($data);           // Armazena os dados na propriedade $data
        $this->setKey($key);             // Armazena a chave na propriedade $key
        $this->setMethode($blockSize, $mode); // Monta o nome do método de criptografia
    }

    /**
     * Define os dados (texto) que serão processados
     * @param $data Texto plano ou texto cifrado
     */
    public function setData($data) {
        $this->data = $data; // Salva o texto na propriedade da classe
    }

    /**
     * Define a chave de criptografia
     * @param $key Chave secreta (string)
     */
    public function setKey($key) {
        $this->key = $key; // Salva a chave na propriedade da classe
    }

    /**
     * Monta o nome do método de criptografia no formato aceito pelo OpenSSL
     *
     * Combinações válidas de modo x tamanho de bloco:
     *   CBC            → 128, 192, 256 bits
     *   CBC-HMAC-SHA1  → 128, 256 bits  (NÃO suporta 192)
     *   CBC-HMAC-SHA256→ 128, 256 bits  (NÃO suporta 192)
     *   CFB / CFB1 / CFB8 → 128, 192, 256 bits
     *   CTR / ECB / OFB   → 128, 192, 256 bits
     *   XTS            → 128, 256 bits  (NÃO suporta 192)
     *
     * @param $blockSize Tamanho do bloco (128, 192 ou 256)
     * @param $mode      Modo de operação (padrão: CBC)
     */
    public function setMethode($blockSize, $mode = 'CBC') {
        // Verifica se o bloco de 192 bits foi escolhido com um modo incompatível
        if($blockSize == 192 && in_array('', array('CBC-HMAC-SHA1','CBC-HMAC-SHA256','XTS'))){
            $this->method = null; // Anula o método pois a combinação é inválida
            throw new Exception('Invlid block size and mode combination!'); // Lança erro
        }
        // Monta a string do método: exemplo → "AES-128-CBC"
        $this->method = 'AES-' . $blockSize . '-' . $mode;
    }

    /**
     * Valida se os parâmetros mínimos estão definidos antes de cifrar/decifrar
     * Retorna true se $data e $method não são nulos, false caso contrário
     */
    public function validateParams() {
        if ($this->data != null && $this->method != null) {
            return true;  // Parâmetros válidos: pode prosseguir
        } else {
            return FALSE; // Falta dado ou método: não pode prosseguir
        }
    }

    /**
     * Retorna o IV (Initialization Vector - Vetor de Inicialização)
     *
     * O IV é um valor aleatório usado para garantir que textos iguais
     * gerem textos cifrados DIFERENTES a cada vez.
     * IMPORTANTE: Para cifrar e decifrar, o IV deve ser o MESMO.
     *
     * Neste código está fixo em '1234567890123456' (16 caracteres = 128 bits),
     * o que facilita o uso mas NÃO é recomendado para produção (ideal: aleatório).
     */
    protected function getIV() {
        return '1234567890123456'; // IV fixo de 16 bytes (usado em ambiente de estudo)
        // Alternativa comentada - IV aleatório (mais seguro para produção):
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * Cifra (encripta) os dados usando AES via biblioteca OpenSSL do PHP
     *
     * openssl_encrypt(dados, método, chave, opções, IV)
     * - dados   : texto a ser cifrado ($this->data)
     * - método  : algoritmo (ex: "AES-128-CBC")
     * - chave   : chave secreta ($this->key)
     * - opções  : comportamento (0 = retorna base64)
     * - IV      : vetor de inicialização (getIV())
     *
     * trim() remove espaços/quebras de linha extras do resultado
     *
     * @return string Texto cifrado em formato Base64
     * @throws Exception se os parâmetros forem inválidos
     */
    public function encrypt() {
        if ($this->validateParams()) {
            // Chama o OpenSSL para cifrar e remove espaços desnecessários
            return trim(openssl_encrypt($this->data, $this->method, $this->key, $this->options, $this->getIV()));
        } else {
            throw new Exception('Invlid params!'); // Lança exceção se os dados forem inválidos
        }
    }

    /**
     * Decifra (desencripta) os dados usando AES via biblioteca OpenSSL do PHP
     *
     * openssl_decrypt(dados_cifrados, método, chave, opções, IV)
     * Mesmos parâmetros do encrypt — o IV DEVE ser idêntico ao usado na cifragem.
     *
     * @return string Texto original (decifrado)
     * @throws Exception se os parâmetros forem inválidos
     */
    public function decrypt() {
        if ($this->validateParams()) {
            // Chama o OpenSSL para decifrar o texto cifrado
            $ret = openssl_decrypt($this->data, $this->method, $this->key, $this->options, $this->getIV());
            return trim($ret); // Remove espaços/quebras de linha extras do resultado
        } else {
            throw new Exception('Invlid params!'); // Lança exceção se os dados forem inválidos
        }
    }
}
?>
