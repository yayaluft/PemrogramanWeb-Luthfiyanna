// ===== Hamburger Menu (Nav Toggle) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi Hapus Baris Tabel =====
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td:nth-child(2)")?.textContent.trim() : "data ini";

        const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
        if (yakin && row) {
            row.remove();
        }
    });
}

// ===== Filter / Pencarian Tabel Real-Time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            // Abaikan baris notifikasi/kosong
            if (row.children.length <= 1) return;

            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Helper Tampilan Pesan Error Form =====
function tampilkanError(input, pesan) {
    hapusError(input);
    input.classList.add("input-error");
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    input.classList.remove("input-error");
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// ===== Validasi Form Tambah (Client-Side) =====
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Validasi: Kode Alat / ID Penyewa
        const kode = form.querySelector("[name='kode'], [name='id_penyewa']");
        if (kode && kode.value.trim() === "") {
            tampilkanError(kode, "Kolom kode / ID wajib diisi.");
            valid = false;
        } else if (kode) {
            hapusError(kode);
        }

        // Validasi: Nama Perangkat / Nama Penyewa
        const nama = form.querySelector("[name='nama']");
        if (nama && nama.value.trim() === "") {
            tampilkanError(nama, "Nama wajib diisi.");
            valid = false;
        } else if (nama) {
            hapusError(nama);
        }

        // Validasi: Tarif Sewa per Hari (Harus angka dan > 0)
        const tarif = form.querySelector("[name='tarif']");
        if (tarif) {
            const nilai = parseInt(tarif.value, 10);
            if (isNaN(nilai) || nilai <= 0) {
                tampilkanError(tarif, "Tarif sewa harus berupa angka lebih dari 0.");
                valid = false;
            } else {
                hapusError(tarif);
            }
        }

        // Validasi: Nomor WhatsApp / HP Penyewa (Angka, 10-14 digit)
        const telepon = form.querySelector("[name='telepon']");
        if (telepon) {
            const regexTelp = /^[0-9]{10,14}$/;
            if (!regexTelp.test(telepon.value.trim())) {
                tampilkanError(telepon, "Nomor HP harus berupa angka (10-14 digit).");
                valid = false;
            } else {
                hapusError(telepon);
            }
        }
        // Batalkan submit jika validasi klien gagal
        if (!valid) {
            e.preventDefault();
        }
    });
}

// Inisialisasi semua fungsi saat DOM siap
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});