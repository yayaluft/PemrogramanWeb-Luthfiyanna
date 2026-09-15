document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});

// 1. Hamburger menu (Mendukung Bootstrap Collapse lewat JS)
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const navMenu = document.getElementById("navMenu");

    if (!toggleBtn || !navMenu) return;

    const bsCollapse = new bootstrap.Collapse(navMenu, {
        toggle: false
    });

    toggleBtn.addEventListener("click", function () {
        bsCollapse.toggle();
    });
}

// 2. Konfirmasi hapus (Front-end baris tabel) 
function initHapusConfirm() {
    const deleteButtons = document.querySelectorAll(".btn-hapus, .btn-danger");

    deleteButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            if (!row) return;

            const itemText = row.cells[0]?.textContent.trim() || "data ini";
            const yakin = confirm(`Yakin ingin menghapus "${itemText}"?`);

            if (yakin) {
                row.remove();
            }
        });
    });
}

// 3. Filter/pencarian tabel real-time
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase().trim();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(keyword) ? "" : "none";
        });
    });
}

// 4. Validasi form inline (Sisi Klien)
function tampilkanError(input, pesan) {
    hapusError(input);
    input.classList.add("is-invalid");

    const span = document.createElement("span");
    span.className = "error text-danger d-block mt-1 small";
    span.textContent = pesan;

    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    input.classList.remove("is-invalid");
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.querySelector("form");
    if (!form) return;

    form.setAttribute("novalidate", "true");

    form.addEventListener("submit", function (e) {
        let valid = true;

        const namaField = form.querySelector("[name='judul'], [name='nama']");
        if (namaField && namaField.value.trim() === "") {
            tampilkanError(namaField, "Field ini wajib diisi.");
            valid = false;
        } else if (namaField) {
            hapusError(namaField);
        }

        const secondaryField = form.querySelector("[name='pengarang'], [name='no_anggota']");
        if (secondaryField && secondaryField.value.trim() === "") {
            tampilkanError(secondaryField, "Field ini wajib diisi.");
            valid = false;
        } else if (secondaryField) {
            hapusError(secondaryField);
        }

        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (stok.value.trim() === "" || isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif atau kosong.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}