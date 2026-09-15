# Wireframe & User Flow — SIMPUS-Mini
## Aktor
1. Tamu: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
2. Petugas: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku

```text
[Petugas login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Buku

```text
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login

```text
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|          [ Login Petugas ]           |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```text
+-----------------------------------------------------------------------+
| SIMPUS-Mini   Beranda | Buku | Anggota | Peminjaman   (Nama Petugas)  |X| |
|-----------------------------------------------------------------------|
|  [Total Buku]          [Total Anggota]          [Sedang Dipinjam]     |
|                                                                       |
|  Aksi Cepat:                                                          |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                           |
|                                                                       |
|  Transaksi Terbaru                                                    |
|  -------------------------------------------------------------------  |
|  Anggota            | Buku             | Tgl Pinjam   | Status        |
+-----------------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```text
+--------------------------------------+
|  Form Peminjaman Buku                |
|--------------------------------------|
|  Anggota : [ dropdown pilih anggota ]|
|  Buku    : [ dropdown, hanya stok>0 ]|
|  Tanggal Pinjam : [ auto: hari ini ] |
|                                      |
|          [  Simpan Peminjaman  ]     |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```text
+-------------------------------------------------+
|  Pengembalian Buku                              |
|-------------------------------------------------|
|  Cari transaksi aktif:                          |
|  [ nama anggota / judul buku _________________ ]|
|                                                 |
|  Anggota    | Buku      | Tgl Pinjam | Aksi     |
|  -----------+-----------+------------+----------|
|  Siti A.    | Pelangi   | 01/07      | [Kembali]|
+-------------------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```text
+-----------------------------------------------------+
|  Riwayat Peminjaman — Siti Aminah                   |
|-----------------------------------------------------|
|  Buku               | Pinjam   | Kembali  | Status  |
|  -------------------+----------+----------+---------|
|  Laskar Pelangi     | 01/07    | 10/07    | Selesai |
|  Bumi Manusia       | 15/07    | -        | Dipinjam|
+-----------------------------------------------------+
```