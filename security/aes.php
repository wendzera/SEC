<?php
/**
 * Helper simples para criptografia AES com OpenSSL.
 *
 * Esta versao mantem a mesma combinacao de algoritmo/IV usada no projeto
 * original para preservar compatibilidade com o endpoint remoto ja esperado
 * pelo fluxo de login.
 */
class AES
{
    protected $key = null;
    protected $data = null;
    protected $method = null;
    protected $options = 0;
    protected $iv = '1234567890123456';

    /**
     * @param string|null $data
     * @param string|null $key
     * @param int|null    $blockSize
     * @param string      $mode
     */
    public function __construct($data = null, $key = null, $blockSize = 128, $mode = 'CBC')
    {
        $this->setData($data);
        $this->setKey($key);
        $this->setMethode($blockSize, $mode);
    }

    /**
     * @param string|null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param string|null $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Alias mantido por compatibilidade com o codigo antigo.
     *
     * Modos suportados pelo OpenSSL para AES:
     * CBC, CFB, CTR, ECB, OFB, XTS, entre outros.
     *
     * @param int    $blockSize
     * @param string $mode
     *
     * @throws Exception
     */
    public function setMethode($blockSize, $mode = 'CBC')
    {
        $this->setMethod($blockSize, $mode);
    }

    /**
     * @param int    $blockSize
     * @param string $mode
     *
     * @throws Exception
     */
    public function setMethod($blockSize, $mode = 'CBC')
    {
        $mode = strtoupper($mode);

        if ($blockSize == 192 && in_array($mode, array('CBC-HMAC-SHA1', 'CBC-HMAC-SHA256', 'XTS'), true)) {
            $this->method = null;
            throw new Exception('Combinacao invalida entre block size e modo.');
        }

        $method = 'AES-' . $blockSize . '-' . $mode;

        if (!in_array(strtolower($method), openssl_get_cipher_methods(), true)) {
            $this->method = null;
            throw new Exception('Metodo OpenSSL nao suportado: ' . $method);
        }

        $this->method = $method;
    }

    /**
     * @return bool
     */
    public function validateParams()
    {
        return $this->data !== null && $this->key !== null && $this->method !== null;
    }

    /**
     * O IV precisa ser identico entre cifragem e decifragem.
     * Esta implementacao mantem o IV fixo do projeto original.
     *
     * @return string
     */
    protected function getIV()
    {
        $ivLength = openssl_cipher_iv_length($this->method);
        return substr($this->iv, 0, $ivLength);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function encrypt()
    {
        if (!$this->validateParams()) {
            throw new Exception('Parametros invalidos para criptografia.');
        }

        $encrypted = openssl_encrypt(
            $this->data,
            $this->method,
            $this->key,
            $this->options,
            $this->getIV()
        );

        if ($encrypted === false) {
            throw new Exception('Falha ao criptografar com OpenSSL.');
        }

        return trim($encrypted);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function decrypt()
    {
        if (!$this->validateParams()) {
            throw new Exception('Parametros invalidos para descriptografia.');
        }

        $decrypted = openssl_decrypt(
            $this->data,
            $this->method,
            $this->key,
            $this->options,
            $this->getIV()
        );

        if ($decrypted === false) {
            throw new Exception('Falha ao descriptografar com OpenSSL.');
        }

        return trim($decrypted);
    }
}
?>
