 CREATE TABLE alat (
    id SERIAL PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tarif NUMERIC(10, 2) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Tersedia'
);

CREATE TABLE penyewa (
    id SERIAL PRIMARY KEY,
    id_penyewa VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    telepon VARCHAR(20) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Aktif Menyewa'
);