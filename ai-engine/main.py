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
# LABELS
# =========================================================
labels = [
    "Bukan Mata",
    "Katarak",
    "Glaukoma",
    "Mata Normal"
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
# ANALISIS KUALITAS
# =========================================================
def analyze_image_quality(img):

    gray = cv2.cvtColor(
        img,
        cv2.COLOR_BGR2GRAY
    )

    # =====================================================
    # SHARPNESS
    # =====================================================
    sharpness = cv2.Laplacian(
        gray,
        cv2.CV_64F
    ).var()

    # =====================================================
    # BRIGHTNESS
    # =====================================================
    brightness = np.mean(gray)

    # =====================================================
    # COLOR VARIATION
    # =====================================================
    color_std = np.std(img)

    # =====================================================
    # EDGE DENSITY
    # =====================================================
    edges = cv2.Canny(
        gray,
        80,
        180
    )

    edge_pct = (
        cv2.countNonZero(edges)
        / (gray.shape[0] * gray.shape[1])
    ) * 100

    return {
        "sharpness": sharpness,
        "brightness": brightness,
        "color_std": color_std,
        "edge_pct": edge_pct
    }

# =========================================================
# DETEKSI FUNDUS RETINA
# =========================================================
def detect_fundus(img):

    gray = cv2.cvtColor(
        img,
        cv2.COLOR_BGR2GRAY
    )

    h, w = gray.shape

    # =====================================================
    # BLUR
    # =====================================================
    blur = cv2.GaussianBlur(
        gray,
        (9, 9),
        2
    )

    # =====================================================
    # HOUGH CIRCLE
    # =====================================================
    circles = cv2.HoughCircles(
        blur,
        cv2.HOUGH_GRADIENT,
        dp=1.2,
        minDist=100,
        param1=50,
        param2=28,
        minRadius=min(h, w) // 4,
        maxRadius=min(h, w) // 2
    )

    # =====================================================
    # CEK CORNER GELAP
    # =====================================================
    corners = [
        gray[0:25, 0:25],
        gray[0:25, w-25:w],
        gray[h-25:h, 0:25],
        gray[h-25:h, w-25:w]
    ]

    dark_score = 0

    for c in corners:

        if np.mean(c) < 50:
            dark_score += 1

    dark_corner = dark_score >= 3

    # =====================================================
    # SCORE FUNDUS
    # =====================================================
    score = 0

    if circles is not None:
        score += 50

    if dark_corner:
        score += 30

    # =====================================================
    # CEK DOMINASI WARNA ORANYE RETINA
    # =====================================================
    hsv = cv2.cvtColor(
        img,
        cv2.COLOR_BGR2HSV
    )

    lower = np.array([5, 40, 40])
    upper = np.array([35, 255, 255])

    mask = cv2.inRange(
        hsv,
        lower,
        upper
    )

    orange_pct = (
        cv2.countNonZero(mask)
        / (h * w)
    ) * 100

    if orange_pct > 15:
        score += 20

    return score

# =========================================================
# VALIDASI APAKAH FUNDUS
# =========================================================
def is_eye_valid(image_bytes):

    try:

        nparr = np.frombuffer(
            image_bytes,
            np.uint8
        )

        img = cv2.imdecode(
            nparr,
            cv2.IMREAD_COLOR
        )

        if img is None:
            return False, 0, "Gambar tidak valid"

        h, w, _ = img.shape

        # =====================================================
        # MIN SIZE
        # =====================================================
        if h < 100 or w < 100:
            return False, 0, "Resolusi terlalu kecil"

        # =====================================================
        # QUALITY
        # =====================================================
        quality = analyze_image_quality(img)

        sharpness = quality["sharpness"]
        brightness = quality["brightness"]
        color_std = quality["color_std"]
        edge_pct = quality["edge_pct"]

        # =====================================================
        # HITUNG SKOR
        # =====================================================
        score = 0

        # SHARPNESS
        if sharpness > 20:
            score += 25
        elif sharpness > 10:
            score += 15

        # BRIGHTNESS
        if 40 < brightness < 220:
            score += 20

        # COLOR
        if color_std > 20:
            score += 20
        elif color_std > 10:
            score += 10

        # EDGE
        if edge_pct > 2:
            score += 15

        # =====================================================
        # DETEKSI FUNDUS
        # =====================================================
        fundus_score = detect_fundus(img)

        score += fundus_score

        # =====================================================
        # LIMIT MAX
        # =====================================================
        if score > 100:
            score = 100

        # =====================================================
        # VALIDASI
        # =====================================================
        if score >= 60:

            return True, score, "Citra fundus retina terdeteksi"

        return False, score, "Bukan citra fundus retina"

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
        # READ FILE
        # =====================================================
        contents = await file.read()

        # =====================================================
        # VALIDASI
        # =====================================================
        valid, eye_score, reason = is_eye_valid(contents)

        if not valid:

            return {
                "class": "Bukan Mata",
                "confidence": round(eye_score, 2),
                "message": reason
            }

        # =====================================================
        # LOAD IMAGE
        # =====================================================
        image = Image.open(
            io.BytesIO(contents)
        ).convert("RGB")

        image = image.resize(
            (224, 224),
            Image.Resampling.LANCZOS
        )

        # =====================================================
        # PREPROCESS
        # =====================================================
        img_array = tf.keras.preprocessing.image.img_to_array(image)

        img_array = np.expand_dims(
            img_array,
            axis=0
        )

        img_array = img_array / 255.0

        # =====================================================
        # PREDICT
        # =====================================================
        predictions = model.predict(
            img_array,
            verbose=0
        )[0]

        print("RAW PREDICTIONS:", predictions)

        class_idx = np.argmax(predictions)

        ai_confidence = float(
            predictions[class_idx]
        ) * 100

        # =====================================================
        # GAP CHECK
        # =====================================================
        sorted_pred = np.sort(predictions)

        gap = (
            sorted_pred[-1]
            - sorted_pred[-2]
        ) * 100

        # =====================================================
        # FINAL CONFIDENCE
        # =====================================================
        # ===================================================== 
        final_confidence = ai_confidence

        # =====================================================
        # DIAGNOSA GAGAL
        # =====================================================
        if ai_confidence < 75 or gap < 20:

            return {
                "class": "Diagnosa Gagal",
               "confidence": round(final_confidence, 2),
                "validation": reason,
                "message": "AI gagal mengenali penyakit mata secara meyakinkan"
            }

        # =====================================================
        # RESULT
        # =====================================================
        result_class = labels[class_idx]

        # =====================================================
        # FILTER BUKAN MATA
        # =====================================================
        if result_class == "Bukan Mata":

            return {
                "class": "Bukan Mata",
                "confidence": round(final_confidence, 2),
                "message": "Objek bukan fundus retina"
            }

        # =====================================================
        # FINAL RESULT
        # =====================================================
        return {
            "class": result_class,
            "confidence": round(final_confidence, 2),
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