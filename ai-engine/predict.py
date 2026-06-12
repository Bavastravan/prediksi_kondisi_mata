import os
import sys
import json
import numpy as np
import cv2
import tensorflow as tf
from PIL import Image, ImageEnhance

# 1. Matikan log TensorFlow
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')

# 2. Konfigurasi Path
BASE_DIR   = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_DIR, 'model_mata_expert.h5')

# 3. Urutan kelas — HARUS SAMA PERSIS dengan urutan folder saat training (alfabet)
CLASS_NAMES = [
    'bukan_mata',
    'cataract',
    'daging_tumbuh_pterygium',
    'hordeolum_bintitan',
    'iritasi_mata',
    'mata_berdarah_hermohage',
    'mata_berkacamata',
    'normal',
]

# Kelas yang dianggap tidak valid untuk diagnosa (confidence = 0)
INVALID_CLASSES = {'bukan_mata', 'mata_berkacamata'}

CASCADE_PATH = cv2.data.haarcascades + 'haarcascade_eye.xml'


def detect_and_crop_eye(img_cv):
    gray = cv2.cvtColor(img_cv, cv2.COLOR_BGR2GRAY)
    eye_cascade = cv2.CascadeClassifier(CASCADE_PATH)
    eyes = eye_cascade.detectMultiScale(
        gray, scaleFactor=1.1, minNeighbors=3,
        minSize=(30, 30), flags=cv2.CASCADE_SCALE_IMAGE
    )
    if len(eyes) > 0:
        eyes = sorted(eyes, key=lambda e: e[2] * e[3], reverse=True)
        x, y, w, h = eyes[0]
        pad_x = int(w * 0.3)
        pad_y = int(h * 0.3)
        h_img, w_img = img_cv.shape[:2]
        x1 = max(0, x - pad_x)
        y1 = max(0, y - pad_y)
        x2 = min(w_img, x + w + pad_x)
        y2 = min(h_img, y + h + pad_y)
        return img_cv[y1:y2, x1:x2], True
    else:
        h, w = img_cv.shape[:2]
        return img_cv[int(h*0.20):int(h*0.80), int(w*0.20):int(w*0.80)], False


def enhance_image(img_cv):
    img_denoised = cv2.fastNlMeansDenoisingColored(img_cv, None, 10, 10, 7, 21)
    lab = cv2.cvtColor(img_denoised, cv2.COLOR_BGR2LAB)
    l, a, b = cv2.split(lab)
    clahe = cv2.createCLAHE(clipLimit=3.0, tileGridSize=(8, 8))
    l_enhanced = clahe.apply(l)
    img_clahe = cv2.cvtColor(cv2.merge([l_enhanced, a, b]), cv2.COLOR_LAB2BGR)
    kernel = np.array([[0,-1,0],[-1,5,-1],[0,-1,0]])
    img_sharp = cv2.filter2D(img_clahe, -1, kernel)
    return cv2.addWeighted(img_clahe, 0.7, img_sharp, 0.3, 0)


def normalize_lighting(img_cv):
    hsv = cv2.cvtColor(img_cv, cv2.COLOR_BGR2HSV)
    h, s, v = cv2.split(hsv)
    avg_brightness = np.mean(v)
    if avg_brightness > 0:
        scale = np.clip(120.0 / avg_brightness, 0.5, 2.0)
        v = np.clip(v * scale, 0, 255).astype(np.uint8)
    return cv2.cvtColor(cv2.merge([h, s, v]), cv2.COLOR_HSV2BGR)


def preprocess_for_model(img_cv):
    img_normalized         = normalize_lighting(img_cv)
    img_cropped, eye_found = detect_and_crop_eye(img_normalized)
    img_enhanced           = enhance_image(img_cropped)
    img_rgb                = cv2.cvtColor(img_enhanced, cv2.COLOR_BGR2RGB)
    pil_img                = Image.fromarray(img_rgb)
    pil_img                = ImageEnhance.Contrast(pil_img).enhance(1.3)
    pil_img                = ImageEnhance.Sharpness(pil_img).enhance(1.5)
    return pil_img.resize((224, 224), Image.LANCZOS), eye_found


def multi_crop_predict(model, img_cv):
    h, w   = img_cv.shape[:2]
    crops  = [
        img_cv[int(h*.20):int(h*.80), int(w*.20):int(w*.80)],
        img_cv[int(h*.20):int(h*.80), int(w*.10):int(w*.70)],
        img_cv[int(h*.20):int(h*.80), int(w*.30):int(w*.90)],
        img_cv[int(h*.10):int(h*.70), int(w*.20):int(w*.80)],
    ]
    scores = []
    for crop in crops:
        if crop.size == 0:
            continue
        pil = Image.fromarray(cv2.cvtColor(crop, cv2.COLOR_BGR2RGB)).resize((224, 224), Image.LANCZOS)
        arr = np.expand_dims(np.array(pil, dtype=np.float32), axis=0) / 255.0
        scores.append(model.predict(arr, verbose=0)[0])
    return np.mean(scores, axis=0) if scores else None


def predict_eye(image_path):
    if not os.path.exists(image_path):
        return json.dumps({"status": "error", "message": f"File tidak ditemukan: {image_path}"})

    try:
        model  = tf.keras.models.load_model(MODEL_PATH)
        img_cv = cv2.imread(image_path)
        if img_cv is None:
            raise Exception("Gagal membaca file gambar.")

        # Prediksi utama
        pil_main, eye_detected = preprocess_for_model(img_cv)
        arr_main  = np.expand_dims(np.array(pil_main, dtype=np.float32), axis=0) / 255.0
        pred_main = model.predict(arr_main, verbose=0)[0]

        # TTA multi-crop
        pred_tta     = multi_crop_predict(model, normalize_lighting(img_cv))
        final_scores = (0.6 * pred_main + 0.4 * pred_tta) if pred_tta is not None else pred_main

        predicted_idx   = int(np.argmax(final_scores))
        predicted_class = CLASS_NAMES[predicted_idx]
        confidence      = float(final_scores[predicted_idx]) * 100

        # Threshold confidence rendah → bukan_mata
        if confidence < 45.0:
            predicted_class = 'bukan_mata'
            message = "Gambar kurang jelas atau bukan gambar mata. Pastikan foto mata terlihat jelas."
        elif predicted_class == 'mata_berkacamata':
            message = "Terdeteksi kacamata. Lepas aksesories Anda terlebih dahulu agar proses diagnosa akurat."
        elif predicted_class == 'bukan_mata':
            message = "Gambar yang diunggah bukan gambar mata. Silakan ulangi dengan foto mata yang benar."
        else:
            message = "Analisis selesai." + ("" if eye_detected else " (Area tengah gambar digunakan.)")

        # Confidence = 0 untuk kelas tidak valid
        if predicted_class in INVALID_CLASSES:
            confidence = 0.0

        return json.dumps({
            "status":          "success",
            "prediction":      predicted_class,
            "confidence":      f"{confidence:.2f}%",
            "eye_detected":    eye_detected,
            "message":         message,
            "raw_predictions": {
                CLASS_NAMES[i]: f"{float(final_scores[i]) * 100:.2f}%"
                for i in range(len(CLASS_NAMES))
            }
        })

    except Exception as e:
        return json.dumps({"status": "error", "message": str(e)})


if __name__ == "__main__":
    if len(sys.argv) > 1:
        print(predict_eye(sys.argv[1]))
    else:
        print(json.dumps({"status": "error", "message": "Tidak ada argumen gambar."}))
        