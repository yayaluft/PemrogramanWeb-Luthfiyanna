document.addEventListener("DOMContentLoaded", () => {
    muatDataAlat();
});

async function muatDataAlat() {
    const tableBody = document.getElementById("tabel-body");
    if (!tableBody) return;

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const response = await fetch("../data/alat.json");
        if (!response.ok) {
            throw new Error(`Gagal mengambil data: HTTP ${response.status}`);
        }

        const dataAlat = await response.json();

        tableBody.innerHTML = "";

        if (dataAlat.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center;">Tidak ada data alat yang tersedia.</td></tr>`;
            return;
        }

        dataAlat.forEach((item) => {
            const tr = document.createElement("tr");

            const badgeClass = item.status.toLowerCase() === "tersedia" ? "badge-tersedia" : "badge-disewa";
            const tarifFormat = Number(item.tarif).toLocaleString("id-ID");

            tr.innerHTML = `
                <td>${item.kode}</td>
                <td>${item.nama}</td>
                <td>${item.kategori}</td>
                <td>Rp ${tarifFormat}</td>
                <td><span class="badge-status ${badgeClass}">${item.status}</span></td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-hapus">Hapus</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

    } catch (error) {
        console.error("Error muatDataAlat:", error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; color: #d9534f; font-weight: bold;">
                    Gagal memuat data alat. Pastikan file JSON tersedia dan dijalankan lewat server lokal.
                </td>
            </tr>
        `;
    }
}