# 👁️ EyeExpert: Sistem Asistensi Diagnosa Oftalmologi Berbasis AI

![Laravel](https://img.shields.io/badge/Laravel-12.58-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![FastAPI](https://img.shields.io/badge/FastAPI-0.110-009688?style=for-the-badge&logo=fastapi&logoColor=white)
![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-FF6F00?style=for-the-badge&logo=tensorflow&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Python](https://img.shields.io/badge/Python-3.10-3776AB?style=for-the-badge&logo=python&logoColor=white)
![Model Accuracy](https://img.shields.io/badge/Akurasi%20Model-92.73%25-brightgreen?style=for-the-badge)

EyeExpert adalah aplikasi sistem pakar dan deteksi dini patologi okular (penyakit mata) digital yang mengintegrasikan keandalan **Double Validation Pipeline**. Sistem ini memadukan kekuatan **Computer Vision (OpenCV)** untuk pemeriksaan kelayakan citra fisik dan **Deep Learning (MobileNetV2)** untuk klasifikasi penyakit, yang kemudian disinkronkan dengan **Sistem Pakar Certainty Factor** berbasis gejala klinis pada web orchestrator.

---

## 🔗 Demo Sistem Online

> 👉 **[https://sikamiamik.my.id](https://sikamiamik.my.id)**

Sistem dapat diakses langsung tanpa instalasi melalui link di atas.

---

## 🚀 Fitur Utama Sistem

* **Double Validation Engine (`main.py`)**:
    * *Image Quality Assessment*: Menggunakan varians Laplacian untuk memblokir foto yang buram (*blur*).
    * *Geometrical Verification*: Otomatis meloloskan citra medis **Fundus Retina** melalui transformasi *Hough Circles* dan mendeteksi fitur mata luar menggunakan *Haar Cascades*.
* **Peningkatan Citra Medis (CLAHE)**: Mengaplikasikan pengondisian kontras lokal pada saluran pencahayaan LAB untuk memperjelas visualisasi penipisan pembuluh darah dan batas struktur kepala saraf optik (*Optic Disc*).
* **Sistem Pakar Certainty Factor (`DiagnosisController`)**: Mengombinasikan probabilitas model AI visual dengan bobot klinis dari data manifestasi gejala teks (seperti fotofobia, penurunan visus akut) serta faktor risiko usia kronologis pasien.
* **Safe Medical Compliance**: Mengalihkan tebakan model yang ambigu secara otomatis (jika *Confidence* < 75% atau selisih *Gap* antar label < 30%) menjadi kesimpulan **"Diagnosa Gagal"** demi menjaga kepatuhan keselamatan interpretasi medis.
* **Antarmuka Interaktif Modern**: Form pengunggahan citra dilengkapi efek animasi *Laser Scan Overlay* dan lembar umpan balik dinamis yang informatif serta siap cetak.

---

## 📊 Performa Model AI

| Metrik | Nilai |
| :--- | :--- |
| **Arsitektur** | MobileNetV2 (Transfer Learning) |
| **Akurasi Prediksi** | **92.73%** |
| **Total Parameter** | 2,427,848 (~9.26 MB) |
| **Input Citra** | 224 × 224 piksel |
| **Jumlah Kelas** | 6 kondisi mata |
| **Framework** | TensorFlow / Keras |

---

## 🛠️ Matriks Stack Teknologi

| Komponen | Teknologi | Peran Spesifik |
| :--- | :--- | :--- |
| **Web Orchestrator** | Laravel v12.58.0 | Mengelola sesi pengguna, database rekam medis, dan jembatan transmisi biner gambar via HTTP Client. |
| **UI Framework** | Tailwind CSS v4 | Menyusun tata letak antarmuka responsif, modern, dan ergonomis standar klinik medis. |
| **AI Gateway API** | FastAPI & Uvicorn | Menyediakan endpoint asinkron berkecepatan tinggi (`/predict`) untuk pemrosesan paralel Python. |
| **Image Processing** | OpenCV 4.13 | Bertindak sebagai penapis kualitas gambar awal dan eksekutor filter penajam kontras CLAHE. |
| **Deep Learning** | TensorFlow & Keras | Mengeksekusi ekstraksi fitur spasial non-linear menggunakan model praterlatih **MobileNetV2**. |

---

## 📦 Alur Klasifikasi Label AI

Sistem ini memetakan citra ke dalam 6 kategori keluaran:

| # | Label | Deskripsi |
| :--- | :--- | :--- |
| 1 | **Normal** | Tidak ditemukan indikasi patologi okular. |
| 2 | **Katarak** | Terdeteksi kekeruhan pada lensa mata. |
| 3 | **Eksudat / Belekan** | Terdeteksi deposit eksudat pada retina. |
| 4 | **Hordeolum (Bintitan)** | Terdeteksi infeksi kelenjar kelopak mata. |
| 5 | **Uveitis (Peradangan)** | Terdeteksi peradangan pada uvea mata. |
| 6 | **Bukan Mata** | Objek masukan tidak memenuhi karakteristik anatomi mata manusia. |

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

**Response:**
```json
{
  "class": "Katarak",
  "confidence": 92.73,
  "validation": "Citra fundus retina terdeteksi",
  "message": "Analisis selesai"
}
```

---

## 📁 Struktur Proyek

```
eye-expert-system/
├── ai-engine/
│   ├── main.py              # FastAPI app + endpoint /predict
│   ├── train.py             # Script training model
│   ├── model_mata_expert.h5 # Model terlatih (via Git LFS)
│   ├── requirements.txt     # Dependensi Python
│   └── dataset/             # Dataset gambar mata (6 kelas)
├── app/
│   └── Http/Controllers/    # Laravel Controllers
├── resources/views/         # Blade templates
├── routes/                  # Laravel routes
└── .env.example             # Template konfigurasi
```

---

## 👨‍💻 Kontribusi

Proyek ini dikembangkan sebagai sistem asistensi diagnosa oftalmologi. Kontribusi dan saran pengembangan sangat terbuka.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademis.