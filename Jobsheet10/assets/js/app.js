// ===== Hamburger Menu (Nav Toggle) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi Hapus =====
// Delete tetap dikirim menggunakan method POST melalui form.
// JavaScript hanya meminta konfirmasi sebelum request dikirim.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target.closest(".form-hapus");
        if (!form) return;

        const row = form.closest("tr");
        const nama = row
            ? row.querySelector("td:nth-child(2)")?.textContent.trim()
            : "data ini";

        const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// ===== Pencarian Client-Side Lama =====
// Pencarian sekarang dilakukan server-side pada list.php,
// sehingga fungsi filter tabel lama tidak digunakan lagi.

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

// ===== Validasi Form Tambah dan Edit =====
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const kode = form.querySelector("[name='kode'], [name='id_penyewa']");
        if (kode && kode.value.trim() === "") {
            tampilkanError(kode, "Kolom kode / ID wajib diisi.");
            valid = false;
        } else if (kode) {
            hapusError(kode);
        }

        const nama = form.querySelector("[name='nama']");
        if (nama && nama.value.trim() === "") {
            tampilkanError(nama, "Nama wajib diisi.");
            valid = false;
        } else if (nama) {
            hapusError(nama);
        }

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

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initValidasiForm();
});
