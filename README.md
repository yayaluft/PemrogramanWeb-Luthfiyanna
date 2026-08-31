# SIMPUS-Mini

## JOBSHEET 1
### Latihan Reflektif
1. Kenapa field "Alamat" dan "No. HP" tidak diberi required, sedangkan "Nama" dan "No. Anggota" diberi?
2. Apa yang akan terjadi (di browser) kalau kamu klik tombol "Simpan" tanpa mengisi field "Nama"? Coba buka filenya di browser dan praktikkan.
3. Form ini juga belum punya action pada tag <form>-nya — apa dampaknya saat tombol "Simpan" ditekan?

### Jawaban : 
1. Alasan field "Nama" dan "No. Anggota" diberi atribut required sementara "Alamat" dan "No. HP" tidak adalah karena nomor anggota berfungsi sebagai pengidentifikasi unik (Primary Key) dan nama merupakan identitas utama entitas, sehingga sistem tidak boleh membiarkan kedua data tersebut bernilai kosong. Sebaliknya, alamat dan nomor telepon diperlakukan sebagai informasi kontak pelengkap yang bersifat opsional agar pendaftaran anggota tetap dapat diproses meskipun data kontak belum lengkap.
2. Ketika tombol "Simpan" ditekan dalam kondisi field "Nama" masih kosong, browser akan langsung mencegat pengiriman form melalui mekanisme validasi bawaan HTML5, memfokuskan kursor kembali ke kolom nama, serta memunculkan pesan peringatan seperti "Please fill out this field" atau "Harap isi bidang ini" tanpa memuat ulang halaman.
3. Ketiadaan atribut action pada elemen form menyebabkan data dikirimkan kembali ke URL halaman yang sedang dibuka saat ini (self-submission). Dampaknya, ketika seluruh input wajib telah terisi dan tombol "Simpan" diklik, browser hanya akan me-refresh halaman tersebut dan mengembalikan nilai isian formulir ke kondisi semula, tanpa ada data yang tersimpan karena belum tersambung ke skrip pemroses di sisi server.