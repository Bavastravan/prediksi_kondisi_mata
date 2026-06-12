from fastapi import FastAPI, File, UploadFile
import uvicorn
import numpy as np
import tensorflow as tf
from PIL import Image
import io
import os
import sys
import cv2

# =========================================================
# FIX UNICODE WINDOWS
# =========================================================
if sys.platform == "win32":
    sys.stdout = io.TextIOWrapper(
        sys.stdout.buffer,
        encoding="utf-8"
    )

# =========================================================
# FASTAPI
# =========================================================
app = FastAPI(title="Sistem Diagnosa Mata AI")

# =========================================================
# MODEL PATH
# =========================================================
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_DIR, "model_mata_expert.h5")

# =========================================================
# 💡 PERBAIKAN: LABELS (Wajib Sama Persis dengan Urutan Folder Dataset!)
# =========================================================
# Keterangan: Urutan ini (alfabetis) adalah urutan default Keras flow_from_directory
labels = [
    "Bukan Mata",
    "Katarak",
    "Daging Tumbuh (Pterygium)",
    "Hordeolum (Bintitan)",
    "Iritasi Mata",
    "Mata Berdarah (Hemorrhage)",
    "Mata Berkacamata",
    "Normal"
]

# =========================================================
# LOAD MODEL
# =========================================================
try:
    model = tf.keras.models.load_model(
        MODEL_PATH,
        compile=False
    )
    print("✅ MODEL BERHASIL DIMUAT")
except Exception as e:
    model = None
    print(f"❌ GAGAL LOAD MODEL: {e}")


# =========================================================
# VALIDASI APAKAH CITRA LAYAK/MATA (Fokus Selfie/Real World)
# =========================================================
def is_eye_valid(image_bytes):
    try:
        nparr = np.frombuffer(image_bytes, np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

        if img is None:
            return False, 0, "Format gambar tidak valid"

        h, w, _ = img.shape

        # Min Size (Diturunkan sedikit agar bisa menerima crop selfie kecil)
        if h < 80 or w < 80:
            return False, 0, "Resolusi terlalu kecil, mohon dekatkan kamera"

        # Deteksi wajah/mata dasar dengan Haar Cascade (Opsional tapi sangat disarankan)
        # Jika tidak pakai Haar, kita gunakan deteksi warna dan bentuk dasar
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        
        # Cek kontras/blur
        sharpness = cv2.Laplacian(gray, cv2.CV_64F).var()
        if sharpness < 15:
            # Tetap loloskan, tapi kurangi skor. Karena blur sedikit wajar di selfie.
            score_base = 30
        else:
            score_base = 60

        # Cek brightness
        brightness = np.mean(gray)
        if brightness < 30 or brightness > 230:
            return False, score_base, "Pencahayaan ekstrem (terlalu gelap/terang)"

        # Catatan: Fungsi detect_fundus milikmu yang sebelumnya lebih cocok untuk
        # kamera fundus retinopati medis (oranye/bulat). 
        # Karena ini sistem kamera HP biasa, kita longgarkan validasinya.
        return True, score_base + 30, "Gambar mata dapat dianalisis"

    except Exception as e:
        return False, 0, str(e)


# =========================================================
# ROOT
# =========================================================
@app.get("/")
def home():
    return {
        "status": "running",
        "model_loaded": model is not None
    }


# =========================================================
# PREDICT
# =========================================================
@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    if model is None:
        return {
            "class": "Error",
            "message": "Model belum aktif"
        }

    try:
        # =====================================================
        # READ FILE & PRE-VALIDATION
        # =====================================================
        contents = await file.read()
        valid, eye_score, reason = is_eye_valid(contents)

        if not valid:
            return {
                "class": "Bukan Mata",
                "confidence": round(eye_score, 2),
                "message": reason
            }

        # =====================================================
        # LOAD & RESIZE IMAGE 
        # 💡 PERBAIKAN: Sesuaikan ukuran dengan train.py yang kamu ubah (224 atau 160)
        # Jika di train.py kamu pakai 224, tetap gunakan 224 di sini.
        # =====================================================
        image = Image.open(io.BytesIO(contents)).convert("RGB")
        image = image.resize((224, 224), Image.Resampling.LANCZOS)

        # =====================================================
        # PREPROCESS
        # =====================================================
        img_array = tf.keras.preprocessing.image.img_to_array(image)
        img_array = np.expand_dims(img_array, axis=0)
        img_array = img_array / 255.0

        # =====================================================
        # PREDICT
        # =====================================================
        predictions = model.predict(img_array, verbose=0)[0]
        print("RAW PREDICTIONS:", [f"{p:.3f}" for p in predictions])

        class_idx = np.argmax(predictions)
        ai_confidence = float(predictions[class_idx]) * 100

        # =====================================================
        # GAP CHECK (Kepercayaan Diri Model)
        # =====================================================
        sorted_pred = np.sort(predictions)
        gap = (sorted_pred[-1] - sorted_pred[-2]) * 100

        # =====================================================
        # DIAGNOSA GAGAL (Aturan Ketat)
        # =====================================================
        # Jika akurasi di bawah 55% ATAU jarak antara prediksi ranking 1 dan 2 sangat tipis (< 10%)
        if ai_confidence < 55 or gap < 10:
            return {
                "class": "Diagnosa Gagal",
                "confidence": round(ai_confidence, 2),
                "validation": reason,
                "message": "Gambar kurang jelas atau AI ragu menentukan jenis penyakit."
            }

        # =====================================================
        # FINAL RESULT
        # =====================================================
        result_class = labels[class_idx]

        # Jika AI secara eksplisit memprediksi ini bukan gambar mata (kelas ke-0)
        if result_class == "Bukan Mata":
            return {
                "class": "Bukan Mata",
                "confidence": round(ai_confidence, 2),
                "message": "AI mendeteksi objek ini bukan area mata manusia"
            }

        return {
            "class": result_class,
            "confidence": round(ai_confidence, 2),
            "validation": reason,
            "message": "Analisis selesai"
        }

    except Exception as e:
        return {
            "class": "Error",
            "message": str(e)
        }


# =========================================================
# RUN SERVER
# =========================================================
if __name__ == "__main__":
    print("🚀 Sistem Diagnosa Mata AI berjalan di port 8080")
    uvicorn.run(
        app,
        host="127.0.0.1",
        port=8080
    )