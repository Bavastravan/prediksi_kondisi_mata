# 👁️ EyeExpert: Sistem Asistensi Diagnosa Oftalmologi Berbasis AI

![Laravel](https://img.shields.io/badge/Laravel-12.58-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![FastAPI](https://img.shields.io/badge/FastAPI-0.110-009688?style=for-the-badge&logo=fastapi&logoColor=white)
![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-FF6F00?style=for-the-badge&logo=tensorflow&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Python](https://img.shields.io/badge/Python-3.10-3776AB?style=for-the-badge&logo=python&logoColor=white)
![Model Accuracy](https://img.shields.io/badge/Akurasi%20Model-81.61%25-brightgreen?style=for-the-badge)

EyeExpert adalah platform skrining kesehatan mata digital yang menggabungkan tiga modul pemeriksaan mandiri dalam satu sistem: **Diagnosa Citra Mata berbasis AI**, **Tes Ketajaman Mata Refraksi (Snellen & Jaeger)**, dan **Skrining Persepsi Buta Warna (Ishihara Digital)**. Seluruh hasil pemeriksaan tersimpan dalam satu **Rekam Medis Riwayat** yang dapat dicetak menjadi laporan PDF.

Modul diagnosa AI memadukan **Computer Vision (OpenCV)** untuk pemeriksaan kelayakan citra fisik dan **Deep Learning (MobileNetV2)** untuk klasifikasi penyakit, yang kemudian disinkronkan dengan **Sistem Pakar Certainty Factor** berbasis gejala klinis pada web orchestrator.

---

## 🔗 Demo Sistem Online

> 👉 **[https://sikamiamik.my.id](https://sikamiamik.my.id)**

Sistem dapat diakses langsung tanpa instalasi melalui link di atas.

---

## 🚀 Fitur Utama Sistem

### 1. Diagnosa Citra Mata (AI Engine)
* **Double Validation Engine (`main.py`)**:
    * *Image Quality Assessment*: Menggunakan varians Laplacian untuk memblokir foto yang buram (*blur*).
    * *Geometrical Verification*: Otomatis meloloskan citra medis **Fundus Retina** melalui transformasi *Hough Circles* dan mendeteksi fitur mata luar menggunakan *Haar Cascades*.
* **Peningkatan Citra Medis (CLAHE)**: Mengaplikasikan pengondisian kontras lokal pada saluran pencahayaan LAB untuk memperjelas visualisasi penipisan pembuluh darah dan batas struktur kepala saraf optik (*Optic Disc*).
* **Safe Medical Compliance**: Mengalihkan tebakan model yang ambigu secara otomatis (jika *Confidence* < 75% atau selisih *Gap* antar label < 30%) menjadi kesimpulan **"Diagnosa Gagal"** demi menjaga kepatuhan keselamatan interpretasi medis.
* **Antarmuka Interaktif Modern**: Form pengunggahan citra dilengkapi efek animasi *Laser Scan Overlay* dan lembar umpan balik dinamis yang informatif serta siap cetak.

### 2. Tes Ketajaman Mata Refraksi (Mandiri)
* **Uji Jarak Jauh (Snellen Chart)**: Skrining indikasi rabun jauh (miopia) melalui 6 tingkat ukuran karakter optotype.
* **Uji Baca Dekat (Jaeger Chart)**: Skrining indikasi presbiopia/rabun dekat melalui 6 level ukuran teks paragraf.
* Hasil tes otomatis dikonversi menjadi skor persentase (*Visual Acuity Score*) dan kesimpulan klinis indikatif.

### 3. Skrining Persepsi Buta Warna (Ishihara Digital)
* **Ishihara Advanced Draw**: Kombinasi 3 piringan berbasis angka tersembunyi dan 2 piringan *tracing* jalur berkelok pada kanvas interaktif.
* Validasi jalur dilakukan dengan menghitung akurasi titik gambar terhadap fungsi kurva target.
* Hasil dikonversi menjadi skor (0–5 benar), status persepsi warna, dan saran tindak lanjut.

### 4. Rekam Medis & Riwayat Terpadu
* **Riwayat gabungan** dari tiga modul (Diagnosa AI, Refraksi, Buta Warna) dalam satu tabel, dibedakan melalui badge warna dan kode unik (`#EXM-`, `#REF-`, `#CB-`).
* **Cetak laporan PDF** untuk masing-masing modul dengan tema warna berbeda (hijau/cyan/ungu), berisi data identitas pasien, ringkasan hasil, dan disclaimer medis — format A4 siap cetak.
* **Bulk delete** rekam medis lintas modul dengan satu kali konfirmasi.

---

## 📊 Performa Model AI (Diagnosa Citra)

| Metrik | Nilai |
| :--- | :--- |
| **Arsitektur** | MobileNetV2 (Transfer Learning + Fine-Tuning) |
| **Akurasi Validasi Terbaik** | **81.61%** (Epoch 49, Early Stopping di Epoch 64) |
| **Input Citra** | 224 × 224 piksel |
| **Jumlah Kelas** | 8 kondisi mata |
| **Framework** | TensorFlow / Keras |

> 📌 Akurasi mengalami penyesuaian setelah dataset diperluas dari 6 menjadi **8 kelas** (penambahan kategori *Pterygium*, *Iritasi Mata*, *Mata Berdarah/Hemorrhage*, dan *Mata Berkacamata*). Penurunan akurasi dari versi sebelumnya (92.73%) wajar terjadi karena kompleksitas klasifikasi bertambah — proses penambahan data dan fine-tuning lanjutan masih berjalan untuk meningkatkan presisi pada kelas-kelas baru.

---

## 🛠️ Matriks Stack Teknologi

| Komponen | Teknologi | Peran Spesifik |
| :--- | :--- | :--- |
| **Web Orchestrator** | Laravel v12.58.0 | Mengelola sesi pengguna, rekam medis (diagnosa AI, refraksi, buta warna), dan jembatan transmisi biner gambar via HTTP Client. |
| **UI Framework** | Tailwind CSS v4 | Menyusun tata letak antarmuka responsif, modern, dan ergonomis standar klinik medis. |
| **PDF Generator** | barryvdh/laravel-dompdf | Mencetak laporan hasil pemeriksaan (diagnosa AI, refraksi, buta warna) dalam format A4. |
| **AI Gateway API** | FastAPI & Uvicorn | Menyediakan endpoint asinkron berkecepatan tinggi (`/predict`) untuk pemrosesan paralel Python. |
| **Image Processing** | OpenCV 4.13 | Bertindak sebagai penapis kualitas gambar awal dan eksekutor filter penajam kontras CLAHE. |
| **Deep Learning** | TensorFlow & Keras | Mengeksekusi ekstraksi fitur spasial non-linear menggunakan model praterlatih **MobileNetV2**. |

---

## 📦 Alur Klasifikasi Label AI (Diagnosa Citra)

Sistem ini memetakan citra ke dalam **8 kategori** keluaran:

| # | Folder Dataset | Label Tampilan | Deskripsi |
| :--- | :--- | :--- | :--- |
| 1 | `normal` | Normal | Tidak ditemukan indikasi patologi okular. |
| 2 | `cataract` | Katarak | Terdeteksi kekeruhan pada lensa mata. |
| 3 | `daging_tumbuh_pterygium` | Pterygium (Daging Tumbuh) | Terdeteksi pertumbuhan jaringan abnormal pada konjungtiva/kornea. |
| 4 | `hordeolum_bintitan` | Hordeolum (Bintitan) | Terdeteksi infeksi/benjolan pada kelenjar kelopak mata. |
| 5 | `iritasi_mata` | Iritasi Mata | Terdeteksi tanda kemerahan/iritasi pada permukaan mata. |
| 6 | `mata_berdarah_hermohage` | Mata Berdarah (Hemorrhage) | Terdeteksi pendarahan subkonjungtiva pada mata. |
| 7 | `mata_berkacamata` | Mata Berkacamata | Citra mata terhalang oleh penggunaan kacamata. |
| 8 | `bukan_mata` | Bukan Mata | Objek masukan tidak memenuhi karakteristik anatomi mata manusia. |

---

## 🏁 Panduan Instalasi Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- Python 3.10
- Node.js & NPM

### 1. Clone & Setup Laravel

```bash
git clone https://github.com/Bavastravan/prediksi_kondisi_mata.git
cd prediksi_kondisi_mata

# Install dependensi PHP
composer install

# Salin dan konfigurasi environment
cp .env.example .env
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Jalankan server Laravel (port 8000)
php artisan serve
```

### 2. Setup AI Engine (FastAPI)

Buka terminal baru, lalu:

```bash
cd ai-engine

# Aktifkan virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Install dependensi Python
pip install -r requirements.txt

# Jalankan AI server (port 8001)
uvicorn main:app --reload --port 8001
```

> 💡 Folder `dataset/` tidak disertakan di repository (lihat `.gitignore`) karena hanya digunakan saat training. Model terlatih (`model_mata_expert.h5`) dan `class_indices.json` sudah tersedia di repo dan siap dipakai langsung untuk inferensi.

### 3. Akses Sistem

| Layanan | URL |
| :--- | :--- |
| Aplikasi Web (Laravel) | http://localhost:8000 |
| API Dokumentasi (Swagger) | http://localhost:8001/docs |

---

## 🔌 API Endpoint

### `POST /predict`

Menerima gambar mata dan mengembalikan hasil diagnosis AI.

**Request:**
```
Content-Type: multipart/form-data
Body: file (image/jpeg atau image/png)
```

---

## 🗂️ Rute Web Utama (Laravel)

| Rute | Method | Deskripsi |
| :--- | :--- | :--- |
| `/diagnosa` | GET / POST | Halaman & proses diagnosa citra mata via AI |
| `/refraksi` | GET | Halaman tes ketajaman mata (Snellen & Jaeger) |
| `/refraksi/store` | POST | Simpan hasil tes refraksi ke riwayat |
| `/buta-warna` | GET | Halaman skrining Ishihara Advanced Draw |
| `/buta-warna/store` | POST | Simpan hasil skrining buta warna ke riwayat |
| `/riwayat` | GET | Rekam medis gabungan (diagnosa AI, refraksi, buta warna) |
| `/riwayat/{id}/pdf` | GET | Cetak PDF hasil diagnosa AI |
| `/riwayat/refraksi/{id}/pdf` | GET | Cetak PDF hasil tes refraksi |
| `/riwayat/buta-warna/{id}/pdf` | GET | Cetak PDF hasil skrining buta warna |
| `/riwayat/destroy-bulk` | DELETE | Hapus rekam medis secara massal (lintas modul) |

---

## 📁 Struktur Proyek

```
eye-expert-system/
├── ai-engine/
│   ├── main.py                  # FastAPI app + endpoint /predict
│   ├── train.py                 # Script training model
│   ├── predict.py               # Script prediksi standalone (CLI)
│   ├── class_indices.json       # Mapping urutan label kelas hasil training
│   ├── model_mata_expert.h5     # Model terlatih
│   ├── requirements.txt         # Dependensi Python
│   └── dataset/                 # Dataset gambar mata (8 kelas) — diabaikan oleh Git
│       ├── normal/
│       ├── cataract/
│       ├── daging_tumbuh_pterygium/
│       ├── hordeolum_bintitan/
│       ├── iritasi_mata/
│       ├── mata_berdarah_hermohage/
│       ├── mata_berkacamata/
│       └── bukan_mata/
├── app/
│   ├── Http/Controllers/
│   │   ├── DiagnosisController.php
│   │   ├── RefractionTestController.php
│   │   ├── ColorBlindTestController.php
│   │   └── HistoryController.php
│   └── Models/
│       ├── Diagnosis.php
│       ├── RefractionTest.php
│       └── ColorBlindTest.php
├── resources/views/
│   ├── diagnosa.blade.php       # Form unggah citra mata
│   ├── refraksi.blade.php       # Tes ketajaman mata (Snellen & Jaeger)
│   ├── buta_warna.blade.php     # Skrining Ishihara Advanced Draw
│   ├── riwayat.blade.php        # Rekam medis gabungan
│   └── pdf/
│       ├── diagnosis_report.blade.php
│       ├── refraction_report.blade.php
│       └── colorblind_report.blade.php
├── routes/
└── .env.example
```

---

## ⚠️ Catatan Penting

Seluruh hasil pada ketiga modul (Diagnosa AI, Tes Refraksi, Skrining Buta Warna) merupakan **skrining mandiri berbasis estimasi digital** dan **tidak dapat menggantikan** pemeriksaan klinis oleh Dokter Spesialis Mata (Oftalmologis), Optometris, atau Refraksionis Optisien berlisensi. Pengguna dengan hasil indikatif disarankan melakukan pemeriksaan lanjutan di fasilitas kesehatan mata terdekat.

Model AI saat ini berada pada tahap **pengembangan berkelanjutan** — akurasi 81.61% dicapai setelah ekspansi dataset menjadi 8 kelas, dan iterasi penambahan data serta tuning hyperparameter masih terus dilakukan untuk meningkatkan presisi, khususnya pada kelas-kelas yang baru ditambahkan.

---

## 👨‍💻 Kontribusi

Proyek ini dikembangkan sebagai sistem asistensi diagnosa oftalmologi. Kontribusi dan saran pengembangan sangat terbuka.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademis.