# 👁️ EyeExpert: Sistem Asistensi Diagnosa Oftalmologi Berbasis AI

![Laravel](https://img.shields.io/badge/Laravel-12.58-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![FastAPI](https://img.shields.io/badge/FastAPI-0.110-009688?style=for-the-badge&logo=fastapi&logoColor=white)
![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-FF6F00?style=for-the-badge&logo=tensorflow&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)

EyeExpert adalah aplikasi sistem pakar dan deteksi dini patologi okular (penyakit mata) digital yang mengintegrasikan keandalan **Double Validation Pipeline**. Sistem ini memadukan kekuatan **Computer Vision (OpenCV)** untuk pemeriksaan kelayakan citra fisik dan **Deep Learning (MobileNetV2)** untuk klasifikasi penyakit, yang kemudian disinkronkan dengan **Sistem Pakar Certainty Factor** berbasis gejala klinis pada web orchestrator.

---

## 🚀 Fitur Utama Sistem

* **Double Validation Engine (`main.py`)**: 
    * *Image Quality Assessment*: Menggunakan varians Laplacian untuk memblokir foto yang buram (*blur*).
    * *Geometrical Verification*: Otomatis meloloskan citra medis **Fundus Retina** melalui transformasi *Hough Circles* dan mendeteksi fitur mata luar menggunakan *Haar Cascades*.
* **Peningkatan Citra Medis (CLAHE)**: Mengaplikasikan pengondisian kontras lokal pada saluran pencahayaan LAB untuk memperjelas visualisasi penipisan pembuluh darah dan batas struktur kepala saraf optik (*Optic Disc*).
* **Sistem Pakar Certainty Factor (`DiagnosisController`)**: Mengombinasikan probabilitas model AI visual dengan bobot klinis dari data manifestasi gejala teks (seperti fotofobia, penurunan visus akut) serta faktor risiko usia kronologis pasien.
* **Safe Medical Compliance**: Mengalihkan tebakan model yang ambigu secara otomatis (jika *Confidence* < 75% atau selisih *Gap* antar label < 30%) menjadi kesimpulan **"Diagnosa Gagal"** demi menjaga kepatuhan keselamatan interpretasi medis.
* **Antarmuka Interaktif Modern**: Form pengunggahan citra dilengkapi efek animasi *Laser Scan Overlay* fiksi ilmiah dan lembar umpan balik dinamis (berubah warna sesuai kondisi penyakit) yang informatif serta siap cetak.

---

## 🛠️ Matriks Stack Teknologi

| Komponen | Teknologi | Peran Spesifik |
| :--- | :--- | :--- |
| **Web Orchestrator** | Laravel v12.58.0 | Mengelola sesi pengguna, database rekam medis, dan jembatan transmisi biner gambar via HTTP Client. |
| **UI Framework** | Tailwind CSS | Menyusun tata letak antarmuka responsif, modern, dan ergonomis standar klinik medis. |
| **AI Gateway API** | FastAPI & Uvicorn | Menyediakan endpoint asinkron berkecepatan tinggi (`/predict`) untuk pemrosesan paralel Python. |
| **Image Processing** | OpenCV 4.13 | Bertindak sebagai penapis kualitas gambar awal dan eksekutor filter penajam kontras CLAHE. |
| **Deep Learning** | TensorFlow & Keras | Mengeksekusi ekstraksi fitur spasial non-linear menggunakan model praterlatih **MobileNetV2**. |

---

## 📦 Alur Klasifikasi Label AI
Sistem ini memetakan citra ke dalam 4 kategori keluaran utama:
1.  **Mata Normal**: Tidak ditemukan indikasi selaput kekeruhan atau perluasan cekungan saraf optik.
2.  **Katarak**: Terdeteksi penurunan transparansi cahaya/agregasi protein pada media refraksi lensa.
3.  **Glaukoma**: Terdeteksi anomali penipisan serabut saraf akibat pelebaran rasio *Cup-to-Disc* (CDR).
4.  **Bukan Mata**: Objek masukan tidak memenuhi karakteristik anatomi biologis mata manusia.

---

## 🏁 Panduan Instalasi Lokal

### 1. Kloning Repositori & Setup Laravel (Port 8000)
```bash
# Clone proyek dari GitHub
git clone [https://github.com/Bavastravan/prediksi_kondisi_mata.git](https://github.com/Bavastravan/prediksi_kondisi_mata.git)
cd prediksi_kondisi_mata

# Install dependensi PHP Composer
composer install

# Salin dan konfigurasi environment file
cp .env.example .env
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Jalankan local development server
php artisan serve