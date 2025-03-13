Berikut adalah **libraries enkripsi dan dekripsi** untuk CodeIgniter 3 menggunakan **AES-256-CBC** dengan **password**.  

### **📌 Fitur:**
✅ Menggunakan **AES-256-CBC** (salah satu metode enkripsi terbaik).  
✅ Menggunakan **password** sebagai kunci enkripsi.  
✅ Menghasilkan **base64 string** yang mudah disimpan di database.  
✅ Menggunakan **OpenSSL** untuk keamanan yang lebih baik.  

---

## **📌 1. Buat File Libraries (application/libraries/Encryptor.php)**
Buat file di **`application/libraries/Encryptor.php`** dan isi dengan kode berikut:

```php
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
```

---

## **📌 2. Cara Menggunakan Library**
Di **Controller**, panggil library ini untuk **enkripsi & dekripsi**.

```php
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
```

---

## **📌 3. Penjelasan**
### **🔹 Keamanan**
- **AES-256-CBC** digunakan untuk enkripsi yang kuat.  
- **IV (Initialization Vector) acak** digunakan setiap kali enkripsi untuk menghindari pola yang sama.  
- **Password hashing menggunakan SHA-256** memastikan key tetap 32 byte.  

### **🔹 Keunggulan**
✅ Bisa menyimpan hasil enkripsi di database (karena base64).  
✅ Hanya bisa didekripsi dengan **password yang sama**.  
✅ Menggunakan OpenSSL yang sangat **efisien & aman**.  

---

Dengan library ini, data **terjamin aman** 🔒 dan bisa didekripsi hanya oleh pemilik **password**! 🚀
