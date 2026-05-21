import os
import sys
import json
import numpy as np
import tensorflow as tf
from tensorflow.keras.preprocessing import image

# 1. Matikan log peringatan TensorFlow agar output JSON murni bersih
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')

# 2. Konfigurasi Jalur File
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_DIR, 'model_mata_expert.h5')

# 3. Urutan kelas harus sama persis dengan urutan folder saat training
CLASS_NAMES = [
    'bukan_mata',
    'cataract',
    'eksudat_belekan',
    'hordeolum_bintitan',
    'normal',
    'uveitis_peradangan'
]

def predict_eye(image_path):
    if not os.path.exists(image_path):
        return json.dumps({"status": "error", "message": f"File gambar tidak ditemukan di: {image_path}"})

    try:
        # Load model pintar .h5
        model = tf.keras.models.load_model(MODEL_PATH)

        # Proses gambar agar sesuai standar MobileNetV2 (224x224)
        img = image.load_img(image_path, target_size=(224, 224))
        img_array = image.img_to_array(img)
        img_array = np.expand_dims(img_array, axis=0)
        
        # 💡 PERBAIKAN PREPROCESSING: Fungsi normalisasi MobileNetV2 yang valid (-1 s/d 1)
        img_array = tf.keras.applications.mobilenet_v2.preprocess_input(img_array)

        # Lakukan prediksi murni
        predictions = model.predict(img_array, verbose=0)
        
        # 💡 CRITICAL FIX: Hapus baris 'tf.nn.softmax' karena predictions[0] sudah berupa hasil activation softmax!
        raw_scores = predictions[0]
        
        # Ambil hasil dengan persentase tertinggi
        predicted_class_idx = np.argmax(raw_scores)
        predicted_class = CLASS_NAMES[predicted_class_idx]
        confidence = float(raw_scores[predicted_class_idx]) * 100

        # Output JSON untuk dikonsumsi Laravel
        result = {
            "status": "success",
            "prediction": predicted_class,
            "confidence": f"{confidence:.2f}%",
            "raw_predictions": {CLASS_NAMES[i]: f"{float(raw_scores[i])*100:.2f}%" for i in range(len(CLASS_NAMES))}
        }
        return json.dumps(result)

    except Exception as e:
        return json.dumps({"status": "error", "message": str(e)})

if __name__ == "__main__":
    # Menerima argumen jalur gambar dari Laravel lewat terminal
    if len(sys.argv) > 1:
        img_path_arg = sys.argv[1]
        print(predict_eye(img_path_arg))
    else:
        print(json.dumps({"status": "error", "message": "Tidak ada argumen gambar yang diberikan."}))