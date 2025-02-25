Karena Anda menggunakan **Cloudflare Tunneling** dan domain sudah menggunakan **HTTPS**, tetapi `base_url` di CodeIgniter masih mengarah ke **HTTP**, kemungkinan besar masalahnya adalah Cloudflare tidak meneruskan informasi HTTPS dengan benar ke server Anda.

### **Solusi 1: Gunakan `$_SERVER['HTTP_X_FORWARDED_PROTO']`**
Cloudflare mengirimkan protokol asli melalui header `HTTP_X_FORWARDED_PROTO`. Anda bisa memodifikasi `base_url` seperti ini:

```php
$config['base_url'] = ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
```

**Penjelasan:**
- `$_SERVER['HTTP_X_FORWARDED_PROTO']` digunakan untuk mendeteksi apakah request asli menggunakan HTTPS atau HTTP.
- Jika `HTTP_X_FORWARDED_PROTO` bernilai **"https"**, maka `base_url` akan menggunakan **HTTPS**.

---

### **Solusi 2: Paksa HTTPS di CodeIgniter**
Jika Anda ingin memastikan bahwa `base_url` selalu menggunakan **HTTPS**, langsung atur secara manual di `config.php`:

```php
$config['base_url'] = "https://yourdomain.com/";
```

Gantilah `yourdomain.com` dengan domain asli Anda.

---

### **Solusi 3: Konfigurasi `.htaccess`**
Jika masalah masih terjadi, pastikan server Anda memaksa penggunaan HTTPS. Tambahkan aturan ini di file `.htaccess`:

```apache
RewriteEngine On
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
```

---

### **Solusi 4: Konfigurasi Cloudflare**
1. **Masuk ke Cloudflare Dashboard**.
2. Pilih domain Anda.
3. Buka **SSL/TLS > Overview**.
4. Pastikan mode SSL/TLS **Full** atau **Full (Strict)**.
5. Buka **SSL/TLS > Edge Certificates** dan aktifkan **"Always Use HTTPS"**.

---

### **Kesimpulan**
- **Solusi 1** paling aman karena tetap mendukung HTTP jika dibutuhkan.
- **Solusi 2** lebih sederhana, tetapi tidak fleksibel jika Anda menjalankan aplikasi di berbagai lingkungan.
- **Solusi 3 & 4** membantu memastikan Cloudflare dan server selalu menggunakan HTTPS.

Coba solusi di atas, dan beri tahu saya jika masih ada masalah! 🚀
