document.addEventListener("DOMContentLoaded", () => {
    muatDataPenyewa();
});

async function muatDataPenyewa() {
    const tableBody = document.getElementById("tabel-body");
    if (!tableBody) return;

    try {

        await new Promise((resolve) => setTimeout(resolve, 600));

        const response = await fetch("../data/penyewa.json");
        if (!response.ok) {
            throw new Error(`Gagal mengambil data: HTTP ${response.status}`);
        }

        const dataPenyewa = await response.json();

        tableBody.innerHTML = "";

        if (dataPenyewa.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center;">Tidak ada data penyewa yang tersedia.</td></tr>`;
            return;
        }
        dataPenyewa.forEach((item) => {
            const tr = document.createElement("tr");

            const isAktif = item.status.toLowerCase().includes("aktif") || item.status.toLowerCase().includes("sewa");
            const badgeClass = isAktif ? "badge-disewa" : "badge-tersedia";

            tr.innerHTML = `
                <td>${item.id}</td>
                <td>${item.nama}</td>
                <td>${item.telepon}</td>
                <td><span class="badge-status ${badgeClass}">${item.status}</span></td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-hapus">Hapus</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

    } catch (error) {
        console.error("Error muatDataPenyewa:", error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; color: #d9534f; font-weight: bold;">
                    Gagal memuat data penyewa. Pastikan file JSON tersedia dan dijalankan lewat server lokal.
                </td>
            </tr>
        `;
    }
}