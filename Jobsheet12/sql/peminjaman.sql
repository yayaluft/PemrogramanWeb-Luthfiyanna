CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    alat_id INT NOT NULL,
    penyewa_id INT NOT NULL,
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_peminjaman_alat FOREIGN KEY (alat_id) REFERENCES alat(id) ON DELETE CASCADE,
    CONSTRAINT fk_peminjaman_penyewa FOREIGN KEY (penyewa_id) REFERENCES penyewa(id) ON DELETE CASCADE
);