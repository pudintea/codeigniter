
## **📌 Skema Implementasi Enkripsi & Dekripsi, DB MySQL**  
Kita akan menerapkan **AES-256-CBC** untuk mengenkripsi **NIK**, serta menyimpan **kode_decrypt_nik** sebagai password unik untuk setiap entri.  

---
### **📌 1. Struktur Tabel MySQL**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255),
    nik TEXT,
    tanggal_lahir DATE,
    tempat_lahir VARCHAR(255),
    email VARCHAR(255),
    kode_decrypt_nik VARCHAR(255)
);
```
- **`nik`** → Disimpan dalam keadaan **terenkripsi**  
- **`kode_decrypt_nik`** → Disimpan untuk **mendekripsi NIK**  

---
### **📌 2. Modifikasi Library Encryptor**
Agar lebih rapi, tambahkan fungsi `generateRandomKey()` untuk membuat kode_decrypt_nik unik.  

📌 **Buka `application/libraries/Encryptor.php` dan tambahkan:**
```php
public function generateRandomKey($length = 16) {
    return bin2hex(random_bytes($length / 2)); // Menghasilkan key acak
}
```

---
### **📌 3. Buat Model (application/models/User_model.php)**
📌 **Membuat model untuk menyimpan data ke database:**
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->library('encryptor', ['encryption_key' => 'my_secret_key']);
    }

    public function save_user($data) {
        // Buat kode unik untuk decrypt
        $kode_decrypt_nik = $this->encryptor->generateRandomKey(16);

        // Enkripsi NIK sebelum disimpan
        $encrypted_nik = $this->encryptor->encrypt($data['nik'], $kode_decrypt_nik);

        // Simpan ke database
        $insert_data = [
            'nama_lengkap'     => $data['nama_lengkap'],
            'nik'              => $encrypted_nik,
            'tanggal_lahir'    => $data['tanggal_lahir'],
            'tempat_lahir'     => $data['tempat_lahir'],
            'email'            => $data['email'],
            'kode_decrypt_nik' => $kode_decrypt_nik
        ];

        return $this->db->insert('users', $insert_data);
    }

    public function get_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        $user = $query->row_array();

        if ($user) {
            // Dekripsi NIK
            $user['nik'] = $this->encryptor->decrypt($user['nik'], $user['kode_decrypt_nik']);
        }
        return $user;
    }
}
```
---
### **📌 4. Buat Controller (application/controllers/User.php)**
📌 **Membuat controller untuk menyimpan & menampilkan data user**
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function save() {
        $data = [
            'nama_lengkap'  => $this->input->post('nama_lengkap'),
            'nik'           => $this->input->post('nik'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'tempat_lahir'  => $this->input->post('tempat_lahir'),
            'email'         => $this->input->post('email')
        ];

        if ($this->User_model->save_user($data)) {
            echo "Data berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data.";
        }
    }

    public function show($id) {
        $user = $this->User_model->get_user($id);
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
}
```
---
### **📌 5. Buat Form Input Data**
📌 **Buat file di `application/views/form_user.php`**
```html
<form action="<?= base_url('user/save') ?>" method="post">
    <label>Nama Lengkap:</label>
    <input type="text" name="nama_lengkap" required><br>

    <label>NIK:</label>
    <input type="text" name="nik" required><br>

    <label>Tanggal Lahir:</label>
    <input type="date" name="tanggal_lahir" required><br>

    <label>Tempat Lahir:</label>
    <input type="text" name="tempat_lahir" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <button type="submit">Simpan</button>
</form>
```
---
### **📌 6. Uji Coba**
1. **Jalankan form** di browser:  
   ```
   http://localhost/namaproject/index.php/user/form
   ```
2. **Cek database** apakah **NIK sudah terenkripsi**  
3. **Tampilkan data terdekripsi** dengan membuka:
   ```
   http://localhost/namaproject/index.php/user/show/1
   ```
---

### **📌 7. Kesimpulan**
✅ **NIK otomatis terenkripsi saat disimpan**  
✅ **Kode unik decrypt disimpan & digunakan saat dekripsi**  
✅ **Aman karena menggunakan AES-256-CBC dengan IV unik**  

Dengan sistem ini, **NIK di database tetap aman**, tetapi masih bisa diakses jika perlu. 🚀
