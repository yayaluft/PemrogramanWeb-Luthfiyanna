# RentCam - Sistem Informasi Penyewaan Alat Kamera

Aplikasi web manajemen penyewaan alat fotografi dan videografi berbasis PHP dan PostgreSQL/MySQL. Proyek ini dibangun sebagai bagian dari Praktikum Pemrograman Web (Jobsheet 7–11).

---

## 🔒 Fitur Keamanan (Jobsheet 11)

Aplikasi ini telah melalui proses audit dan peningkatan keamanan backend untuk mencegah berbagai celah keamanan web utama:

1. **Pencegahan SQL Injection**
   - Seluruh query database menggunakan **PDO Prepared Statements** (`:parameter`).
   - Tidak ada penggabungan string (*string concatenation*) langsung dari input pengguna ke dalam query SQL.

2. **Pencegahan Cross-Site Scripting (XSS)**
   - Menggunakan helper `e()` berbasis `htmlspecialchars()` dengan flag `ENT_QUOTES` dan encoding `UTF-8`.
   - Seluruh data dinamis yang dicetak ke tampilan HTML (termasuk flash message dan data tabel) di-escape secara otomatis.

3. **Pencegahan Cross-Site Request Forgery (CSRF)**
   - Implementasi per-session token acak berbasis kriptografi aman (`bin2hex(random_bytes(32))`).
   - Seluruh form bermetode `POST` dilengkapi tag `<input type="hidden">` via fungsi `csrf_field()`.
   - Pemrosesan data backend (`proses_*.php` dan `hapus.php`) mewajibkan verifikasi token via `csrf_verify()` menggunakan `hash_equals()`. Request ilegal tanpa token valid ditolak dengan status **HTTP 403 Forbidden**.

4. **Pencegahan Session Fixation**
   - Pembaruan Session ID otomatis menggunakan `session_regenerate_id(true)` tepat setelah proses otentikasi login berhasil.

5. **Validasi & Sanitasi Input**
   - Pembersihan input menggunakan `trim()`.
   - Validasi tipe data numerik (`is_numeric()`) dan *casting* tipe data eksplisit `(int)` / `(float)` pada variabel sensitif seperti `id` dan `tarif`.

---