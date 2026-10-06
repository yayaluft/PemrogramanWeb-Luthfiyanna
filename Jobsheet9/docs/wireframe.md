# Wireframe & User Flow — RentCam
## Aktor
1. Tamu: hanya bisa melihat katalog alat (Beranda, Daftar Alat) tanpa login.
2. Petugas: login untuk mengakses seluruh fitur CRUD dan transaksi penyewaan.

## User Flow — Penyewaan Alat

```text
[Petugas login] -> [Dashboard] -> [Pilih menu "Sewa Baru"]
        -> [Pilih Pelanggan] -> [Pilih Alat (stok > 0)]
        -> [Simpan] -> [Stok alat berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Alat

```text
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (pelanggan/alat)]
        -> [Tandai "Dikembalikan"] -> [Stok alat bertambah 1]
        -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login

```text
+--------------------------------------+
|               RentCam                |
|--------------------------------------|
|                                      |
|          [ Login Petugas ]           |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Hubungi Admin    |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```text
+-----------------------------------------------------------------------+
| RentCam   Beranda | Alat | Pelanggan | Rental         (Nama Petugas)  |X| |
|-----------------------------------------------------------------------|
|  [Total Alat]          [Total Pelanggan]       [Sedang Disewa]        |
|                                                                       |
|  Aksi Cepat:                                                          |
|  [ + Sewa Baru ]         [ + Pengembalian ]                           |
|                                                                       |
|  Transaksi Terbaru                                                    |
|  -------------------------------------------------------------------  |
|  Pelanggan          | Alat             | Tgl Sewa     | Status        |
+-----------------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```text
+--------------------------------------+
|  Form Penyewaan Alat                 |
|--------------------------------------|
|  Pelanggan : [ dropdown pilih nama ] |
|  Alat      : [ dropdown, hanya stok>0]|
|  Tanggal Sewa : [ auto: hari ini ]   |
|                                      |
|          [    Simpan Sewa    ]       |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```text
+-------------------------------------------------+
|  Pengembalian Alat                              |
|-------------------------------------------------|
|  Cari transaksi aktif:                          |
|  [ nama pelanggan / nama alat ________________ ]|
|                                                 |
|  Pelanggan  | Alat      | Tgl Sewa   | Aksi     |
|  -----------+-----------+------------+----------|
|  Bagas P.   | Sony A7   | 01/09      | [Kembali]|
+-------------------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```text
+-----------------------------------------------------+
|  Riwayat Rental — Bagas Pratama                     |
|-----------------------------------------------------|
|  Alat               | Sewa     | Kembali  | Status  |
|  -------------------+----------+----------+---------|
|  Sony Alpha a7 IV   | 01/09    | 10/09    | Selesai |
|  DJI Ronin-SC       | 15/09    | -        | Disewa  |
+-----------------------------------------------------+
```