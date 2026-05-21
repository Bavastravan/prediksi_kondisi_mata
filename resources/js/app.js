import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * 🚀 PERBAIKAN SCROLL & URL CLEANUP
 * Memastikan setiap kali refresh halaman, browser kembali ke posisi paling atas
 * dan menghapus fragment hash agar tidak memicu scroll otomatis.
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mematikan fitur bawaan browser yang menyimpan posisi scroll
    if (history.scrollRestoration) {
        history.scrollRestoration = 'manual';
    }

    // 2. Paksa scroll ke titik koordinat 0,0 (paling atas)
    window.scrollTo(0, 0);

    // 3. Bersihkan URL dari hash (misal: /#edukasi menjadi /)
    if (window.location.hash) {
        // Menggunakan replaceState agar tidak memicu reload halaman
        history.replaceState(null, null, window.location.pathname);
    }
});