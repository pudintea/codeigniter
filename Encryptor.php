<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encryptor {
    private $key;

    public function __construct($config = []) {
        if (!extension_loaded('openssl')) {
            die('OpenSSL PHP extension is not enabled.');
        }

        // Gunakan key yang diberikan atau default key
        $this->key = isset($config['encryption_key']) ? $config['encryption_key'] : 'default_secure_key';
        
        // Pastikan panjang key sesuai (32 byte untuk AES-256)
        $this->key = hash('sha256', $this->key, true);
    }
    /**
     * Agar lebih rapi, tambahkan fungsi generateRandomKey() untuk membuat kode_decrypt_nik unik
     */
    public function generateRandomKey($length = 16) {
        return bin2hex(random_bytes($length / 2)); // Menghasilkan key acak
    }
    /**
     * Enkripsi teks menggunakan AES-256-CBC
     */
    public function encrypt($data, $password) {
        $iv = openssl_random_pseudo_bytes(16); // Generate IV 16 byte
        $key = hash('sha256', $password, true); // Hash password jadi 32 byte

        // Enkripsi data
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        // Gabungkan IV + Hasil enkripsi lalu encode ke base64
        return base64_encode($iv . $encrypted);
    }

    /**
     * Dekripsi teks menggunakan AES-256-CBC
     */
    public function decrypt($encryptedData, $password) {
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, 16); // Ambil IV 16 byte pertama
        $encryptedText = substr($data, 16);
        $key = hash('sha256', $password, true);

        // Dekripsi data
        return openssl_decrypt($encryptedText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}

// application/libraries/Encryptor.php
// Pudin Saepudin : pudin.alazhar@gmail.com

/**
class Test extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('encryptor', ['encryption_key' => 'my_secret_key']);
    }

    public function index() {
        $text = "Data rahasia ini perlu diamankan!";
        $password = "kode_akses"; // Password enkripsi

        // Enkripsi
        $encryptedText = $this->encryptor->encrypt($text, $password);
        echo "Hasil Enkripsi: " . $encryptedText . "<br>";

        // Dekripsi
        $decryptedText = $this->encryptor->decrypt($encryptedText, $password);
        echo "Hasil Dekripsi: " . $decryptedText;
    }
}
**/
